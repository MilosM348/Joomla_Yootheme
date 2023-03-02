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

use Joomla\Input\Input;

use CommerceLabShop\Cart\CartFactory;

class commercelab_shopTask_remove
{

	/**
	 * @param $data
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function getResponse(Input $data): bool
	{

		return CartFactory::remove($data);
	}

}
