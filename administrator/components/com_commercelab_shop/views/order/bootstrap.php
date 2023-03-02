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
use Joomla\CMS\MVC\Model\AdminModel;

use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Render\Render;
use CommerceLabShop\Utilities\Utilities;


/**
 *
 * @since       2.0
 */
class bootstrap extends AdminModel
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
	public static $view = 'order';


	public function __construct()
	{


		$input = Factory::getApplication()->input;
		$id    = $input->get('id');

		$this->init($id);

		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/'.self::$view.'/'.self::$view.'.php', $this->vars);


	}

	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	private function init($id)
	{


		$this->vars['item']     = false;
		$this->vars['currency'] = CurrencyFactory::getDefault();
		$this->vars['locale']   = Factory::getLanguage()->get('tag');

		if ($id)
		{
			$this->vars['item'] = OrderFactory::get($id);
		}

		$this->addScripts();
		$this->addStylesheets();



	}


	/**
	 * @param   array  $data
	 * @param   bool   $loadData
	 *
	 * @return bool
	 *
	 * @since version
	 */

	public function getForm($data = array(), $loadData = true): bool
	{


		return false;
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
		$doc->addScript('../media/com_commercelab_shop/js/vue/'.self::$view.'/'.self::$view.'.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


		//set up data for vue:
		if ($this->vars['item'])
		{


				$doc->addCustomTag('<script id="p2s_order" type="application/json">' . json_encode($this->vars['item']) . '</script>');


		}


		// include whatever PrimeVue component scripts we need
		Utilities::includePrime(array('inputswitch', 'timeline', 'avatar'));


	}

	/**
	 *
	 *
	 * @since version
	 */

	private function addStylesheets()
	{
	}

}

