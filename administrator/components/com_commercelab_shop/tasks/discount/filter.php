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

use CommerceLabShop\Discount\DiscountFactory;


class commercelab_shopTask_filter
{

	public function getResponse($data)
	{

		// init
		$response = array();
		$publishedOnly = $data->json->get('publishedOnly', false) === "true";
		$searchTerm    = $data->json->getString('searchTerm', null);

		if ($searchTerm == "null") {
			$searchTerm = null;
		}

		$discounts = DiscountFactory::getList(
			$data->json->getInt('limit', 0),
			$data->json->getInt('offset', 0),
			$publishedOnly,
			$searchTerm
		);

		$response['items'] = $discounts;

		return $response;
	}

}
