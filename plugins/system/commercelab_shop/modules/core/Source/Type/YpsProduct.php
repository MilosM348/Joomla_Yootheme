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

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Customfield\CustomFieldsHelper;


class YpsProduct
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
            'subtitle' => [
                'type' => 'String',
                'label' => 'Subtitle',
                'group' => 'Basic',
                'property_name' => 'subtitle'
            ],
            'item_link' => [
                'type' => 'String',
                'label' => 'Link',
                'group' => 'Basic',
                'property_name' => 'link'
            ],
            'sku' => [
                'type' => 'String',
                'label' => 'Sku',
                'group' => 'Basic',
                'property_name' => 'sku'
            ],
            'stock' => [
                'type' => 'String',
                'label' => 'Stock',
                'group' => 'Basic',
                'property_name' => 'stock',
            ],
            'shipping_flat' => [
                'type' => 'String',
                'label' => 'Flat Shipping',
                'group' => 'Basic',
                'property_name' => 'flatfeeFloat_formatted',
            ],

            // Price

            'baseprice_withtax' => [
                'type' => 'String',
                'label' => 'Price with Tax',
                'group' => 'Price',
                'property_name' => 'base_priceWithTax_formatted',
            ],
            'baseprice_withouttax' => [
                'type' => 'String',
                'label' => 'Price without Tax',
                'group' => 'Price',
                'property_name' => 'base_priceWithoutTax_formatted',
            ],
            
            'discount_formatted' => [
                'type' => 'String',
                'label' => 'Discount',
                'group' => 'Price',
                'property_name' => 'discount_formatted',
            ],
            'price_after_discount' => [
                'type' => 'String',
                'label' => 'Price After Discount without Tax',
                'group' => 'Price',
                'property_name' => 'priceAfterDiscountWithoutTax_formatted',
            ],
            'price_after_discount_withtax' => [
                'type' => 'String',
                'label' => 'Price After Discount with Tax',
                'group' => 'Price',
                'property_name' => 'priceAfterDiscountWithTax_formatted',
            ],

            // Raw Price
            'raw_base_price' => [
                'type' => 'String',
                'label' => 'Base Price',
                'group' => 'Price Without Currency',
                'property_name' => 'basepriceFloat'
            ],

            'raw_baseprice_withtax' => [
                'type' => 'String',
                'label' => 'Price with Tax',
                'group' => 'Price Without Currency',
                'property_name' => 'base_priceWithTaxFloat',
            ],
            'raw_baseprice_withouttax' => [
                'type' => 'String',
                'label' => 'Price without Tax',
                'group' => 'Price Without Currency',
                'property_name' => 'base_priceWithoutTaxFloat',
            ],

            'raw_discount' => [
                'type' => 'String',
                'label' => 'Discount',
                'group' => 'Price Without Currency',
                'property_name' => 'discountFloat',
            ],
            'raw_price_after_discount' => [
                'type' => 'String',
                'label' => 'Price After Discount without Tax',
                'group' => 'Price Without Currency',
                'property_name' => 'priceAfterDiscountWithoutTaxFloat',
            ],
            'raw_price_after_discount_withtax' => [
                'type' => 'String',
                'label' => 'Price After Discount with Tax',
                'group' => 'Price Without Currency',
                'property_name' => 'priceAfterDiscountWithTaxFloat',
            ],

            // Category
            'category_name' => [
                'type' => 'String',
                'label' => 'Name',
                'group' => 'Category',
                'property_name' => 'categoryName'
            ],
            'category_link' => [
                'type' => 'String',
                'label' => 'Link',
                'group' => 'Category',
                'property_name' => 'category_link'
            ],

            // Content
            'short_desc' => [
                'type' => 'String',
                'label' => 'Short Description',
                'group' => 'Content',
                'property_name' => 'short_desc',
                'metadata' => [
                    'filters' => ['limit'],
                ]
            ],
            'long_desc' => [
                'type' => 'String',
                'label' => 'Long Description',
                'group' => 'Content',
                'property_name' => 'long_desc',
                'metadata' => [
                    'filters' => ['limit'],
                ]
            ],


            // Media
            'image_intro' => [
                'type' => 'String',
                'label' => 'Intro Image',
                'group' => 'Media',
                'property_name' => 'teaserImagePath',
            ],
            'image_fulltext' => [
                'type' => 'String',
                'label' => 'Full Image',
                'group' => 'Media',
                'property_name' => 'fullImagePath',
            ],

            // Author
            'author' => [
                'type' => 'String',
                'label' => 'Alias',
                'group' => 'Author',
                'property_name' => 'created_by_alias'
            ],
            // 'author' => [
            //     'type' => 'String',
            //     'label' => 'Username',
            //     'group' => 'Author',
            //     'property_name' => 'created_by_username'
            // ],
            // 'author_email' => [
            //     'type' => 'String',
            //     'label' => 'Name',
            //     'group' => 'Author',
            //     'property_name' => 'created_by_email'
            // ],

            // System
            'author_id' => [
                'type' => 'String',
                'label' => 'Author Id',
                'group' => 'System',
                'property_name' => 'created_by'
            ],
            'category_id' => [
                'type' => 'String',
                'label' => 'Category Id',
                'group' => 'System',
                'property_name' => 'catid'
            ],
            'item_id' => [
                'type' => 'String',
                'label' => 'Product Id',
                'group' => 'System',
                'property_name' => 'id'
            ],
            'modified' => [
                'type' => 'String',
                'label' => 'Modified Date',
                'group' => 'System',
                'property_name' => 'modified'
            ],
            'created' => [
                'type' => 'String',
                'label' => 'Created Date',
                'group' => 'System',
                'property_name' => 'created'
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

        $fieldsArray['tagString'] = [
            'type' => 'String',
            'args' => [
                'parent_id' => [
                    'type' => 'String',
                ],
                'separator' => [
                    'type' => 'String',
                ],
                'show_link' => [
                    'type' => 'Boolean',
                ],
                'link_style' => [
                    'type' => 'String',
                ],
            ],
            'metadata' => [
                'label' => trans('Tags'),
                'arguments' => [
                    'parent_id' => [
                        'label' => trans('Parent Tag'),
                        'description' => trans(
                            'Tags are only loaded from the selected parent tag.'
                        ),
                        'type' => 'select',
                        'default' => '0',
                        'options' => [
                            ['value' => '0', 'text' => 'Root'],
                            ['evaluate' => 'config.tags'],
                        ],
                    ],
                    'separator' => [
                        'label' => trans('Separator'),
                        'description' => trans('Set the separator between tags.'),
                        'default' => ', ',
                    ],
                    'show_link' => [
                        'label' => trans('Link'),
                        'type' => 'checkbox',
                        'default' => true,
                        'text' => trans('Show link'),
                    ],
                    'link_style' => [
                        'label' => trans('Link Style'),
                        'description' => trans('Set the link style.'),
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Muted' => 'link-muted',
                            'Text' => 'link-text',
                            'Heading' => 'link-heading',
                            'Reset' => 'link-reset',
                        ],
                        'enable' => 'arguments.show_link',
                    ],
                ],
            ],
            'extensions' => [
                'call' => __CLASS__ . '::tagString',
            ],
        ];
        $fieldsArray['tags'] = [
            'type' => [
                'listOf' => 'Tag',
            ],
            'args' => [
                'parent_id' => [
                    'type' => 'String',
                ],
            ],
            'metadata' => [
                'label' => trans('Tags'),
                'arguments' => [
                    'parent_id' => [
                        'label' => trans('Parent Tag'),
                        'description' => trans(
                            'Tags are only loaded from the selected parent tag.'
                        ),
                        'type' => 'select',
                        'default' => '0',
                        'options' => [
                            ['value' => '0', 'text' => 'Root'],
                            ['evaluate' => 'config.tags'],
                        ],
                    ],
                ],
            ],
            'extensions' => [
                'call' => __CLASS__ . '::tags',
            ],
        ];

        $fieldsArray['relatedProducts'] = [
            'type' => ['listOf' => 'YpsProduct'],
            'args' => [
                'category' => [
                    'type' => 'String',
                ],
                'tags' => [
                    'type' => 'String',
                ],
                'author' => [
                    'type' => 'String',
                ],
                'offset' => [
                    'type' => 'Int',
                ],
                'limit' => [
                    'type' => 'Int',
                ],
                'order' => [
                    'type' => 'String',
                ],
                'order_direction' => [
                    'type' => 'String',
                ],
                'order_alphanum' => [
                    'type' => 'Boolean',
                ],
            ],
            'metadata' => [
                'label' => trans('Related Products'),
                'arguments' => [
                    'category' => [
                        'label' => trans('Relationship'),
                        'type' => 'select',
                        'default' => 'IN',
                        'options' => [
                            trans('Ignore Category') => '',
                            trans('Match Category (OR)') => 'IN',
                            trans('Don\'t Match Category (NOR)') => 'NOT IN',
                        ],
                    ],
                    'tags' => [
                        'type' => 'select',
                        'options' => [
                            trans('Ignore Tags') => '',
                            trans('Match One Tag (OR)') => 'IN',
                            trans('Match All Tags (AND)') => 'AND',
                            trans('Don\'t Match Tags (NOR)') => 'NOT IN',
                        ],
                    ],
                    'author' => [
                        'description' => trans(
                            'Set the logical operators for how the product relate to category, tags and author. Choose between matching at least one term, all terms or none of the terms.'
                        ),
                        'type' => 'select',
                        'options' => [
                            trans('Ignore Author') => '',
                            trans('Match Author (OR)') => 'IN',
                            trans('Don\'t Match Author (NOR)') => 'NOT IN',
                        ],
                    ],
                    '_offset' => [
                        'description' => trans(
                            'Set the starting point and limit the number of products.'
                        ),
                        'type' => 'grid',
                        'width' => '1-2',
                        'fields' => [
                            'offset' => [
                                'label' => trans('Start'),
                                'type' => 'number',
                                'default' => 0,
                                'modifier' => 1,
                                'attrs' => [
                                    'min' => 1,
                                    'required' => true,
                                ],
                            ],
                            'limit' => [
                                'label' => trans('Quantity'),
                                'type' => 'limit',
                                'default' => 10,
                                'attrs' => [
                                    'min' => 1,
                                ],
                            ],
                        ],
                    ],
                    '_order' => [
                        'type' => 'grid',
                        'width' => '1-2',
                        'fields' => [
                            'order' => [
                                'label' => trans('Order'),
                                'type' => 'select',
                                'default' => 'publish_up',
                                'options' => [
                                    ['evaluate' => 'config.sources.articleOrderOptions'],
                                ],
                            ],
                            'order_direction' => [
                                'label' => trans('Direction'),
                                'type' => 'select',
                                'default' => 'DESC',
                                'options' => [
                                    trans('Ascending') => 'ASC',
                                    trans('Descending') => 'DESC',
                                ],
                            ],
                        ],
                    ],
                    'order_alphanum' => [
                        'text' => trans('Alphanumeric Ordering'),
                        'type' => 'checkbox',
                    ],
                ],
                'directives' => [],
            ],
            'extensions' => [
                'call' => __CLASS__ . '::relatedProducts',
            ]
        ];

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
        $product       = ProductFactory::get($item->id);

        if ($product) {
            switch($property_name)
            {
                case 'link':
                    $value = RouteHelper::getArticleRoute($item->id, $item->catid, $item->language);
                    break;

                case 'stock':
                    if (!$product->manage_stock) {
                        $value = null;
                    } else {
                        $value = '<span class="stock-in-product-dyncon">' . self::getUpdatedStock($product) . '<span>';
                    }
                    break;

                // case 'discount':
                // case 'priceAfterDiscount':
                // case 'priceAfterDiscountWithTax':
                // case 'discount_formatted':
                // case 'priceAfterDiscount_formatted':
                // case 'priceAfterDiscountWithTax_formatted':
                // case 'discountFloat':
                // case 'priceAfterDiscountFloat':
                // case 'priceAfterDiscountWithTaxFloat':
                //     $value = $product->$property_name;
                //     if (!$product->discount)
                //     {
                //         $value = null;
                //     }
                //     break;

                default:
                    $value = $product->$property_name;
                    break;
            }
            return $value;
        }
    }

    public static function relatedProducts($article, array $args)
    {
        $args['article'] = $article->id;
        $args['article_operator'] = 'NOT IN';

        if (!empty($args['category'])) {
            $args['cat_operator'] = $args['category'];
            $args['catid'] = $article->catid;
        }

        if (!empty($args['tags'])) {
            $args['tag_operator'] = $args['tags'];
            $args['tags'] = array_column(static::tags($article, []), 'id');
        }

        if (!empty($args['author'])) {
            $args['users'] = $article->created_by;
            $args['users_operator'] = $args['author'];
        }

        return ArticleHelper::query($args);
    }

    public static function tagString($article, array $args)
    {
        $tags = static::tags($article, $args);
        $args += ['separator' => ', ', 'show_link' => true, 'link_style' => ''];

        return app(View::class)->render(Path::get('../../templates/tags'), compact('tags', 'args'));
    }

    public static function tags($article, $args)
    {
        if (!isset($article->tags)) {
            $tags = (new TagsHelper())->getItemTags('com_content.article', $article->id);
        } else {
            $tags = $article->tags->itemTags;
        }

        if (!empty($args['parent_id'])) {
            return TagHelper::filterTags($tags, $args['parent_id']);
        }

        return $tags;
    }

}