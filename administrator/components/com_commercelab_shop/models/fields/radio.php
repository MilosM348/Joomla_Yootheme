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
class JFormFieldRadio extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'radio';

	public function getLabel()
	{
		return '<label class="uk-card-title">' . Text::_($this->element['label']) . '</label>';
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


		$format = '<input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s />';
		$alt    = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->name);
		$html   = array();

		$html[] = '<fieldset id="' . $this->id . '" class="' . $this->class . ' radio">';

		if (!empty($this->element->option))
		{
			$i = 1;
			foreach ($this->element->option as $option)
			{
				$checked       = ($i == $this->value) ? 'checked="checked"' : '';
				$option->class = !empty($option->class) ? $option->class : '';
				$option->class = trim($option->class);
				$optionClass   = !empty($option->class) ? 'class="' . $option->class . '"' : '';
				$vModel   = ' v-model="'.$this->id.'"';
				$vModelVal   = ' v-bind:value="'.$i.'"';

				$oid        = $this->id . $i;
				$ovalue     = htmlspecialchars($i, ENT_COMPAT, 'UTF-8');
				$attributes = array_filter(array($checked, $optionClass, $vModel, $vModelVal));

				$html[] = sprintf($format, $oid, $this->name, $ovalue, implode(' ', $attributes));
				$html[] = '<label for="' . $oid . '" ' . trim($optionClass) . '>' . \Joomla\CMS\Language\Text::_($option) . '</label>';
				$i--;
			}
		}

		$html[] = '</fieldset>';

		return implode('', $html);

	}


}
