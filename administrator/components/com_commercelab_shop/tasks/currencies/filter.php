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

use CommerceLabShop\Currency\CurrencyFactory;


class commercelab_shopTask_filter
{

	public function getResponse($data)
	{

		// init
		$response = [];

		$currencies = CurrencyFactory::getList(
			$data->json->getInt('limit', 0),
			$data->json->getInt('offset', 0),
			$data->json->getInt('publishedOnly', 1),
			$data->json->getString('searchTerm', null)
		);

		$response['items'] = $currencies;

		return $response;
	}

}
