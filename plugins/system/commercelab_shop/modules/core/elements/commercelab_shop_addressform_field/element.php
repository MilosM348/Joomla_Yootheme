<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

use YOOtheme\Str;

return [
    'transforms' => [
        'render' => function ($node, $params) {

            // // Prevent Loading if no producst in cart
            // if (!CheckoutFactory::validationStatus()) {
            //     return false;
            // }
            // $node->props['required_status'] = 2;
            // $node->props['isValidStatus']   = ($node->props['required_status'] <= CheckoutFactory::validationStatus());



            // dd($node);
            // return $node->props['field_type'];
            // // Display
            // foreach (['image', 'link'] as $key) {
            //     if (!$params['parent']->props["show_{$key}"]) {
            //         $node->props[$key] = '';
            //         if ($key === 'image') {
            //             $node->props['icon'] = '';
            //         }
            //     }
            // }

            // // Don't render element if content fields are empty
            // return Str::length($node->props['content']) ||
            //     $node->props['image'] ||
            //     $node->props['icon'];
        },
    ],
];
