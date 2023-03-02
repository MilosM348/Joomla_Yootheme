<?php

namespace YpsApp\Source\CustomFieldsTypes;

use function YOOtheme\trans;

class ChoiceFieldStringType
{
    /**
     * @return array
     */
    public static function config()
    {
        $field = [
            'type' => 'String',
            'args' => [
                'separator' => [
                    'type' => 'String',
                ],
            ],
            'metadata' => [
                'arguments' => [
                    'separator' => [
                        'label' => trans('Separator'),
                        'description' => trans('Set the separator between fields.'),
                        'default' => ', ',
                    ],
                ],
            ],
            'extensions' => [
                'call' => __CLASS__ . '::resolve',
            ],
        ];

        return [
            'fields' => [
                'name' => array_merge_recursive($field, [
                    'metadata' => [
                        'label' => trans('Names'),
                    ],
                ]),

                'value' => array_merge_recursive($field, [
                    'metadata' => [
                        'label' => trans('Values'),
                    ],
                ]),
            ],
        ];
    }

    public static function resolve($item, $args, $context, $info)
    {
        $args += ['separator' => ', '];

        return join($args['separator'], array_column($item, $info->fieldName));
    }
}
