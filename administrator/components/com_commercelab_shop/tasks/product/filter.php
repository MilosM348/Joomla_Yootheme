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

use CommerceLabShop\Product\ProductFactory;


class commercelab_shopTask_filter
{

	public function getResponse($data)
	{

		// init
		$data = [
			$data->json->getInt('limit', 0),
			$data->json->getInt('offset', 0),
			$data->json->getInt('category', null),
			$data->json->getString('searchTerm', null),
			$data->json->getInt('active_only', 0),
			$data->json->getString('currentSort', null),
			$data->json->getString('currentSortDir', null)
		];

		$response = ProductFactory::getList(...$data);

		return $response;
	}

}
