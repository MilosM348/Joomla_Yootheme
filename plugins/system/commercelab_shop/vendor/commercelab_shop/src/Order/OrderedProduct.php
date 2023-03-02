<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
namespace CommerceLabShop\Order;

defined('_JEXEC') or die('Restricted access');


class OrderedProduct
{

	public $id;
	public $order_id;
	public $j_item;
	public $j_item_cat;
	public $j_item_name;
	public $item_options;
	public $variant_id;
	public $item_options_array;
	public $price_at_sale;
	public $price_at_sale_formatted;
	public $amount;
	public $subtotal;
	public $subtotal_formatted;


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
	 *
	 * @throws \Brick\Money\Exception\UnknownCurrencyException
	 * @since 2.0
	 */

	private function init()
	{

		// set all the formats for the money values.
		$this->price_at_sale_formatted = OrderFactory::intToFormat($this->price_at_sale, OrderFactory::getOrderCurrency($this->order_id));

		$this->subtotal           = $this->price_at_sale * $this->amount;
		$this->subtotal_formatted = OrderFactory::intToFormat($this->subtotal);
		$this->item_options_array = json_decode($this->item_options);

	}


}
