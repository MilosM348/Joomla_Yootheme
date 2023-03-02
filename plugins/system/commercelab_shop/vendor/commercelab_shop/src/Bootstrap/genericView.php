<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Bootstrap;

// no direct access
defined('_JEXEC') or die('Restricted access');


interface genericView
{

	/**
	 *
	 * @return mixed
	 *
	 * @since 2.0
	 */
	public function init(): void;

	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */
	public function setVars(): void;

	/**
	 *
	 * @return void
	 *
	 * @since v1.6
	 */
	public function addScripts(): void;

	/**
	 *
	 * @return void
	 *
	 * @since v1.6
	 */
	public function addStylesheets(): void;

	/**
	 *
	 * @return void
	 *
	 * @since v1.6
	 */
	
	public function addTranslationStrings(): void;




}
