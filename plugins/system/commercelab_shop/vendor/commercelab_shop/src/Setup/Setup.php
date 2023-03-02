<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Setup;
// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Setup
{

	private $db;
	public $issetup;


	public function __construct()
	{
		$this->db = Factory::getDbo();

		$this->initSetup();


	}

	private function initSetup()
	{

		$query = $this->db->getQuery(true);

		$query->select('*');
		$query->from($this->db->quoteName('#__commercelab_shop_setup'));
		$query->where($this->db->quoteName('id') . ' = 1');
		$query->where($this->db->quoteName('value') . ' = ' . $this->db->quote('true'));

		$this->db->setQuery($query);

		if ($this->db->loadResult())
		{
			$this->issetup = 'true';
		}
		else
		{
			$this->issetup = 'false';
		}


	}

	public function setupComplete()
	{

		$object        = new stdClass();
		$object->id    = 1;
		$object->value = 'true';

		$this->db->updateObject('#__commercelab_shop_setup', $object, 'id');

		$this->issetup = true;
	}

}
