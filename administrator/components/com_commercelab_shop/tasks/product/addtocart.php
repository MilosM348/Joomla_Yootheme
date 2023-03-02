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

class commercelab_shopTask_addtocart
{

	public function getResponse($data)
	{

		// init
		$amount      = $data->json->get('amount', null, 'INT');
		$j_item_id   = $data->json->get('j_item_id', null, 'INT');
		$variant_ids = $data->json->get('variant', null, 'ARRAY');
		$options     = $data->json->get('options', null, 'ARRAY');


		return CartFactory::addToCart($j_item_id, $amount, $options, $variant_ids);
	}

}
