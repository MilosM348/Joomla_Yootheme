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

use CommerceLabShop\Bootstrap\listView;
use CommerceLabShop\Render\Render;
use CommerceLabShop\Customer\CustomerFactory;
use CommerceLabShop\Utilities\Utilities;

/**
 *
 * @since 2.0
 */
class bootstrap implements listView
{

	/**
	 * @var array $vars
	 * @since 2.0
	 */
	public $vars;

	/**
	 * @var string $view
	 * @since 2.0
	 */
	public static $view = 'customers';


	public function __construct()
	{
		$this->init();
		$this->setVars();
		$this->addScripts();
		$this->addStylesheets();
		$this->addTranslationStrings();


		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/'.self::$view.'/'.self::$view.'.php', $this->vars);

	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	public function init(): void
	{


	}


	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	public function setVars(): void
	{

		$this->vars['items']      = $this->getItems();
		$this->vars['list_limit'] = Factory::getConfig()->get('list_limit', '25');

	}

	/**
	 *
	 * @return array|false
	 *
	 * @since 2.0
	 */

	public function getItems(): ?array
	{


		return CustomerFactory::getList();

	}


	/**
	 *
	 *
	 * @since 2.0
	 */

	public function addScripts(): void
	{


		// include the vue script - defer
		$doc = Factory::getDocument();
		$doc->addScript('../media/com_commercelab_shop/js/vue/'.self::$view.'/'.self::$view.'.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));
		$doc->addCustomTag('<script id="items_data" type="application/json">' . json_encode($this->vars['items']) . '</script>');
		$doc->addCustomTag('<script id="page_size" type="application/json">' . $this->vars['list_limit'] . '</script>');

		// include prime
		Utilities::includePrime(array('inputswitch'));


	}

	/**
	 *
	 *
	 * @since 2.0
	 */	
	
	public function addStylesheets(): void
	{
		// TODO: Implement addStylesheets() method.
	}

	/**
	 *
	 *
	 * @since 2.0
	 */
	
	public function addTranslationStrings(): void
	{
		// TODO: Implement addTranslationStrings() method.
	}

}

