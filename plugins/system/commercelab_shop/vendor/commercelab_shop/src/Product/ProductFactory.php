<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Product;

defined('_JEXEC') or die('Restricted access');

use Joomla\Input\Input;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Filesystem\File as JoomlaFile;
use Joomla\Component\Fields\Administrator\Model\FieldModel;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

use Brick\Math\BigDecimal;
use Brick\Money\Exception\UnknownCurrencyException;

use YOOtheme\View;
use function YOOtheme\app;

use CommerceLabShop\Tag\TagFactory;
use CommerceLabShop\Tax\TaxFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Customfield\CustomFieldsHelper;
use CommerceLabShop\Productoption\Productoption;
use CommerceLabShop\Productoption\ProductoptionFactory;

use StathisG\GreekSlugGenerator\GreekSlugGenerator;

use Exception;
use stdClass;


class ProductFactory
{


	/**
	 * @param   int  $joomla_item_id
	 *
	 * @return Product|null
	 * @since 2.0
	 */

	public static function get(int $joomla_item_id): ?Product
	{

		// ***  TODO - Implement Cache

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__commercelab_shop_product'))
			->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($joomla_item_id));

		$db->setQuery($query);

		$result = $db->loadObject();
		if ($result)
		{
			return new Product($result);
		}

		return null;
	}

	public static function getByClsId(int $cls_id): ?Product
	{

		// ***  TODO - Implement Cache

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__commercelab_shop_product'))
			->where($db->quoteName('id') . ' = ' . $db->quote($cls_id));

		$db->setQuery($query);

		$result = $db->loadObject();
		if ($result)
		{
			return new Product($result);
		}

		return null;
	}


	public static function getIdsFromCategories(array $categories_ids, string $ids = 'a.id'): array
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select($ids)
			->from($db->quoteName('#__content', 'a'));
			
		$query->where($db->quoteName('a.state') . ' = 1 ');

		// Productos
    	$query->join('INNER', $db->quoteName('#__commercelab_shop_product', 'p') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('p.joomla_item_id'));

		// Categories
    	if (count($categories_ids))
    	{
	    	$query->join('INNER', $db->quoteName('#__categories', 'c') . ' ON ' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('c.id'));
			$query->where($db->quoteName('c.id') . ' IN (' . implode(',', $categories_ids) . ')');
    	}

		$db->setQuery($query);

		return $db->loadColumn();

	}


	/**
	 * @param   int          $limit
	 *
	 * @param   int          $offset
	 * @param                $category
	 * @param   string|null  $searchTerm
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 *
	 * @return array
	 * @since 2.0
	 */

	public static function getList(int $limit = 20, int $offset = 0, $category = 0, string $searchTerm = null, int $active_only = 0, string $orderBy = 'p.id', string $orderDir = 'DESC'): ?array
	{

		$response = ['items' => []];

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		// $query->select(['p.*', 'COUNT(p.*)']);
		$query->select(['p.*', 'c.title']);
		$query->from($db->quoteName('#__content', 'a'));

		// Productos
    	$query->join('INNER', $db->quoteName('#__commercelab_shop_product', 'p') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('p.joomla_item_id'));

		// Categories
    	$query->join('INNER', $db->quoteName('#__categories', 'c') . ' ON ' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('c.id'));

		$response['totalitems'] = count($db->setQuery($query)->loadColumn());

		if ($searchTerm)
		{
			$query->where($db->quoteName('a.title') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}

		if ($category)
		{

			if (is_array($category))
			{
				$query->where($db->quoteName('a.catid') . ' IN (' . implode(', ', $category) . ')');
			}
			elseif (is_int($category))
			{
				$query->where($db->quoteName('a.catid') . ' = ' . $db->quote($category));
			}


		}
				
		if ($active_only === 1)
		{
			$query->where($db->quoteName('a.state') . ' = 1 ');
		}



		$query->order($orderBy . ' ' . $orderDir);

		$response['totalfiltered'] = count($db->setQuery($query)->loadColumn());


		//  Query With Limits
		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();
		$response['totalshowing'] = count($results);


		$response['query'] = $query->__toString();

		if (count($results))
		{
			foreach ($results as $joomla_item_id)
			{
				$response['items'][] = new Product($joomla_item_id);
			}
		}
		else
		{
			$response['items'] = [];
		}

		return $response;


		// if ($contentResults)
		// {
		// 	foreach ($contentResults as $contentId)
		// 	{
		// 		$query = $db->getQuery(true);

		// 		$query->select('*');
		// 		$query->from($db->quoteName('#__commercelab_shop_product'));
		// 		$query->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($contentId));

		// 		$db->setQuery($query);

		// 		$productResult = $db->loadObject();

		// 		if ($productResult)
		// 		{
		// 			$products[] = new Product($productResult);
		// 		}


		// 	}

		// 	return $products;
		// }


		// return null;
	}


	/**
	 * @param   int          $limit
	 *
	 * @param   int          $offset
	 * @param                $category
	 * @param   string|null  $searchTerm
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 *
	 * @return array
	 * @since 2.0
	 */

	public static function getIdsFromFieldValues(string $field_ids = null, $value)
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName('item_id'))->from($db->quoteName('#__fields_values', 'fv'));

		if ($field_ids)
		{
			$query->where($db->quoteName('field_id') . ' IN (' . $field_ids . ')');
		}

		$query->where($db->quoteName('value') . ' LIKE ' . $db->quote('%' . $value . '%'))->group('item_id');

		return $db->setQuery($query)->loadColumn();

	}

	public static function getGridAndFilterListOnLoad(
			int $limit                     = 10, 
			int $offset                    = 0, 
			array $categories              = null, 
			array $tags                    = null, 
			string $orderBy                = 'a.id', 
			string $orderDir               = 'DESC',
			array $node                    = []
		): ?array
	{

		$time_start = microtime(true);
		$response = ['items' => [], 'timestamps' => [0 => $time_start]];

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select(['p.*']);
		$query->from($db->quoteName('#__content', 'a'));

		// Combine Products
    	$query->join('INNER', $db->quoteName('#__commercelab_shop_product', 'p') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('p.joomla_item_id'));

		$response['totalitems'] = count($db->setQuery($query->group('a.id'))->loadColumn());

		// Item must be published
		$query->where($db->quoteName('a.state') . ' = 1 ');


		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($categories && !empty($categories))
		{
			$query->where($db->quoteName('a.catid') . ' IN (' . implode(', ', $categories) . ')');
		}

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($tags && !empty($tags))
		{
			foreach ($tags as $tag_group) if (!empty($tag_group))
			{
				$grouped_query = [];
				foreach ($tag_group as $selected_tag)
				{
					$grouped_query[] = $db->quoteName('a.id') . ' IN (' . implode(', ', $selected_tag['items']) . ')';
				}
				if (!empty($grouped_query))
				{
					$query->where('(' . implode(' OR ', $grouped_query) . ')');
				}
			}
		}

		$query->order($orderBy . ' ' . $orderDir);

		$query->group('a.id');

		// dd($query);

		$response['totalfiltered'] = count($db->setQuery($query)->loadColumn());

		// dd($response['totalfiltered']);

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		
		// Query With Limits
		$db->setQuery($query, $offset, $limit);

		$results                  = $db->loadObjectList();
		$response['totalshowing'] = count($results);
		$response['query']        = $query->__toString();

		// dd($results);

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;

		if (count($results))
		{
			foreach ($results as $joomla_item_id)
			{
				$response['items'][] = new Product($joomla_item_id);
			}
		}
		else
		{
			$response['items'] = [];
		}

		$response['render'] = self::renderTypesGaF($response['items'], $node);

		return $response;
	}

	public static function getGridAndFilterList(
			int $limit                     = 10, 
			int $offset                    = 0, 
			array $categories              = null, 
			array $searchTerms             = null, 
			array $customFieldsSearchTerms = null, 
			string $priceFrom              = null, 
			string $priceTo                = null, 
			array $variants                = null, 
			array $filter_custom_fields    = null, 
			array $options                 = null, 
			array $tags                    = null, 
			string $orderBy                = 'a.id', 
			string $orderDir               = 'DESC',
			array $node                    = []
		): ?array
	{

		$time_start = microtime(true);
		$response = ['items' => [], 'timestamps' => [0 => $time_start]];

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select(['p.*']);
		$query->from($db->quoteName('#__content', 'a'));

		// Combine Products
    	$query->join('INNER', $db->quoteName('#__commercelab_shop_product', 'p') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('p.joomla_item_id'));

		// if ($customFieldsSearchTerms)
		// {
  //   		$query->join('LEFT', $db->quoteName('#__fields_values', 'fv') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('fv.item_id'));
		// }

		// Item must be published
		$query->where($db->quoteName('a.state') . ' = 1 ');

		$response['totalitems'] = count($db->setQuery($query->group('a.id'))->loadColumn());

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($searchTerms)
		{
			foreach ($searchTerms as $searchTermGroup) {

				$grouped_query = [];
				foreach ($searchTermGroup as $searchTerm => $value) if ($value != '')
				{

					switch($searchTerm)
					{

						case 'stock':
							$grouped_query[] = $db->quoteName('p.' . $searchTerm) . ' > ' . $db->quote($value);
							break;

						case 'title':
							$grouped_query[] = $db->quoteName('a.' . $searchTerm) . ' LIKE ' . $db->quote('%' . $value . '%');
							break;

						case 'all_custom_fields':
							if (!empty(self::getIdsFromFieldValues(null, $value)))
							{
								$grouped_query[] = $db->quoteName('a.id') . ' IN (' . implode(', ', self::getIdsFromFieldValues(null, $value)) . ')';
							}
							break;

						default:
							$grouped_query[] = $db->quoteName('p.' . $searchTerm) . ' LIKE ' . $db->quote('%' . $value . '%');
							break;

					}
				}

				if (!empty($grouped_query))
				{
					$query->where('(' . implode(' OR ', $grouped_query) . ')');
				}

			}
		}

		if ($customFieldsSearchTerms)
		{

			foreach ($customFieldsSearchTerms as $searchTermGroup)
			{
				$grouped_query = [];
				foreach ($searchTermGroup as $field_ids => $value) if (trim($value) != '')
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(', ', self::getIdsFromFieldValues($field_ids, $value)) . ')');
				}
			}
		}

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($categories && !empty($categories))
		{
			$grouped_query = [];
			foreach ($categories as $category_group) if (!empty($category_group))
			{
				$grouped_query[] = $db->quoteName('a.catid') . ' IN (' . implode(', ', $category_group) . ')';
			}
			if (!empty($grouped_query))
			{
				$query->where('(' . implode(' OR ', $grouped_query) . ')');
			}
		}

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($variants && !empty($variants))
		{
			foreach ($variants as $variant_group) if (!empty($variant_group))
			{
				$grouped_query = [];
				foreach ($variant_group as $selected_variant)
				{
					$grouped_query[] = $db->quoteName('a.id') . ' IN (' . implode(', ', $selected_variant['items']) . ')';
				}
				if (!empty($grouped_query))
				{
					$query->where('(' . implode(' OR ', $grouped_query) . ')');
				}
			}
		}

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($filter_custom_fields && !empty($filter_custom_fields))
		{
			foreach ($filter_custom_fields as $filter_custom_fields_group) if (!empty($filter_custom_fields_group))
			{
				$grouped_query = [];
				foreach ($filter_custom_fields_group as $selected_custom_field)
				{
					$grouped_query[] = $db->quoteName('a.id') . ' IN (' . implode(', ', $selected_custom_field['items']) . ')';
				}
				if (!empty($grouped_query))
				{
					$query->where('(' . implode(' OR ', $grouped_query) . ')');
				}
			}
		}

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($options && !empty($options))
		{
			foreach ($options as $option_group) if (!empty($option_group))
			{
				$grouped_query = [];
				foreach ($option_group as $selected_option)
				{
					$grouped_query[] = $db->quoteName('a.id') . ' IN (' . implode(', ', $selected_option['items']) . ')';
				}
				if (!empty($grouped_query))
				{
					$query->where('(' . implode(' OR ', $grouped_query) . ')');
				}
			}
		}

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($tags && !empty($tags))
		{
			foreach ($tags as $tag_group) if (!empty($tag_group))
			{
				$grouped_query = [];
				foreach ($tag_group as $selected_tag)
				{
					$grouped_query[] = $db->quoteName('a.id') . ' IN (' . implode(', ', $selected_tag['items']) . ')';
				}
				if (!empty($grouped_query))
				{
					$query->where('(' . implode(' OR ', $grouped_query) . ')');
				}
			}
		}

		// Prices Matrix
		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		if ($priceFrom || $priceTo)
		{
			if (!is_null($priceFrom) && !is_null($priceTo))
			{
				$query->where($db->quoteName('p.base_price') . ' > ' . (int) $priceFrom . ' AND ' . $db->quoteName('p.base_price') . ' < ' . (int) $priceTo);
			}
			else
			{
				if (is_null($priceFrom))
				{
					$query->where($db->quoteName('p.base_price') . ' < ' . (int) $priceTo);
				}
				if (is_null($priceTo))
				{
					$query->where($db->quoteName('p.base_price') . ' > ' . (int) $priceFrom);
				}
			}
		}

		$query->order($orderBy . ' ' . $orderDir);

		$query->group('a.id');

		// dd($query);

		$response['totalfiltered'] = count($db->setQuery($query)->loadColumn());

		// dd($response['totalfiltered']);

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;
		
		// Query With Limits
		$db->setQuery($query, $offset, $limit);

		// dd($query->__toString());

		$results                  = $db->loadObjectList();
		$response['totalshowing'] = count($results);
		$response['query']        = $query->__toString();

		// dd($results);

		// $response['timestamps'][] = (microtime(true) - $time_start)*60;

		if (count($results))
		{
			foreach ($results as $joomla_item_id)
			{
				$response['items'][] = new Product($joomla_item_id);
			}
		}
		else
		{
			$response['items'] = [];
		}

		$response['render'] = self::renderTypesGaF($response['items'], $node);

		return $response;
	}

	public static function renderTypesGaF(
			array $items,
			array $node
		): ?array
	{
		if (!count($items))
		{
			return [];
		}
		$props     = $node['props'];
		$new_items = [];

		foreach ($items as $key => $item) {

			$article = $item->joomlaItem;
			
			$new_item = [];

			foreach ($props as $content_source_type => $content_source) 
				if (in_array($content_source_type, 
					[
						'title_source', 
						'subtitle_source', 
						'content_source', 
						'meta_source', 
						'image_source', 
						'image_alt_source',
						'additional_text',
						'additional_text2'
					]
				) && $content_source != '')
			{
				if (!str_starts_with($content_source, 'custom_field_'))
				{
					$method = $props['type_source'][$content_source]['extensions']['call']['func'];
					$args   = $props['type_source'][$content_source]['extensions']['call']['args'];
					$result = call_user_func_array($method, [$article, $args]);
				}
				else if (JVERSION >= "4.0.0") // Custom Fields Dynamic Values
				{
					$field_id = str_replace('custom_field_', '', $content_source);
					$field    = CustomFieldsHelper::getCustomField($field_id, $article);

					switch ($field->type) {
						// case 'media':
						// 	dump($field);
						// 	break;
						
						default:
							$result = $field->value;
							break;
					}

					// dump($result);
				}

				$max_length = $content_source_type . '_max_length';

				if (isset($props[$max_length]) 
					&& !is_null($props[$max_length])
					&& trim($props[$max_length]) != '')
				{
					$result = strip_tags($result);
					if (strlen(strip_tags($result)) > trim($props[$max_length]))
					{
						$result = substr($result, 0, trim($props[$max_length]));
					}
				}

				$new_item[str_replace('_source', '', $content_source_type)] = $result;
			}
			foreach ($props['type_source'] as $content_source_type => $content_source)
			{
				if (isset($content_source['extensions']['call']['func']))
				{
					$method = $content_source['extensions']['call']['func'];
					$args   = $content_source['extensions']['call']['args'];
					$result = call_user_func_array($method, [$article, $args]);

					$new_item['sources'][$content_source['extensions']['call']['args']['property_name']] = $result;
				}
			}

			$new_item['sources']['link']  = self::getRoute('item', $article->id, $article->catid);
			$new_item['joomla_item_id']   = $item->joomla_item_id;
			$new_item['add2cartquantity'] = 1;
			$new_item['product']          = $item;

			$new_items[] = $new_item;
		}

		// $props['items'] = $new_items;
		// return app(View::class)->render(JPATH_SITE . '/plugins/system/commercelab_gridandfilter/modules/core/elements/result/templates/layouts/default.php', compact('props'));

		return $new_items;

	}



	/**
	 * @param   string  $searchTerm
	 * @param           $categories
	 * @param           $tags
	 * @param   float   $priceFrom
	 * @param   float   $priceTo
	 *
	 * @return array|null
	 * @since 2.0
	 */


	public static function getAllTagsForParams()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);
		$query->select('a.title, a.id ');

		// Select the required fields from the table.
		$query->from($db->quoteName('#__tags', 'a'))
			->where($db->quoteName('a.alias') . ' <> ' . $db->quote('root'))
			->where($db->quoteName('published') . ' = 1')
			->where($db->quoteName('level') . ' > 0');

		// // Count Items
		// $subQueryCountTaggedItems = $db->getQuery(true);
		// $subQueryCountTaggedItems
		// 	->select('COUNT(' . $db->quoteName('tag_map.content_item_id') . ')')
		// 	->from($db->quoteName('#__contentitem_tag_map', 'tag_map'))
		// 	->where($db->quoteName('tag_map.tag_id') . ' = ' . $db->quoteName('a.id'));
		// $query->select('(' . (string) $subQueryCountTaggedItems . ') AS ' . $db->quoteName('countTaggedItems'));

		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getCustomFieldValues($id, array $item_ids = array()): ?array
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true)
			->select([
				'GROUP_CONCAT(DISTINCT fv.item_id) AS items', 
				'fv.value'
			])
			->from($db->quoteName('#__fields_values', 'fv'))
			->where($db->quoteName('fv.field_id') . ' = ' . $db->quote($id))
			->group('fv.value');

		if (count($item_ids))
		{
			$query->where($db->quoteName('fv.item_id') . ' IN (\'' . implode("','", $item_ids) . '\')');
		}

		$db->setQuery($query);

		$results = $db->loadObjectList();

		return $results;
		// $response = [];
		// foreach ($results as &$option) {

		// 	$new_option = new stdClass();
		// 	$items      = explode(',', $option->items);
			
		// 	if ((count($items) == 1 && $items[0] != '')
		// 		|| count($items) > 1)
		// 	{
		// 		$new_option->title    = $option->title;
		// 		$new_option->items    = $items;
		// 		$new_option->numitems = count($items);

		// 		$response[] = $new_option;
		// 	}
		// }

		// return $response;
	}

	public static function getCustomFieldOptions($field_id)
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__fields'))
			->where($db->quoteName('id') . ' = ' . $db->quote($field_id));

		$db->setQuery($query);

		return $db->loadObject();

	}

	public static function getTagsByProducts(array $product_ids = [], array $tag_ids = [])
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select([
			'a.title AS title',
			'a.id AS id',
			'COUNT(tag_map.tag_id) AS numitems',
			'GROUP_CONCAT(DISTINCT tag_map.content_item_id) AS items',
		])->from($db->quoteName('#__tags', 'a'));

		$query->join('INNER', $db->quoteName('#__contentitem_tag_map', 'tag_map') . ' ON ' . $db->quoteName('tag_map.tag_id') . ' = ' . $db->quoteName('a.id'));

		$query->where($db->quoteName('a.alias') . ' <> ' . $db->quote('root'))
			->where($db->quoteName('a.published') . ' = 1')
			->where($db->quoteName('a.level') . ' > 0');

		if (!empty($tag_ids))
		{
			$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $tag_ids) . ')');
		}

		if (!empty($product_ids))
		{
			$query->where($db->quoteName('tag_map.content_item_id') . ' IN (' . implode(',', $product_ids) . ')');
		}

		$query->group('a.id');

		$db->setQuery($query);
		// dd($query->__toString());
		return $db->loadObjectList();

		// // Count Items
		// $subQueryCountTaggedItems = $db->getQuery(true);
		// $subQueryCountTaggedItems
		// 	->select('COUNT(' . $db->quoteName('tag_map.tag_id') . ')', $db->quoteName('tag_map.content_item_id'))
		// 	->from($db->quoteName('#__contentitem_tag_map', 'tag_map'))
		// 	->where($db->quoteName('tag_map.tag_id') . ' = ' . $db->quoteName('a.id'));

		// // $query->select(['a.id', '(' . (string) $subQueryCountTaggedItems . ') AS ' . $db->quoteName('numitems'), 'GROUP_CONCAT(DISTINCT ' . $db->quoteName('tgm.content_item_id') . ') AS ' . $db->quoteName('items')]);
		// $query->select('`a`.`title` AS `title`, `a`.`id` AS `id`, `tgm`.`tag_id` AS `itemnum`, `tgm`.`content_item_id` AS `items`');

	}

	public static function filterList(string $searchTerm, $categories, $tags, float $priceFrom, float $priceTo, $variant, $variantselected): ?array
	{

		$products = array();

		$db = Factory::getDbo();


		if ($tags)
		{

			//if we have tags ... do a search on the Tags table

			$query = $db->getQuery(true);

			$query->select('a.content_item_id');
			$query->from($db->quoteName('#__contentitem_tag_map', 'a'));
			$query->join('INNER', $db->quoteName('#__content', 'b') . ' ON ' . $db->quoteName('a.content_item_id') . ' = ' . $db->quoteName('b.id'));

			$query->where($db->quoteName('a.tag_id') . ' IN ( ' . implode(',', $tags) . ')');
			$query->where($db->quoteName('b.state') . ' = 1');

			if ($categories)
			{
				if (!is_array($categories))
				{
					$categories = array($categories);
				}

				//add in categories if we have any
				$query->where($db->quoteName('b.catid') . ' IN ( ' . implode(',', $categories) . ')');
			}

			if ($searchTerm)
			{
				//add in text search if we have it
				$query->where($db->quoteName('b.title') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			}

		}
		elseif ($categories)
		{
			if (!is_array($categories))
			{
				$categories = array($categories);
			}

			$query = $db->getQuery(true);
			$query->select('a.id');
			$query->from($db->quoteName('#__content', 'a'));

			$query->where($db->quoteName('a.catid') . ' IN (' . implode(',', $categories) . ')');

			if ($searchTerm)
			{
				//add in text search if we have it
				$query->where($db->quoteName('a.title') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			}

		}
		else
		{

			$query = $db->getQuery(true);

			$query->select('id');
			$query->from($db->quoteName('#__content'));

			if ($searchTerm)
			{
				//add in text search if we have it
				$query->where($db->quoteName('title') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
			}


		}

		// set pricing search to true
		$searchPrice = true;

		if ($priceFrom == '' && $priceTo == '')
		{
			// if we're null on both from and to, then set searchPrice to false
			$searchPrice = false;
		}
		if ($priceFrom == '0' && $priceTo == '0')
		{
			// if we're null on both from and to, then set searchPrice to false
			$searchPrice = false;
		}
		if ($priceFrom == 'null' && $priceTo == 'null')
		{
			// if we're null on both from and to, then set searchPrice to false
			$searchPrice = false;
		}

		// if we have a search price, set the null values to numbers to allow searching.
		if ($searchPrice)
		{
			if ($priceFrom == 'null' || $priceFrom == '')
			{
				// lower price can go to zero
				$priceFrom = 0;
			}
			if ($priceTo == 'null' || $priceTo == '')
			{
				// higher price goes to some astronomical value
				// this allows searches to have a min price but no max price
				$priceTo = 99999999;
			}

			// now use Brick to convert the number to minor int.
			// Currency ISO code doesn't matter here
			$priceFrom = \Brick\Money\Money::of($priceFrom, 'EUR', new \Brick\Money\Context\CashContext(1), \Brick\Math\RoundingMode::DOWN);
			$priceFrom = $priceFrom->getMinorAmount()->toInt();
			$priceTo   = \Brick\Money\Money::of($priceTo, 'EUR', new \Brick\Money\Context\CashContext(1), \Brick\Math\RoundingMode::DOWN);
			$priceTo   = $priceTo->getMinorAmount()->toInt();
		}

		$db->setQuery($query);

		$contentResults = $db->loadColumn();

		if($variant)
		{
			$query = $db->getQuery(true);

			$query->select('product_id');
			$query->from($db->quoteName('#__commercelab_shop_product_variant'));
			$query->where($db->quoteName('name') . ' = ' . $db->quote($variant));
			$db->setQuery($query);

			$variantProducts = $db->loadObjectlist();
			$variantContent = array();
			foreach($variantProducts as $variantProduct){
				array_push($variantContent,$variantProduct->product_id);
			}

			$contentResults = array_intersect($variantContent,$contentResults);

		}

		if($variantselected)
		{

			$query = $db->getQuery(true);

			$query->select('product_id');
			$query->from($db->quoteName('#__commercelab_shop_product_variant_label'));
			$query->where($db->quoteName('name') . ' LIKE "%' . $variantselected . '%"');
			$query->group('product_id');
			$db->setQuery($query);

			
			$variantProducts = $db->loadObjectlist();
			$variantContent = array();
			foreach($variantProducts as $variantProduct){
				array_push($variantContent,$variantProduct->product_id);
			}

			$contentResults = array_intersect($variantContent,$contentResults);

		}

		if ($contentResults)
		{
			foreach ($contentResults as $contentId)
			{
				$query = $db->getQuery(true);

				$query->select('*');
				$query->from($db->quoteName('#__commercelab_shop_product'));
				$query->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($contentId));
				$db->setQuery($query);

				$productResult = $db->loadObject();

				if ($productResult)
				{
					if(!empty($productResult->discount))
					{
						$realprice = ($productResult->base_price-$productResult->discount);
					}else{
						$realprice = $productResult->base_price;
					}
					// do pricing
					if ($searchPrice)
					{
						if ($productResult->base_price >= $priceFrom && $realprice <= $priceTo)
						{
							$products[] = new Product($productResult);
						}
					}
					else
					{
						$products[] = new Product($productResult);
					}

				}

			}

			return $products;
		}

		return null;

	}


	/**
	 * @param   Input  $data
	 *
	 *
	 * @return null|Product
	 * @throws Exception
	 * @since 2.0
	 */

	public static function duplicateFromInputData(Input $data)
	{

		if ($items = $data->json->get('items', '', 'ARRAY'))
		{

			$db = Factory::getDbo();

			/** @var Product $item */
			foreach ($items as $item)
			{

				//  Step #1

				// Create Joomla Article

				$query = $db->getQuery(true);
				$query->select($db->quoteName(array(
					'attribs', 
					'metadata'
				)));
				$query->from($db->quoteName('#__content'));
				$query->where($db->quoteName('id') . ' = ' . $db->quote($item['joomlaItem']['id']));

				$db->setQuery($query);

				$results  = $db->loadObjectList();
				$attribs  = $results[0]->attribs;
				$metadata = $results[0]->metadata;


				$content        = new stdClass();
				$content->id    = $content->state = 0;
				$content->title = $item['joomlaItem']['title'] . ' (Copy)';

				// Workaround for Greek titles.
				$alias = GreekSlugGenerator::getSlug($content->title);
				$alias = OutputFilter::stringUrlUnicodeSlug($alias);
				$alias = Utilities::generateUniqueAlias($alias);

				$content->alias = $alias;

				$content->introtext   = $item['joomlaItem']['introtext'];
				$content->fulltext    = $item['joomlaItem']['fulltext'];
				$content->catid       = $item['joomlaItem']['catid'];
				$content->access      = $item['joomlaItem']['access'];				
				$content->featured    = $item['joomlaItem']['featured'];
				$content->language    = $item['joomlaItem']['language'];
				$content->created     = Utilities::prepareDateToSave();
				$content->created_by  = $item['joomlaItem']['created_by'];
				$content->modified    = Utilities::prepareDateToSave();
				$content->modified_by = $item['joomlaItem']['modified_by'];
				$content->publish_up  = $item['joomlaItem']['publish_up'];
				$content->urls        = $item['joomlaItem']['urls'];
				$content->metadesc    = $item['joomlaItem']['metadesc'];
				$content->metakey     = $item['joomlaItem']['metakey'];
				$content->metadata    = $metadata;
				$content->language    = $item['joomlaItem']['language'];
				$content->images      = $item['joomlaItem']['images'];
				$content->attribs     = $attribs;

				if (!$db->insertObject('#__content', $content))
				{
					return null;
				}

				$new_joomla_article_id = $db->insertid();


				// Step #2
				// Get Custom Fields

				$query = $db->getQuery(true);
				$query->select($db->quoteName([
					'field_id', 
					'value'
				]));
				$query->from($db->quoteName('#__fields_values'));
				$query->where($db->quoteName('item_id') . ' = ' . $db->quote($item['joomlaItem']['id']));

				$db->setQuery($query);

				$custom_fields  = $db->loadObjectList();

				// Duplicate Custom Fields
				if ($custom_fields)
				{

					$query_values = [];
					foreach ($custom_fields as $field) {
						$query_values[] = implode(',', [
							(int) $field->field_id,
							(int) $new_joomla_article_id,
							$db->quote($field->value),
						]);
					}

					// Prepare Save Query
					$query = $db->getQuery(true);

					$query
						->insert($db->quoteName('#__fields_values'))
						->columns(
							$db->quoteName(
								[
									'field_id',
									'item_id', 
									'value'
								]
							)
						);

					$query->values($query_values);

					// Execute Save
					$db->setQuery($query)->execute();
				}


				// Step #3
				// Get Gallery Images

				if (PluginHelper::isEnabled('system', 'commercelab_shop_gallery'))
				{

					$query = $db->getQuery(true);
					$query->select($db->quoteName([
						'path', 
						'ordering'
					]));
					$query->from($db->quoteName('#__commercelab_shop_gallery'));
					$query->where($db->quoteName('product_j_id') . ' = ' . $db->quote($item['joomlaItem']['id']));

					$db->setQuery($query);

					$gallery_images  = $db->loadObjectList();

					// Duplicate Images
					if ($gallery_images)
					{

						$query_values = [];
						foreach ($gallery_images as $image) {
							$query_values[] = implode(',', [
								$db->quote($image->path),
								(int) $new_joomla_article_id,
								$db->quote($image->ordering),
							]);
						}

						// Prepare Save Query
						$query = $db->getQuery(true);

						$query
							->insert($db->quoteName('#__commercelab_shop_gallery'))
							->columns(
								$db->quoteName(
									[
										'path',
										'product_j_id', 
										'ordering'
									]
								)
							);

						$query->values($query_values);

						// Execute Save
						$db->setQuery($query)->execute();
					}

				}

				// Create the Tags
				if ($item['tags'])
				{
					TagFactory::saveTags($new_joomla_article_id, $item['tags']);
				}

				// Step #3
				// Create CommerceLab Product

				$product                 = new stdClass();
				$product->joomla_item_id = $new_joomla_article_id;

				//		FIX j4 WORKFLOWS
				if (JVERSION >= "4.0.0")
				{
					$object            = new stdClass();
					$object->item_id   = $product->joomla_item_id;
					$object->stage_id  = 1;
					$object->extension = 'com_content.article';

					$db->insertObject('#__workflow_associations', $object);
				}

				$product->subtitle       = $item['subtitle'];
				$product->short_desc     = $item['short_desc'];
				$product->long_desc      = $item['long_desc'];
				$product->base_price     = $item['base_price'];
				$product->shipping_mode  = $item['shipping_mode'];
				$product->flatfee        = $item['flatfee'];
				$product->discount       = $item['discount'];
				$product->manage_stock   = $item['manage_stock'];
				$product->apply_discount = $item['apply_discount'];
				$product->stock          = $item['stock'];
				$product->maxPerOrder    = $item['maxPerOrder'];
				$product->taxclass       = $item['taxclass'];
				$product->weight         = $item['weight'];
				$product->weight_unit    = $item['weight_unit'];
				$product->sku            = $item['sku'];
				$product->discount_type  = $item['discount_type'];


				if (!$db->insertObject('#__commercelab_shop_product', $product))
				{
					return null;
				}

			}

			return true;

		}

		//  else {

		// 	return self::createNewProduct($data);

		// }

	}
	/**
	 * @param   Input  $data
	 *
	 *
	 * @return null|Product
	 * @throws Exception
	 * @since 2.0
	 */
	public static function saveFromInputData(Input $data)
	{

		// if there's no item id, then we need to create a new product
		if ($data->json->getInt('itemid') === 0)
		{
			return self::createNewProduct($data);
		}
		// product exists so we can run an update
		// get current product object
		$currentProduct = self::get($data->json->getInt('itemid'));

		// set up Joomla Item:

		$currentProduct->joomlaItem->title       = $data->json->getString('title', $currentProduct->joomlaItem->title);
		$currentProduct->joomlaItem->access      = $data->json->getInt('access', $currentProduct->joomlaItem->access);
		$currentProduct->joomlaItem->modified_by = Factory::getUser()->id;
		$currentProduct->joomlaItem->modified    = Utilities::prepareDateToSave();
		$currentProduct->joomlaItem->images      = self::processImagesForSave(
			$data->json->getString('teaserimage', $currentProduct->teaserImagePath),
			$data->json->getString('fullimage', $currentProduct->fullImagePath)
		);
		$currentProduct->joomlaItem->featured    = $data->json->getInt('featured', $currentProduct->joomlaItem->featured);
		$currentProduct->joomlaItem->state       = $data->json->getInt('state', $currentProduct->joomlaItem->state);
		$currentProduct->joomlaItem->publish_up  = Utilities::prepareDateToSave($data->json->getString('publish_up_date', $currentProduct->joomlaItem->publish_up));
		$currentProduct->joomlaItem->catid       = $data->json->getInt('category', $currentProduct->joomlaItem->catid);
		$currentProduct->joomlaItem->language    = $data->json->getString('language', $currentProduct->joomlaItem->language);


		// with prices... we need to run it through the Brick system first.
		$base_price = $data->json->getFloat('base_price');


		if ($base_price)
		{
			$currentProduct->base_price = CurrencyFactory::toInt($base_price);
		}
		else
		{
			$currentProduct->base_price = $data->json->getFloat('base_price', $currentProduct->base_price);;
		}

		$discount = $data->json->getFloat('discount');
		if ($discount)
		{
			$currentProduct->discount = CurrencyFactory::toInt($discount);
		}
		else
		{
			$currentProduct->discount = $data->json->getFloat('discount', $currentProduct->discount);
		}

		$currentProduct->shipping_mode = $data->json->getString('shipping_mode', $currentProduct->shipping_mode);

		if ($currentProduct->shipping_mode == 'flat')
		{

			$currentProduct->flatfee = $data->json->getFloat('flatfee');

			if ($currentProduct->flatfee)
			{
				$currentProduct->flatfee = CurrencyFactory::toInt($currentProduct->flatfee);
			}

		}
		else
		{
			$currentProduct->flatfee = $data->json->getFloat('flatfee', $currentProduct->flatfee);
		}

		$currentProduct->subtitle       = $data->json->getString('subtitle', $currentProduct->subtitle);
		$currentProduct->short_desc     = json_decode($data->json->getRaw())->short_desc;
		$currentProduct->long_desc      = json_decode($data->json->getRaw())->long_desc;
		$currentProduct->manage_stock   = $data->json->getInt('manage_stock', $currentProduct->manage_stock);
		$currentProduct->apply_discount = $data->json->getInt('apply_discount', $currentProduct->apply_discount);
		$currentProduct->stock          = $data->json->getInt('stock', $currentProduct->stock);
		$currentProduct->maxPerOrder    = $data->json->getInt('maxPerOrder', $currentProduct->maxPerOrder);
		$currentProduct->taxclass       = $data->json->getString('taxclass', $currentProduct->taxclass);
		$currentProduct->weight         = $data->json->getInt('weight', $currentProduct->weight);
		$currentProduct->weight_unit    = $data->json->getString('weight_unit', $currentProduct->weight_unit);
		$currentProduct->sku            = $data->json->getString('sku', $currentProduct->sku);
		$currentProduct->discount_type  = $data->json->getString('discount_type', $currentProduct->discount_type);
		$currentProduct->tags           = $data->json->getString('tags');

		// custom fields
		$currentProduct->custom_fields = $data->json->get('custom_fields', $currentProduct->custom_fields, 'ARRAY');

		$currentProduct->options     = $data->json->get('options', $currentProduct->options, 'ARRAY');
		$currentProduct->variants    = $data->json->get('variants', $currentProduct->variants, 'ARRAY');
		$currentProduct->variantList = $data->json->get('variantList', $currentProduct->variantList, 'ARRAY');


		if (self::commitToDatabase($currentProduct))
		{
			return self::get($data->json->getInt('itemid'));
		}

		return null;

	}


	/**
	 * @param   Input  $data
	 *
	 * @return null|Product
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	private static function createNewProduct(Input $data)
	{


		$db = Factory::getDbo();

		// create the Joomla Item

		$content           = new stdClass();
		$content->id       = 0;
		$content->title    = $data->json->getString('title');

		//alias:
		// Workaround for Greek titles.
		$alias = GreekSlugGenerator::getSlug($content->title);
		$alias = OutputFilter::stringUrlUnicodeSlug($alias);
		$alias = Utilities::generateUniqueAlias($alias);

		$content->alias = $alias;

		$content->introtext   = '';
		$content->fulltext    = '';
		$content->state       = $data->json->getInt('state');
		$content->catid       = $data->json->getInt('category');
		$content->access      = $data->json->getInt('access');
		$content->featured    = $data->json->getInt('featured');
		$content->language    = $data->json->getString('language');
		$content->created_by  = Factory::getUser()->id;
		$content->modified_by = Factory::getUser()->id;
		$content->created     = Utilities::prepareDateToSave();
		$content->modified    = Utilities::prepareDateToSave();
		$content->publish_up  = Utilities::prepareDateToSave($data->json->getString('publish_up_date'));
		$content->urls        = '{"urla":"","urlatext":"","targeta":"","urlb":"","urlbtext":"","targetb":"","urlc":"","urlctext":"","targetc":""}';
		$content->attribs     = '{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}';
		$content->metadesc    = '';
		$content->metakey     = '';
		$content->metadata    = '';
		$content->language    = '*';
		$content->images      = self::processImagesForSave(
			$data->json->getString('teaserimage'),
			$data->json->getString('fullimage')
		);
		if (!$db->insertObject('#__content', $content))
		{
			return null;
		}

		// create the item in CommerceLab Shop Products table

		$product                 = new stdClass();
		$product->joomla_item_id = $db->insertid();

		//		FIX j4 WORKFLOWS
		if(JVERSION >= "4.0.0"){
			$object            = new stdClass();
			$object->item_id   = $product->joomla_item_id;
			$object->stage_id  = 1;
			$object->extension = 'com_content.article';

			$db->insertObject('#__workflow_associations', $object);
		}

		$base_price          = $data->json->getFloat('base_price', 0);
		$product->base_price = CurrencyFactory::toInt($base_price);

		$product->shipping_mode = $data->json->getString('shipping_mode');

		// flat fee
		if ($product->shipping_mode == 'flat')
		{

			$product->flatfee = $data->json->getFloat('flatfee', 0);
			$product->flatfee = CurrencyFactory::toInt($product->flatfee);

		}
		else
		{
			$product->flatfee = 0;
		}

		$discount = $data->json->getFloat('discount', 0);
		if ($discount)
		{
			$product->discount = CurrencyFactory::toInt($discount);
		}

		$product->short_desc     = json_decode($data->json->getRaw())->short_desc;
		$product->long_desc      = json_decode($data->json->getRaw())->long_desc;
		$product->subtitle       = $data->json->getString('subtitle', '');
		$product->apply_discount = $data->json->getInt('apply_discount', 0);
		$product->manage_stock   = $data->json->getInt('manage_stock', 0);
		$product->stock          = $data->json->getInt('stock', 0);
		$product->maxPerOrder    = $data->json->getInt('maxPerOrder', 0);
		$product->taxclass       = $data->json->getString('taxclass', 'taxrate');
		$product->weight         = $data->json->getInt('weight', 0);
		$product->weight_unit    = $data->json->getString('weight_unit');
		$product->sku            = $data->json->getString('sku');
		$product->discount_type  = $data->json->getString('discount_type');
		$product->custom_fields  = $data->json->get('custom_fields', [], 'ARRAY');

		if (!$db->insertObject('#__commercelab_shop_product', $product))
		{
			return null;
		}

		// Create the Tags

		if ($tags = $data->json->getString('tags'))
		{
			TagFactory::saveTags($product->joomla_item_id, $tags);
		}

		self::commitCustomFieldsToDatabase($product->joomla_item_id, $product->custom_fields);

		return self::get($product->joomla_item_id);

	}


	/**
	 * @param   Product  $product
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	private static function commitToDatabase(Product $product): bool
	{

		$db = Factory::getDbo();

		$insertProduct = new stdClass();

		$insertProduct->id             = $product->id;
		$insertProduct->subtitle       = $product->subtitle;
		$insertProduct->joomla_item_id = $product->joomla_item_id;
		$insertProduct->short_desc     = $product->short_desc;
		$insertProduct->long_desc      = $product->long_desc;
		$insertProduct->sku            = $product->sku;
		$insertProduct->base_price     = $product->base_price;
		$insertProduct->shipping_mode  = $product->shipping_mode;
		$insertProduct->flatfee        = $product->flatfee;
		$insertProduct->weight         = $product->weight;
		$insertProduct->weight_unit    = $product->weight_unit;
		$insertProduct->manage_stock   = $product->manage_stock;
		$insertProduct->apply_discount = $product->apply_discount;
		$insertProduct->stock          = $product->stock;
		$insertProduct->discount       = $product->discount;
		$insertProduct->maxPerOrder    = $product->maxPerOrder;
		$insertProduct->discount_type  = $product->discount_type;
		$insertProduct->taxclass       = $product->taxclass;
		$insertProduct->short_desc     = $product->short_desc;
		$insertProduct->long_desc      = $product->long_desc;

		$result = $db->updateObject('#__commercelab_shop_product', $insertProduct, 'joomla_item_id');

		if ($result)
		{
			// now do the Joomla Item

			$jresult = $db->updateObject('#__content', $product->joomlaItem, 'id');

			$j_item_id = $db->insertid();

			if ($jresult)
			{
				// now do variants & checkbox options

				self::commitVariants($product);
				self::commitOptions($product);

			}


			// now do TAGS

			if ($tags = $product->tags)
			{
				TagFactory::saveTags($product->joomla_item_id, $tags);
			}
			else
			{
				TagFactory::clearTags($product->joomla_item_id);
			}

		}

		self::commitCustomFieldsToDatabase($product->joomla_item_id, $product->custom_fields);

		return true;

	}

	public static function commitCustomFieldsToDatabase($joomla_item_id, $custom_fields)
	{

		$db           = Factory::getDbo();
		$query_values = [];

		// now do custom fields
		foreach ($custom_fields as $field)
		{
			// delete item's fields value

			$query = $db->getQuery(true);

			$conditions = array(
				$db->quoteName('item_id') . ' = ' . $db->quote($joomla_item_id)
				// $db->quoteName('field_id') . ' = ' . $db->quote($field['id'])
			);

			$query->delete($db->quoteName('#__fields_values'));
			$query->where($conditions);

			$db->setQuery($query);
			$db->execute();

			// insert value back - if any
			if ($field['rawvalue'] == '' && $field['type'] != 'subform')
			{
				continue;
			}

			// Each Element from this array, unless Subform, is stored as a single value - 1 row in table
			$values = [];
			switch ($field['type'])
			{

				case 'list':
					if (isset($field['fieldparams']['multiple']) && $field['fieldparams']['multiple'])
					{
						foreach ($field['rawvalue'] as $key => $rawvalue)
						{
							$has_value = ($rawvalue != '') ? $rawvalue : null;
							if (!is_null($has_value))
							{
								$values[] = $has_value;
							}
						}
					}
					else
					{
						$has_value = ($field['rawvalue'] != '') ? $field['rawvalue'] : null;
						if (!is_null($has_value))
						{
							$values[] = $has_value;
						}
					}

					break;

				case 'checkboxes':
				case 'imagelist':
					if (is_array($field['rawvalue']))
					{
						foreach ($field['rawvalue'] as $key => $rawvalue)
						{
							$has_value = ($rawvalue != '') ? $rawvalue : null;
							if (!is_null($has_value))
							{
								$values[] = $has_value;
							}
						}
					}
					else
					{
						$has_value = ($field['rawvalue']  != '') ? $field['rawvalue']  : null;
						if (!is_null($has_value)){
							$values[] = $has_value;
						}
					}
					break;

				default:
					$has_value = self::prepareCustomFieldValues($field);
					if ($has_value)
					{
						$values[] = $has_value;
					}
					break;
			}

			if (count($values))
			{
				foreach ($values as $value)
				{
					$query_values[] = implode(',', [
						(int) $field['id'],
						(int) $joomla_item_id,
						$db->quote($value),
					]);
				}
			}
		}

		// Prepare Save Query
		$query = $db->getQuery(true);

		$query
			->insert($db->quoteName('#__fields_values'))
			->columns(
				$db->quoteName(
					[
						'field_id',
						'item_id', 
						'value'
					]
				)
			);

		// dd($query_values);
		// If data for Save Exist
		if (count($query_values)) {

			$query->values($query_values);

			$db->setQuery($query);
			// dd($query->dump());
			return $db->execute();
		}

		return false;

	}

	public static function prepareCustomFieldValues($field)
	{
		$values = false;
		switch($field['type'])
		{
			case 'media';
				$has_value = self::prepareMediaCustomField($field);
				if ($has_value)
					$values = $has_value;
				break;

			case 'subform';
				$subform_values = [];
				foreach($field['subform_rows'] as $row_index => $subform_row) {

					$subfield_values = [];
					foreach($subform_row as $field_name => $subform_field) {

						if ($subform_field['rawvalue'] == '')
							continue;

						$data = false;
						switch($subform_field['type'])
						{
							case 'media':
								$has_value = self::prepareMediaCustomField($subform_field);
								if ($has_value)
									$data = $has_value;
								break;

							default:
								$has_value = ($subform_field['rawvalue'] != '') ? $subform_field['rawvalue'] : false;
								if ($has_value)
									$data = $has_value;
								break;
						}

						if ($data)
							$subfield_values['field' . $subform_field['id']] = $data;
					}

					if (count($subfield_values))
						$subform_values['row' . $row_index] = $subfield_values;

				}
				if (count($subform_values))
					$values = json_encode($subform_values);
				break;

			default:
				$values = $field['rawvalue'];
				break;
		}

		if ($values == '' || !$values)
			return false;

		return $values;
	}

	public static function prepareMediaCustomField($field)
	{

		$image_path = $field['rawvalue'];
		if ($image_path == '')
			return;
		
		if (JVERSION >= "4.0.0" ) {

			if (!isset($field['width']) || !isset($field['height'])) {

				$full_image_path = JPATH_SITE . "/" . $image_path;

				list($width, $height, $type, $attributes) 
									  = getimagesize($full_image_path);

				$image_width      = $width;
				$image_height     = $height;
			} else {
				$image_width      = $field['width'];
				$image_height     = $field['height'];
			}

			$data = [
				'imagefile' => $image_path . '#joomlaImage://local-' . $image_path . '?width=' . $image_width . '&height=' . $image_height,
				"alt_text" => "",
			];

			return json_encode($data);
		} else {
			return $image_path;
		}

	}

	/**
	 * @param   Product  $product
	 *
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function commitOptions(Product $product): void
	{


		$db = Factory::getDbo();

		// check that there are options set
		if ($product->options)
		{
			// ok we have options - iterate them and either insert or update

			/** @var Productoption $option */
			foreach ($product->options as $option)
			{

				// convert to object to satisfy Joomla's DB system
				$option = (object) $option;


				//process value
				if (property_exists($option, 'modifier_valueFloat'))
				{
					$option->modifier_value = CurrencyFactory::toInt($option->modifier_valueFloat);
					unset($option->modifier_valueFloat);
				}
				// set the "product_id"
				$option->product_id = $product->joomla_item_id;

				// check if we have a new option by checking if the id is "0"
				if ($option->id == 0)
				{

					// sometimes the oprion is created and then set to "delete" by the user, so check that:
					if (!$option->delete)
					{

						// unset delete value, since Joomla's DB system doesn't know what to do when there's no coloumn for this node.
						unset($option->delete);

						// the option id is 0 and the "delete" value is false, that means this is a new option, run insert
						$db->insertObject('#__commercelab_shop_product_option', $option);

					}

				}
				else
				{

					if (property_exists($option, 'delete'))
					{
						// the option id is already set, check if this option is set to "delete"
						if (!$option->delete)
						{

							// unset delete value, since Joomla's DB system doesn't know what to do when there's no coloumn for this node.
							unset($option->delete);

							// the option id is already set and the "delete" value is false, so run update
							$db->updateObject('#__commercelab_shop_product_option', $option, 'id');

						}
						else
						{
							// the "delete" value is true, so remove:
							$query      = $db->getQuery(true);
							$conditions = array(
								$db->quoteName('id') . ' = ' . $db->quote($option->id)
							);

							$query->delete($db->quoteName('#__commercelab_shop_product_option'));
							$query->where($conditions);

							$db->setQuery($query);

							$db->execute();
						}

					}
					else
					{
						// update
						unset($option->modifier_value_translated);
						$db->updateObject('#__commercelab_shop_product_option', $option, 'id');
					}
				}


			}
		}
		else
		{
			// remove all current options

			$query      = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('product_id') . ' = ' . $db->quote($product->joomla_item_id)
			);

			$query->delete($db->quoteName('#__commercelab_shop_product_option'));
			$query->where($conditions);

			$db->setQuery($query);

			$db->execute();

		}


	}


	/**
	 * @param   Product  $product
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	public static function commitVariants(Product $product): bool
	{


		// init $variantIds - this array holds the ids for all the list variants in the current request - used for deleting removed variants.
		$variantIds = array();

		$db = Factory::getDbo();

		foreach ($product->variants as $variant)
		{
			// get the id for removal function later.
			$variantIds[] = $variant['id'];

			// check if this variant exists

			$query = $db->getQuery(true);

			$query->select('*');
			$query->from($db->quoteName('#__commercelab_shop_product_variant'));
			$query->where($db->quoteName('id') . ' = ' . $db->quote($variant['id']));

			$db->setQuery($query);

			$result = $db->loadObject();

			$object = new stdClass();
			if ($result)
			{
				//exists... update

				$object->id         = $variant['id'];
				$object->product_id = $product->joomla_item_id;
				$object->name       = $variant['name'];

				$db->updateObject('#__commercelab_shop_product_variant', $object, 'id');

			}
			else
			{
				// does not exist... insert
				$object->id         = 0;
				$object->product_id = $product->joomla_item_id;
				$object->name       = $variant['name'];

				$db->insertObject('#__commercelab_shop_product_variant', $object);


			}
			// now labels.

			self::saveLabels($variant);
		}

		// now delete all removed variants
		self::removeDeletedVariants($product->joomla_item_id, $variantIds);


		// now add/update the actual variantList data!

//		//for cleanup of removed variants & labels... collect the label_ids in an array for later use:
//		$variantListLabelIds = array();
//
//
//		foreach ($product->variantList as $variantListItem)
//		{
//
//
//			//check if the item already exists in the db
//			$query = $db->getQuery(true);
//
//			$query->select('*');
//			$query->from($db->quoteName('#__commercelab_shop_product_variant_data'));
//			$query->where($db->quoteName('id') . ' = ' . $db->quote($variantListItem['id']));
//
//			$db->setQuery($query);
//
//			$result = $db->loadObject();
//
//
//			// init the object for updating or inserting
//			$object             = new stdClass();
//			$object->product_id = $product->joomla_item_id;
//			$object->label_ids  = $variantListItem['label_ids'];
//			$object->price      = CurrencyFactory::toInt($variantListItem['price']);
//			$object->stock      = $variantListItem['stock'];
//			$object->sku        = $variantListItem['sku'];
//			$object->active     = ($variantListItem['active'] ? 1 : 0);
//			$object->default    = ($variantListItem['default'] ? 1 : 0);
//
//			if ($result)
//			{
//				// if so, update
//				$object->id = $variantListItem['id'];
//				$db->updateObject('#__commercelab_shop_product_variant_data', $object, 'id');
//			}
//			else
//			{
//				//if not, insert
//				$object->id = 0;
//				$db->insertObject('#__commercelab_shop_product_variant_data', $object);
//			}
//
//			//for cleanup of removed variants & labels... collect the ids in an array for later use:
////			$variantListLabelIds[] = explode(',', $variantListItem['label_ids']);
//			$variantListLabelIds[] = $variantListItem['label_ids'];
//
//
//		}

//		self::removeDeletedVariantListItems($product->joomla_item_id, $variantListLabelIds);


		return true;


	}


	/**
	 * @param   int    $product
	 * @param   array  $variantIds
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	private static function removeDeletedVariants(int $j_item_id, array $variantIds): void
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($j_item_id));

		$db->setQuery($query);

		$currentVariantList = $db->loadObjectList();

		// iterate them and check if the id from the table is in the array

		foreach ($currentVariantList as $currentVariant)
		{

			if (in_array($currentVariant->id, $variantIds))
			{
				// if so, continue
				continue;
			}
			else
			{

				// if not, delete
				$query      = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('id') . ' = ' . $db->quote($currentVariant->id)
				);
				$query->delete($db->quoteName('#__commercelab_shop_product_variant'));
				$query->where($conditions);
				$db->setQuery($query);
				$db->execute();

				//now remove labels too
				$query      = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('variant_id') . ' = ' . $db->quote($currentVariant->id)
				);
				$query->delete($db->quoteName('#__commercelab_shop_product_variant_label'));
				$query->where($conditions);
				$db->setQuery($query);
				$db->execute();


			}

		}

	}

	/**
	 * @param   array  $variant
	 * @param   array  $labelIds
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	private static function removeDeletedVariantLabels(array $variant, array $labelIds): void
	{

		// create an array of all the label ids from the request ^^ (these are the ones that now exist on the product) - $labelIds
		// get all entries for this variant_id in an objectlist

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_label'));
		$query->where($db->quoteName('variant_id') . ' = ' . $db->quote($variant['id']));

		$db->setQuery($query);

		$currentLabels = $db->loadObjectList();

		// iterate them and check if the id from the table is in the array

		foreach ($currentLabels as $currentLabel)
		{

			if (in_array($currentLabel->id, $labelIds))
			{
				// if so, continue
				continue;
			}
			else
			{
				// if not, delete
				$query      = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('id') . ' = ' . $db->quote($currentLabel->id)
				);
				$query->delete($db->quoteName('#__commercelab_shop_product_variant_label'));
				$query->where($conditions);
				$db->setQuery($query);
				$db->execute();
			}

		}

	}

	/**
	 * @param   int    $joomla_item_id
	 * @param   array  $variantListLabelIds
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	private static function removeDeletedVariantListItems(int $joomla_item_id, array $variantListLabelIds): void
	{

		// create an array of all the item ids from the request ^^ (these are the ones that now exist on the product) - $variantListIds
		// get all entries for this product_id in an objectlist

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_data'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($joomla_item_id));

		$db->setQuery($query);

		$currentItems = $db->loadObjectList();

		// iterate them and check if the id from the table is in the array

		foreach ($currentItems as $currentItem)
		{
			// make an array out of the current rows label_ids - for equality comparison
//			$currentItemLabelIdArray = explode(',', $currentItem->label_ids);


//			if (in_array($currentItemLabelIdArray, $variantListLabelIds))
			if (in_array($currentItem->label_ids, $variantListLabelIds))
			{
				// if so, continue
				continue;
			}
			else
			{
				// if not, delete
				$query      = $db->getQuery(true);
				$conditions = array(
					$db->quoteName('id') . ' = ' . $db->quote($currentItem->id)
				);
				$query->delete($db->quoteName('#__commercelab_shop_product_variant_data'));
				$query->where($conditions);
				$db->setQuery($query);
				$db->execute();
			}


		}

	}


	/**
	 * @param   int          $limit
	 * @param   int          $offset
	 * @param   string|null  $searchTerm
	 * @param   string|null  $optionType
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function getOptionList(int $limit = 0, int $offset = 0, $searchTerm = null, string $optionType = null): ?array
	{

		$options = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_option'));

		if ($searchTerm)
		{
			$query->where($db->quoteName('name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));

		}

		if ($optionType)
		{
			$query->where($db->quoteName('option_type') . ' = ' . $db->quote($optionType));
		}


		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		if ($results)
		{
			foreach ($results as $result)
			{
				$options[] = new Option($result);

			}

			return $options;
		}


		return null;

	}

	/**
	 * @param   int  $j_item_id
	 *
	 *
	 * @return int
	 * @since 2.0
	 */

	public static function getCurrentStock(int $j_item_id): int
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('stock');
		$query->from($db->quoteName('#__commercelab_shop_product'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($j_item_id));

		$db->setQuery($query);

		return $db->loadResult();

	}


	/**
	 * @param $joomla_item_id
	 *
	 * @return JoomlaItem
	 *
	 * @since 2.0
	 */

	public static function getJoomlaItem($joomla_item_id): ?JoomlaItem
	{


		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__content'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($joomla_item_id));

		$db->setQuery($query);

		$result = $db->loadObject();
		if ($result && is_object($result))
		{
			return new JoomlaItem($result);
		}

		return null;

	}

	/**
	 * @param   int  $j_item_id
	 *
	 * @return array|null
	 *
	 * @since 2.0
	 */


	public static function getCustomFields(int $j_item_id): ?array
	{

		return [];
	}


	/**
	 * @param   string  $type
	 * @param   int     $joomla_item_id
	 * @param   int     $catid
	 *
	 * @return string|null
	 *
	 * @since 2.0
	 */

	public static function getRoute(string $type, int $joomla_item_id, int $catid): ?string
	{

		switch ($type)
		{
			case 'category':
				return Route::_('index.php?option=com_content&view=category&layout=blog&id=' . $catid);
			default:
				// item
				return Route::_('index.php?option=com_content&view=article&id=' . $joomla_item_id . '&catid=' . $catid);
		}


	}


	/**
	 * @param $price
	 *
	 * @return BigDecimal
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function getFloat($price): BigDecimal
	{
		if (is_null($price))
		{
			$price = 0;
		}
		return CurrencyFactory::toFloat($price);
	}


	/**
	 * @param   int  $price
	 *
	 * @return string
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function getFormattedPrice(int $price): string
	{
		return CurrencyFactory::translate($price);
	}

	public static function getFormattedPercent(int $percent): string
	{
		return CurrencyFactory::formatNumberWithCurrency($percent, null, true);
	}

	public static function basePriceWithTax(): bool
	{
		return ComponentHelper::getParams('com_commercelab_shop')->get('prices_entered_with_tax', 1) == 1;
	}

	public static function applyDiscountBeforeTaxes(): bool
	{
		return ComponentHelper::getParams('com_commercelab_shop')->get('discount_before_tax', -1);
	}

	public static function applyCouponBeforeTaxes(): bool
	{
		return ComponentHelper::getParams('com_commercelab_shop')->get('apply_coupon_before_tax', 0) == 1;
	}

	public static function addRate($product, bool $default_rate = null): int
	{
		if ($default_rate)
		{
			return TaxFactory::addDefaultRateToPrice($product->base_price);
		}
		else
		{
			return TaxFactory::addRateToPrice($product->base_price, TaxFactory::getAplicableTaxRate($product));
		}
	}

	public static function removeRate($product): int
	{

	}


	/**
	 * @param   int  $price
	 *
	 * @return int
	 *
	 * @since 2.0
	 */

	// public static function removeRateFromPrice(int $price, $rate): int
	// {
	// 	// dd($rate);
	// 	return $price - ($price * $rate);
	// }

	public static function applyDiscount(int $price, $product, $return_with_tax = null): int
	{

		$discounted_price = self::calculateDiscount($price, $product);

		if ($return_with_tax && !ProductFactory::basePriceWithTax())
		{
			return TaxFactory::addApplicableRateToPrice($discounted_price, $product->taxclass);
		}

		if (!$return_with_tax && ProductFactory::basePriceWithTax())
		{
			return TaxFactory::getNetPrice($discounted_price, $product->taxclass);
		}

		return $discounted_price;
		// if ($return_with_tax && !ProductFactory::basePriceWithTax())
		// {
		// 	return TaxFactory::addApplicableRateToPrice($discounted_price, $product->taxclass);
		// }
		
		// if (!$return_with_tax)
		// {
		// 	return $discounted_price;
		// }
		// else
		// {
		// 	// dd(TaxFactory::addApplicableRateToPrice($product->taxclass) / 100);
		// 	if (self::applyDiscountBeforeTaxes() == 1
		// 		|| self::applyDiscountBeforeTaxes() == -1 && !ProductFactory::basePriceWithTax())
		// 	{
		// 		return TaxFactory::addApplicableRateToPrice($discounted_price, $product->taxclass);
		// 	}
		// 	else
		// 	{
		// 		return $discounted_price;
		// 	}
		// }

	}

	public static function calculateDiscount($discounted_price, $product)
	{

		if (!$product->apply_discount)
		{
			return $discounted_price;
		}

		// switch(self::applyDiscountBeforeTaxes())
		// {
		// 	case 1:
		// 		$discounted_price = TaxFactory::getNetPrice($price, $product->taxclass);
		// 		break;
			
		// 	case 0:
		// 		$discounted_price = TaxFactory::getBrutPrice($price, $product->taxclass);
		// 		break;

		// 	default:
		// 		if (ProductFactory::basePriceWithTax())
		// 		{
		// 			$discounted_price = TaxFactory::getBrutPrice($price, $product->taxclass);
		// 		}
		// 		else
		// 		{
		// 			$discounted_price = TaxFactory::getNetPrice($price, $product->taxclass);
		// 		}
		// 		break;
		// }

		if ($product->discount_type == 'amount')
		{
			$discounted_price = $discounted_price - $product->discount;
		}
		else
		{
			$discount_rate    = $product->discount / 10000;
			$discounted_price = (int) ($discounted_price - ($discounted_price * $discount_rate));
		}

		return $discounted_price;
	}

	public static function getProductTaxRate($taxclass)
	{
		return TaxFactory::getApplicableTaxRate($taxclass);
	}

	public static function getProductTax(int $value, $tax_rate)
	{
		$tax = TaxFactory::getItemTax($value, $tax_rate);
		return CurrencyFactory::toInt($tax);
	}

	public static function getPriceWithTax(int $value, $taxclass): int
	{
		return TaxFactory::getBrutPrice($value, $taxclass);
	}

	public static function getPriceWithoutTax(int $value, $taxclass): int
	{
		return TaxFactory::getNetPrice($value, $taxclass);
	}


	/**
	 * @param $category_id
	 *
	 * @return string|null
	 *
	 * @since 2.0
	 */

	public static function getCategoryParentsTree(int $cat_id): ?array
	{
		$extension = 'com_content';
		if (JVERSION < "4.0.0")
		{
			$extension = 'content';
		}
		$categories = Categories::getInstance($extension);
		$category   = $categories->get((int) $cat_id);

		return array_keys($category->getPath());
	}

	public static function getUncategorisedId(): ?int
	{
		$categories = Categories::getInstance('com_content');
		if (JVERSION < "4.0.0")
		{
			$categories = Categories::getInstance('content');
		}
		$category   = $categories->get('root');

		foreach ($category->getChildren() as $cat_child) {
			
			if ($cat_child->alias == 'uncategorised')
			{
				return $cat_child->id;
			}
		}

		return 0;
	}

	/**
	 * @param $category_id
	 *
	 * @return string|null
	 *
	 * @since 2.0
	 */

	public static function getCategoryName($category_id): ?string
	{

		//$categories   = Categories::getInstance('content');
		//$categoryNode = $categories->get($category_id);   // returns the category node for category with id=12

		//return $categoryNode->title;

		$db = Factory::getDbo();

		$availableFields = array();

		$query = $db->getQuery(true);

		$query->select('title');
		$query->from($db->quoteName('#__categories'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($category_id));

		$db->setQuery($query);

		return $results = $db->loadResult();

	}


	/**
	 * @param   int  $joomla_item_id
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function getTags(int $joomla_item_id): array
	{

		return TagFactory::getTags($joomla_item_id);

	}


	/**
	 * @param   int  $itemid
	 * @param   int  $catid
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function getAvailableCustomFields(object $joomla_item = null, int $catid = 0): array
	{
		$fields     = CustomFieldsHelper::getApprovedCustomFields($joomla_item);
		$fieldTypes = CustomFieldsHelper::getFieldTypes();
		$fieldTypes['location'] = [
			"type" => "location",
			"label" => "Location"
		];
		$groups = $types = [];
		$fields_in_group = 0;

		foreach ($fields as $key => $field) {
			// Group ALL Fields for Showing in Product
			if ($field->group_title) {

				$groups[$field->group_id]['categories']  = array_unique(array_merge(
					(isset($groups[$field->group_id]['categories']))
						? $groups[$field->group_id]['categories']
						: [], 
					$field->assigned_category_ids
				));
				$groups[$field->group_id]['id']          = $field->group_id;
				$groups[$field->group_id]['title']       = $field->group_title;
				$groups[$field->group_id]['countfields'] = (isset($groups[$field->group_id]['countfields'])) ? $groups[$field->group_id]['countfields'] + 1 : 1;
				$fields_in_group++;
			}
			$types[$field->type] = preg_replace('/ \(.*?\)/i', '', $fieldTypes[$field->type]['label']);
		}

		return [$fields, $groups, $types, $fieldTypes];

	}

	public static function getCustomFieldFieldparams(int $custom_field_id, int $itemId) {

	}

	/**
	 * @param   int  $custom_field_id
	 * @param   int  $itemId
	 *
	 * @return mixed|null
	 *
	 * @since 2.0
	 */

	public static function setCustomFieldValue(int $custom_field_id, int $itemId)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('value');
		$query->from($db->quoteName('#__fields_values'));
		$query->where($db->quoteName('field_id') . ' = ' . $db->quote($custom_field_id));
		$query->where($db->quoteName('item_id') . ' = ' . $db->quote($itemId));

		$db->setQuery($query);

		return $db->loadResult();


	}


	/**
	 * @param   int  $j_item_id
	 *
	 * @return null|array
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function getOptions(int $j_item_id): ?array
	{
		return ProductoptionFactory::getProductOptions($j_item_id);
	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */

	public static function togglePublishedFromInputData(Input $data)
	{

		$response = false;

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');

		/** @var Product $item */
		foreach ($items as $item)
		{

			$query = 'UPDATE ' . $db->quoteName('#__content') . ' SET ' . $db->quoteName('state') . ' = IF(' . $db->quoteName('state') . '=1, 0, 1) WHERE ' . $db->quoteName('id') . ' = ' . $db->quote($item['joomla_item_id']) . ';';
			$db->setQuery($query);
			$result = $db->execute();

			if ($result)
			{
				$response = true;
			}

		}

		return $response;
	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function batchUpdateCategory(Input $data)
	{


		$response = false;

		$db = Factory::getDbo();

		$items       = $data->json->get('items', '', 'ARRAY');
		$category_id = $data->json->get('category_id', '', 'INT');

		/** @var Product $item */
		foreach ($items as $item)
		{


			$object        = new stdClass();
			$object->id    = $item['joomla_item_id'];
			$object->catid = $category_id;
			$result        = $db->updateObject('#__content', $object, 'id');

			if ($result)
			{
				$response = true;
			}

		}

		return $response;

	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */

	public static function batchUpdateStock(Input $data): bool
	{
		$response = false;

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');
		$stock = $data->json->get('stock', '', 'INT');

		/** @var Product $item */
		foreach ($items as $item)
		{

			$object                 = new stdClass();
			$object->joomla_item_id = $item['joomla_item_id'];
			$object->stock          = $stock;
			$result                 = $db->updateObject('#__commercelab_shop_product', $object, 'joomla_item_id');

			if ($result)
			{
				$response = true;
			}

		}

		return $response;


	}


	/**
	 * @param $image
	 *
	 * @return false|string
	 *
	 * @since 2.0
	 */

	public static function getImagePath($image)
	{

		if ($image)
		{
			if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
				return Uri::root() . $image;
			} else {
				return $image;
			}
		}

		return false;


	}

	/**
	 * @param   Input  $data
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function getRefreshedVariantData(Input $data): array
	{

		$j_item_id = $data->json->getInt('j_item_id');

		$response = array();

		$product = self::get($j_item_id);

		$response['variants']    = $product->variants;
		$response['variantList'] = $product->variantList;

		return $response;

	}

	/**
	 * @param   int  $j_item_id
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	private static function variantScorchedEarth(int $j_item_id): bool
	{

		$response = true;

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('product_id') . ' = ' . $db->quote($j_item_id)
		);

		$query->delete($db->quoteName('#__commercelab_shop_product_variant'));
		$query->where($conditions);

		$db->setQuery($query);

		$result = $db->execute();

		if (!$result)
		{
			$response = false;
		}

		$query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('product_id') . ' = ' . $db->quote($j_item_id)
		);

		$query->delete($db->quoteName('#__commercelab_shop_product_variant_label'));
		$query->where($conditions);

		$db->setQuery($query);

		$result = $db->execute();

		if (!$result)
		{
			$response = false;
		}

		$query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('product_id') . ' = ' . $db->quote($j_item_id)
		);

		$query->delete($db->quoteName('#__commercelab_shop_product_variant_data'));
		$query->where($conditions);

		$db->setQuery($query);

		$result = $db->execute();

		if (!$result)
		{
			$response = false;
		}

		return $response;
	}


	/**
	 *
	 * This function takes the variant data, and the Product id as POST $data variables.
	 * It saves the variants and the corresponding labels.
	 * It then runs the Cartesian Product over the variant labels.
	 * Then it saves the Variant List data
	 *
	 *
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function saveVariantsFromInputData(Input $data): bool
	{
		$db = Factory::getDbo();

		$variants = $data->json->get('variants', '', 'ARRAY');


		$j_item_id = $data->json->getInt('itemid');

		//check if variants exist if not delete.
		if (empty($variants))
		{
			return self::variantScorchedEarth($j_item_id);

		}

		$base_price = $data->json->getFloat('base_price');


		if ($base_price)
		{
			$base_price = CurrencyFactory::toInt($base_price);
		}
		else
		{
			$base_price = 0;
		}


		foreach ($variants as $variant)
		{


			// check to see if the id is in the table... if so, update. If not, insert... usual shit.

			$query = $db->getQuery(true);

			$query->select('*');
			$query->from($db->quoteName('#__commercelab_shop_product_variant'));
			$query->where($db->quoteName('id') . ' = ' . $db->quote($variant['id']));

			$db->setQuery($query);

			$result = $db->loadObject();


			if ($result)
			{
				// update
				$updateVariant             = new stdClass();
				$updateVariant->id         = $variant['id'];
				$updateVariant->product_id = $variant['product_id'];
				$updateVariant->name       = $variant['name'];
				$db->updateObject('#__commercelab_shop_product_variant', $updateVariant, 'id');

			}

			else
			{
				// insert
				$object             = new stdClass();
				$object->id         = 0;
				$object->product_id = $variant['product_id'];
				$object->name       = $variant['name'];

				$db->insertObject('#__commercelab_shop_product_variant', $object);

				// since this is a new variant... set the id.
				$variant['id'] = $db->insertid();

			}

			// get the id for removal function later.
			$variantIds[] = $variant['id'];


			// ok... now that the variants are saved... add the labels.
			self::saveLabels($variant);

		}
		self::removeDeletedVariants($j_item_id, $variantIds);

		// now the fancy bit... run the Cartesian of all the variant labels

		$labelArrays = [];


		// todo - Ahhh... this iteration doesn't contain the new label ids... i was lucky to spot this bug... need to get the new labels!!


		$variants = self::getVariantData($j_item_id);

		// dd($variants->variants);
		foreach ($variants->variants as $variant)
		{
			$labelArrays[] = $variant->labels;
		}

		$cartesianProduct = self::cartesian($labelArrays);

		$dbRowLabelIdsStringArray = array();

		foreach ($cartesianProduct as $node)
		{

			$dbRowLabelIds = array();
			// so $node is an array of the cartesian product of a particular selection.
			// iterate over $node to create the labelIds required for the db processing:

			foreach ($node as $var)
			{
				$dbRowLabelIds[] = $var->id;
			}

			// get the comma separated string
			$dbRowLabelIdsString = implode(',', $dbRowLabelIds);

			// for garbage collection
			$dbRowLabelIdsStringArray[] = $dbRowLabelIdsString;


			// now test the DB for update or insert

			$query = $db->getQuery(true);

			$query->select('*');
			$query->from($db->quoteName('#__commercelab_shop_product_variant_data'));
			$query->where($db->quoteName('label_ids') . ' = ' . $db->quote($dbRowLabelIdsString));
			$query->where($db->quoteName('product_id') . ' = ' . $db->quote($j_item_id));

			$db->setQuery($query);

			$result = $db->loadObject();

			if (!$result)
			{
				//insert

				$object             = new stdClass();
				$object->id         = 0;
				$object->product_id = $j_item_id;
				$object->label_ids  = $dbRowLabelIdsString;
				$object->price      = $base_price;
				$object->stock      = 0;
				$object->sku        = 0;
				$object->active     = 1;
				$object->default    = 0;

				$db->insertObject('#__commercelab_shop_product_variant_data', $object);

			}
			else
			{
				// todo - need to run an update!
//
			}


		}

		// set the valiantList data
		self::updateVariantValuesFromInputData($data);

		// do garbage collection:
		self::removeDeletedVariantListItems($j_item_id, $dbRowLabelIdsStringArray);

		// set a default if there isn't one
		self::setDefaultVariant($j_item_id);


		return true;

	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function updateVariantValuesFromInputData(Input $data): bool
	{

		$db = Factory::getDbo();


		$variantList = $data->json->get('variantList', '', 'ARRAY');


		foreach ($variantList as $variant)
		{


			$price = CurrencyFactory::toInt($variant['price']);


			$object          = new stdClass();
			$object->id      = $variant['id'];
			$object->price   = $price;
			$object->stock   = $variant['stock'];
			$object->sku     = $variant['sku'];
			$object->active  = ($variant['active'] ? 1 : 0);
			$object->default = ($variant['default'] ? 1 : 0);

			$db->updateObject('#__commercelab_shop_product_variant_data', $object, 'id');
		}

		return true;

	}

	/**
	 * @param   int  $j_item_id
	 *
	 *
	 * @return bool
	 * @since 2.0
	 *
	 */


	public static function setDefaultVariant(int $j_item_id): bool
	{

		// check if there is already a default, if so... just return

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_data'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($j_item_id));
		$query->where($db->quoteName('default') . ' = ' . $db->quote(1));

		$db->setQuery($query);

		$result = $db->loadObjectList();

		if ($result)
		{
			return true;
		}
		else
		{
			// if not, set the first instance as default

			$query = $db->getQuery(true);

			$query->select('*');
			$query->from($db->quoteName('#__commercelab_shop_product_variant_data'));
			$query->where($db->quoteName('product_id') . ' = ' . $db->quote($j_item_id));
			$query->setLimit('1');
			$db->setQuery($query);

			$first = $db->loadObject();

			$first->default = 1;

			return $db->updateObject('#__commercelab_shop_product_variant_data', $first, 'id');
		}


	}

	/**
	 *
	 * This function saves the labels of the given variant
	 *
	 * @param   array  $variant
	 *
	 *
	 * @since 2.0
	 */

	private static function saveLabels(array $variant)
	{

		$db = Factory::getDbo();

		$labelIds = array();

		foreach ($variant['labels'] as $label)
		{

			$query = $db->getQuery(true);

			$query->select('*');
			$query->from($db->quoteName('#__commercelab_shop_product_variant_label'));
			$query->where($db->quoteName('id') . ' = ' . $db->quote($label['id']));

			$db->setQuery($query);

			$result = $db->loadObject();

			if ($result)
			{
				// update
				$updateLabel             = new stdClass();
				$updateLabel->id         = $label['id'];
				$updateLabel->variant_id = $variant['id'];
				$updateLabel->product_id = $variant['product_id'];
				$updateLabel->name       = $label['name'];
				$db->updateObject('#__commercelab_shop_product_variant_label', $updateLabel, 'id');

			}
			else
			{
				// insert
				$object             = new stdClass();
				$object->id         = 0;
				$object->variant_id = $variant['id'];
				$object->product_id = $variant['product_id'];
				$object->name       = $label['name'];

				$db->insertObject('#__commercelab_shop_product_variant_label', $object);

				// get the new label id
				$label['id'] = $db->insertid();

			}

			$labelIds[] = $label['id'];

		}

		// remove deleted labels
		self::removeDeletedVariantLabels($variant, $labelIds);


	}

	/**
	 * @param   array  $input
	 *
	 * @return array|array[]
	 *
	 * @since 2.0
	 */


	private static function cartesian(array $input): array
	{
		$result = array(array());

		foreach ($input as $key => $values)
		{
			$append = array();

			foreach ($result as $product)
			{
				foreach ($values as $item)
				{
					$product[$key] = $item;
					$append[]      = $product;
				}
			}

			$result = $append;
		}

		return $result;

	}


	/**
	 * @param   int  $j_item_id
	 *
	 * @return Variant
	 *
	 * @since 2.0
	 */

	public static function getProductIdsFromVariantData(string $variant_type, array $variant_labels): array
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('DISTINCT vd.product_id')
			->from($db->quoteName('#__commercelab_shop_product_variant_data', 'vd'))
			->join('INNER', $db->quoteName('#__commercelab_shop_product_variant_label', 'vl') . ' ON ' . $db->quoteName('vl.id') . ' IN (' . $db->quoteName('vd.label_ids') . ')')
			->join('INNER', $db->quoteName('#__commercelab_shop_product_variant', 'v') . ' ON ' . $db->quoteName('v.id') . ' = ' . $db->quoteName('vl.variant_id'))
			->where($db->quoteName('v.name') . ' = ' . $db->quote($variant_type) . ' AND ' . $db->quoteName('vl.name') . " IN ('" . implode("','", $variant_labels) . "')");

		$db->setQuery($query);

		return $db->loadColumn();
	}

	/**
	 * @param   int  $j_item_id
	 *
	 * @return Variant
	 *
	 * @since 2.0
	 */

	public static function getVariantData(int $j_item_id): Variant
	{

		// init

		/** @var Variant $variantObject */
		$variantObject = new stdClass;


		// get the list of variants for this product
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($j_item_id));
		$query->order('ordering');
		$db->setQuery($query);

		$variants = $db->loadObjectList();

		$variantObject->variants = $variants;


		// now get the array of product prices(etc) for each combination of variant labels.

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_data'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($j_item_id));
		$query->order('ordering');
		$db->setQuery($query);

		$list = $db->loadObjectList();

		$variantObject->variantList = $list;

		return new Variant($variantObject);


	}


	/**
	 *
	 * Takes the raw db data for a variant and processes the data to make it useful for the UI:
	 *
	 * * Processes "1" and "0" to true and false
	 * * Gets the namedLabel... i.e. "Small / Red" etc.
	 * * sorts out Brick numbers
	 *
	 * @param   array  $variantList
	 *
	 * @return array
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 *
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
					$query->from($db->quoteName('#__commercelab_shop_product_variant_label'));
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

				// We don't have a Product here, but let's keep the code by hand
				// $variant->priceIntWithoutTax = TaxFactory::getNetPrice($variant->price, $product->taxclass);
				// $variant->priceIntWithTax    = TaxFactory::getBrutPrice($variant->price, $product->taxclass);

				// $variant->priceWithTax    = CurrencyFactory::toFloat($variant->priceIntWithTax);
				// $variant->priceWithoutTax = CurrencyFactory::toFloat($variant->priceIntWithoutTax);
			}

			// booleans
			$variant->default = $variant->default == 1;
			$variant->active  = $variant->active == 1;

		}

		return $variantList;


	}

	/**
	 * @param   int  $j_item_id
	 *
	 * @return array|mixed
	 *
	 * @since 2.0
	 */

	public static function getLabels(int $j_item_id)
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_label'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($j_item_id));

		$db->setQuery($query);

		return $db->loadObjectList();

	}

	/**
	 *
	 * this function adds the labels array to the variants
	 *
	 * @param   array  $variants
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public static function attachVariantLabels(array $variants): array
	{

		// get the item id from the first variant
		$j_item_id = $variants[0]->product_id;

		$labels = self::getLabels($j_item_id);

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
	 *
	 * This function takes in the product id and the users selected variants and processes this data in order to return:
	 *
	 * 1. the price, stock and sku for the selection
	 * 2. the active variants list, to allow the UI to update with new dropdowns if there is no stock or if the options is inactive.
	 *
	 * @param   int    $joomla_item_id
	 * @param   array  $selected
	 *
	 * @return array
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function getSelectedVariant(int $joomla_item_id, array $selected): array
	{

		// init

		$response = array();


		// get the variant data for this product
		$productVariants = self::getVariantData($joomla_item_id);

		// get the actual variants list to allow us to grab the price, stock and sku - set it as a workable array using json_decode
		$productVariantsList = json_decode($productVariants->variantList);


		// iterate over the variants list and grab the price, stock and sku
		/** @var VariantListItem $productVariant */
		foreach ($productVariantsList as $productVariant)
		{
			if ($productVariant->identifier == $selected)
			{
				$response['identifier'] = $productVariant->identifier;
				$response['name']       = $productVariant->name;
				$response['priceInt']   = $productVariant->priceInt;
				$response['price']      = CurrencyFactory::translate(18500);
				$response['stock']      = $productVariant->stock;
				$response['sku']        = $productVariant->sku;
				$response['active']     = $productVariant->active;
			}


		}


		return $response;

	}


	/**
	 * @param   int    $joomla_item_id
	 * @param   array  $selected
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function checkVariantAvailability(int $joomla_item_id, array $selected): ?array
	{

		// init
		$response           = array();
		$response['active'] = true;

		$selected = implode(',', $selected);

		// get the product
		$product = self::get($joomla_item_id);

		// get the chosen variant selection
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_variant_data'));
		$query->where($db->quoteName('label_ids') . ' = ' . $db->quote($selected));

		$db->setQuery($query);

		// get the object
		$result = $db->loadObject();
		if ($result && is_object($result))
		{

			$selectedVariant = new SelectedVariant($result);
		}
		else
		{
			return null;
		}


		// check the stock
		if ($product->manage_stock == "1")
		{
			if ($selectedVariant->stock == 0)
			{
				$response['active'] = false;
				$response['reason'] = "oos";

			}
		}

		// check the active state
		if ($selectedVariant->active == "0")
		{
			$response['active'] = false;
			$response['reason'] = "not_active";
		}

		return $response;

	}

	/**
	 * @param   array  $variantList
	 *
	 *
	 * @return array
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
		foreach ($items as $item)
		{
			$item = (object) $item;

			$query      = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($item->id)
			);
			$query->delete($db->quoteName('#__commercelab_shop_product'));
			$query->where($conditions);
			$db->setQuery($query);
			$db->execute();

		}


		foreach ($items as $item)
		{

			$item = (object) $item;

			$query      = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($item->joomla_item_id)
			);
			$query->delete($db->quoteName('#__content'));
			$query->where($conditions);
			$db->setQuery($query);
			$db->execute();

		}

		return true;

	}


	/**
	 * @param $id
	 *
	 * @return File|null
	 *
	 * @since 2.0
	 */


	public static function getFile($id): ?File
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_file'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();
		if ($result && is_object($result))
		{


			return new File($result);
		}

		return null;

	}


	/**
	 * @param   int  $product_id
	 *
	 * @return array|null
	 *
	 * @since 2.0
	 */

	public static function getFiles(int $product_id): ?array
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_product_file'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id));

		$db->setQuery($query);

		$results = $db->loadObjectList();

		$files = array();

		if ($results)
		{
			foreach ($results as $result)
			{
				$files[] = new File($result);

			}

			return $files;
		}


		return null;

	}

	/**
	 * @param   int  $type
	 *
	 * @return string|void
	 *
	 * @since 2.0
	 */

	public static function getFileStabilityLevelString(int $type)
	{

		switch ($type)
		{
			case 1;
				return Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_ALPHA');

			case 2;
				return Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_BETA');

			case 3;
				return Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_RELEASE_CANDIDATE');

			case 4;
				return Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_RELEASE_STABLE');

		}

	}

	/**
	 * @param   Input  $data
	 *
	 * @return File
	 *
	 * @since 2.0
	 */


	public static function saveFileFromInputData(Input $data): ?File
	{

		$db = Factory::getDbo();

		// if there's no item id, then we need to create a new product
		if ($data->json->getInt('fileid'))
		{
			$current = self::getFile($data->json->getInt('fileid'));

			if ($current)
			{

				$update = new stdClass();

				$update->id                = $current->id;
				$update->download_access   = $data->json->getInt('download_access', $current->download_access);
				$update->product_id        = $data->json->getInt('product_id', $current->product_id);
				$update->filename          = $data->json->getString('filename', $current->filename);
				$update->filename_obscured = $data->json->getString('filename_obscured', $current->filename_obscured);
				$update->isjoomla          = $data->json->getInt('isjoomla', $current->isjoomla);
				$update->version           = $data->json->getString('version', $current->version);
				$update->type              = $data->json->getString('type', $current->type);
				$update->stability_level   = $data->json->getInt('stability_level', $current->stability_level);
				$update->php_min           = $data->json->getFloat('php_min', $current->php_min);
				$update->download_access   = $data->json->getInt('download_access', $current->download_access);
				$update->published         = $data->json->getInt('published', $current->published);

				$db->updateObject('#__commercelab_shop_product_file', $update, 'id');

				return self::getFile($current->id);
			}
			else
			{
				return self::createNewFile($data);
			}

		}

		return self::createNewFile($data);
	}

	/**
	 * @param   Input  $data
	 *
	 * @return ?File
	 *
	 * @since 2.0
	 */


	public static function createNewFile(Input $data): ?File
	{
		$db = Factory::getDbo();

		$file = new stdClass();

		$file->id                = 0;
		$file->product_id        = $data->json->get('product_id');
		$file->filename          = $data->json->getString('filename');
		$file->filename_obscured = $data->json->getString('filename_obscured');
		$file->isjoomla          = $data->json->getInt('isjoomla');
		$file->version           = $data->json->getString('version');
		$file->type              = $data->json->getString('type');
		$file->stability_level   = $data->json->getInt('stability_level');
		$file->php_min           = $data->json->getFloat('php_min');
		$file->download_access   = $data->json->getInt('download_access', 1);
		$file->downloads         = 0;
		$file->published         = $data->json->getInt('published');
		$file->created           = Utilities::prepareDateToSave();


		$result = $db->insertObject('#__commercelab_shop_product_file', $file);

		if ($result)
		{
			return self::getFile($db->insertid());
		}

		return null;

	}

	/**
	 * @param   Input  $data
	 *
	 * @return array|false
	 *
	 * @since 2.0
	 */


	public static function uploadFileFromInputData(Input $data)
	{

		// first, create the MD5's for folder creation

		$md5_1 = md5(uniqid());
		$md5_2 = md5(uniqid());
		$md5_3 = md5(uniqid());
		$md5_4 = md5(uniqid());

		// build the path
		$path = $md5_1 . '/' . $md5_2 . '/' . $md5_3 . '/' . $md5_4;

		// get the file from the POST data
		$file = $data->files->get('files');
		$file = $file[0];

		// is this needed these days?
		jimport('joomla.filesystem.file');

		// sluggify the filename
		$filename = JoomlaFile::makeSafe($file['name']);
		$src      = $file['tmp_name'];

		// create the destination
		$dest = JPATH_SITE . '/images/pro2store_files/' . $path . '/' . $filename;

		//Upload the file
		if (JoomlaFile::upload($src, $dest))
		{

			$response['uploaded']     = true;
			$response['path']         = $path;
			$response['relativepath'] = $path . '/' . $filename;
			$response['filename']     = $filename;
			$response['dest']         = $dest;


			return $response;
		}
		else
		{
			return false;
		}


	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function saveStockFromInputData(Input $data): bool
	{

		$db = Factory::getDbo();

		$itemId = $data->json->getInt('itemid');
		$stock  = $data->json->getInt('stock');


		$object                 = new stdClass();
		$object->joomla_item_id = $itemId;
		$object->stock          = $stock;

		$result = $db->updateObject('#__commercelab_shop_product', $object, 'joomla_item_id');

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
	 * @throws Exception
	 * @since 2.0
	 */

	public static function savePriceFromInputData(Input $data): bool
	{

		$db = Factory::getDbo();

		$itemId     = $data->json->getInt('itemid');
		$priceFloat = $data->json->getFloat('base_priceFloat');


		if ($priceFloat)
		{
			$base_price = CurrencyFactory::toInt($priceFloat);
		}
		else
		{
			$base_price = 0;
		}

		$object                 = new stdClass();
		$object->joomla_item_id = $itemId;
		$object->base_price     = $base_price;

		$result = $db->updateObject('#__commercelab_shop_product', $object, 'joomla_item_id');

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
	 * @since 2.0
	 */

	public static function export(Input $data)
	{

		$response = false;

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		$date = new Date('now');

		$filename = "export." . $date->toISO8601() . ".csv";

		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');

		// clean output buffer
		ob_end_clean();

		$handle = fopen('php://output', 'w');

		// use keys as column titles
		fputcsv($handle, array_keys($array['0']), ',');

		foreach ($array as $value)
		{
			fputcsv($handle, $value, ',');
		}

		fclose($handle);

		// flush buffer
		ob_flush();

		// use exit to get rid of unexpected output afterward
		exit();

	}

	/**
	 * @param   string  $teaserImage
	 * @param   string  $fullImage
	 *
	 *
	 * @return false|string
	 * @since 2.0
	 */

	private static function processImagesForSave($teaserImage, $fullImage)
	{

		$images = array();

		$images['image_intro']    = $teaserImage;
		$images['image_fulltext'] = $fullImage;

		return json_encode($images);

	}


	/**
	 * @param $product
	 *
	 * @return string
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	private static function processVariantPrices($product): string
	{

		$variantList = json_decode($product->variantList);

		foreach ($variantList as $variant)
		{

			if ($variant->price)
			{
				$variant->price = CurrencyFactory::toInt($variant->price);
			}
			else
			{
				$variant->price = $product->base_price;
			}

		}

		return json_encode($variantList);

	}
	public static function removeGalleryImg($data)
	{
		$image_id = $data->json->getString('img_id');

		$item_id = $data->json->get('item_id', '', 'INT');

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		// delete all custom keys for user 1001.
		$conditions = array(
			$db->quoteName('id') . ' = '.$image_id,
			$db->quoteName('product_j_id') . ' = ' . $db->quote($item_id)
		);

		$query->delete($db->quoteName('#__commercelab_shop_gallery'));
		$query->where($conditions);



		$db->setQuery($query);

		$result = $db->execute();

		return $item_id;
	}

	public static function refreshGalleryImg($data)
	{
		$item_id = $data->json->get('item_id', '', 'INT');

		$db = Factory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select(array('id','path'));
        $query->from($db->quoteName('#__commercelab_shop_gallery'));
        $query->where($db->quoteName('product_j_id') . ' = ' . $db->quote($item_id));
        $query->order('ordering ASC');

        $db->setQuery($query);

        return $db->loadObjectList();

	}

	public static function orderGalleryImgs($data)
	{
		$id = $data->json->get('id', '', 'INT');
		$order_no = $data->json->get('order_no');
		
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		// Fields to update.
		$fields = array(
			$db->quoteName('ordering') . ' = ' . $db->quote($order_no),
		);

		// Conditions for which records should be updated.
		$conditions = array(
			$db->quoteName('id') . ' = ' . $id
		);

		$query->update($db->quoteName('#__commercelab_shop_gallery'))->set($fields)->where($conditions);

		$db->setQuery($query);

		$result = $db->execute();

	}


	public static function varaintchild($data)
	{
		$variant = $data->json->get('variant', 0, 'string');
		dd($variant);
		$db = Factory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select('id');
        $query->from($db->quoteName('#__commercelab_shop_product_variant'));
        $query->where($db->quoteName('name') . ' = ' . $db->quote($variant));

        $db->setQuery($query);
		$variantProductIds = $db-> loadObjectList();
		$variantProductId = '';
		
		for ($i=0; $i < sizeof($variantProductIds) ; $i++) 
		{ 
			$variantProductId .= $variantProductIds[$i]->id;
			if($i < (sizeof($variantProductIds)-1))
			{
				$variantProductId .= ', ';	
			}
		}

	
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select('name');
        $query->from($db->quoteName('#__commercelab_shop_product_variant_label'));
        $query->where($db->quoteName('variant_id') . ' IN (' . $variantProductId.')');
		$query->group('name');

       $db->setQuery($query);
	   $variantOption = $db-> loadObjectList();
	// 	echo '<pre>';
	//    print_r($db-> loadObjectList());
	//    die;
	   return $variantOption;

	}

	public static function getVariantLabelsByType(array $types = null, array $product_ids = null)
	{
		$grouped_variants = [];

		$variants = self::getVariantTypes($types, $product_ids);

		$variant_ids = [];
		// foreach ($variants as $variant)
		// {
		// 	if (!isset($grouped_variants[$variant->name]))
		// 	{
		// 		$grouped_variants[$variant->name] = [];
		// 	}
		// 	foreach (ProductFactory::getVariantLabels([$variant->id], $product_ids) as $label)
		// 	{
		// 		if (!isset($grouped_variants[$variant->name][$label->name]))
		// 		{
		// 			$grouped_variants[$variant->name][$label->name] = [];
		// 		}

		// 		if (!in_array($label->id, $grouped_variants[$variant->name][$label->name]))
		// 		{
		// 			$grouped_variants[$variant->name][$label->name][] = $label->id;
		// 		}
		// 	}
		// 	// asort($grouped_variants[$variant->name]);
		// }
		foreach ($variants as $variant)
		{
			// if (!isset($grouped_variants[$variant->name]))
			// {
			// 	$grouped_variants[$variant->name] = [];
			// }

			// dd(ProductFactory::getVariantLabels([$variant->id], $product_ids));

			foreach (ProductFactory::getVariantLabels([$variant->id], $product_ids) as $label)
			{
				if (!isset($grouped_variants[$label->name]))
				{
					$grouped_variants[$label->name] = [];
				}

				if (!in_array($label->id, $grouped_variants[$label->name]))
				{
					$grouped_variants[$label->name]['id']       = $label->id;
					$grouped_variants[$label->name]['title']    = $label->name;
					$grouped_variants[$label->name]['items'][]  = $label->product_id;
					$grouped_variants[$label->name]['numitems'] = count($grouped_variants[$label->name]['items']);
				}
			}
			// asort($grouped_variants[$variant->name]);
		}


		$cleaned_array = [];
		foreach ($grouped_variants as $value) {
			$value['items']  = array_unique($value['items']);
			$cleaned_array[] = $value;
		}

		return $cleaned_array;
	}

	public static function getVariantTypes(array $types = null, array $product_ids = null)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__commercelab_shop_product_variant'));

		if ($types)
		{
			$query->where($db->quoteName('name') . " IN ('" . implode("','", $types) . "')");
		}

		if ($product_ids)
		{
			$query->where($db->quoteName('product_id') . ' IN (' . implode(',', $product_ids) . ')');
		}

		// $query->group('name');
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getVariantLabels(array $variant_ids = null, array $product_ids = null)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select(['*'])
			->from($db->quoteName('#__commercelab_shop_product_variant_label'));

		if ($variant_ids)
		{
			$query->where($db->quoteName('variant_id') . " IN ('" . implode("','", $variant_ids) . "')");
		}

		if ($product_ids)
		{
			$query->where($db->quoteName('product_id') . ' IN (' . implode(',', $product_ids) . ')');
		}
		// $query->group('id');

       	$db->setQuery($query);
	   	return $db-> loadObjectList();

	}
	
	//Variant option ordering
	public static function variantTypeOrdering(Input $data){
        $items = $data->json->get('items', '', 'ARRAY');
		if(!empty($items)){
            $db = Factory::getDbo();
            foreach ($items as $item){
                $object                 =   new stdClass();
                $object->id             =   $item['id'];
                $object->ordering       =   $item['ordering'];
                $result = $db->updateObject('#__commercelab_shop_product_variant', $object,'id');
            }
		}	
	}
	//Variant option data ordering
	public static function variantcombinationordering(Input $data){
        $items = $data->json->get('items', '', 'ARRAY');
		if(!empty($items)){
            $db = Factory::getDbo();
            foreach ($items as $item){
                $object                 =   new stdClass();
                $object->id             =   $item['id'];
                $object->ordering       =   $item['ordering'];
                $result = $db->updateObject('#__commercelab_shop_product_variant_data', $object,'id');
            }
		}	
	}
}
