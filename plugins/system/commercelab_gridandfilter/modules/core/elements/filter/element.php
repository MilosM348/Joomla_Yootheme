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
use CommerceLabShop\Productoption\ProductoptionFactory;

return [

	// Define transforms for the element node
	'transforms' => [


		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {

			$config       = app(Config::class);
			$all_cats     = array_values($config->get('gridandfilter.joomla.categories'));
			$all_cats_obj = $config->get('gridandfilter.joomla.categories_object_list');

			$node->props['root_categories'] = [];
			$node->props['filter_list']     = [];
			$node->props['total_coount']    = 0;

			// Prepare Category Filter
			switch ($node->props['category_filter']) {

				case '-1': // Current Category
					if ($params['category'])
					{
						// Dynamic Title
						$node->props['filter_title'] = str_replace('{Current_Category}', $params['category']->title, $node->props['filter_title']);

						// Prepare Category
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
					$node->props['root_categories'] = $node->props['specific_category']?: [];
					break;
				
			}

			// Prepare element list
			switch ($node->props['filter_type']) {

				case 'categories':
					foreach (array_values($all_cats_obj) as $key => $cat_obj) {
						if (in_array($cat_obj->id, $node->props['root_categories']))
						{
							$node->props['filter_list'][] = $cat_obj;
						}
					}
					break;

				case 'variants':
					if (!$node->props['filter_variants'])
					{
						break;
					}
					$node->props['filter_list'] = ProductFactory::getVariantLabelsByType(
						($node->props['filter_variants']) ? [$node->props['filter_variants']] : [],
						ProductFactory::getIdsFromCategories($node->props['root_categories'] ?: [])
					);

					break;

				case 'options':
					$node->props['filter_list'] = ProductoptionFactory::getListFromGivenIdsForGandF(
						ProductFactory::getIdsFromCategories($node->props['root_categories'] ?: []),
						$node->props['filtered_options'] ? $node->props['filtered_options'] : []
					);
					break;

				case 'custom_fields':
					if (!$node->props['filter_custom_fields'])
					{
						break;
					}

					$custom_field = ProductFactory::getCustomFieldOptions($node->props['filter_custom_fields']);
					$field_params = json_decode($custom_field->fieldparams, true)['options'];

					$field_values = ProductFactory::getCustomFieldValues(
						$node->props['filter_custom_fields'],
						ProductFactory::getIdsFromCategories($node->props['root_categories'] ?: [])
					);

					foreach ($field_values as $key => &$field_value)
					{
						foreach ($field_params as $key => $field_param)
						{
							if ($field_value->value == $field_param['value'])
							{
								$field_value->id       = $field_param['value'];
								$field_value->title    = $field_param['name'];
								$field_value->items    = explode(',', $field_value->items);
								$field_value->numitems = count($field_value->items);
								continue;
							}
						}
					}

					$node->props['filter_list'] = $field_values;
					$node->props['filter_type'] = 'filter_custom_fields';

					break;

				case 'tags':
					$node->props['filter_list'] = ProductFactory::getTagsByProducts(
						ProductFactory::getIdsFromCategories($node->props['root_categories'] ?: []),
						($node->props['filtered_tags']) ? $node->props['filtered_tags'] : []
					);

					foreach ($node->props['filter_list'] as &$filter) {
						$filter->items = explode(',', $filter->items);
					}
					break;

			}

			if ($node->props['show_total_count'])
			{
				$total_count = 0;
				foreach ($node->props['filter_list'] as $filter_element) {
					if ($node->props['filter_type'] == 'variants')
					{
						$total_count += (int) $filter_element['numitems'];
					}
					else
					{
						$total_count += (int) $filter_element->numitems;
					}
				}
				$node->props['total_count'] = $total_count;
			}

			// Not show if empty
			if (empty($node->props['filter_list']))
			{
				return false;
			}

		}

	]

];

?>
