<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\Filesystem\Folder;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Theme\CacheController;

/**
 * Script File of Commercelab Shop Component
 * @since 1.0
 */
class pkg_Commercelab_shopInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param     $parent  The object responsible for running this script
	 *
	 * @since 1.0
	 */
	private $db;
	// private $release;
	// private $oldversion;

	public function __construct($parent)
	{

		// $this->release    = $parent->getManifest()->version;
		// $this->oldversion = $this->getParam('version');

		$this->db = Factory::getDbo();
	}

	/**
	 * Called on installation
	 *
	 * @param     $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 * @since 1.0
	 */
	public function install($parent)
	{
		// $db = Factory::getDbo();
		// $query = 'UPDATE  `#__extensions` set enabled=0 WHERE `element` LIKE "%protostore%"';
		// $db->setQuery($query);
		// $db->execute();

	}

	/**
	 * Called on uninstallation
	 *
	 * @param     $parent  The object responsible for running this script
	 *
	 * @since 1.0
	 */
	public function uninstall($parent)
	{


	}

	/**
	 * Called on update
	 *
	 * @param     $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 * @since 1.0
	 */
	public function update($parent)
	{

	}

	/**
	 * Called before any type of action
	 *
	 * @param   string  $type    Which action is happening (install|uninstall|discover_install|update)
	 * @param           $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 * @since 1.0
	 */
	public function preflight($type, $parent)
	{

		$ext = get_loaded_extensions();

		if (!in_array('intl', $ext))
		{

			Factory::getApplication()
				->enqueueMessage('The INTL extension is not enabled on your PHP version, CommerceLab Shop requires INTL. Please enable the extension in your PHP and try again.', 'error');

			return false;

			// die('The INTL extension is not enabled on your PHP version, CommerceLab Shop requires INTL. Please enable the extension in your PHP and try again. ');

			// Factory::getApplication()->enqueueMessage(mysqli_get_client_version(), 'error');
		}

		if (!ini_get('allow_url_fopen'))
		{
			
			Factory::getApplication()
				->enqueueMessage('The allow_url_fopen is not enabled on your server, you need this option to be enabled in order to use the component properly. Please ask your hosting how to proceed with it', 'error');

			return false;
			// die('The allow_url_fopen is not enabled on your server, you need this option to be enabled in order to use the component properly. Please ask your hosting how to proceed with it');

			// Factory::getApplication()->enqueueMessage(mysqli_get_client_version(), 'error');
		}


	}

	/**
	 * Called after any type of action
	 *
	 * @param   string  $type    Which action is happening (install|uninstall|discover_install|update)
	 * @param           $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 * @since 1.0
	 */
	public function postflight($type, $parent)
	{	
		$db = Factory::getDbo();

        if (!in_array($type, ['install', 'update'])) {
            return;
        }

		// dd($type);
		if ($type === 'install' && $type !== 'update')
		{
			
			$query = "SELECT * FROM ".$db->quoteName('#__commercelab_shop_setup');
			$db->setQuery($query);
			$results = $db->loadObject();
			if(empty($results)){
				$object            		= new stdClass();
				$object->id        		= 1;
				$object->value        	= 0;
				$db->insertObject('#__commercelab_shop_setup', $object);
			}	

			if ($this->_checkEmails())
			{

			}
			else
			{

				// Order is Pending - Admin
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{shop_email}';
				$object->body      = '<p>Hi Admin</p><p>Your order #{order_number}, is now pending approval.&nbsp; Thanks!&nbsp;</p>';
				$object->emailtype = 'pending';
				$object->subject   = '{site_name} #{order_number} is now pending your approval';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);

				// Order is Confirmed - Admin
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{shop_email}';
				$object->body      = '<p>Will you look at that you\'ve received a new order!&nbsp; All is confirmed.&nbsp;</p><ul><li>For: {customer_name}<br></li><li>Email: {customer_email}</li><li>Quick Look: {customer_order_count} products&nbsp;</li><li>Date: {order_date}</li><li>Payment Method {order_payment_method}</li><li>{order_currency_symbol} {order_grand_total}&nbsp;</li></ul>';
				$object->emailtype = 'confirmed';
				$object->subject   = '{shop_name} has a new order #{order_number}!';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);
				
				// Thank You - New Order
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{customer_email}';
				$object->body      = '<p>Hi {customer_name}</p><p>Thank you for your order! Your order details are as follows.&nbsp;</p>';
				$object->emailtype = 'created';
				$object->subject   = '{shop_name} Thank you for your order!';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);

				// Order is Pending
				// $object            = new stdClass();
				// $object->id        = 0;
				// $object->to        = '{customer_email}';
				// $object->body      = '<p>{customer_name}</p><p>Order, {order_number},  is now pending </p>';
				// $object->emailtype = 'pending';
				// $object->subject   = 'Order {order_number} Pending';
				// $object->published = 1;
				// $db->insertObject('#__commercelab_shop_email', $object);

				// Order is Confirmed
				// $object            = new stdClass();
				// $object->id        = 0;
				// $object->to        = '{customer_email}';
				// $object->body      = '<p>{customer_name}</p><p>Order, {order_number},  is now confirmed </p>';
				// $object->emailtype = 'confirmed';
				// $object->subject   = 'Order {order_number} Confirmed';
				// $object->published = 1;
				// $db->insertObject('#__commercelab_shop_email', $object);

				// Order is Cancelled
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{customer_email}';
				$object->body      = '<p>Hi {customer_name}</p><p>Your order, {order_number} is now cancelled.</p>';
				$object->emailtype = 'cancelled';
				$object->subject   = 'Your order, {order_number} is now cancelled.';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);

				// Order is Refunded
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{customer_email}';
				$object->body      = '<p>Hi {customer_name}</p><p>Your order, {order_number} is now refunded.</p><p>If you have any further questions please feel free to email us at {shop_email}.&nbsp;</p>';
				$object->emailtype = 'refunded';
				$object->subject   = 'Your {shop_name}, order #{order_number} has been refunded.';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);

				// Order is Shipped
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{customer_email}';
				$object->body      = '<p>Hi {customer_name}</p><p>Your order, {order_number} is now shipped.&nbsp; Please see below for any tracking info if applicable.&nbsp;</p><p>Tracking Info: {tracking_code} &nbsp;{tracking_url}</p>';
				$object->emailtype = 'shipped';
				$object->subject   = 'Your {shop_name} order, has been shipped.';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);

				// Order is Completed
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{customer_email}';
				$object->body      = '<p>Hi {customer_name}</p><p>Your order, {order_number} is now completed. We thank you for your purchase. Shop again with us soon!&nbsp;</p><p>If you have received this email in error or have an questions about your order please contact us at {Shop Email}</p>';
				$object->emailtype = 'completed';
				$object->subject   = 'Your order, {order_number} has been marked as completed';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);

				// Order is Denied
				$object            = new stdClass();
				$object->id        = 0;
				$object->to        = '{customer_email}';
				$object->body      = '<p>Hi {customer_name}</p><p>We\'re sorry but the order you placed with the number of {order_number} has been denied.</p><p>Please contact {shop_email} if you\'ve received this email in error.&nbsp;</p>';
				$object->emailtype = 'denied';
				$object->subject   = 'Your order, {order_number} is now denied.';
				$object->published = 1;
				$db->insertObject('#__commercelab_shop_email', $object);

			}
			
			//Check wether we install Pro
			/*$proResult = $this->checkProInstall();
			if(!empty($proResult)){
				$products = $this->mappingp2sProducts();
			}*/
			// $oldOption = $this->getoldoption();
			// $this->checkRestoreProTable($oldOption);
			// $this->alterClsTables();

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop_shortcodes';
			$plugin->folder  = (string) 'content';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));


			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop_ajaxhelper';
			$plugin->folder  = (string) 'ajax';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'paypal';
			$plugin->folder  = (string) 'commercelab_shop_payment';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'stripepayment';
			$plugin->folder  = (string) 'commercelab_shop_payment';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'offlinepay';
			$plugin->folder  = (string) 'commercelab_shop_payment';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop';
			$plugin->folder  = (string) 'user';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop_fields';
			$plugin->folder  = (string) 'content';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'emailer';
			$plugin->folder  = (string) 'commercelab_shop_system';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop_paypal';
			$plugin->folder  = (string) 'system';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop_stripepayment';
			$plugin->folder  = (string) 'system';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));


			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop_offlinepay';
			$plugin->folder  = (string) 'system';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'defaultshipping';
			$plugin->folder  = (string) 'commercelab_shop_shipping';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'coresystemtaxes';
			$plugin->folder  = (string) 'commercelab_shop_taxes';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop';
			$plugin->folder  = (string) 'system';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop';
			$plugin->folder  = (string) 'installer';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop';
			$plugin->folder  = (string) 'quickicon';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'io';
			$plugin->folder  = (string) 'commercelab_shop_extended';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'commercelab_shop_animation';
			$plugin->folder  = (string) 'system';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));
		}

		if ($type == 'update')
		{
			// Clear YTP Cache
			$cacheFiles = new \RecursiveIteratorIterator(
	            new \RecursiveDirectoryIterator(
	                JPATH_SITE . '/templates/yootheme/cache',
	                \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS
	            ),
	            \RecursiveIteratorIterator::CHILD_FIRST
	        );
	        foreach ($cacheFiles as $file) {
	            if ($file->isFile()) {
	                unlink($file->getRealPath());
	            } elseif ($file->isDir()) {
	                rmdir($file->getRealPath());
	            }
	        }

			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'coresystemtaxes';
			$plugin->folder  = (string) 'commercelab_shop_taxes';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			// Remove in BETA_4.4.5 or later
			$plugin          = new stdClass();
			$plugin->type    = 'plugin';
			$plugin->element = 'io';
			$plugin->folder  = (string) 'commercelab_shop_extended';
			$plugin->enabled = 1;
			$db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

			$this->alterClsTables();
		}

	}

	
	
	private function getParam($name)
	{
		$db = Factory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "commercelab_shop"');
		$manifest = json_decode($db->loadResult(), true);

		return $manifest[$name];
	}

	private function removeUnneededColumns()
	{
		$customerColumns = array(
			'checked_out',
			'checked_out_time',
			'version',
			'hits',
			'access',
			'ordering',
			'params',
			'asset_id'
		);

		foreach ($customerColumns as $column)
		{
			$this->dropColumn('customer', $column);
		}


		$option_presetColumns = array(
			'checked_out',
			'checked_out_time',
			'version',
			'hits',
			'access',
			'ordering',
			'params',
			'asset_id'
		);

		foreach ($option_presetColumns as $column)
		{
			$this->dropColumn('option_preset', $column);
		}


		$productColumns = array(
			'asset_id'
		);

		foreach ($productColumns as $column)
		{
			$this->dropColumn('product', $column);
		}


		$zoneColumns = array(
			'default'
		);

		foreach ($zoneColumns as $column)
		{
			$this->dropColumn('zone', $column);
		}


		$orderColumns = array(
			'asset_id'
		);

		foreach ($orderColumns as $column)
		{
			$this->dropColumn('order', $column);
		}

		$discountColumns = array(
			'asset_id',
			'ordering',
			'access',
			'hits',
			'version',
			'checked_out_time',
			'checked_out'
		);

		foreach ($discountColumns as $column)
		{
			$this->dropColumn('discount', $column);
		}

		$customerAddressColumns = array('asset_id');

		foreach ($customerAddressColumns as $column)
		{
			$this->dropColumn('customer_address', $column);
		}

		$emailColumns = array('asset_id', 'params');

		foreach ($emailColumns as $column)
		{
			$this->dropColumn('email', $column);
		}

	}


	private function dropColumn($tableSuffix, $column)
	{
		$db    = Factory::getDbo();
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_' . $tableSuffix) . " LIKE '" . $column . "'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if ($res)
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_' . $tableSuffix) . ' DROP COLUMN ' . $db->quoteName($column);
			$db->setQuery($query);
			$db->execute();
		}
	}

	private function _checkEmails()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_email'));

		$db->setQuery($query);

		$result = $db->loadObjectList();

		if ($result)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	
	/*Check wether we have pro component or not*/
	public function checkProInstall(){
		$db = Factory::getDbo();
		$db->setQuery('SELECT * FROM #__extensions WHERE element = "pkg_protostore"');
		return $db->loadResult();
	}

	
	
	public function checkRestoreProTable(){
		$db = Factory::getDbo();
		$db->setQuery("show tables LIKE '%protostore%'");
		$tables = 	$db->loadAssocList();
		$db->setQuery("show tables LIKE '%commercelab%'");
 		$tablesCom = 	$db->loadColumn();
		if(!empty($tables)){
			foreach($tables as $table){
				
				$oldTable = array_values($table)[0];
				$oldTableArr[] = $oldTable;
			   
				$pattern = '/protostore/i';
				$newTableName = preg_replace($pattern, 'commercelab_shop', $oldTable);
			   if(in_array($newTableName,$tablesCom)){	
				   $this->dropClsTable($newTableName);
				   
				   $query = 'RENAME TABLE '.$oldTable.' TO '.$newTableName.'';
				   $db->setQuery($query);
				   $db->execute();
			   }
			}
			
			
			$this->alterClsTables();
			//Get Old Options
			// $this->getOption($oldOption);
			//Update Pro Modules elements 
			// $this->updateProModules();
			//remove all Pro extension 
			// $this->removeProExtension();
			// $this->updateAllYooThemeElement();
			// $this->deletePro();
		}	
	}
	public function deletePro(){
		$extname = 'protostore';
		$folders = array();
		
		$folders[] = JPATH_ADMINISTRATOR . '/components/com_' . $extname;
		$folders[] = JPATH_ROOT . '/components/com_' . $extname;
		
		$folders[] = JPATH_ROOT . '/plugins/system/'.$extname;
		$folders[] = JPATH_ROOT . '/plugins/system/'.$extname.'_offlinepay';
		$folders[] = JPATH_ROOT . '/plugins/ajax/'.$extname.'_ajaxhelper';
		$folders[] = JPATH_ROOT . '/plugins/content/'.$extname.'_fields';
		$folders[] = JPATH_ROOT . '/plugins/content/'.$extname.'_shortcodes';
		$folders[] = JPATH_ROOT . '/plugins/'.$extname.'payment';
		$folders[] = JPATH_ROOT . '/plugins/'.$extname.'shipping';
		$folders[] = JPATH_ROOT . '/plugins/'.$extname.'system';
		
		$folders[] = JPATH_ROOT . '/modules/mod_protostorecart';
		$folders[] = JPATH_ROOT . '/modules/mod_protostorecartfab';
		$folders[] = JPATH_ROOT . '/modules/mod_protostorecurrencyswitcher';
		$folders[] = JPATH_ROOT . '/modules/mod_protostorecustomeraddresses';
		$folders[] = JPATH_ROOT . '/modules/mod_protostorecustomerorders';
		
		foreach ($folders as $folder){
		
			if (is_dir($folder)){
				Folder::delete($folder);
			}	
		}
		

	}
	public function updateProModules(){
		$db = Factory::getDbo();
		$query = 'UPDATE `#__modules` SET `title` = REPLACE(`module`, "Pro2Store", "CommerceLabShop") ,`module` = REPLACE(`module`, "protostore", "commercelab_shop_") WHERE `module` LIKE "%protostore%" ';
		$db->setQuery($query);
		$db->execute();
	}
	public function updateAllYooThemeElement(){
		
		$db = Factory::getDbo();
		$query = 'UPDATE `#__content` SET `fulltext` = REPLACE(`fulltext`, "protostore", "commercelab_shop") WHERE `fulltext` LIKE "%protostore%" ';
		$db->setQuery($query);
		$db->execute();
		
		$query = 'UPDATE `#__extensions` SET `custom_data` = REPLACE(`custom_data`, "protostore", "commercelab_shop") WHERE `custom_data` LIKE "%protostore%" ';
		$db->setQuery($query);
		$db->execute();
	}
	
	public function removeProExtension(){
		// $db = Factory::getDbo();
		// $query = 'DELETE FROM  `#__extensions` WHERE `element` LIKE "%protostore%"';
		// $db->setQuery($query);
		// $db->execute();

		// $db = Factory::getDbo();
		// $query = 'DELETE FROM  `#__menu` WHERE `path` LIKE "%com_protostore_menu%"';
		// $db->setQuery($query);
		// $db->execute();
		
		
	}
	//Check whether we have already cls tables
	public function dropClsTable($newTableName){
		$db = Factory::getDbo();
		$queryDrop = 'DROP TABLE IF EXISTS `'.$newTableName.'`';
		$db->setQuery($queryDrop);
		$db->execute();
	}
	public function alterClsTables(){
		$db = Factory::getDbo();


		$query = "CREATE TABLE IF NOT EXISTS `#__commercelab_shop_callback_log` 
			( 
			    `id`          int(11)          NOT NULL AUTO_INCREMENT,
			    `paymenttype` text,
			    `payload`     text,
			    `post`        text,
			    `server`      text,
			    `created`     datetime         NOT NULL DEFAULT CURRENT_TIMESTAMP,
			    PRIMARY KEY (`id`)
			) 	
			ENGINE=InnoDB 
			DEFAULT CHARSET=utf8;
		";

		$db->setQuery($query);
		$db->execute();

		// Empty Cart, Addresses and Customers

		// $query = 'TRUNCATE TABLE ' . $db->quoteName('#__commercelab_shop_customer');
		// $db->setQuery($query);
		// $db->execute();

		// $query = 'TRUNCATE TABLE ' . $db->quoteName('#__commercelab_shop_customer_address');
		// $db->setQuery($query);
		// $db->execute();

		// $query = 'TRUNCATE TABLE ' . $db->quoteName('#__commercelab_shop_cart');
		// $db->setQuery($query);
		// $db->execute();

		// $query = 'TRUNCATE TABLE ' . $db->quoteName('#__commercelab_shop_cart_item');
		// $db->setQuery($query);
		// $db->execute();

		// Setup

		// GUest Cart
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart') . " LIKE 'guest'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart') . ' ADD COLUMN  `guest` tinyint(4) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// GUest Cart
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart') . " LIKE 'address_same_as'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart') . ' ADD COLUMN  `address_same_as` tinyint(4) DEFAULT 1;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Customer ID as NULL for guests

		$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer') . ' DROP COLUMN `j_user_id`;';
		$db->setQuery($query);
		$db->execute();

		$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer') . ' ADD COLUMN  `j_user_id` int(11) DEFAULT NULL;';
		$db->setQuery($query);
		$db->execute();

		$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' DROP COLUMN `customer_id`;';
		$db->setQuery($query);
		$db->execute();

		$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN  `customer_id` int(11) DEFAULT NULL;';
		$db->setQuery($query);
		$db->execute();


		// Product Subtitle
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_product') . " LIKE 'subtitle'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product') . ' ADD COLUMN  `subtitle` mediumtext DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Product Apply Discount
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_product') . " LIKE 'apply_discount'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product') . ' ADD COLUMN  `apply_discount` tinyint(4) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Cart State
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart') . " LIKE 'state'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart') . ' ADD COLUMN  `state` tinyint(4) DEFAULT 0;';
			$db->setQuery($query);
			$db->execute();
		}	


		// Tax Rates

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart_item') . " LIKE 'price_without_tax'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart_item') . ' ADD COLUMN  `price_without_tax` int(11) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart_item') . " LIKE 'price_with_tax'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart_item') . ' ADD COLUMN  `price_with_tax` int(11) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart_item') . " LIKE 'taxclass'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart_item') . " ADD COLUMN  `taxclass` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart_item') . " LIKE 'taxrate'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart_item') . ' ADD COLUMN  `taxrate` decimal(4,2) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_order_products') . " LIKE 'price_without_tax'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_order_products') . ' ADD COLUMN  `price_without_tax` int(11) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_order_products') . " LIKE 'price_with_tax'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_order_products') . ' ADD COLUMN  `price_with_tax` int(11) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_order_products') . " LIKE 'taxclass'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_order_products') . " ADD COLUMN  `taxclass` varchar(255) NOT NULL DEFAULT '';";
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_order_products') . " LIKE 'taxrate'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_order_products') . ' ADD COLUMN  `taxrate` decimal(4,2) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}


		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_country') . " LIKE 'taxrate_reduced'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_country') . ' ADD COLUMN  `taxrate_reduced` decimal(4,2) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_country') . " LIKE 'taxrate_extra'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_country') . ' ADD COLUMN  `taxrate_extra` decimal(4,2) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_zone') . " LIKE 'taxrate_reduced'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_zone') . ' ADD COLUMN  `taxrate_reduced` decimal(4,2) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}
		
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_zone') . " LIKE 'taxrate_extra'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_zone') . ' ADD COLUMN  `taxrate_extra` decimal(4,2) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	
		
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_zone') . " LIKE 'inherit_taxrate'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_zone') . ' ADD COLUMN  `inherit_taxrate` tinyint(4) DEFAULT 1;';
			$db->setQuery($query);
			$db->execute();
		}	
		
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_product') . " LIKE 'taxclass'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{

			$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_product') . " LIKE 'taxable'";
			$db->setQuery($query);
			$res = $db->loadResult();

			if (!empty($res))
			{
				$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product') . ' DROP COLUMN `taxable`;';
				$db->setQuery($query);
				$db->execute();
			}

			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product') . ' ADD COLUMN `taxclass` varchar(255) DEFAULT ' . $db->quote('taxrate') . ';';
			$db->setQuery($query);
			$db->execute();

		}	



		// Cart Date
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart') . " LIKE 'created'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart') . ' ADD COLUMN  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;';
			$db->setQuery($query);
			$db->execute();
		}	
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_cart') . " LIKE 'converted'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_cart') . ' ADD COLUMN  `converted` datetime DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Customer Temp ID
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer') . " LIKE 'temp_id'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (!empty($res))
		{

			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer') . ' DROP COLUMN `temp_id`;';
			$db->setQuery($query);
			$db->execute();

		}	

		// Address First Name
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer_address') . " LIKE 'first_name'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN  `first_name` varchar(255) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Address Last Name
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer_address') . " LIKE 'last_name'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN  `last_name` varchar(255) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Address VAT
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer_address') . " LIKE 'vat'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN  `vat` varchar(255) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Address Company name
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer_address') . " LIKE 'company_name'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN  `company_name` varchar(255) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Address City
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer_address') . " LIKE 'city'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN `city` varchar(255) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	

		// Address Type
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer_address') . " LIKE 'address_type'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN  `address_type` varchar(64) DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}			
		// Address Extra Fields
		$query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_customer_address') . " LIKE 'extra_fields'";
		$db->setQuery($query);
		$res = $db->loadResult();
		if (empty($res))
		{
			$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_customer_address') . ' ADD COLUMN  `extra_fields` mediumtext DEFAULT NULL;';
			$db->setQuery($query);
			$db->execute();
		}	


		return;

		// $query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_email') . " LIKE 'language'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if (empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_email') . ' ADD COLUMN  `language` char(7) DEFAULT \'*\';';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }	

		// // add maxPerOrder column
		// $query = "SHOW COLUMNS FROM " . $db->quoteName('#__commercelab_shop_product') . " LIKE 'maxPerOrder'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if (empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product') . ' ADD COLUMN `maxPerOrder` int(11) DEFAULT NULL;';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }
		// // fix customer_id column
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_order` LIKE 'customer'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		
		// if (!empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_order') . ' CHANGE `customer` `customer_id` int(11) NOT NULL DEFAULT \'0\';';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }	

		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_country` LIKE 'default'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if (empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_country') . ' ADD COLUMN `default` tinyint(11) DEFAULT \'0\';';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }

		// //Check default country 
		// $query = 'UPDATE `#__commercelab_shop_country` SET `default` = 1  WHERE `country_isocode_3` = "%USA%" ';
		// $db->setQuery($query);
		// $db->execute();
		
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_product_option` LIKE 'product_id'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if (!!empty($res))
		// {

		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product_option') . ' ADD COLUMN `product_id` int(11) NOT NULL DEFAULT \'0\';';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }

		// /**
		//  * Do discount table
	 // */
		// // add percentage column
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_discount` LIKE 'percentage'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if(empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_discount') . ' ADD COLUMN `percentage` float DEFAULT NULL;';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }
		
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_discount` LIKE 'couponcode'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if(!empty($res))
		// {
		
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_discount') . ' CHANGE `couponcode` `coupon_code` varchar(255) DEFAULT NULL;';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }
		
		// //Add template_option_id 
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_product_variant` LIKE 'template_option_id'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if(empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product_variant') . ' ADD COLUMN `template_option_id` int(11) NOT NULL DEFAULT \'0\';';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }
		// //Add ordering 
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_product_variant` LIKE 'ordering'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if(empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product_variant') . ' ADD COLUMN `ordering` int(11) NOT NULL DEFAULT \'0\';';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }

		// //Add ordering 
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_product_variant_data` LIKE 'ordering'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if(empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product_variant_data') . ' ADD COLUMN `ordering` int(11) NOT NULL DEFAULT \'0\';';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }
		// //Add short desc 
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_product` LIKE 'short_desc'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if(empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product') . ' ADD COLUMN `short_desc` MEDIUMTEXT DEFAULT NULL;';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }	
		// $query = "SHOW COLUMNS FROM `#__commercelab_shop_product` LIKE 'long_desc'";
		// $db->setQuery($query);
		// $res = $db->loadResult();
		// if(empty($res))
		// {
		// 	$query = 'ALTER TABLE ' . $db->quoteName('#__commercelab_shop_product') . ' ADD COLUMN `long_desc` MEDIUMTEXT DEFAULT NULL;';
		// 	$db->setQuery($query);
		// 	$db->execute();
		// }	
	}
	public function getoldoption(){
	
		$db = Factory::getDbo();
	
		$query = $db->getQuery(true);

		$query
			->select(array('*'))
			->from($db->quoteName('#__protostore_product_option'));

		$db->setQuery($query);

		return $db->loadObjectList();
		
	}
	public function getOption($oldOption) {
		$results = $oldOption;
		foreach($results as $result){
			$db = Factory::getDbo();
			$query = $db->getQuery(true);

			$query
				->select('*')
				->from($db->quoteName('#__protostore_product_option_values'))
				->where($db->quoteName('optiontype') . ' = ' . $db->quote($result->id))
				->group($db->quoteName('product_id'));
			$db->setQuery($query);
			
			$product_s = $db->loadObjectList();
	
			foreach($product_s as $product){
				if($result->option_type != 'Checkbox'){
					//Enter the variant
					$query = $db->getQuery(true);

					$columns = array('product_id', 'name');

					$values = array($product->product_id, $db->quote($result->name));

					$query
						->insert($db->quoteName('#__commercelab_shop_product_variant'))
						->columns($db->quoteName($columns))
						->values(implode(',', $values));

					$db->setQuery($query);
					$db->execute();
					$lastVariantId = $db->insertid();
					
					
				}else{
					$query = $db->getQuery(true);

					$columns = array('product_id', 'option_name', 'modifier_value', 'modifier_type');

					$values = array($product->product_id, $db->quote($product->optionname), $db->quote($product->modifiervalue), $db->quote($product->modifiervalue));

					$query
						->insert($db->quoteName('#__commercelab_shop_product_option'))
						->columns($db->quoteName($columns))
						->values(implode(',', $values));

					$db->setQuery($query);
					$db->execute();
				}
			}
		}
		
	}
}


