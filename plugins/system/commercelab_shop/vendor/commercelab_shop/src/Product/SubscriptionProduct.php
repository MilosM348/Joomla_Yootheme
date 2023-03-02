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



class SubscriptionProduct extends Product
{


	public $subscription;
	public $costPerMonth;


	/**
	 * Product constructor.
	 *
	 * @param   null  $joomla_item_id
	 */


	public function __construct($data)
	{

		if ($data)
		{
			$this->hydrate($data);
			$this->init($data);

			parent::__construct($data);
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

	}




}
