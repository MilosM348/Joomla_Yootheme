<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\de_AT;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('aon.at', 'chello.at', 'gmail.com', 'gmx.at', 'univie.ac.at');
    protected static $tld = array('at', 'co.at', 'com', 'net', 'org');
}
