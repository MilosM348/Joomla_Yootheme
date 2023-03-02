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

use Brick\Money\Exception\UnknownCurrencyException;
use Joomla\Input\Input;

use CommerceLabShop\Price\PriceFactory;
use \CommerceLabShop\Price\Price;


class commercelab_shopTask_calculateprice
{

	/**
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */
	public function getResponse(Input $data): Price
	{
		return PriceFactory::calculatePriceFromInputData($data);
	}

}
