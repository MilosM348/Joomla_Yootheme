<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\en_IN;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('gmail.com', 'yahoo.com', 'hotmail.com', 'yahoo.co.in', 'rediffmail.com');
    protected static $tld = array('com', 'com', 'com', 'com', 'com', 'com', 'in', 'in', 'in', 'ac.in', 'net', 'org', 'co.in');
}
