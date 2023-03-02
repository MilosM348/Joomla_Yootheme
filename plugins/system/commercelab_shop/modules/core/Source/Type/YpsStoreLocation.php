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
use YOOtheme\Builder\Joomla\Source\ArticleHelper;
use YOOtheme\Builder\Joomla\Source\TagHelper;
use YOOtheme\Path;
use YOOtheme\Str;
use function YOOtheme\trans;
use YOOtheme\View;

use CommerceLabShop\Shop\ShopFactory;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Shop\Shop;
use CommerceLabShop\Customfield\CustomFieldsHelper;


class YpsStoreLocation
{
    public static function config()
    {
        $fieldsParams = [
            'title' => [
                'type' => 'String',
                'label' => 'Title',
                'group' => 'Basic',
                'property_name' => 'title'
            ],
            'address' => [
                'type' => 'String',
                'label' => 'Address',
                'group' => 'Basic',
                'property_name' => 'address'
            ],
            'city' => [
                'type' => 'String',
                'label' => 'City',
                'group' => 'Basic',
                'property_name' => 'city'
            ],
            'postalcode' => [
                'type' => 'String',
                'label' => 'Postalcode',
                'group' => 'Basic',
                'property_name' => 'postalcode'
            ],
            'country' => [
                'type' => 'String',
                'label' => 'Country',
                'group' => 'Basic',
                'property_name' => 'country',
            ],
            'zone' => [
                'type' => 'String',
                'label' => 'Zone',
                'group' => 'Basic',
                'property_name' => 'zone',
            ],
            'image' => [
                'type' => 'String',
                'label' => 'Image',
                'group' => 'Basic',
                'property_name' => 'image',
            ],
            'pickuptimes' => [
                'type' => 'String',
                'label' => 'Pickup Times',
                'group' => 'Basic',
                'property_name' => 'pickuptimes',
            ],
            'ordertimes' => [
                'type' => 'String',
                'label' => 'Order Times',
                'group' => 'Basic',
                'property_name' => 'ordertimes',
            ],
            'workinghours' => [
                'type' => 'String',
                'label' => 'Working Hours',
                'group' => 'Basic',
                'property_name' => 'workinghours',
            ],
        ];

        $fieldsArray = [];
        foreach ($fieldsParams as $field => $param) {
            $fieldsArray[$field] = [
                'type' => $param['type'],
                'metadata' => [
                    'label' => trans($param['label']),
                    'group' => $param['group'],
                ],
                'extensions' => [
                    'call' => [
                        'func' => __CLASS__ . '::cslResolver',
                        'args' => [
                            'property_name' => $param['property_name'],
                        ],
                    ],
                ],
            ];
            if (isset($param['metadata']))
            {
                foreach ($param['metadata'] as $metadata_key => $metadata_value) {
                    $fieldsArray[$field]['metadata'][$metadata_key] = $metadata_value;
                }
            }
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
    
    public static function getUpdatedStock($item) {
        if ($item->manage_stock) {
            return ($item->stock - CartFactory::getTotalAmountProductFromCart($item->joomla_item_id));
        } else {
            $item->stock;
        }
    }

    public static function cslResolver($item, $args, $context = null, $info = null) {

        $property_name = $args['property_name'];
        $shop       = ShopFactory::get($item->id);

        if ($shop) {
            switch($property_name)
            {
                case 'pickuptimes':
                    $tmp = $shop->$property_name;
                    $value = '';
                    if ($tmp) {
                        $pickuptimes = json_decode($tmp);
                        $value = $value . '';
                        foreach($pickuptimes as $pickuptime) {
                            $value = $value . '<div><div>' . $pickuptime->name. '</div>';
                            if ($pickuptime->workingday == '1') {
                                $value = $value . '<div><span>&nbsp;&nbsp;Pickup Times: </span>';
                                foreach($pickuptime->timeslots as $timeslot) {
                                    $value = $value . '<span>'. $timeslot->start .'</span> ~ <span>'. $timeslot->end .'</span>&nbsp;&nbsp;&nbsp;';
                                }
                                $value = $value . '</div>';    
                            }
                            $value = $value . '</div>';
                        }
                    }
                case 'ordertimes':
                    $tmp = $shop->$property_name;
                    $value = '';
                    if ($tmp) {
                        $ordertimes = json_decode($tmp);
                        $value = $value . '';
                        foreach($ordertimes as $ordertime) {
                            $value = $value . '<div><div>' . $ordertime->name. '</div>';
                            if ($ordertime->workingday == '1') {
                                $value = $value . '<div><span>&nbsp;&nbsp;Order Times: </span>';
                                $hours = $ordertime->workinghours;
                                if ($ordertime->straight == '1') {
                                    $value = $value . '<span>'. $hours->start1 .'</span> ~ <span>'. $hours->end2 .'</span>';
                                }
                                else {
                                    $value = $value . '<span>'. $hours->start1 .'</span> ~ <span>'. $hours->end1 .'</span>&nbsp;&nbsp;&nbsp;<span>'. $hours->start2 .'</span> ~ <span>'. $hours->end2 .'</span>';
                                }
                                $value = $value . '</div>';    
                            }
                            $value = $value . '</div>';
                        }
                    }
                case 'workinghours':
                    $tmp = $shop->$property_name;
                    $value = '';
                    if ($tmp) {
                        $workinghours = json_decode($tmp);
                        $value = $value . '';
                        foreach($workinghours as $workinghour) {
                            $value = $value . '<div><div>' . $workinghour->name. '</div>';
                            if ($workinghour->workingday == '1') {
                                $value = $value . '<div><span>&nbsp;&nbsp;Working Hours: </span>';
                                $hours = $workinghour->workinghours;
                                if ($workinghour->straight == '1') {
                                    $value = $value . '<span>'. $hours->start1 .'</span> ~ <span>'. $hours->end2 .'</span>';
                                }
                                else {
                                    $value = $value . '<span>'. $hours->start1 .'</span> ~ <span>'. $hours->end1 .'</span>&nbsp;&nbsp;&nbsp;<span>'. $hours->start2 .'</span> ~ <span>'. $hours->end2 .'</span>';
                                }
                                $value = $value . '</div>';    
                            }
                            $value = $value . '</div>';
                        }
                    }
                default:
                    $value = $shop->$property_name;
                    break;
            }
            return $value;
        }
    }

}