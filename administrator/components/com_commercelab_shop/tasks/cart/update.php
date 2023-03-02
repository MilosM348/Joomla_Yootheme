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
use CommerceLabShop\Cart\Cart;

class commercelab_shopTask_update
{

	/**
	 * @param $data
	 *
	 * @return Cart
	 *
	 * @since 1.5
	 */
	public function getResponse($data)
	{

		$cart = CartFactory::get();

		return $cart;
	}

}
