<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Total;

defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;


use CommerceLabShop\Coupon\CouponFactory;
use CommerceLabShop\Productoptions\Productoptions;
use CommerceLabShop\Productoption\Productoption;
use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Price\Price;


class TotalFactory
{




	/**
	 * @param   Cart  $cart
	 *
	 * @return float|int|mixed
	 *
	 * @since 1.0
	 */

    public static function getGrandTotal(Cart $cart)
    {

        $total = $cart->subtotalInt;

        $couponDiscount = CouponFactory::calculateDiscount($cart);

        if ($couponDiscount > $total) {
            $couponDiscount = $total;
        }

        $total = $total - $couponDiscount;
//        $total = $total + Shipping::getTotalShippingFromPlugin($cart);
//        $total = $total + Tax::calculateTotalTax($cart);

        return $total;

    }


	/**
	 *
	 * Function - getSubTotal
	 *
	 * Returns the subtotal for any given cart as an integer
	 *
	 * @param   Cart  $cart
	 *
	 * @return int
	 * @since 2.0
	 */

    public static function getSubTotal(Cart $cart) : int
    {


        // init total var at 0
        $total = 0;

        if ($results = $cart->cartItems) {

            // loop through the cart list
            foreach ($results as $result) {

                $total += (int) $result->totalCost;
            }

        }

        return $total;

    }

    /**
     * Function - getItemTotal
     *
     * returns to the total for the item in the cart in integer format
     *
     * @param $cartitemid
     * @return integer
     */


    public static function getItemTotal($cartitemid)
    {
        // Get Helpers
        $productOptionsHelper = new Productoptions();

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__commercelab_shop_cart_item'));
        $query->where($db->quoteName('id') . ' = ' . $db->quote($cartitemid));

        $db->setQuery($query);

        $result = $db->loadObject();

        // init total var at 0
        $total = 0;
        // get the saved item options
        $item_options = json_decode($result->item_options);

        // get the baseprice of the item
//        $baseprice = $this->getBaseprice($result->joomla_item_id);
        $baseprice = Price::getBasePrice($result->joomla_item_id);

        //init the sum var as the baseprice
        $sum = $baseprice;

        // get the options as set in the item database
        // keeps carts up to date with the latest product data
        $dboptions = $productOptionsHelper->getOptions($result->joomla_item_id);

        // loop through the saved item options and match them to the current product options
        foreach ($item_options->options as $option) {


            $dboption = new Productoption($option->optionid);

//            return json_encode($dboption);

            if ($dboption->modifiervalue) {

                if ($dboption->modifiertype === 'perc') {
                    if ($dboption->modifier == 'add') {
                        $sum += ($dboption->modifiervalue / 100) * $baseprice;
                    } else {
                        $sum -= ($dboption->modifiervalue / 100) * $baseprice;
                    }
                } elseif ($dboption->modifiertype === 'amount') {
                    if ($dboption->modifier == 'add') {
                        $sum += $dboption->modifiervalue;
                    } else {
                        $sum -= $dboption->modifiervalue;
                    }
                }

            }


        }
        // add the summed amount to the total
        $total += $sum;

        return $total;

    }

    public static function formatTotal($total, $currency)
    {

    }

}
