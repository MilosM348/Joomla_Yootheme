<?php
/**
 * @package     CommerceLab Shop - Paypal
 * @subpackage  com_commercelab_shop
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop - https://Commercelab.solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

require_once __DIR__ . '/vendor/autoload.php';

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Response\JsonResponse;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Order\Orderlog;
use CommerceLabShop\Address\Address;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Currency\Currency;
use CommerceLabShop\Total\TotalFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Emaillog\EmaillogFactory;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class plgCommercelab_shop_paymentPaypal extends JPlugin
{

    public function getPaypalclient()
    {
        return new PayPalHttpClient($this->getPaypalenvironment());
    }

    public function getPaypalenvironment()
    {

        if ((int)$this->params->get('live')) {
            $publicKey    = $this->params->get('live_client_id');
            $secret       = $this->params->get('live_secret');
            $clientId     = getenv("CLIENT_ID") ?: $publicKey;
            $clientSecret = getenv("CLIENT_SECRET") ?: $secret;

            return new ProductionEnvironment($clientId, $clientSecret);

        } else {

            $publicKey    = $this->params->get('sb_client_id');
            $secret       = $this->params->get('sb_secret');

            $clientId     = getenv("CLIENT_ID") ?: $publicKey;
            $clientSecret = getenv("CLIENT_SECRET") ?: $secret;

            return new SandboxEnvironment($clientId, $clientSecret);

        }


    }

    public function onInitPaymentPaypal($post)
    {
        $debug = false;

        // $address = new Address(Address::getAssignedShippingAddressID());
        // return new JsonResponse($address);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->body = $this->buildRequestBody();

        // 3. Call PayPal to set up a transaction
        $client   = $this->getPaypalclient();
        $response = $client->execute($request);
        
        if ($debug) {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Intent: {$response->result->intent}\n";
            print "Links:\n";
            foreach ($response->result->links as $link) {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }

            // To print the whole response body, uncomment the following line
            // echo json_encode($response->result, JSON_PRETTY_PRINT);
        }

        // 4. Return a successful response to the client.
        return $response;

    }


    public function onCompletePaymentPaypal($data)
    {

        $debug = false;

        $vendorToken = $data->json->getString('paypalorderid');
        $request     = new OrdersCaptureRequest($vendorToken);

        // 3. Call PayPal to capture an authorization
        $client   = $this->getPaypalclient();
        $response = $client->execute($request);

        if ($response->result->status == 'COMPLETED') {

            //create the order
            $orderid = CartFactory::convertToOrder('PayPal', '', $vendorToken, false);

            // Is this really Workiong?? If yes, why it does not work on StripePayment??
            $order = new OrderFactory($orderid);
            $order->updateStatus('C', $orderid);
            $order->togglePaid($orderid);
            $response->clsOrderId = $orderid;
            // $order->save();

            // CartFactory::clearCart(CartFactory::get()->id, Utilities::getCookieID());

            try { // To send an email

                // Why is not working?
                // new Orderlog(false, $orderid, 'Order set to confirmed');
                PluginHelper::importPlugin('commercelab_shop_system');

                Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['created', $orderid]);
                Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['confirmed', $orderid]);


            } catch (Exception $e) {}

        }

         
//        if ($responsedata[0])
        // 4. Save the capture ID to your database. Implement logic to save capture to your database for future reference.
        if ($debug) {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Links:\n";
            foreach ($response->result->links as $link) {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            print "Capture Ids:\n";
            foreach ($response->result->purchase_units as $purchase_unit) {
                foreach ($purchase_unit->payments->captures as $capture) {
                    print "\t{$capture->id}";
                }
            }
            // To print the whole response body, uncomment the following line
            // echo json_encode($response->result, JSON_PRETTY_PRINT);
        }


        return $response;

    }


    /**
     * Function hook() - handles the hook event to allow webhooks to conrim orders etc.
     *
     * @param $post
     *
     *
     *
     */


    public function hook($post)
    {


    }

    private function buildRequestBody()
    {

        $application  = Factory::getApplication();
        $configcls    = new ConfigFactory;
        $configHelper = $configcls->getSystemRedirectUrls();

        // $confrimationUrl = $configHelper->confirmationItemid;

        // $confirmation = Utilities::getUrlFromMenuItem($confrimationUrl);
        $defaultcurrency = CurrencyFactory::getDefault();
        $currencyHelper  = new Currency($defaultcurrency);

        
        $address = new Address(Address::getAssignedShippingAddressID());
        // dd($address);
        $cartid  = CartFactory::get();

        $cart      = new Cart($cartid);
        $cartItems = $cart->cartItems;
        $value     = sprintf('%0.2f', round($cart->subtotalWithoutTaxInt/100, 2));

        $brand_name = $configcls->get()->get('shop_name') != '' ? $configcls->get()->get('shop_name') : $application->get('sitename');
        // $value = round(2200/100, 2);
        $items = [];
        $ci    = 0;

        foreach ($cartItems as $cart_item) {

            $cart_item->product->joomlaItem->title = str_replace(' ', '-', $cart_item->product->joomlaItem->title);
            $cart_item->product->joomlaItem->title = str_replace(',', '', $cart_item->product->joomlaItem->title);

            // $padded = sprintf('%0.2f', round($cart_item->product->base_priceWithTax/100, 2));
            // $padded = sprintf('%0.2f', round($cart_item->product->base_price/100, 2));

            $item = [
                'name'        => mb_substr($cart_item->product->joomlaItem->title, 0, 100),
                'description' => mb_substr(
                    (strlen(strip_tags($cart_item->product->short_desc)) > 2) 
                        ? strip_tags($cart_item->product->short_desc) 
                        : strip_tags($cart_item->product->title),
                    0, 100
                ),
                'unit_amount' => 
                [
                    'currency_code' => $currencyHelper->iso,
                    'value'         => sprintf('%0.2f', round(($cart_item->total_bought_at_price_WithoutTax/$cart_item->amount)/100, 2))
                ],
                'tax' => 
                [
                    'currency_code' => $currencyHelper->iso,
                    'value'         => sprintf('%0.2f', round(($cart_item->tax/$cart_item->amount)/100, 2))
                ],
                'quantity' => $cart_item->amount,
                'category' => 'DIGITAL_GOODS',
            ];

            // Add Sku if available
            if ($cart_item->product->sku != '') {
                $item['sku'] = $cart_item->product->sku;
            }

            $items[] = $item;

            $ci++;
        }

        $shipping = [
            'method' => 'United States Postal Service',
            'name'   => [
                'full_name' => $address->first_name . ' ' . $address->last_name,
            ],
            'email_address' => $address->email,    
            'address'       => [
                'address_line_1' => $address->address1,
                'address_line_2' => $address->address2,
                'admin_area_2'   => $address->city,
                'admin_area_1'   => $address->zone_name,
                'postal_code'    => $address->postcode,
                'country_code'   => $address->country_isocode_2
            ]
        ];
        $shipping = [];
        $shipping_preferences = (count($shipping)) ? 'SET_PROVIDED_ADDRESS' : 'NO_SHIPPING';

        // Request Body Return
        $request_body = [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url'          => Uri::base().$configHelper->confirmation->short,
                'cancel_url'          => Uri::base().$configHelper->cancellation->short,
                'brand_name'          => $brand_name,
                'locale'              => 'en-US',
                'landing_page'        => 'BILLING',
                'shipping_preference' => $shipping_preferences,
                'user_action'         => 'PAY_NOW'
            ],
            'purchase_units' => [
                0 => [
                    'reference_id' => 'REFID-000-100' . $cartItems[0]->product->joomla_item_id,
                    'description'  => mb_substr(
                        (strlen(strip_tags($cartItems[0]->product->short_desc)) > 2) 
                            ? strip_tags($cartItems[0]->product->short_desc) 
                            : strip_tags($cartItems[0]->product->title),
                        0, 100
                    ),
                    'custom_id'    => $cartid->id,
                    'amount' => [
                        'currency_code' => $currencyHelper->iso,
                        'value'         => sprintf('%0.2f', round($cart->totalWithTaxInt/100, 2)),
                        'breakdown'     => [
                            'item_total' => 
                            [
                                'currency_code' => $currencyHelper->iso,
                                'value'         => sprintf('%0.2f', round($cart->subtotalWithoutTaxInt/100, 2))
                            ],
                            'shipping' =>
                            [
                                'currency_code' => $currencyHelper->iso,
                                'value'         => sprintf('%0.2f', round($cart->totalShippingWithoutTax/100, 2))
                            ],
                            'handling' => 
                            [
                                'currency_code' => $currencyHelper->iso,
                                'value'         => '00.00'
                            ],
                            'tax_total' => 
                            [
                                'currency_code' => $currencyHelper->iso,
                                'value'         => sprintf('%0.2f', round($cart->taxInt/100, 2))
                            ],
                            'shipping_discount' => 
                            [
                                'currency_code' => $currencyHelper->iso,
                                'value'         => sprintf('%0.2f', round($cart->totalDiscountInt/100, 2))
                            ]
                        ]
                    ],
                    'items'    => $items,      
                    // 'shipping' => $shipping
                ]
            ]
        ];

        // dd($request_body);
        return $request_body;
    }

}

