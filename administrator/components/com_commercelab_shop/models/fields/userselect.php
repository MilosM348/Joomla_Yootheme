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
use CommerceLabShop\Utilities\Utilities;


class JFormFieldUserselect extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Userselect';

	public function getLabel()
	{
		return \Joomla\CMS\Language\Text::_('COM_COMMERCELAB_SHOP_CUSTOMER_JUSER');
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

		$users = Utilities::getUserListForSelect();


		$html  = array();

		$html[] = '<select name="' . $this->name . '" v-model="form.'.$this->id.'" class="required ' . $this->class . '" id="' . $this->id . '">';
		$html[] = '<option value=""> ' . Text::_('COM_COMMERCELAB_SHOP_ORDER_SHIPPING_PROVIDER_SELECT_DEFAULT') . ' </option>';

		foreach ($users as $user)
		{
			$html[] = '<option value="' . $user->id . '">';
			$html[] = $user->name;
			$html[] = "</option>";
		}


		$html[] = "</select>";

		return implode('', $html);

	}
}
