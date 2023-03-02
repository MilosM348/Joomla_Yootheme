<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Setup;
// no direct access
defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Version;
use Joomla\Input\Input;

use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Language\LanguageFactory;
use CommerceLabShop\Utilities\Utilities;

use stdClass;
use Exception;

class SetupFactory
{


	/**
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */

	public static function isSetup(): bool
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_setup'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote('1'));
		$query->where("(".$db->quoteName('value') . ' = 1 OR '.$db->quote('value'). ' = "true")');

		$db->setQuery($query);

		if ($db->loadResult())
		{
			return true;
		}

		return false;
	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @throws Exception
	 * @since 2.0
	 */

	public static function init(Input $data)
	{

		// init
		$db = Factory::getDbo();

		$shopName            = $data->json->getString('shopName');
		$shopEmail           = $data->json->getString('shopEmail');
		$defaultCurrencyId   = $data->json->getInt('selectedCurrency');
		$defaultCountryId    = $data->json->getInt('selectedCountry');
		$createCheckout      = $data->json->getBool('createCheckout');
		$createEmptyCheckout = $data->json->getBool('createEmptyCheckout');
		$createConfirmation  = $data->json->getBool('createConfirmation');
		$createTandcs        = $data->json->getBool('createTandcs');
		$createCancel        = $data->json->getBool('createCancel');


		// First do currency
		// First set all items to 0
		$query  = $db->getQuery(true);
		$fields = $db->quoteName('default') . ' = 0';
		$query->update($db->quoteName('#__commercelab_shop_currency'))->set($fields);
		$db->setQuery($query);
		$db->execute();


		// Now update the row we need to be the default
		$object            = new stdClass();
		$object->id        = $defaultCurrencyId;
		$object->default   = 1;
		$object->rate      = 1;
		$object->published = 1;

		$db->updateObject('#__commercelab_shop_currency', $object, 'id');


		// now do country
		// First set all items to 0
		$query  = $db->getQuery(true);
		$fields = array($db->quoteName('default') . ' = 0');
		$query->update($db->quoteName('#__commercelab_shop_country'))->set($fields);
		$db->setQuery($query);
		$db->execute();

		// Now update the row we need to be the default
		$object            = new stdClass();
		$object->id        = $defaultCountryId;
		$object->default   = 1;
		$object->published = 1;

		$db->updateObject('#__commercelab_shop_country', $object, 'id');

		$country              = [];
		$country['id']        = $defaultCountryId;
		$country['published'] = 1;

		// now do the zones:
		CountryFactory::updateZoneList($country);

		// now do Shop Name etc
		ConfigFactory::updateComponentParams('shop_name', $shopName);
		ConfigFactory::updateComponentParams('supportemail', $shopEmail);

		// now do page creation

		self::createPage('checkout');
		self::createPage('cart');
		self::createPage('confirmation');
		self::createPage('tandcs');

		$object        = new stdClass();
		$object->id    = 1;
		$object->value = 1;

		$result = $db->updateObject('#__commercelab_shop_setup', $object, 'id');

		if ($result)
		{
			return true;
		}

		return false;


	}

	/**
	 * @param   string  $pageType
	 *
	 *
	 * @since 2.0
	 */

	private static function createPage(string $pageType)
	{

		LanguageFactory::load();

		$db = Factory::getDbo();

		$title = Text::_('COM_COMMERCELAB_SHOP_' . strtoupper($pageType) . '_PAGE_TITLE');

		switch($pageType)
		{

			case 'checkout';
			case 'confirmation';
			case 'cart';
			case 'tandcs';
				$remote_content = file_get_contents('https://raw.githubusercontent.com/CommerceLabSolutions/ComLab_Shop-Demo_Content/main/articles/' . $pageType . '/fulltext.json');
				break;

			default:
				$remote_content = $title . ' Content';
				break;
		}

		$object              = new stdClass();
		$object->id          = 0;
		$object->title       = $title;
		$object->alias       = Utilities::generateUniqueAlias(OutputFilter::stringURLSafe($title));
		$object->state       = 1;
		$object->access      = 1;
		$object->catid       = 2;
		$object->introtext = '';
		$object->fulltext  = $remote_content;
		// $object->short_desc  = "";
		// $object->long_desc   = "";
		$object->created     = Utilities::getDate();
		$object->publish_up  = Utilities::getDate();
		$object->created_by  = Factory::getUser()->id;
		$object->modified    = Utilities::getDate();
		$object->modified_by = Factory::getUser()->id;
		$object->images      = '{"image_intro":"","image_intro_alt":"","float_intro":"","image_intro_caption":"","image_fulltext":"","image_fulltext_alt":"","float_fulltext":"","image_fulltext_caption":""}';
		$object->urls        = '{"urla":"","urlatext":"","targeta":"","urlb":"","urlbtext":"","targetb":"","urlc":"","urlctext":"","targetc":""}';
		$object->attribs     = '{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}';
		$object->version     = 1;
		$object->language    = '*';
		$object->metakey     = '';
		$object->metadesc    = '';
		$object->hits        = 0;
		$object->metadata    = '{"robots":"","author":"","rights":""}';
		$object->featured    = 0;
		$object->language    = '*';

		$result    = $db->insertObject('#__content', $object);
		$newItemid = $db->insertid();

		//J4 workflows

		if (Version::MAJOR_VERSION === 4)
		{
			$object            = new stdClass();
			$object->item_id   = $newItemid;
			$object->stage_id  = 1;
			$object->extension = 'com_content.article';

			$db->insertObject('#__workflow_associations', $object);
		}

		if ($result)
		{

			//add menu
			$menuid = self::createCommerceLabShopMenuIfNotExists();

			$object               = new stdClass();
			$object->id           = 0;
			$object->menutype     = 'commercelabshop';
			$object->title        = Text::_('COM_COMMERCELAB_SHOP_' . strtoupper($pageType) . '_PAGE_TITLE');
			$object->alias        = Utilities::generateUniqueAlias(OutputFilter::stringURLSafe($title), 'menu');
			$object->path         = $object->alias;
			$object->link         = 'index.php?option=com_content&view=article&id=' . $newItemid;
			$object->type         = 'component';
			$object->published    = 1;
			$object->parent_id    = 1;
			$object->level        = 1;
			$object->img          = "";
			$object->params       = "";
			$object->client_id    = 0;
			$object->access       = 1;
			$object->component_id = self::getComponentId();
			$object->language     = '*';
			$object->home         = 0;

			$result      = $db->insertObject('#__menu', $object);
			$newMenuItem = $db->insertid();

			if ($result)
			{

				$setParams = null;
				switch ($pageType)
				{
					case 'checkout':
						$setParams = 'checkout_page_url';
						break;
					case 'confirmation':
						$setParams = 'confirmation_page_url';
						break;
					case 'tandcs':
						$setParams = 'terms_and_conditions_url';
						break;
					case 'cart':
						$setParams = 'cart_page_url';
						break;
				}

				if ($setParams)
				{
					ConfigFactory::updateComponentParams($setParams, $newMenuItem);
				}

			}

		}
	}

