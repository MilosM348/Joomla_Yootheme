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
	public static $view = 'currency';


	public function __construct()
	{


		$input = Factory::getApplication()->input;
		$id    = $input->get('id');

		$this->init($id);

		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/' . self::$view . '/' . self::$view . '.php', $this->vars);


	}

	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	private function init($id)
	{


		$this->vars['currency'] = CurrencyFactory::getDefault();
		$this->vars['locale']   = Factory::getLanguage()->get('tag');


		$this->vars['item'] = CurrencyFactory::get($id);

		$this->addScripts();
		$this->addStylesheets();


		$this->vars['form'] = $this->getForm(array('item' => $this->vars['item']), true);


	}


	/**
	 * @param   array  $data
	 * @param   bool   $loadData
	 *
	 * @return bool|JForm
	 *
	 * @since version
	 */

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.


		$form = $this->loadForm('com_commercelab_shop.' . self::$view, self::$view, array('control' => 'jform', 'load_data' => $loadData));


		$form->setValue('id', null, $this->vars['item']->id);
		$form->setValue('name', null, $this->vars['item']->name);
		$form->setValue('iso', null, $this->vars['item']->iso);
		$form->setValue('currencysymbol', null, $this->vars['item']->currencysymbol);
		$form->setValue('rate', null, $this->vars['item']->rate);
		$form->setValue('published', null, $this->vars['item']->published);

		return $form;

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
		$doc->addScript('../media/com_commercelab_shop/js/vue/' . self::$view . '/' . self::$view . '.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


		//set up data for vue:
		//set up data for vue:
		if ($this->vars['item'])
		{

			foreach ($this->vars['item'] as $key => $value)
			{
				if (is_string($value))
				{
					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . $value . '</script>');
				}

				if (is_integer($value))
				{
					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . $value . '</script>');
				}

				if (is_array($value))
				{
					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . json_encode($value) . '</script>');
				}
				if (is_object($value))
				{
					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . json_encode($value) . '</script>');
				}
			}

		}



		// include whatever PrimeVue component scripts we need
		Utilities::includePrime(array('inputswitch'));


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

