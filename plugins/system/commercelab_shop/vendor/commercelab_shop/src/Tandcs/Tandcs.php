<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Tandcs;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use stdClass;

class Tandcs
{


	public function __construct()
	{


	}

	public static function isChecked()
	{

		$db        = Factory::getDbo();
		$cookie_id = Factory::getApplication()->input->cookie->get('yps-cart', null);

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_tandcs_checked'));
		$query->where($db->quoteName('cookie_id') . ' = ' . $db->quote($cookie_id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if($result) {
			return true;
		} else {
			return false;
		}

	}


	public static function toggle($checkState)
	{

		$db        = Factory::getDbo();
		$cookie_id = Factory::getApplication()->input->cookie->get('yps-cart', null);

		$query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('cookie_id') . ' = ' . $db->quote($cookie_id)
		);

		$query->delete($db->quoteName('#__commercelab_shop_tandcs_checked'));
		$query->where($conditions);

		$db->setQuery($query);

		$result = $db->execute();

		if ($result)
		{

			if ($checkState == 'checked')
			{

				$object            = new stdClass();
				$object->id        = 0;
				$object->cookie_id = $cookie_id;

				$db->insertObject('#__commercelab_shop_tandcs_checked', $object);

				return true;
			}

			return false;

		}


	}


}
