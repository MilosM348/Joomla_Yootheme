<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\en_HK;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array(
        'gmail.com', 'yahoo.com', 'hotmail.com', 'yahoo.com.hk', 'hotmail.com.hk'
    );
    protected static $tld = array(
        'com', 'com', 'com', 'com.hk', 'com.hk', 'com', 'biz', 'info', 'net', 'org',
        'com.hk', 'edu.hk', 'org.hk', 'idv.hk'
    );
}
