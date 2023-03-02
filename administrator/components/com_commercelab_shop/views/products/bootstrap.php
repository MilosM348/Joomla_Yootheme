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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

use CommerceLabShop\Bootstrap\listView;
use CommerceLabShop\Render\Render;
use CommerceLabShop\Product\ProductFactory;
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
	public static $view = 'products';


	public function __construct()
	{
		$this->init();
		$this->setVars();
		$this->addScripts();
		$this->addStylesheets();
		$this->addTranslationStrings();


		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/' . self::$view . '/' . self::$view . '.php', $this->vars);

	}

	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	public function init(): void
	{


	}

	public function setVars(): void
	{
		$items = $this->getItems();
		$this->vars['items']                    = $items['items'];
		$this->vars['pages']                    = (int) ceil($items['totalfiltered'] / 20);
		$this->vars['categories']               = $this->getCategories();
		$this->vars['list_limit']               = Factory::getConfig()->get('list_limit', 20);
		$this->vars['filter_category_selector'] = Route::_('index.php?option=com_categories&view=categories&layout=modal&tmpl=component&function=filterByCategory&' . Session::getFormToken() . '=1');
		$this->vars['change_category_selector'] = Route::_('index.php?option=com_categories&view=categories&layout=modal&tmpl=component&function=batchChangeCategory&' . Session::getFormToken() . '=1');

	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	public function addScripts(): void
	{
		$doc = Factory::getDocument();

		// include the vue script - defer
		$doc->addScript('../media/com_commercelab_shop/js/vue/' . self::$view . '/' . self::$view . '.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));

		$doc->addCustomTag('<script id="items_data" type="application/json">' . json_encode($this->vars['items']) . '</script>');
		$doc->addCustomTag('<script id="pages_data" type="application/json">' . $this->vars['pages'] . '</script>');
		$doc->addCustomTag('<script id="categories_data" type="application/json">' . json_encode($this->vars['categories']) . '</script>');
		$doc->addCustomTag('<script id="page_size" type="application/json">' . $this->vars['list_limit'] . '</script>');

		// include prime
		Utilities::includePrime(array('inputtext', 'inputnumber'));

	}

	/**
	 *
	 * @return array|false
	 *
	 * @since 2.0
	 */

	public function getItems(): ?array
	{
		return ProductFactory::getList();
	}


	/**
	 *
	 *
	 * @since 2.0
	 */

	public function addStylesheets(): void
	{

	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	public function addTranslationStrings(): void
	{
		$doc = Factory::getDocument();


		$doc->addCustomTag('<script id="confirmLangString" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_ORDER_ATTACH_CUSTOMER_CONFIRM_MODAL') . '</script>');
	}

	/**
	 *
	 * @return array|mixed
	 *
	 * @since 2.0
	 */


	// TODO - are we stil using this?
	private function getCategories()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__categories'));
		$query->where($db->quoteName('extension') . ' = ' . $db->quote('com_content'));

		$db->setQuery($query);

		return $db->loadObjectList();


	}

}

