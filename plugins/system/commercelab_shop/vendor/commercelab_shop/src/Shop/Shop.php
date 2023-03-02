<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access


namespace CommerceLabShop\Shop;

use Joomla\CMS\Factory;

use Joomla\CMS\Component\ComponentHelper;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Cart\CartFactory;

defined('_JEXEC') or die('Restricted access');

class Shop
{

	// base
	public $id;
	public $joomla_item_id;
	public $enablepickup;
	public $enableordertime;
	public $pickuptimes;
	public $ordertimes;
	public $workinghours;
	public $address;
	public $city;
	public $postalcode;
	public $country;
	public $zone;
	public $products;
	public $published;
	
	// Joomla Item
	public $title;
	public $categoryName;
	public $joomlaItem;
	public $images;
	public $imagePath;
	public $tags;
	public $taxclass;
	public $link;
	public $category_link;
	public $isPendingState;

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
	
	private function fixCheckboxes($data)
	{
		foreach ($data as $key => &$day) {
			$day['workingday'] = ($day['workingday'] == '1') ? true : false;
			
			if (isset($day['straight']))
			{
				$day['straight']   = ($day['straight'] == '1') ? true : false;
			}
		}
		return $data;
	}

	private function init()
	{
		// get the joomla item
		$this->joomlaItem     = ShopFactory::getJoomlaItem($this->joomla_item_id);
		$this->published      = $this->joomlaItem->state == 1;
		$this->title          = $this->joomlaItem->title;
		// $this->isPendingState = Utilities::isPendingState($this->publish_up);
		$this->images         = json_decode($this->joomlaItem->images, true);

		if ($this->images)
		{
			$this->imagePath = ShopFactory::getImagePath($this->images['image_intro']);
		}

		$this->workinghours               = self::fixCheckboxes(json_decode($this->workinghours, true));
		$this->ordertimes                 = self::fixCheckboxes(json_decode($this->ordertimes, true));
		$this->pickuptimes                = self::fixCheckboxes(json_decode($this->pickuptimes, true));
		$this->enablepickup               = ($this->enablepickup == 1) ? true : false;
		$this->enableordertime            = ($this->enableordertime == 1) ? true : false;
		$this->products                   = (!is_null($this->products) && $this->products != '') ? json_decode($this->products, true) : [];
	}
}
