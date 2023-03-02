<?php
/**
 * @package     CommerceLab Shop - Stripe Payment
 * @subpackage  com_commercelab_shop
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop - https://app.commercelab.shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

require_once __DIR__ . '/vendor/autoload.php';

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Config\Config;
use CommerceLabShop\Order\Orderlog;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Currency\Currency;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Emaillog\EmaillogFactory;

class plgCommercelab_shop_paymentStripepayment extends JPlugin
{


    /**
     * @return \Stripe\Checkout\Session
     * @throws \Stripe\Exception\ApiErrorException
     * @since 1.0
     *
     * @note - Function MUST call Cart::convertToOrder() to set the current cart to an order.
     *
     */


    public function onInitPaymentStripepayment($post)
    {

        $token = $post->json->getString('stripeToken');

        //first create the order in the DB
        $orderId = CartFactory::convertToOrder('Stripe Payment', '', '', false);

        if ($this->params->get('live'))
        {
            $privateKey = $this->params->get('live_private_key');
        }
        else
        {
            $privateKey = $this->params->get('test_private_key');
        }

        $order = OrderFactory::get($orderId);

        \Stripe\Stripe::setApiKey($privateKey);

        try {
            $charge = \Stripe\Charge::create(array(
                "amount"      => $order->order_total,
                "currency"    => $order->currency,
                "description" => $orderId,
                'source'      => $token,
            ));

            return $charge;

        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            $error = 'Status is:' . $e->getHttpStatus() . '\n';
            $error .= 'Type is:' . $e->getError()->type . '\n';
            $error .= 'Code is:' . $e->getError()->code . '\n';
            // param is '' in this case
            $error .= 'Param is:' . $e->getError()->param . '\n';
            $error .= 'Message is:' . $e->getError()->message . '\n';
            return $error;
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            $error = 'Message is:' . $e->getError()->message . '\n';
            return $error;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            $error = 'Message is:' . $e->getError()->message . '\n';
            return $error;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $error = 'Message is:' . $e->getError()->message . '\n';
            return $error;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            $error = 'Message is:' . $e->getError()->message . '\n';
            return $error;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $error = 'Message is:' . $e->getError()->message . '\n';
            return $error;
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $error = 'Message is:' . $e->getError()->message . '\n';
            return $error;
        }



    }

    /**
     *
     * Function onHookstripecheckout() - handles the hook event to allow webhooks to confirm orders etc.
     *
     * @param $payload
     * @param $post
     *
     * @since 1.0
     *
     */


    public function onHookstripepayment($payload, $post)
    {


        if ($this->params->get('live')) {
            $privateKey      = $this->params->get('live_private_key');
            $endpoint_secret = $this->params->get('live_endpoint_secret');
        } else {
            $privateKey      = $this->params->get('test_private_key');
            $endpoint_secret = $this->params->get('test_endpoint_secret');
        }

        \Stripe\Stripe::setApiKey($privateKey);

        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event      = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        }
        catch (\UnexpectedValueException $e)
        {
            // Invalid payload
                
            echo $e->getMessage();
            http_response_code(420);
            exit();
        }
        catch (\Stripe\Exception\SignatureVerificationException $e)
        {
            echo '<br /><h1>You reached your Stripe Webhook properly, add this URL inside your Stripe configuration</h1><br /><br />';

            // Invalid signature
            echo $e->getMessage();
            http_response_code(420);
            exit();
        }


        if ($event->type == 'charge.succeeded') {

            /*
             * Use after 1.0.12
             */

            // $orderid = OrderFactory::getOrderIdViaNumber($event->data->object->description);

            $order = OrderFactory::get($event->data->object->description);

            if ($order->id) {

                $order->order_status = 'C';
                $order->vendor_token = $event->data->object->id;
                $order->order_paid   = 1;

                $order_updated = OrderFactory::update($order);

                // CartFactory::clearCart(CartFactory::get()->id, Utilities::getCookieID());

                new Orderlog(false, $order->id, 'Order set to confirmed');

                try { // To send an email

                    // Why is not working?
                    // new Orderlog(false, $orderid, 'Order set to confirmed');
                    PluginHelper::importPlugin('commercelab_shop_system');

                    Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['created', $order->id]);
                    Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['confirmed', $order->id]);


                } catch (Exception $e) {
                    echo 'Order Completed correctly, but email sending failed <br />';
                    echo $e->getMessage();
                    http_response_code(200);
                    exit();

                }

                if ($order_updated) {
                    echo 'Order Completed correctly!';
                    http_response_code(200);
                    exit();
                }

                echo 'Order Not Update';
                echo var_dump($order_updated);
                http_response_code(420);
                exit();

            }

            echo 'Order Not Found';
            echo var_dump($order);
            http_response_code(420);
            exit();

        }

        echo 'Transaction not Charged, client side error';
        http_response_code(420);
        exit();
    }

    // private function getOrderLines($total)
    // {


    //     $currencyHelper = new Currency();

    //     $orderLines = array();

    //     $orderLines[0]['name']        = 'Your purchase on: ' . Factory::getConfig()->get('sitename');
    //     $orderLines[0]['description'] = $this->params->get('purchase_description');;
    //     $orderLines[0]['images']      = ['https://app.commercelab.shop/images/system/logo_sm.png'];
    //     $orderLines[0]['amount']      = $total;
    //     $orderLines[0]['currency']    = $currencyHelper->currency->iso;
    //     $orderLines[0]['quantity']    = 1;


    //     return $orderLines;


    // }


}
