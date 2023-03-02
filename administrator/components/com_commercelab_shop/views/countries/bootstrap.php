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

use Joomla\CMS\Language\Text;
use CommerceLabShop\Bootstrap\listView;
use CommerceLabShop\Render\Render;
use CommerceLabShop\Country\CountryFactory;
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
		$this->addTranslationStrings();


		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/countries/countries.php', $this->vars);

	}

	/**
	 *
	 * @return void
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


		$this->vars['items']          = $this->getItems();
		$this->vars['list_limit']     = Factory::getConfig()->get('list_limit', '25');


	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public function getItems(): ?array
	{

		return CountryFactory::getList(0, 0, false, '', 'published', 'desc');

	}


	/**
	 *
	 * @return void
	 * @since 2.0
	 */

	public function addScripts(): void
	{

		$doc = Factory::getDocument();

		// include the vue script - defer
		$doc->addScript('../media/com_commercelab_shop/js/vue/countries/countries.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));

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

		$doc = Factory::getDocument();

		$doc->addCustomTag('<script id="updatedMessage" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_UPDATED') . '</script>');
		$doc->addCustomTag('<script id="confirmLangString" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_DELETE_CONFIRM') . '</script>');
	}

}

