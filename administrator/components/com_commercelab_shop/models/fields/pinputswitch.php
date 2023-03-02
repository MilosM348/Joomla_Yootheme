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
	protected $type = 'Pinputswitch';

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

		// @change="getSellPrice()" 

		$html = [];

		$html[] = '<div class="uk-width-1-1 uk-text-right">';
			$html[] = '<p-inputswitch v-model="form.' . $this->id . '" id="' . $this->id . '" @change="logIt"></p-inputswitch>';
		$html[] = '</div>';

		return implode('', $html);

	}
}
