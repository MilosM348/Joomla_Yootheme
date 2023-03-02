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

jimport('joomla.plugin.plugin');

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Emaillog\EmaillogFactory;

class plgCommercelab_shop_paymentOfflinepay extends JPlugin
{


	/**
	 *
	 * Function called by the commercelab_shop_ajaxhelper plugin via checkout AJAX
	 *
	 * This function should ALWAYS call Cart::convertToOrder(NAME OF PAYMENT METHOD);
	 *
	 * NOTES @param '$paymentMethod' must allow PHP's strtolower function to always match the plugin name. so "Offline Pay" will become "offlinepay"
	 *
	 * @return mixed
	 *
	 */


	public function onInitPaymentOfflinepay($data)
	{

		//first create the order in the DB
		$order_id = CartFactory::convertToOrder('Offline Pay', '', '', true);

		// CartFactory::clearCart(CartFactory::get()->id, Utilities::getCookieID());

		if ($order_id)
		{
			try { // To send an email

				// get the plugin functions
				PluginHelper::importPlugin('commercelab_shop_system');
				Factory::getApplication()->triggerEvent('onSendCommerceLabShopEmail', ['pending', $order_id]);

			}
			catch (Exception $e)
			{	
				// Log if Failed
				EmaillogFactory::log($e->getMessage(), 'pending', 0, $order_id);
			}

		}

		return ['orderid' => $order_id];

	}


}
