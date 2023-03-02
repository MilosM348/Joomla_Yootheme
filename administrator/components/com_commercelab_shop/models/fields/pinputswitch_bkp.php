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
class JFormFieldPinputswitch extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'pinputswitch';

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

		$html[] = '<div uk-grid>';
		$html[] = '<div class="uk-width-1-4 uk-grid-item-match uk-flex-middle">';
		$html[] =  Text::_($this->element['label']);
		$html[] = '</div>';
		$html[] = '<div class="uk-width-3-4">';
		$html[] = '<p-inputswitch @change="getSellPrice()" v-model="form.' . $this->id . '" id="' . $this->id . '" @change="logIt"></p-inputswitch>';
		$html[] = '</div>';
		$html[] = '</div>';

		return implode('', $html);


	}
}
