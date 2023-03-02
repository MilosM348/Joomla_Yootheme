<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Checkout\CheckoutFactory;


return [

	// Define transforms for the element node
	'transforms' => [


		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {

            // Prevent Loading if no producst in cart
            if (!CheckoutFactory::validationStatus()) {
                return false;
            }
			$node->props['required_status']        = 1;
			$node->props['isValidStatus']          = ($node->props['required_status'] <= CheckoutFactory::validationStatus());
			$node->props['globalValidationStatus'] = CheckoutFactory::validationStatus();
			$node->props['isGuestCheckout']        = CartFactory::get()->guest;

			$node->props['fields_width'] = ($node->props['fields_width'] == 'custom') ? $node->props['fields_width_custom'] : $node->props['fields_width'];
			$node->props['showregister'] = ($node->props['showregister'] && ComponentHelper::getParams('com_users')->get('allowUserRegistration'));

			$node->props['shown'] = [];

			if ($node->props['showregister'])
			{
				$node->props['shown'][] = $node->props['showregister'];
			}

			if ($node->props['showlogin'])
			{
				$node->props['shown'][] = $node->props['showlogin'];
			}

			if ($node->props['showguest'])
			{
				$node->props['shown'][] = $node->props['showguest'];
			}

			if (empty($node->props['shown']))
			{
				return false;
			}
		}
	]
];
