<?php

/**
 * @package     Pro2Store - Grid & Filter
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - Pro2Store. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

return [

	// Define transforms for the element node
	'transforms' => [

		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {

			$node->props['all_sort_options'] = [
				"a.id"         => "Item Id",
				"a.title"      => "Title",
				"p.base_price" => "Price",
				"p.sku"        => "SKU",
				"a.hits"       => "Hits",
				"a.created"    => "Created Date",
				"a.modified"   => "Modified Date",
				"a.publish_up" => "Publish up Date"
			];

			$node->props['sorted_by'] = (!empty($node->props['sorted_by'])) 
				? $node->props['sorted_by'] 
				: array_keys($node->props['all_sort_options']);

		},

	]

];

?>
