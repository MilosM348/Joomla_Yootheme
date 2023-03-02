<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Discount;
// no direct access
defined('_JEXEC') or die('Restricted access');


class Discount
{


	//TODO - WRITE A FUNCTION IN THE INSTALL/UPGRADE SCRIPT TO CONVERT OLD DISCOUNT STRUCTURE TO THIS NEW ONE.


	public $id;
	public $name;
	public $amount;
	public $amount_formatted;
	public $percentage;
	public $coupon_code;
	public $start_date;
	public $expiry_date;
	public $expiry_date_vue;
	public $discount_type;
	public $discount_type_string;
	public $max_usage;
	public $published;
	public $created;
	public $modified;
	public $created_by;
	public $modified_by;


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

		$this->discount_type_string = DiscountFactory::getDiscountTypeAsString($this->discount_type);
		$this->amount_formatted     = DiscountFactory::getDiscountAmountFormatted($this->amount, $this->percentage, $this->discount_type);

	}
}
