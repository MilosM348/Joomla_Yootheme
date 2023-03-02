<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Optiontemplates;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Input\Input;

use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Currency\CurrencyFactory;

use Brick\Money\Money;
use Brick\Math\RoundingMode;
use Brick\Money\Context\CashContext;

use stdClass;

class Optiontemplates
{

    public $db;


    public function __construct()
    {
        $this->db = Factory::getDbo();
    }


    public static function getOptions($itemid = null)
    {

        $db = Factory::getDbo();

        if (!$itemid)
        {
            $itemid = Utilities::getCurrentItemId();
        }

        $product_id = Utilities::getProductIdFromJoomlaItemId($itemid);
        $query      = $db->getQuery(true);

        $query->select('*')
            ->from($db->quoteName('#__commercelab_shop_product_option'));

        $db->setQuery($query);

        $optionsArray = array();

        $availableOptions = $db->loadObjectList();
        $e = 0;

        foreach ($availableOptions as $availableOption)
        {
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__commercelab_shop_product_option_values'))
                ->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id))
                ->where($db->quoteName('optiontype') . ' = ' . $db->quote($availableOption->id))
                ->order('ordering ASC');

            $db->setQuery($query);
            $results = $db->loadObjectList();

            if ($results)
            {
                $optionsArray[$e]['optionname']    = $availableOption->name;
                $optionsArray[$e]['optiontype']    = $availableOption->option_type;
                $optionsArray[$e]['optiongroupid'] = $availableOption->id;
                $optionsArray[$e]['option']        = [];

                $i = 0;
                foreach ($results as $result)
                {

                    $optionsArray[$e]['option']['option' . $i]['optionid'] = $result->id;
                    $optionsArray[$e]['option']['option' . $i]['label']    = $result->optionname;
                    $optionsArray[$e]['option']['option' . $i]['modifier'] = $result->modifier;
                    $optionsArray[$e]['option']['option' . $i]['selected'] = ($i == 0) ? 'true' : 'false';


                    if ($result->modifiervalue)
                    {
                        if ($result->modifier == 'perc')
                        {
                            $optionsArray[$e]['option']['option' . $i]['modifiervalue'] = $result->modifiervalue;
                        }
                        else
                        {
                            //currency doesn't matter at this point, we only need to get the minor amount. So just use EUR
                            $modifiervalue = Money::ofMinor($result->modifiervalue, 'EUR', new CashContext(1), RoundingMode::DOWN);
                            $optionsArray[$e]['option']['option' . $i]['modifiervalue'] = $modifiervalue->getAmount();
                        }
                    }
                    else
                    {
                        $optionsArray[$e]['option']['option' . $i]['modifiervalue'] = "";
                    }


                    $optionsArray[$e]['option']['option' . $i]['modifiertype'] = $result->modifiertype;
                    $optionsArray[$e]['option']['option' . $i]['optionsku']    = $result->optionsku;
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

        if (!$itemid)
        {
            $itemid = Utilities::getCurrentItemId();
        }

        $product_id = Utilities::getProductIdFromJoomlaItemId($itemid);

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__commercelab_shop_product_option_values'))
            ->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id))
            ->order('ordering ASC');

        $db->setQuery($query);
        $options = $db->loadObjectList();

        foreach ($options as $option)
        {

            if ($option->modifiervalue)
            {

                if ($option->modifiertype == 'perc')
                {

                }
                else
                {
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

        if (!$itemid)
        {
            $itemid = Utilities::getCurrentItemId();
        }

        $product_id = Utilities::getProductIdFromJoomlaItemId($itemid);

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__commercelab_shop_product_option_values'))
            ->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id))
            ->order('ordering ASC');

        $db->setQuery($query);
        $options = $db->loadObjectList();

        $availableOptions = [];

        foreach ($options as $option)
        {
            $availableOptions[$option->optiontype] = array();
        }

        foreach ($options as $option)
        {
            $option->optionvalueid = $option->id;
            $availableOptions[$option->optiontype][] = $option;
        }

        return $availableOptions;


    }

    private static function getOptionType($optionTypeId)
    {
        $db = Factory::getDbo();

        $query = $db->getQuery(true)
            ->select(array('name', 'option_type'))
            ->from($db->quoteName('#__commercelab_shop_product_option'))
            ->where($db->quoteName('id') . ' = ' . $db->quote($optionTypeId));

        $db->setQuery($query);

        return $db->loadObject();
    }


