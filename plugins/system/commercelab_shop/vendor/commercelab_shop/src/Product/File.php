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


class File
{

	public $id;
	public $product_id;
	public $filename;
	public $filename_obscured;
	public $isjoomla;
	public $version;
	public $type;
	public $stability_level;
	public $stability_level_string;
	public $php_min;
	public $download_access;
	public $published;
	public $downloads;
	public $created;
	public $modified;


	public function __construct($data)
	{

		if ($data)
		{
			$this->hydrate($data);
			$this->init();
		}

	}

	/**
	 *
	 * Function to simply "hydrate" the database values directly to the class parameters.
	 *
	 * @param $data
	 *
	 *
	 * @since 2.0
	 */

	private function hydrate($data)
	{
		foreach ($data as $key => $value)
		{

			if (property_exists($this, $key))
			{
				$this->{$key} = $value;
			}

		}
	}

	/**
	 *
	 * Function to "hydrate" all non-database values.
	 *
	 * @param $data
	 *
	 *
	 * @since 2.0
	 */

	private function init()
	{
		$this->stability_level_string = ProductFactory::getFileStabilityLevelString($this->stability_level);

	}


}
