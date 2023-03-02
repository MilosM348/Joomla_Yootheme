<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\ar_SA;

class Address extends \Faker\Provider\Address
{
    protected static $streetPrefix = array('شارع', 'طريق', 'ممر');

    /**
     * @link https://ar.wikipedia.org/wiki/%D9%82%D8%A7%D8%A6%D9%85%D8%A9_%D9%85%D8%AF%D9%86_%D8%A7%D9%84%D8%B3%D8%B9%D9%88%D8%AF%D9%8A%D8%A9
     */
    protected static $cityName = array(
        'الرياض', 'جدة', 'مكة', 'المدينة المنورة', 'تبوك', 'الدمام', 'الأحساء', 'القطيف', 'خميس مشيط', 'المظيلف', 'الهفوف',
        'المبرز', 'الطائف', 'نجران', 'حفر الباطن', 'الجبيل', 'ضباء', 'الخرج', 'الثقبة', 'ينبع البحر', 'الخبر', 'عرعر', 'الحوية',
        'عنيزة', 'سكاكا', 'جيزان', 'القريات', 'الظهران', 'الزلفي', 'الباحة', 'الرس', 'وادي الدواسر', 'بيشة', 'سيهات', 'شرورة',
        'الدوادمي', 'الأفلاج',
    );

    /**
     * @link https://ar.wikipedia.org/wiki/%D8%A7%D9%84%D8%AA%D9%82%D8%B3%D9%8A%D9%85_%D8%A7%D9%84%D8%A5%D8%AF%D8%A7%D8%B1%D9%8A_%D9%84%D9%84%D9%85%D9%85%D9%84%D9%83%D8%A9_%D8%A7%D9%84%D8%B9%D8%B1%D8%A8%D9%8A%D8%A9_%D8%A7%D9%84%D8%B3%D8%B9%D9%88%D8%AF%D9%8A%D8%A9
     */
    protected static $subdivisions = array(
        'منطقة الرياض', 'منطقة القصيم',
        'منطقة مكة المكرمة', 'منطقة المدينة المنورة',
        'منطقة حائل', 'منطقة الجوف', 'منطقة تبوك', 'منطقة الحدود الشمالية',
        'منطقة عسير', 'منطقة جازان', 'منطقة نجران', 'منطقة الباحة',
        'المنطقة الشرقية',
    );

    /**
     * @link https://ar.wikipedia.org/wiki/%D9%82%D8%A7%D8%A6%D9%85%D8%A9_%D9%85%D8%AD%D8%A7%D9%81%D8%B8%D8%A7%D8%AA_%D8%A7%D9%84%D8%B3%D8%B9%D9%88%D8%AF%D9%8A%D8%A9
     */
    protected static $governorates = array(
        'الرياض', 'الدرعية', 'الخرج', 'الدوادمي', 'المجمعة', 'القويعية', 'الأفلاج', 'وادي الدواسر', 'الزلفي', 'شقراء', 'حوطة بني تميم', 'عفيف', 'الغاط', 'السليل', 'ضرما', 'المزاحمية', 'رماح', 'ثادق', 'حريملاء', 'الحريق', 'مرات',
        'مكة المكرمة', 'جدة', 'الطائف', 'القنفذة', 'الليث', 'رابغ', 'خليص', 'الخرمة', 'رنية', 'تربة', 'الجموم', 'الكامل', 'المويه', 'ميسان', 'أضم', 'العرضيات', 'بحرة',
        'المدينة المنورة', 'ينبع', 'العلا', 'مهد الذهب', 'الحناكية', 'بدر', 'خيبر', 'العيص', 'وادي الفرع',
        'بريدة', 'عنيزة', 'الرس', 'المذنب', 'البكيرية', 'البدائع', 'الأسياح', 'النبهانية', 'الشماسية', 'عيون الجواء', 'رياض الخبراء', 'عقلة الصقور', 'ضرية',
        'الدمام', 'الأحساء', 'حفر الباطن', 'الجبيل', 'القطيف', 'الخبر', 'الخفجي', 'رأس تنورة', 'بقيق', 'النعيرية', 'قرية العليا', 'العديد',
        'أبها', 'خميس مشيط', 'بيشة', 'النماص', 'محايل عسير', 'ظهران الجنوب', 'تثليث', 'سراة عبيدة', 'رجال ألمع', 'بلقرن', 'أحد رفيدة', 'المجاردة', 'البرك', 'بارق', 'تنومة', 'طريب',
        'تبوك', 'الوجه', 'ضبا', 'تيماء', 'أملج', 'حقل', 'البدع',
        'حائل', 'بقعاء', 'الغزالة', 'الشنان', 'الحائط', 'السليمي', 'الشملي', 'موقق', 'سميراء',
        'عرعر', 'رفحاء', 'طريف', 'العويقيلة',
        'جازان', 'صبيا', 'أبو عريش', 'صامطة', 'بيش', 'الدرب', 'الحرث', 'ضمد', 'الريث', 'جزر فرسان', 'الدائر', 'العارضة', 'أحد المسارحة', 'العيدابي', 'فيفاء', 'الطوال', 'هروب',
        'نجران', 'شرورة', 'حبونا', 'بدر الجنوب', 'يدمه', 'ثار', 'خباش', 'الخرخير',
        'الباحة', 'بلجرشي', 'المندق', 'المخواة', 'قلوة', 'العقيق', 'القرى', 'غامد الزناد', 'الحجرة', 'بني حسن',
        'سكاكا', 'القريات', 'دومة الجندل', 'طبرجل'
    );

