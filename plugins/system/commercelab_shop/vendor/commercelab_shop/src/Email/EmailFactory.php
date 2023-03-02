<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Email;

// no direct access
defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;
use Joomla\Input\Input;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Access\Access;
use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Order\Order;
use CommerceLabShop\Customer\Customer;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Customer\CustomerFactory;
use CommerceLabShop\Emaillog\EmaillogFactory;
use CommerceLabShop\Language\LanguageFactory;

use stdClass;


class EmailFactory
{


	/**
	 *
	 * Gets the discount based on the given ID.
	 *
	 * @param   int  $id
	 *
	 * @return Email
	 *
	 * @since 2.0
	 */

	public static function get(int $id): ?Email
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_email'));


		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));


		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{

			return new Email($result);
		}

		return null;

	}


	/**
	 * @param   int          $limit
	 * @param   int          $offset
	 * @param   string|null  $searchTerm
	 * @param   string|null  $type
	 * @param   string       $language
	 * @param   string       $orderBy
	 * @param   string       $orderDir
	 *
	 *
	 * @return array
	 * @since 2.0
	 */

	public static function getList(int $limit = 0, int $offset = 0, string $searchTerm = null, string $type = null, string $language = '', string $orderBy = 'id', string $orderDir = 'DESC'): ?array
	{

		// init items
		$items = array();

		// get the Database
		$db = Factory::getDbo();

		// set initial query
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_email'));


		// if there is a search term, iterate over the columns looking for a match
		if ($searchTerm)
		{
			$query->where($db->quoteName('subject') . ' LIKE ' . $db->quote('%' . $searchTerm . '%'));
		}

		if ($type)
		{
			$query->where($db->quoteName('emailtype') . ' = ' . $db->quote($type));

		}

		if ($language)
		{
			$query->where('(' . $db->quoteName('language') . ' = ' . $db->quote($language) . ' OR ' . $db->quoteName('language') . ' = ' . $db->quote('*') . ')');

		}

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query, $offset, $limit);

		$results = $db->loadObjectList();

		// only proceed if there's any rows
		if ($results)
		{
			// iterate over the array of objects, initiating the Class.
			foreach ($results as $result)
			{
				$items[] = new Email($result);

			}

			return $items;
		}

		return null;

	}


	/**
	 * @param $emailType
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	public static function emailTypeToString($emailType): string
	{

		LanguageFactory::load();

		switch ($emailType)
		{
			case 'created':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_THANK_YOU');

			case 'pending':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_PENDING');

			case 'confirmed':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_CONFIRMED');

			case 'cancelled':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_CANCELLED');

			case 'refunded':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_REFUNDED');

			case 'created':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_CREATED');

			case 'shipped':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_SHIPPED');

			case 'completed':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_COMPLETED');

			case 'denied':
				return Text::_('COM_COMMERCELAB_SHOP_EMAILTYPE_DENIED');

			default:
				return Text::_('');
		}

	}

	/**
	 * @param   string  $language
	 *
	 * @return string
	 *
	 * @since 2.0
	 */

	public static function getLanguageImageString(string $language): string
	{

		return strtolower(str_replace('-', "_", $language));

	}


	/**
	 * @param   Input  $data
	 *
	 *
	 * @since 2.0
	 */

	public static function togglePublishedFromInputData(Input $data)
	{

		$db = Factory::getDbo();

		$items = json_decode($data->getString('items'));


		foreach ($items as $item)
		{

			$query = 'UPDATE ' . $db->quoteName('#__commercelab_shop_email') . ' SET ' . $db->quoteName('published') . ' = IF(' . $db->quoteName('published') . '=1, 0, 1) WHERE ' . $db->quoteName('id') . ' = ' . $db->quote($item->id) . ';';
			$db->setQuery($query);
			$db->execute();

		}

	}


	/**
	 * @param   Input  $data
	 *
	 *
	 * @return Email
	 * @since 2.0
	 */


	public static function saveFromInputData(Input $data)
	{

		if ($id = $data->json->getInt('itemid', null))
		{


			$current = self::get($id);

			$current->to          = $data->json->getString('to', $current->to);
			$current->subject     = $data->json->getString('subject', $current->subject);
			$current->body        = $data->json->get('body', $current->body, 'RAW');
			$current->emailtype   = $data->json->getString('emailtype', $current->emailtype);
			$current->language    = $data->json->getString('language', $current->language);
			$current->published   = $data->json->getInt('published', $current->published);
			$current->modified    = Utilities::getDate();
			$current->modified_by = Factory::getUser()->id;

			if (self::commitToDatabase($current))
			{
				return $current;
			}

		}
		else
		{

			if ($item = self::createFromInputData($data))
			{
				return $item;
			}

		}

		return null;

	}

	/**
	 * @param   Email  $item
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */


	private static function commitToDatabase(Email $item): bool
	{

		$db = Factory::getDbo();

		$insert = new stdClass();

		$insert->id          = $item->id;
		$insert->to          = $item->to;
		$insert->subject     = $item->subject;
		$insert->emailtype   = $item->emailtype;
		$insert->body        = $item->body;
		$insert->language    = $item->language;
		$insert->published   = $item->published;
		$insert->modified    = $item->modified;
		$insert->modified_by = $item->modified_by;

		$result = $db->updateObject('#__commercelab_shop_email', $insert, 'id');

		if ($result)
		{
			return true;
		}

		return false;

	}


	/**
	 * @param   Input  $data
	 *
	 * @return Email|bool
	 *
	 * @since 2.0
	 */


	private static function createFromInputData(Input $data): Email
	{

		$db = Factory::getDbo();

		$item              = new stdClass();
		$item->to          = $data->json->getString('to');
		$item->subject     = $data->json->getString('subject');
		$item->emailtype   = $data->json->getString('emailtype');
		$item->body        = $data->json->get('body', '', 'RAW');
		$item->language    = $data->json->getString('language');
		$item->published   = $data->json->getInt('published');
		$item->created     = Utilities::getDate();
		$item->created_by  = Factory::getUser()->id;
		$item->modified    = Utilities::getDate();
		$item->modified_by = Factory::getUser()->id;


		$result = $db->insertObject('#__commercelab_shop_email', $item);

		if ($result)
		{
			return self::get($db->insertid());
		}

		return false;

	}



	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function trashFromInputData(Input $data): bool
	{

		$db = Factory::getDbo();

		$items = $data->json->get('items', '', 'ARRAY');


		foreach ($items as $item)
		{
			$query      = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($item['id'])
			);
			$query->delete($db->quoteName('#__commercelab_shop_email'));
			$query->where($conditions);
			$db->setQuery($query);
			$db->execute();

		}

		return true;

	}

	/**
	 * @param   string  $type
	 * @param   int     $order_id
	 *
	 * @param   string  $layout
	 * @param   string  $plugin
	 *
	 * @return void
	 *
	 * @throws \Exception
	 * @since 2.0
	 */


	public static function send(string $type, int $order_id, string $layout, string $plugin)
	{
		// init the mailer
		$mailer = Factory::getMailer();
		$config = Factory::getConfig();

		// load CLS language strings
		Factory::getLanguage()->load('com_commercelab_shop', JPATH_ADMINISTRATOR);

        /**
         * Look for user language for emails. Priority:
         *  1. User saved language
         *  2. Default Front end language 
         */
		$userParams = new Registry(Factory::getUser()->get('params'));
		$userLocale = $userParams->get('language', ComponentHelper::getParams('com_languages')->get('site'));

		// grab the order and the customer
		$order = OrderFactory::get($order_id);

		if ($order->customer_id) {
			$customer = CustomerFactory::get($order->customer_id);
		} else {
			$customer = null;
		}

		$response = [];

		// get the emails that needs to be sent
		$emails = self::getList(0, 0, null, $type, $userLocale);

		if ($emails)
		{

			foreach ($emails as $email)
			{

				$sender = [
					$config->get('mailfrom'),
					$config->get('fromname')
				];

				$mailer->setSender($sender);

				// Replace Shortcodes for Email To
				if ($email->to)
				{
					$email->to = self::processReplacements($email->to, $order, $customer);
					$emailto   = explode(',', $email->to);
					$mailer->addRecipient($emailto);
				}
				else
				{
					$emailto = [$order->billing_address->email];
					$mailer->addRecipient($emailto);
				}

				$text = self::processReplacements($email->body, $order, $customer);

				$params = ConfigFactory::get();

				$displayData = ['order' => $order, 'body' => $text, 'config' => $params];

				$body = LayoutHelper::render($layout, $displayData, JPATH_PLUGINS . '/commercelab_shop_system/' . $plugin . '/tmpl');

				$mailer->setSubject(self::processReplacements($email->subject, $order, $customer));
				$mailer->isHtml(true);
				$mailer->setBody($body);

				$send = $mailer->Send();

				if ($send)
				{
					// Log Sucesseverything
					EmaillogFactory::log(implode(',', $emailto), $type, $order->customer_id, $order->id);

					OrderFactory::log(
						$order->id,
						Text::sprintf('COM_COMMERCELAB_SHOP_ORDER_EMAIL_SENT_LOG', ucfirst($type), implode(',', $emailto), (Factory::getUser()->name ? Factory::getUser()->name : 'Joomla'))
					);

				}
				else
				{
					// Log if Failed
					EmaillogFactory::log(implode(',', $emailto), $type, $order->customer_id, $order->id, $send);
				}

				$response[] = $send;
			}

			return $response;

		}

		return ['No Emails Found' => $emails, 'type' => $type, 'languageTag' => $languageTag];
	}

	/**
	 * @param   string    $text
	 * @param   Order     $order
	 * @param   Customer  $customer
	 *
	 * @return string
	 *
	 * @since 2.0
	 */


	private static function processReplacements(string $text, Order $order, Customer $customer = null): string
	{

		$config = Factory::getConfig();
		$access = new Access;

		// global
		$text = str_replace('{site_name}', $config->get('fromname'), $text);
		$text = str_replace('{admin_email}', $config->get('mailfrom'), $text);

		// shop
		$text = str_replace('{shop_name}', ComponentHelper::getParams('com_commercelab_shop')->get('shop_name', ''), $text);
		$text = str_replace('{shop_logo}', Uri::root() . ComponentHelper::getParams('com_commercelab_shop')->get('shop_logo', ''), $text);
		$text = str_replace('{shop_brandcolour}', ComponentHelper::getParams('com_commercelab_shop')->get('shop_brandcolour', ''), $text);

		$shop_mail = ComponentHelper::getParams('com_commercelab_shop')->get('supportemail', '');
		if ($shop_mail == '')
		{

			$super_users = [];
			foreach ($access->getUsersByGroup(8) as $key => $user_id) {
				$user          = Factory::getUser($user_id);
				$super_users[] = $user->email;
			}
			$shop_mail = implode(',', $super_users);
		}

		$text = str_replace('{shop_email}', $shop_mail, $text);

		// order
		$search= [
			'{order_number}',
			'{order_grand_total}',
			'{order_subtotal}',
			'{order_currency_symbol}',
			'{order_payment_method}',
			'{order_date}'
		];
		$replace = [
			$order->order_number,
			$order->order_total_formatted,
			$order->order_subtotal_formatted,
			$order->currency,
			(($order->payment_method == 'Offline Pay') 
				? Text::_('COM_COMMERCELAB_SHOP_OFFLINE_PAYMENT') 
				: $order->payment_method),
			$order->order_date
		];

		$text = str_replace($search, $replace, $text);

		if ($order->shipping_total)
		{
			$text = str_replace('{order_shipping_total}', $order->shipping_total_formatted, $text);
		} else {
			$text = str_replace('{order_shipping_total}', '', $text);
		}

		// tracking
		$text = str_replace('{tracking_code}', $order->tracking_code, $text);
		$text = str_replace('{tracking_url}', $order->tracking_link, $text);

		// customer
		if ($customer && $customer->name)
		{
			$text = str_replace('{customer_name}', $customer->name, $text);
		}
		else if ($order->billing_address && ($order->billing_address->first_name || $order->billing_address->last_name))
		{
			$text = str_replace('{customer_name}', $order->billing_address->first_name . ' ' . $order->billing_address->last_name, $text);
		}
		else if ($order->shipping_address && $order->shipping_address->first_name . ' ' . $order->shipping_address->last_name)
		{
			$text = str_replace('{customer_name}', $order->shipping_address->first_name . ' ' . $order->shipping_address->last_name, $text);
		}
		else
		{
			$text = str_replace('{customer_name}', '', $text);
		}

		if ($customer && $customer->email)
		{
			$text = str_replace('{customer_email}', $customer->email, $text);
		}
		else if ($order->billing_address && $order->billing_address->email)
		{
			$text = str_replace('{customer_email}', $order->billing_address->email, $text);
		}
		else if ($order->shipping_address && $order->shipping_address->email)
		{
			$text = str_replace('{customer_email}', $order->shipping_address->email, $text);
		}
		else
		{
			$text = str_replace('{customer_email}', '', $text);
		}

		if ($customer && $customer->total_orders)
		{
			$text = str_replace('{customer_order_count}', $customer->total_orders, $text);
		}
		else
		{
			$text = str_replace('{customer_order_count}', '', $text);
		}


		if ($order->shipping_address)
		{
			// shipping
			$search = [
				'{shipping_first_name}', 
				'{shipping_last_name}', 
				'{shipping_address1}',
				'{shipping_address2}',
				'{shipping_address3}',
				'{shipping_city}',
				'{shipping_state}',
				'{shipping_country}',
				'{shipping_postcode}',
				'{shipping_email}',
				'{shipping_postcode}',
				'{shipping_mobile}',
				'{shipping_phone}',

			];
			$replace = [
				$order->shipping_address->first_name,
				$order->shipping_address->last_name, 
				$order->shipping_address->address1,
				$order->shipping_address->address2,
				$order->shipping_address->address3,
				$order->shipping_address->city,
				$order->shipping_address->zone_name,
				$order->shipping_address->country_name,
				$order->shipping_address->postcode,
				$order->shipping_address->email,
				$order->shipping_address->postcode,
				$order->shipping_address->mobile_phone,
				$order->shipping_address->phone
			];

			$text = str_replace($search, $replace, $text);
		}


		if ($order->billing_address)
		{

			$search = [
				'{billing_first_name}',
				'{billing_last_name}',
				'{billing_address1}',
				'{billing_address2}',
				'{billing_address3}',
				'{billing_city}',
				'{billing_state}',
				'{billing_country}',
				'{billing_postcode}',
				'{billing_email}',
				'{billing_postcode}',
				'{billing_mobile}',
				'{billing_phone}',
				'{billing_vat}',
				'{billing_company_name}'
			];

			$replace = [
				$order->billing_address->first_name,
				$order->billing_address->last_name,
				$order->billing_address->address1,
				$order->billing_address->address2,
				$order->billing_address->address3,
				$order->billing_address->city,
				$order->billing_address->zone_name,
				$order->billing_address->country_name,
				$order->billing_address->postcode,
				$order->billing_address->email,
				$order->billing_address->postcode,
				$order->billing_address->mobile_phone,
				$order->billing_address->phone,
				$order->billing_address->vat,
				$order->billing_address->company_name
			];
			
			// billing
			$text = str_replace($search, $replace, $text);

		}


		return $text;

	}


}
