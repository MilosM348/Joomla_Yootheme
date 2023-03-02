<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Currency;

// no direct access
defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;
use Joomla\Input\Input;

use Brick\Money\Money;
use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Brick\Money\Context\CashContext;
use Brick\Money\Exception\UnknownCurrencyException;

use CommerceLabShop\Utilities\Utilities;

use Exception;
use stdClass;

class CurrencyFactory
{

	/**
	 *
	 * Gets the currency based on the given ID.
	 *
	 * @param $id
	 *
	 * @return Currency
	 *
	 * @since 1.5
	 */

	public static function get($id): ?Currency
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_currency'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();



		if ($result)
		{

			$currency = new Currency($result);

			return $currency;
		}

		return null;

	}

	/**
	 *
	 * Gets the current users set currency from the cookie
	 * If none is set, the currency initialisation occurs.
	 *
	 * @return null|Currency
	 *
	 * @throws Exception
	 *
	 * @since 2.0
	 */

	public static function getCurrent(): ?Currency
	{
		$instance = CurrentCurrency::getInstance();

		return $instance->getCurrency();

	}

	/**
	 *
	 * Gets the default currency
	 *
	 * @return Currency
	 *
	 * @since 1.5
	 */

	public static function getDefault(): ?Currency
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_currency'));
		$query->where($db->quoteName('default') . ' = 1');

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return new Currency($result);
		}

		return null;

	}


	/**
	 *
	 * sets the currency cookie to the set value
	 *
	 * @param $id
	 *
	 *
	 * @return bool
	 * @throws Exception
	 * @since 1.5
	 */


	public static function setCurrency($id): bool
	{

		Factory::getApplication()->input->cookie->set(
			'yps-currency',
			$id,
			0,
			Factory::getApplication()->get('cookie_path', '/'),
			Factory::getApplication()->get('cookie_domain'),
			Factory::getApplication()->isSSLConnection()
		);

		return true;
	}


	/**
	 * @param   int          $limit
	 * @param   int          $offset
	 * @param   bool         $publishedOnly
	 * @param   string|null  $searchTerm
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 *
	 *
	 * @return array
	 * @since 1.5
	 */

	public static function getList(int $limit = 0, int $offset = 0, bool $publishedOnly = null, string $searchTerm = null, string $orderBy = 'name', string $orderDir = 'ASC'): ?array
	{
		$currencies = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_currency'));

		if ($publishedOnly)
		{
			$query->where($db->quoteName('published') . ' = ' . $publishedOnly);
		}


		if ($searchTerm)
		{
			$query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{

				$currencies[] = new Currency($result);


			}


			return $currencies;
		}


		return null;


	}


	public static function format($number, $currency)
	{

	}

	/**
	 * @param         $number
	 * @param   null  $currency
	 *
	 * @return string
	 *
	 * @throws UnknownCurrencyException
	 * @throws Exception
	 * @since 1.5
	 */

	public static function translate($number, $currency = null): string
	{

		if (!$currency)
		{
			$instance = CurrentCurrency::getInstance();
			$currency = $instance->getCurrency();
		}

		$rate = $currency->rate;

		if ($rate)
		{
			$value = ($number * $rate);
		}
		else
		{
			$value = $number;
		}

		return self::formatNumberWithCurrency((int) $value, $currency->iso);


	}

	public static function translateByISO($number, $iso)
	{

		// TODO: Implement translateByISO() method.
	}

	public static function translateToInt($number, $iso)
	{

		// TODO: Implement translateToInt() method.
	}

	public static function getConversionRate($currency)
	{

		// TODO: Implement getConversionRate() method.
	}


	/**
	 * @param   Input  $data
	 *
	 * @return Currency|null
	 *
	 * @since 2.0
	 */

	public static function saveFromInputData(Input $data): ?Currency
	{


		if ($id = $data->json->get('currency_id', null))
		{

			$current = self::get($id);

			$current->iso            = $data->json->getString('iso', $current->iso);
			$current->currencysymbol = $data->json->getString('currencysymbol', $current->currencysymbol);
			$current->name           = $data->json->getString('name', $current->name);
			$current->rate           = floatval($data->json->getString('rate', $current->rate));
			$current->published      = $data->json->getInt('published', $current->published);

			if (self::commitToDatabase($current))
			{
				return $current;
			}

		}


		return null;

	}

	/**
	 * @param   Currency  $currency
	 *
	 * @return bool
	 *
	 * @since v2.0
	 */

	public static function commitToDatabase(Currency $currency): bool
	{
		$db = Factory::getDbo();

		$insert = new stdClass();

		$insert->id             = $currency->id;
		$insert->iso            = $currency->iso;
		$insert->currencysymbol = $currency->currencysymbol;
		$insert->name           = $currency->name;
		$insert->rate           = $currency->rate;
		$insert->published      = $currency->published;


		$result = $db->updateObject('#__commercelab_shop_currency', $insert, 'id');

		if ($result)
		{
			return true;
		}

		return false;


	}


	/**
	 *
	 * Takes an integer (representing the MINOR of the value - i.e. for 10 pounds, the number will be 1000)
	 * and a Currency ISO and returns the Formatted string for the value.
	 *
	 * @param   int          $number
	 * @param   string|null  $currencyISO
	 *
	 * @return string
	 *
	 * @throws UnknownCurrencyException
	 * @throws Exception
	 * @since 1.5
	 */

	public static function formatNumberWithCurrency(int $number, string $currencyISO = null, bool $percent = null): string
	{
		// try getting the current selected currency
		$instance = CurrentCurrency::getInstance();
		$currency = $instance->getCurrency();

		// if no $currencyISO is specified...
		if (!$currencyISO)
		{
			$currencyISO = $currency->iso;
		}

		// get the Joomla Locale
		$lang    = Factory::getLanguage()->getTag();
		// dd($lang);
		// $locales = $lang->getLocale();
		// $locale  = str_replace('.utf8', '', $locales[0]);

		// use Brick to format the number
		$formatter = new \NumberFormatter($lang, \NumberFormatter::CURRENCY);
		// $formatter->setPattern('#,## ¤');

		// dd($currency->currencysymbol);
		$formatter->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $currency->currencysymbol);
		if ($percent)
		{
			$formatter = new \NumberFormatter($lang, \NumberFormatter::PERCENT);
			$formatter->setSymbol(\NumberFormatter::PERCENT_SYMBOL, '%');
		}

		$money = Money::ofMinor($number, $currencyISO);

		// dd($formatter);
		return $money->formatWith($formatter); // example:  €220.00


	}

	/**
	 * @param   int          $number
	 * @param   string|null  $currencyISO
	 *
	 * @return BigDecimal
	 *
	 * @throws UnknownCurrencyException
	 * @throws Exception
	 * @since 2.0
	 */

	public static function toFloat(int $number, string $currencyISO = null): BigDecimal
	{

		// if no $currencyISO is specified...
		if (!$currencyISO)
		{

			// try getting the current selected currency
			$instance = CurrentCurrency::getInstance();
			$currency = $instance->getCurrency();

			$currencyISO = $currency->iso;

		}

		$float = Money::ofMinor($number, $currencyISO, new CashContext(1), RoundingMode::HALF_UP);

		return $float->getAmount();


	}

	/**
	 * @param   float        $number
	 * @param   string|null  $currencyISO
	 *
	 * @return int
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function toInt(float $number, string $currencyISO = null): int
	{

		// if no $currencyISO is specified...
		if (!$currencyISO)
		{

			// try getting the current selected currency
			// try getting the current selected currency
			$instance = CurrentCurrency::getInstance();
			$currency = $instance->getCurrency();
			if ($currency)
			{
				$currencyISO = $currency->iso;
			}


		}

		$int = Money::of($number, $currencyISO, new CashContext(1), RoundingMode::HALF_UP);
		return $int->getMinorAmount()->toInt();

	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function togglePublishedFromInputData(Input $data): bool
	{


		$response = true;

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		foreach ($items as $item)
		{

			$query = 'UPDATE ' . $db->quoteName('#__commercelab_shop_currency') . ' SET ' . $db->quoteName('published') . ' = IF(' . $db->quoteName('published') . '=1, 0, 1) WHERE ' . $db->quoteName('id') . ' = ' . $db->quote($item['id']) . ';';
			$db->setQuery($query);
			$result = $db->execute();

			if (!$result)
			{
				$response = false;
			}

		}

		return $response;
	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function toggleDefaultFromInputData(Input $data): bool
	{

		$response = true;

		$db = Factory::getDbo();

		$item = $data->json->get('item', '', 'ARRAY');

		if (!$item)
		{
			return false;
		}


		//first set all items to 0
		$query      = $db->getQuery(true);
		$fields     = array($db->quoteName('default') . ' = 0');
		$conditions = array($db->quoteName('default') . ' = 1');
		$query->update($db->quoteName('#__commercelab_shop_currency'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();


		$object            = new stdClass();
		$object->id        = $item['id'];
		$object->default   = 1;
		$object->published = 1;

		$result = $db->updateObject('#__commercelab_shop_currency', $object, 'id');

		if (!$result)
		{
			$response = false;
		}


		return $response;
	}


	/**
	 *
	 * Just gets the first published currency - used for initialising a currency
	 *
	 * @return Currency
	 *
	 * @since version
	 */

	private static function getAPublishedCurrency(): ?Currency
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__commercelab_shop_currency'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->order('id ASC');
		$db->setQuery($query);

		$id = $db->loadResult();

		return self::get($id);

	}


	/**
	 *
	 * Initialises the currency in the cookie if there is none already set.
	 *
	 *
	 * @return Currency
	 *
	 * @throws Exception
	 * @since 1.5
	 */

	public static function initCurrency(): ?Currency
	{
		$currency = self::getAPublishedCurrency();

		Factory::getApplication()->input->cookie->set(
			'yps-currency',
			$currency->id,
			0,
			Factory::getApplication()->get('cookie_path', '/'),
			Factory::getApplication()->get('cookie_domain'),
			Factory::getApplication()->isSSLConnection()
		);

		return $currency;

	}

}
