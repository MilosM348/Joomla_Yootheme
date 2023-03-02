<?php

namespace YpsApp\Source\Type;

use YOOtheme\Builder\Joomla\Source\ArticleHelper;
use function YOOtheme\trans;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Product\Product;

class YpsCustomProductQueryType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'cslCustomProduct' => [
                    'type' => 'YpsProduct',

                    'args' => [
                        'id' => [
                            'type' => 'String',
                        ],
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
                        'label' => trans('Custom Product'),
                        'group' => 'CommerceLab Shop',
                        // 'group' => 'Custom',
                        'fields' => [
                            'id' => [
                                'label' => trans('Select Manually'),
                                'description' => trans(
                                    'Pick an article manually or use filter options to specify which article should be loaded dynamically.'
                                ),
                                'type' => 'select-item',
                                'labels' => ['type' => 'Article'],
                            ],
                            'catid' => [
                                'label' => trans('Filter by Categories'),
                                'type' => 'select',
                                'default' => [],
                                'options' => [['evaluate' => 'config.categories']],
                                'attrs' => [
                                    'multiple' => true,
                                    'class' => 'uk-height-small',
                                ],
                                'enable' => '!id',
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
                                'enable' => '!id',
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
                                'enable' => '!id',
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
                                'enable' => '!id',
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
                                'enable' => '!id',
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
                                'enable' => '!id',
                            ],
                            'featured' => [
                                'label' => trans('Limit by Featured Articles'),
                                'type' => 'checkbox',
                                'text' => trans('Load featured articles only'),
                                'enable' => '!id',
                            ],
                            'offset' => [
                                'label' => trans('Start'),
                                'description' => trans(
                                    'Set the starting point to specify which article is loaded.'
                                ),
                                'type' => 'number',
                                'default' => 0,
                                'modifier' => 1,
                                'attrs' => [
                                    'min' => 1,
                                    'required' => true,
                                ],
                                'enable' => '!id',
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
                                        'enable' => '!id',
                                    ],
                                    'order_direction' => [
                                        'label' => trans('Direction'),
                                        'type' => 'select',
                                        'default' => 'DESC',
                                        'options' => [
                                            trans('Ascending') => 'ASC',
                                            trans('Descending') => 'DESC',
                                        ],
                                        'enable' => '!id',
                                    ],
                                ],
                            ],
                            'order_alphanum' => [
                                'text' => trans('Alphanumeric Ordering'),
                                'type' => 'checkbox',
                                'enable' => '!id',
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
        $args += ['id' => 0, 'limit' => 1];

        if (!empty($args['id'])) {
            $articles = ArticleHelper::get($args['id']);
        } else {
            $articles = ArticleHelper::query($args);
        }

        return array_shift($articles);
    }
}