<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\zh_TW;

class Internet extends \Faker\Provider\Internet
{
    public function userName()
    {
        return \Faker\Factory::create('en_US')->userName();
    }

    public function domainWord()
    {
        return \Faker\Factory::create('en_US')->domainWord();
    }
}
