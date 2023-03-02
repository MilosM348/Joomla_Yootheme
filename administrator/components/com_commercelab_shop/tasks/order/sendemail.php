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

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Input\Input;

class commercelab_shopTask_sendemail
{

	public function getResponse(Input $data)
	{

		// init
		$response = [];

		PluginHelper::importPlugin('commercelab_shop_system');
		Factory::getApplication()->triggerEvent(
			'onSendCommerceLabShopEmail', 
			[
				$data->json->getString('emailtype', 'created'),
				$data->json->getInt('orderid')
			]
		);

		$response['sent'] = 'ok';

		return $response;

	}

}
