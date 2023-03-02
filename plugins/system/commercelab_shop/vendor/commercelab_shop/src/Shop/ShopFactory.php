<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Shop;

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\Categories\Categories;
use Joomla\Input\Input;

use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Product\ProductFactory;
use DateTime;

use stdClass;

use StathisG\GreekSlugGenerator\GreekSlugGenerator;

class ShopFactory
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

	public static function get($joomla_item_id): ?Shop
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_shops'));
		$query->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($joomla_item_id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return new Shop($result);
		}

		return null;

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

	// /**
	//  * @param   int          $limit
	//  * @param   int          $offset
	//  * @param   bool         $publishedOnly
	//  * @param   string|null  $searchTerm
	//  * @param   string       $orderBy
	//  * @param   string       $orderDir
	//  *
	//  *
	//  * @return array
	//  * @since 2.0
	//  */

	public static function getList(int $limit = 0, int $offset = 0, bool $publishedOnly = false, string $searchTerm = null, string $orderBy = 'published', string $orderDir = 'DESC', int $item_id = null): ?array
	{

		// init items
		$items = array();

		// get the Database
		$db = Factory::getDbo();

		// set initial query
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_shops'));

		// only get published items based on $publishedOnly boolean
		if ($publishedOnly)
		{
			$query->where($db->quoteName('published') . ' = 1');
		}
		if ($item_id)
		{
			$query->where($db->quoteName('products') . ' LIKE ' . $db->quote('%' . $item_id . '%'));
		}


		// if there is a search term, iterate over the columns looking for a match
		// if ($searchTerm)
		// {
		// 	$query->where($db->quoteName('country_name') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		// }

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		// only proceed if there's any rows
		if ($results)
		{
			// iterate over the array of objects, initiating the Class.
			foreach ($results as $result)
			{
				$items[] = new Shop($result);

			}

			return $items;
		}

		return [];

	}

	public static function getFullList(int $limit = 0, int $offset = 0, bool $publishedOnly = false, string $searchTerm = null, string $orderBy = 'published', string $orderDir = 'DESC', int $item_id = null): array 
	{
		$results = self::getList($limit, $offset, $publishedOnly, $searchTerm, $orderBy, $orderDir, $item_id);
		foreach($results as $key => $result) {
			$products = [];
			$productIds = $result->products;
			foreach($productIds as $productId) {
				$product = ProductFactory::get($productId);
				array_push($products, $product);
			}
			$result->products = $products;
		}
		return $results;
	}

	public static function savePrepTime(Input $data): int
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		// delete all custom keys for user 1001.
		$conditions = array(
		    $db->quoteName('product_id') . ' = ' . $db->quote($data->json->getInt('product_id', ''))
		);

		$query->delete($db->quoteName('#__commercelab_shop_product_preparation_time'));
		$query->where($conditions);

		$db->setQuery($query);

		$db->execute();


		$db = Factory::getDbo();

		$new                   = new stdClass();
		$new->product_id       = $data->json->getInt('product_id');
		$new->preparation_time = $data->json->getInt('time');

		return  $db->insertObject('#__commercelab_shop_product_preparation_time', $new);
	}

	public static function getPrepTime($product_id): int
	{
		// dd($product_id);
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('preparation_time');
		$query->from($db->quoteName('#__commercelab_shop_product_preparation_time'));
		$query->where($db->quoteName('product_id') . ' = ' . $db->quote($product_id));

		$db->setQuery($query);

		$result = $db->loadResult();
		// dd($result);

		if ($result)
		{
			return $result;
		}

		return 0;

	}

	/**
	 * @param   Product  $product
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	private static function commitToDatabase(Shop $shop): bool
	{
		$db = Factory::getDbo();
		$insertShop = new stdClass();
		$insertShop->id               = $shop->id;
		$insertShop->joomla_item_id   = $shop->joomla_item_id;
		$insertShop->enablepickup     = $shop->enablepickup;
		$insertShop->enableordertime  = $shop->enableordertime;
		$insertShop->pickuptimes      = $shop->pickuptimes;
		$insertShop->ordertimes       = $shop->ordertimes;
		$insertShop->workinghours     = $shop->workinghours;
		$insertShop->products         = $shop->products;
		$insertShop->address          = $shop->address;
		$insertShop->city             = $shop->city;
		$insertShop->postalcode       = $shop->postalcode;
		$insertShop->country          = $shop->country;
		$insertShop->zone             = $shop->zone;
		$insertShop->published        = $shop->published;

		$result = $db->updateObject('#__commercelab_shop_shops', $insertShop, 'joomla_item_id');
		if ($result)
		{
			// now do the Joomla Item
			$db->updateObject('#__content', $shop->joomlaItem, 'id');
			return true;
		}
		return false;
	}

	public static function saveFromInputData(Input $data): Shop
	{
		$id = $data->json->getInt('itemid', null);
		if (!$id)
		{
			$item = self::createFromInputData($data);
			if (!is_null($item))
			{
				return $item;
			}
		}
		// store location exists so we can run an update
		// get current store location object
		$current = self::get($id);
		// set up Joomla Item:
		$current->joomlaItem->title       = $data->json->getString('title', $current->joomlaItem->title);
		$current->joomlaItem->access      = $data->json->getInt('access', $current->joomlaItem->access);
		$current->joomlaItem->modified_by = Factory::getUser()->id;
		$current->joomlaItem->modified    = Utilities::prepareDateToSave();
		$current->joomlaItem->images      = self::processImagesForSave(
			$data->json->getString('image', $current->imagePath),
		);
		$current->joomlaItem->featured    = $data->json->getInt('featured', $current->joomlaItem->featured);
		$current->joomlaItem->state       = $data->json->getInt('published', $current->joomlaItem->state);
		$current->joomlaItem->publish_up  = Utilities::prepareDateToSave($data->json->getString('publish_up_date', $current->joomlaItem->publish_up));
		$current->joomlaItem->catid       = $data->json->getInt('category', $current->joomlaItem->catid);
		$current->joomlaItem->language    = $data->json->getString('language', $current->joomlaItem->language);

		$current->enablepickup    = $data->json->getInt('enablepickup', $current->enablepickup);
		$current->enableordertime = $data->json->getInt('enableordertime', $current->enableordertime);
		$current->pickuptimes     = json_encode($data->json->getString('pickuptimes', $current->pickuptimes));
		$current->ordertimes      = json_encode($data->json->getString('ordertimes', $current->ordertimes));
		$current->workinghours    = json_encode($data->json->getString('workinghours', $current->workinghours));
		$current->products        = json_encode($data->json->getString('products', $current->products));
		$current->address         = $data->json->getString('address', $current->address);
		$current->city            = $data->json->getString('city', $current->city);
		$current->postalcode      = $data->json->getString('postalcode', $current->postalcode);
		$current->country         = $data->json->getInt('country', $current->country);
		$current->zone            = $data->json->getInt('zone', $current->zone);
		$current->published       = $data->json->getInt('published', $current->published);
		if (self::commitToDatabase($current))
		{
			return self::get($id);
		}
		return null;
	}

	public static function removeProduct(Input $data)
	{
		$db = Factory::getDbo();

		$shop_id    = $data->json->getInt('shop_id', null);
		$product_id = $data->json->getInt('product_id', null);

		$_shop = self::get($shop_id);
		$products = $_shop->products;
		if (($key = array_search($product_id, $products)) !== false) {
		    unset($products[$key]);
		}

		$shop           = new stdClass();
		$shop->products = json_encode($products);
		$shop->id       = $shop_id;
		return $db->updateObject('#__commercelab_shop_shops', $shop, 'id');
	}

	public static function addproduct(Input $data): bool
	{
		$db = Factory::getDbo();

		$shop_id    = $data->json->getInt('shop_id', null);
		$product_id = $data->json->getInt('product_id', null);

		$_shop = self::get($shop_id);

		$products       = $_shop->products;
		$products[]     = $product_id;

		$shop           = new stdClass();
		$shop->products = json_encode($products);
		$shop->id       = $shop_id;
		return $db->updateObject('#__commercelab_shop_shops', $shop, 'id');
	}

	/**
	 * @param   string  $image
	 *
	 *
	 * @return false|string
	 * @since 2.0
	 */

	private static function processImagesForSave($image)
	{

		$images = array();

		$images['image_intro']    = $image;

		return json_encode($images);

	}

	/**
	 * @param   Input  $data
	 *
	 * @return Country
	 *
	 * @since 2.0
	 */


	private static function createFromInputData(Input $data): Shop
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
		$content->state       = $data->json->getInt('published');
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
			$data->json->getString('image')
		);
		if (!$db->insertObject('#__content', $content))
		{
			return null;
		}

		// create the item in CommerceLab Shop Products table
		$shop                  = new stdClass();
		$shop->joomla_item_id  = $db->insertid();
		//		FIX j4 WORKFLOWS
		if(JVERSION >= "4.0.0"){
			$object            = new stdClass();
			$object->item_id   = $shop->joomla_item_id;
			$object->stage_id  = 1;
			$object->extension = 'com_content.article';

			$db->insertObject('#__workflow_associations', $object);
		}
		$shop->enablepickup    = $data->json->getInt('enablepickup');
		$shop->enableordertime = $data->json->getInt('enableordertime');
		$shop->pickuptimes     = json_encode($data->json->getString('pickuptimes'));
		$shop->ordertimes      = json_encode($data->json->getString('ordertimes'));
		$shop->workinghours    = json_encode($data->json->getString('workinghours'));
		$shop->products        = json_encode($data->json->getString('products'));
		$shop->address         = $data->json->getString('address');
		$shop->city            = $data->json->getString('city');
		$shop->postalcode      = $data->json->getString('postalcode');
		$shop->country         = $data->json->getInt('country');
		$shop->zone            = $data->json->getInt('zone');
		$shop->published       = $data->json->getInt('published');

		$result = $db->insertObject('#__commercelab_shop_shops', $shop);

		if ($result)
		{
			return self::get($shop->joomla_item_id);
		}
		return null;
	}

	public static function getShopsFromProductId($item_id, $prepare_for_cart = null): array
	{
		$result = self::getList(0, 0, false, null, 'published', 'DESC', $item_id);
		if ($result)
		{
			// dump($result);
			if ($prepare_for_cart)
			{
				$week_day         = (int) date('w', strtotime(Utilities::getDate())) - 1;
				$day_hour         = (int) date('Hi', strtotime(Utilities::getDate()));
				$preparation_time = self::getPrepTime($item_id);
				if ($preparation_time)
				{
					$preparation_time = $preparation_time * 100;
				}

				foreach ($result as $key => &$shop)
				{
					if ($shop->enableordertime) 
						$order_start = self::getNextAvailableTimeframe($shop->ordertimes);
					// same as working hours
					else 
						$order_start = self::getNextAvailableTimeframe($shop->workinghours);
					$work_start        = self::getNextAvailableTimeframe($shop->workinghours, null, $preparation_time, $order_start[0]['start_date']);
					// $shop->pickuptimes = self::getNextAvailablePickupTimes($shop->pickuptimes, $work_start[0]['start_date']);
				}
			}

			return $result;
		}

		return [];
	}

	public static function resetWeekday(array $timeframes, $week_day)
	{
		return array_merge(array_slice($timeframes, $week_day), array_slice($timeframes, 0, $week_day));
	}

	public static function getNextAvailableTimeframe(array $week, $next_available = null, $hours_lapse = 0, $order_start = null)
	{

		$start_date = ($order_start) ? $order_start : Factory::getDate(date('Y-m-d H:i:s', strtotime(Utilities::getDate())));
		// dump($start_date);
		$week_day = (int) date('w', strtotime($start_date));
		$day_hour = (int) date('Hi', strtotime($start_date));

		// dump($week_day, $week);

		$timeframes     = self::resetWeekday($week, $week_day);
		$next_timeframe = self::getAvailableTimeframe(reset($timeframes), $day_hour, $hours_lapse);

		// dump($next_timeframe, $timeframes);

		$plus_days = 0;
		if (!reset($timeframes)['workingday'] || $next_timeframe == false)
		{
			do {

				$plus_days++;

				if ($week_day < 6) $week_day++;
				else $week_day = 0;

				$timeframes = self::resetWeekday($week, $week_day);
				// dump($week_day, $timeframes);

			} while (!reset($timeframes)['workingday']);
		}

		if ($plus_days > 0)
		{
			$next_timeframe = self::_getIntHours(reset($timeframes)['workinghours']['start1']);
			$start_date     = $start_date->modify('+' . $plus_days . ' day');
		}

		if (strlen((string)$next_timeframe) < 4)
		{
			$next_timeframe = '0' . (string)$next_timeframe;	
		}

		$time = str_split($next_timeframe, 2);

		$timeframes[0]['start_date'] = $start_date->setTime($time[0], $time[1]);

		// dd($timeframes);
		return $timeframes;

	}

	public static function getAvailableTimeframe($week_day, $day_hour, &$hours_lapse = 0, $next_timeframe = null)
	{

		$start_hour = self::_getIntHours($week_day['workinghours']['start1']);
		$end_hour   = self::_getIntHours($week_day['workinghours']['end2']);

		// Check if actuak hour is before or after working time, and return respectevly
		if ($day_hour + $hours_lapse > $end_hour) return false;

		if (($day_hour + $hours_lapse) < $start_hour) // Order/Working day didn't started yet
		{
			if (($end_hour - $day_hour) > $hours_lapse) return $start_hour + $hours_lapse;
		}

		if ($week_day['straight'])
		{

			if ($hours_lapse > 0)
			{

				// if ($hours_lapse)
				// {
				// 	dd('milos', $hours_lapse);
				// }
				if (($end_hour - $day_hour) > $hours_lapse) // ready today
				{
					return (!$next_timeframe) ? $day_hour + $hours_lapse : false;
				}
				else // calculate remaining time lapse for next day
				{
					$hours_lapse = $end_hour - $day_hour;
				}
			}

			// if ($hours_lapse)
			// {
			// 	dump($day_hour);
			// 	dump($hours_lapse);
			// 	dump($next_timeframe);
			// 	dump($hours_lapse);
			// }

			return (!$next_timeframe && $hours_lapse == 0) ? $day_hour : false;
		}
		else // Working days that have 2 working lapses - closed at middle day
		{

			$end_hour1   = self::_getIntHours($week_day['workinghours']['end1']);
			$start_hour2 = self::_getIntHours($week_day['workinghours']['start2']);

			if ($hours_lapse > 0)
			{
				if (($end_hour1 - $day_hour) > $hours_lapse) // ready in first time lapse
				{
					$start_hour  = $day_hour + $hours_lapse;
					$hours_lapse = 0;
				}
				else if ((($end_hour1 - $day_hour) + ($end_hour - $start_hour2)) > $hours_lapse) // calculate if ready today
				{
					$start_hour  = (($end_hour1 - $day_hour) + ($end_hour - $start_hour2)) - $hours_lapse;
					$hours_lapse = 0;
				}
				else // calculate remaining time lapse for next day
				{
					$hours_lapse = $hours_lapse - ($end_hour - $day_hour);
				}
			}

			if ($day_hour < $end_hour1)
			{
				return (!$next_timeframe) ? $day_hour : $start_hour2;
			}

			if ($day_hour < $start_hour2)
			{
				return $start_hour2;
			}

			if ($day_hour > $start_hour2)
			{
				return (!$next_timeframe) ? $day_hour : false;
			}
			
		}

	}

	public static function _getIntHours($hours_string)
	{
		return (int)str_replace(":", '', $hours_string);
	}


	public static function getAvailableTimeslot($week_day, $day_hour)
	{
		if (!count($week_day['timeslots']))
		{
			return false;
		}

		$new_timeslots = [];
		foreach ($week_day['timeslots'] as $key => $slot) {
			$start_hour = self::_getIntHours($slot['start']);
			$end_hour   = self::_getIntHours($slot['end']);

			if ($day_hour <= $start_hour)
			{
				$new_timeslots[] = $slot;
			}
		}

		if (count($new_timeslots))
		{
			return $new_timeslots;
		}

		return false;
		// dd($week_day);
	}

	public static function getNextAvailablePickupTimes($week, $order_ready)
	{

		$week_day = (int) date('w', strtotime($order_ready)) - 1;
		$day_hour = (int) date('Hi', strtotime($order_ready));

		$timeframes     = self::resetWeekday($week, $week_day);
		$next_timeframe = self::getAvailableTimeslot(reset($timeframes), $day_hour);

		$plus_days = 0;
		if (!reset($timeframes)['workingday'] || !count(reset($timeframes)['timeslots']) || !$next_timeframe)
		{
			do {

				$plus_days++;

				if ($week_day < 6)
				{
					$week_day++;
				}
				else
				{
					$week_day = 0;
				}

				$timeframes = self::resetWeekday($week, $week_day);

			} while (!reset($timeframes)['workingday'] || !count(reset($timeframes)['timeslots']));
		}

		$next_timeframe = self::_getIntHours(reset(reset($timeframes)['timeslots'])['start']);
		if ($plus_days > 0)
		{
			$start_date     = $order_ready->modify('+' . $plus_days . ' day');
		}

		if (strlen((string)$next_timeframe) < 4)
		{
			$next_timeframe = '0' . (string)$next_timeframe;	
		}

		$time = str_split($next_timeframe, 2);

		$timeframes[0]['start_date'] = $order_ready->setTime($time[0], $time[1]);

		// foreach ($timeframes as $key => $timeframe) {
		// 	if (!$timeframe['workingday'] || !count($timeframe['timeslots']))
		// 	{
		// 		unset($timeframes[$key]);
		// 	}
		// }

		return $timeframes;
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

}
