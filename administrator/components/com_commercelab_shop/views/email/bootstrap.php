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
use CommerceLabShop\Email\EmailFactory;
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
	public static $view = 'email';


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


		$this->vars['item']     = false;
		$this->vars['currency'] = CurrencyFactory::getDefault();
		$this->vars['locale']   = Factory::getLanguage()->get('tag');
		$this->vars['editor_name']           = (Factory::getApplication()->get('editor') == 'jce') ? 'tinymce' : Factory::getApplication()->get('editor');

		if ($id)
		{
			$this->vars['item'] = EmailFactory::get($id);
		}

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

		$item = $data['item'];


		$form = $this->loadForm('com_commercelab_shop.email', 'email', array('control' => 'jform', 'load_data' => $loadData));

		if ($item)
		{

			$form->setValue('body', null, $item->body);


		}

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
		$doc->addScript('../media/com_commercelab_shop/js/vue/email/email.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


		//set up data for vue:
		if ($this->vars['item'])
		{
			$doc->addCustomTag('<script id="cls_email_form_data" type="application/json">' . json_encode($this->vars['item']) . '</script>');
			$doc->addCustomTag('<script id="editor" type="application/json">' . $this->vars['editor_name'] . '</script>');
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

