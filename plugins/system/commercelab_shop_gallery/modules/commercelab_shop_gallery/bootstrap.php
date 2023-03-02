<?php

namespace YpsApp_Gallery;

use YOOtheme\Builder;
use YOOtheme\Path;

return [

    'events' => [
        'source.init' => [
            Source\SourceListener::class => 'initSource',
        ],
    ],

    'extend' => [

        Builder::class => function (Builder $builder) {

            $builder->addTypePath(Path::get('./elements/*/element.json'));

        },

    ]

];
