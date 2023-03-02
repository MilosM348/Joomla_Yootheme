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
require_once(__DIR__ . '/vendor/autoload.php');

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Session\Session;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;

use YOOtheme\Application;
use YOOtheme\Path;

use CommerceLabShop\Setup\SetupFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Currency\CurrencyFactory;


class plgSystemCommercelab_shop extends CMSPlugin
{

	public function onAfterInitialise()
	{

		if (!ComponentHelper::getComponent('com_commercelab_shop', true)->enabled)
		{
			return;
		}

		//import VUE on the frontend
		$app = Factory::getApplication();
		$doc = Factory::getDocument();

		if (Version::MAJOR_VERSION === 4)
		{
			$wa  = Factory::getDocument()->getWebAssetManager();
		}

		// Loading Usefull Variables within Joomla global JS var
		$doc->addScriptDeclaration("
			Joomla_cls = {
				uri_base: '" . Uri::base() . "',
				token: '" . Session::getFormToken() . "',
				checkoutLink: '" . Route::_(ConfigFactory::getSystemRedirectUrls()->checkout->short) . "',
				selectedOptions: {},
				selectedVariants: {}
			};
		");

		if ($app->isClient('site') && $app->input->get('p', false) != 'customizer')
		{

			if (Version::MAJOR_VERSION === 4)
			{
			    if (!$wa->assetExists('script', 'cls_bundle'))
			    {
			        $wa->registerScript('cls_bundle', 'media/com_commercelab_shop/js/bundle.min.js');
			        $wa->useScript('cls_bundle');
			    }
			}
			else
			{
				$doc->addScript('media/com_commercelab_shop/js/bundle.min.js', array('type' => 'text/javascript'));
			}

			// $doc->addScript('media/com_commercelab_shop/js/bundle.min.js', array('type' => 'text/javascript'), array('async' => 'async'));
			// $doc->addStyleDeclaration('[v-cloak] {display: none}');

		}
		// $doc->addScriptDeclaration("Joomla_cls.gaf = Vue.reactive({});");
		$doc->addStyleDeclaration('[v-cloak] {display: none}');

		// set the CommerceLab Shop Cookie
		$value = $app->input->cookie->get('yps-cart', null);
		if ($value == null)
		{
			$value = md5(Factory::getSession()->getId());
			$time  = 0;
			$app->input->cookie->set(
				'yps-cart',
				$value,
				$time,
				$app->get('cookie_path', '/'),
				$app->get('cookie_domain'),
				$app->isSSLConnection()
			);
		}

		//check if the setup is done

		if (SetupFactory::isSetup())
		{
			$value = $app->input->cookie->get('yps-currency', null);
			if ($value == null)
			{
				$currency = CurrencyFactory::getDefault();
				$app->input->cookie->set('yps-currency', $currency->id, 0, $app->get('cookie_path', '/'), $app->get('cookie_domain'), $app->isSSLConnection());
			}
		}


		if (class_exists(Application::class, false))
		{

			$app = Application::getInstance();

			$root    = __DIR__;
			$rootUrl = Uri::root(true);

			$themeroot = Path::get('~theme');
			$loader    = require "{$themeroot}/vendor/autoload.php";
			$loader->setPsr4("YpsApp\\", __DIR__ . "/modules/core");

			// set alias
			Path::setAlias('~commercelab_shop', $root);
			Path::setAlias('~commercelab_shop:rel', $rootUrl . '/plugins/system/commercelab_shop');

			// bootstrap modules
			$app->load('~commercelab_shop/modules/core/bootstrap.php');
		}

	}

	public function onAfterRoute(){
		if (Version::MAJOR_VERSION === 3) : 
			$app = Factory::getApplication();
			if( $app->isAdmin() && $app->input->get('option')=='com_commercelab_shop'){
				$doc = Factory::getDocument();
				$doc->addStyleDeclaration('
					.brand-logo-block{
						bottom:0px;
						top:0px;
					}
					header{
						display:none;
					}
					#p2s_leftCol{
						top:30px;
						
					}
				');
			}
		endif;	
	}

	public function onAfterDispatch() {


		$app = Factory::getApplication();
		$doc = Factory::getDocument();

		// Hidding Joomla Article Editor
		if ($app->isClient('administrator') 
			&& $app->input->get('option') == 'com_content' 
			&& $app->input->get('view') == 'article'
			&& $app->input->get('layout') == 'edit'
		) {

			if($app->input->get('id', null)) {
				
				$j_id = $app->input->get('id');
				$product = ProductFactory::get($j_id);
				if ($product) {
					// $doc->addScript('/media/com_commercelab_shop/js/bundle.min.js', array('type' => 'text/javascript'));
					// $doc->addStyleDeclaration('[v-cloak] {display: none}');
					HTMLHelper::_('jquery.framework');
					$doc->addStyleDeclaration('
						#editor-xtd-buttons, .toggle-editor.btn-toolbar, .adminform > * {
							display: none;
						}
						.cls_redirect {
							background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
							background-size: 400% 400%;
							animation: gradient 15s ease infinite;
							width: 100%;
							text-align: center;
							display: block !important;

							// background-size: cover !important;
							// background: url("'.Uri::root().'media/com_commercelab_shop/images/Article_Editor_BG_Image.jpg") center center;
						}
						.cls_redirect > div {
							padding: 40px 20px;
						}
						.cls_redirect img {
							margin: 50px auto 0;
							width: 350px;
							max-width: 100%;					
							height: auto;
						}
						.cls_redirect a {
							display: block;
							box-sizing: border-box;
							max-width: 280px;
							margin: 50px auto 100px;
							padding: 20px 30px;
							border-radius: 2px;
							background: linear-gradient(140deg,#67FEFE,#1B5E82);
							box-shadow: inset 0 0 1px 0 rgb(0 0 0 / 50%);
							line-height: 14px;
							color: #fff!important;
							font-size: 11px;
							font-weight: 700;
							font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif;
							text-align: center;
							text-decoration: none!important;
							text-transform: uppercase;
							letter-spacing: 2px;
							-webkit-font-smoothing: antialiased;
						}
						.cls_redirect a span {
							display: inline-block;
							color: white;
						}


						@keyframes gradient {
							0% {
								background-position: 0% 50%;
							}
							50% {
								background-position: 100% 50%;
							}
							100% {
								background-position: 0% 50%;
							}
						}
					');

					$doc->addScriptDeclaration("
						jQuery(document).ready(function($) {
							var htmlToAdd = $(\"<div class='cls_redirect'><div><img src='".Uri::root()."media/com_commercelab_shop/images/CommerceLab_logo.png' width='569' height='148'><a title='" . Text::_('Open Product in CLS') . "' href='index.php?option=com_commercelab_shop&view=product&id=" . $j_id . "'><span>" . Text::_('Open Product in CLS') . "</span></a></div></div>\");
							var editor = $('.col-lg-9');
							if (!editor.length) {
								var editor = $('.span9');
							}
							editor[0].append(htmlToAdd[0]);
						});
					");
				}		
			}
		}
	}


	public function onUpdateAddonsValidation()
	{

		$filepath = JPATH_SITE . '/plugins/system/commercelab_shop/vendor/commercelab_shop/src/Watchful';

		if (is_dir($filepath))
		{
			$files = array_diff(scandir($filepath), array('.', '..'));
			foreach($files as $file){
				ConfigFactory::getClSubscription((int) str_replace('validate_', '', $file), 'status_show', '', $filepath . '/' . $file);
			}
		}

	}

	// Thir Party Extensions Changes

	public function onExtensionAfterInstall($description, $params, $return = null) {}

	public function onExtensionAfterUpdate($description, $params, $return = null) {}

}
