<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\en_UG;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '+256 7## ### ###',
        '+2567########',
        '+256 4## ### ###',
        '+2564########',
        '07## ### ###',
        '07########',
        '04## ### ###',
        '04########'
    );
}
