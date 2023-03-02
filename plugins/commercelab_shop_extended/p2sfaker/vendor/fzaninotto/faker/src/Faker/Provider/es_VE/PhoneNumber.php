<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\es_VE;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $formats = array(
        '+58 2## ### ####',
        '+58 2## #######',
        '+58 2#########',
        '+58 2##-###-####',
        '+58 2##-#######',
        '2## ### ####',
        '2## #######',
        '2#########',
        '2##-###-####',
        '2##-#######',
        '+58 4## ### ####',
        '+58 4## #######',
        '+58 4#########',
        '+58 4##-###-####',
        '+58 4##-#######',
        '4## ### ####',
        '4## #######',
        '4#########',
        '4##-###-####',
        '4##-#######',
    );
}
