<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Render;

defined('_JEXEC') or die('Restricted access');



class Render
{

	/**
	 * @param          $path
	 * @param   array  $vars
	 *
	 * @return bool|string|null
	 *
	 * @since 2.0
	 */

	public static function render($path, array $vars)
	{
		$output = null;
		if (file_exists($path))
		{
			// Extract the variables to a local namespace
			extract($vars);

			// Start output buffering
			ob_start();

			// Include the template file
			include $path;

			// End buffering and return its contents
			$output = ob_get_clean();
		}
		return $output;
	}

}
