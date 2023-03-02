<?php
/**
 * @package     CommerceLab Shop - PayPal Element
 * @subpackage  com_commercelab_shop
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop - https://Commercelab.solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Plugin\PluginHelper;

use YOOtheme\Application;
use YOOtheme\Path;


class plgSystemCommerceLab_Shop_paypal extends CMSPlugin
{

    private $db;

    public function onAfterInitialise()
    {

        if (!ComponentHelper::getComponent('com_commercelab_shop', true)->enabled) {
            return;
        }

        if (!PluginHelper::isEnabled('system', 'commercelab_shop')) {
            return;
        }


        if (!class_exists(Application::class, false)) {
            return;
        }


        $app = Application::getInstance();

        $root = __DIR__;
        $rootUrl = Uri::root(true);

        $themeroot = Path::get('~theme');
        $loader = require "{$themeroot}/vendor/autoload.php";
        $loader->setPsr4("YpsApp_paypal\\", __DIR__ . "/modules/paypal");

        // set alias
        Path::setAlias('~commercelab_shop_paypal', $root);
        Path::setAlias('~commercelab_shop_paypal:rel', $rootUrl . '/plugins/system/commercelab_shop_paypal');

        // bootstrap modules
        $app->load('~commercelab_shop_paypal/modules/paypal/bootstrap.php');

    }


    private function getExtensionData()
    {


        $query = $this->db->getQuery(true);

        $query->select('*');
        $query->from($this->db->quoteName('#__extensions'));
        $query->where($this->db->quoteName('element') . ' = ' . $this->db->quote('commercelab_shop_paypal'));

        $this->db->setQuery($query);

        return $this->db->loadObject();


    }


    private function getUpdateSiteId($extension_id)
    {
        $query = $this->db->getQuery(true);

        $query->select('update_site_id');
        $query->from($this->db->quoteName('#__update_sites_extensions'));
        $query->where($this->db->quoteName('extension_id') . ' = ' . $this->db->quote($extension_id));

        $this->db->setQuery($query);

        $result = $this->db->loadResult();

        if ($result) {
            return $result;
        } else {
            return false;
        }

    }

}
