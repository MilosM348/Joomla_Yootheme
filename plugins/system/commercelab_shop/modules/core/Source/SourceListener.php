<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace YpsApp\Source;

// use Joomla\CMS\Factory;
use Joomla\CMS\Document\Document;

// use YOOtheme\Config;
use YOOtheme\Config;
use function YOOtheme\trans;
use YOOtheme\Builder\Joomla\Fields\FieldsHelper;

// use Joomla\CMS\HTML\HTMLHelper;

use CommerceLabShop\Product\ProductFactory;

class SourceListener
{
    public static function initSource($source)
    {

        // Product
        $source->objectType('YpsProduct', Type\YpsProduct::config());

        // Product query types
        $source->queryType(Type\YpsProductQueryType::config()); // Product
        $source->queryType(Type\YpsProductsQueryType::config()); // Products

        $source->queryType(Type\YpsCustomProductQueryType::config()); // Custom Product
        $source->queryType(Type\YpsCustomProductsQueryType::config()); // Custom Products

        // Store Location
        $source->objectType('YpsStoreLocation', Type\YpsStoreLocation::config());

        // Store Location query types
        $source->queryType(Type\YpsStoreLocationQueryType::config()); // Store Location

        // Orders
        $source->objectType('YpsOrder', Type\YpsOrder::config());
        $source->queryType(Type\YpsOrderQueryType::config());

        // Custom Fields
        $source->objectType('YpsProductSqlField', CustomFieldsTypes\SqlFieldType::config());
        $source->objectType('YpsProductValueField', CustomFieldsTypes\ValueFieldType::config());
        $source->objectType('YpsProductMediaField', CustomFieldsTypes\MediaFieldType::config());
        $source->objectType('YpsProductChoiceField', CustomFieldsTypes\ChoiceFieldType::config());
        $source->objectType('YpsProductChoiceFieldString', CustomFieldsTypes\ChoiceFieldStringType::config());

        if ($fields = FieldsHelper::getFields('com_content.article')) {
            static::configFields($source, 'YpsProduct', 'com_content.article', $fields);
        }

    }

    public static function initCustomizer(Config $config)
    {
        $fields = [];

        foreach (FieldsHelper::getFields('com_content.article') as $field) {
            if (
                $field->fieldparams->get('multiple') ||
                $field->fieldparams->get('repeat') ||
                $field->type === 'repeatable'
            ) {
                continue;
            }

            $fields[] = ['value' => "field:{$field->id}", 'text' => $field->title];
        }

        if ($fields) {
            $config->add(
                'customizer.sources.articleOrderOptions',
                array_merge($config('customizer.sources.articleOrderOptions'), [
                    ['label' => 'Custom Fields', 'options' => $fields],
                ])
            );
        }
    }

    protected static function configFields($source, $type, $context, array $fields)
    {
        // add field on type
        $source->objectType(
            $type,
            $config = [
                'fields' => [
                    'field' => [
                        'type' => ($fieldType = "YpsProductFields"),
                        'metadata' => [
                            'label' => trans('Product'),
                        ],
                        'extensions' => [
                            'call' => CustomFieldsTypes\FieldsType::class . '::field',
                        ],
                    ],
                ],
            ]
        );

        if ($type === 'YpsProduct') {
            $source->objectType('TagItem', $config);
        }

        // configure field type
        $source->objectType($fieldType, CustomFieldsTypes\FieldsType::config($source, $type, $context, $fields));
    }
    // public static function matchTemplate(Document $document, $view, $tpl)
    // {


        // $layout  = $view->getLayout();
        // $context = $view->get('context');


        // if (($context === 'com_content.category' || $context === 'com_content.featured') && $layout === 'blog') {

        //     $category = $view->get('category');
        //     $pagination = $view->get('pagination');

        //     return [
        //         'type' => $context,
        //         'query' => [
        //             'catid' => $category->id,
        //             'tag' => array_column($category->tags->itemTags, 'id'),
        //             'pages' => $pagination->pagesCurrent === 1 ? 'first' : 'except_first',
        //             'lang' => $document->language,
        //         ],
        //         'params' => [
        //             'category' => $category,
        //             'items' => array_merge($view->get('lead_items'), $view->get('intro_items')),
        //             'pagination' => $pagination,
        //         ],
        //     ];
        // }

        // dd($view);
        // if ($context === 'com_content.article' && $layout === 'default' && !$tpl) {

        //     // get current item from view, like an Article object

        //     $order = $view->get('cls_order_id');

        //     return [
        //         'type' => $context,
        //         'query' => ['cslOrder' => $order],
        //         'params' => ['item' => $order],
        //     ];
        // }

        // if ($context === 'com_content.article.clabshopcheckout' && $layout === 'default' && !$tpl) {

        //     // get current item from view, like an Article object
        //     $item = $view->get('item');

        //     // return type, query and parameters of the matching view
        //     $checkout = (ConfigFactory::getSystemRedirectUrls()->checkout->id == $item);
        //     return [
        //         'type' => $context,
        //         'params' => ['item' => $checkout],
        //     ];
        // }
    // }
}
