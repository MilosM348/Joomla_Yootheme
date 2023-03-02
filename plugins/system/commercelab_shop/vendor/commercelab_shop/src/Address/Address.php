<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Address;

// no direct access
defined('_JEXEC') or die('Restricted access');


class Address
{
	public $id;
	public $customer_id;
	public $first_name;
	public $last_name;
	public $company_name;
	public $vat;
	public $address1;
	public $address2;
	public $address3;
	public $city;
	public $zone;
	public $zone_name;
	public $country;
	public $country_name;
	public $country_isocode_2;
	public $country_isocode_3;
	public $postcode;
	public $phone;
	public $email;
	public $mobile_phone;
	public $address_type;
	public $created;
	public $address_as_csv;
	public $isAssignedShipping;
	public $isAssignedBilling;


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

		$this->zone_name          = AddressFactory::getZoneName($this->zone);
		$country                  = AddressFactory::getCountry($this->country);

		if($country) {
			$this->country_name       = $country->country_name;
			$this->country_isocode_2  = $country->country_isocode_2;
			$this->country_isocode_3  = $country->country_isocode_3;
		}

		$this->address_as_csv       = AddressFactory::getAddressAsCSV($this);
		$this->address_for_checkout = AddressFactory::getAddressForCheckout($this);
		$this->isAssignedShipping   = AddressFactory::checkAssigned($this->id, 'shipping');
		$this->isAssignedBilling    = AddressFactory::checkAssigned($this->id, 'billing');


	}

	public static function getAssignedShippingAddressID(){
		return AddressFactory::getCurrentShippingAddress();
	}

	public static function getAssignedBillingAddressID(){
		return AddressFactory::getCurrentBillingAddress();
	}

}
