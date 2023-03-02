<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Vat;
// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vat
{

    private $db;


    public function __construct($id)
    {
        $this->db = Factory::getDbo();



    }


}
