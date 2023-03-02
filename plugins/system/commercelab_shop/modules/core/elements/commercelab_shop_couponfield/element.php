<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Coupon\CouponFactory;
use CommerceLabShop\Utilities\Utilities;


return [

	// Define transforms for the element node
	'transforms' => [


		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {


			\CommerceLabShop\Language\LanguageFactory::load();

			$node->props['buttontext']       = Text::_('COM_COMMERCELAB_SHOP_ELM_COUPON_FIELD_BUTTON_TEXT_ADD');
			$node->props['removebuttontext'] = Text::_('COM_COMMERCELAB_SHOP_ELM_COUPON_FIELD_BUTTON_TEXT_REMOVE');
			$node->props['couponapplied']    = Text::_('COM_COMMERCELAB_SHOP_ELM_COUPON_FIELD_COUPON_APPLIED');
			$node->props['entercouponcode']  = Text::_('COM_COMMERCELAB_SHOP_ELM_COUPON_FIELD_PLACEHOLDER');
			$node->props['couponremoved']    = Text::_('COM_COMMERCELAB_SHOP_ELM_COUPON_FIELD_COUPON_REMOVED');

			$isCouponApplied = CouponFactory::isCouponApplied();

			$node->props['isCouponApplied'] = $isCouponApplied ? 'true' : 'false';

			$node->props['coupon'] = '';

			$doc = Factory::getDocument();
			if ($isCouponApplied)
			{
				$node->props['coupon'] = CouponFactory::getCurrentAppliedCoupon();
				$doc->addCustomTag('<script id="yps-coupon-field-appliedcouponcode" type="application/json">' . $node->props['coupon']->coupon_code . '</script>');
			}

			$doc->addCustomTag('<script id="yps-coupon-field-baseUrl" type="application/json">' . Uri::base() . '</script>');
			$doc->addCustomTag('<script id="yps-coupon-field-isCouponApplied" type="application/json">' . $node->props['isCouponApplied'] . '</script>');
			$doc->addCustomTag('<script id="yps-coupon-field-buttontext" type="application/json">' . $node->props['buttontext'] . '</script>');
			$doc->addCustomTag('<script id="yps-coupon-field-removebuttontext" type="application/json">' . $node->props['removebuttontext'] . '</script>');
			$doc->addCustomTag('<script id="yps-coupon-field-couponapplied" type="application/json">' . $node->props['couponapplied'] . '</script>');
			$doc->addCustomTag('<script id="yps-coupon-field-entercouponcode" type="application/json">' . $node->props['entercouponcode'] . '</script>');
			$doc->addCustomTag('<script id="yps-coupon-field-couponremoved" type="application/json">' . $node->props['couponremoved'] . '</script>');


		},

	]

];


