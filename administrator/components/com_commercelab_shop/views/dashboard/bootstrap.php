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

use Joomla\CMS\Date\Date;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

use CommerceLabShop\Render\Render;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Dashboard\DashboardFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Product\ProductFactory;


/**
 *
 * @since       1.6
 */
class bootstrap
{

	private $vars;

	public function __construct()
	{
		$this->init();
		$this->setVars();
		$this->addScripts();
		$this->addStylesheets();
		$this->addTranslationStrings();


		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/dashboard/dashboard.php', $this->vars);


	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	private function init()
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

		$this->vars['currencysymbol']  = CurrencyFactory::getDefault()->currencysymbol;
		$this->vars['orders']          = OrderFactory::getList(5)['items'];
		$this->vars['total_sales']     = OrderFactory::totalSales();
		$this->vars['total_orders']    = OrderFactory::totalOrders();
		$this->vars['total_customers'] = DashboardFactory::totalCustomers();
		$this->vars['products']        = ProductFactory::getList()['items'];
		$this->vars['now']             = new Date('now');
		$this->vars['list_limit']      = Factory::getConfig()->get('list_limit', '25');


		// Bestsellers list
		$this->vars['bestSellers'] = DashboardFactory::getBestsellers();

		// order stats grid
		$this->vars['orderStats']  = DashboardFactory::getOrderStats();


		// Sales Chart
		$this->vars['months']      = DashboardFactory::getMonths();
		$this->vars['monthsSales'] = DashboardFactory::getMonthsSales();

		// Donut chart
		$donutData                   = DashboardFactory::getDataForCategoryDonut();
		$this->vars['categories']    = $donutData['categories'];
		$this->vars['categorySales'] = $donutData['categorySales'];
		$this->vars['colours']       = $donutData['colours'];

	}



	/**
	 *
	 *
	 * @since version
	 */

	private function addScripts()
	{

		$doc = Factory::getDocument();

		// include the vue script - defer
		$doc->addScript('/media/com_commercelab_shop/js/vue/dashboard/dashboard.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


		$doc->addCustomTag('<script id="orders_data" type="application/json">' . json_encode($this->vars['orders']) . '</script>');

		// include prime
//		Utilities::includePrime(array('chart'));


	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	private function addStylesheets()
	{
	}

	/**
	 *
	 *
	 * @since 2.0
	 */


	private function addTranslationStrings()
	{

		$doc = Factory::getDocument();


		$doc->addCustomTag('<script id="successMessage" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED') . '</script>');

	}

}

