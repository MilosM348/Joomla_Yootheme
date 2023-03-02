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
use CommerceLabShop\Cart\Cart;
use Joomla\CMS\Plugin\PluginHelper;
use CommerceLabShop\Address\Address;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Currency\Currency;
use phpDocumentor\Reflection\Types\Integer;
use CommerceLabShop\Currency\CurrencyFactory;


class Shipping
{

	public $db;
	public $app;
	private $cookie_id;

	public function __construct()
	{
		$this->db        = Factory::getDbo();
		$this->app       = Factory::getApplication();
		$this->cookie_id = $this->app->input->cookie->get('yps-cart', null);
	}

	/**
	 *
	 * This function calculates the total shipping for an order.
	 *
	 * @param   false  $integer
	 * @param   false  $float
	 *
	 * @return int|mixed|string|string[]|null
	 */


	public static function calculateTotalShipping()
	{


		$cart      = CartFactory::get();
		$cartitems = $cart->cartItems;


		$total = 0;

		foreach ($cartitems as $item)
		{
			$total += self::getItemFlatShipping($item);
		}
//        return $total;

		// get the total weight of the "weight" activated items.
		// then get the shipping total for that combined weight
		// then add it to the $total from above.
		$weight = 0;
		foreach ($cartitems as $item)
		{
			$weight += self::getItemWeight($item);
		}
//        return $weight;
		// $weight now has the total of the cart weight for items that calculate shipping based on their weight.
		$weightTotal = 0;
		if ($weight > 0)
		{
			$weightTotal = self::getWeightTotal($weight);
		}

//        return $weightTotal;

		return $total + $weightTotal;


	}


	public static function getWeightTotal($weight)
	{


		// now get the customers selected shipping address
		if ($selectedShippingAddress = Address::getAssignedShippingAddressID())
		{

			// get the full address using the class
			$address = new Address($selectedShippingAddress);

			$db = Factory::getDbo();

			// check if we need to ship to a zone first
			$db->setQuery('SELECT * from ' . $db->quoteName('#__commercelab_shop_zone_shipping_rate') . ' where ' . $weight . ' between `weight_from` and `weight_to` AND `zone_id` = ' . $address->zone_id . ' AND `published` = 1;');

			$zoneResult = $db->loadObject();

			//if so, return that shipping value
			if ($zoneResult)
			{
				return $zoneResult->cost + $zoneResult->handling_cost;
			}
			else
			{

				// so, if no zone shipping is found, try to apply some country level shipping
				$db->setQuery('SELECT * from ' . $db->quoteName('#__commercelab_shop_shipping_rate') . ' where ' . $weight . ' between `weight_from` and `weight_to` AND `country_id` = ' . $address->country_id . ' AND `published` = 1;');

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

			// just return zero if nothing happens.
			return 0;

		}

	}

	public static function getItemWeight($cartitem)
	{
		$product = new Product($cartitem->joomla_item_id);

		if ($product->shipping_mode == 'weight')
		{
			// return the weight for all of the items of this type in the cart, by multiplying by the count
			return $product->weight * $cartitem->count;
		}

	}


	/**
	 *
	 * This function returns the shipping total for a single item
	 *
	 * @param $cartitem
	 *
	 * @return int
	 *
	 * @since 1.0
	 */

	public static function getItemFlatShipping($cartitem)
	{

		$product = new Product($cartitem->joomla_item_id);

		if ($product->shipping_mode == 'flat')
		{
			// return the flatfees for all of the items of this type in the cart, by multiplying by the count
			return $product->flatfee * $cartitem->count;
		}


	}

	public static function calculateMostExpensiveItemShipping()
	{


		$cart      = CartFactory::get();
		$cartitems = $cart->cartItems;

		$values = array();

		foreach ($cartitems as $item)
		{
			$values[] = self::getItemShipping($item);
		}

		rsort($values);

		$total = $values[0];

		return $total;


	}


	public static function getPrioritisedShipping()
	{

		$availableShipping = PluginHelper::getPlugin('commercelab_shop_shipping');

		return $availableShipping[0];

	}


	public static function getTotalShippingFromPlugin(Cart $cart)
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

		$shippingTotal = Factory::getApplication()->triggerEvent('onCalculateShipping' . $shippingType, [$cart]);
		if ($shippingTotal)
		{
			return $shippingTotal[0];
		}

		return 0;

	}

	/**
	 * @param $currency
	 *
	 *
	 * @return string
	 * @since 1.5
	 */


	public static function calculateTotalShippingForCart(Cart $cart, $currency)
	{
		if (UserFactory::getActiveUser()->guest)
		{
			$cart_addresses = CartFactory::getAssignedAddresses();
			if (!is_null($cart_addresses) 
				&& !is_null($cart_addresses->shipping_address_id))
			{
				$totalShipping = CurrencyFactory::translate(Shipping::getTotalShippingFromPlugin($cart), $currency);
			}
			else
			{
				Factory::getLanguage()->load('com_commercelab_shop', JPATH_ADMINISTRATOR);
				$totalShipping = Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_SELECT_SHIPPING_ADDRESS');
			}
		}
		else
		{
			$totalShipping = CurrencyFactory::translate(Shipping::getTotalShippingFromPlugin($cart), $currency);
		}

		return $totalShipping;
	}


}
