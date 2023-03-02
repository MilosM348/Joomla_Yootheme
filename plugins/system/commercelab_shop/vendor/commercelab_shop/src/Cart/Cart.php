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

use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Tax\TaxFactory;
use CommerceLabShop\Coupon\CouponFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Shipping\ShippingFactory;

use Exception;


class Cart
{


	public $id;
	public $user_id;
	public $cookie_id;
	public $state; // 0 => Open Cart, 1 => Concluded Cart, 2 => Moved from Guest to Customer, 3 => Abbonded
	public $guest;
	public $address_same_as;
	public $coupon_id;
	public $shipping_address_id;
	public $billing_address_id;
	public $shipping_type;
	public $count;
	public $cartItems;

	public $total;
	public $totalInt;

	public $totalWithTaxInt;

	public $totalWithTax;
	public $totalWithoutTax;

	public $totalWithDefaultTaxInt;
	public $totalWithDefaultTax;

	public $subtotal;
	public $subtotalInt;

	public $subtotalWithTaxInt;
	public $subtotalWithTax;

	public $finalSubtotal;

	public $subtotalWithDefaultTaxInt;
	public $subtotalWithDefaultTax;

	public $tax;
	public $taxInt;

	public $default_tax;
	public $default_taxInt;

	public $totalShipping;
	public $totalShippingFormatted;
	public $totalDiscount;
	public $totalDiscountInt;


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

		$currency = CurrencyFactory::getCurrent();

		$this->cartItems = CartFactory::getCartItems($this->id);
		$this->count     = CartFactory::getCount($this->cartItems);

		$this->subtotalInt = CartFactory::getSubTotal($this);
		$this->subtotal    = CurrencyFactory::translate($this->subtotalInt, $currency);

		$this->subtotalWithoutTaxInt = CartFactory::getSubTotalWithoutTax($this);
		$this->subtotalWithTaxInt    = CartFactory::getSubTotalWithTax($this);
		$this->subtotalWithTax       = CurrencyFactory::translate($this->subtotalWithTaxInt, $currency);
		$this->subtotalWithoutTax    = CurrencyFactory::translate($this->subtotalWithoutTaxInt, $currency);

		$this->totalShipping    = ShippingFactory::getShipping($this);
		$shipping_tax_rate      = ComponentHelper::getParams('com_commercelab_shop')->get('shipping_tax_class', 0);
		$this->totalShippingTax = (!$shipping_tax_rate) ? 0 : (int) (TaxFactory::getItemTax(
			$this->totalShipping, 
			TaxFactory::getApplicableTaxRate($shipping_tax_rate)
		) * 100);
		// dd($this->totalShippingTax);
		$this->totalShippingWithTax    = ShippingFactory::getShippingWithTax($this->totalShipping);
		$this->totalShippingWithoutTax = ShippingFactory::getShippingWithoutTax($this->totalShipping);

		$this->totalInt = CartFactory::getGrandTotal($this);
		$this->total    = CurrencyFactory::translate($this->totalInt, $currency);

		$this->totalWithTaxInt = CartFactory::getTotalWithTax($this);
		$this->totalWithTax    = CurrencyFactory::translate($this->totalWithTaxInt, $currency);
		$this->totalWithoutTax = CurrencyFactory::translate(CartFactory::getTotalWithoutTax($this), $currency);

		$this->taxInt = TaxFactory::getTotalTax($this);
		$this->tax    = CurrencyFactory::translate($this->taxInt, $currency);

		$this->default_taxInt = TaxFactory::getTotalDefaultTax($this->subtotalInt);
		$this->default_tax    = CurrencyFactory::translate($this->default_taxInt, $currency);

		// $this->totalWithTaxInt = $this->totalInt;



		$this->totalWithDefaultTaxInt  = $this->totalInt + $this->default_taxInt;
		$this->totalWithDefaultTax     = CurrencyFactory::translate($this->totalWithDefaultTaxInt, $currency);


		$this->totalShippingWithTax_formatted    = CurrencyFactory::translate($this->totalShippingWithTax, $currency);
		$this->totalShippingWithoutTax_formatted = CurrencyFactory::translate($this->totalShippingWithoutTax, $currency);

		$this->totalShippingFormatted  = ShippingFactory::getShippingFormatted($this);

		$couponDiscount = CouponFactory::calculateDiscount($this);

		if ($couponDiscount > $this->subtotalInt)
		{
			$this->totalDiscount    = CurrencyFactory::translate($this->subtotalInt);
			$this->totalDiscountInt = $this->subtotal;
		}
		else
		{
			$discount               = CouponFactory::calculateDiscount($this);
			$this->totalDiscount    = CurrencyFactory::translate($discount);
			$this->totalDiscountInt = CouponFactory::calculateDiscount($this);
		}


	}


}
