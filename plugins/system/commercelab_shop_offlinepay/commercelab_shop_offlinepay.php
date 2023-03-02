<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Input\Input;

use CommerceLabShop\Order\Order;
use CommerceLabShop\Order\OrderFactory;

use YOOtheme\Application;
use YOOtheme\Path;

class plgSystemCommerceLab_Shop_offlinepay extends CMSPlugin
{

	public function onAfterInitialise()
	{

		if (!ComponentHelper::getComponent('com_commercelab_shop', true)->enabled)
		{
			return;
		}

		if (!PluginHelper::isEnabled('system', 'commercelab_shop'))
		{
			return;
		}

		if (class_exists(Application::class, false))
		{

			$app = Application::getInstance();

			$root    = __DIR__;
			$rootUrl = Uri::root(true);

			$themeroot = Path::get('~theme');
			$loader    = require "{$themeroot}/vendor/autoload.php";
			$loader->setPsr4("YpsApp_offlinepay\\", __DIR__ . "/modules/offlinepay");

			// set alias
			Path::setAlias('~commercelab_shop_offlinepay', $root);
			Path::setAlias('~commercelab_shop_offlinepay:rel', $rootUrl . '/plugins/system/commercelab_shop_offlinepay');

			// bootstrap modules
			$app->load('~commercelab_shop_offlinepay/modules/offlinepay/bootstrap.php');

		}

	}

	/**
	 * @return Order
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	// onInitP2SPaymentOfflinepay
	// public function onInitPaymentOfflinepay()
	// {

	// 	return OrderFactory::createOrderFromCart('Offline Pay', '', true);


	// }

}
