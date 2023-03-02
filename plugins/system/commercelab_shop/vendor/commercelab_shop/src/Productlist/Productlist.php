<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Productlist;

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use CommerceLabShop\Product\Product;

class Productlist
{


    public static function getListByCategory($catid, $ordering, $listDirection, $limit = false)
    {

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select('id');
        $query->from($db->quoteName('#__content'));
        $query->where($db->quoteName('catid') . ' = ' . $db->quote($catid));
        $query->order($db->quoteName($ordering) . ' ' . $listDirection);

        if($limit) {
            $query->setLimit($limit);
        }

        $db->setQuery($query);

        $results = $db->loadColumn();

        $products = array();

        foreach ($results as $product) {
            $products[] = new Product($product);
        }

        return $products;


    }

    public static function getListByTags($tags = array(), $ordering, $listDirection)
    {
        $tags = (array)$tags;

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select('content_item_id');
        $query->from($db->quoteName('#__contentitem_tag_map'));
        $query->where($db->quoteName('tag_id') . ' IN (' . implode(",", $tags) . ')');
        $query->group($db->quoteName('content_item_id'));

        $db->setQuery($query);

        $results = $db->loadColumn();

        $results = self::getItemsByIds($results, $ordering, $listDirection);

        $products = array();

        foreach ($results as $product) {
            $products[] = new Product($product);
        }

        return $products;


    }


    private static function getItemsByIds($ids = array(), $ordering, $listDirection)
    {

        $ids = (array)$ids;

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select('id');
        $query->from($db->quoteName('#__content'));
        $query->where($db->quoteName('id') . ' IN (' . implode(",", $ids) . ')');
        $query->order($db->quoteName($ordering) . ' ' . $listDirection);

        $db->setQuery($query);

        return $db->loadColumn();

    }

}
