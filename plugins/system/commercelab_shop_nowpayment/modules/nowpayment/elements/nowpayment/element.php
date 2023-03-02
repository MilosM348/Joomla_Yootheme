<?php

/**
 * @package     CommerceLab Shop - Stripe Payment
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\Plugin\PluginHelper;

use CommerceLabShop\Checkout\CheckoutFactory;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Cart\Cart;

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

            $paymentPlugin       = PluginHelper::getPlugin('system', 'commercelab_shop_nowpayment');
            $paymentPluginParams = new Registry($paymentPlugin->params);

            if (!$paymentPluginParams->get('api_key', null) && !$paymentPluginParams->get('ipn_secret_key', null))
            {
                Factory::getApplication()->enqueueMessage('Please enter your Shared API Key and IPN Secret Key in the CommerceLab Shop NOWPayments Getaway plugin.', 'warning');
                return false;
            }

            $base_url = ($paymentPluginParams->get('live')) ? 'https://api.nowpayments.io/v1/' : 'https://api-sandbox.nowpayments.io/v1/';
            $client   = new GuzzleHttp\Client(['base_uri' => $base_url]);
            $status   = $client->request('GET', 'status');

            if (json_decode($status->getBody()->getContents())->message != 'OK')
            {
                return false;
            }

            $cartid = CartFactory::get();
            $cart   = new Cart($cartid);

            $node->props['cartTotal'] = $cart->totalWithTax;

        },

    ]

];

?>
