<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\lt_LT;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '86#######',
        '8 6## #####',
        '+370 6## ## ###',
        '+3706#######',
        '(8 5) ### ####',
        '+370 5 ### ####',
        '+370 46 ## ## ##',
        '(8 46) ## ## ##',
    );
}
