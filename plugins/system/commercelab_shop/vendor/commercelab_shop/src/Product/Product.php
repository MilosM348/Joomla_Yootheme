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

use Joomla\CMS\Factory;

use Joomla\CMS\Component\ComponentHelper;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Shop\ShopFactory;

defined('_JEXEC') or die('Restricted access');

class Product
{

	// base
	public $id;
	public $joomla_item_id;
	public $title;
	public $subtitle;
	public $sku;

	// Text Descriptions
	public $short_desc;
	public $long_desc;

	// Pricing
	public $base_price = 0; // 4599
	public $base_priceFloat; // 45.99
	public $base_price_formatted; //£45.99
	public $final_price = 0;

	public $tax_rate = 0;
	public $tax = 0;
	public $tax_formatted;

	public $base_priceWithTax = 0;
	public $base_priceWithTax_formatted;

	public $base_priceWithoutTax = 0;
	public $base_priceWithoutTax_formatted;

	public $apply_discount;
	public $discount_type;

	public $discount = 0;
	public $discountFloat;
	public $discount_formatted;

	public $saving = 0;

	public $priceAfterDiscount;
	public $priceAfterDiscount_formatted;

	public $priceAfterDiscountWithTax;
	public $priceAfterDiscountWithTaxFloat;
	public $priceAfterDiscountWithTax_formatted;

	public $in_cart = 0;

	// Checkbox Options
	public $options;

	// Joomla Item
	public $categoryName;
	public $joomlaItem;
	public $images;
	public $teaserImagePath;
	public $fullImagePath;
	public $tags;
	public $taxclass;
	public $link;
	public $category_link;
	public $published;
	public $isPendingState;

	// Shipping
	public $shipping_mode;
	public $flatfee;
	public $flatfeeFloat;
	public $flatfeeFloat_formatted;
	public $weight;
	public $weight_unit;

	// Stock
	public $manage_stock;
	public $stock;
	public $maxPerOrder;

	// Variants
	public $variants;
	public $variantList;
	public $variantDefault;

	// custom fields
	public $custom_fields;

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

	public function __get($name)
	{
		return $this->joomlaItem->$name;
	}

