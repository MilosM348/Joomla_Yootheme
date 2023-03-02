<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
namespace CommerceLabShop\Shop;

defined('_JEXEC') or die('Restricted access');


class JoomlaItem
{

	public $id;
	public $title;
	public $alias;
	public $state;
	public $catid;
	public $created;
	public $created_by;
	public $created_by_alias;
	public $modified;
	public $modified_by;
	public $publish_up;
	public $publish_down;
	public $images;
	public $urls;
	public $ordering;
	public $metakey;
	public $metadesc;
	public $access;
	public $hits;
	public $featured;
	public $language;
	public $introtext;
	public $fulltext;



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
	 * @since 2.0
	 */

	private function init()
	{


	}


}