    public static function getChosenOptions($itemid = null)
    {
        $db = Factory::getDbo();

        if (!$itemid)
        {
            $itemid = Utilities::getCurrentItemId();
        }

        //get the id of the options field
        $optionsFieldID = Utilities::getFieldId('yps-options');

        //now get the value
        $query = $db->getQuery(true);

        $query->select('value')
            ->from($db->quoteName('#__fields_values'))
            ->where($db->quoteName('item_id') . ' = ' . $db->quote($itemid))
            ->where($db->quoteName('field_id') . ' = ' . $db->quote($optionsFieldID));

        $db->setQuery($query);

        return $db->loadResult();
    }

    public static function getOptionList($type=NULL)
    {
        //now get the value
        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select('*')
            ->from($db->quoteName('#__commercelab_shop_product_option_template'))
            ->order('ordering');

        if (!empty($type))
        {
            $query->where($db->quoteName('option_type') . ' = ' . $db->quote($type));
        }

        $db->setQuery($query);

        $options = $db->loadObjectList();

        return $options;
       
    }

    public static function getOptionTemplate(int $template_id)
    {

         //now get the value
         $db = Factory::getDbo();

         $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__commercelab_shop_product_option_template'))
            ->where($db->quoteName('id') . ' = ' . $db->quote($template_id));
 
         $db->setQuery($query);
         $template = $db->loadObject();

         return $template;
    }

    public static function getOptionTemplateFilterList(string $searchTerm=null)
    {

         //now get the value
         $db = Factory::getDbo();

         $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__commercelab_shop_product_option_template'));

         if ($searchTerm)
         {
            // add in text search if we have it
            $query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
         }

         $query->order('ordering');
 
         $db->setQuery($query);
         $options = $db->loadObjectList();

         return $options;
    }

    public static function saveOptionTemplate(Input $data)
    {

        $db     = Factory::getDbo();
        $object = new stdClass();

        $object->name                 = $data->json->getString('name');
        $object->option_type          = $data->json->getString('option_type');
        $object->option_variant_price = $data->json->getInt('option_variant_price');
        $object->option_variant_stock = $data->json->getInt('option_variant_stock');
        $object->modifier_valueFloat  = CurrencyFactory::toInt($data->json->get('modifier_valueFloat'));
        $object->modifier_type        = $data->json->getString('modifier_type');
        $object->created_by           = Factory::getUser()->id;
        $object->created              = Utilities::getDate();

		return $db->insertObject('#__commercelab_shop_product_option_template', $object);
    }

    public static function updateoptiontemplate(Input $data)
    {
        $db     = Factory::getDbo();
        $object = new stdClass();

        $object->id                   = $data->json->getInt('id');
        $object->name                 = $data->json->getString('name');
        $object->option_variant_price = $data->json->getInt('option_variant_price');
        $object->option_variant_stock = $data->json->getInt('option_variant_stock');
        $object->modifier_valueFloat  = CurrencyFactory::toInt($data->json->get('modifier_valueFloat'));
        $object->modifier_type        = $data->json->getString('modifier_type');
        $object->option_type          = $data->json->getString('option_type');
        $object->modified_by          = Factory::getUser()->id;
        $object->modified             = Utilities::getDate();

		return $db->updateObject('#__commercelab_shop_product_option_template', $object,'id');

    }

