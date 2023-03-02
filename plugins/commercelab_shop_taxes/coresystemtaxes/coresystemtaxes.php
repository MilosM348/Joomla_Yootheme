<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Cart\CartItem;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Shipping\TaxFactory;
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Address\AddressFactory;

class plgCommercelab_shop_taxesCoresystemtaxes extends JPlugin
{
    protected $autoloadLanguage = true;

    function __construct(&$subject, $config)
    {
        $language = Factory::getLanguage();
        $language->load('com_commercelab_shop', JPATH_ADMINISTRATOR);
        parent::__construct($subject, $config);

    }

    protected static function defaultCountryTaxRate(string $taxclass): float
    {
        $taxrate = CountryFactory::getDefault()->$taxclass;

        return $taxrate;
    }

    public function onGetItemTaxCoresystemtaxes($value, $tax_rate): float
    {
        $item_tax = 0;

        if (!ProductFactory::basePriceWithTax())
        {
            $item_tax = $value * ($tax_rate / 100);
        }
        else
        {
            $item_tax = ($value - ($value / ($tax_rate + 1))) / 100;
        }

        return round($item_tax, 2);
    }

    // Get net Price, if price is added with Tax in the product, we only use default country Tax rate
    public function onGetNetPriceCoresystemtaxes($price, $taxclass): float
    {

        if (!ProductFactory::basePriceWithTax())
        {
            return $price;
        }
        else
        {
            $net_price = self::onRemoveTaxRateCoresystemtaxes(
                $price, 
                self::onGetApplicableTaxRateCoresystemtaxes($taxclass)
            );
        }
        return $net_price; 
    }

    // Get net Price, if price is added with Tax in the product, we only use default country Tax rate
    public function onGetBrutPriceCoresystemtaxes($price, $taxclass): float
    {

        if (ProductFactory::basePriceWithTax())
        {
            $price = self::onGetNetPriceCoresystemtaxes($price, $taxclass);
        }

        $brut_price = self::onAddTaxRateCoresystemtaxes(
            $price, 
            self::onGetApplicableTaxRateCoresystemtaxes($taxclass)
        );

        return $brut_price; 
    }

    public function onCalculateTotalTaxesCoresystemtaxes(Cart $cart, Address $address)
    {
        if (ProductFactory::basePriceWithTax())
        {

        }
        // return ShippingFactory::calculateTotalShipping($cart);
    }

    public function onGetDefaultCountryTaxRateCoresystemtaxes($taxclass)
    {
        $taxrate = CountryFactory::getDefault()->$taxclass;
    }

    public function onAddTaxRateCoresystemtaxes($price, $rate)
    {
        return $price + ($price * ($rate / 100));
    }

    public function onRemoveTaxRateCoresystemtaxes($price, $rate)
    {
        return $price / (($rate / 100) + 1);
    }



    public function onGetApplicableTaxRateCoresystemtaxes($taxclass): float
    {
        // Not a Taxable Product
        if (!$taxclass)
        {
            return 0.00;
        }

        $tax_source = ComponentHelper::getParams('com_commercelab_shop')->get('calculate_tax_based_on', 'default_country');

        // Get Taxrate from default (Shop) Country
        $taxrate = CountryFactory::getDefault()->$taxclass;

        if (is_null($taxrate))
        {
            $taxrate = 0.00;
        }

        if ($tax_source == 'default_country')
        {
            return $taxrate;
        }

        // If settings are to use Billing OR SHipping Address.
        // check the address if it has enough data for Taxrate, if not set, return Country Taxrate
        $addresses         = CartFactory::getAssignedAddresses();
        $address_taxsource = str_replace('customer_', '', $tax_source) . '_id';

        if ($addresses && $addresses->$address_taxsource)
        {
            $address = AddressFactory::get($addresses->$address_taxsource);
            if (is_null($address))
            {
                $taxrate = 0.00;
                return $taxrate;
            }

            $country = CountryFactory::get($address->country);
            $zone    = CountryFactory::getZone($address->zone);

            // If Address has a valid Zone Tax Rate
            if ($zone && !$zone->inherit_taxrate && $zone->$taxclass)
            {
                $taxrate = $zone->$taxclass;
            }
            else if ($country && $country->$taxclass)
            {
                $taxrate = $country->$taxclass;
            }
        }

        if (is_null($taxrate))
        {
            $taxrate = 0.00;
        }

        return $taxrate;
    }

}