    protected static $buildingNumber = array('#####', '####', '##');

    protected static $postcode = array('#####', '#####-####');

    /**
     * @link http://www.nationsonline.org/oneworld/countrynames_arabic.htm
     */
    protected static $country = array(
        'الكاريبي', 'أمريكا الوسطى', 'أنتيجوا وبربودا', 'أنجولا', 'أنجويلا', 'أندورا', 'اندونيسيا', 'أورجواي', 'أوروبا', 'أوزبكستان', 'أوغندا', 'أوقيانوسيا', 'أوقيانوسيا النائية', 'أوكرانيا', 'ايران', 'أيرلندا', 'أيسلندا', 'ايطاليا',
        'بابوا غينيا الجديدة', 'باراجواي', 'باكستان', 'بالاو', 'بتسوانا', 'بتكايرن', 'بربادوس', 'برمودا', 'بروناي', 'بلجيكا', 'بلغاريا', 'بليز', 'بنجلاديش', 'بنما', 'بنين', 'بوتان', 'بورتوريكو', 'بوركينا فاسو', 'بوروندي', 'بولندا', 'بوليفيا', 'بولينيزيا', 'بولينيزيا الفرنسية', 'بيرو',
        'تانزانيا', 'تايلند', 'تايوان', 'تركمانستان', 'تركيا', 'ترينيداد وتوباغو', 'تشاد', 'توجو', 'توفالو', 'توكيلو', 'تونجا', 'تونس', 'تيمور الشرقية',
        'جامايكا', 'جبل طارق', 'جرينادا', 'جرينلاند', 'جزر الأنتيل الهولندية', 'جزر الترك وجايكوس', 'جزر القمر', 'جزر الكايمن', 'جزر المارشال', 'جزر الملديف', 'جزر الولايات المتحدة البعيدة الصغيرة', 'جزر أولان', 'جزر سليمان', 'جزر فارو', 'جزر فرجين الأمريكية', 'جزر فرجين البريطانية', 'جزر فوكلاند', 'جزر كوك', 'جزر كوكوس', 'جزر ماريانا الشمالية', 'جزر والس وفوتونا', 'جزيرة الكريسماس', 'جزيرة بوفيه', 'جزيرة مان', 'جزيرة نورفوك', 'جزيرة هيرد وماكدونالد', 'جمهورية افريقيا الوسطى', 'جمهورية التشيك', 'جمهورية الدومينيك', 'جمهورية الكونغو الديمقراطية', 'جمهورية جنوب افريقيا', 'جنوب آسيا', 'جنوب أوروبا', 'جنوب شرق آسيا', 'جنوب وسط آسيا', 'جواتيمالا', 'جوادلوب', 'جوام', 'جورجيا', 'جورجيا الجنوبية وجزر ساندويتش الجنوبية', 'جيبوتي', 'جيرسي',
        'دومينيكا',
        'رواندا', 'روسيا', 'روسيا البيضاء', 'رومانيا', 'روينيون',
        'زامبيا', 'زيمبابوي',
        'ساحل العاج', 'ساموا', 'ساموا الأمريكية', 'سانت بيير وميكولون', 'سانت فنسنت وغرنادين', 'سانت كيتس ونيفيس', 'سانت لوسيا', 'سانت مارتين', 'سانت هيلنا', 'سان مارينو', 'ساو تومي وبرينسيبي', 'سريلانكا', 'سفالبارد وجان مايان', 'سلوفاكيا', 'سلوفينيا', 'سنغافورة', 'سوازيلاند', 'سوريا', 'سورينام', 'سويسرا', 'سيراليون', 'سيشل',
        'شرق آسيا', 'شرق افريقيا', 'شرق أوروبا', 'شمال افريقيا', 'شمال أمريكا', 'شمال أوروبا', 'شيلي',
        'صربيا', 'صربيا والجبل الأسود',
        'طاجكستان',
        'عمان',
        'غامبيا', 'غانا', 'غرب آسيا', 'غرب افريقيا', 'غرب أوروبا', 'غويانا', 'غيانا', 'غينيا', 'غينيا الاستوائية', 'غينيا بيساو',
        'فانواتو', 'فرنسا', 'فلسطين', 'فنزويلا', 'فنلندا', 'فيتنام', 'فيجي',
        'قبرص', 'قرغيزستان', 'قطر',
        'كازاخستان', 'كاليدونيا الجديدة', 'كرواتيا', 'كمبوديا', 'كندا', 'كوبا', 'كوريا الجنوبية', 'كوريا الشمالية', 'كوستاريكا', 'كولومبيا', 'كومنولث الدول المستقلة', 'كيريباتي', 'كينيا',
        'لاتفيا', 'لاوس', 'لبنان', 'لوكسمبورج', 'ليبيا', 'ليبيريا', 'ليتوانيا', 'ليختنشتاين', 'ليسوتو',
        'مارتينيك', 'ماكاو الصينية', 'مالطا', 'مالي', 'ماليزيا', 'مايوت', 'مدغشقر', 'مصر', 'مقدونيا', 'ملاوي', 'منغوليا', 'موريتانيا', 'موريشيوس', 'موزمبيق', 'مولدافيا', 'موناكو', 'مونتسرات', 'ميانمار', 'ميكرونيزيا', 'ميلانيزيا',
        'ناميبيا', 'نورو', 'نيبال', 'نيجيريا', 'نيكاراجوا', 'نيوزيلاندا', 'نيوي',
        'هايتي', 'هندوراس', 'هولندا', 'هونج كونج الصينية',
        'وسط آسيا', 'وسط افريقيا',
    );

