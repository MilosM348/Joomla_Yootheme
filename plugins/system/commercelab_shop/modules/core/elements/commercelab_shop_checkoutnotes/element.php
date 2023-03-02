<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use CommerceLabShop\Checkoutnote\CheckoutnoteFactory;
use CommerceLabShop\Checkout\CheckoutFactory;

return [

	'transforms' => [

		'render' => function ($node, array $params) {

            // Prevent Loading if no producst in cart
            if (!CheckoutFactory::validationStatus()) {
                return false;
            }
			$node->props['required_status'] = 4;
			$node->props['isValidStatus']   = ($node->props['required_status'] <= CheckoutFactory::validationStatus());
			$node->props['globalValidationStatus'] = CheckoutFactory::validationStatus();

			$node->props['note'] = '';
			$node->props['note'] = '';

			if ($currentNote = CheckoutnoteFactory::getCurrentNote())
			{
				$node->props['note'] = $currentNote->note;
			}


		},

	]

];
