<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Productoptions;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use CommerceLabShop\Utilities\Utilities;

use Brick\Money\Money;
use Brick\Money\Context\CashContext;
use Brick\Math\RoundingMode;

class Productoptions
{

    public $db;


    public function __construct()
    {

        $this->db = Factory::getDbo();

    }


    public static function getOptions($itemid = null)
    {

        $db = Factory::getDbo();

        if (!$itemid) {
            $itemid = Utilities::getCurrentItemId();
        }

        $product_id = Utilities::getProductIdFromJoomlaItemId($itemid);

        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__commercelab_shop_product_option'));

        $db->setQuery($query);

        $optionsArray = array();

        $availableOptions = $db->loadObjectList();
        $e = 0;
        foreach ($availableOptions as $availableOption) {
            $query = $db->getQuery(true);

            $query->select('*');
            $query->from($db->quoteName('#__commercelab_shop_product_option_values'));
            $query->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id));
            $query->where($db->quoteName('optiontype') . ' = ' . $db->quote($availableOption->id));
            $query->order('ordering ASC');

            $db->setQuery($query);
            $results = $db->loadObjectList();

            if ($results) {

                $optionsArray[$e]['optionname'] = $availableOption->name;
                $optionsArray[$e]['optiontype'] = $availableOption->option_type;
                $optionsArray[$e]['optiongroupid'] = $availableOption->id;
                $optionsArray[$e]['option'] = array();
                $i = 0;
                foreach ($results as $result) {
                    $optionsArray[$e]['option']['option' . $i]['optionid'] = $result->id;
                    $optionsArray[$e]['option']['option' . $i]['label'] = $result->optionname;
                    $optionsArray[$e]['option']['option' . $i]['modifier'] = $result->modifier;
                    if($i == 0) {
                        $optionsArray[$e]['option']['option' . $i]['selected'] = 'true';
                    } else {
                        $optionsArray[$e]['option']['option' . $i]['selected'] = 'false';
                    }


                    if ($result->modifiervalue) {
                        if ($result->modifier == 'perc') {
                            $optionsArray[$e]['option']['option' . $i]['modifiervalue'] = $result->modifiervalue;
                        } else {

                            //currency doesn't matter at this point, we only need to get the minor amount. So just use EUR
                            $modifiervalue = Money::ofMinor($result->modifiervalue, 'EUR', new CashContext(1), RoundingMode::DOWN);

                            $optionsArray[$e]['option']['option' . $i]['modifiervalue'] = $modifiervalue->getAmount();
                        }
                    } else {
                        $optionsArray[$e]['option']['option' . $i]['modifiervalue'] = "";
                    }


                    $optionsArray[$e]['option']['option' . $i]['modifiertype'] = $result->modifiertype;
                    $optionsArray[$e]['option']['option' . $i]['optionsku'] = $result->optionsku;
                    $i++;
                }
                $e++;
            }


        }

        return $optionsArray;


    }


    public static function getOptionsForEdit($itemid = null)
    {
        $db = Factory::getDbo();

        if (!$itemid) {
            $itemid = Utilities::getCurrentItemId();
        }

        $product_id = Utilities::getProductIdFromJoomlaItemId($itemid);

        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__commercelab_shop_product_option_values'));
        $query->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id));
        $query->order('ordering ASC');

        $db->setQuery($query);
        $options = $db->loadObjectList();

        foreach ($options as $option) {

            if ($option->modifiervalue) {
                if ($option->modifiertype == 'perc') {

                } else {

                    //currency doesn't matter at this point, we only need to get the minor amount. So just use EUR
                    $modifiervalue = Money::ofMinor($option->modifiervalue, 'EUR', new CashContext(1), RoundingMode::DOWN);

                    $option->modifiervalue = $modifiervalue->getAmount();
                }

            }

        }

        return $options;


    }

    public static function getOptionsForEditNew($itemid = null)
    {
        $db = Factory::getDbo();

        if (!$itemid) {
            $itemid = Utilities::getCurrentItemId();
        }

        $product_id = Utilities::getProductIdFromJoomlaItemId($itemid);

        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__commercelab_shop_product_option_values'));
        $query->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id));
        $query->order('ordering ASC');

        $db->setQuery($query);
        $options = $db->loadObjectList();

        $availableOptions = [];

        foreach ($options as $option) {
            $availableOptions[$option->optiontype] = array();
        }

        foreach ($options as $option) {
            $option->optionvalueid = $option->id;
            $availableOptions[$option->optiontype][] = $option;
        }

        return $availableOptions;


    }

    private static function getOptionType($optionTypeId)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select(array('name', 'option_type'));
        $query->from($db->quoteName('#__commercelab_shop_product_option'));
        $query->where($db->quoteName('id') . ' = ' . $db->quote($optionTypeId));

        $db->setQuery($query);

        return $db->loadObject();
    }


    public static function getChosenOptions($itemid = null)
    {

        $db = Factory::getDbo();

        if (!$itemid) {
            $itemid = Utilities::getCurrentItemId();
        }

        //get the id of the options field
        $optionsFieldID = Utilities::getFieldId('yps-options');

        //now get the value
        $query = $db->getQuery(true);

        $query->select('value');
        $query->from($db->quoteName('#__fields_values'));
        $query->where($db->quoteName('item_id') . ' = ' . $db->quote($itemid));
        $query->where($db->quoteName('field_id') . ' = ' . $db->quote($optionsFieldID));

        $db->setQuery($query);

        return $db->loadResult();


    }


}
