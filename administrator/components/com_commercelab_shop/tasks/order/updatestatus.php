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

use CommerceLabShop\Order\OrderFactory;
use Joomla\Input\Input;


/**
 *
 * @since       2.0
 */

class commercelab_shopTask_updatestatus
{

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	public function getResponse(Input $data)
	{

		return OrderFactory::updateStatus(
			$data->json->getString('status'),
			$data->json->getString('order_id'),
			$data->json->getBool('sendEmail')
		);

	}

}
