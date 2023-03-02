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

use CommerceLabShop\Email\EmailFactory;


class commercelab_shopTask_filter
{

	public function getResponse($data)
	{

		$type = 'Email';

		// init
		$response = array();


		$searchTerm = $data->json->getString('searchTerm', null);

		if($searchTerm == "null") {
			$searchTerm = null;
		}

		$items = EmailFactory::getList(
			$data->json->getInt('limit', 0),
			$data->json->getInt('offset', 0),
			$searchTerm
		);

		$response['items'] = $items;

		return $response;
	}

}
