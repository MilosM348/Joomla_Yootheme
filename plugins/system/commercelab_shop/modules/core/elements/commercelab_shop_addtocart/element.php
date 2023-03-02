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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Product\ProductFactory;

use function YOOtheme\app;
use YOOtheme\Config;

return [

	// Define transforms for the element node
	'transforms' => [


		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {

			$config = app(Config::class);

			// Checkout Link
			$node->props['checkoutlink'] = Route::_(ConfigFactory::getSystemRedirectUrls()->checkout->short);
			$node->props['baseUrl']      = Uri::base();

			// Product
			$product_id = ($config('commercelab.add2cartanywhere') && $node->props['product_source'] == 'manual' && $node->props['product_source_manual']) 
				? $node->props['product_source_manual']
				: ((isset($params['item'])) ? $params['item']->id : (isset($params['article']) ? $params['article']->id : null));

			if (!$product_id)
			{
				return false;
			}

			$product = ProductFactory::get($product_id);

			if (is_null($product) || $product->published == 0)
			{
				return false;
			}
			$node->props['item_id']              = $product_id;

			$product        = ProductFactory::get($node->props['item_id']);
			$amount_in_cart = CartFactory::getTotalAmountProductFromCart($node->props['item_id']);
			// $cartitem               = CartFactory::getCartitem($node->props['item_id']);

			if (!$product || $product->published == 0) {
				return false;
			}

			// Remove Joomla Item Properties
			$product->joomlaItem->introtext = null;
			$product->joomlaItem->fulltext  = null;
			$product->joomlaItem->images    = null;
			$product->joomlaItem->urls      = null;

			// Stock
			$node->props['instock']         = true;
			$node->props['product_in_cart'] = json_encode($product);
			$node->props['amount_in_cart']  = $amount_in_cart;

			if ($product->manage_stock == 1 && $product->stock == 0 || (($product->stock - $amount_in_cart) == 0)) {
				$node->props['instock'] = false;
			}

			// $node->props['show_out_of_stock_message'] = false;

			// // Button Behaviour
			// $node->props['disable_button'] = $amount_in_cart;
			// $node->props['hide_button']    = $amount_in_cart;


		}

	]

];

?>
