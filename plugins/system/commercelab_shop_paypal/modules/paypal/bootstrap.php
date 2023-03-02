<?php

namespace YpsApp_paypal;

use YOOtheme\Builder;
use YOOtheme\Path;

return [

    'extend' => [

        Builder::class => function (Builder $builder) {

            $builder->addTypePath(Path::get('./elements/*/element.json'));

        },

    ]

];
