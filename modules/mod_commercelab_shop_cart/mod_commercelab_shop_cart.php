<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

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

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

use CommerceLabShop\Language\LanguageFactory;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Currency\CurrencyFactory;

LanguageFactory::load();

$cParams = ConfigFactory::get();

$currentCartId = CartFactory::getCurrentCartId();
$cart          = CartFactory::get();

$cartItems = $cart->cartItems;
$count     = $cart->count;
$currency  = CurrencyFactory::getCurrent();
$locale    = Factory::getLanguage()->get('tag');

/** @var  $params */
$totalType = $params->get('total_type', 'grandtotal');

switch ($totalType)
{
	case 'grandtotal' :

		// if ($cParams->get('add_default_country_tax_to_price', '1') == "1")
		// {
		// 	$total = $cart->totalWithTax;
		// }
		// else
		// {
		// 	$total = $cart->total;
		// }

		if ($params->get('products_with_taxes'))
		{
			$total = $cart->subtotalWithTax;
		}
		else
		{
			$total = $cart->subtotalWithoutTax;
		}
		break;

	case 'subtotal' :

		// if ($cParams->get('add_default_country_tax_to_price', '1') == "1")
		// {
		// 	$total = $cart->subtotalWithTax;
		// }
		// else
		// {
		// 	$total = $cart->subtotal;
		// }

		$total = $cart->subtotal;
		break;
}

$checkoutLink = "index.php?Itemid=" . $params->get('cartmenuitem');

require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', $params->get('layout', 'default'));
