<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Resolver;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use CommerceLabShop\Price\Price;
use CommerceLabShop\Price\PriceFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Currency\Currency;

use Exception;

class Resolver
{

    public static function getSKU($itemid)
    {

        try {
            $product = ProductFactory::get($itemid);

        } catch (Exception $e) {
            return true;
        }
        return $product->sku;

    }


    public static function getBasePrice($itemid)
    {

        return;

        try {
            $product = ProductFactory::get($itemid);

        } catch (Exception $e) {
            return false;
        }
        $defaultcurrency = CurrencyFactory::getDefault();
        $currencyHelper = new Currency($defaultcurrency);

        return CurrencyFactory::formatNumberWithCurrency($product->base_price, $currencyHelper->iso);

    }

    public static function getDiscountedPrice($itemid)
    {

        try {
            $product = ProductFactory::get($itemid);

        } catch (Exception $e) {
            return true;
        }
        $defaultcurrency = CurrencyFactory::getDefault();
        $currencyHelper = new Currency($defaultcurrency);
        $price = $product->base_price - PriceFactory::calculateItemDiscount($product, true);

        return CurrencyFactory::formatNumberWithCurrency($price, $currencyHelper->iso, '', false);
    }


    public static function getStock($itemid)
    {
        try {
            $product = ProductFactory::get($itemid);

        } catch (Exception $e) {
            return true;
        }
        if ($product->stock == 0) {
            return "'0'";
        } else {
            return (string)$product->stock;
        }

    }


    public static function getWeight($itemid)
    {

        try {
            $product = ProductFactory::get($itemid);


        } catch (Exception $e) {
            return true;
        }
        return $product->weight . $product->weight_unit;

    }

    public static function getFlatFee($itemid)
    {

        try {

            $product = ProductFactory::get($itemid);

        } catch (Exception $e) {
            return true;
        }
        $defaultcurrency = CurrencyFactory::getDefault();
        $currencyHelper = new Currency($defaultcurrency);

        return CurrencyFactory::formatNumberWithCurrency($product->flatfee, $currencyHelper->iso);

    }

}
