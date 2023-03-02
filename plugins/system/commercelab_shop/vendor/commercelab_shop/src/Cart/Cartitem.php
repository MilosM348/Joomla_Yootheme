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


use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;

use Exception;

use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Tax\TaxFactory;

use stdClass;

class CartItem
{

	public $id;
	public $cart_id;
	public $joomla_item_id;
	public $item_options;
	public $bought_at_price;
	public $added;
	public $order_id;
	public $cookie_id;
	public $user_id;
	public $amount;

	public $bought_at_price_formatted;
	public $total_bought_at_price_formatted;
	public $total_bought_at_price_with_tax;
	public $total_bought_at_price_with_tax_formatted;
	public $manage_stock_enabled;
	public $product;
	public $totalCost;
	public $selected_options;
	public $variant_id;
	public $selected_variant;


	/**
	 * @throws Exception
	 * @since 2.0
	 */
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
	 * @throws Exception
	 * @since 2.0
	 */

	private function init()
	{

		PluginHelper::importPlugin('commercelab_shop_taxes');

		$this->product                   = ProductFactory::get($this->joomla_item_id);
		$this->bought_at_price_formatted = CurrencyFactory::translate($this->bought_at_price);

		$this->total_bought_at_price_WithoutTax = TaxFactory::getNetPrice(
			$this->bought_at_price * $this->amount,
			$this->product->taxclass
		);
		$this->total_bought_at_price_WithTax    = TaxFactory::getBrutPrice(
			$this->bought_at_price * $this->amount,
			$this->product->taxclass
		);

		$this->total_bought_at_price_formattedWithTax    = CurrencyFactory::translate($this->total_bought_at_price_WithTax);
		$this->total_bought_at_price_formattedWithoutTax = CurrencyFactory::translate($this->total_bought_at_price_WithoutTax);

		if (ProductFactory::basePriceWithTax())
		{
			$args['value'] = $this->total_bought_at_price_WithTax;
		}
		else
		{
			$args['value'] = $this->total_bought_at_price_WithoutTax;
		}

		$this->tax = ProductFactory::getProductTax(
			$args['value'],
			ProductFactory::getProductTaxRate($this->product->taxclass)
		);

		$this->tax_formatted = ProductFactory::getFormattedPrice($this->tax);

		$this->manage_stock_enabled = $this->product->manage_stock;
		$this->stock_available      = $this->product->stock - $this->amount;

		$this->selected_options     = CartFactory::getSelectedOptions($this->item_options);
		$this->selected_variant     = CartFactory::getSelectedVariant($this->variant_id);
		$this->totalCost            = $this->amount * $this->bought_at_price;

		// Removing this data from Cart Items, confclits with Vue - TODO, recheck if:
		// Do we really need an entire Joomla Article object? We can leverage more on __get($name) & __isset($name) functions from Product Class
		$this->product->joomlaItem->introtext = null;
		$this->product->joomlaItem->fulltext  = null;

		$listed_variants = [];
		if ($this->selected_variant)
		{
			$this->listedVariants = [];
			foreach ($this->product->variants as $variant)
			{
				foreach ($variant->labels as $label) if ( in_array($label->id, explode(',', $this->selected_variant->label_ids)))
				{
					$listedVariant          = new stdClass();
					$listedVariant->name    = $variant->name;
					$listedVariant->label   = $label->name;
					$this->listedVariants[] = $listedVariant;
				}
			}
		}

	}


}
