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

class commercelab_shopTask_get
{

	public function getResponse(Input $data)
	{

		return OrderFactory::get(
            $data->json->getInt('order_id')
        );

	}

}
