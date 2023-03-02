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
use Joomla\CMS\User\User;
use Joomla\Filesystem\Path;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use Joomla\Database\ParameterType;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;


use CommerceLabShop\Customfield\Customfield;
// use CommerceLabShop\Debugger\DebuggerFactory;


class CustomFieldsHelper
{
	// use stdClass;
	/**
	 * @var    FieldsModel
	 */
	private static $fieldsCache = null;

	/**
	 * @var    FieldsModel
	 */
	private static $fieldCache = null;

	public static function getFieldTypes() {
		$field_types = FieldsHelper::getFieldTypes();
		return $field_types;
	}

	public static function getFields (
		$joomla_item = null, $context = 'com_content.article', $prepareValue = true, array $valuesToOverride = null, bool $includeSubformFields = true
	) {

		// $fields = FieldsHelper::getFields($context, $joomla_item, $prepareValue, $valuesToOverride, $includeSubformFields);
		if (self::$fieldsCache === null)
		{
			self::$fieldsCache = Factory::getApplication()->bootComponent('com_fields')
					->getMVCFactory()->createModel('Fields', 'Administrator', ['ignore_request' => true]);
		}

		// dd(self::$fieldsCache);
		if (isset($joomla_item)) {
			return self::addValues(
				self::$fieldsCache->getItems(),
				$joomla_item
			);
		} else {
			return self::$fieldsCache->getItems();
		}
	}

	private static function approvedList() {
		return [
			'calendar',
			'checkboxes',
			'color',
			'editor',
			'imagelist',
			'input',
			'list',
			'location',
			'media',
			'radio',
			'subform',
			// 'repeatable',
			'text',
			'textarea',
			'url',
			'user',
		];
	}
	public static function getAssignedCategoriesIds($fieldId)
	{
		$fieldId = (int) $fieldId;

		if (!$fieldId)
		{
			return [];
		}

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName('c.id'))
			->from($db->quoteName('#__fields_categories', 'a'))
			->join('INNER', $db->quoteName('#__categories', 'c') . ' ON a.category_id = c.id')
			->where($db->quoteName('field_id') . ' = :fieldid')
			->bind(':fieldid', $fieldId, ParameterType::INTEGER);

		$db->setQuery($query);

