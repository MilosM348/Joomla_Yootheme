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
class JFormFieldTaxclasseslist extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Taxclasseslist';

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

		$html = array();

		$html[] = '<select name="jform_taxclass" v-model="form.jform_taxclass" id="jform_taxclass">';
			$html[] = '<option :selected="!form.jform_taxclass.length || form.jform_taxclass == \'0\'" value="0">Not Taxable</option>';
			$html[] = '<option :selected="form.jform_taxclass == \'taxrate\'" value="taxrate">Standard</option>';
			$html[] = '<option :selected="form.jform_taxclass == \'taxrate_reduced\'" value="taxrate_reduced">Reduced</option>';
			$html[] = '<option :selected="form.jform_taxclass == \'taxrate_extra\'" value="taxrate_extra">Extra</option>';
		$html[] = '</select>';

		return implode('', $html);

	}
}
