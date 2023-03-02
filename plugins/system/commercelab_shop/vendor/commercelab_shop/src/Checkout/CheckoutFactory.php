<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


namespace CommerceLabShop\Checkout;

// no direct access
defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;

use Joomla\Input\Input;
use Joomla\CMS\Language\Text;
use CommerceLabShop\Tandcs\Tandcs;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Price\PriceFactory;
use CommerceLabShop\Shipping\Shipping;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Tandcs\TandcsFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Coupon\CouponFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Productoption\ProductoptionFactory;

use stdClass;
use Exception;

class CheckoutFactory
{

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function isStatusValid($data): bool
	{
		$valid = $data->json->getInt('required_status', 1) <= self::validationStatus();
		return $valid;
	}

	public static function validationStatus(): int
	{

		$cart      = CartFactory::get();
		$component = ConfigFactory::get();


		$guest_checkout_allowed = $component->get('guest_checkout_allowed', 1);
		$billing_required       = (bool) $component->get('billing_required', 1);
		$shipping_required      = CartFactory::isShippingRequired();
		$requiretandcs          = $component->get('requiretandcs', 0);


		// Cart has NO Items
		if (is_null($cart->cartItems)) {
			return 0;
		}

		// User is Guest and  guest is NOT allowsed
		if (!$guest_checkout_allowed && UserFactory::getActiveUser()->guest) {
			return 1;
		}

		// User is Guest and  guest is NOT allowsed
		if ($guest_checkout_allowed && UserFactory::getActiveUser()->guest && CartFactory::get()->guest === 0) {
			return 2;
		}

		// Billing Address required and added to the checkout
		if ($billing_required && (is_null(CartFactory::getAssignedAddresses()) || !CartFactory::getAssignedAddresses()->billing_address_id)) {
			return 3;
		}

		// Shipping Address added to the checkout
		// if ($shipping_required && (is_null(CartFactory::getAssignedAddresses()) || !CartFactory::getAssignedAddresses()->shipping_address_id)) {
		if ($shipping_required && (is_null(CartFactory::getAssignedAddresses()) || !CartFactory::getAssignedAddresses()->shipping_address_id)) {
			return 4;
		}

		// Terms and Conditions checked
		if ($requiretandcs && !Tandcs::isChecked()) {
			return 5;
		}

		return 10;

	}

}
