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

use Joomla\CMS\Factory;


class commercelab_shopTask_openclose
{

	public function getResponse($data)
	{
        if(empty($data->json->get('sidemenu'))){
            $session = Factory::getSession();
            $session->clear('sidemenu');
        }else{
            $session = Factory::getSession();
            $session->set('sidemenu', "openmenu");
        }
       
		return true;
	}

}
