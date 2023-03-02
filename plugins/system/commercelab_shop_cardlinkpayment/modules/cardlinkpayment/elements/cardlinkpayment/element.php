<?php

/**
 * @package     CommerceLab Shop - Stripe Payment
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;
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

            Factory::getLanguage()->load('com_commercelab_shop', JPATH_ADMINISTRATOR);

            $paymentPlugin       = PluginHelper::getPlugin('system', 'commercelab_shop_cardlinkpayment');
            $paymentPluginParams = new Registry($paymentPlugin->params);

            $live = ($paymentPluginParams->get('live')) ? 'live' : 'test';
            if (!$paymentPluginParams->get($live . '_shared_secret', null) || !$paymentPluginParams->get('mid', null))
            {
                Factory::getApplication()->enqueueMessage('Please enter your Shared Secret Key and MID in the CommerceLab Shop Cardlink Payment Getaway plugin.', 'warning');
                return false;
            }

        },

    ]

];

?>
