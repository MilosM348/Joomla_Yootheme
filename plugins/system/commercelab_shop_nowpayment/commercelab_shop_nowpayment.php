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

// require_once __DIR__ . '/vendor/autoload.php';

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Component\ComponentHelper;

use YOOtheme\Path;
use YOOtheme\Application;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Order\Orderlog;
use CommerceLabShop\Address\Address;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Currency\CurrencyFactory;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class plgSystemCommercelab_shop_nowpayment extends CMSPlugin
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

		if (class_exists(Application::class, false))
		{

			$app = Application::getInstance();

			$root    = __DIR__;
			$rootUrl = Uri::root(true);

			$themeroot = Path::get('~theme');
			$loader    = require "{$themeroot}/vendor/autoload.php";
			$loader->setPsr4("YpsApp_nowpayment\\", __DIR__ . "/modules/nowpayment");

			// set alias
			Path::setAlias('~commercelab_shop_nowpayment', $root);
			Path::setAlias('~commercelab_shop_nowpayment:rel', $rootUrl . '/plugins/system/commercelab_shop_nowpayment');

			// bootstrap modules
			$app->load('~commercelab_shop_nowpayment/modules/nowpayment/bootstrap.php');

		}

	}


	/**
	 * @return JsonResponse
	 * @throws Exception
	 * @since 2.0
	 */
	public function onAjaxCommercelab_shop_nowpayment()
	{

		$input = Factory::getApplication()->input;

		$task = $input->getString('task');

		switch ($task)
		{

			case 'getCurrencies':
				return $this->getCurrencies();

			case 'calculateCrypto':
				return $this->calculateCrypto($input);

			case 'initpayment':
				return $this->initPayment();

			case 'completepayment':
				return $this->completePayment($input);
		}

		return [];

	}


	/**
	 * @return Session
	 * @throws ApiErrorException
	 * @throws Exception
	 *
	 * @since 2.0
	 */

	public function onInitPaymentNowpayment()
	{
		$configcls    = new ConfigFactory;
		$configHelper = $configcls->getSystemRedirectUrls();
		$application  = Factory::getApplication();

		// $confirmation = Utilities::getUrlFromMenuItem();
		// $checkout     = Utilities::getUrlFromMenuItem($configHelper->checkout->short);

		$cartid    = CartFactory::get();
		$cart      = new Cart($cartid);
		$cartItems = $cart->cartItems;

		$configcls = new ConfigFactory;

		$address      = new Address(Address::getAssignedBillingAddressID());
		$order_amount = sprintf('%0.2f', round($cart->totalWithTaxInt/100, 2));

        // first create the order in DB
        $order_id = CartFactory::convertToOrder('Nowpayment');

        $brand_name = $configcls->get()->get('shop_name') != '' ? $configcls->get()->get('shop_name') : $application->get('sitename');

        $paymentPlugin       = PluginHelper::getPlugin('system', 'commercelab_shop_nowpayment');
        $paymentPluginParams = new Registry($paymentPlugin->params);

		$base_url = ($paymentPluginParams->get('live')) ? 'https://nowpayments.io/payment/' : 'https://sandbox.nowpayments.io/payment/';
		$protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https://" : "http://";
    	$hostname = $_SERVER['HTTP_HOST'];

        $nowpayments_args = array(
			'dataSource'       => "CommerceLab Shop",
			'ipnURL'           => $protocol . $hostname . '/' . 'index.php?option=com_commercelab_shop&paymenttype=Nowpayment',
			'paymentCurrency'  => CurrencyFactory::getDefault()->iso,
			'paymentAmount'    => $order_amount,
			'orderID'          => $order_id,
			'orderDescription' => $brand_name,
			'successURL'       => $protocol . $hostname . '/' . $configHelper->confirmation->short . '&cls_order_id=' . $order_id,
			'apiKey'           => ($paymentPluginParams->get('live')) ? $paymentPluginParams->get('api_key') : $paymentPluginParams->get('test_api_key')

        );

        $nowpayments_adr = urlencode(json_encode($nowpayments_args));

        return $base_url . '?data='.$nowpayments_adr;

	}
        


	/**
	 *
	 * Function onHooknowpayment() - handles the hook event to allow webhooks to confirm orders etc.
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


	public function onHookNowpayment($payload, $post, $server): void
	{

		if ($this->params->get('live'))
		{
			$api_key    = $this->params->get('api_key');
			$ipn_secret = $this->params->get('ipn_secret_key');
		}
		else
		{
			$api_key    = $this->params->get('test_api_key');
			$ipn_secret = $this->params->get('test_ipn_secret_key');

		}

		$error_msg    = "Unknown error";
		$auth_ok      = false;
		$request_data = null;

        if (isset($server['HTTP_X_NOWPAYMENTS_SIG']) && !empty($server['HTTP_X_NOWPAYMENTS_SIG']))
        {
            $recived_hmac = $server['HTTP_X_NOWPAYMENTS_SIG'];
            $request_data = json_decode($payload, true);

            ksort($request_data);
            $sorted_request_json = json_encode($request_data, JSON_UNESCAPED_SLASHES);

            if ($sorted_request_json !== false && !empty($sorted_request_json))
            {
                $hmac = hash_hmac("sha512", $sorted_request_json, trim($ipn_secret));

                if ($hmac == $recived_hmac)
                {

					$order = OrderFactory::get($request_data['order_id']);

					if ($order->id)
					{
		                $order->order_status = 'C';
		                $order->vendor_token = $request_data['payment_id'];
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

	                echo 'Order ID not found';
	                http_response_code(420);
					exit();

                }
                else
                {
                    echo 'HMAC signature does not match';
					http_response_code(420);
					exit();
                }
            }
            else
            {
                echo 'Error reading POST data';
				http_response_code(420);
				exit();
            }
        }
        else
        {
            echo 'No HMAC signature sent.';
			http_response_code(420);
			exit();
        }

	}


}