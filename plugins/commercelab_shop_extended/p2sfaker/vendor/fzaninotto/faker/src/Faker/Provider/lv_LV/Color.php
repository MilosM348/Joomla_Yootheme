<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\lv_LV;

class Color extends \Faker\Provider\Color
{
    protected static $safeColorNames = array(

        'balts', 'melns', 'sarkans', 'zaļš', 'dzeltens', 'zils',
        'brūns', 'purpurs', 'rozā', 'oranžs', 'pelēks'

    );

    protected static $allColorNames = array(
        'bēšs', 'palss šatens', 'bordo', 'marengo', 'mēļš', 'sirms', 'ruds', 'rūsgans',
        'ābolains', 'bērs', 'dūkans', 'loss', 'pāts', 'salns',
        'zelts', 'sudrabs', 'varš', 'bronza', 'zeltains', 'subrabains'
    );
}
