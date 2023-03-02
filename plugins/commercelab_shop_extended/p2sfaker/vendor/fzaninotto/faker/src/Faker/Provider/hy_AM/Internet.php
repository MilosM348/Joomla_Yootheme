<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\hy_AM;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('gmail.com', 'yahoo.com', 'hotmail.com', 'yandex.ru', 'mail.ru', 'mail.am');
    protected static $tld = array('com', 'com', 'am', 'am', 'am', 'net', 'org', 'ru', 'am', 'am', 'am');
}
