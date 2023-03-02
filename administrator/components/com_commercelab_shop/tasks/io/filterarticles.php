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
use Joomla\Input\Input;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Component\Content\Site\Model\ArticlesModel;
use Joomla\Component\Content\Administrator\Model\ArticleModel;

class commercelab_shopTask_filterarticles
{

	public function getResponse($data)
	{

        $app          = Factory::getApplication();
        $model        = $app->bootComponent('com_content')->getMVCFactory()->createModel('Articles', 'Administrator', ['ignore_request' => true]);

		$search      = $data->json->getString('search', null);
		$language    = $data->json->getString('language', null);

		$featured    = $data->json->getBool('featured', null);
		$published   = $data->json->getBool('published', null);

		$level       = $data->json->getInt('level', null);

		$category_id = $data->json->get('category_id', null, 'ARRAY');
		$access      = $data->json->get('access', null, 'ARRAY');
		$author_id   = $data->json->get('author_id', null, 'ARRAY');

		// Set application parameters in model
		$model->setState('params', ComponentHelper::getParams('com_content'));

        if ($search) {
        	$model->setState('filter.search', $search);
        }

        if ($language) {
        	$model->setState('filter.language', $language);
        }

        if ($featured) {
        	$model->setState('filter.featured', $featured);
        }

        if ($published) {
        	$model->setState('filter.published', $published);
        }

        if ($level) {
        	$model->setState('filter.level', $level);
        }

        if ($category_id) {
        	$model->setState('filter.category_id', $category_id);
        }

        if ($access) {
        	$model->setState('filter.access', $access);
        }

        if ($author_id) {
        	$model->setState('filter.author_id', $author_id);
        }

		return $model->getItems();

	}

}
