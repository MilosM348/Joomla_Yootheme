<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Tax;
// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

use CommerceLabShop\Address\Address;
use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Shipping\Shipping;

use Brick\Money\Money;
use Brick\Money\Context\CashContext;
use Brick\Math\RoundingMode;

class Tax
{

	private $db;

	public function __construct($id)
	{
		$this->db = Factory::getDbo();


	}


	public static function calculateTotalTax(Cart $cart)
	{



		$cartitems = $cart->cartItems;

		$totalTaxableValue = 0;

		foreach ($cartitems as $item)
		{
			$totalTaxableValue += self::getItemTaxableValue($item);

		}

//		if ($config->get('add_tax_to_shipping'))
//		{
//			$totalTaxableValue += Shipping::getTotalShippingFromPlugin();
//		}

		$total = self::getTotalTax($cart, $totalTaxableValue);

		//now convert to integer
		// currency doesn't matter at this point... we just need the int
		$amount = Money::ofMinor($total, 'EUR', new CashContext(1), RoundingMode::DOWN);
		$amount = $amount->getMinorAmount()->toInt();


		return $amount;

	}

	public static function getItemTaxableValue($cartitem)
	{

		return $cartitem->bought_at_price;

	}


	public static function getItemTax($cartitem)
	{

		$product = new Product($cartitem->joomla_item_id);
		$price   = $cartitem->bought_at_price / 100;

		// if ($product->taxable == 0)
		// {
		// 	return 0;
		// }

		if ($selectedShippingAddress = Address::getAssignedShippingAddressID())
		{

			$db = Factory::getDbo();

			// get the full address using the class
			$address = new Address($selectedShippingAddress);


			// first get zone tax rate
			$query = $db->getQuery(true);

			$query->select('taxrate');
			$query->from($db->quoteName('#__commercelab_shop_zone'));
			$query->where($db->quoteName('id') . ' = ' . $db->quote($address->zone_id));

			$db->setQuery($query);

			$zoneTaxrate = $db->loadResult();

			if ($zoneTaxrate)
			{
				// if we have a zone tax rate... return the added tax
				return Utilities::getPercentOfNumber($price, $zoneTaxrate);
			}
			else
			{

				// there is no zone tax rate... perhaps there is a country level tax rate.
				// get country tax rate
				$query = $db->getQuery(true);

				$query->select('taxrate');
				$query->from($db->quoteName('#__commercelab_shop_country'));
				$query->where($db->quoteName('id') . ' = ' . $db->quote($address->country_id));

				$db->setQuery($query);

				$countryTaxrate = $db->loadResult();

				if ($countryTaxrate)
				{

					// if there is a country tax rate, return the added tax
					return Utilities::getPercentOfNumber($price, $countryTaxrate);
				}

			}

			// or you know... whatever....
			return 0;


		}

	}


	public static function getTotalTax(Cart $cart, $total)
	{

//
		// if ($selectedShippingAddress = Address::getAssignedShippingAddressID($cart))
		// {

		// 	$db = Factory::getDbo();

		// 	// get the full address using the class
		// 	$address = new Address($selectedShippingAddress);


		// 	// first get zone tax rate
		// 	$query = $db->getQuery(true);

		// 	$query->select('taxrate');
		// 	$query->from($db->quoteName('#__commercelab_shop_zone'));
		// 	$query->where($db->quoteName('id') . ' = ' . $db->quote($address->zone_id));

		// 	$db->setQuery($query);

		// 	$zoneTaxrate = $db->loadResult();

		// 	if ($zoneTaxrate)
		// 	{
		// 		// if we have a zone tax rate... return the added tax
		// 		return Utilities::getPercentOfNumber($total, $zoneTaxrate);
		// 	}
		// 	else
		// 	{

		// 		// there is no zone tax rate... perhaps there is a country level tax rate.
		// 		// get country tax rate
		// 		$query = $db->getQuery(true);

		// 		$query->select('taxrate');
		// 		$query->from($db->quoteName('#__commercelab_shop_country'));
		// 		$query->where($db->quoteName('id') . ' = ' . $db->quote($address->country_id));

		// 		$db->setQuery($query);

		// 		$countryTaxrate = $db->loadResult();

		// 		if ($countryTaxrate)
		// 		{

		// 			// if there is a country tax rate, return the added tax
		// 			return Utilities::getPercentOfNumber($total, $countryTaxrate);
		// 		}

		// 	}

			// or you know... whatever....
			return 0;


		// }
//		else
//		{
//			return 0;
//		}
		return 0;
	}
}
