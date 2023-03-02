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

use Brick\Money\Exception\UnknownCurrencyException;

use Exception;
use Joomla\Input\Input;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Module\Login\Site\Helper\LoginHelper;

use CommerceLabShop\Tax\Tax;
use CommerceLabShop\Cart\Cartitem;
use CommerceLabShop\Tax\TaxFactory;
use CommerceLabShop\Order\Orderlog;
use CommerceLabShop\Product\Product;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Currency\Currency;
use CommerceLabShop\Shipping\Shipping;
use CommerceLabShop\Price\PriceFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Coupon\CouponFactory;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Customer\CustomerFactory;
use CommerceLabShop\Productoption\Productoption;
use CommerceLabShop\Checkoutnote\CheckoutnoteFactory;
use CommerceLabShop\Productoption\ProductoptionFactory;

use stdClass;

class CartFactory
{


	/**
	 *
	 * gets the current cart... last line initiates a new cart if none is currently found. This is self referencing.
	 *
	 * @return Cart
	 *
	 * @since 2.0
	 */

	public static function get(): Cart
	{
		$instance = CurrentCart::getInstance();
		return $instance->getCart();
	}

	/**
	 *
	 * creates a new cart and then runs the get function.
	 *
	 * @return Cart
	 *
	 * @since 2.0
	 */

	public static function init(): Cart
	{

		$db   = Factory::getDbo();
		$user = UserFactory::getActiveUser();
		// $user     = Factory::getUser();

		$shipping = Shipping::getPrioritisedShipping(); // TODO - move to ShippingFactory

		$object                = new stdClass();
		$object->id            = 0;
		$object->shipping_type = ($shipping->name ? $shipping->name : 'defaultshipping');
		$object->cookie_id     = Utilities::getCookieID();

		// $object->shipping_address_id = 0;
		// $object->billing_address_id  = 0;

		// if ($user->guest)
		// {
		// 	$object->cookie_id = Utilities::getCookieID();
		// }
		// else

		if (!$user->guest)
		{
			$object->user_id = $user->id;
		}

		$db->insertObject('#__commercelab_shop_cart', $object);

		return self::get();

	}

	public static function finalizeGuestCart($cart_id)
	{
		$db = Factory::getDbo();

		$db->setQuery(
			$db->getQuery(true)
				->update($db->quoteName('#__commercelab_shop_cart'))
				->set([
					$db->quoteName('state') . ' = 2'
				])
				->where([
					$db->quoteName('id') . ' = ' . $cart_id
				])
		);

		$db->execute();
	}
	/**
	 *
	 *
	 *
	 * AVOID USING self::get() here as it seems to cause infinite loops. Not sure why!
	 *
	 * @return false|mixed
	 *
	 * @since 1.5
	 */

	// TODO - this method is called more than 10 times when in cart module??!!
	public static function getCartIdByCookie($cookie)
	{

		$db   = Factory::getDbo();

		// now check if there is already a cart for this cookie

		$db->setQuery(
			$db->getQuery(true)
				->select('id')
				->from($db->quoteName('#__commercelab_shop_cart'))
				->where($db->quoteName('cookie_id') . ' = ' . $db->quote($cookie))
				->where($db->quoteName('state') . ' = ' . $db->quote(0))
				->order('id DESC')
		);

		$currentCartId = $db->loadResult();

		if ($currentCartId)
		{
			return $currentCartId;
		}
		else
		{
			return false;

		}
	}
	/**
	 *
	 *
	 *
	 * AVOID USING self::get() here as it seems to cause infinite loops. Not sure why!
	 *
	 * @return false|mixed
	 *
	 * @since 1.5
	 */

	// TODO - this method is called more than 10 times when in cart module??!!
	public static function getCurrentCartId()
	{

		$db   = Factory::getDbo();
		$user = UserFactory::getActiveUser();

		// now check if there is already a cart for this cookie
		$query = $db->getQuery(true)
			->select('id')
			->from($db->quoteName('#__commercelab_shop_cart'))
			->where($db->quoteName('state') . ' = ' . $db->quote(0)); // Cart Not Processed

		// Loggedin user
		if (!$user->guest && !is_null($user->id) && $user->id > 1)
		{
			$query->where($db->quoteName('user_id') . ' = ' . $db->quote($user->id));
		}
		else // Guest User
		{
			$query->where($db->quoteName('cookie_id') . ' = ' . $db->quote(Utilities::getCookieID()));
		}

		$db->setQuery($query);

		$cart_id = $db->loadResult();

		if ($cart_id)
		{
			return $cart_id;
		}
		else
		{
			return false;

		}
	}


	/**
	 * @param $id
	 *
	 * @return false|CartItem
	 *
	 * @throws Exception
	 * @since 1.5
	 */

