<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die('Restricted access');

/**
 * Clicks field.
 *
 * @since 2.0
 */
class JFormFieldDiscount extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Discount';


	public function getLabel()
	{
		return '<label class="uk-card-title" v-if="form.jform_apply_discount">' . Text::_($this->element['label']) . '</label>';
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


		$html[] = '<div v-if="form.jform_apply_discount">';
			$html[] = '<div class="main-select-amount" uk-grid>';
				$html[] = '<div class="select-fild">';
					$html[] = '<span v-if="form.jform_discount_type == \'amount\'">';
						$html[] = '<p-inputnumber mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale"  name="' . $this->name . '" v-model="form.' . $this->id . '" id="' . $this->id . '">';
						$html[] = '</p-inputnumber>';
					$html[] = '</span>';
					$html[] = '<span v-if="form.jform_discount_type == \'perc\'">';
						$html[] = '<p-inputnumber mode="decimal" name="' . $this->name . '" v-model="form.' . $this->id . '" id="' . $this->id . '">';
						$html[] = '</p-inputnumber> ';
					$html[] = '</span>';
				$html[] = '</div>';
				$html[] = '<div class="select-amount">';
					$html[] = '<select class="uk-select" v-model="form.jform_discount_type">';
						$html[] = '<option :selected="form.jform_discount_type == \'amount\'" value="amount">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_AMOUNT') . '</option>';
						$html[] = '<option :selected="form.jform_discount_type == \'perc\'" value="perc">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_PERCENT') . '</option>';
					$html[] = '</select>';
				$html[] = '</div>';
			$html[] = '</div>';
			$html[] = '<br/><span>This product will sell for: {{sellPrice}}</span>';
		$html[] = ' </div>';


		return implode('', $html);


	}
}
