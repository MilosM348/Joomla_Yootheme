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


class commercelab_shopTask_saveguestbilling
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
		if ($address = AddressFactory::saveFromInputData($data))
		{
			// now that we have the address, apply it to the guest checkout

			if (!CartFactory::setCartAddress($address->id, 'billing'))
			{

				$response['status']  = 'ko';
				$response['message'] = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ERROR_IN_ADDRESS_FORM');

				return $response;
			}


			$response['status']  = 'ok';
			$response['message'] = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ADDRESS_ADDED');

			return $response;
		}


		$response['status']  = 'ko';
		$response['message'] = Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_ALERT_ERROR');

		return $response;


	}

}
