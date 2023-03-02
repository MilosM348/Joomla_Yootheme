<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access


defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Component\Content\Site\Model\ArticlesModel;

use CommerceLabShop\Product\ProductFactory;

class commercelab_shopTask_importarticle
{

	public function getResponse($data)
	{

        $article = $data->json->get('article', '', 'ARRAY');

        // If already a Product, do nothing
        if (ProductFactory::get($article['id']))
        {
            return true;
        }

        $app          = Factory::getApplication();
        $articleModel = $app->bootComponent('com_content')->getMVCFactory()->createModel('Article', 'Administrator', ['ignore_request' => true]);

        $article['attribs']['ispro2storeproduct'] = 1;

        return $articleModel->save((array) $article);

  //       $product                 = new stdClass();
  //       $product->id             = 0;
  //       $product->joomla_item_id = $data->json->getInt('article_id');
  //       $product->base_price     = 0;
  //       $product->short_desc     = $data->json->getString('introtext');
  //       $product->long_desc      = $data->json->getString('fulltext');

  //       $insert = $db->insertObject('#__commercelab_shop_product', $product);

		// return $insert;
	}

}
