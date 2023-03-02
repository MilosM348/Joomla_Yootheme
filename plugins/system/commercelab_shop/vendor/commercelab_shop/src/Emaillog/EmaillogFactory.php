<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
namespace CommerceLabShop\Emaillog;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Utilities\Utilities;
use stdClass;

class EmaillogFactory
{

	/**
	 * @param   int  $id
	 *
	 * @return Emaillog
	 *
	 * @since 2.0
	 */

	public static function get(int $id): ?Emaillog
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_email_log'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();
		if ($result && is_object($result))
		{
			return new Emaillog($result);
		}

		return null;
	}

	/**
	 * @param   int          $limit
	 * @param   int          $offset
	 * @param   string|null  $searchTerm
	 * @param   int|null     $customerId
	 * @param   int|null     $orderId
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 * @param   string|null  $dateFrom
	 * @param   string|null  $dateTo
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getList(int $limit = 0, int $offset = 0, string $searchTerm = null, int $customerId = null, int $orderId = null, string $orderBy = 'created', string $orderDir = 'DESC', string $dateFrom = null, string $dateTo = null): ?array
	{


		$emailLogs = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_email_log'));

		if ($searchTerm)
		{
			$query->where($db->quoteName('emailaddress') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			$query->where($db->quoteName('emailtype') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}


		if ($customerId)
		{
			$query->where($db->quoteName('customer_id') . ' = ' . $db->quote($customerId));
		}

		if ($orderId)
		{
			$query->where($db->quoteName('order_id') . ' = ' . $db->quote($orderId));
		}

		if ($dateFrom)
		{
			$query->where($db->quoteName('order_date') . ' >= ' . $db->quote($dateFrom));
		}

		if ($dateTo)
		{
			$query->where($db->quoteName('order_date') . ' <= ' . $db->quote($dateTo));
		}

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{
				$emailLogs[] = new Emaillog($result);

			}

			return $emailLogs;
		}


		return null;


	}

	/**
	 * @param $customer_id
	 *
	 * @return string|null
	 *
	 * @since 2.0
	 */


	public static function getCustomerName($customer_id): ?string
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('name');
		$query->from($db->quoteName('#__commercelab_shop_customer'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($customer_id));

		$db->setQuery($query);

		return $db->loadResult();


	}

	/**
	 * @param $order_id
	 *
	 * @return string|null
	 *
	 * @since 2.0
	 */


	public static function getOrderNumber($order_id): ?string
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('order_number');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($order_id));

		$db->setQuery($query);

		return $db->loadResult();

	}

	/**
	 * @param $user_id
	 *
	 * @return string|null
	 *
	 * @since 2.0
	 */


	public static function getCreatedName($user_id): ?string
	{

		return Factory::getUser($user_id)->name;

	}

	/**
	 * @param   string  $emailaddress
	 * @param   string  $emailtype
	 * @param   int     $customer_id
	 * @param   int     $order_id
	 *
	 *
	 * @since 2.0
	 */


	public static function log(string $emailaddress, string $emailtype, int $customer_id, int $order_id, string $error = null)
	{

		$userid = (Factory::getUser()->id ? Factory::getUser()->id : 0);

		$object               = new stdClass();
		$object->id           = 0;
		$object->emailaddress = $emailaddress;
		$object->emailtype    = $emailtype;
		$object->sentdate     = Utilities::getDate();
		$object->customer_id  = $customer_id;
		$object->order_id     = $order_id;
		$object->created_by   = $userid;
		$object->params       = ($error) ? $error : "{}";
		$object->modified_by  = $userid;
		$object->created      = Utilities::getDate();
		$object->modified     = Utilities::getDate();

		Factory::getDbo()->insertObject('#__commercelab_shop_email_log', $object);

	}


}
