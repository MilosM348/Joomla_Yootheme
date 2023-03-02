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

class commercelab_shopTask_changecount
{

	public function getResponse($data)
	{

		// init
		$response   = array();
		$cartItemId = $data->json->get('cartitemid');
		$itemId     = $data->json->get('itemId');
		$newCount   = $data->json->get('newcount', 0);

		$response = CartFactory::changeCount($cartItemId, $itemId, $newCount);
		return $response;
	}

}
