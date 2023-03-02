<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access

use Joomla\Input\Input;

use CommerceLabShop\Cart\CartFactory;

defined('_JEXEC') or die('Restricted access');

class commercelab_shopTask_setsameas
{

	/**
	 * @param $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse(Input $data)
	{
		$state = $data->json->getInt('state');
		if ($state === 0)
		{
			$address_type      = $data->json->getString('address_type');
			$address_to_remove = CartFactory::getTempAddress(null, $address_type);

			CartFactory::removeAddress($address_type);

			if ($address_to_remove && count($address_to_remove))
			{
				CartFactory::removeTempAddress($address_to_remove[0]->address_id);
			}

		}
		
		return CartFactory::setSameAs($state);
	}

}
