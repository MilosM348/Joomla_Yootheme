<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


namespace CommerceLabShop\Cart;

// no direct access
defined('_JEXEC') or die('Restricted access');



class SelectedVariant
{

	public $id;
	public $product_id;
	public $label_ids;
	public $price;
	public $stock;
	public $sku;
	public $active;
	public $default;
	public $labels_csv;
	public $selection_array;


	public function __construct($data)
	{

		if ($data)
		{
			$this->hydrate($data);
			$this->init();
		}

	}

	/**
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
	 *
	 * @since 2.0
	 */

	private function init()
	{

		$this->selection_array = CartFactory::getVariantLabels($this->label_ids);

		if($this->selection_array) {
			$labelNames = array();
			foreach ($this->selection_array as $label) {
				$labelNames[] = $label['name'];
			}

			$this->labels_csv = implode(', ', $labelNames);
		}






	}


}
