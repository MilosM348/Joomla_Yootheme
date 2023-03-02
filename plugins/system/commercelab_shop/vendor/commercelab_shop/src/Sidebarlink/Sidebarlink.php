<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Sidebarlink;

// no direct access
defined('_JEXEC') or die('Restricted access');


class Sidebarlink
{
	public $hasParent;
	public $view;
	public $linkText;
	public $icon;
	public $subLinks;

	public function __construct($data)
	{

		$this->view     = $this->_setView($data->view);
		$this->view_name= $data->view;
		$this->linkText = $data->linkText;
		$this->icon     = $data->icon;
		if (isset($data->hasParent) && $data->hasParent)
		{
			$this->hasParent = $data->hasParent;
			if (isset($data->subLinks))
			{
				$this->subLinks = $data->subLinks;
			}
			else
			{
				$this->subLinks = [];
			}

		}
		else
		{
			$this->hasParent = false;
			$this->subLinks  = [];
		}


	}

	/**
	 * @param   string  $view
	 *
	 * @return string
	 *
	 * @since 2.0
	 */


	private function _setView(string $view): string
	{
		return 'index.php?option=com_commercelab_shop&view=' . $view;
	}

}
