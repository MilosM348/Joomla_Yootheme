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
class JFormFieldFlatfee extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Flatfee';


	public function getLabel()
	{
		return '<label class="uk-card-title" v-show="form.jform_shipping_mode == \'flat\'">' . Text::_($this->element['label']) . '</label>';
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

		$html[] = '<div v-show="form.jform_shipping_mode == \'flat\'">';
		$html[] = '<p-inputnumber mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale"  name="' . $this->name . '" v-model="form.' . $this->id . '" id="' . $this->id . '">';
		$html[] = '</p-inputnumber> ';
		$html[] = '</div> ';

		return implode('', $html);


	}
}
