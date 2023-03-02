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

class JFormFieldStock extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Stock';


	public function getLabel()
	{

		$html = array();

		$html[] = '<label class="uk-card-title" v-if="form.jform_manage_stock">';
		$html[] = Text::_($this->element['label']);
		$html[] = '</label>';


		return implode('', $html);

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

		$html[] = '<input class="input-small ' . $this->class . '" type="text" ';
		$html[] = 'v-if="form.jform_manage_stock"';
		$html[] = 'placeholder="' . TEXT::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_INVENTORY_CURRENT_STOCK_PLACEHOLDER') . '" ';
		$html[] = 'name="' . $this->name . '" ';
		$html[] = 'v-model="form.' . $this->id . '" ';
		$html[] = 'id="' . $this->id . '" ';
		$html[] = ' />';

		return implode('', $html);


	}
}
