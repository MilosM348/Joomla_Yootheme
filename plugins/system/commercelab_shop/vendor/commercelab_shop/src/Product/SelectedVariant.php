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


class SelectedVariant
{


	/**
	 * @var int $id
	 * @since 2.0
	 */
	public $id;

	/**
	 * @var int $product_id
	 * @since 2.0
	 */
	public $product_id;

	/**
	 * @var string $label_ids
	 * @since 2.0
	 */
	public $label_ids;

	/**
	 * @var int $price
	 * @since 2.0
	 */
	public $price;

	/**
	 * @var int $stock
	 * @since 2.0
	 */
	public $stock;

	/**
	 * @var string $stock
	 * @since 2.0
	 */
	public $sku;

	/**
	 * @var int $active
	 * @since 2.0
	 */
	public $active;

	/**
	 * @var int $default
	 * @since 2.0
	 */
	public $default;


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
	 * @since 2.0
	 */

	private function init()
	{


	}


}
