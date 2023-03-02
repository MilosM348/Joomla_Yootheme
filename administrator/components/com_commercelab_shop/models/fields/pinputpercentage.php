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

use Joomla\CMS\Form\FormField;

/**
 * Clicks field.
 *
 * @since 2.0
 */
class JFormFieldPinputpercentage extends FormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'pinputpercentage';

	public function getLabel()
	{
		return '';
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

		$html[] = '<div v-show="form.jform_discount_type == 2">';
		$html[] = '<div>' . $this->element['label'] . '</div>';
		$html[] = '<p-inputnumber v-show="form.jform_discount_type == 2" v-model="form.'.$this->id.'" prefix="%"></p-inputnumber>';
		$html[] = '</div>';


		return implode('', $html);


	}
}
