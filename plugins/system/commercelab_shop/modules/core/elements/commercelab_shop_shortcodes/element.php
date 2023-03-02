<?php

/**
 * @package     CommerceLab Shop - Shortcodes
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

use function YOOtheme\app;
use YOOtheme\Config;
use YOOtheme\Http\Request;
use YOOtheme\Http\Message\Uri;

use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\User\UserFactory;

return [

	// Define transforms for the element node
	'transforms' => [

		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {

			list($config, $request) = app(Config::class, Request::class);

			$order_id = $request->getQueryParam('cls_order_id', null);

			if (!$order_id) {
				return false;
			}

			$order       = OrderFactory::get($order_id);

			if (!$order || !$order->{$node->props['codetype']}) {
				return false;
			}

			$user        = UserFactory::getActiveUser();
			$cart_cookie = $request->getCookieParam('yps-cart');

			// if ($user->guest && $order->guest_pin != $cart_cookie
			// 	|| !$user->guest && $order->customer_id != $user->id)
			// {
			// 	return false;
			// }

			$node->props['codetype_title'] = ucfirst(str_replace('_', ' ', $node->props['codetype']));
			$node->props['codetype']       = ($node->props['codetype'] == 'payment_method' && $order->{$node->props['codetype']} == 'Offline Pay') 
				? Text::_('COM_COMMERCELAB_SHOP_OFFLINE_PAYMENT')
				: $order->{$node->props['codetype']};
		},

	]

];

?>
