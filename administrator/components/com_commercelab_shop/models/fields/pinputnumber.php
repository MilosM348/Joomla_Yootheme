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
class JFormFieldPinputnumber extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'pinputnumber';

	public function getLabel()
	{
		switch ($this->element['formName'])
		{
			case 'discount_amount':
				return '';

			case 'discount_percentage':
				return '';
				
			case 'cost':
				return Text::_("COM_COMMERCELAB_SHOP_SHIPPINGRATES_TABLE_COST");

			case 'handling_cost':
				return Text::_("COM_COMMERCELAB_SHOP_SHIPPINGRATES_TABLE_HANDLING_COST");

			case 'zonecost':
				return Text::_("COM_COMMERCELAB_SHOP_SHIPPINGRATES_TABLE_COST");

			case 'zonehandling_cost':
				return Text::_("COM_COMMERCELAB_SHOP_SHIPPINGRATES_TABLE_HANDLING_COST");
		}
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

		switch ($this->element['formName'])
		{
			case 'discount_amount':

				$html[] = '<div v-if="form.jform_discount_type == 1">';
					$html[] = '<div>' . $this->element['label'] . '</div>';
					$html[] = '<p-inputnumber v-model="form.' . $this->id . '"name="' . $this->name . '" mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale" id="' . $this->id . '"></p-inputnumber>';
				$html[] = '</div>';
				break;

			case 'discount_percentage':

				$html[] = '<div v-if="form.jform_discount_type == 2">';
					$html[] = '<div>' . $this->element['label'] . '</div>';
					$html[] = '<p-inputnumber v-model="form.' . $this->id . '"  mode="decimal" max="100" min="1" minFractionDigits="2" useGrouping="false"></p-inputnumber>';
				$html[] = '</div>';
				break;

			case 'cost':			
				$html[] = '<p-inputnumber v-model="form.' . $this->id . '" mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale"></p-inputnumber>';			
				break;

			case 'handling_cost':				
				$html[] = '<p-inputnumber v-model="form.' . $this->id . '" mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale"></p-inputnumber>';				
				break;

			case 'zonecost':
				$html[] = '<p-inputnumber v-model="form.' . $this->id . '" mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale"></p-inputnumber>';			
				break;

			case 'zonehandling_cost':
				$html[] = '<p-inputnumber v-model="form.' . $this->id . '" mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale"></p-inputnumber>';				
				break;

		}


		return implode('', $html);

	}
}
