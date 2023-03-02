<?php

namespace YpsApp\Source\Type;

use YOOtheme\Builder\Joomla\Source\ArticleHelper;
use function YOOtheme\trans;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Product\Product;

class YpsCustomProductsQueryType
{
    public static function config()
    {
        return [

            'fields' => [
                'cslCustomProducts' => [
                    'type' => [
                        'listOf' => 'YpsProduct',
                    ],

                    'args' => [
                        'catid' => [
                            'type' => [
                                'listOf' => 'String',
                            ],
                        ],
                        'cat_operator' => [
                            'type' => 'String',
                        ],
                        'tags' => [
                            'type' => [
                                'listOf' => 'String',
                            ],
                        ],
                        'tag_operator' => [
                            'type' => 'String',
                        ],
                        'users' => [
                            'type' => [
                                'listOf' => 'String',
                            ],
                        ],
                        'users_operator' => [
                            'type' => 'String',
                        ],
                        'featured' => [
                            'type' => 'Boolean',
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
                        'label' => trans('Custom Products'),
                        'group' => 'CommerceLab Shop',
                        // 'view' => ['com_content.category', 'com_content.featured'],
                        'fields' => [
                            'catid' => [
                                'label' => trans('Filter by Categories'),
                                'type' => 'select',
                                'default' => [],
                                'options' => [['evaluate' => 'config.categories']],
                                'attrs' => [
                                    'multiple' => true,
                                    'class' => 'uk-height-small',
                                ],
                            ],
                            'cat_operator' => [
                                'description' => trans(
                                    'Filter articles by categories. Use the <kbd>shift</kbd> or <kbd>ctrl/cmd</kbd> key to select multiple categories. Set the logical operator to match or not match the selected categories.'
                                ),
                                'type' => 'select',
                                'default' => 'IN',
                                'options' => [
                                    trans('Match (OR)') => 'IN',
                                    trans('Don\'t Match (NOR)') => 'NOT IN',
                                ],
                            ],
                            'tags' => [
                                'label' => trans('Filter by Tags'),
                                'type' => 'select',
                                'default' => [],
                                'options' => [['evaluate' => 'config.tags']],
                                'attrs' => [
                                    'multiple' => true,
                                    'class' => 'uk-height-small',
                                ],
                            ],
                            'tag_operator' => [
                                'description' => trans(
                                    'Filter articles by tags. Use the <kbd>shift</kbd> or <kbd>ctrl/cmd</kbd> key to select multiple tags. Set the logical operator to match at least one of the tags, none of the tags or all tags.'
                                ),
                                'type' => 'select',
                                'default' => 'IN',
                                'options' => [
                                    trans('Match One (OR)') => 'IN',
                                    trans('Match All (AND)') => 'AND',
                                    trans('Don\'t Match (NOR)') => 'NOT IN',
                                ],
                            ],
                            'users' => [
                                'label' => trans('Filter by Users'),
                                'type' => 'select',
                                'default' => [],
                                'options' => [['evaluate' => 'config.users']],
                                'attrs' => [
                                    'multiple' => true,
                                    'class' => 'uk-height-small',
                                ],
                            ],
                            'users_operator' => [
                                'description' => trans(
                                    'Filter articles by users. Use the <kbd>shift</kbd> or <kbd>ctrl/cmd</kbd> key to select multiple users. Set the logical operator to match or not match the selected users.'
                                ),
                                'type' => 'select',
                                'default' => 'IN',
                                'options' => [
                                    trans('Match (OR)') => 'IN',
                                    trans('Don\'t Match (NOR)') => 'NOT IN',
                                ],
                            ],
                            'featured' => [
                                'label' => trans('Limit by Featured Articles'),
                                'type' => 'checkbox',
                                'text' => trans('Load featured articles only'),
                            ],
                            '_offset' => [
                                'description' => trans(
                                    'Set the starting point and limit the number of articles.'
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
                                        'type' => 'number',
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

        $articles = ArticleHelper::query($args);


        $products = [];
        foreach($articles as $item) {
            if (ProductFactory::get($item->id) !== null) {
                $products[] = $item;
            }
        }

        if (!count($products)) {
            return;
        }

        return $products;

    }
}