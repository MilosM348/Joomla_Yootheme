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
use CommerceLabShop\Optiontemplates\Optiontemplates;

use Joomla\Input\Input;

class commercelab_shopTask_OptionValueslist
{

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse(Input $data)
	{

		$input = Factory::getApplication()->input;
		$option_id    = $input->get('option_id');
		return Optiontemplates::getTemplateOptionValuesList($option_id);
	//	return Optiontemplates::getOptionList($data);


	}

}
