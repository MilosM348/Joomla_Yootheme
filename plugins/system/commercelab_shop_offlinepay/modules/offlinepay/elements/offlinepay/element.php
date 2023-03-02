<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Tandcs\Tandcs;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Checkout\CheckoutFactory;

return [

    // Define transforms for the element node
    'transforms' => [

        // The function is executed before the template is rendered
        'render' => function ($node, array $params) {

            // Prevent Loading if no producst in cart
            if (!CheckoutFactory::validationStatus())
            {
                return false;
            }

            $node->props['required_status']        = 6;
            $node->props['isValidStatus']          = ($node->props['required_status'] <= CheckoutFactory::validationStatus());
            $node->props['globalValidationStatus'] = CheckoutFactory::validationStatus();
            $node->props['isGuestCheckout']        = CartFactory::get()->guest;


            $params = ConfigFactory::get();

            $confirmation                 = Utilities::getUrlFromMenuItem($params->get('confirmation_page_url', '45'));
            $node->props['completionurl'] = Route::_(Uri::base() . $confirmation);

        },

    ]

];

?>
