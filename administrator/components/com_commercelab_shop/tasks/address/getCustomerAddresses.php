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

use CommerceLabShop\Address\AddressFactory;


class commercelab_shopTask_getCustomerAddresses
{

	/**
	 * @param   Input  $data
	 *
	 * @return array
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse(Input $data): ?array
	{

		// grab current customer info here on the server - not on the client!
		$customer = \CommerceLabShop\Customer\CustomerFactory::get();

		return AddressFactory::getList(0, 0, null, 'id', 'DESC', $customer->id);


	}

}
