<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access


defined('_JEXEC') or die('Restricted access');

use CommerceLabShop\Cart\CartFactory;


class commercelab_shopTask_startover
{

	/**
	 * @param $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */
	public function getResponse($data)
	{

		return CartFactory::destroyCartAddress();
	}

}
