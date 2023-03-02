<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Tandcs\TandcsFactory;
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
			$node->props['required_status']        = 5;
			$node->props['isValidStatus']          = ($node->props['required_status'] <= CheckoutFactory::validationStatus());
			$node->props['globalValidationStatus'] = CheckoutFactory::validationStatus();
			
			TandcsFactory::reset();
			$node->props['checked'] = false;

			$node->props['termsUrl'] = \CommerceLabShop\Config\ConfigFactory::getSystemRedirectUrls()->tandcs->full;

		},

	]

];

?>
