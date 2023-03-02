<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace YpsApp;

use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Component\ComponentHelper;
use CommerceLabShop\Product\ProductFactory;

use YOOtheme\Builder;
use YOOtheme\Path;
use YOOtheme\Config as Yooconfig;
use YOOtheme\Builder\ElementTransform;

// use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Config\ConfigFactory;

return [
    // 'config' => function () {
    //     dd('config');
    //     $registry = Factory::getConfig();
    //     $language = Factory::getLanguage();
    //     $application = Factory::getApplication();

    //     // get apikey from plugin
    //     if ($plugin = PluginHelper::getPlugin('installer', 'yootheme')) {
    //         dd($plugin);
    //         $params = json_decode($plugin->params);
    //     }

    //     return [
    //         'app' => [
    //             'platform' => 'joomla',
    //             'version' => JVERSION,
    //             'secret' => $registry->get('secret'),
    //             'debug' => (bool) $registry->get('debug'),
    //             'rootDir' => strtr(JPATH_ROOT, '\\', '/'),
    //             'tempDir' => strtr($registry->get('tmp_path', JPATH_ROOT . '/tmp'), '\\', '/'),
    //             'cacheDir' => strtr($registry->get('cache_path', JPATH_ROOT . '/cache'), '\\', '/'),
    //             'adminDir' => strtr(JPATH_ADMINISTRATOR, '\\', '/'),
    //             'uploadDir' => strtr(
    //                 JPATH_ROOT .
    //                     '/' .
    //                     ComponentHelper::getParams('com_media')->get('file_path', 'images'),
    //                 '\\',
    //                 '/'
    //             ),
    //             'isSite' => $application->isClient('site'),
    //             'isAdmin' => $application->isClient('administrator'),
    //             'apikey' => isset($params->apikey) ? $params->apikey : '',
    //         ],

    //         'req' => [
    //             'baseUrl' => Uri::base(true),
    //             'rootUrl' => Uri::root(true),
    //             'siteUrl' => rtrim(Uri::root(), '/'),
    //         ],

    //         'locale' => [
    //             'rtl' => (bool) $language->get('rtl'),
    //             'code' => strtr($language->get('tag'), '-', '_'),
    //         ],

    //         'session' => [
    //             'token' => Session::getFormToken(),
    //         ],

    //         'joomla' => [
    //             'config' => $registry,
    //         ],

    //         'user' => Factory::getUser(),
    //     ];
    // },

    'events' => [
        'source.init' => [
            Source\SourceListener::class => ['initSource', -10],
        ],
        'customizer.init' => [
            Source\SourceListener::class => 'initCustomizer',
        ],
        // 'builder.save' => [
        //     CustomizerListener::class => function (View $view) {
                
        //     }
        // ],

        // 'builder.template' => [
        //     Source\SourceListener::class => 'matchTemplate',
        // ],
        // 'customizer.init' => [
        //     Source\SourceListener::class => ['initCustomizer', -10],
        // ],
    ],

    'extend' => [

        Builder::class => function (Builder $builder) {
            $builder->addTypePath(Path::get('./elements/*/element.json'));
        },

    ],
    // 'services' => [
    //     Builder::class => function (
    //         ElementTransform $element
    //     ) {
    //         dd($element);
    //     }
    // ],
    'config' => function (Yooconfig $yooconfig) {

        // dd($yooconfig);
        // Load Custom Params
        $yooconfig->addFile('cls_builder', Path::get('./config/cls_builder.json'));


        // $yooconfig->get('joomla.config.db')
        // ${commercelab.component.config.billing_required}
        // "default": "${commercelab.component.config.guest_checkout_allowed}"     

        // ${commercelab.component.config.requiretandcs}
        $order_properties = (array) new Order([]);
        ksort($order_properties, SORT_REGULAR);

        $product_options_list = [];
        foreach (array_keys($order_properties) as $property_name) {
            $name = ucfirst(str_replace('_', ' ', $property_name));
            $product_options_list[$name] = $property_name;
        }

        // $cls_payment_plugins = PluginHelper::isEnabled('commercelab_shop_payment');
        // $cls_payment_plugins = PluginHelper::getPlugin('commercelab_shop_payment');
        // dd($cls_payment_plugins);
        // foreach($cls_payment_plugins as $plugin) {
        //     $payment_plugins[] = $plugin->name;
        // }

        $extension = 'com_content';
        if (JVERSION < "4.0.0")
        {
            $extension = 'content';
        }
        $categories = Categories::getInstance($extension);

        $cat0 = $categories->get();
        $cats = $cat0->getChildren(true);

        // $rootNode = $categories->get();   
        // $categoryNodes = $rootNode->getChildren();
        $categories_array = [];
        foreach ($cats as $key => $category) {

            // Build Subcategories indented Name
            if ($category->level > 1)
            {
                $level = $category->level;

                $title = '';
                while ($level > 1) {
                    $title .= ' -';
                    $level--;
                }
                $title .= ' ' . $category->title;

            }
            else
            {
                // Not a Subcategoru
                $title = $category->title;
            }

            $categories_array[$title] = $category->id;
        }

        $variants_array = [];
        foreach (ProductFactory::getVariantTypes() as $type)
        {
            if (!in_array($type->name, $variants_array))
            {
                $variants_array[$type->name] = $type->name;
            }
        }

        // Load List of Payment Plugins for AIO Payments
        $payment_plugins = ["- Select - " => ""];

        if (PluginHelper::getPlugin('commercelab_shop_payment', 'offlinepay')) {
            $payment_plugins['Offline'] = 'offlinepay';
        }

        if (PluginHelper::getPlugin('commercelab_shop_payment', 'paypal')) {
            $payment_plugins['PayPal'] = 'paypal';
        }

        if (PluginHelper::getPlugin('commercelab_shop_payment', 'stripepayment')) {
            $payment_plugins['Stripe'] = 'stripepayment';
        }

        if (PluginHelper::getPlugin('commercelab_shop_payment', 'mollieadvanced')) {
            $payment_plugins['Mollie Advanced'] = 'mollieadvanced';
        }

        if (PluginHelper::getPlugin('system', 'commercelab_shop_stripeadvanced')) {
            $payment_plugins['Stripe Advanced'] = 'commercelab_shop_stripeadvanced';
        }

        $commercelab_shop_add2cartanywhere = false;
        $products_array                    = [];
        if (PluginHelper::getPlugin('system', 'commercelab_shop_add2cartanywhere')) {

            foreach (ProductFactory::getList(0)['items'] as $product)
            {
                $products_array[$product->title] = $product->joomla_item_id;
            }
            ksort($products_array);
            $commercelab_shop_add2cartanywhere = true;
        }

        $return = [
            'commercelab' => [
                'component' => [
                    'config' => [
                        'guest_checkout_allowed' => ComponentHelper::getParams('com_commercelab_shop')->get('guest_checkout_allowed', 1),
                        'billing_required'       => ComponentHelper::getParams('com_commercelab_shop')->get('billing_required', 1),
                        'requiretandcs'          => ComponentHelper::getParams('com_commercelab_shop')->get('requiretandcs', 0)
                    ],
                    'order' => [
                        'properties' => $product_options_list
                    ],
                    'products' => [
                        'variants'      => $variants_array,
                        'products_list' => $products_array
                    ]
                ],
                'payment_plugins'  => $payment_plugins,
                'add2cartanywhere' => $commercelab_shop_add2cartanywhere,
                'joomla' => [
                    'user' => [
                        'allowUserRegistration' => ComponentHelper::getParams('com_users')->get('allowUserRegistration')
                    ],
                    'categories' => $categories_array
                ]
            ]
        ];

        $clsubscription = ConfigFactory::getClSubscription(18);
        if ($clsubscription['status_show'] && $clsubscription['ytp_status'])
        {
            $return['app'] = [
                'apikey' => $clsubscription['ytp_status']
            ];
        }

        return $return;
    },

];
