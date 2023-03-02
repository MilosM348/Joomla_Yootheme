<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

/**
 * Clicks field.
 *
 * @since 2.0
 */
class JFormFieldVuelist extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'vuelist';

	public function getLabel()
	{
		return '<label class="uk-card-title">' . Text::_($this->element['label']) . (($this->required) ? ' <span class="uk-text-danger">*</span>' : '') . '</label>';
	}
	/**
	 * Method to get the field input markup.
	 *
	 * @return  string    The field input markup.
	 *
	 * @since 2.0
	 */
	protected function getInput()
	{

		$html = [];
		$html[] = '<select class=" ' . $this->class . '"';
		$html[] = 'name="' . $this->name . '" ';
		$html[] = ($this->required) ? 'required ' : '';
		$html[] = 'v-model="form.' . $this->id . '" ';
		$html[] = 'id="' . $this->id . '">';
		foreach ($this->getOptions() as $key => $option) {
			$html[] = '<option value="' . $option->value . '">';
				$html[] = $option->text;
			$html[] = '</option>';
		}
		$html[] = '</select>';

		return implode('', $html);

	}


	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   3.7.0
	 */
	protected function getOptions()
	{
		$fieldname = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname);
		$options   = array();

		foreach ($this->element->xpath('option') as $option)
		{
			// Filter requirements
			if ($requires = explode(',', (string) $option['requires']))
			{
				// Requires multilanguage
				if (in_array('multilanguage', $requires) && !JLanguageMultilang::isEnabled())
				{
					continue;
				}

				// Requires associations
				if (in_array('associations', $requires) && !JLanguageAssociations::isEnabled())
				{
					continue;
				}

				// Requires adminlanguage
				if (in_array('adminlanguage', $requires) && !JModuleHelper::isAdminMultilang())
				{
					continue;
				}

				// Requires vote plugin
				if (in_array('vote', $requires) && !JPluginHelper::isEnabled('content', 'vote'))
				{
					continue;
				}
			}

			$value = (string) $option['value'];
			$text  = trim((string) $option) != '' ? trim((string) $option) : $value;

			$disabled = (string) $option['disabled'];
			$disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');
			$disabled = $disabled || ($this->readonly && $value != $this->value);

			$checked = (string) $option['checked'];
			$checked = ($checked == 'true' || $checked == 'checked' || $checked == '1');

			$selected = (string) $option['selected'];
			$selected = ($selected == 'true' || $selected == 'selected' || $selected == '1');

			$tmp = array(
					'value'    => $value,
					'text'     => JText::alt($text, $fieldname),
					'disable'  => $disabled,
					'class'    => (string) $option['class'],
					'selected' => ($checked || $selected),
					'checked'  => ($checked || $selected),
			);

			// Set some event handler attributes. But really, should be using unobtrusive js.
			$tmp['onclick']  = (string) $option['onclick'];
			$tmp['onchange'] = (string) $option['onchange'];

			if ((string) $option['showon'])
			{
				$tmp['optionattr'] = " data-showon='" .
					json_encode(
						JFormHelper::parseShowOnConditions((string) $option['showon'], $this->formControl, $this->group)
						)
					. "'";
			}
			// Add the option object to the result set.
			$options[] = (object) $tmp;
		}

		if ($this->element['useglobal'])
		{
			$tmp        = new stdClass;
			$tmp->value = '';
			$tmp->text  = JText::_('JGLOBAL_USE_GLOBAL');
			$component  = JFactory::getApplication()->input->getCmd('option');

			// Get correct component for menu items
			if ($component == 'com_menus')
			{
				$link      = $this->form->getData()->get('link');
				$uri       = new JUri($link);
				$component = $uri->getVar('option', 'com_menus');
			}

			$params = JComponentHelper::getParams($component);
			$value  = $params->get($this->fieldname);

			// Try with global configuration
			if (is_null($value))
			{
				$value = JFactory::getConfig()->get($this->fieldname);
			}

			// Try with menu configuration
			if (is_null($value) && JFactory::getApplication()->input->getCmd('option') == 'com_menus')
			{
				$value = JComponentHelper::getParams('com_menus')->get($this->fieldname);
			}

			if (!is_null($value))
			{
				$value = (string) $value;

				foreach ($options as $option)
				{
					if ($option->value === $value)
					{
						$value = $option->text;

						break;
					}
				}

				$tmp->text = JText::sprintf('JGLOBAL_USE_GLOBAL_VALUE', $value);
			}

			array_unshift($options, $tmp);
		}

		reset($options);

		return $options;
	}

	/**
	 * Method to add an option to the list field.
	 *
	 * @param   string  $text        Text/Language variable of the option.
	 * @param   array   $attributes  Array of attributes ('name' => 'value' format)
	 *
	 * @return  JFormFieldList  For chaining.
	 *
	 * @since   3.7.0
	 */
	public function addOption($text, $attributes = array())
	{
		if ($text && $this->element instanceof SimpleXMLElement)
		{
			$child = $this->element->addChild('option', $text);

			foreach ($attributes as $name => $value)
			{
				$child->addAttribute($name, $value);
			}
		}

		return $this;
	}

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to get the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   3.7.0
	 */
	public function __get($name)
	{
		if ($name == 'options')
		{
			return $this->getOptions();
		}

		return parent::__get($name);
	}
}
