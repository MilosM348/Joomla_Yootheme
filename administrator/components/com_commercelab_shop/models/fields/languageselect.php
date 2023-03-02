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
use Joomla\CMS\Language\LanguageHelper;

/**
 * Clicks field.
 *
 * @since 2.0
 */
class JFormFieldLanguageselect extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Languageselect';

	public function getLabel()
	{
		return '<label class="uk-card-title">' . Text::_($this->element['label']) . (($this->required) ? '<span class="uk-text-danger">*</span>' : '') . '</label>';
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


		$languages = LanguageHelper::getContentLanguages();


		$html[] = '<select class="uk-select" v-model="form.' . $this->id . '">';
		$html[] = '<option value="*">' . Text::_('JALL') . '</option>';
		foreach ($languages as $language) {
			$html[] = '<option value="'.$language->lang_code.'">' . $language->title . '</option>';
		}

		$html[] = '</select>';

		return implode('', $html);


	}
}
