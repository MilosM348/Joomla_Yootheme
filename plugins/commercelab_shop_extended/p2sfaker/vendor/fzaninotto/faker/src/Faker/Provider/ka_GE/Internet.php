<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\ka_GE;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array(
        'posta.ge', 'boom.ge', 'hotmail.com', 'gmail.com', 'yahoo.com', 'mail.ru', 'avoe.ge'
    );

    protected static $tld = array(
        'ge', 'ge', 'ge', 'ge', 'ge', 'com.ge', 'edu.ge', 'net.ge', 'org.ge',
        'pvt.ge', 'gov.ge', 'mil.ge', 'com', 'biz', 'info', 'net', 'org'
    );
}
