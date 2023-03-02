<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Customer;

// no direct access

defined('_JEXEC') or die('Restricted access');


class Customer
{

	public $id;
	public $j_user_id;
	public $name;
	public $email;
	public $published;
	public $j_user;
	public $orders;
	public $total_orders;
	public $order_total;
	public $order_total_integer;
	public $addresses;


	public function __construct($data)
	{

		if ($data) {
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
	 * @throws \Brick\Money\Exception\UnknownCurrencyException
	 * @since 2.0
	 */

	private function init()
	{
		  // "items" => []
		  // "totalitems" => 49
		  // "totalfiltered" => 0
		  // "totalshowing" => 0

		$this->j_user = ($this->j_user_id !== 0) ? 0 : CustomerFactory::getUser($this->j_user_id);
		$this->orders = CustomerFactory::getCustomersOrders($this->id);

		$this->total_orders = $this->orders['totalfiltered'];

		$this->order_total         = CustomerFactory::getOrderTotal($this->orders['items']);
		$this->order_total_integer = CustomerFactory::getOrderTotal($this->orders['items'], true);
		$this->addresses           = CustomerFactory::getCustomerAddresses($this->id);

	}


}
