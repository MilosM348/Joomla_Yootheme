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

use CommerceLabShop\Tandcs\TandcsFactory;

class commercelab_shopTask_toggle
{

	public function getResponse($data)
	{

		// init
		$response = [];

		$response['toggle'] = TandcsFactory::toggle($data->json->get('state'));

		return $response;
	}

}
