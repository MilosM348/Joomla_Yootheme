<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
namespace CommerceLabShop\Emailer;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use stdClass;

class Emailer
{

    protected $db;

    public $order_status;

    public function __construct($order_status)
    {
        $this->db = Factory::getDbo();
        $this->initMailer($order_status);
    }


    private function initMailer($order_status)
    {

        $this->order_status = $order_status;

    }


    public function send() {

    }



}
