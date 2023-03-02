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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\Model\AdminModel;

use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Render\Render;
use CommerceLabShop\Discount\DiscountFactory;
use CommerceLabShop\Utilities\Utilities;


/**
 *
 * @since       1.6
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
	public static $view = 'discount';

	public function __construct()
	{


		$input = Factory::getApplication()->input;
		$id    = $input->get('id');

		$this->init($id);

		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/'.self::$view.'/'.self::$view.'.php', $this->vars);


	}

	/**
	 *
	 * @return array
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
			$this->vars['item'] = $this->getTheItem($id);
		}

		$this->addScripts();
		$this->addStylesheets();


		$this->vars['form'] = $this->getForm(array('item' => $this->vars['item']), true);


	}

	/**
	 *
	 * @return array|false
	 *
	 * @since 2.0
	 */

	public function getTheItem($id)
	{
		return DiscountFactory::get($id);
	}

	/**
	 * @param   array  $data
	 * @param   bool   $loadData
	 *
	 * @return bool|JForm
	 *
	 * @since 2.0
	 */

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.

		$item = $data['item'];

		$form = $this->loadForm('com_commercelab_shop.discount', 'discount', array('control' => 'jform', 'load_data' => $loadData));

		if ($item)
		{
			$form->setValue('name', null, $item->name);
			$form->setValue('discount_type', null, $item->discount_type);
			$form->setValue('coupon_code', null, $item->coupon_code);
			$form->setValue('amount', null, $item->amount);
			$form->setValue('percentage', null, $item->percentage);
			$form->setValue('start_date', null, $item->start_date);
			$form->setValue('expiry_date', null, $item->expiry_date);
			$form->setValue('max_usage', null, $item->max_usage);
			// $form->setValue('user_id', null, $item->user_id);
			$form->setValue('published', null, $item->published);


		}

		return $form;
	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	private function addScripts()
	{

		$doc = Factory::getDocument();


		// include the vue script - defer
		$doc->addScript('../media/com_commercelab_shop/js/vue/'.self::$view.'/'.self::$view.'.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


		//set up data for vue:
		if ($this->vars['item'])
		{


			// format the date with a 'T' before the time to make it work with the datetime-local HTML5 element.
			if ($this->vars['item']->start_date) {
				$this->vars['item']->start_date = HtmlHelper::date($this->vars['item']->start_date, 'Y-m-d\TH:i:s');
			}
			if ($this->vars['item']->expiry_date) {
				$this->vars['item']->expiry_date = HtmlHelper::date($this->vars['item']->expiry_date, 'Y-m-d\TH:i:s');
			}
			foreach ($this->vars['item'] as $key => $value)
			{
				if (is_string($value))
				{
					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . $value . '</script>');
				}
				if(is_float($value)){
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
		Utilities::includePrime(array('inputswitch', 'inputtext', 'inputnumber'));


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

