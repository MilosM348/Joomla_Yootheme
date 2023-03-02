<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\bn_BD;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{companyName}} {{companyType}}'
    );

    protected static $names = array(
        'রহিম', 'করিম', 'বাবলু'
    );

    protected static $types = array(
        'সিমেন্ট', 'সার', 'ঢেউটিন'
    );

    public static function companyType()
    {
        return static::randomElement(static::$types);
    }

    public static function companyName()
    {
        return static::randomElement(static::$names);
    }
}
