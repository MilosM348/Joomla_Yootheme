<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


use Joomla\CMS\Uri\Uri;
use Joomla\Input\Input;

use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Checkout\CheckoutFactory;

return [
	'transforms' =>
		['render' => function ($node, array $params) {

			$cart = CartFactory::get();

			$node->props['cartItems'] = $cart->cartItems;
			$node->props['baseUrl']   = Uri::base();

			// Set Vlidation for Items on Load
			// $data = new Input();
			// $data->set('status_1', ($cart->cartItems));

			// CheckoutFactory::validationStatus($data);
		},
	]
];

























































