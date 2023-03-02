<?php
/**
 * @package     CommerceLab Shop - Currency Switcher
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Plugin\PluginHelper;

if (!ComponentHelper::getComponent('com_commercelab_shop', true)->enabled) {
    return;
}

if (!PluginHelper::isEnabled('system', 'commercelab_shop')) {
    return;
}

/** @var $params */
require ModuleHelper::getLayoutPath('mod_commercelab_shop_currencyswitcher', $params->get('layout', 'default'));
