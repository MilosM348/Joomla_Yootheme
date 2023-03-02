<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Tag;

// no direct access
defined('_JEXEC') or die('Restricted access');

use Exception;
use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

use CommerceLabShop\Utilities\Utilities;
use stdClass;

class TagFactory
{


	public static function getTags(int $joomla_item_id): ?array
	{


		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('b.title');
		$query->from($db->quoteName('#__contentitem_tag_map', 'a'));
		$query->where($db->quoteName('content_item_id') . ' = ' . $db->quote($joomla_item_id));
		$query->join('INNER', $db->quoteName('#__tags', 'b') . ' ON ' . $db->quoteName('a.tag_id') . ' = ' . $db->quoteName('b.id'));

		$db->setQuery($query);

		$results = $db->loadObjectList();


		return ArrayHelper::getColumn($results, 'title');

	}


	/**
	 *
	 * Gets the available tags.
	 * If the ID of the item is supplied, then the function removes the currently selected tags and returns the remaining, unselected tags.
	 *
	 * @param   null  $id
	 *
	 * @return array|null
	 *
	 * @since 2.0
	 */

	public static function getAvailableTags($id = null): ?array
	{

		$tags = array();

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('title');
		$query->from($db->quoteName('#__tags'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->where($db->quoteName('title') . ' != ' . $db->quote('ROOT'));

		$db->setQuery($query);

		$results = $db->loadObjectList();
		if ($results)
		{
			foreach ($results as $result)
			{

				$tags[] = new Tag($result);


			}

			$allTags = ArrayHelper::getColumn($tags, 'title');

			if ($id)
			{
				$diffs = array_diff($allTags, self::getTags($id));

				$newArray = array();

				foreach ($diffs as $key => $diff)
				{

					$newArray[] = $allTags[$key];
				}

				return $newArray;

			}
			else
			{
				return $allTags;
			}


		}


		return null;


	}

	/**
	 * @param   int    $joomla_item_id
	 * @param   array  $tagNames
	 *
	 * @since 2.0
	 */

	public static function saveTags(int $joomla_item_id, array $tagNames): void
	{

		$db = Factory::getDbo();

		//first, clear the current tags
		self::clearTags($joomla_item_id);

		foreach ($tagNames as $tagName)
		{

			$tag = self::getTagByName($tagName);

			if (!$tag)
			{
				$tag = self::create($tagName);
			}


			$object                  = new stdClass();
			$object->type_alias      = 'com_content.article';
			$object->core_content_id = 1;
			$object->content_item_id = $joomla_item_id;
			$object->tag_id          = $tag->id;
			$object->tag_date        = Utilities::getDate();
			$object->type_id         = 1;

			$db->insertObject('#__contentitem_tag_map', $object);

		}

	}

	/**
	 * @param   string  $name
	 *
	 * @return Tag|null
	 *
	 * @since 2.0
	 */

	public static function getTagByName(string $name): ?Tag
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__tags'));
		$query->where($db->quoteName('title') . ' = ' . $db->quote($name));

		$db->setQuery($query);

		$data = $db->loadObject();

		if ($data)
		{
			return new Tag($data);
		}

		return null;

	}

	/**
	 * @param   int  $id
	 *
	 * @return Tag|null
	 *
	 * @since 2.0
	 */

	public static function getTagById(int $id): ?Tag
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__tags'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$data = $db->loadObject();

		if ($data)
		{
			return new Tag($data);
		}

		return null;

	}


	/**
	 * @param   string  $tagName
	 *
	 * @return Tag|null
	 *
	 * @since 2.0
	 */

	public static function create(string $tagName): ?Tag
	{

		$db = Factory::getDbo();

		$object                   = new stdClass();
		$object->id               = 0;
		$object->parent_id        = 1;
		$object->level            = 1;
		$object->path             = $tagName;
		$object->title            = $tagName;
		$object->alias            = $tagName;
		$object->published        = 1;
		$object->note             = "";
		$object->description      = "";
		$object->metadesc         = "";
		$object->metakey          = "";
		$object->metadata         = "{}";
		$object->created_time     = Utilities::getDate();
		$object->modified_time    = Utilities::getDate();
		$object->access           = 1;
		$object->params           = "{}";
		$object->images           = "{}";
		$object->urls             = "{}";
		$object->hits             = 0;
		$object->language         = "*";
		$object->version          = 1;
		$object->created_user_id  = Factory::getUser()->id;
		$object->modified_user_id = Factory::getUser()->id;

		$db->insertObject('#__tags', $object);

		return self::getTagById($db->insertid());

	}

	/**
	 * @param   int  $joomla_item_id
	 *
	 *
	 * @since 2.0
	 */


	public static function clearTags(int $joomla_item_id)
	{

		$db = Factory::getDbo();

		$query      = $db->getQuery(true);
		$conditions = array(
			$db->quoteName('content_item_id') . ' = ' . $db->quote($joomla_item_id)
		);
		$query->delete($db->quoteName('#__contentitem_tag_map'));
		$query->where($conditions);
		$db->setQuery($query);
		$db->execute();

	}

}
