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

use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;


return [

	// Define transforms for the element node
	'transforms' => [


		// The function is executed before the template is rendered
		'render' => function ($node, array $params) {

			// Varous Search Terms
			if ($node->props['search_within'] == '' || $node->props['search_within'] == 'specific')
			{
				$search_within = [];
				foreach ($node->props as $prop_name => $prop_value)
				{
					if (str_starts_with($prop_name, 'search_within_') 
						&& ($prop_value === true || ($prop_name == 'search_within_custom_fields' && !empty($prop_value))))
					{
						if ($prop_name == 'search_within_custom_fields')
						{
							foreach ($prop_value as $key => $prop_val) {
					    		$search_within[str_replace('search_within_', '', $prop_name)][] =  $prop_val;
							}
						}
						else
						{
					    	$search_within[] = str_replace('search_within_', '', $prop_name);
						}
					}
				}
				$node->props['search_within'] = $search_within;
			}
			else
			{
				$node->props['search_within'] = [$node->props['search_within']];
			}

		},

	]

];

?>
