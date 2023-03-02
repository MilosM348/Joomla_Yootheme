<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


namespace CommerceLabShop\Country;

// no direct access
defined('_JEXEC') or die('Restricted access');


class Country
{

	public $id;
	public $country_name;
	public $country_isocode_2;
	public $country_isocode_3;
	public $requires_vat;
	public $taxrate;
	public $taxrate_reduced;
	public $taxrate_extra;
	public $published;
	public $default;


	public function __construct($data)
	{

		if ($data)
		{
			$this->hydrate($data);
			$this->init();
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

	private function init()
	{

	}


}
