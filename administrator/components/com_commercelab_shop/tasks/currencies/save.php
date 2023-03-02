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

use CommerceLabShop\Currency\Currency;
use CommerceLabShop\Currency\CurrencyFactory;
use Joomla\Input\Input;

class commercelab_shopTask_save
{

	/**
	 * @param   Input  $data
	 *
	 * @return Currency
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse(Input $data): ?Currency
	{
		return CurrencyFactory::saveFromInputData($data);
	}

}
