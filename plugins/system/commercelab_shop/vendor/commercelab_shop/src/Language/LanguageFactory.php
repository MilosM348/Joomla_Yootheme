<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Language;

// no direct access
defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;


class LanguageFactory
{

	public static function load(): ?\Joomla\CMS\Language\Language
	{

		$language = Factory::getLanguage();
		$language->load('com_commercelab_shop', JPATH_ADMINISTRATOR);

		return $language;

	}


}
