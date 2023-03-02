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

use CommerceLabShop\Discount\DiscountFactory;
use CommerceLabShop\Discount\Discount;


class commercelab_shopTask_save
{

	/**
	 * @param   Input  $data
	 *
	 * @return null|Discount
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse(Input $data): ?Discount
	{
		return DiscountFactory::saveFromInputData($data);
	}

}