    protected static $cityFormats = array(
        '{{cityName}}',
    );

    protected static $streetNameFormats = array(
        '{{streetPrefix}} {{firstName}} {{lastName}}',
    );

    protected static $streetAddressFormats = array(
        '{{buildingNumber}} {{streetName}}',
        '{{buildingNumber}} {{streetName}} {{secondaryAddress}}',
    );

    protected static $addressFormats = array(
        "{{streetAddress}}\n{{city}}",
    );

    protected static $secondaryAddressFormats = array('شقة رقم. ##', 'عمارة رقم ##');

    /**
     * @example 'شرق'
     */
    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    /**
     * @example 'الرياض'
     */
    public static function cityName()
    {
        return static::randomElement(static::$cityName);
    }

    /**
     * @example 'شارع'
     */
    public static function streetPrefix()
    {
        return static::randomElement(static::$streetPrefix);
    }

    /**
     * @example 'شقة رقم. 350'
     */
    public static function secondaryAddress()
    {
        return static::numerify(static::randomElement(static::$secondaryAddressFormats));
    }

    /**
     * @example 'منطقة الرياض'
     */
    public static function subdivision()
    {
        return static::randomElement(static::$subdivisions);
    }

    /**
     * @example 'منطقة الرياض'
     */
    public static function governorate()
    {
        return static::randomElement(static::$governorates);
    }
}
