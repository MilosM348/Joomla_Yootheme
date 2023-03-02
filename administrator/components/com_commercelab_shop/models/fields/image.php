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

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;

/**
 * Image field.
 *
 * @since  2.0
 */
class JFormFieldImage extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since 2.0
	 */
	protected $type = 'Image';

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
		return LayoutHelper::render('product/media', array(
			'id'           => $this->id, 
			'model'        => 'form.' . $this->id,
			'thumb_height' => '250px',
			'idStringify'  => true,
		));

	}
}
