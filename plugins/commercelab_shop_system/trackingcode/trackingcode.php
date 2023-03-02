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

jimport('joomla.plugin.plugin');

use Joomla\CMS\Factory;
use CommerceLabShop\Order\Order;
use CommerceLabShop\Orderlog\Orderlog;

class plgCommercelab_shop_systemTrackingcode extends JPlugin
{

    private $db;
    private $order;

    public function onGetTrackingCode($orderId)
    {

    }

    public function onSaveTrackingCode($orderId, $code, $type)
    {

    }





}
