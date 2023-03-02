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

use Joomla\Input\Input;
use CommerceLabShop\Config\ConfigFactory;


class commercelab_shopTask_validate
{

	public function getResponse(Input $data)
	{
        $watchful_key = $data->getString('watchful_key', '');
        $extension_id = $data->getInt('extension_id', 18);
        
        $save_key = $data->getInt('save_key', 0);
        $action   = $data->getString('action', 'status_show');
        $debug    = $data->getBool('debug', false);

        $validation = ConfigFactory::getClSubscription($extension_id, $action, $watchful_key, null, null, '1');

        if ($save_key && $validation[$action] == true)
        {
            $param_name  = 'subscription_key';
            $param_value = $watchful_key;

            ConfigFactory::updateComponentParams($param_name, $param_value);
        }

		return $validation;
	}

}
