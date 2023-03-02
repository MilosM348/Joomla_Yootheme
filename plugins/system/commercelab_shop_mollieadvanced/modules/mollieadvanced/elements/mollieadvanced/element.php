<?php

/**
 * @package     Pro2Store - Mollie
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - Pro2Store. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Checkout\CheckoutFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Cart\CartFactory;


return [

    // Define transforms for the element node
    'transforms' => [



        // The function is executed before the template is rendered
        'render' => function ($node, array $params) {

            // Prevent Loading if no producst in cart
            if (!CheckoutFactory::validationStatus()) {
                return false;
            }

            $node->props['required_status']        = 6;
            $node->props['isValidStatus']          = ($node->props['required_status'] <= CheckoutFactory::validationStatus());
            $node->props['globalValidationStatus'] = CheckoutFactory::validationStatus();
            $node->props['isGuestCheckout']        = CartFactory::get()->guest;

            Factory::getLanguage()->load('com_commercelab_shop', JPATH_ADMINISTRATOR);

            $paymentPlugin       = PluginHelper::getPlugin('commercelab_shop_payment', 'mollieadvanced');
            $paymentPluginParams = new Registry($paymentPlugin->params);

            if ($paymentPluginParams->get('live'))
            {

                if (!$paymentPluginParams->get('live_api_key')) {
                    Factory::getApplication()->enqueueMessage('Please enter your Mollie API Key in the Mollie Advanced - CommerceLab plugin.', 'warning');
                    return false;
                }
                $node->props['publishable_key'] = $paymentPluginParams->get('live_api_key');

            }
            else
            {
                if (!$paymentPluginParams->get('test_api_key')) {
                    Factory::getApplication()->enqueueMessage('Please enter your Mollie API Key in the Mollie Advanced - CommerceLab plugin.', 'warning');
                    return false;
                }
                $node->props['publishable_key'] = $paymentPluginParams->get('test_api_key');
            }


        },

    ]

];