	public function __isset($name)
	{
		return isset($this->joomlaItem->$name);
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
		// get the joomla item
		$this->joomlaItem     = ProductFactory::getJoomlaItem($this->joomla_item_id);
		$this->published      = $this->joomlaItem->state == 1;
		$this->title          = $this->joomlaItem->title;
		$this->isPendingState = Utilities::isPendingState($this->publish_up);
		$this->images         = json_decode($this->joomlaItem->images, true);

		if ($this->images)
		{
			$this->teaserImagePath = ProductFactory::getImagePath($this->images['image_intro']);
			$this->fullImagePath   = ProductFactory::getImagePath($this->images['image_fulltext']);
		}

		// set the prices
		$this->basepriceFloat                 = ProductFactory::getFloat($this->base_price);
		$this->base_price_formatted           = ProductFactory::getFormattedPrice($this->base_price ?: 0);

		// Taxrate
		$this->tax_rate                       = ProductFactory::getProductTaxRate($this->taxclass);
		$this->tax_rateFloat                  = $this->tax_rate;
		$this->tax_rate_formatted             = ProductFactory::getFormattedPercent($this->tax_rate);

		// Shipping
		$this->flatfeeFloat                   = ProductFactory::getFloat(($this->flatfee ?: 0));
		$this->flatfeeFloat_formatted         = ($this->shipping_mode == 'flat') ? ProductFactory::getFormattedPrice($this->flatfee ?: 0) : null;

		$this->tax                            = ($this->tax_rate) ? ProductFactory::getProductTax($this->base_price ?: 0, $this->tax_rate) : 0;
		$this->taxFloat                       = ProductFactory::getFloat($this->tax);
		$this->tax_formatted                  = ProductFactory::getFormattedPrice($this->tax);

		$this->base_priceWithoutTax           = ProductFactory::getPriceWithoutTax($this->base_price ?: 0, $this->taxclass);
		$this->base_priceWithoutTaxFloat      = ProductFactory::getFloat($this->base_priceWithoutTax);
		$this->base_priceWithoutTax_formatted = ProductFactory::getFormattedPrice($this->base_priceWithoutTax);

		$this->base_priceWithTax              = ProductFactory::getPriceWithTax($this->base_price ?: 0, $this->taxclass);
		$this->base_priceWithTaxFloat         = ProductFactory::getFloat($this->base_priceWithTax);
		$this->base_priceWithTax_formatted    = ProductFactory::getFormattedPrice($this->base_priceWithTax);

		// Discount
		if (!$this->apply_discount)
		{
			$this->discount = 0;
		}

		$this->discountFloat      = ProductFactory::getFloat($this->discount);
		$this->discount_formatted =  ($this->discount_type == 'amount')
			? ProductFactory::getFormattedPrice((int) $this->discount)
			: ProductFactory::getFormattedPercent($this->discount / 100);


		$this->priceAfterDiscount                     = ProductFactory::applyDiscount($this->base_price ?: 0, $this, ProductFactory::basePriceWithTax());
		$this->priceAfterDiscountFloat                = ProductFactory::getFloat($this->priceAfterDiscount);
		$this->priceAfterDiscount_formatted           = ProductFactory::getFormattedPrice($this->priceAfterDiscount);

		$this->priceAfterDiscountWithoutTax           = ProductFactory::getPriceWithoutTax($this->priceAfterDiscount, $this->taxclass);
		$this->priceAfterDiscountWithoutTaxFloat      = ProductFactory::getFloat($this->priceAfterDiscountWithoutTax);
		$this->priceAfterDiscountWithoutTax_formatted = ProductFactory::getFormattedPrice($this->priceAfterDiscountWithoutTax);

		$this->priceAfterDiscountWithTax              = ProductFactory::getPriceWithTax($this->priceAfterDiscount, $this->taxclass);
		$this->priceAfterDiscountWithTaxFloat         = ProductFactory::getFloat($this->priceAfterDiscountWithTax);
		$this->priceAfterDiscountWithTax_formatted    = ProductFactory::getFormattedPrice($this->priceAfterDiscountWithTax);


		// Saving
		if ($this->apply_discount)
		{
			if ($this->discount_type == 'amount')
			{
				$this->saving = $this->discount;
			}
			else
			{
				$this->saving = $this->base_price * ($this->discount / 10000);
			}
		}

		$this->savingWithoutTax                = ProductFactory::getPriceWithoutTax((int) $this->saving, $this->taxclass);
		$this->savingWithoutTaxFloat           = ProductFactory::getFloat($this->savingWithoutTax);
		$this->savingWithoutTax_formatted      = ProductFactory::getFormattedPrice($this->savingWithoutTax);

		$this->savingWithTax                   = ProductFactory::getPriceWithTax((int) $this->saving, $this->taxclass);
		$this->savingWithTaxFloat              = ProductFactory::getFloat($this->savingWithTax);
		$this->savingWithTax_formatted         = ProductFactory::getFormattedPrice($this->savingWithTax);

		// Final Price
		$this->final_price                     = $this->priceAfterDiscount; // Int

		$this->final_priceWithoutTax           = $this->priceAfterDiscountWithoutTax; // Int
		$this->final_priceWithoutTaxFloat      = $this->priceAfterDiscountWithoutTaxFloat;
		$this->final_priceWithoutTax_formatted = $this->priceAfterDiscountWithoutTax_formatted;

		$this->final_priceWithTax              = $this->priceAfterDiscountWithTax; // Int
		$this->final_priceWithTaxFloat         = $this->priceAfterDiscountWithTaxFloat;
		$this->final_priceWithTax_formatted    = $this->priceAfterDiscountWithTax_formatted;

		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__commercelab_shop_cart_item'))
			->where($db->quoteName('cart_id') . ' = ' . $db->quote(CartFactory::getCurrentCartId()))
			->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($this->joomla_item_id));

		$db->setQuery($query);
		foreach ($db->loadObjectList() as $key => $cart_items) {
			$this->in_cart += $cart_items->amount;
		}

		$this->pickupoptions = ($this->joomla_item_id) ? ShopFactory::getShopsFromProductId($this->joomla_item_id, true) : [];

		$this->options       = ProductFactory::getOptions($this->joomla_item_id ?: 0);
		$this->categoryName  = ProductFactory::getCategoryName($this->joomlaItem->catid ?: '');
		$this->tags          = ProductFactory::getTags($this->joomla_item_id ?: 0);

		$this->link          = ProductFactory::getRoute('item', $this->joomla_item_id?$this->joomla_item_id:0, $this->joomlaItem->catid?$this->joomlaItem->catid:0);
		$this->category_link = ProductFactory::getRoute('category', $this->joomla_item_id?$this->joomla_item_id:0, $this->joomlaItem->catid?$this->joomlaItem->catid:0);

		$variantData = ProductFactory::getVariantData($this->joomla_item_id?$this->joomla_item_id:0);

		if ($variantData)
		{
			$this->variantData    = $variantData;
			$this->variants       = $variantData->variants;
			$this->variantList    = $variantData->variantList;
			$this->variantDefault = $variantData->default;
		}

		$this->custom_fields = ProductFactory::getCustomFields($this->id?$this->id:0);

	}

}
