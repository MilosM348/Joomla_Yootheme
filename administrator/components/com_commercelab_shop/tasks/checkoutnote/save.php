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

use CommerceLabShop\Checkoutnote\CheckoutnoteFactory;
use CommerceLabShop\Checkoutnote\Checkoutnote;

class commercelab_shopTask_save
{

	public function getResponse($data): ?Checkoutnote
	{

		return CheckoutnoteFactory::save($data);


	}

}
