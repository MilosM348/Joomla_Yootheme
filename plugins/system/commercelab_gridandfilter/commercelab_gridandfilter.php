<?php
/**
 * @package   CommerceLab
 *
 * @copyright   Copyright (C) 2020 Cloud Chief - CommerceLab.solutions - https://CommerceLab.solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Response\JsonResponse;

use CommerceLabShop\Product\Product;
use YOOtheme\Application;
use YOOtheme\Path;

class plgSystemCommercelab_gridandfilter extends CMSPlugin
{

	public function onAfterInitialise()
	{

		if (class_exists(Application::class, false))
		{

			$app = Application::getInstance();

			$root    = __DIR__;
			$rootUrl = Uri::root(true);

			$themeroot = Path::get('~theme');
			$loader    = require "{$themeroot}/vendor/autoload.php";
			$loader->setPsr4("YpsApp_gridandfilter\\", __DIR__ . "/modules/core");

			// set alias
			Path::setAlias('~commercelab_gridandfilter', $root);
			Path::setAlias('~commercelab_gridandfilter:rel', $rootUrl . '/plugins/system/commercelab_gridandfilter');
			
			// bootstrap modules
			$app->load('~commercelab_gridandfilter/modules/core/bootstrap.php');
		
		}

	}


	/**
	 * @return JsonResponse
	 * @throws Exception
	 * @since 2.0
	 */
	public function onAjaxCommercelab_gridandfilter(): JsonResponse
	{

		$input = Factory::getApplication()->input;

		try
		{

			$response   = [];
			$categories = $input->json->get('categories', null, 'ARRAY');
			$tags       = $input->json->get('tags', null, 'ARRAY');
			$text       = $input->json->get('text', '', 'string');
			$priceFrom  = $input->json->get('price_from', 0, 'float');
			$priceTo    = $input->json->get('price_to', 999999999, 'float');

			$products = \CommerceLabShop\Product\ProductFactory::filterList($text, $categories, $tags, $priceFrom, $priceTo);

			$response['products'] = $products;

			return new JsonResponse($response);

		}
		catch (Exception $e)
		{
			return new JsonResponse('ko', $e->getMessage(), true);
		}

	}

}
