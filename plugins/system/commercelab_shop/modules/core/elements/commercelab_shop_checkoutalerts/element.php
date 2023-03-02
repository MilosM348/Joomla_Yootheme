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
use Joomla\CMS\Router\Route;
use Joomla\Input\Input;

use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Checkout\CheckoutFactory;


return [

	// Define transforms for the element node
	'transforms' => [

		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {


			return false;
			$node->props['baseUrl'] = Uri::base();

			$validation_status = CheckoutFactory::validationStatus(new Input());

			if (!$node->props['show_alerts'] || $node->props['show_alerts'] == '1') {
				$cart  = CartFactory::get();

				$validation_status = [
					'status_1' => [
						'status' => !is_null($cart->cartItems),
						'message' => $node->props['status_1']
					]
				];

			}

			$node->props['validation_status'] = $validation_status;

		}

	]

];

?>
