<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\kk_KZ;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('mail.kz', 'yandex.kz', 'host.kz');
    protected static $tld = array('com', 'com', 'net', 'org', 'kz', 'kz', 'kz', 'kz');
}