    public static function trashoptiontemplates(Input $data)
    {
        $db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');
      
		/** @var Product $item */
		foreach ($items as $item)
		{
            $templateOption[]   = $item['id'];
		}

        if (!empty($templateOption))
        {

            $query = $db->getQuery(true)
                ->select('id')
                ->from($db->quoteName('#__commercelab_shop_product_option_templateoptions'))
                ->where('template_id IN('.implode(',',$templateOption).')');

            $db->setQuery($query);
            
            $options = $db->loadColumn();

            if (!empty($options))
            {

                $query = $db->getQuery(true)
                    ->select('id')
                    ->from($db->quoteName('#__commercelab_shop_product_option_templatevalues'))
                    ->where('option_id IN('.implode(',',$options).')');

                $db->setQuery($query);
                $optionsValues = $db->loadColumn();
                 
                if(!empty($optionsValues))
                {
                    $db->setQuery($db->getQuery(true)
                        ->delete($db->quoteName('#__commercelab_shop_product_option_templatevalues'))
                        ->where('id IN('.implode(',',$optionsValues).')'))
                    ->execute();
                }


                $query = $db->getQuery(true)
                    ->delete($db->quoteName('#__commercelab_shop_product_option_templateoptions'))
                    ->where('id IN('.implode(',',$options).')');

                $db->setQuery($query);
                $db->execute();
            }   

			$query = $db->getQuery(true)
                ->delete($db->quoteName('#__commercelab_shop_product_option_template')) 
                ->where('id IN('.implode(',',$templateOption).')');

			$db->setQuery($query);
			$db->execute();
        }
     
		return true;
    }

