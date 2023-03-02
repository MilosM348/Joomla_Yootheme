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

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Shipping\Shipping;
use CommerceLabShop\Total\TotalFactory;
use CommerceLabShop\Shipping\ShippingFactory;


class plgCommercelab_shop_shippingDefaultshipping extends JPlugin


{
    protected $autoloadLanguage = true;

    function __construct(&$subject, $config)
    {
        $language = Factory::getLanguage();
        $language->load('com_commercelab_shop', JPATH_ADMINISTRATOR);
        parent::__construct($subject, $config);

    }


    public function onCalculateShippingdefaultshipping(Cart $cart)
    {

        if ($this->params->get('threshold_enable'))
        {
            $threshold = $this->params->get('threshold_value');
            $threshold = preg_replace("/[^0-9]/", "", $threshold);

            if ($cart->subtotalInt > ($threshold * 100))
            {
                return 0;
            }
        }


        if ($this->params->get('order_flat_enable'))
        {
            return ($this->params->get('order_flat_value') * 100);
        }

        if ($this->params->get('capping_enable'))
        {
            switch ($this->params->get('capping_type')) {
                case 'value' :
                    $shippingTotal = ShippingFactory::calculateTotalShipping($cart);
                    $cap = ($this->params->get('capping_value') * 100);
                    if ($shippingTotal >= $cap) {
                        return $cap;
                    }
                    break;
                case 'expensive' :
                    return Shipping::calculateMostExpensiveItemShipping();
            }
        }

        return ShippingFactory::calculateTotalShipping($cart);

    }


}
