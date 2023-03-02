<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\ProductAddon;

use stdClass;

class ProductAddon
{

	/** @var string $id */
	public $id;

	/** @var string $title */
	public $title;

	/** @var array $fields */
	public $fields;

	/** @var string $fi $htmlelds */
	public $html;


	public function __construct(stdClass $data)
	{
		$this->id     = $data->id;
		$this->title  = $data->title;
		$this->fields = $data->fields;
		$this->html   = $data->html;
	}

}
