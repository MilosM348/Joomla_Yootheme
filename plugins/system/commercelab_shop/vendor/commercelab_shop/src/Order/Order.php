<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
namespace CommerceLabShop\Order;

use CommerceLabShop\Address\Address;

defined('_JEXEC') or die('Restricted access');


class Order
{

	public $id;
	public $customer_id;
	public $customer_name;
	public $customer_email;
	public $order_date;
	public $order_number;
	public $invoice_number;
	public $payment_number;
	public $order_paid;
	public $order_subtotal;
	public $order_status;
	public $order_status_formatted;
	public $order_total;
	public $shipping_total;
	public $tax_total;
	public $currency;
	public $payment_method;
	public $payment_method_icon;
	public $customer_notes;
	public $vendor_token;
	public $guest_pin;
	public $billing_address_id;
	public $shipping_address_id;
	public $published;
	public $discount_code;
	public $discount_total;
	public $donation_total;


	// Addresses

	public $billing_address;
	public $shipping_address;

	// Price as formatted Strings:

	public $order_total_formatted;
	public $order_total_float;
	public $order_subtotal_formatted;
	public $shipping_total_formatted;
	public $tax_total_formatted;
	public $discount_total_formatted;
	public $donation_total_formatted;

	// Products

	public $ordered_products;
	public $product_count;


	// Tracking

	public $tracking_code;
	public $tracking_link;
	public $tracking_provider;
	public $tracking_created;

	// Logs

	public $logs;
	public $emailLogs;
	public $internal_notes;

	// hash
	public $hash;

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

		// set all the formats for the money values.
		if($this->order_status) {
			$this->order_status_formatted = OrderFactory::getStatusFormatted($this->order_status);
		}
		
		$this->order_total_formatted = OrderFactory::intToFormat($this->order_total, $this->currency);
		$this->order_total_float     = OrderFactory::intToFloat($this->order_total, $this->currency);

		$this->order_subtotal_formatted = OrderFactory::intToFormat($this->order_subtotal, $this->currency);

		// Customer

		$this->customer_name  = '';
		$this->customer_email = '';

		$customer = OrderFactory::getCustomer($this->customer_id);
		if ($customer)
		{
			$this->customer_name  = $customer->name;
			$this->customer_email = $customer->email;
		}


		// Addresses

		$this->billing_address  = ($this->billing_address_id) ? OrderFactory::getAddress($this->billing_address_id) : '';
		$this->shipping_address = ($this->shipping_address_id) ? OrderFactory::getAddress($this->shipping_address_id) : '';


		// Logs
		$this->logs           = OrderFactory::getOrderLogs($this->id);
		$this->emailLogs      = OrderFactory::getEmailLogs($this->id);
		$this->internal_notes = OrderFactory::getOrderNotes($this->id);
		// Formatted values

		// get the £0.00 value for use on all formatted values if they are set to 0.
		$zeroFormatted = OrderFactory::intToFormat(0, $this->currency);


		$this->shipping_total_formatted = $zeroFormatted;
		if ($this->shipping_total)
		{
			$this->shipping_total_formatted = OrderFactory::intToFormat($this->shipping_total, $this->currency);
		}

		$this->tax_total_formatted = $zeroFormatted;
		if ($this->tax_total)
		{
			$this->tax_total_formatted = OrderFactory::intToFormat($this->tax_total, $this->currency);

		}

		$this->discount_total_formatted = $zeroFormatted;
		if ($this->discount_total)
		{
			$this->discount_total_formatted = OrderFactory::intToFormat($this->discount_total, $this->currency);
		}


		$this->donation_total_formatted = $zeroFormatted;
		if ($this->donation_total)
		{
			$this->donation_total_formatted = OrderFactory::intToFormat($this->donation_total, $this->currency);
		}

		// get the products ordered
		$this->ordered_products = OrderFactory::getOrderedProducts($this->id);
		if ($this->ordered_products)
		{
			$this->product_count = count($this->ordered_products);
		}

		$this->payment_method_icon = OrderFactory::getPaymentMethodIcon($this->payment_method);

		// Tracking


		$this->tracking_code    = '';
		$this->tracking_link    = '';
		$this->tracking_created = '';

		if ($tracking = OrderFactory::getTracking($this->id))
		{

			$this->tracking_code     = $tracking->tracking_code;
			$this->tracking_link     = $tracking->tracking_link;
			$this->tracking_provider = $tracking->tracking_provider;
			$this->tracking_created  = $tracking->created;

		}

	}

    // public static function getVars() {
    //     return get_object_vars(self);
    // }
}
