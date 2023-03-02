<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

use Joomla\CMS\Language\Text;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Price\PriceFactory;
use CommerceLabShop\Utilities\Utilities;

use function YOOtheme\app;
use YOOtheme\Config;


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
			$product    = ProductFactory::get($product_id);

			if (is_null($product) || $product->published == 0)
			{
				return false;
			}
			$node->props['item_id'] = $product_id;
			
			$price_type_int = $node->props['price_type'];

			// Do not show any 0 value
			// Maybe later we can add an option to choose
			if ($product->$price_type_int == 0)
			{
				return false;
			}

			switch ($price_type_int)
			{
				case 'saving':
				case 'base_price':
				case 'priceAfterDiscount':

					if ($node->props['with_tax'])
					{
						$price_type_int = $price_type_int . 'WithTax';
					}
					else
					{
						$price_type_int = $price_type_int . 'WithoutTax';
					}

					break;

			}

			if ($node->props['formatted'])
			{
				$price_type = $price_type_int . '_formatted';
			}
			else
			{
				$price_type = $price_type_int . 'Float';
			}

			$node->props['price_type_data'] = $product->$price_type;

			// Apply strike trough only if discounted
			if ($node->props['strikethru'])
			{
				if ($node->props['strikethru_only_if_discount'] && !$product->discount)
				{
					$node->props['strikethru'] = '';		
				}
			}

		},

	]

];
