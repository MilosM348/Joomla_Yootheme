<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;


use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Tax\Tax;
use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Total\TotalFactory;
use CommerceLabShop\Coupon\CouponFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Shipping\ShippingFactory;
use CommerceLabShop\Language\LanguageFactory;
use CommerceLabShop\Checkout\CheckoutFactory;


use Brick\Money\Money;

return [

	// Define transforms for the element node
	'transforms' => [


		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {

            // Prevent Loading if no producst in cart
            if (!CheckoutFactory::validationStatus()) {
                return false;
            }

            $node->props['required_status'] = 1;

			LanguageFactory::load();
            $config = ConfigFactory::get();
            $cart   = CartFactory::get();

			$node->props['cart'] = $cart;

			if ($node->props['shipping_tax'])
            {
			    $shippingTotal = CurrencyFactory::translate(ShippingFactory::getShipping($cart));
            }
            else
            {
                $shippingTotal = CurrencyFactory::translate(ShippingFactory::getShipping($cart));
            }

            if ($node->props['subtotal_tax'])
            {
                $node->props['subTotal'] = CurrencyFactory::translate(CartFactory::getSubTotalWithTax($cart));
            }
            else
            {
                $node->props['subTotal'] = CurrencyFactory::translate(CartFactory::getSubTotalWithoutTax($cart));
            }

			$node->props['total']    = CurrencyFactory::translate(TotalFactory::getGrandTotal($cart));

			// check if a coupon is applied
            if ($coupon = CouponFactory::getCurrentAppliedCoupon()) {

            	// check if the discount is free shipping
                if ($coupon->discount_type === 'freeship') {

                	//if so, set the discount to the shipping total.
                    $node->props['totalDiscount'] =  CurrencyFactory::translate(CouponFactory::calculateDiscount($cart));
                } else {
                	//
                    $couponDiscount = CouponFactory::calculateDiscount($cart);
                    if ($couponDiscount > TotalFactory::getSubTotal($cart)) {
                        $node->props['totalDiscount'] = $node->props['subTotal'];
                    } else {
                        $node->props['totalDiscount'] = CurrencyFactory::translate(CouponFactory::calculateDiscount($cart));
                    }
                }
            } else {

            	// if no coupon applied, simply return £0.00 (or whatever currency is selected)
                $node->props['totalDiscount'] = CurrencyFactory::translate(0);
            }

			$node->props['totalDiscount'] = CurrencyFactory::translate(CouponFactory::calculateDiscount($cart));

		}

	]

];
