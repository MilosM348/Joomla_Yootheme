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

jimport('joomla.plugin.plugin');


use CommerceLabShop\Email\EmailFactory;


class plgCommercelab_shop_systemEmailer extends JPlugin
{

	/**
	 * @param   string  $emailType
	 * @param   int     $order_id
	 *
	 *
	 * @throws Exception
	 * @since 2.0
	 */

	public function onSendCommerceLabShopEmail(string $emailType, int $order_id)
	{
		return EmailFactory::send($emailType, $order_id, $this->params->get('layout', 'default'), 'emailer');
	}

}
