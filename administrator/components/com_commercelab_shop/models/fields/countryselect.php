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
use Joomla\CMS\Language\LanguageHelper;
use CommerceLabShop\Country\Country;
use CommerceLabShop\Country\CountryFactory;

defined('_JEXEC') or die('Restricted access');

/**
 * Clicks field.
 *
 * @since 2.0
 */
class JFormFieldCountryselect extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Countryselect';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string    The field input markup.
	 *
	 * @since 2.0
	 */
	protected function getInput(): string
	{

		$html = array();


		$countries = CountryFactory::getList(0,0, true);

		$required = ($this->element['required'] ? 'required' : '');
		$html[] = '<select '.$required.' class="uk-select" v-model="form.' . $this->id . '">';
		$html[] = '<option value="">' . Text::_('COM_COMMERCELAB_SHOP_ZONES_SELECT_A_COUNTRY') . '</option>';
		/** @var $country Country */
		foreach ($countries as $country) {
			$html[] = '<option value="'.$country->id.'">' . $country->country_name . '</option>';
		}

		$html[] = '</select>';

		return implode('', $html);


	}
}
