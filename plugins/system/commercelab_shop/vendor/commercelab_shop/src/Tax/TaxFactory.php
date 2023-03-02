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
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Cart\CartItem;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Shipping\ShippingFactory;

use Brick\Money\Exception\UnknownCurrencyException;

use Exception;

class TaxFactory
{

    private function __construct() {
		PluginHelper::importPlugin('commercelab_shop_taxes');
    }

	public static function getTaxPlugin(): string
	{
		return ComponentHelper::getParams('com_commercelab_shop')->get('tax_plugin', 'Coresystemtaxes');
	}

	public static function getDefaultCountryTaxRate(): float
	{
		PluginHelper::importPlugin('commercelab_shop_taxes');

		$default_country_rate = Factory::getApplication()->triggerEvent('onGetDefaultCountryTaxRate' . TaxFactory::getTaxPlugin(), []);
		return $default_country_rate[0];
	}

	// public static function getAplicableTaxRate($taxclass): float
	// {
	// 	PluginHelper::importPlugin('commercelab_shop_taxes');

	// 	$default_country_rate = Factory::getApplication()->triggerEvent('onGetApplicableTaxRate' . TaxFactory::getTaxPlugin(), ['taxclass' => $taxclass]);
	// 	return $default_country_rate[0];
	// }

	public static function getNetPrice($price, $taxclass): int
	{
		PluginHelper::importPlugin('commercelab_shop_taxes');

		$args = [
			$price,
			$taxclass
		];

		$net_price = Factory::getApplication()->triggerEvent('onGetNetPrice' . TaxFactory::getTaxPlugin(), $args);

		return round($net_price[0]);
	}

	public static function getBrutPrice($price, $taxclass): int
	{
		PluginHelper::importPlugin('commercelab_shop_taxes');

		$args = [
			$price,
			$taxclass
		];

		$brut_price = Factory::getApplication()->triggerEvent('onGetBrutPrice' . TaxFactory::getTaxPlugin(), $args);

		return round($brut_price[0]);
	}


	// public static function getTotalTax(Cart $cart): int
	// {
	// 	$tax = 0;
	// 	return $tax;
	// }

	public static function addDefaultRateToPrice(int $price): int
	{
		return self::addTaxRate($price, self::getDefaultCountryTaxRate());
		// return (int) ($price + ($price * ($default_country_rate / 100)));
	}

	public static function addApplicableRateToPrice(int $price, string $taxclass): int
	{
		PluginHelper::importPlugin('commercelab_shop_taxes');

		$args = [
			'price' => $price,
			'rate'  => self::getApplicableTaxRate($taxclass)
		];

		$price = Factory::getApplication()->triggerEvent('onAddTaxRate' . TaxFactory::getTaxPlugin(), $args);

		return $price[0];
		// return (int) ($price + ($price * ($default_country_rate / 100)));
	}

	public static function removeDefaultRateFromPrice(int $price): int
	{
		return self::removeTaxRate($price, self::getDefaultCountryTaxRate());
		// (int) ($price / (($default_country_rate / 100) + 1));
	}


	public static function getTotalTax(Cart $cart): int
	{

		$totalTax = 0;

		if ($cart->cartItems)
		{
			/* @var CartItem $item */
			foreach ($cart->cartItems as $item)
			{
				$totalTax += $item->tax;
			}

		}

		return $totalTax + $cart->totalShippingTax;

	}


	public static function getApplicableTaxRate($taxclass): float
	{
		PluginHelper::importPlugin('commercelab_shop_taxes');

		$tax_rate = Factory::getApplication()->triggerEvent('onGetApplicableTaxRate' . TaxFactory::getTaxPlugin(), ['taxclass' => $taxclass]);

		return $tax_rate[0];
	}

	public static function getItemTax(int $value, $tax_rate): float
	{

		PluginHelper::importPlugin('commercelab_shop_taxes');

		$args = [
			'value' => $value,
			'tax_rate' => $tax_rate / 100
		];

		$item_tax = Factory::getApplication()->triggerEvent('onGetItemTax' . TaxFactory::getTaxPlugin(), $args);

		return $item_tax[0];

	}


	public static function getTotalDefaultTax(int $totalTaxableValue): int
	{
		return 0;
	}

}
