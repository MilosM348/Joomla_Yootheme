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

use CommerceLabShop\Render\Render;
use CommerceLabShop\Bootstrap\listView;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Optiontemplates\Optiontemplates;

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
	public static $view = 'optiontemplateoptions';

	public function __construct()
	{
		$this->init();
		$this->addScripts();
		$this->addStylesheets();
		$this->addTranslationStrings();
		$this->setVars();

		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/'.self::$view.'/'.self::$view.'.php', $this->vars);

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

	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	public function setVars(): void
	{
		$this->vars['template_name'] = $this->getTamplateName();
		$this->vars['items']         = $this->getItems();
		$this->vars['list_limit']    = Factory::getConfig()->get('list_limit', '25');
	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	public function getItems(): ?array
	{
		$input       = Factory::getApplication()->input;
		$template_id = $input->get('template_id');
		return Optiontemplates::getTemplateOptionList($template_id);
	}

	public function getTamplateName()
	{
		$input       = Factory::getApplication()->input;
		$template_id = $input->get('template_id');
		return Optiontemplates::getOptionTemplate($template_id)->name;
	}


	/**
	 *
	 *
	 * @since 2.0
	 */

	public function addScripts(): void
	{

		Utilities::includePrime(array('inputswitch', 'button', 'chip', 'chips', 'inputtext', 'inputnumber'));
		// include the vue script - defer
		$input = Factory::getApplication()->input;
		$template_id    = $input->get('template_id');
		$doc	=	Factory::getDocument();
		$doc->addScript('../media/com_commercelab_shop/js/vue/'.self::$view.'/'.self::$view.'.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));
		$doc->addCustomTag(' <script id="template_id" type="application/json">' . $template_id . '</script>');
		Utilities::includePrime(array('inputswitch','primevue'));

	}




	public function addStylesheets(): void
	{
		// TODO: Implement addStylesheets() method.
	}

	public function addTranslationStrings(): void
	{
		// TODO: Implement addTranslationStrings() method.
		// TODO: Implement addTranslationStrings() method.
		$doc = Factory::getDocument();
		$doc->addCustomTag('<script id="confirmLangString" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_DELETE_ARE_YOU_SURE') . '</script>');
	}
}

