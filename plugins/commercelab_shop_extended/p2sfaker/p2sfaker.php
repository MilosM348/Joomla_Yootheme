<?php
/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(__DIR__ . '/vendor/autoload.php');


use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\Input\Input;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filter\OutputFilter;

use CommerceLabShop\Bootstrap\AdminViewExtended;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Customer\CustomerFactory;

use CommerceLabShop\Sidebarlink\Sidebarlink;
use CommerceLabShop\Utilities\Utilities;


class plgCommerceLab_Shop_extendedP2sfaker extends CMSPlugin implements AdminViewExtended
{

	public $app;

	/**
	 * @var Input
	 * @since 1.0
	 */
	public $input;

	public function onAfterInitialise()
	{


	}

	/**
	 *
	 * @return Sidebarlink
	 *
	 * @since 2.00
	 */


	public function onGetSidebarLink(): Sidebarlink
	{
		$menuItem = new \stdClass();


		$menuItem->view     = 'p2sfaker';
		$menuItem->linkText = 'Generate Testing Content';
		$menuItem->icon     = '<svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="layer-plus" class="svg-inline--fa fa-layer-plus fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M504 96h-88V8c0-4.42-3.58-8-8-8h-16c-4.42 0-8 3.58-8 8v88h-88c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h88v88c0 4.42 3.58 8 8 8h16c4.42 0 8-3.58 8-8v-88h88c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zm-6.77 270.71l-99.72-42.87 99.72-42.87c8.35-3.6 12.19-13.23 8.58-21.52-3.65-8.29-13.32-12.13-21.74-8.48l-225.32 96.86c-1.81.77-3.74.77-5.48 0L45.23 258.4l193.45-83.16c8.35-3.59 12.19-13.23 8.58-21.52-3.65-8.28-13.26-12.13-21.74-8.48L14.81 235.81C5.81 239.66 0 248.52 0 258.4c0 9.87 5.81 18.74 14.77 22.58l99.73 42.87-99.7 42.85C5.81 370.55 0 379.42 0 389.31c0 9.87 5.81 18.74 14.77 22.58l225.32 96.84c5.06 2.17 10.48 3.28 15.9 3.28s10.84-1.09 15.9-3.28l225.29-96.83c9-3.85 14.81-12.72 14.81-22.59.01-9.89-5.8-18.76-14.76-22.6zM258.74 478.72c-1.81.77-3.74.77-5.48 0L45.23 389.29 156 341.68l84.1 36.15c5.06 2.17 10.48 3.28 15.9 3.28s10.84-1.09 15.9-3.28l84.12-36.16 110.78 47.62-208.06 89.43z"></path></svg>';

		return new Sidebarlink($menuItem);


	}

	/**
	 *
	 * @return JsonResponse
	 *
	 * @throws Exception
	 * @since 1.0
	 */