	public static function getCartitem($id)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__commercelab_shop_cart_item'))
			->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return new CartItem($result);
		}

		return false;

	}

	/**
	 *
	 * gets the cart items for the cart id supplied
	 *
	 * @param $carId
	 *
	 * @return null|array
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function getProductFromCart($product_id)
	{

		$items = self::getCartItems(self::getCurrentCartId());

		if ($items)
		{
			$cartItems = array();

			foreach ($items as $item)
			{
				if ($item->joomla_item_id == $product_id) {
					$cartItems[] = $item;
				}
			}

			return $cartItems;
		}

		return [];

	}

	public static function getTotalAmountProductFromCart($product_id)
	{

		$items  = self::getProductFromCart($product_id);
		$amount = 0;

		if ($items)
		{

			foreach ($items as $item)
			{
				$amount += $item->amount;
			}

		}

		return $amount;

	}

	/**
	 *
	 * gets the cart items for the cart id supplied
	 *
	 * @param $carId
	 *
	 * @return null|array
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function getCartItems($cart_id): ?array
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__commercelab_shop_cart_item'))
			->where($db->quoteName('cart_id') . ' = ' . $db->quote($cart_id));

		// $query->select(['a.*', 'b.*']);
		// $query->from($db->quoteName('#__commercelab_shop_cart_item', 'a'));

		// $query->join('LEFT', $db->quoteName('#__content', 'b') . ' ON (' . $db->quoteName('a.joomla_item_id') . ' = ' . $db->quoteName('b.id') . ')' . ' AND (' . $db->quote(1) . ' = ' . $db->quoteName('b.state') . ')');

		// $query->where($db->quoteName('a.cart_id') . ' = ' . $db->quote($carId));
		// $query->where($db->quoteName('b.id') . ' = ' . $db->quote($carId));

		$db->setQuery($query);

		$items = $db->loadObjectList();

		if ($items)
		{
			$cartItems = [];

			foreach ($items as $item)
			{
				if (ProductFactory::getJoomlaItem($item->joomla_item_id))
				{
					$cartItems[] = new Cartitem($item);
				}
			}

			return $cartItems;
		}

		return null;

	}

	/**
	 * @param   array|null  $cartItems
	 *
	 * @return int
	 *
	 * @since 1.5
	 */

	public static function getCount(?array $cartItems): int
	{

		$count = 0;
		if ($cartItems)
		{
			foreach ($cartItems as $item)
			{
				$count += $item->amount;
			}
		}

		return $count;

	}

	/**
	 * @param   string  $options
	 *
	 * @return null|array
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */


	public static function getSelectedOptions(string $options): ?array
	{
		$selectedOptions = [];
		$option_ids      = explode(',', $options);

		foreach ($option_ids as $option_id)
		{
			$selectedOption = ProductoptionFactory::get($option_id);

			if ($selectedOption)
			{
				$selectedOptions[] = $selectedOption;
			}

		}

		if (!empty($selectedOptions))
		{
			return $selectedOptions;
		}

		return null;

	}

	/**
	 * @param   int|null  $variant_id
	 *
	 * @return SelectedVariant|null
	 *
	 * @since 2.0
	 */


	public static function getSelectedVariant(int $variant_id = null): ?SelectedVariant
	{

		if (!$variant_id)
		{
			return null;
		}

		$db = Factory::getDbo();

		// now check if there is already a cart for this cookie
		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__commercelab_shop_product_variant_data'))
			->where($db->quoteName('id') . ' = ' . $db->quote($variant_id));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return new SelectedVariant($result);
		}

		return null;


	}


	public static function getVariantLabels(string $labels): ?array
	{
		$db    = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('name')
			->from($db->quoteName('#__commercelab_shop_product_variant_label'))
			->where($db->quoteName('id') . ' IN (' . $labels . ')');

		$db->setQuery($query);

		$results = $db->loadAssocList();

		if ($results)
		{
			return $results;
		}

		return null;

	}


	public static function change($change, $cart_id, $item_options_raw, $cart_item_id)
	{

		$db = Factory::getDbo();

		if ($change < 0)
		{
			// remove
			$change = abs($change);

			for ($x = 1; $x <= $change; $x++)
			{

				$conditions = [
					$db->quoteName('cart_id') . " = " . $db->quote($cart_id),
					$db->quoteName('item_options') . ' = ' . $db->quote($item_options_raw)
				];

				$query = $db->getQuery(true)
					->delete($db->quoteName('#__commercelab_shop_cart_item'))
					->where($conditions)
					->setLimit('1');

				$db->setQuery($query);
				$db->execute();

			}

		}
		else
		{
			// create

			$query = $db->getQuery(true)
				->select('*')
				->from($db->quoteName('#__commercelab_shop_cart_item'))
				->where($db->quoteName('id') . ' = ' . $db->quote($cart_item_id));

			$db->setQuery($query);

			$result = $db->loadObject();

			for ($x = 1; $x <= $change; $x++)
			{
				$result->id = 0;
				$db->insertObject('#__commercelab_shop_cart_item', $result);

			}

		}


	}

	/**
	 * @param $id
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function setAsGuest(): bool
	{

		$cart_id = self::getCurrentCartId();

		$object        = new stdClass();
		$object->id    = $cart_id;
		$object->guest = 1;

		$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

		if ($result)
		{
			return true;
		}

		return false;

	}

	public static function setSameAs(int $state): bool
	{

		$cart_id = self::getCurrentCartId();

		$object                  = new stdClass();
		$object->id              = $cart_id;
		$object->address_same_as = $state;

		$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

		if ($result)
		{
			return true;
		}

		return false;

	}
	
	public static function unsetAsGuest(): bool
	{

		$cart_id = self::getCurrentCartId();

		$object        = new stdClass();
		$object->id    = $cart_id;
		$object->guest = 0;

		$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

		if ($result)
		{
			return true;
		}

		return false;

	}

	public static function isGuestCart(): bool
	{
		$cart_id = self::getCurrentCartId();

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('id')
			->from($db->quoteName('#__commercelab_shop_cart'))
			->where($db->quote('id') . ' = ' .$db->quote($cart_id))
			->where($db->quote('guest') . ' = ' .$db->quote(1));

		$db->setQuery($query);

		$results = $db->loadResult();

		if ($results)
		{
			return true;
		}

		return false;

	}

	/**
	 * @param $id
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function removeAll($id): bool
	{

		$db = Factory::getDbo();

		$conditions = array(
			$db->quoteName('id') . " = " . $db->quote($id),
		);

		$query = $db->getQuery(true)
			->delete($db->quoteName('#__commercelab_shop_cart_item'))
			->where($conditions);

		$db->setQuery($query);

		$done = $db->execute();

		if ($done)
		{
			return true;
		}

		return false;
	}

	/**
	 * @param $id
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function remove(Input $data): bool
	{

		$db = Factory::getDbo();

		$conditions = array(
			$db->quoteName('id') . " = " . $db->quote($data->json->getInt('uid')),
			$db->quoteName('cart_id') . " = " . $db->quote($data->json->getInt('cart_id')),
		);

		$query = $db->getQuery(true)
			->delete($db->quoteName('#__commercelab_shop_cart_item'))
			->where($conditions);

		$db->setQuery($query);

		$done = $db->execute();

		if ($done)
		{
			return true;
		}

		return false;
	}

	/**
	 * @param $cartItemId
	 * @param $itemId
	 * @param $newAmount
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function changeCount($cartItemId, $itemId, $newAmount): array
	{
		$product = ProductFactory::get($itemId);

		if (!$product->manage_stock || $product->stock >= $newAmount)
		{
			self::updateExistingCartAmount($cartItemId, $newAmount);

			return ['status' => true, 'amount_in_cart' => $newAmount];
		}

		return ['status' => false];

		// if ($available = self::doStockCompare($product, $cartItemId))
		// {

		// }

		// return false;

	}

	/**
	 * @param   int         $itemid
	 * @param   int         $amount
	 * @param   array|null  $options
	 * @param   array|null  $variant_ids
	 *
	 * @return null|array
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function addToCart(int $itemid, int $amount, array $options = null, array $variant_ids = null): ?array
	{

		// init response
		$response = [];

		// get the product
		$product = ProductFactory::get($itemid);

		$cart_id = self::getCurrentCartId();

		// check stock right away... sorts out a lot of checking later.
		if ($product->manage_stock == 1)
		{
			if ($product->stock == 0)
			{
				//out of stock
				$response['status']  = 'ko';
				$response['message'] = Text::_('COM_COMMERCELAB_SHOP_OUT_OF_STOCK');

				return $response;
			}
		}


		// check if there's a variant
		if ($variant_ids)
		{
			$response = self::addVariantToCart($product, $cart_id, $amount, $variant_ids, $options);
		}
		else
		{
			$response = self::addNonVariantToCart($product, $cart_id, $amount, $options);
		}

		return $response;
	}


	/**
	 *
	 * this function adds a variant selection to the cart.
	 *
	 * @param   Product     $product
	 * @param   int         $cart_id
	 * @param   int         $amount
	 * @param   array|null  $options
	 * @param   array       $variant_ids
	 *
	 * @return array
	 *
	 * @since 2.0
	 *
	 *        todo - stock management
	 */

	public static function addVariantToCart(Product $product, int $cart_id, int $amount, array $variant_ids, array $options = null): array
	{

		// init response
		$response = [];

		// get the variant row containing the price, sku, and stock etc.
		$variantRow = self::getVariantRow($variant_ids);

		if (!$variantRow)
		{
			$response['status'] = 'ko';
			$response['error']  = "CANNOT FIND VARIANT";

			return $response;
		}

		// We need to check if an item with the same variant is already in the cart, so go get the cart item
		$cart_item = self::getCurrentCartItem($cart_id, $product->joomla_item_id, $variantRow->id, $options);


		// now, check the current cart to see if the items are accounted for
		// doVariantStockCompare returns the available stock as an int - or NULL if all stock is used up.
		$amountThatCanBeAdded = ($product->manage_stock) ? self::doVariantStockCompare($variantRow->stock, ($cart_item) ? $cart_item->id : null) : $amount;

		// $amountThatCanBeAdded will be NULL if nothing can be added, so we can do a boolean check here.
		if (!$amountThatCanBeAdded)
		{
			//all stock is added to cart already
			$response['status'] = 'ko';
			$response['error']  = Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_INVENTORY_ALL_STOCK_ADDED_TO_CART');

			return $response;
		}

		//first, does current cart exist?
		if ($cart_item)
		{
			if (self::addAmountToExistingCart($cart_item, $amountThatCanBeAdded)) $response['status'] = 'added';
		}
		else
		{
			$price = $variantRow->price;
			if(!empty($product->apply_discount) && !empty($product->discount))
			{
				if ($product->discount_type == 'amount') $price = $price - $product->discount;
				else $price = $price - ($price * ($product->discount / 10000));
			}

			$priceToBeAdded = 0;
			if ($options) $priceToBeAdded = self::getOptionsPriceToBeAdded($price, $options);

			$price += $priceToBeAdded;

			// this product is not already in the cart, so simply add to cart up to the available stock
			if ($product->manage_stock && $amount <= $variantRow->stock)
			{

				$insert = self::addToCart_afresh($cart_id, $product->joomla_item_id, $variantRow->id, $options, $price, $amount);
				if (!$insert)
				{
					$response['status'] = 'ko';
					$response['error']  = 'There was an error adding to cart, AMOUNT LESS THAN STOCK'; // TODO - TRANSLATE

					return $response;
				}

			}
			else
			{
				//  only add up to the max amount that can be added
				$insert = self::addToCart_afresh($cart_id, $product->joomla_item_id, $variantRow->id, $options, $price, $amount);
				if (!$insert)
				{
					$response['status'] = 'ko';
					$response['error']  = 'There was an error adding to cart, ADDING STOCK'; // TODO - TRANSLATE

					return $response;
				}

			}

		}


		return $response;

	}

	/**
	 * @param   array  $variant_ids
	 *
	 *
	 * @return mixed|null
	 * @since 2.0
	 */

	private static function getVariantRow(array $variant_ids)
	{
		$variant_ids = implode(',', $variant_ids);

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__commercelab_shop_product_variant_data'))
			->where($db->quoteName('label_ids') . ' = ' . $db->quote($variant_ids));

		$db->setQuery($query);

		return $db->loadObject();
	}


	/**
	 * @param   Product     $product
	 * @param   int         $cart_id
	 * @param   int         $amount
	 * @param   array|null  $options
	 *
	 * @return array
	 *
	 * @throws UnknownCurrencyException
	 * @since 2.0
	 */

	public static function addNonVariantToCart(Product $product, int $cart_id, int $amount, array $options = null): array
	{

		// init response
		$response = [];

		//We need to check if an item with the same variant is already in the cart, so go get the cart item
		$cart_item = self::getCurrentCartItem($cart_id, $product->joomla_item_id, null, $options);

		//first, does current cart exist?
		if ($cart_item)
		{
			// now, check the current cart to see if the items are accounted for
			// doStockCompare returns the available stock as an int - or NULL if all stock is used up.
			$amountThatCanBeAdded = ($product->manage_stock) ? self::doStockCompare($product, $cart_item->id) : $amount;

			// $amountThatCanBeAdded will be NULL if nothing can be added, so we can do a boolean check here.
			if (!$amountThatCanBeAdded)
			{
				//all stock is added to cart already
				$response['status'] = 'ko';
				$response['error']  = Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_INVENTORY_ALL_STOCK_ADDED_TO_CART');

				return $response;
			}

			// check if the amount requested is lower than the amount possible
			if (self::addAmountToExistingCart($cart_item, $amountThatCanBeAdded)) $response['status'] = 'added';

			// Append remaioning Stock Information
			$response['amount_in_cart'] = ($cart_item->product->manage_stock) ? self::getTotalAmountProductFromCart($cart_item->joomla_item_id) : 0;
			$response['stock']          = $cart_item->product->stock;
		}
		else
		{
			//get price with options
			$priceToBeAdded = 0;
			if ($options) $priceToBeAdded = self::getOptionsPriceToBeAdded($product->final_price, $options);

			$product->final_price += $priceToBeAdded;

			// this product is not already in the cart, so simply add to cart up to the available stock
			if ($product->manage_stock && $amount <= $product->stock)
			{

				$insert = self::addToCart_afresh($cart_id, $product->joomla_item_id, 0, $options, $product->final_price, $amount);
				if (!$insert)
				{
					$response['status'] = 'ko';
					$response['error']  = 'There was an error adding to cart, AMOUNT LESS THAN STOCK'; // TODO - TRANSLATE

					return $response;
				}

			}
			else
			{
				//  only add up to the max amount that can be added
				$insert = self::addToCart_afresh($cart_id, $product->joomla_item_id, 0, $options, $product->final_price, $amount);
				if (!$insert)
				{
					$response['status'] = 'ko';
					$response['error']  = 'There was an error adding to cart, ADDING STOCK'; // TODO - TRANSLATE

					return $response;
				}

			}

			// Append remaioning Stock Information
			$response['amount_in_cart'] = ($product->manage_stock) ? self::getTotalAmountProductFromCart($product->joomla_item_id) : 0;
			$response['stock']          = $product->stock;

		}

		return $response;


	}


	/**
	 * @param   int         $cart_id
	 * @param   int         $itemid
	 * @param   int|null    $variant_id
	 * @param   array|null  $options
	 *
	 * @return CartItem|null
	 *
	 * @since 2.0
	 */


	private static function getCurrentCartItem(int $cart_id, int $itemid, int $variant_id = null, array $options = null): ?CartItem
	{

		$option_ids = [];
		if ($options)
		{
			foreach ($options as $option)
			{
				$option_ids[] = $option['id'];
			}
		}

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from($db->quoteName('#__commercelab_shop_cart_item'))
			->where($db->quoteName('cart_id') . ' = ' . $db->quote($cart_id))
			->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($itemid))
			->where($db->quoteName('variant_id') . ' = ' . $db->quote($variant_id))
			->where($db->quoteName('item_options') . ' = ' . $db->quote(implode(',', $option_ids)));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return new CartItem($result);
		}

		return null;
	}


	/**
	 * @param   int    $basePrice
	 * @param   array  $options
	 *
	 * @return int
	 *
	 * @since 2.0
	 */


	public static function getOptionsPriceToBeAdded(int $basePrice, array $options): int
	{
		$toBeAdded = 0;

		foreach ($options as $option)
		{
			if (isset($option['modifier_type']) && $option['modifier_type'] == 'perc')
			{
				$toBeAdded += (Utilities::getPercentOfNumber($basePrice, $option['modifier_value']) / 100);

			}
			if (isset($option['modifier_type']) && $option['modifier_type'] == 'amount')
			{
				$toBeAdded += $option['modifier_value'];
			}

		}

		return $toBeAdded;
	}

	/**
	 * @param   Product  $product
	 * @param   int      $cart_itemid
	 *
	 * @return int|null
	 *
	 * @since 1.5
	 */


	public static function doStockCompare(Product $product, int $cart_itemid): ?int
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('amount')
			->from($db->quoteName('#__commercelab_shop_cart_item'))
			->where($db->quoteName('id') . ' = ' . $db->quote($cart_itemid));

		$db->setQuery($query);

		$currentAmount = $db->loadResult();

		if ($currentAmount >= $product->stock)
		{
			return null;
		}
		else
		{
			return $product->stock - $currentAmount;
		}

	}

	/**
	 * @param   int  $variantStock
	 * @param   int  $cart_itemid
	 *
	 * @return int|null
	 *
	 * @since 2.0
	 */


	public static function doVariantStockCompare(int $variantStock, int $cart_itemid = null): ?int
	{

		if ($cart_itemid)
		{
			$db = Factory::getDbo();

			//get the current cart amount
			$query = $db->getQuery(true)
				->select('amount')
				->from($db->quoteName('#__commercelab_shop_cart_item'))
				->where($db->quoteName('id') . ' = ' . $db->quote($cart_itemid));

			$db->setQuery($query);

			$currentAmount = $db->loadResult();
		}
		else
		{
			$currentAmount = 0;
		}

		if ($currentAmount >= $variantStock)
		{
			return null;
		}
		else
		{
			return $variantStock - $currentAmount;
		}

	}

	/**
	 * @param   CartItem  $cart_item
	 * @param   int       $amountToBeAdded
	 *
	 *
	 * @since 1.5
	 */

	private static function addAmountToExistingCart(CartItem $cart_item, int $amountToBeAdded)
	{

		$object = new stdClass();

		$object->id     = $cart_item->id;
		$object->amount = ($cart_item->amount + $amountToBeAdded);

		return Factory::getDbo()->updateObject('#__commercelab_shop_cart_item', $object, 'id');
	}

	/**
	 * @param   int  $cartItemId
	 * @param   int  $newAmount
	 *
	 * @since 2.0
	 */

	private static function updateExistingCartAmount(int $cartItemId, int $newAmount)
	{

		$object = new stdClass();

		$object->amount = $newAmount;
		$object->id     = $cartItemId;

		return Factory::getDbo()->updateObject('#__commercelab_shop_cart_item', $object, 'id');

	}

	/**
	 * @param   int         $cart_id
	 * @param   int         $j_item_id
	 * @param   int|null    $variant_id
	 * @param   array|null  $options
	 * @param   int         $price
	 * @param   int         $amount
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	private static function addToCart_afresh(int $cart_id, int $j_item_id, ?int $variant_id, ?array $options, int $price, int $amount): bool
	{

		$option_ids = [];
		
		if ($options)
		{
			foreach ($options as $option)
			{
				$option_ids[] = $option['id'];
			}
		}
		$object = new stdClass();

		$object->id              = 0;
		$object->cart_id         = $cart_id;
		$object->joomla_item_id  = $j_item_id;
		$object->variant_id      = $variant_id;
		$object->item_options    = implode(',', $option_ids);
		$object->added           = Utilities::getDate();
		$object->amount          = $amount;
		$object->bought_at_price = $price;

		$insert = Factory::getDbo()->insertObject('#__commercelab_shop_cart_item', $object);

		if (!$insert)
		{
			return false;
		}

		return true;

	}


	/**
	 * @param   Cart  $cart
	 *
	 *
	 * @since 1.5
	 */

	public static function save(Cart $cart)
	{

		$object                      = new stdClass();
		$object->id                  = $cart->id;
		$object->user_id             = $cart->user_id;
		$object->cookie_id           = $cart->cookie_id;
		$object->coupon_id           = $cart->coupon_id;
		$object->billing_address_id  = $cart->billing_address_id;
		$object->shipping_address_id = $cart->shipping_address_id;

		Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');
	}


	/**
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */

	public static function isShippingRequired(): bool
	{
		$shipping_required = false;
		$cart_items        = self::getCartItems(self::getCurrentCartId());

		if (!$cart_items)
		{
			return false;
		}
		
		// If some Item in the cart has shipping enabled, we validate the entire Cart based on that
		foreach($cart_items as $cart_item)
		{
			if ($cart_item->product->shipping_mode != 'none')
			{
				$shipping_required = true;
				break;
			}
		}

		return $shipping_required;

	}

	public static function getCurrentCartAddress(string $address_type): ?Address
	{

		$db    = Factory::getDbo();

		// If Cart has a Saced Shipping
		$query = $db->getQuery(true)
			->select($address_type . '_address__id')
			->from($db->quoteName('#__commercelab_shop_cart'))
			->where($db->quoteName('id') . ' = ' . $db->quote(self::getCurrentCartId()));

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result)
		{
			return AddressFactory::get($result);
		}

		// If Cart has Tempo Shipping address
		$query = $db->getQuery(true);

		$query->select('id')
			->from($db->quoteName('#__commercelab_shop_cart_addresses'))
			->where($db->quoteName('cookie_id') . ' = ' . $db->quote(Utilities::getCookieID()))
			->where($db->quoteName('type') . ' = ' . $db->quote($address_type));

		$db->setQuery($query);

		$result = $db->loadResult();

		return ($result)
			? AddressFactory::get($result)
			: null;
			
	}


	/**
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */

	public static function getAssignedAddresses($cart_id = null )
	{
		$cart_id = ($cart_id) ? $cart_id : self::getCurrentCartId();
		
		$db = Factory::getDbo();

		return $db->setQuery(
			$db->getQuery(true)
				->select('shipping_address_id, billing_address_id')
				->from($db->quoteName('#__commercelab_shop_cart'))
				->where($db->quoteName('id') . ' = ' . (int) $cart_id)
		)->loadObject();

	}

	/**
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */

	public static function getTempAddress($address_id = null, $address_type = null)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('address_id')
			->from($db->quoteName('#__commercelab_shop_cart_addresses'))
			->where($db->quoteName('cookie_id') . ' = ' . $db->quote(Utilities::getCookieID()));

		if ($address_id) {
			$query->where($db->quoteName('address_id') . ' = ' . $db->quote($address_id));
		}

		if ($address_type) {
			$query->where($db->quoteName('type') . ' = ' . $db->quote($address_type));
		}

		$db->setQuery($query);

		$result = $db->loadObjectList();

		return ($result)
			? $result
			: false;

	}

	public static function setTempAddress(\CommerceLabShop\Address\Address $address, $both_types = null)
	{
		$db = Factory::getDbo();

		// Bind Address to Cart
		$cartAddressForInsert             = new stdClass();
		$cartAddressForInsert->id         = 0;
		$cartAddressForInsert->cookie_id  = Utilities::getCookieID();
		$cartAddressForInsert->address_id = $address->id;
		$cartAddressForInsert->type       = ($both_types) ? 'both' : $address->address_type;

		$insert = $db->insertObject('#__commercelab_shop_cart_addresses', $cartAddressForInsert);

		return ($insert) 
			? $address->id 
			: false;

		// $db = Factory::getDbo();

		// $query = $db->getQuery(true);

		// $query->select('address_id');
		// $query->from($db->quoteName('#__commercelab_shop_cart_addresses'));
		// $query->where($db->quoteName('cookie_id') . ' = ' . $db->quote(Utilities::getCookieID()));

		// if ($address_type) {
		// 	$query->where($db->quoteName('type') . ' = ' . $db->quote($address_type));
		// }

		// $db->setQuery($query);

		// $result = $db->loadObjectList();


	}


	/**
	 *
	 * Called when logging out to clear all remaining data
	 * Called when guest user clicks "Start Over"
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function destroyCartAddress(): bool
	{

		$db = Factory::getDbo();

		$object                      = new stdClass();
		$object->id                  = self::getCurrentCartId();
		$object->shipping_address_id = '0';
		$object->billing_address_id  = '0';

		return $db->updateObject('#__commercelab_shop_cart', $object, 'id');

	}

	/**
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function setBillingAsShipping(): bool
	{

		$currentCartId = self::getCurrentCartId();

		$object = new stdClass();

		$object->id                 = $currentCartId;
		$object->billing_address_id = AddressFactory::getCurrentShippingAddress()->id;

		return Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

	}


	/**
	 * @param   int     $address_id
	 * @param   string  $type
	 *
	 * @return bool|void
	 *
	 * @since 2.0
	 */


	// public static function setTempCartAddress(int $address_id, string $type): bool
	// {


	// 	$cart = self::get();

	// 	switch ($type)
	// 	{

	// 		case 'shipping':

	// 			$object = new stdClass();

	// 			$object->id                  = $cart->id;
	// 			$object->shipping_address_id = $address_id;

	// 			$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

	// 			if ($result)
	// 			{
	// 				return true;
	// 			}

	// 			return false;


	// 		case 'billing':

	// 			$object = new stdClass();

	// 			$object->id                 = $cart->id;
	// 			$object->billing_address_id = $address_id;

	// 			$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

	// 			if ($result)
	// 			{
	// 				return true;
	// 			}

	// 			return false;

	// 	}

	// 	return false;

	// }

	public static function setCartAddress(int $address_id, string $type): bool
	{

		$cart = self::get(self::getCurrentCartId());

		$object                          = new stdClass();

		$object->id                      = $cart->id;
		$object->{$type . '_address_id'} = $address_id;

		$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

		return $result;

		// switch ($type)
		// {

		// 	case 'shipping':

		// 		$object = new stdClass();

		// 		$object->id                  = $cart->id;
		// 		$object->shipping_address_id = $address_id;

		// 		$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

		// 		if ($result)
		// 		{
		// 			return true;
		// 		}

		// 		return false;


		// 	case 'billing':

		// 		$object = new stdClass();

		// 		$object->id                 = $cart->id;
		// 		$object->{$type . '_address_id'} = $address_id;

		// 		$result = Factory::getDbo()->updateObject('#__commercelab_shop_cart', $object, 'id');

		// 		if ($result)
		// 		{
		// 			return true;
		// 		}

		// 		return false;

		// }

	}


	public static function removeBillingAsShipping()
	{

		$db = Factory::getDbo();

		$object                     = new stdClass();
		$object->id                 = Cart::getCurrentCartId();
		$object->billing_address_id = 0;

		return ($db->updateObject('#__commercelab_shop_cart', $object, 'id')) 
			? 'ok' 
			: 'ko';

	}

	public static function removeAddress($address_type)
	{

		$db = Factory::getDbo();

		$object     = new stdClass();
		$object->id = self::getCurrentCartId();

		$object->{$address_type . "_address_id"} = 0;

		return $db->updateObject('#__commercelab_shop_cart', $object, 'id');

	}

	public static function removeTempAddress($address_id)
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('address_id') . " = " . $db->quote($address_id)
		);

		$query
			->delete($db->quoteName('#__commercelab_shop_cart_addresses'))
			->where($conditions);

		$db->setQuery($query);

		return $db->execute();

	}


	/**
	 *
	 * Function - getSubTotal
	 *
	 * Returns the subtotal for any given cart as an integer
	 * (Moved from Total in 1.6)
	 *
	 * @param   Cart  $cart
	 *
	 * @return int
	 * @since 2.0
	 */

	public static function getSubTotal(Cart $cart): int
	{

		// init total var at 0
		$total = 0;

		// iterate through the cart items and sum their totals.
		if ($results = $cart->cartItems)
		{
			// loop through the cart list
			foreach ($results as $result)
			{
				$total += (int) $result->totalCost;
			}

		}

		return $total;

	}

	public static function getSubTotalWithTax(Cart $cart): int
	{

		// init total var at 0
		$total = 0;

		// iterate through the cart items and sum their totals.
		if ($results = $cart->cartItems)
		{
			// loop through the cart list
			foreach ($results as $result)
			{
				$total += TaxFactory::getBrutPrice($result->totalCost, $result->product->taxclass);
			}

		}

		return $total;

	}


	public static function getSubTotalWithoutTax(Cart $cart): int
	{


		// init total var at 0
		$total = 0;

		// iterate through the cart items and sum their totals.
		if ($results = $cart->cartItems)
		{

			// loop through the cart list
			foreach ($results as $result)
			{
				$total += TaxFactory::getNetPrice($result->totalCost, $result->product->taxclass);
			}

		}

		return $total;

	}


	/**
	 * @param   Cart  $cart
	 *
	 * Returns the grand total for any given cart as an integer
	 * (Moved from Total in 1.6)
	 *
	 * @return int
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	public static function getTotalWithTax(Cart $cart): int
	{

		// get the current subtotal
		$total = self::getSubTotalWithTax($cart);

		// look to see if any coupons are applied
		$couponDiscount = CouponFactory::calculateDiscount($cart);

		// if the coupon discount is greater than the actual total,
		// then set the coupon discount top the value of the total to
		// avoid negative values.
		if ($couponDiscount > $total)
		{
			$couponDiscount = $total;
		}


		// now return the value (in int) of the total minus the discount total
		return ($total + $cart->totalShippingWithTax) - $couponDiscount;

	}

	public static function getTotalWithoutTax(Cart $cart): int
	{

		// get the current subtotal
		$total = self::getSubTotalWithoutTax($cart);

		// look to see if any coupons are applied
		$couponDiscount = CouponFactory::calculateDiscount($cart);

		// if the coupon discount is greater than the actual total,
		// then set the coupon discount top the value of the total to
		// avoid negative values.
		if ($couponDiscount > $total)
		{
			$couponDiscount = $total;
		}

		// now return the value (in int) of the total minus the discount total
		return ($total + $cart->totalShippingWithoutTax) - $couponDiscount;

	}

	public static function getGrandTotal(Cart $cart): int
	{

		// get the current subtotal
		$total = $cart->subtotalInt;

		// look to see if any coupons are applied
		$couponDiscount = CouponFactory::calculateDiscount($cart);

		// if the coupon discount is greater than the actual total,
		// then set the coupon discount top the value of the total to
		// avoid negative values.
		if ($couponDiscount > $total)
		{
			$couponDiscount = $total;
		}

		// now return the value (in int) of the total minus the discount total
		return ($total + $cart->totalShipping) - $couponDiscount;

	}

	/**
	 * @param   Cart  $cart
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function clearItems(Cart $cart): bool
	{

		$db = Factory::getDbo();

		$conditions = array(
			$db->quoteName('cart_id') . ' = ' . $db->quote($cart->id),
		);

		$query = $db->getQuery(true)
			->delete($db->quoteName('#__commercelab_shop_cart_item'))
			->where($conditions);

		$db->setQuery($query);
		$result = $db->execute();

		if ($result)
		{
			return true;
		}

		return false;

	}

	/**
	 * @param   Cart  $cart
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function clearCoupons(Cart $cart): bool
	{

		$db = Factory::getDbo();

		$conditions[] = $db->quoteName('cookie_id') . ' = ' . $db->quote($cart->cookie_id);

		$query = $db->getQuery(true)
			->delete($db->quoteName('#__commercelab_shop_coupon_cart'))
			->where($conditions);
			
		$db->setQuery($query);
		$result = $db->execute();

		if ($result)
		{
			return true;
		}

		return false;

	}


	/**
	 * function convertToOrder()
	 *
	 * Call this function from the payment plugin. It simply turns the Cart object into an order in CommerceLab Shop.
	 *
	 * Deprecated 2.0 use OrderFactory::createOrderFromCart() instead
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @deprecated  2.0
	 * @since       1.0
	 */

	// This one is working - why we have the same type of methid in Order Factory?
	public static function convertToOrder($paymentMethod, $shippingMethod = 'default', $vendorToken = '', $sendEmail = false)
	{
		$defaultcurrency = CurrencyFactory::getDefault();
		$currencyHelper  = new Currency($defaultcurrency);
		$date            = Utilities::getDate();
		$cookie_id       = Utilities::getCookieID();
		$customer        = CustomerFactory::get();

		// Convert User to Customer
		if (is_null($customer))
		{
			$customer = CustomerFactory::create();
		}

		// TODO - Save Address Optional
		$save_addresses  = false;

		$cart = self::get();
		$db   = Factory::getDbo();

		// Build Order Object
		$object              = new stdClass();
		$object->id          = 0;
		$object->customer_id = null;

		if ($customer)
		{
			$object->customer_id = $customer->id;
		}
		else
		{
			$object->guest_pin = $cookie_id;
		}

		$object->order_date     = $date;
		$object->order_number   = OrderFactory::getNextOrderNumber(true);
		$object->order_paid     = 0;
		$object->order_status   = 'P';
		
		$object->tax_total      = TaxFactory::getTotalTax($cart);
		$object->shipping_total = Shipping::getTotalShippingFromPlugin($cart);
		$object->order_subtotal = self::getSubTotal($cart);
		$object->order_total    = self::getTotalWithTax($cart);

		$object->currency            = $currencyHelper->iso;
		$object->payment_method      = $paymentMethod;
		$object->vendor_token        = $vendorToken;
		$object->billing_address_id  = $cart->billing_address_id;
		$object->shipping_address_id = $cart->shipping_address_id;
		$object->published           = 1;

		if ($coupon = CouponFactory::isCouponApplied())
		{
			$object->discount_code = $coupon->couponcode;
		}

		$object->discount_total = CouponFactory::calculateDiscount($cart);

		if ($currentNote = CheckoutnoteFactory::getCurrentNote())
		{
			$object->customer_notes = $currentNote->note;
		}
		else
		{
			$object->customer_notes = '';
		}

		$result  = $db->insertObject('#__commercelab_shop_order', $object);
		$orderID = $db->insertid();

		// now set the order items
		$cartItems = $cart->cartItems;
		
		foreach ($cartItems as $cartItem)
		{
			$object                = new stdClass();
			$object->id            = 0;
			$object->order_id      = $orderID;
			$object->j_item        = $cartItem->joomla_item_id;
			$object->j_item_cat    = $cartItem->product->joomlaItem->catid;
			$object->j_item_name   = $cartItem->product->joomlaItem->title;
			$object->item_options  = json_encode($cartItem->selected_options);
			$object->variant_id    = ($cartItem->selected_variant) ? $cartItem->selected_variant->id : null;
			$object->price_at_sale = ($cartItem->selected_variant) ? $cartItem->selected_variant->price : $cartItem->product->final_price;
			$object->amount        = $cartItem->amount;

			$result = $db->insertObject('#__commercelab_shop_order_products', $object);

			if ($cartItem->manage_stock_enabled == 1)
			{

				$currentStock  = ProductFactory::getCurrentStock($cartItem->product->id);
				$newStockLevel = ($currentStock - $cartItem->amount);

				if ($newStockLevel <= 0)
				{
					$newStockLevel = 0;
				}

				$stockUpdate        = new stdClass();
				$stockUpdate->id    = $cartItem->product->id;
				$stockUpdate->stock = $newStockLevel;

				$db->updateObject('#__commercelab_shop_product', $stockUpdate, 'id');
			}

		}

		if ($save_addresses) {
			// Save Addresses - if set so
			if ($cart->billing_address_id) {
				$billingAddressUpdate             = new stdClass();
				$billingAddressUpdate->id         = $cart->billing_address_id;
				$billingAddressUpdate->customerid = $customer->id;

				$db->updateObject('#__commercelab_shop_customer_address', $billingAddressUpdate, 'id');
			}
			if ($cart->shipping_address_id) {
				$shippinggAddressUpdate             = new stdClass();
				$shippinggAddressUpdate->id         = $cart->shipping_address_id;
				$shippinggAddressUpdate->customerid = $customer->id;

				$db->updateObject('#__commercelab_shop_customer_address', $shippinggAddressUpdate, 'id');
			}
		}

		CartFactory::clearCart(CartFactory::get()->id, Utilities::getCookieID());

		//Clear coupons
		$query        = $db->getQuery(true);
		$conditions[] = $db->quoteName('cookie_id') . ' = ' . $db->quote($cookie_id);

		$query->delete($db->quoteName('#__commercelab_shop_coupon_cart'))
			->where($conditions);

		$db->setQuery($query);
		$db->execute();

		if ($sendEmail)
		{

			try { // To send an email

				// get the plugin functions
				PluginHelper::importPlugin('commercelab_shop_system');
				Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['created', $orderID]);

			}
			catch (Exception $e)
			{	
				new Orderlog(false, $orderID, $e->getMessage());

			}

		}

		new Orderlog(false, $orderID, Text::_('COM_COMMERCELAB_SHOP_ORDER_IS_CREATED_LOG'));

		if ($result)
		{
			try {
				PluginHelper::importPlugin('commercelab_shop_system');
				Factory::getApplication()->triggerEvent('onOrderCreated', [$orderID]);
			} catch (Exception $e) {
				
			}
			return $orderID;
		}

	}

	/**
	 * @param $seed
	 *
	 * @return string
	 *
	 * @since 1.0
	 */


	public static function clearCart($cart_id, $cookie_id)
	{
		$db = Factory::getDbo();

		// Clear the cart
		$query = $db->getQuery(true)
			->delete($db->quoteName('#__commercelab_shop_cart_item'))
			->where($db->quoteName('cart_id') . ' = ' . $db->quote($cart_id));

		$db->setQuery($query);
		$db->execute();

		// Save the cart
		$cartStateUpdate        = new stdClass();
		$cartStateUpdate->id    = $cart_id;
		$cartStateUpdate->state = 1;

		$db->updateObject('#__commercelab_shop_cart', $cartStateUpdate, 'id');

		// Clear the guest cart
		// if (!$customer)
		$query = $db->getQuery(true)
			->delete($db->quoteName('#__commercelab_shop_cart_addresses'))
			->where($db->quoteName('cookie_id') . ' = ' . $db->quote($cookie_id));

		$db->setQuery($query);
		$db->execute();
	}

	private static function _generateOrderId($seed): string
	{

		$config    = new ConfigFactory;
		$configcls = $config->get();

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
