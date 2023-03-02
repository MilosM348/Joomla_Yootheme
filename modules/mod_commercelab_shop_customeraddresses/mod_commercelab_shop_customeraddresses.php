<?php
/**
 * @package     CommerceLab Shop - Customer Addresses
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

use CommerceLabShop\User\UserFactory;

if (UserFactory::getActiveUser()->guest)
{
	return;
}

$config    = \CommerceLabShop\Config\ConfigFactory::get();
$customer  = \CommerceLabShop\Customer\CustomerFactory::get();
$countries = \CommerceLabShop\Country\CountryFactory::getList(0, 0, true);

if (!$customer) return;

$addresses = $customer->addresses;



/** @var $params */
require JModuleHelper::getLayoutPath('mod_commercelab_shop_customeraddresses', $params->get('layout', 'default'));
