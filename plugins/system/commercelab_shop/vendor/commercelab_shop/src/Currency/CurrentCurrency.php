<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Currency;

use Exception;
use Joomla\CMS\Factory;

/**
 *
 * Singleton to grab the current currency... it may be "anti-pattern" but it saves a TON of DB queries.
 *
 * @package     CommerceLabShop\Currency
 *
 * @since       2.0
 */

class CurrentCurrency
{
    // Hold the class instance.
	private static $instance = null;
	private $currency;


	/**
	 * @throws Exception
	 * @since 2.0
	 */

	private function __construct()
	{

		// get the current cookie stored currency
		$currency_id = Factory::getApplication()->input->cookie->get('yps-currency');

		// if there is no currency stored in the cookie...
		if (!$currency_id)
		{
			// then init the currency using the factory
			$this->currency = CurrencyFactory::initCurrency();

			// if there is a store currency in the cookie then...
		} else {

			// go to the database and get that particular currency
			$this->currency = CurrencyFactory::get($currency_id);
		}




	}

	/**
	 *
	 * @return CurrentCurrency|null
	 *
	 * @since 2.0
	 */

	public static function getInstance(): ?CurrentCurrency
	{
		if (!self::$instance)
		{
			self::$instance = new CurrentCurrency();
		}

		return self::$instance;
	}

	/**
	 *
	 * @return Currency|null
	 *
	 * @since 2.0
	 */

	public function getCurrency(): ?Currency
	{
		return $this->currency;
	}
}
