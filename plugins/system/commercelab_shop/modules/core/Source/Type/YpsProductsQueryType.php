<?php

namespace YpsApp\Source\Type;

use Joomla\CMS\Language\Text;
use CommerceLabShop\Language\LanguageFactory;

use function YOOtheme\trans;

use CommerceLabShop\Product\ProductFactory;

class YpsProductsQueryType
{
    public static function config()
    {
        return [

            'fields' => [
                'cslProducts' => [
                    'type' => [
                        'listOf' => 'YpsProduct',
                    ],
                    'args' => [
                        'offset' => [
                            'type' => 'Int',
                        ],
                        'limit' => [
                            'type' => 'Int',
                        ],
                    ],
                    'metadata' => [
                        'label' => trans('Products'),
                        'group' => 'CommerceLab Shop',
                        'view' => ['com_content.category', 'com_content.featured'],
                        'fields' => [
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
                                        'attrs' => [
                                            'placeholder' => trans('No limit'),
                                            'min' => 0,
                                        ],
                                    ],
                                ],
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
        $args += [
            'offset' => 0,
            'limit' => null,
        ];

        if (isset($root['items']) && count($root['items'])) {

            $items = $raw_articles = [];
            foreach($root['items'] as $item) {
                if (ProductFactory::get($item->id) !== null) {
                    $items[] = $item;
                } else {
                    $raw_articles[] = $item;
                }
            }

            if (count($raw_articles)) {
                $article_links = '';
                foreach ($raw_articles as $article) {
                    $article_links .= '<br><a href="administrator/index.php?option=com_content&view=article&layout=edit&id=' . $article->id . '" target="_blank">' . $article->title . '</a>';
                }
                \Joomla\CMS\Factory::getApplication()
                    ->enqueueMessage(
                        trans('There is a problem with items in this category, only CommerceLab products are allowed, you need to remove, unpblish or turn On the CLS product integration for the following Joomla article(s) in order to avoid YOOtheme Pro conflicts' . $article_links), 
                        'danger'
                    );
                new \ExceptionError;
            }

            if ($args['offset'] || $args['limit']) {
                $items = array_slice($items, (int) $args['offset'], (int) $args['limit'] ?: null);
            }

            return $items;
        }
    }
}