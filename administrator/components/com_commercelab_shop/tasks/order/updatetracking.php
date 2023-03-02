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

class commercelab_shopTask_updatetracking
{

	public function getResponse(Input $data)
	{
		return OrderFactory::updateTracking(
            $data->json->getString('tracking_code'), 
            $data->json->getString('tracking_link'), 
            $data->json->getString('tracking_provider'), 
            $data->json->getString('order_id'), 
            $data->json->getBool('sendEmail')
        );
	}

}
