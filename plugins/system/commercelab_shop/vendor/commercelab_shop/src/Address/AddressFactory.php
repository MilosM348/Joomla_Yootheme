<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Address;

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Input\Input;


use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Country\Country;
use CommerceLabShop\Country\CountryFactory;

use CommerceLabShop\Utilities\Utilities;

use CommerceLabShop\Customer\CustomerFactory;
use stdClass;

class AddressFactory
{


	/**
	 *
	 * Gets the address based on the given ID.
	 *
	 * @param   int  $id
	 *
	 * @return Address|null
	 *
	 * @since 2.0
	 */

	public static function get($id): ?Address
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_customer_address'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{

			return new Address($result);
		}

		return null;

	}

	/**
	 *
	 * Gets the address as CSV string based on the given ID.
	 *
	 * @param $id
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	public static function getAsCSVFromId($id): string
	{

		$address = self::get($id);

		unset($address->id);
		unset($address->created);
		unset($address->customer_id);
		unset($address->zone);
		unset($address->country);

		$string = '';

		foreach ($address as $line)
		{
			$string .= $line . ", ";
		}

		return rtrim($string, ', ');


	}


	/**
	 * @param   int          $limit
	 * @param   int          $offset
	 * @param   string|null  $searchTerm
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 * @param   int|null     $customerId
	 * @param   int|null     $zoneId
	 * @param   int|null     $countryId
	 *
	 * @return array|null
	 * @since 2.0
	 */

	public static function getList(int $limit = 0, int $offset = 0, string $searchTerm = null, string $orderBy = 'id', string $orderDir = 'DESC', int $customerId = null, int $zoneId = null, int $countryId = null, int $addressType = null): ?array
	{


		// init items
		$items = array();

		// get the Database
		$db = Factory::getDbo();

		// set initial query
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_customer_address'));


		// if there is a search term, iterate over the columns looking for a match
		if ($searchTerm)
		{
			// $query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			$query->where($db->quoteName('address1') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			$query->where($db->quoteName('address2') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			$query->where($db->quoteName('address3') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			$query->where($db->quoteName('city') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}

		// filter by the customers id
		if ($customerId)
		{
			$query->where($db->quoteName('customer_id') . ' = ' . $db->quote($customerId));
		}
		// filter by the zone id
		if ($zoneId)
		{
			$query->where($db->quoteName('zone') . ' = ' . $db->quote($zoneId));
		}

		// filter by the country id
		if ($countryId)
		{
			$query->where($db->quoteName('country') . ' = ' . $db->quote($countryId));
		}

		// filter by the adddress type
		if ($addressType)
		{
			$query->where($db->quoteName('addres_type') . ' = ' . $db->quote($addressType));
		}

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadAssocList();


		// only proceed if there's any rows
		if ($results)
		{
			// iterate over the array of objects, initiating the Class.
			foreach ($results as $result)
			{
				$items[] = new Address($result);

			}

			return $items;
		}

		return null;

	}

	/**
	 * @param   Input  $data
	 *
	 * @return Address|bool
	 *
	 * @since 2.0
	 */


	public static function saveFromInputData(Input $data, $both_types = null): Address
	{

		$db = Factory::getDbo();

		// $temp_address = CartFactory::getTempAddress($data->json->get('address_type'));
		// dd($temp_address);
		// $address_id   = ($data->json->get('id', false)) ? $data->json->get('id') : (($temp_address) ? $temp_address[0]->address_id : false);
		$address_id = $data->json->get('id', null);

		if ($address_id) {

			// run update
			$currentAddress = self::get($address_id);

			$addressForUpdate               = new stdClass();
			$addressForUpdate->id           = $address_id;

			if ($data->json->get('save_address', false)) {

				$addressForUpdate->customer_id = $data->json->getInt('customer_id', $currentAddress->customer_id);

			}

			// $addressForUpdate->name         = $data->json->getString('name', $currentAddress->name);
			$addressForUpdate->first_name   = $data->json->getString('first_name', $currentAddress->first_name);
			$addressForUpdate->last_name    = $data->json->getString('last_name', $currentAddress->last_name);
			$addressForUpdate->company_name = $data->json->getString('company_name', $currentAddress->company_name);
			$addressForUpdate->vat          = $data->json->getString('vat', $currentAddress->vat);
			$addressForUpdate->address1     = $data->json->getString('address1', $currentAddress->address1);
			$addressForUpdate->address2     = $data->json->getString('address2', $currentAddress->address2);
			$addressForUpdate->address3     = $data->json->getString('address3', $currentAddress->address3);
			$addressForUpdate->city         = $data->json->getString('city', $currentAddress->city);
			$addressForUpdate->country      = $data->json->getInt('country', $currentAddress->country);
			$addressForUpdate->zone         = $data->json->getInt('zone', $currentAddress->zone);
			$addressForUpdate->postcode     = $data->json->getString('postcode', $currentAddress->postcode);
			$addressForUpdate->phone        = $data->json->getString('phone', $currentAddress->phone);
			$addressForUpdate->mobile_phone = $data->json->getString('mobile_phone', $currentAddress->mobile_phone);
			$addressForUpdate->address_type = ($both_types) ? 'both' : $data->json->getString('address_type', $currentAddress->address_type);
			$addressForUpdate->email        = $data->json->getString('email', $currentAddress->email);

			$update = $db->updateObject('#__commercelab_shop_customer_address', $addressForUpdate, 'id');

			if ($update)
			{
				return self::get($address_id);
			}

			return false;

		} else {

			// run insert
			$addressForInsert     = new stdClass();
			$addressForInsert->id = 0;

			// if there's a customer id in the request, use it for the data
			$customer_id = $data->json->get('customer_id');
			if ($customer_id) {

				$addressForInsert->customer_id = $customer_id;

			} else {

				$customer = CustomerFactory::get();

				// if there is no customer id in the request, retrieve the customer id from the Customer Factory, or just set to 0
				if ($customer) {
					$addressForInsert->customer_id = $customer->id;
				}

			}
			// $addressForInsert->name         = $data->json->getString('name');
			$addressForInsert->first_name   = $data->json->getString('first_name');
			$addressForInsert->last_name    = $data->json->getString('last_name');
			$addressForInsert->company_name = $data->json->getString('company_name');
			$addressForInsert->vat          = $data->json->getString('vat');
			$addressForInsert->address1     = $data->json->getString('address1');
			$addressForInsert->address2     = $data->json->getString('address2');
			$addressForInsert->address3     = $data->json->getString('address3');
			$addressForInsert->city         = $data->json->getString('city');
			$addressForInsert->country      = $data->json->getInt('country');
			$addressForInsert->zone         = $data->json->getInt('zone');
			$addressForInsert->postcode     = $data->json->getString('postcode');
			$addressForInsert->phone        = $data->json->getString('phone');
			$addressForInsert->mobile_phone = $data->json->getString('mobile_phone');
			$addressForInsert->address_type = ($both_types) ? 'both' : $data->json->getString('address_type');
			$addressForInsert->email        = $data->json->getString('email');

			$insert = $db->insertObject('#__commercelab_shop_customer_address', $addressForInsert);

			if ($insert)
			{
				return self::get($db->insertid());
			}

			return false;

		}


	}


	/**
	 * @param $country_id
	 *
	 * @return string
	 *
	 * @since version
	 */

	public static function getCountryName($country_id): string
	{

		if ($country = CountryFactory::get($country_id))
		{
			return $country->country_name;
		}
		else
		{
			return '';
		}


	}

	/**
	 * @param $country_id
	 *
	 * @return Country|null
	 *
	 * @since 2.0
	 */

	public static function getCountry($country_id): ?Country
	{


		return CountryFactory::get($country_id);


	}

	/**
	 * @param $zone_id
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	public static function getZoneName($zone_id): string
	{

		if ($zone = CountryFactory::getZone($zone_id))
		{
			return $zone->zone_name;
		}

		return '';


	}

	/**
	 *
	 * Gets the CSV from the given full address object
	 *
	 * @param   Address  $address
	 *
	 * @return string
	 *
	 * @since 2.0
	 */


	public static function getAddressAsCSV(Address $address): string
	{

		// clone the $address to prevent actual values being unset
		$clone = clone $address;

		unset($clone->id);
		unset($clone->created);
		unset($clone->customer_id);
		unset($clone->zone);
		unset($clone->country);
		unset($clone->country_isocode_2);
		unset($clone->country_isocode_3);


		$string = '';

		foreach ($clone as $line)
		{
			if (!empty($line))
			{
				$string .= $line . ", ";
			}

		}

		return rtrim($string, ', ');

	}

	public static function getAddressForCheckout(Address $address): string
	{

		// clone the $address to prevent actual values being unset
		$clone = clone $address;

		unset($clone->id);
		unset($clone->created);
		unset($clone->customer_id);
		unset($clone->zone);
		unset($clone->country);
		unset($clone->country_isocode_2);
		unset($clone->country_isocode_3);


		$string = '';

		foreach ($clone as $line)
		{
			if (!empty($line))
			{
				$string .= $line . ", ";
			}

		}

		return rtrim($string, ', ');

	}


	/**
	 *
	 * @return Address|null
	 *
	 * @since 2.0
	 */


	public static function getCurrentShippingAddress(): ?Address
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('shipping_address_id');
		$query->from($db->quoteName('#__commercelab_shop_cart'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote(CartFactory::getCurrentCartId()));

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result)
		{
			return self::get($result);
		}

		return null;


	}


	/**
	 *
	 * @return Address|null
	 *
	 * @since 2.0
	 */

	public static function getCurrentBillingAddress(): ?Address
	{


		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('billing_address_id');
		$query->from($db->quoteName('#__commercelab_shop_cart'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote(CartFactory::getCurrentCartId()));

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result)
		{
			return self::get($result);
		}

		return null;

	}


	/**
	 *
	 * This static function determines if the billing address is different from the shipping address.
	 *
	 *
	 * @return bool|false
	 * @since 1.0
	 *
	 */


	public static function doesOrderHaveUniqueBillingAddressAssigned(): bool
	{

		$cart = CartFactory::get();

		if ($cart->billing_address_id === $cart->shipping_address_id)
		{
			return false;
		}
		else
		{
			return true;
		}


	}

	/**
	 * @param $address_id
	 * @param $type
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function checkAssigned($address_id, $type): bool
	{

		$cartId = CartFactory::getCurrentCartId();

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_cart'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($cartId));
		$query->where($db->quoteName($type . '_address_id') . ' = ' . $db->quote($address_id));

		$db->setQuery($query);
		$result = $db->loadObject();

		if ($result)
		{
			return true;
		}

		return false;

	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */

	public static function remove(Input $data): bool
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('id') . " = " . $db->quote($data->getInt('address_id'))
		);

		$query
			->delete($db->quoteName('#__commercelab_shop_customer_address'))
			->where($conditions);

		$db->setQuery($query);
		$done = $db->execute();

		if ($done)
		{
			if ($data->getInt('remove_from_cart')) {
				CartFactory::removeAddress($data->getString('address_type'));
				CartFactory::removeTempAddress($data->getString('address_id'));
			}
			return true;
		}

		return false;

	}

	/**
	 * @param   Address  $address
	 * @param   int      $customerId
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function setCustomerId(Address $address, int $customerId): bool
	{
		return false;
	}


	/**
	 * @param   Address  $address
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function saveAddress(Address $address): bool
	{
		return false;
	}

}
