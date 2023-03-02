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

use CommerceLabShop\Order\OrderFactory;


class commercelab_shopTask_filter
{

	public function getResponse(Input $data)
	{

		// init
		$data = [
			$data->json->getInt('limit', 0),
			$data->json->getInt('offset', 0),
			$data->json->getString('searchTerm', null),
			$data->json->getString('customerId', null),
			$data->json->getString('status', null),
			$data->json->getString('currency', null),
			$data->json->getString('dateFrom', null),
			$data->json->getString('dateTo', null),
			$data->json->getString('currentSort', null),
			$data->json->getString('currentSortDir', null)
		];

		$response = OrderFactory::getList(...$data);

		return $response;

	}

}
