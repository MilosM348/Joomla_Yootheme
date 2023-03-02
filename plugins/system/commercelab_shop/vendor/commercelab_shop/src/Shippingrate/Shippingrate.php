<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Shippingrate;

// no direct access
use Brick\Math\BigDecimal;

defined('_JEXEC') or die('Restricted access');


class Shippingrate
{

	public $id;
	public $country_id;
	public $country_name;
	public $weight_from;
	public $weight_to;
	public $cost;
	public $costFloat;
	public $costFormatted;
	public $handling_cost;
	public $handling_costFormatted;
	public $handling_costFloat;
	public $published;


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
	 * @throws \Brick\Money\Exception\UnknownCurrencyException
	 * @since 2.0
	 */

	private function init()
	{

		$this->country_name           = ShippingrateFactory::getCountryName($this->country_id);
		$this->costFormatted          = ShippingrateFactory::intToFormat($this->cost);
		$this->costFloat              = ShippingrateFactory::getFloat($this->cost);
		$this->handling_costFloat     = ShippingrateFactory::getFloat($this->handling_cost);
		$this->handling_costFormatted = ShippingrateFactory::intToFormat($this->handling_cost);


	}


}



