<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Discount;

// no direct access
defined('_JEXEC') or die('Restricted access');


use Brick\Money\Exception\UnknownCurrencyException;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Input\Input;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Utilities\Utilities;
use stdClass;


class DiscountFactory
{


	/**
	 *
	 * Gets the discount based on the given ID.
	 *
	 * @param $id
	 *
	 * @return Discount
	 *
	 * @since 2.0
	 */

	public static function get($id): ?Discount
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_discount'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{

			return new Discount($result);
		}

		return null;

	}


	/**
	 * @param   int          $limit
	 * @param   int          $offset
	 * @param   string|null  $searchTerm
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 *
	 *
	 * @return array
	 * @since 1.5
	 */

	public static function getList(int $limit = 0, int $offset = 0, bool $publishedOnly = false, string $searchTerm = null, string $orderBy = 'id', string $orderDir = 'DESC'): ?array
	{

		// init items
		$items = array();

		// get the Database
		$db = Factory::getDbo();

		// set initial query
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_discount'));
		if ($publishedOnly)
		{
			$query->where($db->quoteName('published') . ' = 1');
		}


		// if there is a search term, iterate over the columns looking for a match
		if ($searchTerm)
		{
			$query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();
		
		// only proceed if there's any rows
		if ($results)
		{
			// iterate over the array of objects, initiating the Class.
			foreach ($results as $result)
			{
				$items[] = new Discount($result);

			}

			return $items;
		}

		return null;

	}

	/**
	 * @param   int  $discount_type
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	public static function getDiscountTypeAsString(int $discount_type): string
	{

		$language = Factory::getLanguage();
		$language->load('com_commercelab_shop');

		switch ($discount_type)
		{
			case 1 :
				return Text::_('COM_COMMERCELAB_SHOP_ADD_DISCOUNTS_MODAL_DISCOUNT_TYPE_AMOUNT');
			case 2 :
				return Text::_('COM_COMMERCELAB_SHOP_ADD_DISCOUNTS_MODAL_DISCOUNT_TYPE_PERCENT');
			case 3 :
				return Text::_('COM_COMMERCELAB_SHOP_ADD_DISCOUNTS_MODAL_DISCOUNT_TYPE_FREE_SHIPPING');
		}

		return '';

	}

	/**
	 * @param   int    $amount
	 * @param   float  $percentage
	 * @param   int    $type
	 *
	 *
	 * @return string|void
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */


	public static function getDiscountAmountFormatted(?int $amount, ?float $percentage, int $type)
	{

		switch ($type)
		{
			case 1:
				return CurrencyFactory::formatNumberWithCurrency($amount);
			case 2 :
				return $percentage . "%";
			case 3 :
				return "-";
		}

	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return Discount
	 * @since 2.0
	 */


	public static function saveFromInputData(Input $data): ?Discount
	{


		if ($id = $data->json->get('itemid', null, 'INT'))
		{

			$currentDiscount = self::get($id);

			$amount     = $data->json->getInt('amount', $currentDiscount->amount);
			$percentage = $data->json->getString('percentage', $currentDiscount->percentage);

			$discountType = $data->json->getInt('discount_type', $currentDiscount->discount_type);


			switch ($discountType)
			{
				case 1:
					$percentage = 0;
					break;
				case 2:
					$amount = 0;
					break;
				case 3:
					$amount     = 0;
					$percentage = 0;
					break;
			}
			
			$currentDiscount->name          = $data->json->getString('name', $currentDiscount->name);
			$currentDiscount->amount        = $amount;
			$currentDiscount->percentage    = $percentage;
			$currentDiscount->discount_type = $data->json->getInt('discount_type', $currentDiscount->discount_type);
			$currentDiscount->coupon_code   = $data->json->getString('coupon_code', $currentDiscount->coupon_code);
			$currentDiscount->start_date    = $data->json->getString('start_date', $currentDiscount->start_date);
			$currentDiscount->expiry_date   = $data->json->getString('expiry_date', $currentDiscount->expiry_date);
			$currentDiscount->max_usage     = $data->json->getInt('max_usage', $currentDiscount->max_usage);
			// $currentDiscount->user_id       = $data->json->getInt('user_id', $currentDiscount->user_id);
			$currentDiscount->published     = $data->json->getInt('published', $currentDiscount->published);
			$currentDiscount->modified      = Utilities::getDate();
			$currentDiscount->modified_by   = Factory::getUser()->id;

			if (self::commitToDatabase($currentDiscount))
			{
				return $currentDiscount;
			}

		}
		else
		{

			if ($discount = self::createFromInputData($data))
			{
				return $discount;
			}

		}

		return null;
	}

	/**
	 * @param   Input  $data
	 *
	 * @return Discount|bool
	 *
	 * @since 2.0
	 */


	private static function createFromInputData(Input $data): Discount
	{

		$db = Factory::getDbo();

		$amount     = $data->json->getInt('amount', 0);
		$percentage = $data->json->getInt('percentage', 0);

		$discountType = $data->json->getInt('discount_type');


		switch ($discountType)
		{
			case 1:
				$percentage = 0;
				break;
			case 2:
				$amount = 0;
				break;
			case 3:
				$amount     = 0;
				$percentage = 0;
				break;
		}


		$discount                = new stdClass();
		$discount->name          = $data->json->getString('name');
		$discount->amount        = $amount;
		$discount->discount_type = $discountType;
		$discount->percentage    = $percentage;
		$discount->coupon_code   = $data->json->getString('coupon_code');
		if ($data->json->getString('start_date', null) != '')
		{
			$discount->start_date = $data->json->getString('start_date', null);
		}
		if ($data->json->getString('expiry_date', null) != '')
		{
			$discount->expiry_date = $data->json->getString('expiry_date', null);
		}
		$discount->max_usage     = $data->json->getInt('max_usage');
		// $discount->user_id       = $data->json->getInt('user_id');
		$discount->published     = $data->json->getInt('published');
		$discount->created       = Utilities::getDate();
		$discount->created_by    = Factory::getUser()->id;
		$discount->modified      = Utilities::getDate();
		$discount->modified_by   = Factory::getUser()->id;


		$result = $db->insertObject('#__commercelab_shop_discount', $discount);

		if ($result)
		{
			return self::get($db->insertid());
		}

		return false;


	}

	/**
	 * @param   Discount  $discount
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */


	private static function commitToDatabase(Discount $discount): bool
	{

		$db = Factory::getDbo();

		/** @var Discount $insert */
		$insert = new stdClass();

		$insert->id            = $discount->id;
		$insert->name          = $discount->name;
		$insert->amount        = $discount->amount;
		$insert->percentage    = $discount->percentage;
		$insert->discount_type = $discount->discount_type;
		$insert->coupon_code = $discount->coupon_code;

		if ($discount->start_date != '')
		{
			$insert->expiry_date = $discount->start_date;
		}
		if ($discount->expiry_date != '')
		{
			$insert->expiry_date   = $discount->expiry_date;
		}
		$insert->max_usage     = $discount->max_usage;
		// $insert->user_id       = $discount->user_id;
		$insert->published     = $discount->published;
		$insert->modified      = $discount->modified;
		$insert->modified_by   = $discount->modified_by;

		$result = $db->updateObject('#__commercelab_shop_discount', $insert, 'id');

		if ($result)
		{
			return true;
		}

		return false;

	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function trashFromInputData(Input $data): bool
	{

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		foreach ($items as $item)
		{
			$query      = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($item['id'])
			);
			$query->delete($db->quoteName('#__commercelab_shop_discount'));
			$query->where($conditions);
			$db->setQuery($query);
			$db->execute();

		}

		return true;

	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function togglePublishedFromInputData(Input $data)
	{


		$response = true;

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		foreach ($items as $item)
		{
			$query = 'UPDATE ' . $db->quoteName('#__commercelab_shop_discount') . ' SET ' . $db->quoteName('published') . ' = IF(' . $db->quoteName('published') . '=1, 0, 1) WHERE ' . $db->quoteName('id') . ' = ' . $db->quote($item['id']) . ';';
			$db->setQuery($query);
			$result = $db->execute();

			if (!$result)
			{
				$response = false;
			}

		}

		return $response;
	}





}
