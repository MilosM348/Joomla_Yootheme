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

JHTML::_('behavior.modal');

use Joomla\CMS\Factory;

/**
 * Script File of CommerceLabShop Component
 * @since 1.0
 */
class pkg_commercelab_shop_mollieInstallerScript
{
    /**
     * Constructor
     *
     * @param JAdapterInstance $parent The object responsible for running this script
     *
     * @since 1.0
     */
    public function __construct(JAdapterInstance $parent)
    {
    }

    /**
     * Called on installation
     *
     * @param JAdapterInstance $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function install(JAdapterInstance $parent)
    {


    }

    /**
     * Called on uninstallation
     *
     * @param JAdapterInstance $parent The object responsible for running this script
     * @since 1.0
     */
    public function uninstall(JAdapterInstance $parent)
    {


    }

    /**
     * Called on update
     *
     * @param JAdapterInstance $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function update(JAdapterInstance $parent)
    {
    }

    /**
     * Called before any type of action
     *
     * @param string $type Which action is happening (install|uninstall|discover_install|update)
     * @param JAdapterInstance $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function preflight($type, JAdapterInstance $parent)
    {


    }

    /**
     * Called after any type of action
     *
     * @param string $type Which action is happening (install|uninstall|discover_install|update)
     * @param JAdapterInstance $parent The object responsible for running this script
     *
     * @return  boolean  True on success
     * @since 1.0
     */
    public function postflight($type, JAdapterInstance $parent)
    {

        if ($type == 'install') {

            $db = Factory::getDbo();
            
            // Prepare plugin object
            $plugin = new stdClass();
            $plugin->type = 'plugin';
            $plugin->element = 'mollie';
            $plugin->folder = (string)'commercelab_shop_payment';
            $plugin->enabled = 1;
            // Update record
            $db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));



            $plugin = new stdClass();
            $plugin->type = 'plugin';
            $plugin->element = 'commercelab_shop_mollie';
            $plugin->folder = (string)'system';
            $plugin->enabled = 1;
            // Update record
            $db->updateObject('#__extensions', $plugin, array('type', 'element', 'folder'));


        }
    }

}
