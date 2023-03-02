<?php
/**
 * @package   CommerceLab Shop
 * @author    Cloud Chief - CommerceLab.solutions
 
 * @copyright Copyright (C) 2021 Cloud Chief - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\Config\ConfigFactory;

use YOOtheme\Path;
use YOOtheme\Application;

class plgSystemCommercelab_shop_gallery extends CMSPlugin
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

        // $validation = ConfigFactory::getAddonClSubscription(10);

        // if (!$validation['status_show'])
        // {
        //     if (Factory::getApplication()->isClient('administrator') 
        //         && Factory::getApplication()->input->get('option', '') == 'com_commercelab_shop')
        //     {
        //         Factory::getApplication()->enqueueMessage($validation['message_html'], 'error');
        //     }

        //     return;
        // }

        $this->db = Factory::getDbo();

        // Get some component information first:
        $component = $this->getExtensionData();

        $extension                 = new stdClass;
        $extension->update_site_id = $this->getUpdateSiteId($component->extension_id);
        $extension->name           = $component->name;
        $extension->type           = 'extension';

        // Link to the PRO version updater XML:
        $extension->location = 'https://app.commercelab.shop/index.php?option=com_rdsubs&view=updater&format=xml&element=commercelab_shop_gallery';

        $extension->enabled              = 1;
        $extension->last_check_timestamp = 0;
        $extension->extra_query          = 'key=' . $this->params->get('update_key');

        if ($this->getUpdateSiteId($component->extension_id))
        {

            // Update the object
            $this->db->updateObject('#__update_sites', $extension, 'update_site_id');

        }
        else
        {

            // Insert the object.
            $this->db->insertObject('#__update_sites', $extension);
            // Get the ID of the inserted item:
            $update_site_id = $this->db->insertid();

            $update = new stdClass;
            $update->update_site_id = $update_site_id;
            $update->extension_id = $component->extension_id;

            // Insert the object.
            $this->db->insertObject('#__update_sites_extensions', $update);
        }


        if (class_exists(Application::class, false))
        {

            $app = Application::getInstance();

            $root    = __DIR__;
            $rootUrl = Uri::root(true);

            $themeroot = Path::get('~theme');
            $loader    = require "{$themeroot}/vendor/autoload.php";
            $loader->setPsr4("YpsApp_Gallery\\", __DIR__ . "/modules/commercelab_shop_gallery");

            // set alias
            Path::setAlias('~commercelab_shop_gallery', $root);
            Path::setAlias('~commercelab_shop_gallery:rel', $rootUrl . '/plugins/system/commercelab_shop_gallery');

            // bootstrap modules
            $app->load('~commercelab_shop_gallery/modules/commercelab_shop_gallery/bootstrap.php');

        }
    }

    public function ongetgallery($payload)
    {

        $payload = json_decode($payload);
        
        $currentProductId = $payload;

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select(array('id','path'))
            ->from($db->quoteName('#__commercelab_shop_gallery'))
            ->where($db->quoteName('product_j_id') . ' = ' . $db->quote($currentProductId))
            ->order('ordering ASC');

        $db->setQuery($query);

        // $result = $db->loadObjectList();

        // $images = [];
        // foreach ($result as $key => $value) {
        //     $images[$value->id] = [
        //         'id' => $value->id,
        //     ]
        // }

        return $db->loadObjectList();
    }

    public function onsavegallery($payload)
    {
      
        $db = Factory::getDbo();
        // $payload = json_decode($payload);

        //first remove all current entries for this product:

        $query = $db->getQuery(true);
        
        // now iterate over the selected images and insert.
        $i = 0;
        foreach ($payload->images as $image) {
            $object               = new stdClass();
            $object->id           = 0;
            $object->product_j_id = $payload->itemid;
            $object->path         = implode('/', $payload->paths) . '/' . $image;
            $object->ordering     = $i;

            $db->insertObject('#__commercelab_shop_gallery', $object);
            $i++;
        }

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select(array('id','path'))
            ->from($db->quoteName('#__commercelab_shop_gallery'))
            ->where($db->quoteName('product_j_id') . ' = ' . $db->quote($payload->itemid))
            ->order('ordering ASC');

        $db->setQuery($query);

        return $db->loadObjectList();

    }

    private function getExtensionData()
    {

        $query = $this->db->getQuery(true);

        $query->select('*')
            ->from($this->db->quoteName('#__extensions'))
            ->where($this->db->quoteName('element') . ' = ' . $this->db->quote('commercelab_shop_gallery'));

        $this->db->setQuery($query);

        return $this->db->loadObject();

    }

    private function getUpdateSiteId($extension_id)
    {
        $query = $this->db->getQuery(true);

        $query->select('update_site_id')
            ->from($this->db->quoteName('#__update_sites_extensions'))
            ->where($this->db->quoteName('extension_id') . ' = ' . $this->db->quote($extension_id));

        $this->db->setQuery($query);

        $result = $this->db->loadResult();

        if ($result)
        {
            return $result;
        }

        return false;

    }

}
