<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\th_TH;

class Color extends \Faker\Provider\Color
{
    protected static $safeColorNames = array(
        'ขาว','ชมพู','ดำ','น้ำตาล','น้ำเงิน','ฟ้า','ม่วง','ส้ม','เขียว','เขียวอ่อน','เหลือง','แดง'
    );

    protected static $allColorNames = array(
         'กากี','ขาว','คราม','ชมพู','ดำ','ทอง','นาค','น้ำตาล',
         'น้ำเงิน','ฟ้า','ม่วง','ส้ม','เขียว','เขียวอ่อน',
         'เงิน','เทา','เหลือง','เหลืองอ่อน','แดง','่ขี้ม้า'
    );
}
