<?php

/**
 * @package     Pro2Store - Grid & Filter
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - Pro2Store. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Categories\Categories; // \libraries\src\Categories\Categories.php

use function YOOtheme\app;
use YOOtheme\Config;

use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Product\ProductFactory;

return [

	// Define transforms for the element node
	'transforms' => [


		// The function is executed before the template is rendered
		'render' => function ($node, array $params)
		{
			$config       = app(Config::class);

			$all_cats     = array_values($config->get('gridandfilter.joomla.categories'));
			$all_cats_obj = $config->get('gridandfilter.joomla.categories_object_list');

			$node->props['root_categories']  = [];
			$node->props['items']            = [];
			$node->props['exclude_category'] = ($node->props['exclude_category']) ? $node->props['exclude_category'] : [];
			// $node->props['filtered_tags']   = [];

			switch ($node->props['category_filter'])
			{

				case '-1': // Current Category
					if ($params['category'])
					{
						$node->props['root_categories'] = [$params['category']->id];
						if ($node->props['category_filter_children'] != 0)
						{
							if ($node->props['exclude_current'])
							{
								$node->props['root_categories'] = [];
							}

							foreach ($all_cats_obj as $cat_obj) if ($cat_obj->id != $params['category']->id)
							{
								$path = $cat_obj->getPath();
								switch ($node->props['category_filter_children'])
								{
									case -1:
										foreach ($path as $parent_id => $route)
										{
											if ($parent_id == $params['category']->id)
											{
												$node->props['root_categories'][] = $cat_obj->id;
											}
										}
										break;
									
									default:
										$allowed_level = $node->props['category_filter_children'];
										$curerent_cat_position = array_search(
											$params['category']->id, 
											array_keys($path)
										);
										$child_offset = array_search(
											$cat_obj->id,
											array_keys($path)
										);
										if ($curerent_cat_position === false || $child_offset < $curerent_cat_position)
										{
											break;
										}

										if ($curerent_cat_position + $allowed_level >= $child_offset
											&& !in_array($cat_obj->id, $node->props['root_categories']))
										{
											$node->props['root_categories'][] = $cat_obj->id;
										}

										break;
								}

							}
						}
					}
					break;
				
				case '0': // All Categories Except
					$node->props['root_categories'] = array_diff($all_cats, $node->props['exclude_category']?: []);
					break;
				
				case '1': // only Selected
					$node->props['root_categories'] = $node->props['specific_category'];
					break;
				
			}

			$filtered_tags = [];
			if (!empty($node->props['filtered_tags']))
			{
				$node->props['filtered_tags'] = ProductFactory::getTagsByProducts(
					[],
					$node->props['filtered_tags']
				);
				foreach ($node->props['filtered_tags'] as $filter) {
					foreach (explode(',', $filter->items) as $items) {
						$filtered_tags[0]['items'][] = $items;
					}
				}
				$filtered_tags[0]['items'] = array_unique($filtered_tags[0]['items']);
			}


			// Grid
			$node->props['items_per_row'] = 'uk-child-width-1-' . $node->props['grid_default'];

			if ($node->props['grid_small'] != '')
			{
				$node->props['items_per_row'] .= ' uk-child-width-1-' . $node->props['grid_small'] . '@s';
			}

			if ($node->props['grid_medium'] != '')
			{
				$node->props['items_per_row'] .= ' uk-child-width-1-' . $node->props['grid_medium'] . '@m';
			}

			if ($node->props['grid_large'] != '')
			{
				$node->props['items_per_row'] .= ' uk-child-width-1-' . $node->props['grid_large'] . '@l';
			}

			if ($node->props['grid_xlarge'] != '')
			{
				$node->props['items_per_row'] .= ' uk-child-width-1-' . $node->props['grid_xlarge'] . '@xl';
			}

			$node->props['type_source'] = $config->get('gridandfilter.ytp.types.YpsProduct.TypeList');

			// Items
			$items_per_page = $node->props['items_per_page'];
			$offset         = 0;

			$query = [
				(int) $items_per_page,
				(int) $offset,
				$node->props['root_categories'],
				['on_load_tags' => $filtered_tags],
				$node->props['sorted_by']?: 'a.id',
				$node->props['sort_direction']?: 'DESC',
				(array) $node
			];

			$filtered_query = ProductFactory::getGridAndFilterListOnLoad(...$query);

			$node->props['filtered_query'] = $filtered_query;
			$node->props['offset']         = $offset;
			$node->props['items']          = $filtered_query['render'];

		}

	]

];

?>
