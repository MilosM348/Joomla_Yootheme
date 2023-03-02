<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access


// TODO - Probably not in use any more, as we are using Joomla Modal Category view

defined('_JEXEC') or die('Restricted access');

use CommerceLabShop\Product\ProductFactory;
use Joomla\Input\Input;

class commercelab_shopTask_changeCategory
{

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse(Input $data): bool
	{


		return ProductFactory::batchUpdateCategory($data);


	}

}
