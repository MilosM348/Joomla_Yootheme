<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access


use CommerceLabShop\Checkout\CheckoutFactory;

defined('_JEXEC') or die('Restricted access');



class commercelab_shopTask_validationMessages
{

	/**
	 * @param $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse($data): bool
	{
		return CheckoutFactory::getValidationMessages($data);
	}

}
