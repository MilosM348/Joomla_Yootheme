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
use CommerceLabShop\Sidebarlink\Sidebarlink;

defined('_JEXEC') or die('Restricted access');


interface AdminViewExtended
{

	/**
	 *
	 * @return Sidebarlink
	 *
	 * @since 2.0
	 */
	public function onGetSidebarLink(): Sidebarlink;


}
