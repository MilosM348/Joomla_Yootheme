<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2021 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;

use CommerceLabShop\Order\OrderFactory;

PluginHelper::importPlugin('commercelab_shop_payment');


$type    = Factory::getApplication()->input->getString('paymenttype');
$payload = @file_get_contents('php://input');

$callback          = new stdClass;
$callback->type    = $type;
$callback->payload = $payload;
$callback->post    = json_encode($_POST);
$callback->server  = json_encode($_SERVER);

// Factory::getDbo()->insertObject('#__commercelab_shop_callback_log', $callback);

Factory::getApplication()->triggerEvent('onHook' . $type, [
    'payload'   => $payload, 
    'post'      => $_POST, 
    'server'    => $_SERVER
]);


return;
