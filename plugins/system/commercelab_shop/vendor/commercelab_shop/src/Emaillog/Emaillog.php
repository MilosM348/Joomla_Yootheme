<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
namespace CommerceLabShop\Emaillog;

defined('_JEXEC') or die('Restricted access');


class Emaillog
{

	public $id;
	public $emailaddress;
	public $emailtype;
	public $sentdate;
	public $customer_id;
	public $customer_name;
	public $order_id;
	public $order_number;
	public $created_by;
	public $created_by_name;
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

		$this->customer_name   = EmaillogFactory::getCustomerName($this->customer_id);
		$this->order_number    = EmaillogFactory::getOrderNumber($this->order_id);
		$this->created_by_name = EmaillogFactory::getCreatedName($this->created_by);

	}


}
