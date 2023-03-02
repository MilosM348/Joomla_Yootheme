<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Variant;

defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;

use CommerceLabShop\Currency\CurrencyFactory;

use Brick\Money\Exception\UnknownCurrencyException;



class VariantFactory
{


	/**
	 * @param   int  $id
	 *
	 * @return Variant
	 *
	 * @since 2.0
	 */

	public static function get(int $id): ?Variant
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_preset'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();
		if ($result && is_object($result))
		{
			return new Variant($result);
		}

		return null;
	}


	/**
	 * @param   int          $limit
	 *
	 * @param   int          $offset
	 * @param   string|null  $searchTerm
	 *
	 * @return array
	 * @since 2.0
	 */

	public static function getPresetGroups(int $limit = 0, int $offset = 0, string $searchTerm = null): ?array
	{


		$orders = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_preset'));

		if ($searchTerm)
		{
			$query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}



		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{
				$orders[] = new Variant($result);

			}

			return $orders;
		}


		return null;
	}
	public static function getPresetList(int $limit = 0, int $offset = 0, string $searchTerm = null): ?array
	{


		$orders = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_preset'));

		if ($searchTerm)
		{
			$query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}



		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{
				$orders[] = new Variant($result);

			}

			return $orders;
		}


		return null;
	}


	/**
	 * @param   array  $variants
	 *
	 * @return array
	 *
	 * @since 2.0
	 */



	public static function attachVariantLabels(array $variants): array
	{

		// get the item id from the first variant
		$variant_id = $variants[0]->variant_id;

		$labels = self::getLabels($variant_id);

		foreach ($variants as $variant)
		{

			foreach ($labels as $label)
			{
				if ($label->variant_id == $variant->id)
				{
					$variant->labels[] = $label;
				}


			}

		}

		return $variants;

	}


	/**
	 * @param   array  $variantList
	 *
	 * @return array
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */
	public static function processVariantData(array $variantList): array
	{


		foreach ($variantList as $variant)
		{

			// namedLabel
			if (isset($variant->label_ids))
			{
				$db       = Factory::getDbo();
				$labelIds = explode(',', $variant->label_ids);

				$namedLabels = array();
				foreach ($labelIds as $labelId)
				{

					$query = $db->getQuery(true);

					$query->select('name');
					$query->from($db->quoteName('#__commercelab_shop_product_variant_label_preset'));
					$query->where($db->quoteName('id') . ' = ' . $db->quote($labelId));

					$db->setQuery($query);

					$namedLabels[] = $db->loadResult();

				}

				$variant->namedLabel = implode(' / ', $namedLabels);


			}

			// prices
			if (isset($variant->price))
			{
				$variant->priceInt = $variant->price;
				$variant->price    = CurrencyFactory::toFloat($variant->price);
			}

			// booleans
			$variant->default = $variant->default == 1;
			$variant->active  = $variant->active == 1;

		}

		return $variantList;


	}

	/**
	 * @param   array  $variantList
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getVariantDefault(array $variantList): array
	{

		$default = array();

		foreach ($variantList as $variant)
		{
			if ($variant->default == 1)
			{
				$default = explode(',', $variant->label_ids);
			}


		}

		return $default;


	}


	/**
	 * @param   int  $variant_id
	 *
	 * @return array|mixed
	 *
	 * @since 2.0
	 */


	public static function getLabels(int $variant_id)
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_label_preset'));
		$query->where($db->quoteName('variant_id') . ' = ' . $db->quote($variant_id));

		$db->setQuery($query);

		return $db->loadObjectList();


	}


}
