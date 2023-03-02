<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


namespace CommerceLabShop\Customfield;
// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use stdClass;

class Customfield
{

    private $db;

    public $id;
    public $title;
    public $name;
    public $label;
    public $default_value;
    public $type;
    public $description;
    public $state;
    public $ordering;
    public $params;
    public $fieldparams;
    public $options;
    public $value;


    public function __construct($fieldid = null, $itemid = null)
    {

        $this->db = Factory::getDbo();

        $this->id = $fieldid;
        $this->initCustomfield($fieldid, $itemid);
    }


    private function initCustomfield($fieldid, $item = null)
    {


        $query = $this->db->getQuery(true);

        $query->select('*');
        $query->from($this->db->quoteName('#__fields'));
        $query->where($this->db->quoteName('id') . ' = ' . $this->db->quote($fieldid));

        $this->db->setQuery($query);

        $customField = $this->db->loadObject();


        $this->title         = $customField->title;
        $this->name          = $customField->name;
        $this->label         = $customField->label;
        $this->default_value = $customField->default_value;
        $this->type          = $this->setType($customField);
        $this->description   = $customField->description;
        $this->state         = $customField->state;
        $this->ordering      = $customField->ordering;
        $this->params        = json_decode($customField->params);
        $this->fieldparams   = json_decode($customField->fieldparams);

        if ($customField->type == 'list' || $customField->type == 'radio') {
            $this->options = $this->setOptions();
        } else {
            $this->options = [];
        }


        if ($item) {
            $this->setValue($item->id);
        } else {
            $this->value = null;
        }


    }


    private function setValue($itemid)
    {

        $query = $this->db->getQuery(true);

        $query->select('value');
        $query->from($this->db->quoteName('#__fields_values'));
        $query->where($this->db->quoteName('field_id') . ' = ' . $this->db->quote($this->id));
        $query->where($this->db->quoteName('item_id') . ' = ' . $this->db->quote($itemid));

        $this->db->setQuery($query);

        $this->value = $this->db->loadResult();

    }


    private function setOptions()
    {

        $params = $this->fieldparams;


        $options = $params->options;

        $availableOptions = array();

        foreach ($options as $option) {
            $availableOptions[] = $option;
        }

        return $availableOptions;
    }


    private function setType($field)
    {

        $fieldParams = json_decode($field->fieldparams);

        if (isset($fieldParams->filter)) {


            if ($fieldParams->filter === 'integer') {
                return 'number';
            }

            if ($fieldParams->filter === 'tel') {
                return 'tel';
            }
            if ($fieldParams->filter === 'float') {
                return 'number';
            }

        }
        return $field->type;

    }


    public static function save($field, $itemid)
    {

        // delete all records

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $conditions = array(
            $db->quoteName('field_id') . ' = ' . $db->quote($field->id),
            $db->quoteName('item_id') . ' = ' . $db->quote($itemid)
        );

        $query->delete($db->quoteName('#__fields_values'));
        $query->where($conditions);

        $db->setQuery($query);
        $db->execute();


        // now recreate if there is a value set

        if ($field->value) {
            $object = new stdClass();
            $object->field_id = $field->id;
            $object->item_id = $itemid;
            $object->value = $field->value;

            $db->insertObject('#__fields_values', $object);
        }


    }

}
