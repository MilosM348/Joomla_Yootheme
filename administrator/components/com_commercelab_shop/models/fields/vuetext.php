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
class JFormFieldVuetext extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'vuetext';

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


		$html = array();

		$html[] = '<input class="test input-small ' . $this->class . '" type="text" ';
		$html[] = 'name="' . $this->name . '" ';
		$html[] = 'v-model="form.' . $this->id . '" ';

		$html[] = 'id="' . $this->id . '" ';
		if($this->required) {
			$html[] = 'required="true" ';
		}

		$html[] = ' />';

		return implode('', $html);


	}
}
