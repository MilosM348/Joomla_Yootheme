<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\ne_NP;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '01-4######',
        '01-5######',
        '01-6######',
        '9841######',
        '9849######',
        '98510#####',
        '9803######',
        '9808######',
        '9813######',
        '9818######',
    );
}