// return [
//      'intent' => 'CAPTURE',
//      'application_context' =>
//      [
//          'return_url' => Uri::base() . $configHelper->confirmation->short,
//          'cancel_url' => Uri::base() . $configHelper->cancellation->short,
//          'brand_name' => 'EXAMPLE INC',
//          'locale' => 'en-US',
//          'landing_page' => 'BILLING',
//          'shipping_preference' => 'SET_PROVIDED_ADDRESS',
//          'user_action' => 'PAY_NOW',
//      ],
//      'purchase_units' =>
//      [
//          0 =>
//          [
//              'reference_id' => 'PUHF',
//              'description' => 'Sporting Goods',
//              'custom_id' => 'CUST-HighFashions',
//              'soft_descriptor' => 'HighFashions',
//              'amount' =>
//              [
//                  'currency_code' => $currencyHelper->currency->iso,
//                  'value' => $value,
//                  'breakdown' =>
//                      [
//                          'item_total' =>
//                              [
//                                  'currency_code' => 'USD',
//                                  'value' => '180.00',
//                              ],
//                          'shipping' =>
//                              [
//                                  'currency_code' => 'USD',
//                                  'value' => '20.00',
//                              ],
//                          'handling' =>
//                              [
//                                  'currency_code' => 'USD',
//                                  'value' => '10.00',
//                              ],
//                          'tax_total' =>
//                              [
//                                  'currency_code' => 'USD',
//                                  'value' => '20.00',
//                              ],
//                          'shipping_discount' =>
//                              [
//                                  'currency_code' => 'USD',
//                                  'value' => '10.00',
//                              ],
//                      ],
//              ],
//              'items' =>
//              [
//                  0 =>
//                  [
//                      'name' => 'T-Shirt',
//                      'description' => 'Green XL',
//                      'sku' => 'sku01',
//                      'unit_amount' =>
//                      [
//                          'currency_code' => 'USD',
//                          'value' => '90.00',
//                      ],
//                      'tax' =>
//                      [
//                          'currency_code' => 'USD',
//                          'value' => '10.00',
//                      ],
//                      'quantity' => '1',
//                      'category' => 'PHYSICAL_GOODS',
//                  ],
//                  1 =>
//                  [
//                      'name' => 'Shoes',
//                      'description' => 'Running, Size 10.5',
//                      'sku' => 'sku02',
//                      'unit_amount' =>
//                      [
//                          'currency_code' => 'USD',
//                          'value' => '45.00',
//                      ],
//                      'tax' =>
//                      [
//                          'currency_code' => 'USD',
//                          'value' => '5.00',
//                      ],
//                      'quantity' => '2',
//                      'category' => 'PHYSICAL_GOODS',
//                  ],
//              ],
//              'shipping' => [
//                  'method' => 'United States Postal Service',
//                  'name' => [
//                      'full_name' => $address->name
//                  ],
//                  'email_address' => $address->email,
//                  'address' => [
//                      'address_line_1' => $address->address1,
//                      'address_line_2' => $address->address2,
//                      'admin_area_2' => $address->town,
//                      'admin_area_1' => $address->zone_name,
//                      'postal_code' => $address->postcode,
//                      'country_code' => $address->country_2digit
//                  ],
//              ],
//          ],
//      ],
//  );
// return [
//      'intent' => 'CAPTURE',
//      'application_context' =>
//          [
//              'return_url' => Uri::base().$configHelper->confirmation->short,
//              'cancel_url' => Uri::base().$configHelper->cancellation->short,
//              'brand_name' => 'EXAMPLE INC',
//              'locale' => 'en-US',
//              'landing_page' => 'BILLING',
//              'shipping_preference' => 'SET_PROVIDED_ADDRESS',
//              'user_action' => 'PAY_NOW',
//          ],
//      'purchase_units' =>
//          [
//              0 =>
//                  [
//                      'reference_id' => 'PUHF',
//                      'description' => 'Sporting Goods',
//                      'custom_id' => 'CUST-HighFashions',
//                      'soft_descriptor' => 'HighFashions',
//                      'amount' =>
//                          [
//                              'currency_code' => 'USD',
//                              'value' => '220.00',
//                              'breakdown' =>
//                                  [
//                                      'item_total' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '180.00',
//                                          ],
//                                      'shipping' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '20.00',
//                                          ],
//                                      'handling' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '10.00',
//                                          ],
//                                      'tax_total' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '20.00',
//                                          ],
//                                      'shipping_discount' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '10.00',
//                                          ],
//                                  ],
//                          ],
//                      'items' =>
//                          [
//                              0 =>
//                                  [
//                                      'name' => 'T-Shirt',
//                                      'description' => 'Green XL',
//                                      'sku' => 'sku01',
//                                      'unit_amount' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '90.00',
//                                          ],
//                                      'tax' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '10.00',
//                                          ],
//                                      'quantity' => '1',
//                                      'category' => 'PHYSICAL_GOODS',
//                                  ],
//                              1 =>
//                                  [
//                                      'name' => 'Shoes',
//                                      'description' => 'Running, Size 10.5',
//                                      'sku' => 'sku02',
//                                      'unit_amount' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '45.00',
//                                          ],
//                                      'tax' =>
//                                          [
//                                              'currency_code' => 'USD',
//                                              'value' => '5.00',
//                                          ],
//                                      'quantity' => '2',
//                                      'category' => 'PHYSICAL_GOODS',
//                                  ],
//                          ],
//                      'shipping' =>
//                          [
//                              'method' => 'United States Postal Service',
//                              'name' =>
//                                  [
//                                      'full_name' => 'John Doe',
//                                  ],
//                              'address' =>
//                                  [
//                                      'address_line_1' => '123 Townsend St',
//                                      'address_line_2' => 'Floor 6',
//                                      'admin_area_2' => 'San Francisco',
//                                      'admin_area_1' => 'CA',
//                                      'postal_code' => '94107',
//                                      'country_code' => 'US',
//                                  ],
//                          ],
//                  ],
//          ],
//  );

