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
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Render\Render;
use CommerceLabShop\Shippingrate\ShippingrateFactory;
use CommerceLabShop\Utilities\Utilities;


/**
 *
 * @since       1.6
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
	public static $view = 'shippingrateszones';

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
	 * @return array
	 *
	 * @since 2.0
	 */

	public function init(): void
	{

	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public function getItems(): ?array
	{

		if($items = ShippingrateFactory::getZoneList()) {
			return $items;
		}
		return array();
	}

	public function setVars(): void
	{
		$this->vars['items']      = $this->getItems();
		$this->vars['countries']  = CountryFactory::getList(0,0,true);
		$this->vars['zones']  = CountryFactory::getZoneList(0,0,true);
		$this->vars['list_limit'] = Factory::getConfig()->get('list_limit', '25');
	}

	public function addScripts(): void
	{
		$doc = Factory::getDocument();


		// include the vue script - defer
		$doc->addScript('../media/com_commercelab_shop/js/vue/'.self::$view.'/'.self::$view.'.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));

		$doc->addCustomTag('<script id="items_data" type="application/json">' . json_encode($this->vars['items']) . '</script>');
		$doc->addCustomTag('<script id="countries_data" type="application/json">' . json_encode($this->vars['countries']) . '</script>');
		$doc->addCustomTag('<script id="zones_data" type="application/json">' . json_encode($this->vars['zones']) . '</script>');
		$doc->addCustomTag('<script id="page_size" type="application/json">' . $this->vars['list_limit'] . '</script>');


		// include prime
		Utilities::includePrime(array('inputtext', 'inputnumber'));

	}

	public function addStylesheets(): void
	{
		// TODO: Implement addStylesheets() method.
	}

	public function addTranslationStrings(): void
	{
		$doc = Factory::getDocument();


		$doc->addCustomTag('<script id="confirmLangString" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_ORDER_ATTACH_CUSTOMER_CONFIRM_MODAL') . '</script>');
		// TODO: Implement addTranslationStrings() method.
	}
}

