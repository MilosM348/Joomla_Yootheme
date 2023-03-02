<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

/**
 * Script File of CommerceLab Shop
 * @since 1.0
 */
class pkg_commercelab_shop_ShopsInstallerScript
{
    /**
     * Constructor
     *
     * @param $parent The object responsible for running this script
     *
     * @since 1.0
     */
    public function __construct($parent) {}

    /**
     * Called on installation
     *
     * @param $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function install($parent) {}

    /**
     * Called on uninstallation
     *
     * @param $parent The object responsible for running this script
     * @since 1.0
     */
    public function uninstall($parent) {}

    /**
     * Called on update
     *
     * @param $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function update($parent) {}

    /**
     * Called before any type of action
     *
     * @param string $type Which action is happening (install|uninstall|discover_install|update)
     * @param $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function preflight($type, $parent) {}

    /**
     * Called after any type of action
     *
     * @param string $type Which action is happening (install|uninstall|discover_install|update)
     * @param $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function postflight($type, $parent)
    {
        if ($type == 'install')
        {
            $db = Factory::getDbo();
            
            // Prepare plugin object
            $plugin          = new stdClass();
            $plugin->type    = 'plugin';
            $plugin->element = 'shops';
            $plugin->folder  = (string)'commercelab_shop_extended';
            $plugin->enabled = 1;
            // Update record
            $db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

            $plugin          = new stdClass();
            $plugin->type    = 'plugin';
            $plugin->element = 'commercelab_shop_shops';
            $plugin->folder  = (string)'system';
            $plugin->enabled = 1;
            // Update record
            $db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));

        }
    }

}
