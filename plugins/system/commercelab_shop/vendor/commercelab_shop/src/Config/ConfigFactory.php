<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


namespace CommerceLabShop\Config;

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Access\Exception\NotAllowed;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

use Exception;
use stdClass;


/**
 * @package     CommerceLabShop\Config
 *
 *              Wrapper for the native Joomla path for retrieving component config. Serves only to keep client code neat!
 *              Simple call:
 *              $config = ConfigFactory::get();
 *              $config->get('node');
 *
 * @since       1.6
 */
class ConfigFactory
{

	/**
	 * @return Registry
	 * @throws Exception
	 * @since 2.0
	 */

	public static function get(): Registry
	{
		return ComponentHelper::getParams('com_commercelab_shop');
	}

	public static function updateComponentParams(string $param_name, string $param_value): bool
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select($db->quoteName('params'))
			->from($db->quoteName('#__extensions'))
			->where($db->quoteName('element') . ' = ' . $db->quote('com_commercelab_shop'));

		$params = @json_decode($db->setQuery($query)->loadResult(), true);

		$params[$param_name] = $param_value;

		$query = $db->getQuery(true);

		// Fields to update.
		$fields = array(
		    $db->quoteName('params') . ' = ' . $db->quote(json_encode($params))
		);

		// Conditions for which records should be updated.
		$conditions = array(
		    $db->quoteName('element') . ' = ' . $db->quote('com_commercelab_shop')
		);

		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);

		$db->setQuery($query);
		return $db->execute();

	}


	public static function getVersion()
	{
		$component = ComponentHelper::getComponent('com_commercelab_shop');
		$extension = Table::getInstance('extension');
		$extension->load($component->id);
		$manifest = new Registry($extension->manifest_cache);

		return $manifest->get('version');

	}

	public static function getAvailableUpdate()
	{
		$component = ComponentHelper::getComponent('com_commercelab_shop');
		$extension = Table::getInstance('extension');
		$extension->load($component->id);
		$manifest  = new Registry($extension->manifest_cache);
		$installed = $manifest->get('version');

		$xml    = simplexml_load_file('https://app.commercelab.shop/index.php?option=com_rdsubs&view=updater&format=xml&element=commercelab_shop');
		$update = (string) $xml->update->{'version'};

		return ($update != $installed) ? $update : false;

	}

	public static function getAddonClSubscription(int $extension_id)
	{

		// $filepath = JPATH_SITE . '/plugins/system/commercelab_shop/vendor/commercelab_shop/src/Watchful/validation_' . $extension_id . '.json';

		// if (file_exists($filepath))
		// {
		// 	$saved_response = json_decode(file_get_contents($filepath), true);
		// 	return $saved_response;
		// }
		// return self::getClSubscription($extension_id, 'status_show', '', $filepath);

	}

	public static function updateAddonsCatch()
	{
		$filepath = JPATH_SITE . '/plugins/system/commercelab_shop/vendor/commercelab_shop/src/Watchful';

		$response = [];

		if (is_dir($filepath))
		{
			$files    = array_diff(scandir($filepath), array('.', '..'));

			foreach($files as $file){
				$response[] = self::getClSubscription(
					(int) str_replace('validation_', '', $file), 
					'status_show', 
					'', 
					$filepath . '/' . $file,
					null, 
					'1'
				);
			}
		}

		return $response;
	}

	public static function getClSubscription(
		int $extension_id, 
		string $action = 'status_show', 
		string $watchful_key = '', 
		string $filepath = null, 
		bool $update_addons = null, 
		bool $debug = null
	)
	{
		return [
			"status_install" => true,
			"status_show" => true,
			"status_update" => true,
			"message" => "",
			"message_html" => "",
			"message_modal" => "",
			"ytp_status" => false
		];
		
		$debug        = Factory::getApplication()->input->get('debug', $debug);
		$watchful_key = ComponentHelper::getParams('com_commercelab_shop')->get('subscription_key', $watchful_key);

		$domain         = $_SERVER['HTTP_HOST'];
		$domainhostname = gethostbyname($_SERVER['HTTP_HOST']);
		$ip             = file_get_contents('https://api.ipify.org');		
		$localhost      = (preg_match("~\b127.0.0.1\b~",$domainhostname) || preg_match("~\blocalhost\b~",$domainhostname)) ? '1' : '0';
		// $localhost      = (str_starts_with($domainhostname, '127.0.0.1') || str_starts_with($domainhostname, 'localhost')) ? '1' : '0';

		$get_queries = "watchful_key=$watchful_key&domain=$domain&ip=$ip&extension_id=$extension_id&localhost=$localhost&action=$action";

		if ($debug == '1')
		{
			$get_queries .= '&debug=1';
		}
		$url = "https://app.commercelab.shop/index.php?option=com_ajax&plugin=validatewatchfull&format=json&$get_queries";

		$response = json_decode(file_get_contents($url), true)['data'][0];

		// Decode Messages
		if ($response['message_html'] != '')
		{
			$response['message_html'] = base64_decode($response['message_html']);
		}
		
		// Store a local copy of the response for addons
		// if ($update_addons)
		// {	
		// 	Factory::getApplication()->triggerEvent('onUpdateAddonsValidation', []);
		// }
		
		if ($filepath && file_exists($filepath))
		{
			file_put_contents($filepath, json_encode($response));
		}
		
		if ($debug == '1' && isset($response['debug']))
		{
			$response['debug']['validation_url'] = $url;
			if ($filepath)
			{
				$response['debug']['filepath'] = $filepath;
			}
			// dd($response);
		}

        return $response;
	}

	/**
	 *
	 * @return stdClass
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	public static function getSystemRedirectUrls(): stdClass
	{

		$urls     = new stdClass();
		$base     = 'index.php?Itemid=';
		$fullBase = Uri::base() . 'index.php?Itemid=';

		$config = self::get();

		$urls->checkout        = new stdClass();
		$urls->checkout->id    = $config->get('checkout_page_url');
		$urls->checkout->short = $base . $config->get('checkout_page_url');
		$urls->checkout->full  = $fullBase . $config->get('checkout_page_url');

		$urls->cart        = new stdClass();
		$urls->cart->id    = $config->get('cart_page_url');
		$urls->cart->short = $base . $config->get('cart_page_url');
		$urls->cart->full  = $fullBase . $config->get('cart_page_url');

		$urls->confirmation        = new stdClass();
		$urls->confirmation->short = $base . $config->get('confirmation_page_url');
		$urls->confirmation->full  = $fullBase . $config->get('confirmation_page_url');

		$urls->cancellation        = new stdClass();
		$urls->cancellation->short = $base . $config->get('confirmation_page_url');
		$urls->cancellation->full  = $fullBase . $config->get('confirmation_page_url');

		// $urls->cancellation        = new stdClass();
		// $urls->cancellation->short = $base . $config->get('cancellation_page_url');
		// $urls->cancellation->full  = $fullBase . $config->get('cancellation_page_url');

		$urls->tandcs        = new stdClass();
		$urls->tandcs->short = $base . $config->get('terms_and_conditions_url');
		$urls->tandcs->full  = $fullBase . $config->get('terms_and_conditions_url');

		return $urls;
	}


}
