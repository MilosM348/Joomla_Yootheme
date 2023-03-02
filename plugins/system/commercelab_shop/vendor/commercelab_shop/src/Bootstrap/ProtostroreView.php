<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Bootstrap;

// no direct access
defined('_JEXEC') or die('Restricted access');

use CommerceLabShop\Language\LanguageFactory;

class ProtostroreView
{



	public function __construct()
	{

		LanguageFactory::load();

	}




}
