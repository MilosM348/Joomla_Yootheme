<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Customer;

// no direct access
defined('_JEXEC') or die('Restricted access');


use Brick\Money\Exception\UnknownCurrencyException;

use Joomla\CMS\Factory;
use Joomla\Input\Input;
use Joomla\CMS\User\User;

use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Currency\CurrencyFactory;

use stdClass;

class CustomerFactory
{


	/**
	 *
	 * Gets the customer based on the given ID.
	 *
	 * @param $id
	 *
	 * @return Customer
	 *
	 * @since 2.0
	 */

	public static function get($id = null): ?Customer
	{

		$db   = Factory::getDbo();
		$user = UserFactory::getActiveUser();

		if ($user->guest === 1 && is_null($id))
		{
			return null;
		}


		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_customer'));

		if (!is_null($id))
		{
			$query->where($db->quoteName('id') . ' = ' . $db->quote($id));
		}
		else if ($user->guest === 0)
		{
			$query->where($db->quoteName('j_user_id') . ' = ' . $db->quote($user->id));
		}

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return new Customer($result);
		}
		else
		{
			return null;
		}

	}

	/**
	 *
	 * Gets the customer based on the given ID.
	 *
	 * @param $id
	 *
	 * @return Customer
	 *
	 * @since 2.0
	 */

	public static function create($j_user_id = null): ?Customer
	{

		if (UserFactory::getActiveUser()->guest) {
			return null;
		} else {
			$user = ($j_user_id) ? Factory::getUser($j_user_id) : UserFactory::getActiveUser();
		}

		$db   = Factory::getDbo();

		$query = $db->getQuery(true);

		$object            = new stdClass;
		$object->id        = 0;
		$object->j_user_id = $user->id;
		$object->email     = $user->email;
		$object->name      = $user->name;
		$object->published = 1;
		$object->created   = Utilities::getDate();

		$insert = $db->insertObject('#__commercelab_shop_customer', $object);

		if ($insert) {
			return CustomerFactory::get($db->insertid());
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


	public static function getList(int $limit = 0, int $offset = 0, string $searchTerm = null, string $orderBy = 'name', string $orderDir = 'DESC'): ?array
	{

		// init items
		$items = array();

		// get the Database
		$db = Factory::getDbo();

		// set initial query
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_customer'));


		// if there is a search term, iterate over the columns looking for a match
		if ($searchTerm)
		{
			$query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}

		// Remove Guest CUstomers from this List
		// $query->where($db->quoteName('temp_id') . ' IS NULL');

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		// only proceed if there's any rows
		if ($results)
		{
			// iterate over the array of objects, initiating the Class.
			foreach ($results as $result)
			{
				$items[] = new Customer($result);

			}

			return $items;
		}

		return null;

	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	// This saveFromInputData methods are ambiguous, we can't know who is calling
	// when adding methods like this it is recommended to put some comments, in this case, when the customer is created

	// In this case, this seems to be an option to manually update customer's data
	// For now we create customers upon order is processed

	public static function saveFromInputData(Input $data): bool
	{

		$customer = json_decode($data->json->getString('customer'));

		$result = Factory::getDbo()->updateObject('#__commercelab_shop_customer', $customer, 'id');

		if ($result)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	/**
	 * @param $id
	 *
	 * @return User
	 *
	 * @since version
	 */

	public static function getUser($joomla_user_id): User
	{
		return User::getInstance($joomla_user_id);
	}

	/**
	 * @param $id  - customer id NOT Joomla user ID
	 *
	 *
	 * @since 2.0
	 */


	public static function getCustomersOrders($cusomter_id): ?array
	{
		return OrderFactory::getList(0, 0, null, $cusomter_id);
	}


	/**
	 * @param          $orders
	 * @param   false  $integer
	 *
	 * @return int|mixed|string
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 *
	 */

	public static function getOrderTotal($orders, bool $integer = false)
	{


		// set $total to 0 (sets an int)
		$total = 0;

		// make sure we have orders
		if ($orders)
		{
			// iterate through the orders adding to the integer total
			foreach ($orders as $order)
			{
				$total += $order->order_total;
			}

		}

		// if $integer is set to "true" then simply return the integer
		if ($integer)
		{
			return $total;
		}


		// if $integer is "false" but default, then go get the formatted currency string
		return CurrencyFactory::formatNumberWithCurrency($total);


	}

	/**
	 * @param $customer_id
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function getCustomerAddresses($customer_id): ?array
	{
		return AddressFactory::getList(0, 0, null, 'id', 'desc', $customer_id);
	}


	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */

	public static function trashFromInputData(Input $data)
	{

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');

		/** @var Product $item */
		foreach ($items as $item_id)
		{
			$query      = $db->getQuery(true);
			$conditions = [
				$db->quoteName('id') . ' = ' . $db->quote($item_id)
			];
			$query->delete($db->quoteName('#__commercelab_shop_customer'));
			$query->where($conditions);
			$db->setQuery($query);
			$db->execute();

		}

		return true;

		// $db = Factory::getDbo();

		// $query = $db->getQuery(true);

		// $conditions = array(
		// 	$db->quoteName('user_id') . ' = ' . $db->quote($user_id)
		// );

		// $query->delete($db->quoteName('#__user_profiles'));
		// $query->where($conditions);

		// $db->setQuery($query);

		// $db->execute();



		// $query = $db->getQuery(true);

		// $conditions = array(
		// 	$db->quoteName('id') . ' = ' . $db->quote($user_id)
		// );

		// $query->delete($db->quoteName('#__users'));
		// $query->where($conditions);

		// $db->setQuery($query);

		// $db->execute();


		// $query = $db->getQuery(true);

		// $conditions = array(
		// 	$db->quoteName('customer_id') . ' = ' . $db->quote($customer_id)
		// );

		// $query->delete($db->quoteName('#__commercelab_shop_customer_address'));
		// $query->where($conditions);

		// $db->setQuery($query);

		// $db->execute();

		// $query = $db->getQuery(true);

		// $conditions = array(
		// 	$db->quoteName('customer_id') . ' = ' . $db->quote($customer_id)
		// );

		// $query->delete($db->quoteName('#__commercelab_shop_order'));
		// $query->where($conditions);

		// $db->setQuery($query);

		// $db->execute();


		return true;
	}

}
