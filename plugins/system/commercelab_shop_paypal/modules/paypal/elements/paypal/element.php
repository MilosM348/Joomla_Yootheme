<?php

/**
 * @package     CommerceLab Shop - PayPal
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;


use CommerceLabShop\Currency\Currency;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Currency\CurrencyFactory;
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

            $node->props['required_status'] = 6;

            $node->props['isValidStatus']          = ($node->props['required_status'] <= CheckoutFactory::validationStatus());
            $node->props['globalValidationStatus'] = CheckoutFactory::validationStatus();


            // API Credentials
            $defaultcurrency = CurrencyFactory::getDefault();
            $currencyHelper  = new Currency($defaultcurrency);

            $paymentPlugin       = PluginHelper::getPlugin('commercelab_shop_payment', 'paypal');
            $paymentPluginParams = new Registry($paymentPlugin->params);

            $node->props['plugin_id']       = $paymentPlugin->id;
            $node->props['publishable_key'] = 'test';
            if ($paymentPluginParams->get('live')) {
                $node->props['mode'] == 'live';

                if (!$paymentPluginParams->get('live_client_id') || !$paymentPluginParams->get('live_secret')) {
                    Factory::getApplication()->enqueueMessage('Please enter your Live PayPal App Credentials in the CommerceLab Shop <a href="administrator/index.php?option=com_plugins&view=plugin&layout=edit&extension_id=' . $paymentPlugin->id . '" target="_blank"> Payment plugin</a>.', 'warning');
                    return false;
                } else {
                    $node->props['publishable_key'] = $paymentPluginParams->get('live_client_id');
                }

            } else {
                $node->props['mode'] == 'sandbox';

                if (!$paymentPluginParams->get('sb_client_id') || !$paymentPluginParams->get('sb_secret')) {
                    Factory::getApplication()->enqueueMessage('Please enter your Sandbox PayPal App Credentials in the CommerceLab Shop <a href="administrator/index.php?option=com_plugins&view=plugin&layout=edit&extension_id=' . $paymentPlugin->id . '" target="_blank"> Payment plugin</a>.', 'warning');
                    return false;
                } else {
                    $node->props['publishable_key'] = $paymentPluginParams->get('sb_client_id');
                }

            }

            // set default tag
            $localeTag = 'en_US';
            if ($paymentPluginParams->get('system_locale')) {
                $currentLanguage = Factory::getLanguage();
                $localeTag = $currentLanguage->getTag();
            } else {
                $localeTag = $paymentPluginParams->get('locale');
            }

            $localeTag = str_replace('-', '_', $localeTag);

            $node->props['baseUrl']   = Uri::base();
            $node->props['currency']  = $currencyHelper->iso;
            $node->props['localeTag'] = $localeTag;

            // Funding Sources
            $node->props['funding_sources'] = $node->props['exclude_funding_sources'] = [];

            if ($node->props['funding_source_CARD']) {
                $node->props['funding_sources'][] = 'card';
            } else {
                $node->props['exclude_funding_sources'][] = 'card';
            }

            if ($node->props['funding_source_PAYLATER']) {
                $node->props['funding_sources'][] = 'paylater';
            } else {
                $node->props['exclude_funding_sources'][] = 'paylater';
            }

            if ($node->props['funding_source_VENMO']) {
                $node->props['funding_sources'][] = 'venmo';
            } else {
                $node->props['exclude_funding_sources'][] = 'venmo';
            }

        }

    ]

];
?>