<?php

namespace YpsApp\Source\Type;

use function YOOtheme\app;
use YOOtheme\Config;
use YOOtheme\Http\Request;
use function YOOtheme\trans;

use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\User\UserFactory;


class YpsOrderQueryType
{
    public static function config()
    {
        return [

            'fields' => [

                'cslOrder' => [
                    'type' => 'YpsOrder',
                    'metadata' => [
                        'label' => trans('Order'),
                        'group' => 'CommerceLab Shop',
                        'view' => ['com_content.article'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],
                ],
            ],

        ];
    }

    public static function resolve($root)
    {

        list($config, $request) = app(Config::class, Request::class);

        $order_id = $request->getQueryParam('cls_order_id', null);

        if (!$order_id) {
            return;
        }

        $user        = UserFactory::getActiveUser();
        $cart_cookie = $request->getCookieParam('yps-cart');
        $order       = OrderFactory::get($order_id);

        // if ($user->guest && $order->guest_pin != $cart_cookie
        //     || !$user->guest && $order->customer_id != $user->id)
        // {
        //     return;
        // }

        if ($order) {
            return $order;
        }

    }
}