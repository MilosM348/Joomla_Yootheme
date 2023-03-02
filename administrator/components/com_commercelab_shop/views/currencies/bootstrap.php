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
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Utilities\Utilities;

/**
 *
 * @since 2.0
 */
class bootstrap implements listView
{

	public $vars;

	public function __construct()
	{
		$this->init();
		$this->setVars();
		$this->addScripts();
		$this->addStylesheets();
		$this->addTranslationStrings();


		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/currencies/currencies.php', $this->vars);

	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	public function init(): void
	{
		return;

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


		return CurrencyFactory::getList(0, 0, true, '', 'published', 'desc');

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
		$doc->addScript('../media/com_commercelab_shop/js/vue/currencies/currencies.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));
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
		return;
	}

	/**
	 *
	 *
	 * @since 2.0
	 */


	public function addTranslationStrings(): void
	{
		return;
	}


}

