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

use CommerceLabShop\Product\ProductFactory;

use Brick\Money\Exception\UnknownCurrencyException;

class commercelab_shopTask_checkvariantavailability
{

	/**
	 * @since 2.0
	 */
	public function getResponse(Input $data): array
	{
		return ProductFactory::checkVariantAvailability($data->json->getInt('joomla_item_id'), $data->json->getString('selected'));
	}

}
