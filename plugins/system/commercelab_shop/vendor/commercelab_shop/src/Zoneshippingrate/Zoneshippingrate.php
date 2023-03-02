<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Zoneshippingrate;
// no direct access
defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;

use CommerceLabShop\Currency\Currency;

use Brick\Money\Money;
use Brick\Money\Context\CashContext;
use Brick\Math\RoundingMode;

class Zoneshippingrate
{

    private $db;

    public $id;
    public $zone_id;
    public $zone_name;
    public $weight_from;
    public $weight_to;
    public $cost;
    public $costAsFloat;
    public $handling_cost;
    public $handling_costAsFloat;
    public $published;

    public function __construct($id)
    {
        $this->db = Factory::getDbo();

        $this->initZoneShippingrate($id);


    }

    private function initZoneShippingrate($id)
    {

        $query = $this->db->getQuery(true);

        $query->select('*');
        $query->from($this->db->quoteName('#__commercelab_shop_zone_shipping_rate'));
        $query->where($this->db->quoteName('id') . ' = ' . $this->db->quote($id));

        $this->db->setQuery($query);

        $result = $this->db->loadObject();

        $this->id            = $id;
        $this->zone_id       = $result->zone_id;
        $this->zone_name     = $this->getZoneName($result->zone_id);
        $this->country_id    = $this->getCountryId($result->zone_id);
        $this->weight_from   = $result->weight_from;
        $this->weight_to     = $result->weight_to;
        $this->cost          = $result->cost;
        $this->costAsFloat = $this->getCostAsFloat();
        $this->handling_cost = $result->handling_cost;
        $this->handling_costAsFloat = $this->getHandlingCostAsFloat();
        $this->published     = $result->published;

    }

    private function getZoneName($id)
    {
        $query = $this->db->getQuery(true);

        $query->select('zone_name');
        $query->from($this->db->quoteName('#__commercelab_shop_zone'));
        $query->where($this->db->quoteName('id') . ' = ' . $this->db->quote($id));

        $this->db->setQuery($query);

        return $this->db->loadResult();
    }


    private function getCountryId($id)
    {

        $query = $this->db->getQuery(true);

        $query->select('country_id');
        $query->from($this->db->quoteName('#__commercelab_shop_zone'));
        $query->where($this->db->quoteName('id') . ' = ' . $this->db->quote($id));

        $this->db->setQuery($query);

        return $this->db->loadResult();

    }


    private function getCostAsFloat()
    {
        $currency = new Currency();

        if ($this->cost) {

            $cost = Money::ofMinor($this->cost, $currency->_getDefaultCurrencyFromDB()->iso,new CashContext(1), RoundingMode::DOWN);

            return $cost->getAmount();


        }
    }

    private function getHandlingCostAsFloat()
    {
        $currency = new Currency();

        if ($this->handling_cost) {

            $handling_cost = Money::ofMinor($this->handling_cost, $currency->_getDefaultCurrencyFromDB()->iso,new CashContext(1), RoundingMode::DOWN);

            return $handling_cost->getAmount();


        }
    }


}



