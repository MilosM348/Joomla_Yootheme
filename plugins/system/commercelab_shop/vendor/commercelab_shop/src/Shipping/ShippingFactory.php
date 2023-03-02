<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Shipping;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Cart\CartItem;
use CommerceLabShop\Tax\TaxFactory;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Address\Address;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Language\LanguageFactory;

use Brick\Money\Exception\UnknownCurrencyException;
use Exception;


class ShippingFactory
{

	/**
	 * @param   Cart  $cart
	 *
	 * @return int
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	public static function getShipping(Cart $cart): int
	{
		PluginHelper::importPlugin('commercelab_shop_shipping');

		if ($cart->shipping_type)
		{
			$shippingType = $cart->shipping_type;
		}
		else
		{
			$shippingType = "defaultshipping";
		}

		$shippingTotal = Factory::getApplication()->triggerEvent('onCalculateShipping' . $shippingType, array('cart' => $cart));
		if ($shippingTotal)
		{
			return (int) $shippingTotal[0];
		}

		return 0;

	}

	public static function getShippingWithoutTax(int $shipping_total): int
	{
		$shipping_taxrate = ComponentHelper::getParams('com_commercelab_shop')->get('shipping_tax_class', 0);

		return TaxFactory::getNetPrice($shipping_total, $shipping_taxrate);
	}

	public static function getShippingWithTax(int $shipping_total): int
	{
		
		$shipping_taxrate = ComponentHelper::getParams('com_commercelab_shop')->get('shipping_tax_class', 0);

		return TaxFactory::getBrutPrice($shipping_total, $shipping_taxrate);
	}


	/**
	 * @param   Cart  $cart
	 *
	 *
	 * @return string
	 * @throws UnknownCurrencyExceptionf
	 * @since 2.0
	 */


	public static function getShippingFormatted(Cart $cart): string
	{
		if (UserFactory::getActiveUser()->guest)
		{
			$cart_addresses = CartFactory::getAssignedAddresses();
			if (!is_null($cart_addresses) && !is_null($cart_addresses->shipping_address_id))
			{
				$totalShipping = CurrencyFactory::translate($cart->totalShipping);
			}
			else
			{
				LanguageFactory::load();
				$totalShipping = Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_SELECT_SHIPPING_ADDRESS');
			}


		}
		else
		{
			$totalShipping = CurrencyFactory::translate($cart->totalShipping);
		}

		return $totalShipping;
	}


	/**
	 *
	 * This function calculates the total shipping for an order.
	 *
	 * @param   Cart  $cart
	 *
	 * @return int
	 *
	 * @since 2.0
	 */


	public static function calculateTotalShipping(Cart $cart): int
	{
		$cartitems = $cart->cartItems;

		$total = 0;

		if ($cartitems)
		{
			/* @var CartItem $item */
			foreach ($cartitems as $item)
			{
				$itemShipping = self::getItemFlatShipping($item);
				// multiply the item shipping by the count
				$total += $itemShipping * $item->amount;
			}
		}

		// get the total weight of the "weight" activated items.
		// then get the shipping total for that combined weight
		// then add it to the $total from above.
		$weight = 0;
		if ($cartitems)
		{
			foreach ($cartitems as $item)
			{
				$itemWeight = self::getItemWeight($item);

				// multiply the item weight by the count
				$weight += $itemWeight * $item->amount;

			}
		}

		// $weight now has the total of the cart weight for items that calculate shipping based on their weight.
		$weightTotal = 0;
		if ($weight > 0)
		{
			$weightTotal = self::getWeightShippingTotal($weight);
		}

		return $total + $weightTotal;
	}


	/**
	 *
	 * This function returns the shipping total for a single item
	 *
	 * @param   CartItem  $cartitem
	 *
	 * @return int
	 *
	 * @since 2.0
	 */

	public static function getItemFlatShipping(CartItem $cartitem): int
	{

		$product = ProductFactory::get($cartitem->joomla_item_id);

		if ($product->shipping_mode == 'flat')
		{
			return (int)$product->flatfee;
		}
		else
		{
			return 0;
		}


	}


	/**
	 * @param   CartItem  $cartitem
	 *
	 * @return int
	 *
	 * @since 2.0
	 */


	public static function getItemWeight(CartItem $cartitem): int
	{

		$product = ProductFactory::get($cartitem->joomla_item_id);

		if ($product->shipping_mode == 'weight')
		{
			// return the weight for the item
			return $product->weight;
		}

		return 0;

	}

	/**
	 *
	 * Takes a weight value and calculates the shipping cost (int) based on the current shipping address
	 *
	 * example: Send in the total weight of the cart (i.e. the products with weight enabled) and get the shipping total back
	 *
	 * @param $weight
	 *
	 * @return int
	 *
	 * @since 2.0
	 */


	public static function getWeightShippingTotal($weight): int
	{


		// now get the customers selected shipping address
		if ($address = AddressFactory::getCurrentShippingAddress())
		{

			$db = Factory::getDbo();

			// check if we need to ship to a zone first
			$db->setQuery('SELECT * from ' . $db->quoteName('#__commercelab_shop_zone_shipping_rate') . ' where ' . $weight . ' between `weight_from` and `weight_to` AND `zone_id` = ' . $address->zone . ' AND `published` = 1;');

			$zoneResult = $db->loadObject();

			//if so, return that shipping value
			if ($zoneResult)
			{
				return $zoneResult->cost + $zoneResult->handling_cost;
			}
			else
			{

				// so, if no zone shipping is found, try to apply some country level shipping
				$db->setQuery('SELECT * from ' . $db->quoteName('#__commercelab_shop_shipping_rate') . ' where ' . $weight . ' between `weight_from` and `weight_to` AND `country_id` = ' . $address->country . ' AND `published` = 1;');

				$countryResult = $db->loadObject();

				if ($countryResult)
				{
					return $countryResult->cost + $countryResult->handling_cost;
				}
				else
				{
					//if no zone shipping or country shipping
					return 0;
				}
			}


		}

		// just return zero if nothing happens.
		return 0;

	}


}
