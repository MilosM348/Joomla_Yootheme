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
class JFormFieldByweight extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Byweight';


	public function getLabel()
	{
		return '<label class="uk-card-title" v-show="form.jform_shipping_mode == \'weight\'">' . Text::_($this->element['label']) . '</label class="">';
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

		$html[] = '<div v-show="form.jform_shipping_mode == \'weight\'">';
		$html[] = '<div class="uk-grid uk-grid-small" uk-grid>';
		$html[] = '<div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">';
		$html[] = '<p-inputnumber mode="decimal"  name="' . $this->name . '" v-model="form.jform_weight" id="' . $this->id . '">';
		$html[] = '</p-inputnumber> ';
		$html[] = '</div> ';
		$html[] = '<div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">';
		$html[] = '<select class="uk-select" v-model="form.jform_weight_unit">';
		$html[] = '<option value="">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_SHIPPING_SELECT') . '</option>';
		$html[] = '<option value="g">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_SHIPPING_WEIGHT_UNIT_GRAM') . '</option>';
		$html[] = '<option value="kg">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_SHIPPING_WEIGHT_UNIT_KG') . '</option>';
		$html[] = '<option value="oz">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_SHIPPING_WEIGHT_UNIT_OUNCE') . '</option>';
		$html[] = '<option value="lb">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_SHIPPING_WEIGHT_UNIT_POUND') . '</option>';
		$html[] = '</select> ';
		$html[] = '</div> ';
		$html[] = '</div> ';
		$html[] = '</div> ';

		return implode('', $html);


	}
}




