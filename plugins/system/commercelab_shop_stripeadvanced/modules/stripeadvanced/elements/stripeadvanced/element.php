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

            $paymentPlugin = PluginHelper::getPlugin('system', 'commercelab_shop_stripeadvanced');
            $paymentPluginParams = new Registry($paymentPlugin->params);

            if ($paymentPluginParams->get('live'))
            {
                if (!$paymentPluginParams->get('live_public_key') || !$paymentPluginParams->get('live_private_key')) {

                    Factory::getApplication()->enqueueMessage('Please enter your Stripe Private Key in the CommerceLab Shop Stripe Advanced.', 'warning');
                    return false;
                }
                $node->props['publishable_key'] = $paymentPluginParams->get('live_public_key');

            }
            else
            {
                if (!$paymentPluginParams->get('test_public_key') || !$paymentPluginParams->get('test_private_key')) {

                    Factory::getApplication()->enqueueMessage('Please enter your Stripe Private Key and Endpoint secret in the CommerceLab Shop Payment plugin.', 'warning');
                    return false;
                }
                $node->props['publishable_key'] = $paymentPluginParams->get('test_public_key');
            }


            Factory::getDocument()->addScript('https://js.stripe.com/v3/');
            // load the vue files.
            // Factory::getDocument()->addScript('media/com_commercelab_shop/js/addons/commercelab_shop_stripepayment/bundle.482325474.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


            if($paymentPluginParams->get('system_locale')) {
                $node->props['locale'] = 'auto';
            } else {
                $node->props['locale']  = $paymentPluginParams->get('locale');
            }


            $configcls = new ConfigFactory;
            $configHelper = $configcls->getSystemRedirectUrls();

            $confrimationUrl = $configHelper->confirmation->short;

            // $confirmation = Utilities::getUrlFromMenuItem($confrimationUrl);
            $confirmation = $configHelper->confirmation->short;

            $node->props['confirmation'] = Route::_(Uri::base() . $confirmation);

        },

    ]

];

?>
