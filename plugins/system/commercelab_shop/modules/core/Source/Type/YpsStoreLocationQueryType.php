<?php

namespace YpsApp\Source\Type;

use function YOOtheme\trans;

use CommerceLabShop\Shop\ShopFactory;
use CommerceLabShop\Shop\Shop;

class YpsStoreLocationQueryType
{
    public static function config()
    {
        return [

            'fields' => [

                'cslShop' => [
                    'type' => 'YpsStoreLocation',
                    'metadata' => [
                        'label' => trans('Store Location'),
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
        dd($request);
        $shop_id = $request->getQueryParam('cls_shop_id', null);

        if (!$shop_id) {
            return;
        }
        $storelocation = ShopFactory::get($shop_id);

        if ($storelocation) {
            return $storelocation;
        }
    }
}