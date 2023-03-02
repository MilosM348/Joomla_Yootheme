<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


namespace CommerceLabShop\Coupon;

// no direct access
defined('_JEXEC') or die('Restricted access');


class Coupon
{

	public $id;
	public $amount;
	public $percentage;
	public $coupon_code;
	public $start_date;
	public $expiry_date;
	public $name;
	public $discount_type;
	public $inDate;


	public function __construct($data)
	{

		if ($data)
		{
			$this->hydrate($data);
			$this->init($data);
		}

	}

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


	private function init($data)
	{

		$this->inDate = CouponFactory::isCouponInDate($this);


	}


}
