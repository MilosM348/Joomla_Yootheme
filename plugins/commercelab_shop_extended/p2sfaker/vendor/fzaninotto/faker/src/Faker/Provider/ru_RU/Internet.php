<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\ru_RU;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('yandex.ru', 'ya.ru', 'narod.ru', 'gmail.com', 'mail.ru', 'list.ru', 'bk.ru', 'inbox.ru', 'rambler.ru', 'hotmail.com');
    protected static $tld = array('com', 'com', 'net', 'org', 'ru', 'ru', 'ru', 'ru');
}