	/**
	 *
	 * @return int
	 *
	 * @since 2.0
	 */

	private static function createCategoryIfNotExists(): int
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__categories'));
		$query->where($db->quoteName('title') . ' = ' . $db->quote('Commerce'));

		$db->setQuery($query);
	
		$result = $db->loadObject();

		if ($result)
		{
			return $result->id;
		}
		else
		{
			$object                = new stdClass();
			$object->parent_id     = 1;
			$object->access        = 1;
			$object->path          = 'commerce';
			$object->extension     = 'com_content';
			$object->title         = "Commerce";
			$object->alias         = "commerce";
			$object->published     = 1;
			$object->language      = "*";
			$object->lft			= 1;
			$object->rgt 			= 2;
			$object->created_time  = Utilities::getDate();
			$object->modified_time = Utilities::getDate();
			$db->insertObject('#__categories', $object);
			return $db->insertid();
		}

	}

	/**
	 *
	 * @return int
	 *
	 * @since 2.0
	 */

	private static function createCommerceLabShopMenuIfNotExists(): int
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__menu_types'));
		$query->where($db->quoteName('menutype') . ' = ' . $db->quote('commercelabshop'));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return $result->id;
		}
		else
		{
			$object            = new stdClass();
			$object->id        = 0;
			$object->asset_id  = 0;
			$object->menutype  = 'commercelabshop';
			$object->title     = 'CommerceLab Shop Menu';
			$object->client_id = 0;

			$db->insertObject('#__menu_types', $object);

			return $db->insertid();
		}


	}

	private static function createCartModuleInstance(): int
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__modules'))
			->where($db->quoteName('module') . ' = ' . $db->quote('mod_commercelab_shop_cart'))
			->where($db->quoteName('position') . ' = ' . $db->quote('navbar'));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return $result->id;
		}

		$object            = new stdClass();
		$object->id        = 0;

		$object->title     = 'CommerceLab Shop - Cart';
		$object->position  = 'navbar';
		$object->published = 1;
		$object->access    = 1;
		$object->showtitle = 0;
		$object->module    = 'mod_commercelab_shop_cart';

		// $object->asset_id  = 0;

		$object->client_id = 0;
		$object->language  = '*';

		$object->params = file_get_contents('https://raw.githubusercontent.com/CommerceLabSolutions/ComLab_Shop-Demo_Content/main/modules/mod_commercelab_shop_cart/params.json');

		$db->insertObject('#__modules', $object);

		// Menu Association

		$object            = new stdClass();
		$object->id        = 0;

		$object->moduleid = $db->insertid();
		$db->insertObject('#__modules_menu', $object);
		
		return true;
	}

	private static function createCartModuleMobilesInstance(): int
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__modules'))
			->where($db->quoteName('module') . ' = ' . $db->quote('mod_commercelab_shop_cart'))
			->where($db->quoteName('position') . ' = ' . $db->quote('navbar-mobile'));

		$db->setQuery($query);

		$result = $db->loadObject();

		if ($result)
		{
			return $result->id;
		}

		$object            = new stdClass();
		$object->id        = 0;

		$object->title     = 'CommerceLab Shop - Cart - Mobile';
		$object->position  = 'navbar-mobile';
		$object->published = 1;
		$object->access    = 1;
		$object->showtitle = 0;
		$object->module    = 'mod_commercelab_shop_cart';

		// $object->asset_id  = 0;

		$object->client_id = 0;
		$object->language  = '*';

		$object->params = file_get_contents('https://raw.githubusercontent.com/CommerceLabSolutions/ComLab_Shop-Demo_Content/main/modules/mod_commercelab_shop_cart/params.json');

		$db->insertObject('#__modules', $object);

		// Menu Association

		$object            = new stdClass();
		$object->id        = 0;

		$object->moduleid = $db->insertid();
		$db->insertObject('#__modules_menu', $object);
		
		return true;
	}

	private static function getComponentId()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('extension_id');
		$query->from($db->quoteName('#__extensions'));
		$query->where($db->quoteName('name') . ' = ' . $db->quote('com_content'));

		$db->setQuery($query);

		return $db->loadResult();

	}


}