<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

Factory::getDocument()->addScript('../media/com_commercelab_shop/js/vue/modules/latestorders/latestorders.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


// Render the module
require ModuleHelper::getLayoutPath('mod_ps2latestorders', $params->get('layout', 'default'));
