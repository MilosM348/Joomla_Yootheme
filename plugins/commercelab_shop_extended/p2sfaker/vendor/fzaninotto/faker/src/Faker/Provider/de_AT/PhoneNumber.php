<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\de_AT;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '0650 #######',
        '0660 #######',
        '0664 #######',
        '0676 #######',
        '0677 #######',
        '0678 #######',
        '0699 #######',
        '0680 #######',
        '+43 #### ####',
        '+43 #### ####-##',
    );
}
