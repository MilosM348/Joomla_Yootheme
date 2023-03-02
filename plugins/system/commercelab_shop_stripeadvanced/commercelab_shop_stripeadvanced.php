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

require_once __DIR__ . '/vendor/autoload.php';

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Component\ComponentHelper;

use YOOtheme\Path;
use YOOtheme\Application;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Order\Orderlog;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Currency\CurrencyFactory;

use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class plgSystemCommercelab_shop_stripeadvanced extends CMSPlugin
{

	private $db;

	public function onAfterInitialise()
	{

		if (!ComponentHelper::getComponent('com_commercelab_shop', true)->enabled)
		{
			return;
		}

		if (!PluginHelper::isEnabled('system', 'commercelab_shop'))
		{
			return;
		}

        // $validation = ConfigFactory::getAddonClSubscription(20);
        // if (!$validation['status_show'])
        // {
        //     if (Factory::getApplication()->isClient('administrator') && Factory::getApplication()->input->get('option', '') == 'com_commercelab_shop')
        //     {
        //         Factory::getApplication()->enqueueMessage($validation['message_html'], 'error');
        //     }

        //     return;
        // }

		if (class_exists(Application::class, false))
		{

			$app = Application::getInstance();

			$root    = __DIR__;
			$rootUrl = Uri::root(true);

			$themeroot = Path::get('~theme');
			$loader    = require "{$themeroot}/vendor/autoload.php";
			$loader->setPsr4("YpsApp_stripeadvanced\\", __DIR__ . "/modules/stripeadvanced");

			// set alias
			Path::setAlias('~commercelab_shop_stripeadvanced', $root);
			Path::setAlias('~commercelab_shop_stripeadvanced:rel', $rootUrl . '/plugins/system/commercelab_shop_stripeadvanced');

			// bootstrap modules
			$app->load('~commercelab_shop_stripeadvanced/modules/stripeadvanced/bootstrap.php');

		}

	}


	/**
	 * @return JsonResponse
	 * @throws Exception
	 * @since 2.0
	 */
	public function onAjaxCommercelab_shop_stripeadvanced(): JsonResponse
	{

		$input = Factory::getApplication()->input;

		$task = $input->getString('task');

		switch ($task)
		{
			case 'initpayment':
				return $this->initPayment();
			case 'completepayment':
				return $this->completePayment($input);
		}

		return new JsonResponse('ko', 'No Task', true);

	}


	/**
	 * @return Session
	 * @throws ApiErrorException
	 * @throws Exception
	 *
	 * @since 2.0
	 */

	public function onInitPaymentStripeadvanced()
	{

        // first create the order in DB
        $orderId = CartFactory::convertToOrder('Stripe Advanced');

		if ($this->params->get('live'))
		{
			$privateKey = $this->params->get('live_private_key');
		}
		else
		{
			$privateKey = $this->params->get('test_private_key');
		}

		\Stripe\Stripe::setApiKey($privateKey);

        $order = OrderFactory::get($orderId);

		$configcls    = new ConfigFactory;
		$configHelper = $configcls->getSystemRedirectUrls();
		$confirmation = $configHelper->confirmation->short;
		$cancel       = $configHelper->checkout->short;
		
		$session = Session::create([
			'payment_method_types' => ['card'],
			'payment_intent_data'  => array('description' => $this->params->get('purchase_description')),
			'line_items'           => [[
				// 'name'        => 'Your purchase on: ' . Factory::getConfig()->get('sitename'),
				// 'description' => $this->params->get('purchase_description', $order->id),
				// 'images'      => [Uri::base() . $this->params->get('checkout_image')],
				// 'amount'      => $order->order_total,
				// 'currency'    => CurrencyFactory::getCurrent()->iso,
				'price_data'  => [
					'currency'     => CurrencyFactory::getCurrent()->iso,
					'unit_amount'  => $order->order_total,
					'product_data' => [
						'name'        => 'Your purchase on: ' . Factory::getConfig()->get('sitename'),
						'description' => $this->params->get('purchase_description', $order->id),
						'images'      => [Uri::base() . $this->params->get('checkout_image')],
				  	],
				],
				'quantity' => 1,
			]],
			'mode' => 'payment',
			'client_reference_id' => $orderId . "|commercelab_shop",                                        // orderID concatenated via pipe with the CommerceLab identity, this helps prevent webhook clashes.
			'success_url'         => Route::_(Uri::base() . $confirmation . '&cls_order_id=' . $orderId),
			'cancel_url'          => Route::_(Uri::base() . $cancel)
		]);	
		return $session;


	}


	// /**
	//  * @param $total
	//  *
	//  * @return array
	//  * @throws Exception
	//  * @since 2.0
	//  */


	// private function getOrderLines($order): array
	// {

	// 	$currency   = CurrencyFactory::getCurrent();
	// 	$orderLines = [];

	// 	$orderLines[0]['name']        = 'Your purchase on: ' . Factory::getConfig()->get('sitename');
	// 	$orderLines[0]['description'] = $this->params->get('purchase_description', $order->id);
	// 	$orderLines[0]['images']      = [Uri::base() . $this->params->get('checkout_image')];
	// 	$orderLines[0]['amount']      = $order->order_total;
	// 	$orderLines[0]['currency']    = $currency->iso;
	// 	$orderLines[0]['quantity']    = 1;
		
	// 	return $orderLines;
	// }


	/**
	 *
	 * Function onHookstripecheckout() - handles the hook event to allow webhooks to confirm orders etc.
	 *
	 * @param $payload
	 * @param $post
	 *
	 * @return void
	 *
	 * @throws Exception
	 * @since 1.0
	 *
	 */


	public function onHookstripeadvanced($payload, $post): void
	{

		if ($this->params->get('live'))
		{
			$privateKey      = $this->params->get('live_private_key');
			$endpoint_secret = $this->params->get('live_endpoint_secret');
		}
		else
		{
			$privateKey      = $this->params->get('test_private_key');
			$endpoint_secret = $this->params->get('test_endpoint_secret');

		}

		\Stripe\Stripe::setApiKey($privateKey);

		$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
		$event      = null;
				
		try
		{
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
			// Invalid signature
			echo '<br /><h1>You reached your Stripe Webhook properly, add this URL inside your Stripe configuration</h1><br /><br />';

			echo $e->getMessage();
			http_response_code(420);
			exit();
		}

		if ($event->type == 'checkout.session.completed')
		{

			$orderRef = $event->data->object->client_reference_id;
			
			$orderRef = explode("|", $orderRef);

			if ($orderRef[1] == 'commercelab_shop')
			{

				$orderid = $orderRef[0];

				if (is_numeric($orderid))
				{

					$order = OrderFactory::get($orderid);

					if ($order->id)
					{
		                $order->order_status = 'C';
		                $order->vendor_token = $event->data->object->payment_intent;
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

                echo 'Order ID Not Numeric';
                echo var_dump($orderid);
                http_response_code(420);
				exit();
			}

		}


	}


}
