<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace YpsApp\Source\Type;

use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\CMS\Helper\TagsHelper;

use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Factory;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use function YOOtheme\app;
use YpsApp\Source\CustomFieldsTypes\ProductFieldsType;
use YOOtheme\Builder\Joomla\Source\ArticleHelper;
use YOOtheme\Builder\Joomla\Source\TagHelper;
use YOOtheme\Path;
use YOOtheme\Str;
use function YOOtheme\trans;
use YOOtheme\View;

use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Order\Order;

use stdClass;

class YpsOrder
{
    public static function config()
    {
        $order_properties = (array) new Order([]);
        ksort($order_properties, SORT_REGULAR);

        foreach (array_keys($order_properties) as $property_name) {

            $name = ucfirst(str_replace('_', ' ', $property_name));

            $type = ($property_name == 'ordered_products') ? ['listOf' => 'YpsProduct'] : 'String';
            $fieldsArray[$property_name] = [
                'type' => $type,
                'metadata' => [
                    'label' => trans($name),
                    // 'group' => $param['group'],
                ],
                'extensions' => [
                    'call' => [
                        'func' => __CLASS__ . '::cslResolver',
                        'args' => [
                            'property_name' => $property_name
                        ],
                    ],
                ],
            ];
        }


        // dd($fieldsArray);
        // $merged_arrays = array_merge($fieldsArray, $customFieldsArray);
        $fields = [
            'fields' => $fieldsArray,
            'metadata' => [
                'type' => true,
                // 'label' => trans('CLS Content')
            ],

        ];

        // dd($fields);

        return $fields;
    }
    
    public static function cslResolver($order, $args, $context, $info) {

        $property_name = $args['property_name'];


        if (!$order->$property_name) {
            return;
        }

        switch($property_name)
        {
            case 'ordered_products':
                $value = [];
                foreach ($order->$property_name as $key => $ordered_product) {
                    $item     = new stdClass();
                    $item->id = $ordered_product->j_item;
                    $value[]  = $item;
                }
                break;

            default:
                $value = $order->$property_name;
                break;
        }

        return $value;

    }

}