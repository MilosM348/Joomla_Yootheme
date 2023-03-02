<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Country;

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Input\Input;


use stdClass;

class CountryFactory
{


	/**
	 *
	 * Gets the currency based on the given ID.
	 *
	 * @param $id
	 *
	 * @return Country
	 *
	 * @since 2.0
	 */

	public static function get($id): ?Country
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_country'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{

			return new Country($result);
		}

		return null;

	}


	/**
	 * @param $id
	 *
	 * @return Zone
	 *
	 * @since 2.0
	 */

	public static function getZone($id): ?Zone
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_zone'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{

			return new Zone($result);
		}

		return null;

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
	 * @since 2.0
	 */

	public static function getList(int $limit = 0, int $offset = 0, bool $publishedOnly = false, string $searchTerm = null, string $orderBy = 'published', string $orderDir = 'DESC'): ?array
	{

		// init items
		$items = array();

		// get the Database
		$db = Factory::getDbo();

		// set initial query
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_country'));

		// only get published items based on $publishedOnly boolean
		if ($publishedOnly)
		{
			$query->where($db->quoteName('published') . ' = 1');
		}


		// if there is a search term, iterate over the columns looking for a match
		if ($searchTerm)
		{
			$query->where($db->quoteName('country_name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
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
				$items[] = new Country($result);

			}

			return $items;
		}

		return null;

	}

	/**
	 * @param   int          $limit
	 * @param   int          $offset
	 * @param   false        $publishedOnly
	 * @param   string|null  $searchTerm
	 * @param   int|null     $country_id
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function getZoneList(int $limit = 0, int $offset = 0, bool $publishedOnly = false, string $searchTerm = null, int $country_id = null, string $orderBy = 'published', string $orderDir = 'DESC'): ?array
	{

		// init items
		$items = array();

		// get the Database
		$db = Factory::getDbo();

		// set initial query
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_zone'));

		// only get published items based on $publishedOnly boolean
		if ($publishedOnly == true)
		{
			$query->where($db->quoteName('published') . ' = 1');
		}

		if (!$country_id) {
			$country_id = CountryFactory::getList(0, 0, true);
			$country_ids_array = [];
			foreach ($country_id as $country) {
				$country_ids_array[] = $country->id;
			}
			$query->where($db->quoteName('country_id') . ' IN ' . "('" . implode("','", $country_ids_array) . "')");
		} else {
			$query->where($db->quoteName('country_id') . ' = ' . $country_id);
		}

		if ($searchTerm)
		{
			$query->where($db->quoteName('zone_name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
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
				$items[] = new Zone($result);

			}

			return $items;
		}

		return null;

	}


	/**
	 *
	 * @return Country|null
	 *
	 * @since 2.0
	 */

	public static function getDefault(): ?Country
	{

		$instance = DefaultCountry::getInstance();

		return $instance->getCountry();


	}


	/**
	 *
	 * This method is called first and runs the check before calling other functions to commit the data.
	 *
	 * @param   Input  $data
	 *
	 *
	 * @return Country
	 * @since 2.0
	 */


	public static function saveFromInputData(Input $data): ?Country
	{


		if ($id = $data->json->getInt('jform_id', null))
		{

			$current = self::get($id);

			$current->country_name      = $data->json->getString('jform_country_name', $current->country_name);
			$current->country_isocode_2 = $data->json->getString('jform_country_isocode_2', $current->country_isocode_2);
			$current->country_isocode_3 = $data->json->getString('jform_country_isocode_3', $current->country_isocode_3);
			$current->requires_vat      = $data->json->getInt('jform_requires_vat', $current->requires_vat);
			$current->taxrate           = floatval($data->json->getString('jform_taxrate', $current->taxrate));
			$current->taxrate_reduced   = floatval($data->json->getString('jform_taxrate_reduced', $current->taxrate_reduced));
			$current->taxrate_extra     = floatval($data->json->getString('jform_taxrate_extra', $current->taxrate_extra));
			$current->published         = $data->json->getInt('jform_published', $current->published);

			
			if (self::commitToDatabase($current))
			{
				// now process the associated zones
				self::updateZoneList((array)$current);

				return $current;
			}

		}
		else
		{

			if ($item = self::createFromInputData($data))
			{
				// now process the associated zones
				self::updateZoneList((array)$item);

				return $item;
			}

		}

		return null;
	}

	/**
	 *
	 * This method is called first and runs the check before calling other functions to commit the data.
	 *
	 * @param   Input  $data
	 *
	 *
	 * @return Zone
	 * @since 2.0
	 */


	public static function saveZoneFromInputData(Input $data): ?Zone
	{


		if ($id = $data->json->getInt('zone_id', null))
		{

			$current = self::getZone($id);

			$current->zone_name       = $data->json->getString('zone_name', $current->zone_name);
			$current->country_id      = $data->json->getString('country_id', $current->country_id);
			$current->zone_isocode    = $data->json->getString('zone_isocode', $current->zone_isocode);
			$current->taxrate         = floatval($data->json->getString('taxrate', $current->taxrate));
			$current->taxrate_reduced = floatval($data->json->getString('taxrate_reduced', $current->taxrate_reduced));
			$current->taxrate_extra   = floatval($data->json->getString('taxrate_extra', $current->taxrate_extra));
			$current->inherit_taxrate = $data->json->getString('inherit_taxrate', $current->inherit_taxrate);
			$current->published       = $data->json->getInt('published', $current->published);


			if (self::commitZoneToDatabase($current))
			{

				return $current;
			}

		}

		return null;
	}

	/**
	 * @param   Input  $data
	 *
	 * @return Country
	 *
	 * @since 2.0
	 */


	private static function createFromInputData(Input $data): ?Country
	{

		$db = Factory::getDbo();

		$discount                    = new stdClass();
		$discount->country_name      = $data->json->getString('jform_country_name');
		$discount->country_isocode_2 = $data->json->getString('jform_country_isocode_2');
		$discount->country_isocode_3 = $data->json->getString('jform_country_isocode_3');
		$discount->requires_vat      = $data->json->getInt('jform_requires_vat');
		$discount->taxrate           = floatval($data->json->getString('jform_taxrate'));
		$discount->taxrate_reduced   = floatval($data->json->getString('jform_taxrate_reduced'));
		$discount->taxrate_extra     = floatval($data->json->getString('jform_taxrate_extra'));
		$discount->published         = $data->json->get('jform_published');


		$result = $db->insertObject('#__commercelab_shop_country', $discount);

		if ($result)
		{
			return self::get($db->insertid());
		}

		return null;


	}

	/**
	 * @param   Zone  $item
	 *
	 * @return bool
	 * @since 2.0
	 */


	private static function commitZoneToDatabase(Zone $item): bool
	{

		$db = Factory::getDbo();

		$insert = new stdClass();

		$insert->id              = $item->id;
		$insert->zone_name       = $item->zone_name;
		$insert->zone_isocode    = $item->zone_isocode;
		$insert->country_id      = $item->country_id;
		$insert->taxrate         = floatval($item->taxrate);
		$insert->taxrate_reduced = floatval($item->taxrate_reduced);
		$insert->taxrate_extra   = floatval($item->taxrate_extra);
		$insert->inherit_taxrate = $item->inherit_taxrate;
		$insert->published       = $item->published;

		$result = $db->updateObject('#__commercelab_shop_zone', $insert, 'id');

		if ($result)
		{
			return true;
		}

		return false;

	}

	/**
	 * @param   Country  $item
	 *
	 * @return bool
	 * @since 2.0
	 */


	private static function commitToDatabase(Country $item): bool
	{

		$db = Factory::getDbo();

		$insert = new stdClass();

		$insert->id                = $item->id;
		$insert->country_name      = $item->country_name;
		$insert->country_isocode_2 = $item->country_isocode_2;
		$insert->country_isocode_3 = $item->country_isocode_3;
		$insert->requires_vat      = $item->requires_vat;
		$insert->taxrate           = floatval($item->taxrate);
		$insert->taxrate_reduced   = floatval($item->taxrate_reduced);
		$insert->taxrate_extra     = floatval($item->taxrate_extra);
		$insert->published         = $item->published;

		$result = $db->updateObject('#__commercelab_shop_country', $insert, 'id');

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

	public static function togglePublishedFromInputData(Input $data): bool
	{


		$response = false;

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		foreach ($items as $item)
		{

			$object            = new stdClass();
			$object->id        = $item['id'];
			$object->published = $item['published'];

			$db->updateObject('#__commercelab_shop_country', $object, 'id');

			self::updateZoneList($item);
			$response = true;
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

	public static function togglePublishedZonesFromInputData(Input $data): bool
	{


		$response = false;

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		foreach ($items as $item)
		{

			$object            = new stdClass();
			$object->id        = $item['id'];
			$object->published = $item['published'];

			$db->updateObject('#__commercelab_shop_zone', $object, 'id');

			$response = true;
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
		$query->update($db->quoteName('#__commercelab_shop_country'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();


		$object            = new stdClass();
		$object->id        = $item['id'];
		$object->default   = 1;
		$object->published = 1;

		$result = $db->updateObject('#__commercelab_shop_country', $object, 'id');

		if (!$result)
		{
			$response = false;
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
			$query->delete($db->quoteName('#__commercelab_shop_country'));
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

	public static function trashZonesFromInputData(Input $data): bool
	{

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		foreach ($items as $item)
		{
			$query      = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($item['id'])
			);
			$query->delete($db->quoteName('#__commercelab_shop_zone'));
			$query->where($conditions);
			$db->setQuery($query);
			$db->execute();

		}

		return true;

	}

	/**
	 * @param   array  $item
	 *
	 * @since 2.0
	 */

	public static function updateZoneList(array $item)
	{

		if (!$item)
		{
			return;
		}

		$item = (array) $item;

		$db = Factory::getDbo();


		$object             = new stdClass();
		$object->country_id = $item['id'];
		$object->published  = $item['published'];

		$db->updateObject('#__commercelab_shop_zone', $object, 'country_id');


	}


}
