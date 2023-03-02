<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Plugin;

defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;
use stdClass;


class PluginFactory
{

	/**
	 * @param   string  $pluginName
	 * @param   string  $updateKey
	 *
	 *
	 * @since 2.0
	 */

	public static function run(string $pluginName, string $updateKey = '')
	{


		$db = Factory::getDbo();


		// Get some component information first:
		$component = self::getExtensionData($pluginName);

		$extension                 = new stdClass;
		$extension->update_site_id = self::getUpdateSiteId($component->extension_id);
		$extension->name           = $component->name;
		$extension->type           = 'extension';

		// Link to the PRO version updater XML:
		$extension->location = 'https://app.commercelab.shop/index.php?option=com_rdsubs&view=updater&format=xml&element=' . $pluginName;

		$extension->enabled              = 1;
		$extension->last_check_timestamp = 0;
		$extension->extra_query          = 'key=' . $updateKey;

		if (self::getUpdateSiteId($component->extension_id))
		{
			// Update the object
			$db->updateObject('#__update_sites', $extension, 'update_site_id');

		}
		else
		{


			// Insert the object.
			$db->insertObject('#__update_sites', $extension);
			// Get the ID of the inserted item:
			$update_site_id = $db->insertid();

			$update                 = new stdClass;
			$update->update_site_id = $update_site_id;
			$update->extension_id   = $component->extension_id;

			// Insert the object.
			$db->insertObject('#__update_sites_extensions', $update);
		}

	}


	/**
	 * @param   string  $pluginName
	 *
	 * @return mixed|null
	 *
	 * @since 2.0
	 */

	private static function getExtensionData(string $pluginName)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__extensions'));
		$query->where($db->quoteName('element') . ' = ' . $db->quote($pluginName));

		$db->setQuery($query);

		return $db->loadObject();


	}

	/**
	 * @param $extension_id
	 *
	 * @return ?int
	 *
	 * @since 2.0
	 */


	private static function getUpdateSiteId($extension_id): ?int
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('update_site_id');
		$query->from($db->quoteName('#__update_sites_extensions'));
		$query->where($db->quoteName('extension_id') . ' = ' . $db->quote($extension_id));

		$db->setQuery($query);

		$result = $db->loadResult();


		return $result;


	}

}