	public function onAjaxP2sfaker()
	{


		$this->app   = Factory::getApplication();
		$this->input = $this->app->input;

		return new JsonResponse($this->getResponse($this->input));

	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 1.0
	 */


	private function getResponse(Input $data): bool
	{


		$products = $data->json->getInt('products');

		if ($products > 0)
		{
			for ($x = 1; $x <= $products; $x++)
			{

				$this->generateProduct($data->json->getInt('jform_catid'));

			}
		}

		$customers = $data->json->getInt('customers');


		if ($customers > 0)
		{
			for ($x = 1; $x <= $customers; $x++)
			{

				$this->generateCustomer();

			}
		}


		$orders = $data->json->getInt('orders');

		if ($orders > 0)
		{
			for ($x = 1; $x <= $orders; $x++)
			{

				$this->generateOrder();

			}
		}

		return true;

	}

	/**
	 *
	 * @return void
	 *
	 * @throws Exception
	 * @since 1.0
	 */


	private function generateProduct($catid)
	{

		$faker = Faker\Factory::create();

		$productInput = new Joomla\Input\Input();

		$title = $faker->company;

		$productInput->json->set('itemid', 0);
		$productInput->json->set('title', $title);
		$productInput->json->set('short_desc', $faker->text(150));
		$productInput->json->set('long_desc', $faker->text(250));
		$productInput->json->set('category', $catid);
		$productInput->json->set('language', '*');
		$productInput->json->set('state', 1);
		$productInput->json->set('featured', 0);
		$productInput->json->set('access', 1);
		$productInput->json->set('publish_up_date', Utilities::getDate());


		Folder::create(JPATH_SITE . '/images/commercelab_shop_faker/');


		$filename = OutputFilter::stringURLSafe($title);
		$filename = File::makeSafe($filename . '.jpg');


		$url  = 'https://picsum.photos/300/300';
		$img  = JPATH_SITE . '/images/commercelab_shop_faker/' . $filename;
		$path = 'images/commercelab_shop_faker/' . $filename;
		file_put_contents($img, file_get_contents($url));

		$productInput->json->set('teaserimage', $path);
		$productInput->json->set('fullimage', $path);
		$productInput->json->set('base_price', random_int(1, 500));

		$shippingModes = array('flat', 'weight');
		$rand_key      = array_rand($shippingModes, 1);
		$productInput->json->set('shipping_mode', $shippingModes[$rand_key]);

		if ($rand_key === 0)
		{
			$productInput->json->set('flatfee', random_int(3, 55));
		}

		$productInput->json->set('manage_stock', random_int(0, 1));
		$productInput->json->set('stock', random_int(1, 100));
		$productInput->json->set('maxPerOrder', random_int(1, 10));
		$productInput->json->set('taxclass', random_int(0, 1));
		$productInput->json->set('product_type', 1);
		$productInput->json->set('sku', $faker->isbn10);


		ProductFactory::saveFromInputData($productInput);

	}

	/**
	 *
	 *
	 * @throws Exception
	 * @since 1.0
	 */

	private function generateCustomer()
	{
		$faker = Faker\Factory::create();

		$input = new Joomla\Input\Input();
		$input->json->set('name', $faker->name);
		$input->json->set('username', $faker->userName);
		$input->json->set('password', $faker->password);
		$input->json->set('email', $faker->email);


		UserFactory::register($input);

		// now create CommerceLab Shop Customer:

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__users'));
		$query->where($db->quoteName('username') . ' = ' . $db->quote($input->json->get('username')));

		$db->setQuery($query);

		$id = $db->loadResult();

		$user = Factory::getUser($id);

		$object            = new stdClass();
		$object->id        = 0;
		$object->j_user_id = $user->id;
		$object->email     = $user->email;
		$object->name      = $user->name;
		$object->published = 1;
		$object->created   = Utilities::getDate();

		$result = $db->insertObject('#__commercelab_shop_customer', $object);

		//add an address

		$input = new Joomla\Input\Input();
		$input->json->set('name', $faker->name);
		$input->json->set('customer_id', $db->insertid());
		$input->json->set('address1', $faker->streetAddress);
		$input->json->set('address2', $faker->secondaryAddress);
		$input->json->set('town', $faker->city);

		$country = $this->getRandomCountryId();
		$input->json->set('country', $country);

		$zone = $this->getRandomZoneId();
		$input->json->set('zone', $zone);

		$input->json->set('postcode', $faker->postcode);
		$input->json->set('phone', $faker->phoneNumber);
		$input->json->set('mobile_phone', $faker->phoneNumber);
		$input->json->set('email', $faker->email);

		AddressFactory::saveFromInputData($input);

	}

	private function generateOrder()
	{

		$db = Factory::getDbo();

		// get the array of potential Orders statuses
		$status = array("R", "C", "P", "X", "S", "F");
		// pick a random status
		$rand_keys = array_rand($status);

		// grab any customer id
		$customer_id = $this->getRandomCustomerId();

		// get the customer object
		$customer = CustomerFactory::get($customer_id);

		// build the insert object, ready for inserting
		$object                      = new stdClass();
		$object->id                  = 0;
		$object->customer_id         = $customer_id;
		$object->order_date          = Utilities::getDate();
		$object->order_number        = $this->_generateOrderId(rand(10000, 99999));
		$object->order_paid          = rand(0, 1);
		$object->order_subtotal      = 0;
		$object->order_status        = $status[$rand_keys];
		$object->order_total         = 0;
		$object->shipping_total      = 0;
		$object->tax_total           = 0;
		$object->currency            = CurrencyFactory::getDefault()->iso;
		$object->payment_method      = "Offline Pay";
		$object->billing_address_id  = ($customer->addresses ? $customer->addresses[0]->id : 0);
		$object->shipping_address_id = ($customer->addresses ? $customer->addresses[0]->id : 0);
		$object->published           = 1;

		$db->insertObject('#__commercelab_shop_order', $object);

		// make sure to keep the new order id
		$order_id = $db->insertid();
		// ADD THE ORDER PRODUCTS TO THE ORDER PRODUCTS TABLE

		// randomise the amount of products ordered integer...
		$amount_of_products_for_order = rand(1, 4);

		// then loop over that generated number
		for ($x = 1; $x <= $amount_of_products_for_order; $x++)
		{

			// grab a random product to add to the order
			$product = ProductFactory::get($this->getRandomProductJoomlaId());

			// build the ordered product object, ready for inserting
			$object                = new stdClass();
			$object->id            = 0;
			$object->order_id      = $order_id;
			$object->j_item        = $product->joomla_item_id;
			$object->j_item_cat    = $product->joomlaItem->catid;
			$object->j_item_name   = $product->joomlaItem->title;
			$object->item_options  = "[]";
			$object->price_at_sale = $product->base_price;
			$object->amount        = 1;

			$db->insertObject('#__commercelab_shop_order_products', $object);

		}

		// go back and update the order with the totals
		$sub_total      = $this->calculateTotal($order_id);

		// invent a shipping total
		$shipping_total = rand(0, 999);

		// add the shipping to the subtotal to get the grand total
		$order_total    = $shipping_total + $sub_total;

		// build the object for the order update
		$object                 = new stdClass();
		$object->id             = $order_id;
		$object->order_subtotal = $sub_total;
		$object->order_total    = $order_total;
		$object->shipping_total = $shipping_total;

		$db->updateObject('#__commercelab_shop_order', $object, 'id');


	}

	/**
	 *
	 * @return mixed|null
	 *
	 * @since 1.0
	 */

	private function calculateTotal(int $order_id)
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('SUM(price_at_sale)');
		$query->from($db->quoteName('#__commercelab_shop_order_products'));
		$query->where($db->quoteName('order_id') . ' = ' . $db->quote($order_id));

		$db->setQuery($query);

		return $db->loadResult();


	}

