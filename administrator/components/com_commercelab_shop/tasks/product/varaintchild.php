<?php
/**
 * @package   CommerceLab_Shop
 * @author    Cloud Chief - CommerceLab Shop
 * @copyright Copyright (C) 2021 Cloud Chief - CommerceLab Shop
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access


defined('_JEXEC') or die('Restricted access');

use CommerceLabShop\Product\ProductFactory;
use Joomla\Input\Input;

class commercelab_shopTask_varaintchild
{

	public function getResponse(Input $data)
	{

		return $products = ProductFactory::varaintchild($data);
	}

}
