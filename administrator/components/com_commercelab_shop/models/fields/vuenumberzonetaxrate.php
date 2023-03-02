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
class JFormFieldVuenumberzonetaxrate extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Vuenumberzonetaxrate';

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
		$html[] = '<input v-if="!form.jform_inherit_taxrate" class="uk-font-primary input-small ' . $this->class . '" type="number" step="0.01" ';
		$html[] = 'name="' . $this->name . '" ';
		$html[] = 'v-model="form.' . $this->id . '" ';
		$html[] = 'id="' . $this->id . '" ';
		$html[] = ' />';
		$html[] = '<input v-else type="text" disabled="disabled" class="uk-font-primary input-small uk-input uk-form-width-medium uk-form-large uk-disabled" ';
			$html[] = ':value="form.jform_country.' . str_replace('jform_', '', $this->id) . '" ';
		$html[] = ' />';

		return implode('', $html);


	}
}
