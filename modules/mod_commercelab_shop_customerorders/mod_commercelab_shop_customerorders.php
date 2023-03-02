<?php
/**
 * @package     CommerceLab Shop - Customer Orders
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

if (Factory::getUser()->guest) {
    return;
}

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Plugin\PluginHelper;

if (!ComponentHelper::getComponent('com_commercelab_shop', true)->enabled)
{
	return;
}

if (!PluginHelper::isEnabled('system', 'commercelab_shop'))
{
	return;
}

$customer = \CommerceLabShop\Customer\CustomerFactory::get();

if (!$customer) return;
if (!$customer->orders) return;

$orders = $customer->orders['items'];

Factory::getDocument()->addStyleSheet('modules/mod_commercelab_shop_customerorders/assets/css/style.css');

/** @var $params */
require JModuleHelper::getLayoutPath('mod_commercelab_shop_customerorders', $params->get('layout', 'default'));
