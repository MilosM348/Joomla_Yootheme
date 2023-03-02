<?php
/**
 * @package     Pro2Store - Stripe Element
 * @subpackage  com_protostore
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - pro2store - https://pro2.store. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Config\ConfigFactory;

use YOOtheme\Application;
use YOOtheme\Path;

class plgSystemCommercelab_Shop_mollieadvanced extends CMSPlugin
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

        // $validation = ConfigFactory::getAddonClSubscription(9);
        // if (!$validation['status_show'])
        // {
        //     if (Factory::getApplication()->isClient('administrator') && Factory::getApplication()->input->get('option', '') == 'com_commercelab_shop')
        //     {
        //         Factory::getApplication()->enqueueMessage($validation['message_html'], 'error');
        //     }

        //     return;
        // }

        if (class_exists(Application::class, false)) {

            $app = Application::getInstance();

            $root    = __DIR__;
            $rootUrl = Uri::root(true);

            $themeroot = Path::get('~theme');
            $loader = require "{$themeroot}/vendor/autoload.php";
            $loader->setPsr4("YpsApp_mollieadvanced\\", __DIR__ . "/modules/mollieadvanced");

            // set alias
            Path::setAlias('~commercelab_shop_mollieadvanced', $root);
            Path::setAlias('~commercelab_shop_mollieadvanced:rel', $rootUrl . '/plugins/system/commercelab_shop_mollieadvanced');

            // bootstrap modules
            $app->load('~commercelab_shop_mollieadvanced/modules/mollieadvanced/bootstrap.php');

        }
        // $this->db = Factory::getDbo();

        // // Get some component information first:
        // $component = $this->getExtensionData();

        // $extension                 = new stdClass;
        // $extension->update_site_id = $this->getUpdateSiteId($component->extension_id);
        // $extension->name           = $component->name;
        // $extension->type           = 'extension';

        // // Link to the PRO version updater XML:
        // $extension->location = 'https://app.commercelab.shop/index.php?option=com_rdsubs&view=updater&format=xml&element=commercelab_shop_mollie_advanced';

        // $extension->enabled              = 1;
        // $extension->last_check_timestamp = 0;
        // $extension->extra_query          = 'key=' . $this->params->get('update_key');

        // if ($this->getUpdateSiteId($component->extension_id))
        // {
        //     // Update the object
        //     $this->db->updateObject('#__update_sites', $extension, 'update_site_id');

        // }
        // else
        // {


        //     // Insert the object.
        //     $this->db->insertObject('#__update_sites', $extension);
        //     // Get the ID of the inserted item:
        //     $update_site_id = $this->db->insertid();

        //     $update                 = new stdClass;
        //     $update->update_site_id = $update_site_id;
        //     $update->extension_id   = $component->extension_id;

        //     // Insert the object.
        //     $this->db->insertObject('#__update_sites_extensions', $update);
        // }


    }


    private function getExtensionData()
    {


        $query = $this->db->getQuery(true);

        $query->select('*');
        $query->from($this->db->quoteName('#__extensions'));
        $query->where($this->db->quoteName('element') . ' = ' . $this->db->quote('commercelab_shop_mollieadvanced'));

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

        if($result) {
            return $result;
        } else {
            return false;
        }

    }

}