		return $db->loadColumn();
	}

	public static function getApprovedCustomFields ($joomla_item = null) {
		return self::getCustomFields($joomla_item);
	}

	protected static function showFieldBasedOnCategories($assignedCategorie, $categories_parents)
	{
		$show = false;
		foreach ($categories_parents as $key => $cat_id) {
			if (in_array($cat_id, $assignedCategorie)) {
				$show = true;
				break;
			}
		}

		return $show;
	}
	// public static function getCategoryParentsTree($cat_id)
	// {
	// 	$categories = Categories::getInstance('com_content');
	// 	$category = $categories->get((int) $cat_id);

	// 	return array_keys($category->getPath());

	// }
	protected static function getCustomFields($joomla_item = null, $subform = null)
	{
		$fields = self::getFields($joomla_item);

		// Filer Fields Fields
		$filtered_fields = [];
		$approvedFields  = self::approvedList();

		foreach ($fields as $key => $field) {

			if ($field->state !== 1)
			{
				continue;
			}
			
			if ($field->context != "com_content.article")
			{
				continue;
			}
			
			// $field->show_on_load          = self::showFieldBasedOnCategories($assignedCategories, $categoriesPath);

			if ( !in_array($field->type, $approvedFields) )
			{
				continue;
			}

			if ( isset($field->only_use_in_subform) && (int)$field->only_use_in_subform && !$subform )
			{
				continue;
			}

			$filtered_fields[] = $field;
		}

		foreach ($filtered_fields as $key => &$field) {

			$field->clsCustomField = new Customfield($field->id, $joomla_item);
			$field->isSubField     = false;
			$field->key            = $key;

			$field = self::prepareField($field, $joomla_item);

			// Prepare Values - repeatable subforms
			if ($field->type == 'repeatable' || $field->type == 'subform') {
				
				$index = 0;
				$subform_rows = [];

				foreach ($field->clsCustomField->fieldparams->options as $option_key => $option) {
					$subField = self::getCustomField($option->customfield, $joomla_item, 'com_content.article', false, null, false);
					if (!$subField) {
						continue;
					}
					// dump($subField);

					$subField->clsCustomField = new Customfield($subField->id);
					$subField->value      = '';
					$subField->rawvalue   = '';
					$subField->dropbox    = false;
					$subField->isSubField = true;
					$subField = self::prepareField($subField);
					$subField->dom_id = 'custom_fields_' . $key . '_' . $subField->name . '_' . $subField->id;
					$subform_rows[$subField->name] = $subField;
					$index++;
				}

				$field->subform_rows_locked = true;
				$field->dragging            = false;
				$field->ghost_fields        = $subform_rows;

				if ($field->rawvalue != '') {
					$field = self::formatSubForm($field, $joomla_item);
				} else {
					$field->subform_rows       = [];
					$field->subform_rows_count = 0;
				}
			}

			$field->assigned_category_ids = self::getAssignedCategoriesIds($field->id);
		}

		// dd($filtered_fields);
		return $filtered_fields;
	}

	public static function getCustomField(
		$fieldId, 
		$joomla_item = null, 
		$context = 'com_content.article', 
		$prepareValue = true, 
		array $valuesToOverride = null, 
		bool $includeSubformFields = true
	) {
		// $fields = FieldsHelper::getFields($context, $joomla_item, $prepareValue, $valuesToOverride, $includeSubformFields);
		$fields = self::getFields($joomla_item);

		$field  = false;
		foreach ($fields as $object) {
		    if ($object->id == $fieldId) {
		        $field = $object;
		        break;
		    }
		}

		return $field;
	}

	public static function addValues($fields, $joomla_item)
	{

		if (!$joomla_item)
			return $fields;

		if (self::$fieldCache === null)
		{
			self::$fieldCache = Factory::getApplication()->bootComponent('com_fields')
				->getMVCFactory()->createModel('Field', 'Administrator', ['ignore_request' => true]);
		}

		$fieldIds = array_map(
			function ($f)
			{
				return $f->id;
			},
			$fields
		);

		$fieldValues = self::$fieldCache->getFieldValues($fieldIds, $joomla_item->id);

		$new = array();

		foreach ($fields as $key => $original)
		{
			/*
			 * Doing a clone, otherwise fields for different items will
			 * always reference to the same object
			 */
			$field = clone $original;

			// if ($valuesToOverride && array_key_exists($field->name, $valuesToOverride))
			// {
			// 	$field->value = $valuesToOverride[$field->name];
			// }
			// elseif ($valuesToOverride && array_key_exists($field->id, $valuesToOverride))
			// {
			// 	$field->value = $valuesToOverride[$field->id];
			// }
			if (array_key_exists($field->id, $fieldValues))
			{
				$field->value = $fieldValues[$field->id];
			}

			if (!isset($field->value) || $field->value === '')
			{
				$field->value = $field->default_value;
			}

			$field->rawvalue = $field->value;

			// If boolean prepare, if int, it is the event type: 1 - After Title, 2 - Before Display, 3 - After Display, 0 - Do not prepare
			if ($field->params->get('display', '2'))
			{
				PluginHelper::importPlugin('fields');

				/*
				 * On before field prepare
				 * Event allow plugins to modify the output of the field before it is prepared
				 */
				Factory::getApplication()->triggerEvent('onCustomFieldsBeforePrepareField', array('com_content.article', $joomla_item, &$field));

				// Gathering the value for the field
				$value = Factory::getApplication()->triggerEvent('onCustomFieldsPrepareField', array('com_content.article', $joomla_item, &$field));

				if (is_array($value))
				{
					$value = implode(' ', $value);
				}

				/*
				 * On after field render
				 * Event allows plugins to modify the output of the prepared field
				 */
				Factory::getApplication()->triggerEvent('onCustomFieldsAfterPrepareField', array('com_content.article', $joomla_item, $field, &$value));

				// Assign the value
				$field->value = $value;
			}

			$new[$key] = $field;
		}

		$fields = $new;

		return $fields;
	}

	public static function formatSubForm($field, $joomla_item = null)
	{
		foreach ($field->subform_rows as $row_index => $subfields) {
			foreach ($subfields as $subfield_name => &$sub_field) {
				$sub_field->dropbox  = false;
				$sub_field->isSubField = true;
				$sub_field->clsCustomField = new Customfield($sub_field->id, $joomla_item);
				$sub_field = self::prepareField($sub_field);
			}

		}

		return $field;
	}

	public static function prepareField($field) {

		if (!isset($field->rawvalue))
			$field->rawvalue = '';

		if (!isset($field->value))
			$field->value = '';

		if (
			$field->type == 'list'
			|| $field->type == 'radio'
			|| $field->type == 'checkboxes'
			|| $field->type == 'sql'
		) {


			// Clean Multiple Value
			if (!isset($field->clsCustomField->fieldparams->multiple) || $field->clsCustomField->fieldparams->multiple == '') {
				$field->clsCustomField->fieldparams->multiple = 0;
			} else {
				$field->clsCustomField->fieldparams->multiple = 1;
			}


			// If single Select, set Rawvalue as single value
			if ($field->type == 'list' && !$field->clsCustomField->fieldparams->multiple) {
				$field->rawvalue = ($field->rawvalue != '') 
					? $field->rawvalue[0]
					: $field->clsCustomField->fieldparams->options->options0->value; // If single select, with no data and no default, select first option
			}

		}

		if ($field->type == 'calendar') {
			if ($field->default_value == 'NOW')
				$field->default_value = '';
		}

		if ($field->type == 'imagelist') {

			$field->clsCustomField->fieldparams->directory = ($field->clsCustomField->fieldparams->directory != '') ? str_replace('\\', '/', $field->clsCustomField->fieldparams->directory) . '/' : '';
			$path = 'images/' . $field->clsCustomField->fieldparams->directory;

			$field->clsCustomField->fieldparams->directory = $path;

			$path = Path::clean(JPATH_ROOT . '/' . $path);

			$files_in_folder = Folder::files($path, '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$|\.jpeg$|\.psd$|\.eps$');
			$field->clsCustomField->fieldparams->options = $files_in_folder;
		}

		if ($field->type == 'checkboxes'
			|| $field->type == 'imagelist')
		{
			$field->rawvalue = ($field->rawvalue != '') 
				? (is_array($field->rawvalue)
					? $field->rawvalue
					: [$field->rawvalue]
				) 
				: ((isset($field->default_value) && $field->default_value != '') 
					? (
						(is_array($field->default_value))
							? $field->default_value
							: [$field->default_value]
					) 
					: []);
		}

		if ($field->type == 'media') {
			$field->rawvalue = ((isset($field->default_value) && $field->default_value != '') 
				? $field->default_value 
				: (($field->rawvalue != '') 
					? self::cleanMediaField($field)->rawvalue 
					: '')
				);

			// dump('prepareField 2', $field->rawvalue);
		}

		$multiple = isset($field->clsCustomField->fieldparams->multiple) && $field->clsCustomField->fieldparams->multiple == 1;

		// Set Default Value as Raw
		if ($field->default_value && $field->default_value != '' && $field->rawvalue == '') {
			$field->rawvalue = ($multiple || $field->type == 'checkboxes') 
				? [$field->default_value] 
				: $field->default_value; 
		}
		if ($field->type == 'user' && $field->rawvalue != '') {
			$field->value = User::getInstance($field->rawvalue)->username;
		}
		return $field;
	}

	public static function cleanMediaField($field, $subfield = false)
	{

		if (JVERSION >= "4.0.0" ) {
			if (!is_array($field->rawvalue)) {
				$raw_value = json_decode($field->rawvalue)->imagefile;
			} else {
				$raw_value = $field->rawvalue['imagefile'];
			}
			$field->rawvalue = strtok($raw_value, '#');
			$split           = preg_split("/(\?|\&|=)/", $raw_value);
			$field->width    = $split[2];
			$field->height   = $split[4];
			return $field;

		} else {
			//  DO Nothing
			return $field;
		}

	}

	// public $id;
	// public $context;
	// public $group_id;
	// public $title;
	// public $name;
	// public $label;
	// public $default_value;
	// public $type;
	// public $description;
	// public $state;
	// public $ordering;
	// public $params;
	// public $fieldparams;

	// public $options;
	// public $value;


	// public function __construct($data, $itemid)
	// {

	// 	if ($data)
	// 	{
	// 		$this->hydrate($data);
	// 		$this->init($itemid);
	// 	}

	// }

	/**
	 *
	 * Function to simply "hydrate" the database values directly to the class parameters.
	 *
	 * @param $data
	 *
	 *
	 * @since 2.0
	 */

	// private function hydrate($data)
	// {
	// 	foreach ($data as $key => $value)
	// 	{

	// 		if (property_exists($this, $key))
	// 		{
	// 			$this->{$key} = $value;
	// 		}

	// 	}
	// }

	/**
	 *
	 * Function to "hydrate" all non-database values.
	 *
	 * @param $itemid
	 *
	 * @since 2.0
	 */

	// private function init($itemid)
	// {

	// 	$this->type = $this->setType($this->type, $this->fieldparams);

	// 	if ($this->type == 'list' || $this->type == 'radio')
	// 	{
	// 		$this->options = $this->setOptions();
	// 	}
	// 	else
	// 	{
	// 		$this->options = [];
	// 	}

	// 	if ($itemid)
	// 	{
	// 		$this->value = ProductFactory::setCustomFieldValue($this->id, $itemid);
	// 	}
	// 	else
	// 	{
	// 		$this->value = null;
	// 	}

	// }


	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	// private function setOptions(): array
	// {

	// 	$params = json_decode($this->fieldparams);


	// 	$options = $params->options;

	// 	$availableOptions = array();

	// 	foreach ($options as $option)
	// 	{
	// 		$availableOptions[] = $option;
	// 	}

	// 	return $availableOptions;
	// }

	/**
	 * @param   string  $type
	 * @param   string  $fieldParams
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	// private function setType(string $type = 'text', string $fieldParams): string
	// {

	// 	$fieldParams = json_decode($fieldParams);

	// 	if (isset($fieldParams->filter))
	// 	{

	// 		if ($fieldParams->filter === 'integer')
	// 		{
	// 			return 'number';
	// 		}

	// 		if ($fieldParams->filter === 'tel')
	// 		{
	// 			return 'tel';
	// 		}
	// 		if ($fieldParams->filter === 'float')
	// 		{
	// 			return 'number';
	// 		}

	// 	}

	// 	return $type;


	// }


	// public static function save($field, $itemid)
	// {

	// 	// delete all records

	// 	$db = Factory::getDbo();

	// 	$query = $db->getQuery(true);

	// 	$conditions = array(
	// 		$db->quoteName('field_id') . ' = ' . $db->quote($field->id),
	// 		$db->quoteName('item_id') . ' = ' . $db->quote($itemid)
	// 	);

	// 	$query->delete($db->quoteName('#__fields_values'));
	// 	$query->where($conditions);

	// 	$db->setQuery($query);
	// 	$db->execute();


	// 	// now recreate if there is a value set

	// 	if ($field->value)
	// 	{
	// 		$object           = new stdClass();
	// 		$object->field_id = $field->id;
	// 		$object->item_id  = $itemid;
	// 		$object->value    = $field->value;

	// 		$db->insertObject('#__fields_values', $object);
	// 	}


	// }

}
