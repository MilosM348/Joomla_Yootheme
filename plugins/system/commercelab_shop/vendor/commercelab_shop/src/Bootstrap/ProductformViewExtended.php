<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Bootstrap;

use CommerceLabShop\ProductAddon\ProductAddon;

defined('_JEXEC') or die('Restricted access');


interface ProductformViewExtended
{
	/**
	 *
	 * @return ProductAddon
	 *
	 * @since 2.0
	 */
	public function onGetProductAddons(): ProductAddon;
}
