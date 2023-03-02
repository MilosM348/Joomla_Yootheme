<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
namespace CommerceLabShop\Email;

defined('_JEXEC') or die('Restricted access');


class Email
{

	public $id;
	public $to;
	public $body;
	public $emailtype;
	public $emailtype_string;
	public $subject;
	public $published;
	public $language;
	public $language_image;
	public $created_by;
	public $modified_by;
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
	 * @since 2.0
	 */

	private function init()
	{

		$this->emailtype_string = EmailFactory::emailTypeToString($this->emailtype);
		$this->language_image = EmailFactory::getLanguageImageString($this->language);

	}


}
