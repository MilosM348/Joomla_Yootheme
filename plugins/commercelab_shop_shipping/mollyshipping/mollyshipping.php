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

use CommerceLabShop\Shipping\Shipping;


class plgCommercelab_shop_shippingMollyshipping extends JPlugin
{


    public function onCalculateShipping($integer, $float)
    {

//        return '$10';

        if($integer) {
            return '1000';
        }

        return '$10';



    }


}
