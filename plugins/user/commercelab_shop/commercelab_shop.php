<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;


use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Cart\CartFactory;


/**
 * Joomla User plugin
 *
 * @since  1.5
 */
class PlgUserCommercelab_shop extends JPlugin
{

	public function onUserAfterSave($user, $isnew, $success, $msg)
	{

		$db = Factory::getDbo();


		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_customer'));
		$query->where($db->quoteName('email') . ' = ' . $db->quote($user['email']));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			// user is a customer - run update

			$object            = new stdClass();
			$object->j_user_id = $user['id'];
			$object->email     = $user['email'];
			$object->name      = $user['name'];
			$object->published = 1;
			$object->modified  = Utilities::getDate();

			$db->updateObject('#__commercelab_shop_customer', $object, 'email');

		}
		else
		{
			// user is not a customer - run insert

			// $object            = new stdClass();
			// $object->id        = 0;
			// $object->j_user_id = $user['id'];
			// $object->email     = $user['email'];
			// $object->name      = $user['name'];
			// $object->published = 1;
			// $object->created   = Utilities::getDate();

			// $db->insertObject('#__commercelab_shop_customer', $object);
		}


	}


	/**
	 * function onUserLogin
	 *
	 * Aim:
	 *
	 * 1) We need to make sure that newly logged in customers are setup in the P2S customers table.
	 * 2) We need to move all cookie reference cart items over to the user to make sure the items stay in the cart after login
	 * 3) We need to "mop up" any previous guest orders using this email address and associate them with this user
	 *
	 *
	 * @param          $user
	 * @param   array  $options
	 *
	 * @throws Exception
	 */

	public function onUserLogin($user, $options = array())
	{

		if (Factory::getApplication()->isClient('site')) 
		{
			$cookieid = Utilities::getCookieID();

			if ($cookieid)
			{

				$db = Factory::getDbo();


				/**
				 *
				 * AIM 1 - set the user in the customer db
				 *
				 */

				// check if user is a customer
				$query = $db->getQuery(true);

				$query->select('*');
				$query->from($db->quoteName('#__commercelab_shop_customer'));
				$query->where($db->quoteName('email') . ' = ' . $db->quote($user['email']));

				$db->setQuery($query);

				$result = $db->loadObject();

				$userid = $this->_getUserId($user['email']);

				if ($result)
				{
					// user is a customer - run update

					$object            = new stdClass();
					$object->email     = $user['email'];
					$object->name      = $user['fullname'];
					$object->published = 1;
					$object->modified  = Utilities::getDate();

					$db->updateObject('#__commercelab_shop_customer', $object, 'email');

				}
				else
				{
					// // user is not a customer - run insert

					// $object            = new stdClass();
					// $object->id        = 0;
					// $object->j_user_id = $userid;
					// $object->email     = $user['email'];
					// $object->name      = $user['fullname'];
					// $object->published = 1;
					// $object->created   = Utilities::getDate();

					// $db->insertObject('#__commercelab_shop_customer', $object);


				}

				/**
				 *
				 * Aim 2 - Mop up the guest orders associated with this email address
				 *
				 */

				// now check the emails on guest orders and associate them if not.
				$this->mopGuestOrders($userid, $user['email']);

				/**
				 *
				 * Aim 3 - move all cart items over to the logged in user
				 *
				 */

				//also move all guest cart items to logged in cart items.
				$this->convertGuestCarts($userid, $cookieid);

			}
		}

	}


	public function onUserLogout($user, $options = array())
	{


		// To prevent the guest checkout from showing addresses after logout,
		// make sure to remove all cart addresses and the cookie.

//        Cart::destroyCookie();

		return true;

	}

	public function onUserAfterDelete($user, $success, $msg)
	{


		$db = Factory::getDbo();

		// check if user is a customer
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_customer'));
		$query->where($db->quoteName('email') . ' = ' . $db->quote($user['email']));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{

			$query = $db->getQuery(true);

			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($result->id)
			);

			$query->delete($db->quoteName('#__commercelab_shop_customer'));
			$query->where($conditions);

			$db->setQuery($query);

			$db->execute();


		}


	}


	private function _getUserId($email)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__users'));
		$query->where($db->quoteName('email') . ' = ' . $db->quote($email));

		$db->setQuery($query);

		return $db->loadResult();

	}


	/**
	 *
	 * mopGuestOrders
	 * If we find that there are orders that can belong to the Clintd, we assing them
	 * Only THose that the Cookie Match, the email based ones, require an email to be verified
	 * and we could offer them as an extra option from the backend
	 *
	 *
	 * since 1.1.0
	 */

	private function mopGuestOrders($userid, $user_email)
	{

		// Get the DB
		$db = Factory::getDbo();

		// now get all orders with a costomerid of '0'
		$query = $db->getQuery(true);

		$query->select('id')
			->from($db->quoteName('#__commercelab_shop_order'))
			->where($db->quoteName('customer_id') . ' = 0');

		$db->setQuery($query);

		$guestOrders = $db->loadColumn();

		foreach ($guestOrders as $guestOrder)
		{

			$order = OrderFactory::get($guestOrder);

			// Add orders Based on Cookie
			if (ComponentHelper::getParams('com_commercelab_shop')->get('append_guest_orders_to_user', 1) && $order->guest_pin == Utilities::getCookieID())
			{
				// Add Customer to Order
				$order->customer_id = Utilities::getCustomerIdByCurrentUserId($userid);
				$saved              = OrderFactory::updateCustomer($order);
			}

		}

	}


	/**
	 *
	 * convertGuestCarts
	 *
	 * @param $userid
	 *
	 * @since 1.1.0
	 */


	private function convertGuestCarts($userid, $cookieid)
	{
		// Get the DB
		$db = Factory::getDbo();


		//first, get the id of the cart with this userid, if not found, create one.

		$query = $db->getQuery(true);

		$query->select('id')
			->from($db->quoteName('#__commercelab_shop_cart'))
			->where($db->quoteName('user_id') . ' = ' . $db->quote($userid))
			->order('id DESC');

		$db->setQuery($query);

		$cartRowFromUserId = $db->loadResult();

		if (!$cartRowFromUserId) // If there was no previous cart for the user, we convert the guest cart to user cart
		{
			// Add user id to existing cart
			$db->setQuery(
				$db->getQuery(true)
					->select('id')
					->from($db->quoteName('#__commercelab_shop_cart'))
					->where($db->quoteName('cookie_id') . ' = ' . $db->quote($cookieid))
					->where($db->quoteName('state') . ' = ' . $db->quote(0))
					->order('id DESC')
			);

			$cart          = new stdClass();
			$cart->id      = $db->loadResult();
			$cart->user_id = $userid;
			$cart->guest   = null;

            $db->updateObject('#__commercelab_shop_cart', $cart, 'id');

		}
		else // Move the Guest Cart to existing user cart
		{

			$cartRowFromCookieId = CartFactory::getCartIdByCookie($cookieid);

			if (!$cartRowFromCookieId) return;

			// Get all Cart Items from the Guest
			$db->setQuery(
				$db->getQuery(true)
					->select('id, variant_id, amount, joomla_item_id')
					->from($db->quoteName('#__commercelab_shop_cart_item'))
					->where($db->quoteName('cart_id') . ' = ' . $db->quote($cartRowFromCookieId))
			);

			$guest_cart_items = $db->loadObjectList();

			$db->setQuery(
				$db->getQuery(true)
					->select('id, variant_id, amount, joomla_item_id')
					->from($db->quoteName('#__commercelab_shop_cart_item'))
					->where($db->quoteName('cart_id') . ' = ' . $db->quote($cartRowFromUserId))
			);

			$user_cart_items = $db->loadObjectList();
			
			foreach ($guest_cart_items as $guest_cart_item)
			{
				foreach ($user_cart_items as $user_cart_item)
				{
					// User already have that item
					if ($user_cart_item->joomla_item_id == $guest_cart_item->joomla_item_id
						&& (!$guest_cart_item->variant_id && !$user_cart_item->variant_id
							|| $guest_cart_item->variant_id == $user_cart_item->variant_id
						)
					) // Identical same item
					{
						// Add amount only to user item
						$db->setQuery(
							$db->getQuery(true)
								->update($db->quoteName('#__commercelab_shop_cart_item'))
								->set([
									$db->quoteName('amount') . ' = ' . $db->quote((int) $guest_cart_item->amount + (int) $user_cart_item->amount)
								])
								->where([
									$db->quoteName('id') . ' = ' . $db->quote($user_cart_item->id)
								])
						)->execute();

						// Remove guest item
						$db->setQuery(
							$db->getQuery(true)
								->delete($db->quoteName('#__commercelab_shop_cart_item'))
								->where($db->quoteName('id') . ' = ' . $db->quote($guest_cart_item->id))
						)->execute();
					}
					else // Convert Guest item to User Cart
					{
						$db->setQuery(
							$db->getQuery(true)
								->update($db->quoteName('#__commercelab_shop_cart_item'))
								->set([
									$db->quoteName('cart_id') . ' = ' . $db->quote($cartRowFromUserId)
								])
								->where([
									$db->quoteName('id') . ' = ' . $db->quote($guest_cart_item->id)
								])
						);

						$db->execute();
					}
				}
			}

			CartFactory::finalizeGuestCart($cartRowFromCookieId);
			
			// // Add assigned addresses, if any
			// $addresses = CartFactory::getAssignedAddresses($cartRowFromCookieId);

			// $fields = [];
			// if ($addresses->billing_address_id)
			// {
			// 	$fields[] = $db->quoteName('billing_address_id') . ' = ' . $db->quote($addresses->billing_address_id);
			// }

			// if ($addresses->shipping_address_id)
			// {
			// 	$fields[] = $db->quoteName('shipping_address_id') . ' = ' . $db->quote($addresses->shipping_address_id);
			// }
			
			// if (!empty($fields))
			// {
			// 	$db->setQuery(
			// 		$db->getQuery(true)
			// 			->update($db->quoteName('#__commercelab_shop_cart'))
			// 			->set($fields)
			// 			->where([
			// 				$db->quoteName('id') . ' = ' . $db->quote($cartRowFromUserId)
			// 			])
			// 	);

			// 	$db->execute();
			// }

			// // change state of previous Cart
			// $db->setQuery(
			// 	$db->getQuery(true)
			// 		->update($db->quoteName('#__commercelab_shop_cart'))
			// 		->set([
			// 			$db->quoteName('state') . ' = ' . $db->quote(2),
			// 			$db->quoteName('converted') . ' = ' . $db->quote(Utilities::prepareDateToSave())
			// 		])
			// 		->where([
			// 			$db->quoteName('id') . ' = ' . $db->quote($cartRowFromCookieId)
			// 		])
			// );

			// $db->execute();

		}

		return true;

	}

// 			// Email Based, but we need the user to Confirm his email first
// 			// if ($order->billingEmail == $user_email)
// 			if (false) {


// 				// THIS IS OLD WAY TOO - NEED TO MOVE TO THE ORDERFACTORY
// 				$order->save();




// //				Old way
// //                $addressToUpdate->setCustomerId($order->customerid);

// 				if (AddressFactory::saveAddress($addressToUpdate))
// 				{

// 				}
// //				Old way
// //                $addressToUpdate->save();

// 			}



		// // Billing Address
		// if (false)
		// // if (isset($order->billing_address_id))
		// {
		// 	$address = AddressFactory::get($order->billing_address_id);

		// 	// Set Customer Address to Address
		// 	if (AddressFactory::setCustomerId($address, $order->customerid))
		// 	{

		// 	}

		// 	// 
		// 	if (AddressFactory::saveAddress($addressToUpdate))
		// 	{

		// 	}
		// }


}
