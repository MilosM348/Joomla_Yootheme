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

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Input\Input;

use CommerceLabShop\Order\Order;


class commercelab_shopTask_initpayment
{

	public function getResponse(Input $data)
	{

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$paymentType = $data->json->getString('paymentType');
		PluginHelper::importPlugin('commercelab_shop_payment');

		// "triggerEvent" returns an array of the triggered events. We know that we're only triggering one,
		// so pull out the first node of the array and return it. this should satisfy PHP 7's type casting for the "Order" type.
		// dump('onInitPayment'.$paymentType);
		$events = Factory::getApplication()->triggerEvent('onInitPayment'.$paymentType, [$data]);

		// $events[0] should be of type "Order"
		return $events[0];

	}

}
