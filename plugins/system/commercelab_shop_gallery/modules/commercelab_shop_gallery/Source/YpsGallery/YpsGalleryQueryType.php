<?php

namespace YpsApp_Gallery\Source\YpsGallery;

use Joomla\CMS\Factory;

use CommerceLabShop\Product\Product;
use CommerceLabShop\Utilities\Utilities;

class YpsGalleryQueryType
{
    public static function config()
    {
        return [

            'fields' => [

                'ypsgallery' => [
                    'type' => [
                        'listOf' => 'YpsGallery',
                    ],
                    'args' => [

                    ],
                    'metadata' => [
                        'label' => 'Product Gallery',
                        'group' => 'CommerceLab Shop',

                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],
                ],
            ],

        ];
    }

    public static function resolve($root, array $args)
    {

        // return array('/images/system/customers.jpg','/images/system/customers.jpg','/images/system/customers.jpg');
        // get current id
        $currentProductId = Utilities::getCurrentItemId();

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select('path');
        $query->from($db->quoteName('#__commercelab_shop_gallery'));
        $query->where($db->quoteName('product_j_id') . ' = ' . $db->quote($currentProductId));
        $query->order('ordering ASC');

        $db->setQuery($query);

        return $db->loadColumn();

    }
}
