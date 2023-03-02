<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

require_once __DIR__ . '/vendor/autoload.php';

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Emaillog\EmaillogFactory;

class plgCommercelab_shop_paymentMollieadvanced extends JPlugin
{

    /**
     *
     * Function called by the protostore_ajaxhelper plugin via checkout AJAX
     *
     * This function should ALWAYS call Cart::convertToOrder(NAME OF PAYMENT METHOD);
     *
     * @return mixed
     *
     */


    public function onInitPaymentMollieadvanced()
    {

        $mollie = new \Mollie\Api\MollieApiClient();

        if ($this->params->get('live')) {
            $mollie->setApiKey($this->params->get('live_api_key'));
        } else {
            $mollie->setApiKey($this->params->get('test_api_key'));
        }


        // first create the order in DB
        $orderId = CartFactory::convertToOrder('Mollie Advanced');

        $configcls    = new ConfigFactory;
        $configHelper = $configcls->getSystemRedirectUrls();
        $confirmation = $configHelper->confirmation->short;

        $order = OrderFactory::get($orderId);
  
        $mollie_order = [
            "amount" => [
                "currency" => $order->currency,
                "value"    => $order->order_total_float
            ],
            "description" => $this->params->get('purchase_description', 'Order Description'),
            "redirectUrl" => Route::_(Uri::base() . $confirmation . '&cls_order_id=' . $orderId),
            "webhookUrl"  => Uri::base() . 'index.php?option=com_commercelab_shop&paymenttype=mollieadvanced',
            // "webhookUrl"  => 'https://9051-201-240-104-126.sa.ngrok.io/index.php?option=com_commercelab_shop&paymenttype=mollieadvanced',
            
            "metadata" => [
                "order_id" => $orderId,
            ]

        ];

        // Make a Call to Mollie
        $payment = $mollie->payments->create($mollie_order);

        // Store Payment ID from Mollie
        $order->order_status = 'P';
        $order->vendor_token = $payment->id;

        $order_updated = OrderFactory::update($order);

        // Return Checkout Url
        if ($order_updated) {
            return $payment->getCheckoutUrl();
        }

        return null;

    }


    public function onHookmollieadvanced($payload, $post)
    {
        
        $mollie = new \Mollie\Api\MollieApiClient();

        if ($this->params->get('live')) {
            $mollie->setApiKey($this->params->get('live_api_key'));
        } else {
            $mollie->setApiKey($this->params->get('test_api_key'));
        }

        $payment = $mollie->payments->get($post['id']);

        if (!$payment->metadata->order_id) {
            return;
        }

        // $order = new OrderFactory($payment->metadata->order_id);
        
        $order = OrderFactory::get($payment->metadata->order_id);

        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
            // $order->updateStatus('C', $payment->metadata->order_id);

            $order->order_status = 'C';
            $order->order_paid   = 1;

            $order_updated = OrderFactory::update($order);

            // CartFactory::clearCart(CartFactory::get()->id, Utilities::getCookieID());

            try { // To send an email

                // Why is not working?
                // new Orderlog(false, $orderid, 'Order set to confirmed');
                PluginHelper::importPlugin('commercelab_shop_system');
                Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['created', $order->id]);


            }
            catch (Exception $e)
            {   
                // Log if Failed
                EmaillogFactory::log($e->getMessage(), 'created', 0, $order->id);
            }

            try { // To send an email

                // Why is not working?
                // new Orderlog(false, $orderid, 'Order set to confirmed');
                PluginHelper::importPlugin('commercelab_shop_system');
                Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['confirmed', $order->id]);
                

            }
            catch (Exception $e)
            {   
                // Log if Failed
                EmaillogFactory::log($e->getMessage(), 'confirmed', 0, $order->id);
            }
            if ($order_updated)
            {

                http_response_code(200);

            } else {
                http_response_code(400);
            }

            // $order->save();
        } elseif ($payment->isOpen()) {
            /*
             * The payment is open.
             */
        } elseif ($payment->isPending()) {
            $order->updateStatus('P', $payment->metadata->order_id);
            // $order->save();
            /*
             * The payment is pending.
             */
        } elseif ($payment->isFailed()) {
            $order->updateStatus('D', $payment->metadata->order_id);
            // $order->save();
        } elseif ($payment->isExpired()) {
            /*
             * The payment is expired.
             */
        } elseif ($payment->isCanceled()) {
            $order->updateStatus('X', $payment->metadata->order_id);
            // $order->save();
        } elseif ($payment->hasRefunds()) {
            /*
             * The payment has been (partially) refunded.
             * The status of the payment is still "paid"
             */
        } elseif ($payment->hasChargebacks()) {
            /*
             * The payment has been (partially) charged back.
             * The status of the payment is still "paid"
             */
        }


    }


}