    public static function getTemplateOptionList(int $template_id = null, string $searchTerm = null)
    {
        //now get the value

        $db = Factory::getDbo();

        $query = $db->getQuery(true)
            ->select('oto.*, ot.name AS template_name')
            ->from($db->quoteName('#__commercelab_shop_product_option_templateoptions','oto'))
            ->join('LEFT', $db->quoteName('#__commercelab_shop_product_option_template', 'ot') . ' ON ' . $db->quoteName('ot.id') . ' = ' . $db->quoteName('oto.template_id'))
            ->where($db->quoteName('oto.template_id') . ' = ' . $db->quote($template_id));

        if ($searchTerm && $searchTerm != '')
        {
            $query->where($db->quoteName('oto.name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
        }

        $query->order('oto.ordering');

        $db->setQuery($query);
        $options = $db->loadObjectList();

        if (!empty($options))
        {
            foreach($options as $option)
            {
                // $option->values =  self::getTemplateOptionValuesList($option->id);
                $query = $db->getQuery(true)
                    ->select('name')
                    ->from($db->quoteName('#__commercelab_shop_product_option_templatevalues'))
                    ->where('option_id='.$option->id);

                $db->setQuery($query);
                $optionsValues  = $db->loadColumn();
                $option->values =  $optionsValues = $db->loadColumn();
            }
        }

        return $options;
    }

    public static function getFilteroptionsList(string $searchTerm=null,int $template_id=null)
    {
       return self::getTemplateOptionList($template_id,$searchTerm);
    }

    public static function saveOptionTemplateOptions(Input $data)
    {

        $db       = Factory::getDbo();
        $variants = $data->json->get('variants', '', 'ARRAY');

        //We use array on 0 key lol
        //option_name is for template options

        $object              = new stdClass();
        $object->name        = $variants[0]['option_name'];//$data->getString('name');
        $object->template_id = $data->json->get('template_id');//$data->getInt('template_id');
        $object->created_by  = Factory::getUser()->id;
        $object->created     = Utilities::getDate();

		$db->insertObject('#__commercelab_shop_product_option_templateoptions', $object);
        $optionId = $db->insertid();

		if ($optionId)
        {
            if (!empty($variants[0]['labels']))
            {

                foreach($variants[0]['labels'] as $label)
                {
                    $object             = new stdClass();
                    $object->name       = $label;
                    $object->option_id  = $optionId;
                    $object->created_by = Factory::getUser()->id;
                    $object->created    = Utilities::getDate();

                    $result = $db->insertObject('#__commercelab_shop_product_option_templatevalues', $object);
                }    
            }        
			return true;
		}
		
        return false;
    }

    public static function updateoptiontemplateoptions(Input $data)
    {
        $db = Factory::getDbo();

        $variants = $data->json->get('variants', '', 'ARRAY');

        $object              = new stdClass();
        $object->id          = $data->json->get('id','','INT');//$data->getInt('id');
        $object->name        = $variants[0]['option_name'];//$data->getString('name');
        $object->modified_by = Factory::getUser()->id;
        $object->modified    = Utilities::getDate();

		return $db->updateObject('#__commercelab_shop_product_option_templateoptions', $object,'id');
    }

    public static function getTemplateOptionValuesList($option_id)
    {
        //now get the value
   
        $db = Factory::getDbo();

        $query = $db->getQuery(true)
            ->select('otv.*,oto.name AS option_name')
            ->from($db->quoteName('#__commercelab_shop_product_option_templatevalues','otv'))
            ->join('LEFT', $db->quoteName('#__commercelab_shop_product_option_templateoptions', 'oto') . ' ON ' . $db->quoteName('oto.id') . ' = ' . $db->quoteName('otv.option_id'))
            ->where($db->quoteName('otv.option_id') . ' = ' . $db->quote($option_id))
            ->order('ordering');

        $db->setQuery($query);

        return  $db->loadObjectList();
    }

    public static function saveoptiontemplatevalues(Input $data)
    {

        $db     = Factory::getDbo();
        $object = new stdClass();

        $object->name       = $data->json->getString('name');
        $object->option_id  = $data->json->getInt('option_id');
        $object->created_by = Factory::getUser()->id;
        $object->created    = Utilities::getDate();

		$result = $db->insertObject('#__commercelab_shop_product_option_templatevalues', $object);

		if ($result)
		{
            
            $query = $db->getQuery(true)
                ->select('product_id,id')
                ->from($db->quoteName('#__commercelab_shop_product_variant'))
                ->where('template_option_id='.$data->json->getInt('option_id'));

            $db->setQuery($query);
            $variantValues = $db->loadObjectList();

            if (!empty($variantValues))
            {
                foreach($variantValues as $variantvalue)
                {
                    $product = ProductFactory::get($variantvalue->product_id);

                    $object             = new stdClass();
                    $object->name       = $data->json->getString('name');
                    $object->variant_id = $variantvalue->id;
                    $object->product_id = $variantvalue->product_id;

                    $db->insertObject('#__commercelab_shop_product_variant_label', $object);
                    $labelId = $db->insertid();

                    $query = $db->getQuery(true)
                        ->select('id')
                        ->from($db->quoteName('#__commercelab_shop_product_variant_label'))
                        ->where('product_id='.$variantvalue->product_id)
                        ->where('variant_id !='.$variantvalue->id);

                    $db->setQuery($query);
                    $variantids = $db->loadObjectList();

                    if (!empty($variantids))
                    {
                        foreach($variantids as $variantid)
                        {
                            $object             = new stdClass();
                            $object->product_id = $variantvalue->product_id;
                            $object->label_ids  = $variantid->id.','.$labelId;
                            $object->price      = $product->base_price;
                            $object->stock      = 0;
                            $object->sku        = 0;

                            $db->insertObject('#__commercelab_shop_product_variant_data', $object);
                        }
                    }
                    else
                    {
                        $object             = new stdClass();
                        $object->product_id = $variantvalue->product_id;
                        $object->label_ids  = $labelId;
                        $object->price      = $product->base_price;
                        $object->stock      = 0;
                        $object->sku        = 0;

                        $db->insertObject('#__commercelab_shop_product_variant_data', $object);
                    }    

                }
            }
              
			return true;
		}

		return false;

    }

    public static function updateoptiontemplatevalue(Input $data)
    {
        $db = Factory::getDbo();

        $object              = new stdClass();
        $object->id          = $data->getInt('id');
        $object->name        = $data->getString('name');
        $object->modified_by = Factory::getUser()->id;
        $object->modified    = Utilities::getDate();

		$result = $db->updateObject('#__commercelab_shop_product_option_templatevalues', $object,'id');

		if ($result)
		{
			return true;
		}
		
        return false;
    }  
    public static function trashoptiontemplatesvalues(Input $data): bool
	{
	    $db = Factory::getDbo();

        $query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('option_id') . ' = ' . $db->quote($data->getInt('option_id')),
            $db->quoteName('name') . ' = ' . $db->quote($data->getString('label_name'))
		);

		$query->delete($db->quoteName('#__commercelab_shop_product_option_templatevalues'))
            ->where($conditions);

		$db->setQuery($query,0,1);
        $db->execute();

		return true;
	}

    /*Sorting option template*/
    public static function optiontemplatesordering(Input $data)
    {
        $items = $data->json->get('items', '', 'ARRAY');

        if (!empty($items))
        {
            $db = Factory::getDbo();
            foreach ($items as $item)
            {
                $object           = new stdClass();
                $object->id       = $item['id'];
                $object->ordering = $item['ordering'];

                $result = $db->updateObject('#__commercelab_shop_product_option_template', $object,'id');
            }
        }    
       
    }
    /*Sorting option template options*/
    
    public static function optiontemplatesoptionordering(Input $data)
    {
        $db    = Factory::getDbo();
        $items = $data->json->get('items', '', 'ARRAY');

        if (!empty($items))
        {
            foreach ($items as $item)
            {
                $object           = new stdClass();
                $object->id       = $item['id'];
                $object->ordering = $item['ordering'];
                $result = $db->updateObject('#__commercelab_shop_product_option_templateoptions', $object,'id');
            }
        }    
       
    }

    /*Sorting option template values*/
    
    public static function optiontemplatesvaluesordering(Input $data)
    {
        $items = $data->json->get('items', '', 'ARRAY');
        $db    = Factory::getDbo();

        if (!empty($items))
        {
            foreach ($items as $item)
            {
                $object           = new stdClass();
                $object->id       = $item['id'];
                $object->ordering = $item['ordering'];
                $result = $db->updateObject('#__commercelab_shop_product_option_templatevalues', $object,'id');
            }
        }    
       
    }

    /*setSelectedOptionTemplates*/
    public static function setSelectedOptionTemplates(Input $data)
    {
        $db         = Factory::getDbo();
        $product_id = $data->json->get('product_id', '', 'INT');
        $items      = $data->json->get('items', '', 'ARRAY');

        if (!empty($items))
        {
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__commercelab_shop_product_option_templateoptions'))
                ->where('template_id IN('.implode(',',$items).')')
                ->order('ordering');

            $db->setQuery($query);
            $options = $db->loadObjectList();

            if (!empty($options))
            {
                foreach($options as $option)
                {
                    $optionValues = self::getTemplateOptionValuesList($option->id);

                    if (!empty($optionValues))
                    {
                        $object                     = new stdClass();
                        $object->name               = $option->name;
                        $object->product_id         = $product_id;
                        $object->template_option_id = $option->id;

                        $db->insertObject('#__commercelab_shop_product_variant', $object);
                        $variantId = $db->insertid();
                        self::insertOptionValues($option,$variantId,$product_id);

                    }
                }

                return true;
            }
        }

        return false;
    }

    public static function insertOptionValues($option,$variantId,$product_id)
    {
        $db = Factory::getDbo();
      
        $optionValues =  self::getTemplateOptionValuesList($option->id);

        if (!empty($optionValues))
        {
            foreach($optionValues as $optionValue)
            {
                $object             = new stdClass();
                $object->name       = $optionValue->name;
                $object->variant_id = $variantId;
                $object->product_id = $product_id;
                $db->insertObject('#__commercelab_shop_product_variant_label', $object);
            }

            return true;
        }

        return false;
    }

    public static function trashoptiontemplateOptions(Input $data){

        $db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');
      
		/** @var Product $item */
		foreach ($items as $item)
		{
            $templateOption[] = $item['id'];

		}   

        if (!empty($templateOption))
        {
            $query = $db->getQuery(true)
                ->select('id')
                ->from($db->quoteName('#__commercelab_shop_product_option_templatevalues'))
                ->where('option_id IN('.implode(',',$templateOption).')');

            $db->setQuery($query);
            $optionsValues = $db->loadColumn();
                 
            if (!empty($optionsValues))
            {
                $query = $db->getQuery(true)
                    ->delete($db->quoteName('#__commercelab_shop_product_option_templatevalues'))
                    ->where('id IN('.implode(',',$optionsValues).')');

                $db->setQuery($query);
                $db->execute();
            }

            $query = $db->getQuery(true)
                ->delete($db->quoteName('#__commercelab_shop_product_option_templateoptions'))
                ->where('id IN('.implode(',',$templateOption).')');

            $db->setQuery($query);
            $db->execute();

        }
     
		return true;
    }

    //Get template options by id
    public static function getTemplateOptionsById($option_id)
    {
        //now get the value
        if (!empty($option_id))
        {
            $db = Factory::getDbo();

            $query = $db->getQuery(true);

            $query->select('*')
                ->from($db->quoteName('#__commercelab_shop_product_option_templateoptions'))
                ->where($db->quoteName('id') . ' = ' . $db->quote($option_id));

            $db->setQuery($query);
            $options = $db->loadObject();

            return $options;
        }   
       
    }
}