	/**
	 *
	 * @return mixed|null
	 *
	 * @since 1.0
	 */

	private function getRandomProductJoomlaId()
	{

		$db  = Factory::getDbo();
		$sql = "SELECT `joomla_item_id` FROM #__commercelab_shop_product ORDER BY RAND() LIMIT 1";

		$db->setQuery($sql);

		return $db->loadResult();

	}

	/**
	 *
	 * @return mixed|null
	 *
	 * @since 1.0
	 */

	private function getRandomCustomerId()
	{

		$db  = Factory::getDbo();
		$sql = "SELECT `id` FROM #__commercelab_shop_customer ORDER BY RAND() LIMIT 1";

		$db->setQuery($sql);

		return $db->loadResult();

	}

	/**
	 *
	 * @return mixed|null
	 *
	 * @since 1.0
	 */

	private function getRandomCountryId()
	{

		$db  = Factory::getDbo();
		$sql = "SELECT `id` FROM #__commercelab_shop_country ORDER BY RAND() LIMIT 1";

		$db->setQuery($sql);

		return $db->loadResult();

	}

	/**
	 *
	 * @return mixed|null
	 *
	 * @since 1.0
	 */

	private function getRandomZoneId()
	{
		$db  = Factory::getDbo();
		$sql = "SELECT `id` FROM #__commercelab_shop_zone ORDER BY RAND() LIMIT 1";

		$db->setQuery($sql);

		return $db->loadResult();

	}

	/**
	 * @param $seed
	 *
	 * @return string
	 *
	 * @since 1.0
	 */

	private function _generateOrderId($seed)
	{

		$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$base    = strlen($charset);
		$result  = '';
		$len     = 5;
		$now     = explode(' ', microtime())[1];
		while ($now >= $base)
		{
			$i      = $now % $base;
			$result = $charset[$i] . $result;
			$now    /= $base;
		}
		$rand = substr($result, -$len);

		return strtoupper($rand . $seed);
	}


}
