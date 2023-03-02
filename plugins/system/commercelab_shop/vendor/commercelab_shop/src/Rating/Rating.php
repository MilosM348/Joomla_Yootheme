<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Rating;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

use CommerceLabShop\Utilities\Utilities;
use stdClass;

class Rating
{

    private $app;
    private $db;

    public $id;
    public $jitem_id;
    public $user_id;
    public $cookie_id;
    public $value;
    public $ip;
    public $created;

    public function __construct($jitem_id, $userId)
    {

        $this->app = Factory::getApplication();
        $this->db = Factory::getDbo();
        $this->jitem_id = $jitem_id;
        $this->cookie_id = $this->app->input->cookie->get('yps-cart', null);

        if ($userId !== 0) {
            $this->user_id = $userId;
            $this->initByUser();
        } else {
            $this->initByCookie();
        }

    }


    private function initByUser()
    {

        $query = $this->db->getQuery(true);

        $query->select('*');
        $query->from($this->db->quoteName('#__commercelab_shop_rating'));
        $query->where($this->db->quoteName('jitem_id') . ' = ' . $this->db->quote($this->jitem_id));
        $query->where($this->db->quoteName('user_id') . ' = ' . $this->db->quote($this->user_id));

        $this->db->setQuery($query);

        $result = $this->db->loadObject();

        if ($result) {
            $this->id = $result->id;
            $this->value = $result->value;
            $this->ip = $result->ip;
            $this->created = $result->created;
        } else {
            if (!$this->checkMerge()) {
                $this->create();
            }


        }


    }

    private function initByCookie()
    {

        $query = $this->db->getQuery(true);

        $query->select('*');
        $query->from($this->db->quoteName('#__commercelab_shop_rating'));
        $query->where($this->db->quoteName('jitem_id') . ' = ' . $this->db->quote($this->jitem_id));
        $query->where($this->db->quoteName('cookie_id') . ' = ' . $this->db->quote($this->cookie_id));

        $this->db->setQuery($query);

        $result = $this->db->loadObject();

        if ($result) {
            $this->id = $result->id;
            $this->value = $result->value;
            $this->ip = $result->ip;
            $this->created = $result->created;
        } else {
            $this->create();
        }


    }

    private function checkMerge()
    {

        $this->initByCookie();
        if ($this->save()) {
            return true;
        }

        return false;

    }

    private function create()
    {

        $object = new stdClass();
        $object->id = 0;
        $object->jitem_id = $this->jitem_id;
        $object->user_id = Factory::getUser()->id;
        $object->cookie_id = $this->cookie_id;
        $object->value = 0;
        $object->ip = $_SERVER['REMOTE_ADDR'];
        $object->created = Utilities::getDate();

        $this->db->insertObject('#__commercelab_shop_rating', $object);

    }

//    SETTERS

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function save()
    {

        $result = $this->db->updateObject('#__commercelab_shop_rating', $this, 'id');

        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public static function getAverageRating($itemId)
    {
        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select('SUM(value)');
        $query->from($db->quoteName('#__commercelab_shop_rating'));
        $query->where($db->quoteName('jitem_id') . ' = ' . $db->quote($itemId));

        $db->setQuery($query);

        $sum = $db->loadResult();

        $query = $db->getQuery(true);

        $query->select('COUNT(*)');
        $query->from($db->quoteName('#__commercelab_shop_rating'));
        $query->where($db->quoteName('jitem_id') . ' = ' . $db->quote($itemId));

        $db->setQuery($query);

        $count = $db->loadResult();
        $number = $sum / $count;

        return round($number, 2);

    }

}
