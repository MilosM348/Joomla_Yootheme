<?php

namespace YpsApp_gridandfilter;

use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Language\Text;

use function YOOtheme\app;
use YOOtheme\Config as Yooconfig;
use YOOtheme\Builder;
use YOOtheme\Path;

// Get YTP Source Object
// use YOOtheme\Builder\Source;
// $source = app(Source::class);

// use YOOtheme\Builder\Joomla\Source\Type;
// use YOOtheme\Builder\Joomla\Source\Type\ArticleType;
use YpsApp\Source\Type\YpsProduct;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Customfield\CustomFieldsHelper;
use CommerceLabShop\Productoption\ProductoptionFactory;

return [

    'extend' => [

        Builder::class => function (Builder $builder) {
            $builder->addTypePath(Path::get('./elements/*/element.json'));
        },

    ],

    'config' => function (Yooconfig $yooconfig) {

        $yooconfig->addFile('gandf_builder', Path::get('./config/gandf_builder.json'));

        $variants_array = [' - Select Variant - ' => ''];
        foreach (ProductFactory::getVariantTypes() as $type)
        {
            if (!in_array($type->name, $variants_array))
            {
                $variants_array[$type->name] = $type->name;
            }
        }

        $YpsProductArray = ['- Set Dynamic Content -' => ''];

        $TypeList = [];
        $YpsProductArray['StringTypeList'] = [];
        $YpsProductArray['ImageTypeList']  = [];
        
        if (class_exists('YpsApp\Source\Type\YpsProduct'))
        {
            // dd(YpsProduct::config());

            $TypeList = YpsProduct::config()['fields'];

            foreach (YpsProduct::config()['fields'] as $field_name => $field) {

                $group = (isset($field['metadata']['group'])) ? ' (' . $field['metadata']['group'] . ')' : '';
                // $YpsProductArray[$field['metadata']['label'] . $group] = $field_name;

                switch ($field_name) {

                    case 'title':
                    case 'subtitle':
                    case 'sku':
                    case 'stock':
                    case 'shipping_flat':
                    case 'baseprice_withtax':
                    case 'baseprice_withouttax':
                    case 'discount_formatted':
                    case 'price_after_discount':
                    case 'price_after_discount_withtax':
                    case 'category_name':
                    case 'author':
                    case 'short_desc':
                    case 'long_desc':
                    case 'item_id':
                        $YpsProductArray['StringTypeList'][$field['metadata']['label'] . $group] = $field_name;
                        break;

                    case 'short_desc':
                    case 'long_desc':
                        $YpsProductArray['TextTypeList'][$field['metadata']['label'] . $group]   = $field_name;
                        break;
                        
                    case 'image_intro':
                    case 'image_fulltext':
                        $YpsProductArray['ImageTypeList'][$field['metadata']['label'] . $group]  = $field_name;
                        break;

                }
            }
        }

        $filter_custom_fields = [' - Select Custom Field - ' => ''];
        $search_custom_fields = [];
        $result_custom_fields = [];
        $list_options         = '';
        if (JVERSION >= "4.0.0")
        {

            // dd(CustomFieldsHelper::getApprovedCustomFields());
            foreach (CustomFieldsHelper::getApprovedCustomFields() as $custom_field) {


                if (in_array($custom_field->type, [
                    'media'
                ])) {
                    $YpsProductArray['StringTypeList'][$custom_field->label . ' (Custom Field)'] = 'custom_field_' . $custom_field->id;
                }

                if (in_array($custom_field->type, [
                    'list',
                    'checkboxes',
                    'radio'
                ])) {
                    $YpsProductArray['StringTypeList'][$custom_field->label . ' (Custom Field)'] = 'custom_field_' . $custom_field->id;
                    $filter_custom_fields[$custom_field->label] = $custom_field->id;

                    if ($custom_field->type == 'list' || $custom_field->type == 'checkbox')
                    {
                        $list_options .= '';
                    }
                }
                
                if (in_array($custom_field->type, [
                    'text',
                    'textarea',
                    'editor'
                ])) {
                    $YpsProductArray['StringTypeList'][$custom_field->label . ' (Custom Field)'] = 'custom_field_' . $custom_field->id;
                    $search_custom_fields[$custom_field->label] = $custom_field->id;
                }
            }

        }

        // Categories
        $extension = "content";
        $options   = [
            'access'     => true,
            'published'  => 1,
            'countItems' => 1
        ];
        $categories = Categories::getInstance($extension, $options);

        $cat0 = $categories->get('root');
        $cats = $cat0->getChildren(true);


        // Tags
        $all_tags = [];
        foreach (ProductFactory::getAllTagsForParams() as $tag) {
            $all_tags[$tag->title] = $tag->id;
        }

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

        $options_array = [];
        foreach (ProductoptionFactory::getAll() as $option) {
            if ($option->title != '')
            {
                $options_array[$option->title] = $option->title;
            }
        }

        // Layouts and Sublayouts
        $exclude       = ['.svn', 'CVS', '.DS_Store', '__MACOSX', '.txt', '.phpNULL'];
        $excludeFilter = ['^\..*'];
        $path          = JPATH_SITE . '/plugins/system/commercelab_gridandfilter/modules/core/elements/';

        $filter_layouts_array = [];
        foreach (Folder::files($path . 'filter/templates/layout', '.', false, false, $exclude, $excludeFilter) as $file_name) {
            $file_name = str_replace('.php', '', $file_name);
            $filter_layouts_array[ucfirst($file_name)] = $file_name;
        }

        $filter_sublayouts_array = [];
        foreach (Folder::files($path . 'filter/templates/layout/sublayout', '.', false, false, $exclude, $excludeFilter) as $file_name) {
            $file_name = str_replace('.php', '', $file_name);
            $filter_sublayouts_array[ucfirst($file_name)] = $file_name;
        }
        
        $search_layouts_array = [];
        foreach (Folder::files($path . 'search/templates/layout', '.', false, false, $exclude, $excludeFilter) as $file_name) {
            $file_name = str_replace('.php', '', $file_name);
            $search_layouts_array[ucfirst($file_name)] = $file_name;
        }

        $search_sublayouts_array = [];
        foreach (Folder::files($path . 'search/templates/layout/sublayout', '.', false, false, $exclude, $excludeFilter) as $file_name) {
            $file_name = str_replace('.php', '', $file_name);
            $search_sublayouts_array[ucfirst($file_name)] = $file_name;
        }

        $grid_layouts_array = [];
        foreach (Folder::files($path . 'result/templates/layouts', '.', false, false, $exclude, $excludeFilter) as $file_name) {
            $file_name = str_replace('.php', '', $file_name);
            $grid_layouts_array[ucfirst($file_name)] = $file_name;
        }

        return [
            'gridandfilter' => [
                'filter' => [
                    'layouts'    => $filter_layouts_array,
                    'sublayouts' => $filter_sublayouts_array
                ],
                'searchbar' => [
                    'layouts'    => $search_layouts_array,
                    'sublayouts' => $search_sublayouts_array
                ],
                'joomla' => [
                    'categories'             => $categories_array,
                    'categories_object_list' => $cats,
                    'tags'                   => $all_tags,
                ],
                'products' => [
                    'variants'                   => $variants_array,
                    'variants_count'             => count($variants_array),
                    'options'                    => $options_array,
                    'options_count'              => count($options_array),
                    'filter_custom_fields'       => $filter_custom_fields,
                    'filter_custom_fields_count' => count($filter_custom_fields),
                    'search_custom_fields'       => $search_custom_fields,
                    'search_custom_fields_count' => count($search_custom_fields)
                ],
                'result' => [
                    'layouts' => $grid_layouts_array
                ],
                'ytp' => [
                    'types' => [
                        'YpsProduct' => [
                            'TypeList'       => $TypeList,
                            'StringTypeList' => $YpsProductArray['StringTypeList'],
                            'ImageTypeList'  => $YpsProductArray['ImageTypeList']
                        ]
                    ]
                ]
            ]
        ];
    }

];
