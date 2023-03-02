<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\lv_LV;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('mail.lv','apollo.lv','inbox.lv','gmail.com', 'yahoo.com', 'hotmail.com');
    protected static $tld = array('com', 'com', 'net', 'org', 'lv', 'lv', 'lv', 'lv');
}
