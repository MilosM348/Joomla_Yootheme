<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Route;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Application;
use CommerceLabShop\Utilities\Utilities;

class Route
{

    private $input;
    public $route;

    public function __construct()
    {
        $this->input = Factory::getApplication()->input;

        $currentRoute = $this->input->get('view');


        if ($currentRoute) {
            $routeData = $currentRoute;
            if ($routeid = $this->input->get('id')) {
                $routeData = $currentRoute . '/' . $routeid;
            }
        } else {
            $routeData = '';
        }

        $this->route = $routeData;

    }


}
