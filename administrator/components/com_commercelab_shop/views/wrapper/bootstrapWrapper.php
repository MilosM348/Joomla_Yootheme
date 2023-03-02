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
use Joomla\CMS\Version;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;

use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Render\Render;

/**
 *
 * @since 2.0
 */
class bootstrapWrapper
{

	/**
	 * @var array $vars
	 * @since 2.0
	 */
	protected $valid_subscription;
	public $vars;

	/**
	 * @var string $view
	 * @since 2.0
	 */
	public static $view = 'wrapper';

	public function __construct()
	{
		$is_active = ConfigFactory::getClSubscription(18, 'status_show', '', null);

		if ($is_active['status_show'])
		{
			$this->init();
			echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/'.self::$view.'/'.self::$view.'.php', $this->vars);
		}
		else
		{
			echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/inactive/inactive.php', ['message_html' => $is_active['message_html']]);	
		}

		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/inactive/catchaddons.php', []);	
	}

	/**
	 * @return void
	 *
	 * @since 2.0
	 */

	private function init()
	{
		$this->setVars();
		$this->addScripts();
		$this->addStylesheets();
	}


	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	private function setVars()
	{
		$this->vars['currency']      = CurrencyFactory::getDefault();
		$this->vars['locale']        = Factory::getLanguage()->get('tag');
		$this->vars['breadcrumbs']   = $this->getBreadcrumbs();
		$this->vars['templateStyle'] = $this->getYtpTemplate();
		$this->vars['nighTheme']     = $this->setNightTheme();
	}

	private function getBreadcrumbs()
	{

		$breadcrumbs = array();


		$input = Factory::getApplication()->input;
		$view  = !empty($input->getString('view'))?$input->getString('view'):"Dashboard";
		switch ($view) {
			case "shippingratescountries":
			  $view = "COUNTRY SHIPPING RATES";
			  break;
			case "shippingrateszones":
			  $view = "ZONE SHIPPING RATES";
			  break;
			case "emaillogs":
			  $view = "EMAIL LOGS";
			  break;
			case "emailmanager":
			  $view = "EMAIL MANAGER";
			  break;
			case "shows":
			  $view = "SHOWS";
			  break;
		}
		$breadcrumbs[] = $view;

//		if ($id = $input->get('id'))
//		{
//			$breadcrumbs[] = $this->getBreadcrumbItem($view, $id);
//		}

		return $breadcrumbs;


	}

	private function getBreadcrumbItem($view, $id)
	{

	}

	/**
	 * Function to add the scripts to the header
	 *
	 * @since 2.0
	 */
	
	/**
	 * Function to get active YOOtheme Pro template ID
	 *
	 * @return int
	 *
	 * @since 2.0
	 */

	private function getYtpTemplate()
	{
        $db = Factory::getDbo();
        $db->setQuery(
            'SELECT id, params from #__template_styles WHERE client_id = 0 ORDER BY home DESC'
        );

        foreach ($db->loadObjectList() as $templ) {
            $params = new Registry($templ->params);

            if ($params->get('yootheme')) {
                return $templ;
            }
        }
	}
	
	private function setNightTheme()
	{
		// if(!isset($_COOKIE['cls_backend_theme']) || $_COOKIE['cls_backend_theme'] == 'nighTheme') {
		if(isset($_COOKIE['cls_backend_theme']) && $_COOKIE['cls_backend_theme'] == 'nighTheme') {
			return true;
		}

		return false;
	}
	

	private function addScripts()
	{

		$doc = Factory::getDocument();


		$doc->addScript('../media/com_commercelab_shop/js/bundleadmin.js', array('type' => 'text/javascript'));
		$doc->addScript('../media/com_commercelab_shop/js/bundleuikit.min.js', array('type' => 'text/javascript'));


		$doc->addCustomTag('<script id="base_url" type="application/json">' . Uri::base() . '</script>');
		$doc->addCustomTag(' <script id="currency" type="application/json">' . json_encode($this->vars['currency']) . '</script>');
		$doc->addCustomTag(' <script id="locale" type="application/json">' . $this->vars['locale'] . '</script>');


	}

	/**
	 * Function to add the styles to the header
	 *
	 * @return void
	 *
	 * @since 2.0
	 */


	private function addStylesheets()
	{

		$doc     = Factory::getDocument();
		$session = Factory::getSession();
		$app     = Joomla\CMS\Factory::getApplication();

		if ($app->getName() == 'administrator') {
			$doc->addStyleSheet("../media/com_commercelab_shop/css/bundle.min.css");
		}
		$doc->addStyleSheet("https://unpkg.com/primeicons@5.0.0/primeicons.css");
		$doc->addStyleSheet("../media/com_commercelab_shop/css/custom.css?".time());
		if($session->get('animation') == false){
			$doc->addStyleSheet("../media/com_commercelab_shop/css/animation.css?".time());
		}		

	}


}

