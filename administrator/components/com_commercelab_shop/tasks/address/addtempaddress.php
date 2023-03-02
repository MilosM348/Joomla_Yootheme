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
use Joomla\CMS\Language\Text;

use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Cart\CartFactory;


class commercelab_shopTask_addtempaddress
{

	/**
	 * @param   Input  $data
	 *
	 * @return array|void
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse(Input $data)
	{
		$response = [];

		// save the given address
		$address = AddressFactory::saveFromInputData($data);
		if ($address)
		{

			$temp_address = CartFactory::getTempAddress($address->id);
			if (!$temp_address)
			{
				$temp_address = CartFactory::setTempAddress($address);
			}

			if ($temp_address)
			{
				$response['address_id'] = $address->id;
				$response['status']     = 'ok';

				return $response;
			}

		}

		$response['status']  = 'ko';
		$response['message'] = Text::_('Error Saving Address');

		return $response;

	}

}
