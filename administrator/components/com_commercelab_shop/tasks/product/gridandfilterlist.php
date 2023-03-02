<?php
/**
 * @package   CommerceLab_Shop
 * @author    Cloud Chief - CommerceLab Shop
 * @copyright Copyright (C) 2021 Cloud Chief - CommerceLab Shop
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access


defined('_JEXEC') or die('Restricted access');

use Joomla\Input\Input;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Currency\CurrencyFactory;

class commercelab_shopTask_gridandfilterlist
{

	public function getResponse(Input $data)
	{
		$limit                   = $data->json->getInt('limit', null);
		$offset                  = $data->json->getInt('offset', null);
		$categories              = $data->json->get('categories', null, 'ARRAY');
		$variants                = $data->json->get('variants', null, 'ARRAY');
		$filter_custom_fields    = $data->json->get('filter_custom_fields', null, 'ARRAY');
		$options                 = $data->json->get('options', null, 'ARRAY');
		$tags                    = $data->json->get('tags', null, 'ARRAY');
		$customFieldsSearchTerms = $data->json->get('customFieldsSearchTerms', null, 'ARRAY');
		$searchTerms             = $data->json->get('searchTerms', null, 'ARRAY');
		$orderBy                 = $data->json->getString('orderBy', null);
		$orderDir                = $data->json->getString('orderDir', null);

		$node = base64_decode($data->json->getString('node', ''));
		
		$priceFrom = $data->json->getFloat('priceFrom', null);
		$priceTo   = $data->json->getFloat('priceTo', null);

		if ($priceFrom)
		{
			$priceFrom = CurrencyFactory::toInt($priceFrom);
		}

		if ($priceTo)
		{
			$priceTo = CurrencyFactory::toInt($priceTo);
		}

		return ProductFactory::getGridAndFilterList(
			$limit, 
			$offset, 
			$categories, 
			$searchTerms, 
			$customFieldsSearchTerms, 
			$priceFrom, 
			$priceTo, 
			$variants,
			$filter_custom_fields,
			$options,
			$tags,
			$orderBy,
			$orderDir,
			json_decode($node, true)
		);
	}

}
