<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


use Joomla\CMS\Factory;
use Joomla\CMS\Document\HtmlDocument;

use CommerceLabShop\Tax\TaxFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Currency\CurrencyFactory;

use function YOOtheme\app;
use YOOtheme\Config;

use stdClass;

return [

	// Define transforms for the element node
	'transforms' => [

		// The function is executed before the template is rendered
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

			if (is_null($product) || $product->published == 0 || !$product->variants)
			{
				return false;
			}

			$node->props['item_id'] = $product_id;
			
			\CommerceLabShop\Language\LanguageFactory::load();

			$node->props['joomla_item_id'] = $product->joomla_item_id;
			$node->props['variants']       = $product->variants;
			$node->props['variantData']    = $product->variantData;
			$node->props['variantDefault'] = $product->variantDefault;

			// dd(
			// 	$node->props['variantData'],
			// 	$node->props['variantDefault']
			// );

			$node->props['selectedVariants'] = [];
			foreach ($node->props['variants'] as $key => $variant) {
				foreach ($variant->labels as $key => $label) {
					if (in_array($label->id, $node->props['variantDefault']))
					{
						$node->props['selectedVariants'][$variant->id] = $label->id;
					}
				}
			}

			foreach ($node->props['variantData']->variantList as $key => &$data)
			{

				if ($node->props['variant_price_type'] == 'relative')
				{
					$relative = $data->priceInt - $product->base_price;

					if ($relative < 0)
					{
						$data->priceInt   = $product->base_price - $data->priceInt;
						$data->bellowZero = true;
						$data->isZero     = false;
					}
					else if ($relative > 0)
					{
						$data->priceInt   = $relative;
						$data->bellowZero = false;
						$data->isZero     = false;
					}
					else
					{
						$data->priceInt   = $relative;
						$data->bellowZero = false;
						$data->isZero     = true;
					}
				}
				else
				{
					$data->priceInt = $data->priceInt;

					if ($data->priceInt == $product->base_price)
					{
						$data->isZero = true;
					}
					else
					{
						$data->isZero = false;
					}
				}

				$variant_price = ($node->props['with_tax']) 
					? TaxFactory::getBrutPrice($data->priceInt, $product->taxclass) 
					: TaxFactory::getNetPrice($data->priceInt, $product->taxclass);

				$data->priceInt = CurrencyFactory::translate($variant_price);
			}

		},

	]

];
