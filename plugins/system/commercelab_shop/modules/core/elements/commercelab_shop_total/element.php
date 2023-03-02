<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Price\PriceFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Product\ProductFactory;

use function YOOtheme\app;
use YOOtheme\Config;

return [

	'transforms' => [

		'render' => function ($node, array $params) {

			$config = app(Config::class);

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
			
			$node->props['price']                = CurrencyFactory::translate($product->base_price);
			$node->props['item_discount']        = CurrencyFactory::translate(PriceFactory::calculateItemDiscount($product));
			$node->props['price_after_discount'] = CurrencyFactory::translate(PriceFactory::calculatePriceAfterDiscount($product));

			$node->props['baseUrl'] = Uri::base();

			$node->props['currency'] = CurrencyFactory::getCurrent()->currencysymbol;

		},
	]

];