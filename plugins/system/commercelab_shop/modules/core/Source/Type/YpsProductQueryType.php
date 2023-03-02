<?php

namespace YpsApp\Source\Type;

use function YOOtheme\trans;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Product\Product;

class YpsProductQueryType
{
    public static function config()
    {
        return [

            'fields' => [

                'cslProduct' => [
                    'type' => 'YpsProduct',
                    'metadata' => [
                        'label' => trans('Product'),
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
        $item = $root['item'] ?? $root['article'] ?? null;

        if ($item && ProductFactory::get($item->id)) {
            return $item;
        }
    }
}