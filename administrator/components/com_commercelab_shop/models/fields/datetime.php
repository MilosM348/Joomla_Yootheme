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
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Clicks field.
 *
 * @since 2.0
 */
class JFormFieldDatetime extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Datetime';

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

		$html   = [];
		$value  = (!empty($this->value)) ? HtmlHelper::date($this->value, Text::_('DATE_FORMAT_LC6')) : HTMLHelper::_('date', null, Text::_('DATE_FORMAT_LC6'));;
		$html[] = '<input type="datetime" id="'.$this->id.'"  name="'.$this->id.'" value="'.$value.'">';

		return implode('', $html);


	}
}
