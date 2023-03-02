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
use Joomla\Input\Input;

class commercelab_shopTask_refreshvariants
{

	/**
	 * @param   Input  $data
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function getResponse(Input $data): array
	{
		return ProductFactory::getRefreshedVariantData($data);
	}

}
