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

use CommerceLabShop\Optiontemplates\Optiontemplates;


class commercelab_shopTask_filteroptions
{

	public function getResponse($data)
	{
		
		// init
		$response = array();


		$response['items'] = Optiontemplates::getFilteroptionsList(
			$data->getString('searchTerm', null),
			$data->getInt('template_id', null),
			
		);


		return $response;
	}

}
