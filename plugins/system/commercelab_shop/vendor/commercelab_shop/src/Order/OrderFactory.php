<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Order;

defined('_JEXEC') or die('Restricted access');

use Exception;
use Joomla\CMS\Factory;
use Joomla\Input\Input;
use Joomla\CMS\User\User;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;

use CommerceLabShop\Checkoutnote\CheckoutnoteFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Customer\CustomerFactory;
use CommerceLabShop\Emaillog\EmaillogFactory;
use CommerceLabShop\Language\LanguageFactory;
use CommerceLabShop\Shipping\ShippingFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Coupon\CouponFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Total\TotalFactory;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Address\Address;
use CommerceLabShop\Cart\CartItem;
use CommerceLabShop\Tax\TaxFactory;

use Brick\Money\Exception\UnknownCurrencyException;

use stdClass;


class OrderFactory
{


	/**
	 * @param   int  $id
	 *
	 * @return Order
	 *
	 * @since 2.0
	 */

	public static function get(int $id): ?Order
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();
		if ($result && is_object($result))
		{
			return new Order($result);
		}

		return null;
	}

	public static function getCallbackLogs() :array
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_callback_log'));

		$db->setQuery($query);

		$result = $db->loadObjectList();

		if ($result)
		{
			return $result;
		}

		return [];
	}


	/**
	 * @param   int  $id
	 *
	 * @return total Order count
	 *
	 * @since 2.0
	 */

	public static function totalOrders() {
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$db->setQuery($query);
		$result = $db->loadObjectList(); 
		return count($result);
	}
	

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */

	public static function trashFromInputData(Input $data): bool
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
			$query->delete($db->quoteName('#__commercelab_shop_order'));
			$query->where($conditions);
			$db->setQuery($query);
			$db->execute();

		}

		return true;

	}

		/**
	 * @param   int  $id
	 *
	 * @return total Order sales count
	 *
	 * @since 2.0
	 */

	public static function totalSales() {

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('SUM(order_total) as order_total,currency')
			->from($db->quoteName('#__commercelab_shop_order'))
			->where($db->quoteName('order_paid') . ' = ' . $db->quote('1'));

		$db->setQuery($query);

		$result = $db->loadObject();
	
		if(!empty($result->order_total))
		{
			return self::intToFormat($result->order_total, $result->currency);
		}
		else
		{
			return 0;	
		}
		
	}	


	/**
	 * @param   int          $limit
	 *
	 * @param   int          $offset
	 * @param   string|null  $searchTerm
	 * @param   int|null     $customerId
	 * @param   string|null  $status
	 * @param   string|null  $currency
	 * @param   string|null  $dateFrom
	 * @param   string|null  $dateTo
	 *
	 * @return array
	 * @since 2.0
	 */

	public static function getList(int $limit = 20, int $offset = 0, string $searchTerm = null, int $customerId = null, string $status = null, string $currency = null, string $dateFrom = null, string $dateTo = null, $orderBy = 'o.id', $orderDir = 'DESC'): ?array
	{


		$response = ['items' => []];

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select(['o.*']);
		// $query->select(['o.*', 'c.name']);
		$query->from($db->quoteName('#__commercelab_shop_order', 'o'));

		// Customers
    	// $query->join('INNER', $db->quoteName('#__commercelab_shop_customer', 'c') . ' ON ' . $db->quoteName('o.customer_id') . ' = ' . $db->quoteName('c.id'));

		$response['totalitems'] = count($db->setQuery($query)->loadColumn());

		if ($searchTerm)
		{
			$query->where($db->quoteName('order_number') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}

		if ($currency)
		{
			$query->where($db->quoteName('currency') . ' = ' . $db->quote($currency));
		}

		if ($status)
		{
			$query->where($db->quoteName('order_status') . ' = ' . $db->quote($status));
		}

		if ($customerId)
		{
			$query->where($db->quoteName('customer_id') . ' = ' . $db->quote($customerId));
		}
		if ($dateTo)
		{
			$query->where($db->quoteName('order_date') . ' <= ' . $db->quote($dateTo . ' 23:59:59'));
		}

		if ($dateFrom)
		{
			$query->where($db->quoteName('order_date') . ' >= ' . $db->quote($dateFrom . ' 00:00:00'));
		}

		$query->order($orderBy . ' ' . $orderDir);

		$response['totalfiltered'] = count($db->setQuery($query)->loadColumn());

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();
		$response['totalshowing'] = count($results);

		$response['query'] = $query->__toString();

		if (count($results))
		{
			foreach ($results as $result)
			{
				$response['items'][] =  new Order($result);

			}

		}
		else
		{
			$response['items'] = [];
		}

		return $response;

	}

	/**
	 * @param   int  $order_id
	 * @param   bool $with_prefix
	 *
	 * @return mixed|null
	 *
	 * @since 2.0
	 */


	public static function getLastOrderNumber(bool $with_prefix = false)
	{

		$configcls = ConfigFactory::get();
		$prefix    = $configcls->get('order_prefix');

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('id, order_number');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$query->order('id DESC');

		$db->setQuery($query);
		$result = $db->loadObject();


		// No previous Orders, get starting number from config
		if (!$result) {
			$order_number = (int) $configcls->get('order_start', 1);
		} else {
			$order_number = (int) str_replace($prefix, '', $result->order_number);
		}

		if ($with_prefix) {
			return $prefix . $order_number;
		} else {
			return $order_number;
		}

	}

	/**
	 * @param   int  $order_id
	 *
	 * @return mixed|null
	 *
	 * @since 2.0
	 */


	public static function getNextOrderNumber(bool $with_prefix = false)
	{

		$configcls = ConfigFactory::get();
		$prefix    = (!$with_prefix) ? '' : $configcls->get('order_prefix');

		$prev_order_number = self::getLastOrderNumber();

		if ($with_prefix) {
			return $prefix . ($prev_order_number + 1);
		} else {
			return $prev_order_number + 1;
		}

	}

	/**
	 * @param $order_id
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getOrderedProducts($order_id): ?array
	{

		$products = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_order_products'));
		$query->where($db->quoteName('order_id') . ' = ' . $db->quote($order_id));

		$db->setQuery($query);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{
				$products[] = new OrderedProduct($result);

			}

			return $products;
		}


		return null;


	}


	/**
	 *
	 * careful now....
	 *
	 * Ok... we need to grab the order then compare the order date with the expiry date set in the component config.
	 *
	 *
	 * @param   string  $hash
	 *
	 * @return Order|null
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function getOrderByHash(string $hash): ?Order
	{

		// get the component config
		$params = ConfigFactory::get();

		// grab the expiry time in minutes (int)
		$expiry = $params->get('hash_expiry', 1);


		// get the order id via the hash string
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$query->where($db->quoteName('hash') . ' = ' . $db->quote($hash));

		$db->setQuery($query);

		$id = $db->loadResult();

		// if there is an id...
		if ($id)
		{

			// go get the full order
			$order = self::get($id);

			// get a Date() object of the order date
			$orderDate = new Date($order->order_date);

			// get a Date() object of the expiry... so now minus however amount of minutes.
			$expiryDate = new Date('now +1 hour -' . $expiry . ' minutes');

			$expiryDate = $expiryDate->toSQL();
			// if the order date is more than the expiry date... then we're good to go.
			if ($orderDate > $expiryDate)
			{
				return $order;
			}

		}

		return null;

	}
	/**
	 * @param   int  $id
	 *
	 * @return Order
	 *
	 * @since 2.0
	 */

	public static function getOrderIdViaNumber(int $order_number): int
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$query->where($db->quoteName('order_number') . ' = ' . $db->quote($order_number));

		$db->setQuery($query);

		$result = $db->loadResult();
		if ($result)
		{
			return $result;
		}

		return null;
	}
	/**
	 * @param   int     $order_id
	 * @param   int     $limit
	 * @param   int     $offset
	 * @param   string  $orderBy
	 * @param   string  $orderDir
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getOrderLogs(int $order_id, int $limit = 0, int $offset = 0, string $orderBy = 'created', string $orderDir = 'DESC'): ?array
	{
		$orderLogs = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_order_log'));

		$query->where($db->quoteName('order_id') . ' = ' . $db->quote($order_id));

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{
				$orderLogs[] = new Orderlog($result);

			}

			return $orderLogs;
		}


		return null;

	}

	/**
	 * @param $order_id
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function getEmailLogs($order_id): ?array
	{
		return EmaillogFactory::getList(0, 0, '', null, $order_id);

	}


	/**
	 * Function to save a new Order Log
	 *
	 * @param   int     $order_id
	 * @param   string  $note
	 *
	 *
	 * @since 2.0
	 */

	public static function log(int $order_id, string $note)
	{

		$object             = new stdClass();
		$object->id         = 0;
		$object->order_id   = $order_id;
		$object->note       = $note;
		$object->created_by = Factory::getUser()->id;
		$object->created    = Utilities::getDate();


		Factory::getDbo()->insertObject('#__commercelab_shop_order_log', $object);

	}

	/**
	 * @param   int  $address_id
	 *
	 * @return Address
	 *
	 * @since 2.0
	 */


	public static function getAddress(int $address_id): ?Address
	{

		return AddressFactory::get($address_id);

	}

	/**
	 * @param   int     $order_id
	 * @param   int     $limit
	 * @param   int     $offset
	 * @param   string  $orderBy
	 * @param   string  $orderDir
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getOrderNotes(int $order_id, int $limit = 0, int $offset = 0, string $orderBy = 'created', string $orderDir = 'ASC'): ?array
	{
		$orderNotes = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_order_notes'));
		$query->where($db->quoteName('order_id') . ' = ' . $db->quote($order_id));

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{
				$orderNotes[] = new Ordernote($result);

			}

			return $orderNotes;
		}


		return null;
	}

	/**
	 * @param $order_id
	 * @param $note
	 *
	 *
	 * @since 2.0
	 */

	public static function note($order_id, $note)
	{

		$object             = new stdClass();
		$object->id         = 0;
		$object->order_id   = $order_id;
		$object->note       = $note;
		$object->created_by = Factory::getUser()->id;
		$object->created    = Utilities::getDate();


		Factory::getDbo()->insertObject('#__commercelab_shop_order_notes', $object);

	}

	/**
	 * @param $note_id
	 * @param $note
	 *
	 *
	 * @since 2.0
	 */

	public static function updateNote($note_id, $note)
	{
		$object       = new stdClass();
		$object->id   = $note_id;
		$object->note = $note;


		Factory::getDbo()->updateObject('#__commercelab_shop_order_notes', $object, 'id');


	}


	/**
	 * @param   int          $int
	 * @param   string|null  $currency
	 *
	 * @return string
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function intToFormat(int $int, string $currency = null): string
	{

		return CurrencyFactory::formatNumberWithCurrency($int, $currency);

	}

	/**
	 * @param   int          $int
	 * @param   string|null  $currency
	 *
	 * @return string
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function intToFloat(int $int, string $currency = null): string
	{

		return CurrencyFactory::toFloat($int, $currency);


	}

	/**
	 *
	 * Gets the currency for the order... we *CAN'T* instantiate the Order class here with self::get() as
	 * we need this function for the OrderedProduct class...
	 * calling the Order would cause an infinite loop
	 *
	 * @param $id
	 *
	 * @return string
	 *
	 * @since 2.0
	 */


	public static function getOrderCurrency($id): string
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('currency');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		return $db->loadResult();


	}

	/**
	 * @param $user_id
	 *
	 * @return User
	 *
	 * @since 2.0
	 */


	public static function getUser($user_id): User
	{

		return Factory::getUser($user_id);

	}

	/**
	 * @param $customer_id
	 *
	 * @return mixed|null
	 *
	 * @since 2.0
	 */


	public static function getCustomer($customer_id)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select(array('name', 'email'));
		$query->from($db->quoteName('#__commercelab_shop_customer'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($customer_id));

		$db->setQuery($query);

		return $db->loadObject();

	}

	/**
	 * @param   string  $name
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	public static function getAvatarAbb(string $name): string
	{

		$words   = preg_split("/[\s,_-]+/", $name);
		$acronym = "";

		foreach ($words as $w)
		{
			$acronym .= $w[0];
		}

		return $acronym;
	}

	/**
	 * @param   string  $status
	 *
	 * @return string
	 *
	 * @since 2.0
	 */


	public static function getStatusFormatted(string $status): string
	{

		LanguageFactory::load();

		switch ($status)
		{
			case 'P':
				return Text::_('COM_COMMERCELAB_SHOP_ORDER_PENDING');
			case 'C':
				return Text::_('COM_COMMERCELAB_SHOP_ORDER_CONFIRMED');
			case 'X':
				return Text::_('COM_COMMERCELAB_SHOP_ORDER_CANCELLED');
			case 'R':
				return Text::_('COM_COMMERCELAB_SHOP_ORDER_REFUNDED');
			case 'S':
				return Text::_('COM_COMMERCELAB_SHOP_ORDER_SHIPPED');
			case 'F':
				return Text::_('COM_COMMERCELAB_SHOP_ORDER_COMPLETED');
			case 'D':
				return Text::_('COM_COMMERCELAB_SHOP_ORDER_DENIED');
			default:
				return '';

		}


	}

	/**
	 * @param   int  $order_id
	 *
	 * @return mixed|null
	 *
	 * @since 2.0
	 */


	public static function getTracking(int $order_id)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_order_tracking'));
		$query->where($db->quoteName('order_id') . ' = ' . $db->quote($order_id));

		$db->setQuery($query);

		return $db->loadObject();

	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function saveNewNote(Input $data): bool
	{

		$db = Factory::getDbo();

		$object             = new stdClass();
		$object->id         = 0;
		$object->order_id   = $data->json->getInt('orderid');
		$object->note       = $data->json->getString('text');
		$object->created_by = Factory::getUser()->id;
		$object->created    = Utilities::getDate();

		$result = $db->insertObject('#__commercelab_shop_order_notes', $object);

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
	 * @param   int  $order_id
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function togglePaid(int $order_id): bool
	{

		$order = self::get($order_id);

		$order->order_paid = ($order->order_paid == 0 ? 1 : 0);

//		return $order->order_paid;

		return self::update($order);


	}

	/**
	 * @param   string  $status
	 * @param   int     $order_id
	 * @param   bool    $sendEmail
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function updateStatus(string $status, int $order_id, bool $sendEmail = false): array
	{

		$order = self::get($order_id);

		$order->order_status = $status;

		$update = self::update($order);

		if ($update)
		{

			if ($sendEmail)
			{
				// send email
				PluginHelper::importPlugin('commercelab_shop_system');
				return Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', 
					[
						Utilities::getOrderStatusFromCharacterCode($status), 
						$order_id
					]
				);

			}

		}

		return [false];

	}


	/**
	 * @param   string  $tracking_code
	 * @param   string  $tracking_link
	 * @param   string  $tracking_provider
	 * @param   int     $order_id
	 * @param   bool    $sendEmail
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	public static function updateTracking(string $tracking_code, string $tracking_link, string $tracking_provider, int $order_id, bool $sendEmail): bool
	{
		$order = self::get($order_id);

		$order->order_status      = 'S';
		$order->tracking_code     = $tracking_code;
		$order->tracking_link     = $tracking_link;
		$order->tracking_provider = $tracking_provider;


		$update = self::update($order);

		if ($update)
		{

			// now update tracking table

			if (self::saveTracking($order))
			{
				if ($sendEmail)
				{
					// send email
					PluginHelper::importPlugin('commercelab_shop_system');
					Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', [Utilities::getOrderStatusFromCharacterCode($order->order_status), $order_id]);
				}

				return true;
			}

			return false;

		}

		return false;

	}

	/**
	 * @param   Order  $order
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function updateCustomer(Order $order): bool
	{

		$orderToSave = new stdClass();

		// iterate through update-able fields:
		$orderToSave->id          = $order->id;
		$orderToSave->customer_id = $order->customer_id;
		// $orderToSave->guest_pin   = 'NULL';

		return Factory::getDbo()->updateObject('#__commercelab_shop_order', $orderToSave, 'id');

	}

	/**
	 * @param   Order  $order
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function update(Order $order): bool
	{

		$orderToSave = new stdClass();

		// iterate through update-able fields:
		$orderToSave->id                  = $order->id;
		$orderToSave->order_paid          = $order->order_paid;
		$orderToSave->order_status        = $order->order_status;
		$orderToSave->vendor_token        = $order->vendor_token;
		$orderToSave->billing_address_id  = $order->billing_address_id;
		$orderToSave->shipping_address_id = $order->shipping_address_id;

		// log
		self::log($order->id, Text::sprintf('COM_COMMERCELAB_SHOP_ORDER_UPDATE_LOG', self::getStatusFormatted($order->order_status), Factory::getUser()->name));

		// event trigger
		PluginHelper::importPlugin('commercelab_shop_system');
		Factory::getApplication()->triggerEvent('onOrderUpdated', [$order->id]);

		return Factory::getDbo()->updateObject('#__commercelab_shop_order', $orderToSave, 'id');

	}

	/**
	 * @param   Order  $order
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */

	public static function saveTracking(Order $order): bool
	{

		$db = Factory::getDbo();

		//check if already in
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_order_tracking'));
		$query->where($db->quoteName('order_id') . ' = ' . $db->quote($order->id));
		$db->setQuery($query);

		$result = $db->loadObject();

		$trackingToSave = new stdClass();

		if ($result)
		{
			//update

			$trackingToSave->order_id          = $order->id;
			$trackingToSave->tracking_code     = $order->tracking_code;
			$trackingToSave->tracking_provider = $order->tracking_provider;
			$trackingToSave->tracking_link     = $order->tracking_link;

			return $db->updateObject('#__commercelab_shop_order_tracking', $trackingToSave, 'order_id');

		}
		else
		{
			//insert

			$trackingToSave->id                = 0;
			$trackingToSave->order_id          = $order->id;
			$trackingToSave->tracking_code     = $order->tracking_code;
			$trackingToSave->tracking_provider = $order->tracking_provider;
			$trackingToSave->tracking_link     = $order->tracking_link;
			$trackingToSave->created           = Utilities::getDate();

			return $db->insertObject('#__commercelab_shop_order_tracking', $trackingToSave);
		}


	}

	/**
	 * @param   string  $paymentMethod
	 * @param   string  $vendorToken
	 *
	 * @return Order
	 *
	 * @throws Exception
	 * @since 2.0
	 *
	 *
	 */


	public static function createOrderFromCart(string $paymentMethod, string $vendorToken = null): ?Order
	{
		// init vars
		$db        = Factory::getDbo();
		$date      = Utilities::prepareDateToSave();
		$cookie_id = Utilities::getCookieID();
		$customer  = CustomerFactory::get();
		$cart      = CartFactory::get();
		$currency  = CurrencyFactory::getCurrent();

		// Build Order Object
		$object     = new stdClass();
		$object->id = 0;

		$object->hash        = bin2hex(random_bytes(18));
		$object->customer_id = ($customer) ? $customer->id : null;
		$object->order_date  = $date;

		$object->order_number   = self::getNextOrderNumber(true);
		$object->order_paid     = 0;
		$object->order_status   = 'P';
		$object->order_total    = $cart->totalInt;
		$object->order_subtotal = $cart->subtotalInt;

		$object->shipping_total      = $cart->totalShipping;
		$object->tax_total           = $cart->taxInt;
		$object->currency            = $currency->iso;
		$object->payment_method      = $paymentMethod;
		$object->vendor_token        = $vendorToken;
		$object->billing_address_id  = $cart->billing_address_id;
		$object->shipping_address_id = $cart->shipping_address_id;
		$object->published           = 1;

		if (CouponFactory::isCouponApplied())
		{
			$coupon                = CouponFactory::getCurrentAppliedCoupon();
			$object->discount_code = $coupon->coupon_code;
		}

		$object->discount_total = $cart->totalDiscountInt;

		if ($currentNote = CheckoutnoteFactory::getCurrentNote())
		{
			$object->customer_notes = $currentNote->note;
		}
		else
		{
			$object->customer_notes = '';
		}


		// insert the new Order object and retrieve the Order ID via insertid method
		$result = $db->insertObject('#__commercelab_shop_order', $object);

		if (!$result)
		{
			return null;
		}

		$order_id = $db->insertid();


		// now insert the products

		/** @var CartItem $cartItem */
		foreach ($cart->cartItems as $cartItem)
		{

			$object                = new stdClass();
			$object->id            = 0;
			$object->order_id      = $order_id;
			$object->j_item        = $cartItem->joomla_item_id;
			$object->j_item_cat    = $cartItem->product->joomlaItem->catid;
			$object->j_item_name   = $cartItem->product->joomlaItem->title;
			$object->item_options  = json_encode($cartItem->selected_options);
			$object->variant_id    = $cartItem->variant_id;
			$object->price_at_sale = ($cartItem->variant_id) ? $cartItem->selected_variant->priceInt : $cartItem->bought_at_price;
			$object->amount        = $cartItem->amount;

			$db->insertObject('#__commercelab_shop_order_products', $object);

			if ($cartItem->manage_stock_enabled == 1)
			{

				$currentStock  = ProductFactory::getCurrentStock($cartItem->product->joomla_item_id);
				$newStockLevel = ($currentStock - $cartItem->amount);

				if ($newStockLevel <= 0)
				{
					$newStockLevel = 0;
				}

				$stockUpdate        = new stdClass();
				$stockUpdate->id    = $cartItem->product->id;
				$stockUpdate->stock = $newStockLevel;

				$db->updateObject('#__commercelab_shop_product', $stockUpdate, 'id');
			}

		}


		// clear the items from the cart
		CartFactory::clearItems($cart);

		// clear the coupons
		CartFactory::clearCoupons($cart);

		// get the plugin functions
		PluginHelper::importPlugin('commercelab_shop_system');

		try
		{
			Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['pending', $order_id]);
		}
		catch (Exception $e)
		{

		}

		// insert a log of this order
		self::log($order_id, Text::_('COM_COMMERCELAB_SHOP_ORDER_IS_CREATED_LOG'));


		// fire the event
		PluginHelper::importPlugin('commercelab_shop_system');

		try
		{
			Factory::getApplication()->triggerEvent('onOrderCreated', array($order_id));
		}
		catch (Exception $e)
		{

		}


		return self::get($order_id);

	}

	/**
	 * @param $seed
	 *
	 * @return string
	 *
	 * @since 1.0
	 */


	private static function _generateOrderId($seed): string
	{

		$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$base    = strlen($charset);
		$result  = '';
		$len     = 5;
		$now     = explode(' ', microtime())[1];
		while ($now >= $base)
		{
			$i      = $now % $base;
			$result = $charset[$i] . $result;
			$now    /= $base;
		}
		$rand = substr($result, -$len);

		return strtoupper($rand . $seed);
	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getStatuses(): array
	{

		$statuses = array();

		$statuses[0]['id']    = 'P';
		$statuses[0]['title'] = Text::_('COM_COMMERCELAB_SHOP_ORDER_PENDING');

		$statuses[1]['id']    = 'C';
		$statuses[1]['title'] = Text::_('COM_COMMERCELAB_SHOP_ORDER_CONFIRMED');

		$statuses[2]['id']    = 'X';
		$statuses[2]['title'] = Text::_('COM_COMMERCELAB_SHOP_ORDER_CANCELLED');

		$statuses[3]['id']    = 'R';
		$statuses[3]['title'] = Text::_('COM_COMMERCELAB_SHOP_ORDER_REFUNDED');

		$statuses[4]['id']    = 'S';
		$statuses[4]['title'] = Text::_('COM_COMMERCELAB_SHOP_ORDER_SHIPPED');

		$statuses[5]['id']    = 'F';
		$statuses[5]['title'] = Text::_('COM_COMMERCELAB_SHOP_ORDER_COMPLETED');

		$statuses[6]['id']    = 'D';
		$statuses[6]['title'] = Text::_('COM_COMMERCELAB_SHOP_ORDER_DENIED');


		return $statuses;
	}


	/**
	 * @param   string  $payment_method
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	public static function getPaymentMethodIcon(string $payment_method): string
	{

		$pluginName = str_replace(' ', '', strtolower($payment_method));

		return \Joomla\CMS\Uri\Uri::root() . "plugins/system/commercelab_shop_" . $pluginName . "/modules/" . $pluginName . "/elements/" . $pluginName . "/images/commercelab_shop_" . $pluginName . ".svg";
	}

}
