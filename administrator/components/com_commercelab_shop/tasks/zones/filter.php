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

use CommerceLabShop\Country\CountryFactory;
use Joomla\Input\Input;

class commercelab_shopTask_filter
{

	public function getResponse(Input $data)
	{

		// init
		$response = array();


		$publishedOnly = $data->json->getInt('publishedOnly', false);

		$response['zones'] = CountryFactory::getZoneList(
			$data->json->getInt('limit', 0),
			$data->json->getInt('offset', 0),
			$publishedOnly,
			$data->json->getString('searchTerm', null),
			$data->json->getInt('country_id', 0)
		);



		return $response;
	}

}
