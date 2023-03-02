<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\Utilities;

defined('_JEXEC') or die('Restricted access');

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\String\StringHelper;
use Joomla\CMS\Plugin\PluginHelper;

use CommerceLabShop\Cart\Cart;
use CommerceLabShop\Address\Address;
use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\Product\Product;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Product\ProductFactory;

use DateTimeZone;


class Utilities
{


	public static function getUserListForSelect()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select(array('id', 'name'));
		$query->from($db->quoteName('#__users'));

		$db->setQuery($query);

		return $db->loadObjectList();

	}

	/**
	 *
	 * @return int|null
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function getCurrentItemId(): ?int
	{

		$input = Factory::getApplication()->input;

		if ($input->get('option') == 'com_content')
		{
			if ($input->get('view') == 'article')
			{
				return $input->getInt('id');
			}
		}

		return null;


	}

	public static function getUrlFromMenuItem($id)
	{
		$menuItem = Factory::getApplication()->getMenu()->getItem($id);

		if ($menuItem)
		{
			return $menuItem->link;
		}


	}

	public static function getFieldId($name)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__fields'));
		$query->where($db->quoteName('name') . ' = ' . $db->quote($name));

		$db->setQuery($query);

		return $db->loadResult();

	}

	public static function getFieldValue($fieldid, $itemid)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('value');
		$query->from($db->quoteName('#__fields_values'));
		$query->where($db->quoteName('field_id') . ' = ' . $db->quote($fieldid));
		$query->where($db->quoteName('item_id') . ' = ' . $db->quote($itemid));

		$db->setQuery($query);

		return $db->loadResult();

	}

	public static function getCategory($itemid)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query
			->select(array('a.catid', 'b.title'))
			->from($db->quoteName('#__content', 'a'))
			->join('INNER', $db->quoteName('#__categories', 'b') . ' ON ' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('b.id'))
			->where($db->quoteName('a.id') . ' = ' . $db->quote($itemid));

		$db->setQuery($query);

		$result = $db->loadObject();

		return $result->title;

	}


	public static function getCategories()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__categories'));
		$query->where($db->quoteName('extension') . ' = ' . $db->quote('com_content'));
		$query->where($db->quoteName('published') . ' = 1');

		$db->setQuery($query);


		return $db->loadObjectList();


	}


	public static function getCategoriesForOptions()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select(array('id', 'title'));
		$query->from($db->quoteName('#__categories'));
		$query->where($db->quoteName('extension') . ' = ' . $db->quote('com_content'));
		$query->where($db->quoteName('published') . ' = 1');

		$db->setQuery($query);

		$results = $db->loadObjectList();

		$categories = array();

		foreach ($results as $result)
		{
			$categories[$result->title] = $result->id;
		}

		return $categories;


	}

	public static function getCatList($parent = 'root', $showCount = 1)
	{
		$options               = array();
		$options['countItems'] = $showCount;

		$categories = \Joomla\CMS\Categories\Categories::getInstance('Content', $options);
		$category   = $categories->get($parent);

		if ($category !== null)
		{
			$items = $category->getChildren();

			$count = 0;

			if ($count > 0 && count($items) > $count)
			{
				$items = array_slice($items, 0, $count);
			}

			return array($category);
		}
	}

	public static function getCatListagain($parent = 'root', $showCount = 1)
	{
		$options               = array();
		$options['countItems'] = $showCount;

		$categories = \Joomla\CMS\Categories\Categories::getInstance('Content', $options);
		$category   = $categories->get($parent);

		if ($category !== null)
		{
			$items = $category->getChildren();

			$count = 0;

			if ($count > 0 && count($items) > $count)
			{
				$items = array_slice($items, 0, $count);
			}

			return $items;
		}
	}


	public static function getTags()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);
		$query->select('a.*');

		// Select the required fields from the table.
		$query->from($db->quoteName('#__tags', 'a'))
			->where($db->quoteName('a.alias') . ' <> ' . $db->quote('root'))
			->where($db->quoteName('published') . ' = 1')
			->where($db->quoteName('level') . ' > 0');

		// Count Items
		$subQueryCountTaggedItems = $db->getQuery(true);
		$subQueryCountTaggedItems
			->select('COUNT(' . $db->quoteName('tag_map.content_item_id') . ')')
			->from($db->quoteName('#__contentitem_tag_map', 'tag_map'))
			->where($db->quoteName('tag_map.tag_id') . ' = ' . $db->quoteName('a.id'));
		$query->select('(' . (string) $subQueryCountTaggedItems . ') AS ' . $db->quoteName('countTaggedItems'));

		$db->setQuery($query);


		return $db->loadObjectList();


	}


	public static function getAllProducts()
	{

		$products = array();

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('joomla_item_id');
		$query->from($db->quoteName('#__commercelab_shop_product'));

		$db->setQuery($query);

		$results = $db->loadColumn();

		foreach ($results as $result)
		{
			$products[] = new Product($result);
		}

		return $products;


	}

	public static function getProductsByCategory($catid)
	{

		$products = array();

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('a.joomla_item_id');
		$query->from($db->quoteName('#__commercelab_shop_product', 'a'));
		$query->join('INNER', $db->quoteName('#__content', 'b') . ' ON ' . $db->quoteName('a.joomla_item_id') . ' = ' . $db->quoteName('b.id'));
		$query->where($db->quoteName('b.catid') . ' = ' . $db->quote($catid));

		$db->setQuery($query);

		$results = $db->loadColumn();

		foreach ($results as $result)
		{
			$products[] = new Product($result);
		}

		return $products;


	}

	public static function getProductsByCategories($catids = array())
	{

		if (!is_array($catids))
		{
			$catids = array($catids);
		}

		$products = array();

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('a.joomla_item_id');
		$query->from($db->quoteName('#__commercelab_shop_product', 'a'));
		$query->join('INNER', $db->quoteName('#__content', 'b') . ' ON ' . $db->quoteName('a.joomla_item_id') . ' = ' . $db->quoteName('b.id'));
		$query->where($db->quoteName('b.catid') . ' IN ( ' . implode(',', $catids) . ')');
		$query->where($db->quoteName('b.state') . ' = 1');

		$db->setQuery($query);

		$results = $db->loadColumn();

		foreach ($results as $result)
		{
			$products[] = ProductFactory::get($result);
		}

		return $products;


	}

	public static function getTitle($itemid)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query
			->select('*')
			->from($db->quoteName('#__content'))
			->where($db->quoteName('id') . ' = ' . $db->quote($itemid));

		$db->setQuery($query);

		$result = $db->loadObject();

		return $result->title;

	}


	public static function getItem($itemid)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query
			->select('*')
			->from($db->quoteName('#__content'))
			->where($db->quoteName('id') . ' = ' . $db->quote($itemid));

		$db->setQuery($query);

		return $db->loadObject();

	}


	public static function getJoomlaItemIdFromProductId($product_id)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query
			->select('joomla_item_id')
			->from($db->quoteName('#__commercelab_shop_product'))
			->where($db->quoteName('id') . ' = ' . $db->quote($product_id));

		$db->setQuery($query);

		return $db->loadResult();

	}

	public static function getProductIdFromJoomlaItemId($joomla_item_id)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query
			->select('id')
			->from($db->quoteName('#__commercelab_shop_product'))
			->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($joomla_item_id));

		$db->setQuery($query);

		return $db->loadResult();

	}

	/**
	 *
	 * @return string
	 *
	 * @since 1.0
	 */

	public static function getDate(): string
	{
		$config   = Factory::getConfig();
		$timezone = $config->get('offset');

		$timezone = new DateTimeZone($timezone);

		$date = Factory::getDate();
		$date->setTimezone($timezone);

		return $date->toSql(true);
	}

	/**
	 *
	 * @return string
	 *
	 * @since 1.0
	 */

	public static function prepareDateToSave($date_string = null): string
	{
		return Factory::getDate(
			$date_string, 
			Factory::getUser()->getTimezone()
			)->toSql();
	}

	/**
	 *
	 * @return string
	 *
	 * @since 1.0
	 */

	public static function isPendingState($publish_up): bool
	{

		$nowDate    = strtotime(Factory::getDate());
		$publish_up = strtotime(Factory::getDate($publish_up));

		return $publish_up > $nowDate;
	}

	/**
	 * @param           $email
	 * @param   int     $s
	 * @param   string  $d
	 * @param   string  $r
	 * @param   false   $img
	 * @param   array   $atts
	 *
	 * @return string
	 *
	 * @since 1.0
	 */

	public static function getGravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
	{
		$url = 'https://www.gravatar.com/avatar/';
		$url .= md5(strtolower(trim($email)));
		$url .= "?s=$s&d=$d&r=$r";
		if ($img)
		{
			$url = '<img src="' . $url . '"';
			foreach ($atts as $key => $val)
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}

		return $url;
	}


	public static function getUntranslatedOrderStatus($orderid)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('order_status');
		$query->from($db->quoteName('#__commercelab_shop_order'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($orderid));

		$db->setQuery($query);

		return $db->loadResult();

	}

	public static function getPresetValue($id)
	{

		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_option_preset'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));

		$db->setQuery($query);

		$result = $db->loadObject();

		return $result->options;

	}


	public static function getOptionPresets()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_option_preset'));

		$db->setQuery($query);

		return $db->loadObjectList();

	}

	public static function getCookieID()
	{

		return Factory::getApplication()->input->cookie->get('yps-cart', null);

	}

	public static function getCustomerAddresses($customerId)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__commercelab_shop_customer_address'));
		$query->where($db->quoteName('customer_id') . ' = ' . $db->quote($customerId));
		$db->setQuery($query);

		$customerAddresses = $db->loadObjectList();


		$addresses = array();

		foreach ($customerAddresses as $addressid)
		{

			$addresses[] = new Address($addressid->id);

		}

		return $addresses;

	}

	public static function getCustomerIdByCurrentUserId($userid = null)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('id');
		$query->from($db->quoteName('#__commercelab_shop_customer'));
		if ($userid)
		{
			$query->where($db->quoteName('j_user_id') . ' = ' . $db->quote($userid));
		}
		else
		{
			$query->where($db->quoteName('j_user_id') . ' = ' . $db->quote(UserFactory::getActiveUser()->id));
		}

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result)
		{
			return $result;
		}
		else
		{
			return 0;
		}

	}


	public static function selectionTranslation($value, $name)
	{
		// Array of order_status language strings
		if ($name === 'order_status')
		{
			$order_statusArray = array(
				'P' => Text::_('COM_COMMERCELAB_SHOP_ORDER_PENDING'),
				'C' => Text::_('COM_COMMERCELAB_SHOP_ORDER_CONFIRMED'),
				'X' => Text::_('COM_COMMERCELAB_SHOP_ORDER_CANCELLED'),
				'R' => Text::_('COM_COMMERCELAB_SHOP_ORDER_REFUNDED'),
				'S' => Text::_('COM_COMMERCELAB_SHOP_ORDER_SHIPPED'),
				'F' => Text::_('COM_COMMERCELAB_SHOP_ORDER_COMPLETED'),
				'D' => Text::_('COM_COMMERCELAB_SHOP_ORDER_DENIED')
			);
			// Now check if value is found in this array
			if (isset($order_statusArray[$value]) && self::checkString($order_statusArray[$value]))
			{
				return $order_statusArray[$value];
			}
		}
		// Array of order_paid language strings
		if ($name === 'order_paid')
		{
			$order_paidArray = array(
				1 => Text::_('COM_COMMERCELAB_SHOP_ORDER_YES'),
				0 => Text::_('COM_COMMERCELAB_SHOP_ORDER_NO')
			);
			// Now check if value is found in this array
			if (isset($order_paidArray[$value]) && self::checkString($order_paidArray[$value]))
			{
				return $order_paidArray[$value];
			}
		}

		return $value;
	}


	public static function getOrderStatusFromCharacterCode($CharacterCode)
	{
		switch ($CharacterCode)
		{
			case 'P':
				return 'pending';
			case 'C':
				return 'confirmed';
			case 'X':
				return 'cancelled';
			case 'R':
				return 'refunded';
			case 'S':
				return 'shipped';
			case 'F':
				return 'completed';
			case 'D':
				return 'denied';

		}
	}


	public static function checkString($string)
	{
		if (isset($string) && is_string($string) && strlen($string) > 0)
		{
			return true;
		}

		return false;
	}

	public static function getNewSku($itemid)
	{


		return self::getFieldValue(self::getFieldId('yps-sku'), $itemid);
	}


	public static function isShippingAssigned()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('shipping_address_id');
		$query->from($db->quoteName('#__commercelab_shop_cart'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote(CartFactory::get()->id));

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result)
		{
			return true;
		}
		else
		{
			return false;
		}

	}


	public static function isGuestCheckoutValid()
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('shipping_address_id');
		$query->from($db->quoteName('#__commercelab_shop_cart'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote(CartFactory::get()->id));

		$db->setQuery($query);

		$shipping = $db->loadResult();

		if ($shipping)
		{
			$query = $db->getQuery(true);

			$query->select('billing_address_id');
			$query->from($db->quoteName('#__commercelab_shop_cart'));
			$query->where($db->quoteName('id') . ' = ' . $db->quote(CartFactory::get()->id));

			$db->setQuery($query);

			$billing = $db->loadResult();

			if ($billing)
			{
				return true;
			}
		}
		else
		{
			return false;
		}

	}

	public static function isBillingAssigned()
	{


		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('billing_address_id');
		$query->from($db->quoteName('#__commercelab_shop_cart'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote(CartFactory::get()->id));

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result)
		{
			return true;
		}
		else
		{
			return false;

		}
	}


	public static function adjustBrightness($hex, $steps)
	{
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max(-255, min(255, $steps));

		// Normalize into a six character long hex string
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3)
		{
			$hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
		}

// Split into three parts: R, G and B
		$color_parts = str_split($hex, 2);
		$return      = '#';

		foreach ($color_parts as $color)
		{
			$color  = hexdec($color); // Convert to decimal
			$color  = max(0, min(255, $color + $steps)); // Adjust color
			$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
		}

		return $return;
	}


	public static function processTagsByName($names)
	{


		$tagArray = array();

		$db = Factory::getDbo();

		foreach ($names as $name)
		{
			$query = $db->getQuery(true);

			$query->select('id');
			$query->from($db->quoteName('#__tags'));
			$query->where($db->quoteName('title') . ' = ' . $db->quote($name));

			$db->setQuery($query);

			$tag = $db->loadResult();

			if ($tag)
			{
				$tagArray[] = $tag;
			}
			else
			{
				$tagArray[] = '#new#' . $name;
			}

		}


		return $tagArray;


	}

	public static function isAliasOkForThisProduct($alias, $id)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('alias');
		$query->from($db->quoteName('#__content'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));
		$query->setLimit('1');

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result == $alias)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public static function isPluginActive(string $plugin_type, string $plugin_name) :bool
	{
		return is_object(PluginHelper::getPlugin($plugin_type, $plugin_name));
	}

	public static function generateUniqueAlias($alias, $table = false)
	{

		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('alias');

		if ($table)
		{
			$query->from($db->quoteName('#__' . $table));
		}
		else
		{
			$query->from($db->quoteName('#__content'));
		}


		$query->where($db->quoteName('alias') . ' = ' . $db->quote($alias));
		$query->setLimit('1');

		$db->setQuery($query);

		$result = $db->loadResult();

		if ($result)
		{
			// already exists - increment and return
			return StringHelper::increment($alias, 'dash');
		}
		else
		{
			return $alias;
		}


	}

	// TODO - Why do we need to load a VueJS component as compressed PHP string??!!
	// All these components are loaded within /media/js/bundleadmin.js (backend) and /media/bundle.min.js (frontend)
	public static function includePrime(array $nodes)
	{

		if (!is_array($nodes))
		{
			return;
		}


		$document = Factory::getDocument();

		foreach ($nodes as $node)
		{

			if (in_array($node, ['chips', 'chip', 'multiselect', 'inputswitch']))
			{
				self::loadPrimeNode($node, $document);
			}
		}

	}

	private static function loadPrimeNode($node, $document)
	{

		switch ($node)
		{
			case "button":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.button=function(t,e){"use strict";function o(t){return t&&"object"==typeof t&&"default"in t?t:{default:t}}var i={name:"Button",props:{label:{type:String},icon:{type:String},iconPos:{type:String,default:"left"},badge:{type:String},badgeClass:{type:String,default:null},loading:{type:Boolean,default:!1},loadingIcon:{type:String,default:"pi pi-spinner pi-spin"}},computed:{buttonClass(){return{"p-button p-component":!0,"p-button-icon-only":this.icon&&!this.label,"p-button-vertical":("top"===this.iconPos||"bottom"===this.iconPos)&&this.label,"p-disabled":this.$attrs.disabled||this.loading,"p-button-loading":this.loading,"p-button-loading-label-only":this.loading&&!this.icon&&this.label}},iconClass(){return[this.loading?"p-button-loading-icon "+this.loadingIcon:this.icon,"p-button-icon",{"p-button-icon-left":"left"===this.iconPos&&this.label,"p-button-icon-right":"right"===this.iconPos&&this.label,"p-button-icon-top":"top"===this.iconPos&&this.label,"p-button-icon-bottom":"bottom"===this.iconPos&&this.label}]},badgeStyleClass(){return["p-badge p-component",this.badgeClass,{"p-badge-no-gutter":this.badge&&1===String(this.badge).length}]},disabled(){return this.$attrs.disabled||this.loading}},directives:{ripple:o(t).default}};const n={class:"p-button-label"};return i.render=function(t,o,i,l,s,a){const c=e.resolveDirective("ripple");return e.withDirectives((e.openBlock(),e.createBlock("button",{class:a.buttonClass,type:"button",disabled:a.disabled},[e.renderSlot(t.$slots,"default",{},(()=>[i.loading&&!i.icon?(e.openBlock(),e.createBlock("span",{key:0,class:a.iconClass},null,2)):e.createCommentVNode("",!0),i.icon?(e.openBlock(),e.createBlock("span",{key:1,class:a.iconClass},null,2)):e.createCommentVNode("",!0),e.createVNode("span",n,e.toDisplayString(i.label||" "),1),i.badge?(e.openBlock(),e.createBlock("span",{key:2,class:a.badgeStyleClass},e.toDisplayString(i.badge),3)):e.createCommentVNode("",!0)]))],10,["disabled"])),[[c]])},i}(primevue.ripple,Vue);');
				break;
			case "inputswitch":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.inputswitch=function(e){"use strict";var t={name:"InputSwitch",inheritAttrs:!1,emits:["click","update:modelValue","change","input"],props:{modelValue:{type:null,default:!1},class:null,style:null,trueValue:{type:null,default:!0},falseValue:{type:null,default:!1}},data:()=>({focused:!1}),methods:{onClick(e){if(!this.$attrs.disabled){const t=this.checked?this.falseValue:this.trueValue;this.$emit("click",e),this.$emit("update:modelValue",t),this.$emit("change",e),this.$emit("input",t),this.$refs.input.focus()}e.preventDefault()},onFocus(){this.focused=!0},onBlur(){this.focused=!1}},computed:{containerClass(){return["p-inputswitch p-component",this.class,{"p-inputswitch-checked":this.checked,"p-disabled":this.$attrs.disabled,"p-focus":this.focused}]},checked(){return this.modelValue===this.trueValue}}};const i={class:"p-hidden-accessible"},n=e.createVNode("span",{class:"p-inputswitch-slider"},null,-1);return function(e,t){void 0===t&&(t={});var i=t.insertAt;if(e&&"undefined"!=typeof document){var n=document.head||document.getElementsByTagName("head")[0],s=document.createElement("style");s.type="text/css","top"===i&&n.firstChild?n.insertBefore(s,n.firstChild):n.appendChild(s),s.styleSheet?s.styleSheet.cssText=e:s.appendChild(document.createTextNode(e))}}(\'\n.p-inputswitch {\n    position: relative;\n    display: inline-block;\n}\n.p-inputswitch-slider {\n    position: absolute;\n    cursor: pointer;\n    top: 0;\n    left: 0;\n    right: 0;\n    bottom: 0;\n}\n.p-inputswitch-slider:before {\n    position: absolute;\n    content: "";\n    top: 50%;\n}\n\'),t.render=function(t,s,c,l,o,u){return e.openBlock(),e.createBlock("div",{class:u.containerClass,onClick:s[4]||(s[4]=e=>u.onClick(e)),style:c.style},[e.createVNode("div",i,[e.createVNode("input",e.mergeProps({ref:"input",type:"checkbox",checked:u.checked},t.$attrs,{onFocus:s[1]||(s[1]=e=>u.onFocus(e)),onBlur:s[2]||(s[2]=e=>u.onBlur(e)),onKeydown:s[3]||(s[3]=e.withKeys(e.withModifiers((e=>u.onClick(e)),["prevent"]),["enter"])),role:"switch","aria-checked":u.checked}),null,16,["checked","aria-checked"])]),n],6)},t}(Vue);');
				break;
			case "chips":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.chips=function(e){"use strict";var t={name:"Chips",inheritAttrs:!1,emits:["update:modelValue","add","remove"],props:{modelValue:{type:Array,default:null},max:{type:Number,default:null},separator:{type:String,default:null},addOnBlur:{type:Boolean,default:null},allowDuplicate:{type:Boolean,default:!0},class:null,style:null},data:()=>({inputValue:null,focused:!1}),methods:{onWrapperClick(){this.$refs.input.focus()},onInput(e){this.inputValue=e.target.value},onFocus(){this.focused=!0},onBlur(e){this.focused=!1,this.addOnBlur&&this.addItem(e,e.target.value,!1)},onKeyDown(e){const t=e.target.value;switch(e.which){case 8:0===t.length&&this.modelValue&&this.modelValue.length>0&&this.removeItem(e,this.modelValue.length-1);break;case 13:t&&t.trim().length&&!this.maxedOut&&this.addItem(e,t,!0);break;default:this.separator&&","===this.separator&&188===e.which&&this.addItem(e,t,!0)}},onPaste(e){if(this.separator){let t=(e.clipboardData||window.clipboardData).getData("Text");if(t){let n=this.modelValue||[],i=t.split(this.separator);i=i.filter((e=>this.allowDuplicate||-1===n.indexOf(e))),n=[...n,...i],this.updateModel(e,n,!0)}}},updateModel(e,t,n){this.$emit("update:modelValue",t),this.$emit("add",{originalEvent:e,value:t}),this.$refs.input.value="",this.inputValue="",n&&e.preventDefault()},addItem(e,t,n){if(t&&t.trim().length){let i=this.modelValue?[...this.modelValue]:[];(this.allowDuplicate||-1===i.indexOf(t))&&(i.push(t),this.updateModel(e,i,n))}},removeItem(e,t){if(this.$attrs.disabled)return;let n=[...this.modelValue];const i=n.splice(t,1);this.$emit("update:modelValue",n),this.$emit("remove",{originalEvent:e,value:i})}},computed:{maxedOut(){return this.max&&this.modelValue&&this.max===this.modelValue.length},containerClass(){return["p-chips p-component p-inputwrapper",this.class,{"p-inputwrapper-filled":this.modelValue&&this.modelValue.length||this.inputValue&&this.inputValue.length,"p-inputwrapper-focus":this.focused}]}}};const n={class:"p-chips-token-label"},i={class:"p-chips-input-token"};return function(e,t){void 0===t&&(t={});var n=t.insertAt;if(e&&"undefined"!=typeof document){var i=document.head||document.getElementsByTagName("head")[0],l=document.createElement("style");l.type="text/css","top"===n&&i.firstChild?i.insertBefore(l,i.firstChild):i.appendChild(l),l.styleSheet?l.styleSheet.cssText=e:l.appendChild(document.createTextNode(e))}}("\n.p-chips {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n}\n.p-chips-multiple-container {\n    margin: 0;\n    padding: 0;\n    list-style-type: none;\n    cursor: text;\n    overflow: hidden;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -ms-flex-wrap: wrap;\n        flex-wrap: wrap;\n}\n.p-chips-token {\n    cursor: default;\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-flex: 0;\n        -ms-flex: 0 0 auto;\n            flex: 0 0 auto;\n}\n.p-chips-input-token {\n    -webkit-box-flex: 1;\n        -ms-flex: 1 1 auto;\n            flex: 1 1 auto;\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n}\n.p-chips-token-icon {\n    cursor: pointer;\n}\n.p-chips-input-token input {\n    border: 0 none;\n    outline: 0 none;\n    background-color: transparent;\n    margin: 0;\n    padding: 0;\n    -webkit-box-shadow: none;\n            box-shadow: none;\n    border-radius: 0;\n    width: 100%;\n}\n.p-fluid .p-chips {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n}\n"),t.render=function(t,l,a,s,o,p){return e.openBlock(),e.createBlock("div",{class:p.containerClass,style:a.style},[e.createVNode("ul",{class:["p-inputtext p-chips-multiple-container",{"p-disabled":t.$attrs.disabled,"p-focus":o.focused}],onClick:l[6]||(l[6]=e=>p.onWrapperClick())},[(e.openBlock(!0),e.createBlock(e.Fragment,null,e.renderList(a.modelValue,((i,l)=>(e.openBlock(),e.createBlock("li",{key:`${l}_${i}`,class:"p-chips-token"},[e.renderSlot(t.$slots,"chip",{value:i},(()=>[e.createVNode("span",n,e.toDisplayString(i),1)])),e.createVNode("span",{class:"p-chips-token-icon pi pi-times-circle",onClick:e=>p.removeItem(e,l)},null,8,["onClick"])])))),128)),e.createVNode("li",i,[e.createVNode("input",e.mergeProps({ref:"input",type:"text"},t.$attrs,{onFocus:l[1]||(l[1]=(...e)=>p.onFocus&&p.onFocus(...e)),onBlur:l[2]||(l[2]=e=>p.onBlur(e)),onInput:l[3]||(l[3]=(...e)=>p.onInput&&p.onInput(...e)),onKeydown:l[4]||(l[4]=e=>p.onKeyDown(e)),onPaste:l[5]||(l[5]=e=>p.onPaste(e)),disabled:t.$attrs.disabled||p.maxedOut}),null,16,["disabled"])])],2)],6)},t}(Vue);');
				break;
			case "chip":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.chip=function(e){"use strict";var n={name:"Chip",emits:["remove"],props:{label:{type:String,default:null},icon:{type:String,default:null},image:{type:String,default:null},removable:{type:Boolean,default:!1},removeIcon:{type:String,default:"pi pi-times-circle"}},data:()=>({visible:!0}),methods:{close(e){this.visible=!1,this.$emit("remove",e)}},computed:{containerClass(){return["p-chip p-component",{"p-chip-image":null!=this.image}]},iconClass(){return["p-chip-icon",this.icon]},removeIconClass(){return["p-chip-remove-icon",this.removeIcon]}}};const t={key:2,class:"p-chip-text"};return function(e,n){void 0===n&&(n={});var t=n.insertAt;if(e&&"undefined"!=typeof document){var i=document.head||document.getElementsByTagName("head")[0],l=document.createElement("style");l.type="text/css","top"===t&&i.firstChild?i.insertBefore(l,i.firstChild):i.appendChild(l),l.styleSheet?l.styleSheet.cssText=e:l.appendChild(document.createTextNode(e))}}("\n.p-chip {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n}\n.p-chip-text {\n    line-height: 1.5;\n}\n.p-chip-icon.pi {\n    line-height: 1.5;\n}\n.p-chip-remove-icon {\n    line-height: 1.5;\n    cursor: pointer;\n}\n.p-chip img {\n    border-radius: 50%;\n}\n"),n.render=function(n,i,l,o,c,s){return c.visible?(e.openBlock(),e.createBlock("div",{key:0,class:s.containerClass},[e.renderSlot(n.$slots,"default",{},(()=>[l.image?(e.openBlock(),e.createBlock("img",{key:0,src:l.image},null,8,["src"])):l.icon?(e.openBlock(),e.createBlock("span",{key:1,class:s.iconClass},null,2)):e.createCommentVNode("",!0),l.label?(e.openBlock(),e.createBlock("div",t,e.toDisplayString(l.label),1)):e.createCommentVNode("",!0)])),l.removable?(e.openBlock(),e.createBlock("span",{key:0,tabindex:"0",class:s.removeIconClass,onClick:i[1]||(i[1]=(...e)=>s.close&&s.close(...e)),onKeydown:i[2]||(i[2]=e.withKeys(((...e)=>s.close&&s.close(...e)),["enter"]))},null,34)):e.createCommentVNode("",!0)],2)):e.createCommentVNode("",!0)},n}(Vue);');
				break;
			case "inputnumber":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.inputnumber=function(e,t,n){"use strict";function i(e){return e&&"object"==typeof e&&"default"in e?e:{default:e}}var s=i(e),r=i(t),u={name:"InputNumber",inheritAttrs:!1,emits:["update:modelValue","input"],props:{modelValue:{type:Number,default:null},format:{type:Boolean,default:!0},showButtons:{type:Boolean,default:!1},buttonLayout:{type:String,default:"stacked"},incrementButtonClass:{type:String,default:null},decrementButtonClass:{type:String,default:null},incrementButtonIcon:{type:String,default:"pi pi-angle-up"},decrementButtonIcon:{type:String,default:"pi pi-angle-down"},locale:{type:String,default:void 0},localeMatcher:{type:String,default:void 0},mode:{type:String,default:"decimal"},prefix:{type:String,default:null},suffix:{type:String,default:null},currency:{type:String,default:void 0},currencyDisplay:{type:String,default:void 0},useGrouping:{type:Boolean,default:!0},minFractionDigits:{type:Number,default:void 0},maxFractionDigits:{type:Number,default:void 0},min:{type:Number,default:null},max:{type:Number,default:null},step:{type:Number,default:1},allowEmpty:{type:Boolean,default:!0},style:null,class:null,inputStyle:null,inputClass:null},numberFormat:null,_numeral:null,_decimal:null,_group:null,_minusSign:null,_currency:null,_suffix:null,_prefix:null,_index:null,groupChar:"",isSpecialChar:null,prefixChar:null,suffixChar:null,timer:null,data:()=>({focused:!1}),watch:{locale(e,t){this.updateConstructParser(e,t)},localeMatcher(e,t){this.updateConstructParser(e,t)},mode(e,t){this.updateConstructParser(e,t)},currency(e,t){this.updateConstructParser(e,t)},currencyDisplay(e,t){this.updateConstructParser(e,t)},useGrouping(e,t){this.updateConstructParser(e,t)},minFractionDigits(e,t){this.updateConstructParser(e,t)},maxFractionDigits(e,t){this.updateConstructParser(e,t)},suffix(e,t){this.updateConstructParser(e,t)},prefix(e,t){this.updateConstructParser(e,t)}},created(){this.constructParser()},methods:{getOptions(){return{localeMatcher:this.localeMatcher,style:this.mode,currency:this.currency,currencyDisplay:this.currencyDisplay,useGrouping:this.useGrouping,minimumFractionDigits:this.minFractionDigits,maximumFractionDigits:this.maxFractionDigits}},constructParser(){this.numberFormat=new Intl.NumberFormat(this.locale,this.getOptions());const e=[...new Intl.NumberFormat(this.locale,{useGrouping:!1}).format(9876543210)].reverse(),t=new Map(e.map(((e,t)=>[e,t])));this._numeral=new RegExp(`[${e.join("")}]`,"g"),this._group=this.getGroupingExpression(),this._minusSign=this.getMinusSignExpression(),this._currency=this.getCurrencyExpression(),this._decimal=this.getDecimalExpression(),this._suffix=this.getSuffixExpression(),this._prefix=this.getPrefixExpression(),this._index=e=>t.get(e)},updateConstructParser(e,t){e!==t&&this.constructParser()},escapeRegExp:e=>e.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&"),getDecimalExpression(){const e=new Intl.NumberFormat(this.locale,{...this.getOptions(),useGrouping:!1});return new RegExp(`[${e.format(1.1).replace(this._currency,"").trim().replace(this._numeral,"")}]`,"g")},getGroupingExpression(){const e=new Intl.NumberFormat(this.locale,{useGrouping:!0});return this.groupChar=e.format(1e6).trim().replace(this._numeral,"").charAt(0),new RegExp(`[${this.groupChar}]`,"g")},getMinusSignExpression(){const e=new Intl.NumberFormat(this.locale,{useGrouping:!1});return new RegExp(`[${e.format(-1).trim().replace(this._numeral,"")}]`,"g")},getCurrencyExpression(){if(this.currency){const e=new Intl.NumberFormat(this.locale,{style:"currency",currency:this.currency,currencyDisplay:this.currencyDisplay,minimumFractionDigits:0,maximumFractionDigits:0});return new RegExp(`[${e.format(1).replace(/\s/g,"").replace(this._numeral,"").replace(this._group,"")}]`,"g")}return new RegExp("[]","g")},getPrefixExpression(){if(this.prefix)this.prefixChar=this.prefix;else{const e=new Intl.NumberFormat(this.locale,{style:this.mode,currency:this.currency,currencyDisplay:this.currencyDisplay});this.prefixChar=e.format(1).split("1")[0]}return new RegExp(`${this.escapeRegExp(this.prefixChar||"")}`,"g")},getSuffixExpression(){if(this.suffix)this.suffixChar=this.suffix;else{const e=new Intl.NumberFormat(this.locale,{style:this.mode,currency:this.currency,currencyDisplay:this.currencyDisplay,minimumFractionDigits:0,maximumFractionDigits:0});this.suffixChar=e.format(1).split("1")[1]}return new RegExp(`${this.escapeRegExp(this.suffixChar||"")}`,"g")},formatValue(e){if(null!=e){if("-"===e)return e;if(this.format){let t=new Intl.NumberFormat(this.locale,this.getOptions()).format(e);return this.prefix&&(t=this.prefix+t),this.suffix&&(t+=this.suffix),t}return e.toString()}return""},parseValue(e){let t=e.replace(this._suffix,"").replace(this._prefix,"").trim().replace(/\s/g,"").replace(this._currency,"").replace(this._group,"").replace(this._minusSign,"-").replace(this._decimal,".").replace(this._numeral,this._index);if(t){if("-"===t)return t;let e=+t;return isNaN(e)?null:e}return null},repeat(e,t,n){let i=t||500;this.clearTimer(),this.timer=setTimeout((()=>{this.repeat(e,40,n)}),i),this.spin(e,n)},spin(e,t){if(this.$refs.input){let n=this.step*t,i=this.parseValue(this.$refs.input.$el.value)||0,s=this.validateValue(i+n);this.updateInput(s,null,"spin"),this.updateModel(e,s),this.handleOnInput(e,i,s)}},onUpButtonMouseDown(e){this.$attrs.disabled||(this.$refs.input.$el.focus(),this.repeat(e,null,1),e.preventDefault())},onUpButtonMouseUp(){this.$attrs.disabled||this.clearTimer()},onUpButtonMouseLeave(){this.$attrs.disabled||this.clearTimer()},onUpButtonKeyUp(){this.$attrs.disabled||this.clearTimer()},onUpButtonKeyDown(e){32!==e.keyCode&&13!==e.keyCode||this.repeat(e,null,1)},onDownButtonMouseDown(e){this.$attrs.disabled||(this.$refs.input.$el.focus(),this.repeat(e,null,-1),e.preventDefault())},onDownButtonMouseUp(){this.$attrs.disabled||this.clearTimer()},onDownButtonMouseLeave(){this.$attrs.disabled||this.clearTimer()},onDownButtonKeyUp(){this.$attrs.disabled||this.clearTimer()},onDownButtonKeyDown(e){32!==e.keyCode&&13!==e.keyCode||this.repeat(e,null,-1)},onUserInput(){this.isSpecialChar&&(this.$refs.input.$el.value=this.lastValue),this.isSpecialChar=!1},onInputKeyDown(e){if(this.lastValue=e.target.value,e.shiftKey||e.altKey)return void(this.isSpecialChar=!0);let t=e.target.selectionStart,n=e.target.selectionEnd,i=e.target.value,s=null;switch(e.altKey&&e.preventDefault(),e.which){case 38:this.spin(e,1),e.preventDefault();break;case 40:this.spin(e,-1),e.preventDefault();break;case 37:this.isNumeralChar(i.charAt(t-1))||e.preventDefault();break;case 39:this.isNumeralChar(i.charAt(t))||e.preventDefault();break;case 13:s=this.validateValue(this.parseValue(i)),this.$refs.input.$el.value=this.formatValue(s),this.$refs.input.$el.setAttribute("aria-valuenow",s),this.updateModel(e,s);break;case 8:if(e.preventDefault(),t===n){const n=i.charAt(t-1),{decimalCharIndex:r,decimalCharIndexWithoutPrefix:u}=this.getDecimalCharIndexes(i);if(this.isNumeralChar(n)){const e=this.getDecimalLength(i);if(this._group.test(n))this._group.lastIndex=0,s=i.slice(0,t-2)+i.slice(t-1);else if(this._decimal.test(n))this._decimal.lastIndex=0,e?this.$refs.input.$el.setSelectionRange(t-1,t-1):s=i.slice(0,t-1)+i.slice(t);else if(r>0&&t>r){const n=this.isDecimalMode()&&(this.minFractionDigits||0)<e?"":"0";s=i.slice(0,t-1)+n+i.slice(t)}else 1===u?(s=i.slice(0,t-1)+"0"+i.slice(t),s=this.parseValue(s)>0?s:""):s=i.slice(0,t-1)+i.slice(t)}this.updateValue(e,s,null,"delete-single")}else s=this.deleteRange(i,t,n),this.updateValue(e,s,null,"delete-range");break;case 46:if(e.preventDefault(),t===n){const n=i.charAt(t),{decimalCharIndex:r,decimalCharIndexWithoutPrefix:u}=this.getDecimalCharIndexes(i);if(this.isNumeralChar(n)){const e=this.getDecimalLength(i);if(this._group.test(n))this._group.lastIndex=0,s=i.slice(0,t)+i.slice(t+2);else if(this._decimal.test(n))this._decimal.lastIndex=0,e?this.$refs.input.$el.setSelectionRange(t+1,t+1):s=i.slice(0,t)+i.slice(t+1);else if(r>0&&t>r){const n=this.isDecimalMode()&&(this.minFractionDigits||0)<e?"":"0";s=i.slice(0,t)+n+i.slice(t+1)}else 1===u?(s=i.slice(0,t)+"0"+i.slice(t+1),s=this.parseValue(s)>0?s:""):s=i.slice(0,t)+i.slice(t+1)}this.updateValue(e,s,null,"delete-back-single")}else s=this.deleteRange(i,t,n),this.updateValue(e,s,null,"delete-range")}},onInputKeyPress(e){e.preventDefault();let t=e.which||e.keyCode,n=String.fromCharCode(t);const i=this.isDecimalSign(n),s=this.isMinusSign(n);(48<=t&&t<=57||s||i)&&this.insert(e,n,{isDecimalSign:i,isMinusSign:s})},onPaste(e){e.preventDefault();let t=(e.clipboardData||window.clipboardData).getData("Text");if(t){let n=this.parseValue(t);null!=n&&this.insert(e,n.toString())}},allowMinusSign(){return null===this.min||this.min<0},isMinusSign(e){return!(!this._minusSign.test(e)&&"-"!==e)&&(this._minusSign.lastIndex=0,!0)},isDecimalSign(e){return!!this._decimal.test(e)&&(this._decimal.lastIndex=0,!0)},isDecimalMode(){return"decimal"===this.mode},getDecimalCharIndexes(e){let t=e.search(this._decimal);this._decimal.lastIndex=0;const n=e.replace(this._prefix,"").trim().replace(/\s/g,"").replace(this._currency,"").search(this._decimal);return this._decimal.lastIndex=0,{decimalCharIndex:t,decimalCharIndexWithoutPrefix:n}},getCharIndexes(e){const t=e.search(this._decimal);this._decimal.lastIndex=0;const n=e.search(this._minusSign);this._minusSign.lastIndex=0;const i=e.search(this._suffix);this._suffix.lastIndex=0;const s=e.search(this._currency);return this._currency.lastIndex=0,{decimalCharIndex:t,minusCharIndex:n,suffixCharIndex:i,currencyCharIndex:s}},insert(e,t,n={isDecimalSign:!1,isMinusSign:!1}){const i=t.search(this._minusSign);if(this._minusSign.lastIndex=0,!this.allowMinusSign()&&-1!==i)return;const s=this.$refs.input.$el.selectionStart,r=this.$refs.input.$el.selectionEnd;let u=this.$refs.input.$el.value.trim();const{decimalCharIndex:l,minusCharIndex:a,suffixCharIndex:o,currencyCharIndex:p}=this.getCharIndexes(u);let c;if(n.isMinusSign)0===s&&(c=u,-1!==a&&0===r||(c=this.insertText(u,t,0,r)),this.updateValue(e,c,t,"insert"));else if(n.isDecimalSign)l>0&&s===l?this.updateValue(e,u,t,"insert"):(l>s&&l<r||-1===l&&this.maxFractionDigits)&&(c=this.insertText(u,t,s,r),this.updateValue(e,c,t,"insert"));else{const n=this.numberFormat.resolvedOptions().maximumFractionDigits,i=s!==r?"range-insert":"insert";if(l>0&&s>l){if(s+t.length-(l+1)<=n){const n=p>=s?p-1:o>=s?o:u.length;c=u.slice(0,s)+t+u.slice(s+t.length,n)+u.slice(n),this.updateValue(e,c,t,i)}}else c=this.insertText(u,t,s,r),this.updateValue(e,c,t,i)}},insertText(e,t,n,i){if(2===("."===t?t:t.split(".")).length){const s=e.slice(n,i).search(this._decimal);return this._decimal.lastIndex=0,s>0?e.slice(0,n)+this.formatValue(t)+e.slice(i):e||this.formatValue(t)}return i-n===e.length?this.formatValue(t):0===n?t+e.slice(i):i===e.length?e.slice(0,n)+t:e.slice(0,n)+t+e.slice(i)},deleteRange(e,t,n){let i;return i=n-t===e.length?"":0===t?e.slice(n):n===e.length?e.slice(0,t):e.slice(0,t)+e.slice(n),i},initCursor(){let e=this.$refs.input.$el.selectionStart,t=this.$refs.input.$el.value,n=t.length,i=null,s=(this.prefixChar||"").length;t=t.replace(this._prefix,""),e-=s;let r=t.charAt(e);if(this.isNumeralChar(r))return e+s;let u=e-1;for(;u>=0;){if(r=t.charAt(u),this.isNumeralChar(r)){i=u+s;break}u--}if(null!==i)this.$refs.input.$el.setSelectionRange(i+1,i+1);else{for(u=e;u<n;){if(r=t.charAt(u),this.isNumeralChar(r)){i=u+s;break}u++}null!==i&&this.$refs.input.$el.setSelectionRange(i,i)}return i||0},onInputClick(){this.initCursor()},isNumeralChar(e){return!(1!==e.length||!(this._numeral.test(e)||this._decimal.test(e)||this._group.test(e)||this._minusSign.test(e)))&&(this.resetRegex(),!0)},resetRegex(){this._numeral.lastIndex=0,this._decimal.lastIndex=0,this._group.lastIndex=0,this._minusSign.lastIndex=0},updateValue(e,t,n,i){let s=this.$refs.input.$el.value,r=null;null!=t&&(r=this.parseValue(t),r=r||this.allowEmpty?r:0,this.updateInput(r,n,i,t),this.handleOnInput(e,s,r))},handleOnInput(e,t,n){this.isValueChanged(t,n)&&this.$emit("input",{originalEvent:e,value:n})},isValueChanged(e,t){if(null===t&&null!==e)return!0;if(null!=t){return t!==("string"==typeof e?this.parseValue(e):e)}return!1},validateValue(e){return"-"===e||null==e?null:null!=this.min&&e<this.min?this.min:null!=this.max&&e>this.max?this.max:e},updateInput(e,t,n,i){t=t||"";let s=this.$refs.input.$el.value,r=this.formatValue(e),u=s.length;if(r!==i&&(r=this.concatValues(r,i)),0===u){this.$refs.input.$el.value=r,this.$refs.input.$el.setSelectionRange(0,0);const e=this.initCursor()+t.length;this.$refs.input.$el.setSelectionRange(e,e)}else{let e=this.$refs.input.$el.selectionStart,i=this.$refs.input.$el.selectionEnd;this.$refs.input.$el.value=r;let l=r.length;if("range-insert"===n){const n=this.parseValue((s||"").slice(0,e)),u=(null!==n?n.toString():"").split("").join(`(${this.groupChar})?`),l=new RegExp(u,"g");l.test(r);const a=t.split("").join(`(${this.groupChar})?`),o=new RegExp(a,"g");o.test(r.slice(l.lastIndex)),i=l.lastIndex+o.lastIndex,this.$refs.input.$el.setSelectionRange(i,i)}else if(l===u)"insert"===n||"delete-back-single"===n?this.$refs.input.$el.setSelectionRange(i+1,i+1):"delete-single"===n?this.$refs.input.$el.setSelectionRange(i-1,i-1):"delete-range"!==n&&"spin"!==n||this.$refs.input.$el.setSelectionRange(i,i);else if("delete-back-single"===n){let e=s.charAt(i-1),t=s.charAt(i),n=u-l,r=this._group.test(t);r&&1===n?i+=1:!r&&this.isNumeralChar(e)&&(i+=-1*n+1),this._group.lastIndex=0,this.$refs.input.$el.setSelectionRange(i,i)}else if("-"===s&&"insert"===n){this.$refs.input.$el.setSelectionRange(0,0);const e=this.initCursor()+t.length+1;this.$refs.input.$el.setSelectionRange(e,e)}else i+=l-u,this.$refs.input.$el.setSelectionRange(i,i)}this.$refs.input.$el.setAttribute("aria-valuenow",e)},concatValues(e,t){if(e&&t){let n=t.search(this._decimal);return this._decimal.lastIndex=0,-1!==n?e.split(this._decimal)[0]+t.slice(n):e}return e},getDecimalLength(e){if(e){const t=e.split(this._decimal);if(2===t.length)return t[1].replace(this._suffix,"").trim().replace(/\s/g,"").replace(this._currency,"").length}return 0},updateModel(e,t){this.$emit("update:modelValue",t)},onInputFocus(){this.focused=!0},onInputBlur(e){this.focused=!1;let t=e.target,n=this.validateValue(this.parseValue(t.value));t.value=this.formatValue(n),t.setAttribute("aria-valuenow",n),this.updateModel(e,n)},clearTimer(){this.timer&&clearInterval(this.timer)}},computed:{containerClass(){return["p-inputnumber p-component p-inputwrapper",this.class,{"p-inputwrapper-filled":this.filled,"p-inputwrapper-focus":this.focused,"p-inputnumber-buttons-stacked":this.showButtons&&"stacked"===this.buttonLayout,"p-inputnumber-buttons-horizontal":this.showButtons&&"horizontal"===this.buttonLayout,"p-inputnumber-buttons-vertical":this.showButtons&&"vertical"===this.buttonLayout}]},upButtonClass(){return["p-inputnumber-button p-inputnumber-button-up",this.incrementButtonClass]},downButtonClass(){return["p-inputnumber-button p-inputnumber-button-down",this.decrementButtonClass]},filled(){return null!=this.modelValue&&this.modelValue.toString().length>0},upButtonListeners(){return{mousedown:e=>this.onUpButtonMouseDown(e),mouseup:e=>this.onUpButtonMouseUp(e),mouseleave:e=>this.onUpButtonMouseLeave(e),keydown:e=>this.onUpButtonKeyDown(e),keyup:e=>this.onUpButtonKeyUp(e)}},downButtonListeners(){return{mousedown:e=>this.onDownButtonMouseDown(e),mouseup:e=>this.onDownButtonMouseUp(e),mouseleave:e=>this.onDownButtonMouseLeave(e),keydown:e=>this.onDownButtonKeyDown(e),keyup:e=>this.onDownButtonKeyUp(e)}},formattedValue(){const e=this.modelValue||this.allowEmpty?this.modelValue:0;return this.formatValue(e)},getFormatter(){return this.numberFormat}},components:{INInputText:s.default,INButton:r.default}};const l={key:0,class:"p-inputnumber-button-group"};return function(e,t){void 0===t&&(t={});var n=t.insertAt;if(e&&"undefined"!=typeof document){var i=document.head||document.getElementsByTagName("head")[0],s=document.createElement("style");s.type="text/css","top"===n&&i.firstChild?i.insertBefore(s,i.firstChild):i.appendChild(s),s.styleSheet?s.styleSheet.cssText=e:s.appendChild(document.createTextNode(e))}}("\n.p-inputnumber {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n}\n.p-inputnumber-button {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -webkit-box-flex: 0;\n        -ms-flex: 0 0 auto;\n            flex: 0 0 auto;\n}\n.p-inputnumber-buttons-stacked .p-button.p-inputnumber-button .p-button-label,\n.p-inputnumber-buttons-horizontal .p-button.p-inputnumber-button .p-button-label {\n    display: none;\n}\n.p-inputnumber-buttons-stacked .p-button.p-inputnumber-button-up {\n    border-top-left-radius: 0;\n    border-bottom-left-radius: 0;\n    border-bottom-right-radius: 0;\n    padding: 0;\n}\n.p-inputnumber-buttons-stacked .p-inputnumber-input {\n    border-top-right-radius: 0;\n    border-bottom-right-radius: 0;\n}\n.p-inputnumber-buttons-stacked .p-button.p-inputnumber-button-down {\n    border-top-left-radius: 0;\n    border-top-right-radius: 0;\n    border-bottom-left-radius: 0;\n    padding: 0;\n}\n.p-inputnumber-buttons-stacked .p-inputnumber-button-group {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-inputnumber-buttons-stacked .p-inputnumber-button-group .p-button.p-inputnumber-button {\n    -webkit-box-flex: 1;\n        -ms-flex: 1 1 auto;\n            flex: 1 1 auto;\n}\n.p-inputnumber-buttons-horizontal .p-button.p-inputnumber-button-up {\n    -webkit-box-ordinal-group: 4;\n        -ms-flex-order: 3;\n            order: 3;\n    border-top-left-radius: 0;\n    border-bottom-left-radius: 0;\n}\n.p-inputnumber-buttons-horizontal .p-inputnumber-input {\n    -webkit-box-ordinal-group: 3;\n        -ms-flex-order: 2;\n            order: 2;\n    border-radius: 0;\n}\n.p-inputnumber-buttons-horizontal .p-button.p-inputnumber-button-down {\n    -webkit-box-ordinal-group: 2;\n        -ms-flex-order: 1;\n            order: 1;\n    border-top-right-radius: 0;\n    border-bottom-right-radius: 0;\n}\n.p-inputnumber-buttons-vertical {\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-inputnumber-buttons-vertical .p-button.p-inputnumber-button-up {\n    -webkit-box-ordinal-group: 2;\n        -ms-flex-order: 1;\n            order: 1;\n    border-bottom-left-radius: 0;\n    border-bottom-right-radius: 0;\n    width: 100%;\n}\n.p-inputnumber-buttons-vertical .p-inputnumber-input {\n    -webkit-box-ordinal-group: 3;\n        -ms-flex-order: 2;\n            order: 2;\n    border-radius: 0;\n    text-align: center;\n}\n.p-inputnumber-buttons-vertical .p-button.p-inputnumber-button-down {\n    -webkit-box-ordinal-group: 4;\n        -ms-flex-order: 3;\n            order: 3;\n    border-top-left-radius: 0;\n    border-top-right-radius: 0;\n    width: 100%;\n}\n.p-inputnumber-input {\n    -webkit-box-flex: 1;\n        -ms-flex: 1 1 auto;\n            flex: 1 1 auto;\n}\n.p-fluid .p-inputnumber {\n    width: 100%;\n}\n.p-fluid .p-inputnumber .p-inputnumber-input {\n    width: 1%;\n}\n.p-fluid .p-inputnumber-buttons-vertical .p-inputnumber-input {\n    width: 100%;\n}\n"),u.render=function(e,t,i,s,r,u){const a=n.resolveComponent("INInputText"),o=n.resolveComponent("INButton");return n.openBlock(),n.createBlock("span",{class:u.containerClass,style:i.style},[n.createVNode(a,n.mergeProps({ref:"input",class:["p-inputnumber-input",i.inputClass],style:i.inputStyle,value:u.formattedValue},e.$attrs,{"aria-valumin":i.min,"aria-valuemax":i.max,onInput:u.onUserInput,onKeydown:u.onInputKeyDown,onKeypress:u.onInputKeyPress,onPaste:u.onPaste,onClick:u.onInputClick,onFocus:u.onInputFocus,onBlur:u.onInputBlur}),null,16,["class","style","value","aria-valumin","aria-valuemax","onInput","onKeydown","onKeypress","onPaste","onClick","onFocus","onBlur"]),i.showButtons&&"stacked"===i.buttonLayout?(n.openBlock(),n.createBlock("span",l,[n.createVNode(o,n.mergeProps({class:u.upButtonClass,icon:i.incrementButtonIcon},n.toHandlers(u.upButtonListeners),{disabled:e.$attrs.disabled}),null,16,["class","icon","disabled"]),n.createVNode(o,n.mergeProps({class:u.downButtonClass,icon:i.decrementButtonIcon},n.toHandlers(u.downButtonListeners),{disabled:e.$attrs.disabled}),null,16,["class","icon","disabled"])])):n.createCommentVNode("",!0),i.showButtons&&"stacked"!==i.buttonLayout?(n.openBlock(),n.createBlock(o,n.mergeProps({key:1,class:u.upButtonClass,icon:i.incrementButtonIcon},n.toHandlers(u.upButtonListeners),{disabled:e.$attrs.disabled}),null,16,["class","icon","disabled"])):n.createCommentVNode("",!0),i.showButtons&&"stacked"!==i.buttonLayout?(n.openBlock(),n.createBlock(o,n.mergeProps({key:2,class:u.downButtonClass,icon:i.decrementButtonIcon},n.toHandlers(u.downButtonListeners),{disabled:e.$attrs.disabled}),null,16,["class","icon","disabled"])):n.createCommentVNode("",!0)],6)},u}(primevue.inputtext,primevue.button,Vue);');
				break;
			case "inputtext":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.inputtext=function(e){"use strict";var t={name:"InputText",emits:["update:modelValue"],props:{modelValue:null},methods:{onInput(e){this.$emit("update:modelValue",e.target.value)}},computed:{filled(){return null!=this.modelValue&&this.modelValue.toString().length>0}}};return t.render=function(t,u,l,n,i,o){return e.openBlock(),e.createBlock("input",{class:["p-inputtext p-component",{"p-filled":o.filled}],value:l.modelValue,onInput:u[1]||(u[1]=(...e)=>o.onInput&&o.onInput(...e))},null,42,["value"])},t}(Vue);');
				break;
			case "timeline":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.timeline=function(e,n){"use strict";var t={name:"Timeline",props:{value:null,align:{mode:String,default:"left"},layout:{mode:String,default:"vertical"},dataKey:null},methods:{getKey(n,t){return this.dataKey?e.ObjectUtils.resolveFieldData(n,this.dataKey):t}},computed:{containerClass(){return["p-timeline p-component","p-timeline-"+this.align,"p-timeline-"+this.layout]}}};const i={class:"p-timeline-event-opposite"},l={class:"p-timeline-event-separator"},o=n.createVNode("div",{class:"p-timeline-event-marker"},null,-1),r=n.createVNode("div",{class:"p-timeline-event-connector"},null,-1),m={class:"p-timeline-event-content"};return function(e,n){void 0===n&&(n={});var t=n.insertAt;if(e&&"undefined"!=typeof document){var i=document.head||document.getElementsByTagName("head")[0],l=document.createElement("style");l.type="text/css","top"===t&&i.firstChild?i.insertBefore(l,i.firstChild):i.appendChild(l),l.styleSheet?l.styleSheet.cssText=e:l.appendChild(document.createTextNode(e))}}("\n.p-timeline {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-flex: 1;\n        -ms-flex-positive: 1;\n            flex-grow: 1;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-timeline-left .p-timeline-event-opposite {\n    text-align: right;\n}\n.p-timeline-left .p-timeline-event-content {\n    text-align: left;\n}\n.p-timeline-right .p-timeline-event {\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: row-reverse;\n            flex-direction: row-reverse;\n}\n.p-timeline-right .p-timeline-event-opposite {\n    text-align: left;\n}\n.p-timeline-right .p-timeline-event-content {\n    text-align: right;\n}\n.p-timeline-vertical.p-timeline-alternate .p-timeline-event:nth-child(even) {\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: row-reverse;\n            flex-direction: row-reverse;\n}\n.p-timeline-vertical.p-timeline-alternate .p-timeline-event:nth-child(odd) .p-timeline-event-opposite {\n    text-align: right;\n}\n.p-timeline-vertical.p-timeline-alternate .p-timeline-event:nth-child(odd) .p-timeline-event-content {\n    text-align: left;\n}\n.p-timeline-vertical.p-timeline-alternate .p-timeline-event:nth-child(even) .p-timeline-event-opposite {\n    text-align: left;\n}\n.p-timeline-vertical.p-timeline-alternate .p-timeline-event:nth-child(even) .p-timeline-event-content {\n    text-align: right;\n}\n.p-timeline-event {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    position: relative;\n    min-height: 70px;\n}\n.p-timeline-event:last-child {\n    min-height: 0;\n}\n.p-timeline-event-opposite {\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n    padding: 0 1rem;\n}\n.p-timeline-event-content {\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n    padding: 0 1rem;\n}\n.p-timeline-event-separator {\n    -webkit-box-flex: 0;\n        -ms-flex: 0;\n            flex: 0;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-timeline-event-marker {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -ms-flex-item-align: baseline;\n        align-self: baseline;\n}\n.p-timeline-event-connector {\n    -webkit-box-flex: 1;\n        -ms-flex-positive: 1;\n            flex-grow: 1;\n}\n.p-timeline-horizontal {\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: row;\n            flex-direction: row;\n}\n.p-timeline-horizontal .p-timeline-event {\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n}\n.p-timeline-horizontal .p-timeline-event:last-child {\n    -webkit-box-flex: 0;\n        -ms-flex: 0;\n            flex: 0;\n}\n.p-timeline-horizontal .p-timeline-event-separator {\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: row;\n            flex-direction: row;\n}\n.p-timeline-horizontal .p-timeline-event-connector  {\n    width: 100%;\n}\n.p-timeline-bottom .p-timeline-event {\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: column-reverse;\n            flex-direction: column-reverse;\n}\n.p-timeline-horizontal.p-timeline-alternate .p-timeline-event:nth-child(even) {\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: column-reverse;\n            flex-direction: column-reverse;\n}\n"),t.render=function(e,t,a,s,c,p){return n.openBlock(),n.createBlock("div",{class:p.containerClass},[(n.openBlock(!0),n.createBlock(n.Fragment,null,n.renderList(a.value,((t,s)=>(n.openBlock(),n.createBlock("div",{key:p.getKey(t,s),class:"p-timeline-event"},[n.createVNode("div",i,[n.renderSlot(e.$slots,"opposite",{item:t,index:s})]),n.createVNode("div",l,[n.renderSlot(e.$slots,"marker",{item:t,index:s},(()=>[o])),s!==a.value.length-1?n.renderSlot(e.$slots,"connector",{key:0},(()=>[r])):n.createCommentVNode("",!0)]),n.createVNode("div",m,[n.renderSlot(e.$slots,"content",{item:t,index:s})])])))),128))],2)},t}(primevue.utils,Vue);');
				break;
			case "avatar":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.avatar=function(e){"use strict";var a={name:"Avatar",props:{label:{type:String,default:null},icon:{type:String,default:null},image:{type:String,default:null},size:{type:String,default:"normal"},shape:{type:String,default:"square"}},computed:{containerClass(){return["p-avatar p-component",{"p-avatar-image":null!=this.image,"p-avatar-circle":"circle"===this.shape,"p-avatar-lg":"large"===this.size,"p-avatar-xl":"xlarge"===this.size}]},iconClass(){return["p-avatar-icon",this.icon]}}};const t={key:0,class:"p-avatar-text"};return function(e,a){void 0===a&&(a={});var t=a.insertAt;if(e&&"undefined"!=typeof document){var n=document.head||document.getElementsByTagName("head")[0],r=document.createElement("style");r.type="text/css","top"===t&&n.firstChild?n.insertBefore(r,n.firstChild):n.appendChild(r),r.styleSheet?r.styleSheet.cssText=e:r.appendChild(document.createTextNode(e))}}("\n.p-avatar {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    width: 2rem;\n    height: 2rem;\n    font-size: 1rem;\n}\n.p-avatar.p-avatar-image {\n    background-color: transparent;\n}\n.p-avatar.p-avatar-circle {\n    border-radius: 50%;\n}\n.p-avatar-circle img {\n    border-radius: 50%;\n}\n.p-avatar .p-avatar-icon {\n    font-size: 1rem;\n}\n.p-avatar img {\n    width: 100%;\n    height: 100%;\n}\n"),a.render=function(a,n,r,i,l,s){return e.openBlock(),e.createBlock("div",{class:s.containerClass},[e.renderSlot(a.$slots,"default",{},(()=>[r.label?(e.openBlock(),e.createBlock("span",t,e.toDisplayString(r.label),1)):r.icon?(e.openBlock(),e.createBlock("span",{key:1,class:s.iconClass},null,2)):r.image?(e.openBlock(),e.createBlock("img",{key:2,src:r.image},null,8,["src"])):e.createCommentVNode("",!0)]))],2)},a}(Vue);');
				break;
			case "dropdown":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.dropdown=function(e,t,i,l,n,o){"use strict";function r(e){return e&&"object"==typeof e&&"default"in e?e:{default:e}}var s=r(t),a=r(l),p=r(n),d={name:"Dropdown",emits:["update:modelValue","before-show","before-hide","show","hide","change","filter","focus","blur"],props:{modelValue:null,options:Array,optionLabel:null,optionValue:null,optionDisabled:null,optionGroupLabel:null,optionGroupChildren:null,scrollHeight:{type:String,default:"200px"},filter:Boolean,filterPlaceholder:String,filterLocale:String,filterMatchMode:{type:String,default:"contains"},filterFields:{type:Array,default:null},editable:Boolean,placeholder:String,disabled:Boolean,dataKey:null,showClear:Boolean,inputId:String,tabindex:String,ariaLabelledBy:null,appendTo:{type:String,default:"body"},emptyFilterMessage:{type:String,default:null},emptyMessage:{type:String,default:null},panelClass:null,loading:{type:Boolean,default:!1},loadingIcon:{type:String,default:"pi pi-spinner pi-spin"},virtualScrollerOptions:{type:Object,default:null}},data:()=>({focused:!1,filterValue:null,overlayVisible:!1}),watch:{modelValue(){this.isModelValueChanged=!0}},outsideClickListener:null,scrollHandler:null,resizeListener:null,searchTimeout:null,currentSearchChar:null,previousSearchChar:null,searchValue:null,overlay:null,itemsWrapper:null,virtualScroller:null,isModelValueChanged:!1,updated(){this.overlayVisible&&this.isModelValueChanged&&this.scrollValueInView(),this.isModelValueChanged=!1},beforeUnmount(){this.unbindOutsideClickListener(),this.unbindResizeListener(),this.scrollHandler&&(this.scrollHandler.destroy(),this.scrollHandler=null),this.itemsWrapper=null,this.overlay&&(e.ZIndexUtils.clear(this.overlay),this.overlay=null)},methods:{getOptionIndex(e,t){return this.virtualScrollerDisabled?e:t&&t(e).index},getOptionLabel(t){return this.optionLabel?e.ObjectUtils.resolveFieldData(t,this.optionLabel):t},getOptionValue(t){return this.optionValue?e.ObjectUtils.resolveFieldData(t,this.optionValue):t},getOptionRenderKey(t){return this.dataKey?e.ObjectUtils.resolveFieldData(t,this.dataKey):this.getOptionLabel(t)},isOptionDisabled(t){return!!this.optionDisabled&&e.ObjectUtils.resolveFieldData(t,this.optionDisabled)},getOptionGroupRenderKey(t){return e.ObjectUtils.resolveFieldData(t,this.optionGroupLabel)},getOptionGroupLabel(t){return e.ObjectUtils.resolveFieldData(t,this.optionGroupLabel)},getOptionGroupChildren(t){return e.ObjectUtils.resolveFieldData(t,this.optionGroupChildren)},getSelectedOption(){let e=this.getSelectedOptionIndex();return-1!==e?this.optionGroupLabel?this.getOptionGroupChildren(this.visibleOptions[e.group])[e.option]:this.visibleOptions[e]:null},getSelectedOptionIndex(){if(null!=this.modelValue&&this.visibleOptions){if(!this.optionGroupLabel)return this.findOptionIndexInList(this.modelValue,this.visibleOptions);for(let e=0;e<this.visibleOptions.length;e++){let t=this.findOptionIndexInList(this.modelValue,this.getOptionGroupChildren(this.visibleOptions[e]));if(-1!==t)return{group:e,option:t}}}return-1},findOptionIndexInList(t,i){for(let l=0;l<i.length;l++)if(e.ObjectUtils.equals(t,this.getOptionValue(i[l]),this.equalityKey))return l;return-1},isSelected(t){return e.ObjectUtils.equals(this.modelValue,this.getOptionValue(t),this.equalityKey)},show(){this.$emit("before-show"),this.overlayVisible=!0},hide(){this.$emit("before-hide"),this.overlayVisible=!1},onFocus(e){this.focused=!0,this.$emit("focus",e)},onBlur(e){this.focused=!1,this.$emit("blur",e)},onKeyDown(e){switch(e.which){case 40:this.onDownKey(e);break;case 38:this.onUpKey(e);break;case 32:this.overlayVisible||(this.show(),e.preventDefault());break;case 13:case 27:this.overlayVisible&&(this.hide(),e.preventDefault());break;case 9:this.hide();break;default:this.search(e)}},onFilterKeyDown(e){switch(e.which){case 40:this.onDownKey(e);break;case 38:this.onUpKey(e);break;case 13:case 27:this.overlayVisible=!1,e.preventDefault()}},onDownKey(e){if(this.visibleOptions)if(!this.overlayVisible&&e.altKey)this.show();else{let t=this.visibleOptions&&this.visibleOptions.length>0?this.findNextOption(this.getSelectedOptionIndex()):null;t&&this.updateModel(e,this.getOptionValue(t))}e.preventDefault()},onUpKey(e){if(this.visibleOptions){let t=this.findPrevOption(this.getSelectedOptionIndex());t&&this.updateModel(e,this.getOptionValue(t))}e.preventDefault()},findNextOption(e){if(this.optionGroupLabel){let t=-1===e?0:e.group,i=-1===e?-1:e.option,l=this.findNextOptionInList(this.getOptionGroupChildren(this.visibleOptions[t]),i);return l||(t+1!==this.visibleOptions.length?this.findNextOption({group:t+1,option:-1}):null)}return this.findNextOptionInList(this.visibleOptions,e)},findNextOptionInList(e,t){let i=t+1;if(i===e.length)return null;let l=e[i];return this.isOptionDisabled(l)?this.findNextOptionInList(i):l},findPrevOption(e){if(-1===e)return null;if(this.optionGroupLabel){let t=e.group,i=e.option,l=this.findPrevOptionInList(this.getOptionGroupChildren(this.visibleOptions[t]),i);return l||(t>0?this.findPrevOption({group:t-1,option:this.getOptionGroupChildren(this.visibleOptions[t-1]).length}):null)}return this.findPrevOptionInList(this.visibleOptions,e)},findPrevOptionInList(e,t){let i=t-1;if(i<0)return null;let l=e[i];return this.isOptionDisabled(l)?this.findPrevOption(i):l},onClearClick(e){this.updateModel(e,null)},onClick(t){this.disabled||this.loading||e.DomHandler.hasClass(t.target,"p-dropdown-clear-icon")||"INPUT"===t.target.tagName||this.overlay&&this.overlay.contains(t.target)||(this.overlayVisible?this.hide():this.show(),this.$refs.focusInput.focus())},onOptionSelect(e,t){let i=this.getOptionValue(t);this.updateModel(e,i),this.$refs.focusInput.focus(),setTimeout((()=>{this.hide()}),200)},onEditableInput(e){this.$emit("update:modelValue",e.target.value)},onOverlayEnter(t){if(e.ZIndexUtils.set("overlay",t,this.$primevue.config.zIndex.overlay),this.alignOverlay(),this.bindOutsideClickListener(),this.bindScrollListener(),this.bindResizeListener(),this.filter&&this.$refs.filterInput.focus(),!this.virtualScrollerDisabled){const e=this.getSelectedOptionIndex();-1!==e&&this.virtualScroller.scrollToIndex(e)}this.$emit("show")},onOverlayLeave(){this.unbindOutsideClickListener(),this.unbindScrollListener(),this.unbindResizeListener(),this.$emit("hide"),this.itemsWrapper=null,this.overlay=null},onOverlayAfterLeave(t){e.ZIndexUtils.clear(t)},alignOverlay(){this.appendDisabled?e.DomHandler.relativePosition(this.overlay,this.$el):(this.overlay.style.minWidth=e.DomHandler.getOuterWidth(this.$el)+"px",e.DomHandler.absolutePosition(this.overlay,this.$el))},updateModel(e,t){this.$emit("update:modelValue",t),this.$emit("change",{originalEvent:e,value:t})},bindOutsideClickListener(){this.outsideClickListener||(this.outsideClickListener=e=>{this.overlayVisible&&this.overlay&&!this.$el.contains(e.target)&&!this.overlay.contains(e.target)&&this.hide()},document.addEventListener("click",this.outsideClickListener))},unbindOutsideClickListener(){this.outsideClickListener&&(document.removeEventListener("click",this.outsideClickListener),this.outsideClickListener=null)},bindScrollListener(){this.scrollHandler||(this.scrollHandler=new e.ConnectedOverlayScrollHandler(this.$refs.container,(()=>{this.overlayVisible&&this.hide()}))),this.scrollHandler.bindScrollListener()},unbindScrollListener(){this.scrollHandler&&this.scrollHandler.unbindScrollListener()},bindResizeListener(){this.resizeListener||(this.resizeListener=()=>{this.overlayVisible&&!e.DomHandler.isTouchDevice()&&this.hide()},window.addEventListener("resize",this.resizeListener))},unbindResizeListener(){this.resizeListener&&(window.removeEventListener("resize",this.resizeListener),this.resizeListener=null)},search(e){if(!this.visibleOptions)return;this.searchTimeout&&clearTimeout(this.searchTimeout);const t=e.key;if(this.previousSearchChar=this.currentSearchChar,this.currentSearchChar=t,this.previousSearchChar===this.currentSearchChar?this.searchValue=this.currentSearchChar:this.searchValue=this.searchValue?this.searchValue+t:t,this.searchValue){let t=this.getSelectedOptionIndex(),i=this.optionGroupLabel?this.searchOptionInGroup(t):this.searchOption(++t);i&&this.updateModel(e,this.getOptionValue(i))}this.searchTimeout=setTimeout((()=>{this.searchValue=null}),250)},searchOption(e){let t;return this.searchValue&&(t=this.searchOptionInRange(e,this.visibleOptions.length),t||(t=this.searchOptionInRange(0,e))),t},searchOptionInRange(e,t){for(let i=e;i<t;i++){let e=this.visibleOptions[i];if(this.matchesSearchValue(e))return e}return null},searchOptionInGroup(e){let t=-1===e?{group:0,option:-1}:e;for(let e=t.group;e<this.visibleOptions.length;e++){let i=this.getOptionGroupChildren(this.visibleOptions[e]);for(let l=t.group===e?t.option+1:0;l<i.length;l++)if(this.matchesSearchValue(i[l]))return i[l]}for(let e=0;e<=t.group;e++){let i=this.getOptionGroupChildren(this.visibleOptions[e]);for(let l=0;l<(t.group===e?t.option:i.length);l++)if(this.matchesSearchValue(i[l]))return i[l]}return null},matchesSearchValue(e){return this.getOptionLabel(e).toLocaleLowerCase(this.filterLocale).startsWith(this.searchValue.toLocaleLowerCase(this.filterLocale))},onFilterChange(e){this.$emit("filter",{originalEvent:e,value:e.target.value})},onFilterUpdated(){this.overlayVisible&&this.alignOverlay()},overlayRef(e){this.overlay=e},itemsWrapperRef(e){this.itemsWrapper=e},virtualScrollerRef(e){this.virtualScroller=e},scrollValueInView(){if(this.overlay){let t=e.DomHandler.findSingle(this.overlay,"li.p-highlight");t&&t.scrollIntoView({block:"nearest",inline:"start"})}},onOverlayClick(e){s.default.emit("overlay-click",{originalEvent:e,target:this.$el})}},computed:{visibleOptions(){if(this.filterValue){if(this.optionGroupLabel){let e=[];for(let t of this.options){let l=i.FilterService.filter(this.getOptionGroupChildren(t),this.searchFields,this.filterValue,this.filterMatchMode,this.filterLocale);if(l&&l.length){let i={...t};i[this.optionGroupChildren]=l,e.push(i)}}return e}return i.FilterService.filter(this.options,this.searchFields,this.filterValue,this.filterMatchMode,this.filterLocale)}return this.options},containerClass(){return["p-dropdown p-component p-inputwrapper",{"p-disabled":this.disabled,"p-dropdown-clearable":this.showClear&&!this.disabled,"p-focus":this.focused,"p-inputwrapper-filled":this.modelValue,"p-inputwrapper-focus":this.focused||this.overlayVisible}]},labelClass(){return["p-dropdown-label p-inputtext",{"p-placeholder":this.label===this.placeholder,"p-dropdown-label-empty":!this.$slots.value&&("p-emptylabel"===this.label||0===this.label.length)}]},panelStyleClass(){return["p-dropdown-panel p-component",this.panelClass,{"p-input-filled":"filled"===this.$primevue.config.inputStyle,"p-ripple-disabled":!1===this.$primevue.config.ripple}]},label(){let e=this.getSelectedOption();return e?this.getOptionLabel(e):this.placeholder||"p-emptylabel"},editableInputValue(){let e=this.getSelectedOption();return e?this.getOptionLabel(e):this.modelValue},equalityKey(){return this.optionValue?null:this.dataKey},searchFields(){return this.filterFields||[this.optionLabel]},emptyFilterMessageText(){return this.emptyFilterMessage||this.$primevue.config.locale.emptyFilterMessage},emptyMessageText(){return this.emptyMessage||this.$primevue.config.locale.emptyMessage},appendDisabled(){return"self"===this.appendTo},virtualScrollerDisabled(){return!this.virtualScrollerOptions},appendTarget(){return this.appendDisabled?null:this.appendTo},dropdownIconClass(){return["p-dropdown-trigger-icon",this.loading?this.loadingIcon:"pi pi-chevron-down"]}},directives:{ripple:a.default},components:{VirtualScroller:p.default}};const h={class:"p-hidden-accessible"},u={key:0,class:"p-dropdown-header"},c={class:"p-dropdown-filter-container"},b=o.createVNode("span",{class:"p-dropdown-filter-icon pi pi-search"},null,-1),f={class:"p-dropdown-item-group"},v={key:2,class:"p-dropdown-empty-message"},g={key:3,class:"p-dropdown-empty-message"};return function(e,t){void 0===t&&(t={});var i=t.insertAt;if(e&&"undefined"!=typeof document){var l=document.head||document.getElementsByTagName("head")[0],n=document.createElement("style");n.type="text/css","top"===i&&l.firstChild?l.insertBefore(n,l.firstChild):l.appendChild(n),n.styleSheet?n.styleSheet.cssText=e:n.appendChild(document.createTextNode(e))}}("\n.p-dropdown {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n    cursor: pointer;\n    position: relative;\n    -webkit-user-select: none;\n       -moz-user-select: none;\n        -ms-user-select: none;\n            user-select: none;\n}\n.p-dropdown-clear-icon {\n    position: absolute;\n    top: 50%;\n    margin-top: -.5rem;\n}\n.p-dropdown-trigger {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -ms-flex-negative: 0;\n        flex-shrink: 0;\n}\n.p-dropdown-label {\n    display: block;\n    white-space: nowrap;\n    overflow: hidden;\n    -webkit-box-flex: 1;\n        -ms-flex: 1 1 auto;\n            flex: 1 1 auto;\n    width: 1%;\n    text-overflow: ellipsis;\n    cursor: pointer;\n}\n.p-dropdown-label-empty {\n    overflow: hidden;\n    visibility: hidden;\n}\ninput.p-dropdown-label  {\n    cursor: default;\n}\n.p-dropdown .p-dropdown-panel {\n    min-width: 100%;\n}\n.p-dropdown-panel {\n    position: absolute;\n    top: 0;\n    left: 0;\n}\n.p-dropdown-items-wrapper {\n    overflow: auto;\n}\n.p-dropdown-item {\n    cursor: pointer;\n    font-weight: normal;\n    white-space: nowrap;\n    position: relative;\n    overflow: hidden;\n}\n.p-dropdown-item-group {\n    cursor: auto;\n}\n.p-dropdown-items {\n    margin: 0;\n    padding: 0;\n    list-style-type: none;\n}\n.p-dropdown-filter {\n    width: 100%;\n}\n.p-dropdown-filter-container {\n    position: relative;\n}\n.p-dropdown-filter-icon {\n    position: absolute;\n    top: 50%;\n    margin-top: -.5rem;\n}\n.p-fluid .p-dropdown {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n}\n.p-fluid .p-dropdown .p-dropdown-label {\n    width: 1%;\n}\n"),d.render=function(e,t,i,l,n,r){const s=o.resolveComponent("VirtualScroller"),a=o.resolveDirective("ripple");return o.openBlock(),o.createBlock("div",{ref:"container",class:r.containerClass,onClick:t[13]||(t[13]=e=>r.onClick(e))},[o.createVNode("div",h,[o.createVNode("input",{ref:"focusInput",type:"text",id:i.inputId,readonly:"",disabled:i.disabled,onFocus:t[1]||(t[1]=(...e)=>r.onFocus&&r.onFocus(...e)),onBlur:t[2]||(t[2]=(...e)=>r.onBlur&&r.onBlur(...e)),onKeydown:t[3]||(t[3]=(...e)=>r.onKeyDown&&r.onKeyDown(...e)),tabindex:i.tabindex,"aria-haspopup":"true","aria-expanded":n.overlayVisible,"aria-labelledby":i.ariaLabelledBy},null,40,["id","disabled","tabindex","aria-expanded","aria-labelledby"])]),i.editable?(o.openBlock(),o.createBlock("input",{key:0,type:"text",class:"p-dropdown-label p-inputtext",disabled:i.disabled,onFocus:t[4]||(t[4]=(...e)=>r.onFocus&&r.onFocus(...e)),onBlur:t[5]||(t[5]=(...e)=>r.onBlur&&r.onBlur(...e)),placeholder:i.placeholder,value:r.editableInputValue,onInput:t[6]||(t[6]=(...e)=>r.onEditableInput&&r.onEditableInput(...e)),"aria-haspopup":"listbox","aria-expanded":n.overlayVisible},null,40,["disabled","placeholder","value","aria-expanded"])):o.createCommentVNode("",!0),i.editable?o.createCommentVNode("",!0):(o.openBlock(),o.createBlock("span",{key:1,class:r.labelClass},[o.renderSlot(e.$slots,"value",{value:i.modelValue,placeholder:i.placeholder},(()=>[o.createTextVNode(o.toDisplayString(r.label||"empty"),1)]))],2)),i.showClear&&null!=i.modelValue?(o.openBlock(),o.createBlock("i",{key:2,class:"p-dropdown-clear-icon pi pi-times",onClick:t[7]||(t[7]=e=>r.onClearClick(e))})):o.createCommentVNode("",!0),o.createVNode("div",{class:"p-dropdown-trigger",role:"button","aria-haspopup":"listbox","aria-expanded":n.overlayVisible},[o.renderSlot(e.$slots,"indicator",{},(()=>[o.createVNode("span",{class:r.dropdownIconClass},null,2)]))],8,["aria-expanded"]),(o.openBlock(),o.createBlock(o.Teleport,{to:r.appendTarget,disabled:r.appendDisabled},[o.createVNode(o.Transition,{name:"p-connected-overlay",onEnter:r.onOverlayEnter,onLeave:r.onOverlayLeave,onAfterLeave:r.onOverlayAfterLeave},{default:o.withCtx((()=>[n.overlayVisible?(o.openBlock(),o.createBlock("div",{key:0,ref:r.overlayRef,class:r.panelStyleClass,onClick:t[12]||(t[12]=(...e)=>r.onOverlayClick&&r.onOverlayClick(...e))},[o.renderSlot(e.$slots,"header",{value:i.modelValue,options:r.visibleOptions}),i.filter?(o.openBlock(),o.createBlock("div",u,[o.createVNode("div",c,[o.withDirectives(o.createVNode("input",{type:"text",ref:"filterInput","onUpdate:modelValue":t[8]||(t[8]=e=>n.filterValue=e),onVnodeUpdated:t[9]||(t[9]=(...e)=>r.onFilterUpdated&&r.onFilterUpdated(...e)),autoComplete:"off",class:"p-dropdown-filter p-inputtext p-component",placeholder:i.filterPlaceholder,onKeydown:t[10]||(t[10]=(...e)=>r.onFilterKeyDown&&r.onFilterKeyDown(...e)),onInput:t[11]||(t[11]=(...e)=>r.onFilterChange&&r.onFilterChange(...e))},null,40,["placeholder"]),[[o.vModelText,n.filterValue]]),b])])):o.createCommentVNode("",!0),o.createVNode("div",{ref:r.itemsWrapperRef,class:"p-dropdown-items-wrapper",style:{"max-height":r.virtualScrollerDisabled?i.scrollHeight:""}},[o.createVNode(s,o.mergeProps({ref:r.virtualScrollerRef},i.virtualScrollerOptions,{items:r.visibleOptions,style:{height:i.scrollHeight},disabled:r.virtualScrollerDisabled}),o.createSlots({content:o.withCtx((({styleClass:t,contentRef:l,items:s,getItemOptions:p})=>[o.createVNode("ul",{ref:l,class:["p-dropdown-items",t],role:"listbox"},[i.optionGroupLabel?(o.openBlock(!0),o.createBlock(o.Fragment,{key:1},o.renderList(s,((t,i)=>(o.openBlock(),o.createBlock(o.Fragment,{key:r.getOptionGroupRenderKey(t)},[o.createVNode("li",f,[o.renderSlot(e.$slots,"optiongroup",{option:t,index:r.getOptionIndex(i,p)},(()=>[o.createTextVNode(o.toDisplayString(r.getOptionGroupLabel(t)),1)]))]),(o.openBlock(!0),o.createBlock(o.Fragment,null,o.renderList(r.getOptionGroupChildren(t),((t,i)=>o.withDirectives((o.openBlock(),o.createBlock("li",{class:["p-dropdown-item",{"p-highlight":r.isSelected(t),"p-disabled":r.isOptionDisabled(t)}],key:r.getOptionRenderKey(t),onClick:e=>r.onOptionSelect(e,t),role:"option","aria-label":r.getOptionLabel(t),"aria-selected":r.isSelected(t)},[o.renderSlot(e.$slots,"option",{option:t,index:r.getOptionIndex(i,p)},(()=>[o.createTextVNode(o.toDisplayString(r.getOptionLabel(t)),1)]))],10,["onClick","aria-label","aria-selected"])),[[a]]))),128))],64)))),128)):(o.openBlock(!0),o.createBlock(o.Fragment,{key:0},o.renderList(s,((t,i)=>o.withDirectives((o.openBlock(),o.createBlock("li",{class:["p-dropdown-item",{"p-highlight":r.isSelected(t),"p-disabled":r.isOptionDisabled(t)}],key:r.getOptionRenderKey(t),onClick:e=>r.onOptionSelect(e,t),role:"option","aria-label":r.getOptionLabel(t),"aria-selected":r.isSelected(t)},[o.renderSlot(e.$slots,"option",{option:t,index:r.getOptionIndex(i,p)},(()=>[o.createTextVNode(o.toDisplayString(r.getOptionLabel(t)),1)]))],10,["onClick","aria-label","aria-selected"])),[[a]]))),128)),n.filterValue&&(!s||s&&0===s.length)?(o.openBlock(),o.createBlock("li",v,[o.renderSlot(e.$slots,"emptyfilter",{},(()=>[o.createTextVNode(o.toDisplayString(r.emptyFilterMessageText),1)]))])):!i.options||i.options&&0===i.options.length?(o.openBlock(),o.createBlock("li",g,[o.renderSlot(e.$slots,"empty",{},(()=>[o.createTextVNode(o.toDisplayString(r.emptyMessageText),1)]))])):o.createCommentVNode("",!0)],2)])),_:2},[e.$slots.loader?{name:"loader",fn:o.withCtx((({options:t})=>[o.renderSlot(e.$slots,"loader",{options:t})]))}:void 0]),1040,["items","style","disabled"])],4),o.renderSlot(e.$slots,"footer",{value:i.modelValue,options:r.visibleOptions})],2)):o.createCommentVNode("",!0)])),_:3},8,["onEnter","onLeave","onAfterLeave"])],8,["to","disabled"]))],2)},d}(primevue.utils,primevue.overlayeventbus,primevue.api,primevue.ripple,primevue.virtualscroller,Vue);');
				break;
			case "speeddail":
				$document->addScriptDeclaration('this.primevue=this.primevue||{},this.primevue.speeddial=function(e,i,t,n){"use strict";function s(e){return e&&"object"==typeof e&&"default"in e?e:{default:e}}var o=s(e),l=s(i),r={name:"SpeedDial",props:{model:null,visible:{type:Boolean,default:!1},direction:{type:String,default:"up"},transitionDelay:{type:Number,default:30},type:{type:String,default:"linear"},radius:{type:Number,default:0},mask:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},hideOnClickOutside:{type:Boolean,default:!0},buttonClass:null,maskStyle:null,maskClass:null,showIcon:{type:String,default:"pi pi-plus"},hideIcon:null,rotateAnimation:{type:Boolean,default:!0},tooltipOptions:null,style:null,class:null},documentClickListener:null,container:null,list:null,data(){return{d_visible:this.visible,isItemClicked:!1}},watch:{visible(e){this.d_visible=e}},mounted(){if("linear"!==this.type){const e=t.DomHandler.findSingle(this.container,".p-speeddial-button"),i=t.DomHandler.findSingle(this.list,".p-speeddial-item");if(e&&i){const t=Math.abs(e.offsetWidth-i.offsetWidth),n=Math.abs(e.offsetHeight-i.offsetHeight);this.list.style.setProperty("--item-diff-x",t/2+"px"),this.list.style.setProperty("--item-diff-y",n/2+"px")}}this.hideOnClickOutside&&this.bindDocumentClickListener()},beforeMount(){this.bindDocumentClickListener()},methods:{onItemClick(e,i){i.command&&i.command({originalEvent:e,item:i}),this.hide(),this.isItemClicked=!0,e.preventDefault()},onClick(e){this.d_visible?this.hide():this.show(),this.isItemClicked=!0,this.$emit("click",e)},show(){this.d_visible=!0,this.$emit("show")},hide(){this.d_visible=!1,this.$emit("hide")},calculateTransitionDelay(e){const i=this.model.length;return(this.d_visible?e:i-e-1)*this.transitionDelay},calculatePointStyle(e){const i=this.type;if("linear"!==i){const t=this.model.length,n=this.radius||20*t;if("circle"===i){const i=2*Math.PI/t;return{left:`calc(${n*Math.cos(i*e)}px + var(--item-diff-x, 0px))`,top:`calc(${n*Math.sin(i*e)}px + var(--item-diff-y, 0px))`}}if("semi-circle"===i){const i=this.direction,s=Math.PI/(t-1),o=`calc(${n*Math.cos(s*e)}px + var(--item-diff-x, 0px))`,l=`calc(${n*Math.sin(s*e)}px + var(--item-diff-y, 0px))`;if("up"===i)return{left:o,bottom:l};if("down"===i)return{left:o,top:l};if("left"===i)return{right:l,top:o};if("right"===i)return{left:l,top:o}}else if("quarter-circle"===i){const i=this.direction,s=Math.PI/(2*(t-1)),o=`calc(${n*Math.cos(s*e)}px + var(--item-diff-x, 0px))`,l=`calc(${n*Math.sin(s*e)}px + var(--item-diff-y, 0px))`;if("up-left"===i)return{right:o,bottom:l};if("up-right"===i)return{left:o,bottom:l};if("down-left"===i)return{right:l,top:o};if("down-right"===i)return{left:l,top:o}}}return{}},getItemStyle(e){return{transitionDelay:`${this.calculateTransitionDelay(e)}ms`,...this.calculatePointStyle(e)}},bindDocumentClickListener(){this.documentClickListener||(this.documentClickListener=e=>{this.d_visible&&this.isOutsideClicked(e)&&this.hide(),this.isItemClicked=!1},document.addEventListener("click",this.documentClickListener))},unbindDocumentClickListener(){this.documentClickListener&&(document.removeEventListener("click",this.documentClickListener),this.documentClickListener=null)},isOutsideClicked(e){return this.container&&!(this.container.isSameNode(e.target)||this.container.contains(e.target)||this.isItemClicked)},containerRef(e){this.container=e},listRef(e){this.list=e}},computed:{containerClass(){return[`p-speeddial p-component p-speeddial-${this.type}`,{[`p-speeddial-direction-${this.direction}`]:"circle"!==this.type,"p-speeddial-opened":this.d_visible,"p-disabled":this.disabled},this.class]},buttonClassName(){return["p-speeddial-button p-button-rounded",{"p-speeddial-rotate":this.rotateAnimation&&!this.hideIcon},this.buttonClass]},iconClassName(){return this.d_visible&&this.hideIcon?this.hideIcon:this.showIcon},maskClassName(){return["p-speeddial-mask",{"p-speeddial-mask-visible":this.d_visible},this.maskClass]}},components:{SDButton:o.default},directives:{ripple:l.default}};return function(e,i){void 0===i&&(i={});var t=i.insertAt;if(e&&"undefined"!=typeof document){var n=document.head||document.getElementsByTagName("head")[0],s=document.createElement("style");s.type="text/css","top"===t&&n.firstChild?n.insertBefore(s,n.firstChild):n.appendChild(s),s.styleSheet?s.styleSheet.cssText=e:s.appendChild(document.createTextNode(e))}}("\n.p-speeddial {\n    position: absolute;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    z-index: 1;\n}\n.p-speeddial-list {\n    margin: 0;\n    padding: 0;\n    list-style: none;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -webkit-transition: top 0s linear 0.2s;\n    transition: top 0s linear 0.2s;\n    pointer-events: none;\n}\n.p-speeddial-item {\n    -webkit-transform: scale(0);\n            transform: scale(0);\n    opacity: 0;\n    -webkit-transition: opacity 0.8s, -webkit-transform 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;\n    transition: opacity 0.8s, -webkit-transform 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;\n    transition: transform 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, opacity 0.8s;\n    transition: transform 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, opacity 0.8s, -webkit-transform 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;\n    will-change: transform;\n}\n.p-speeddial-action {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    border-radius: 50%;\n    position: relative;\n    overflow: hidden;\n}\n.p-speeddial-circle .p-speeddial-item,\n.p-speeddial-semi-circle .p-speeddial-item,\n.p-speeddial-quarter-circle .p-speeddial-item {\n    position: absolute;\n}\n.p-speeddial-rotate {\n    -webkit-transition: -webkit-transform 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;\n    transition: -webkit-transform 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;\n    transition: transform 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;\n    transition: transform 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, -webkit-transform 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;\n    will-change: transform;\n}\n.p-speeddial-mask {\n    position: absolute;\n    left: 0;\n    top: 0;\n    width: 100%;\n    height: 100%;\n    opacity: 0;\n    -webkit-transition: opacity 250ms cubic-bezier(0.25, 0.8, 0.25, 1);\n    transition: opacity 250ms cubic-bezier(0.25, 0.8, 0.25, 1);\n}\n.p-speeddial-mask-visible {\n    pointer-events: none;\n    opacity: 1;\n    -webkit-transition: opacity 400ms cubic-bezier(0.25, 0.8, 0.25, 1);\n    transition: opacity 400ms cubic-bezier(0.25, 0.8, 0.25, 1);\n}\n.p-speeddial-opened .p-speeddial-list {\n    pointer-events: auto;\n}\n.p-speeddial-opened .p-speeddial-item {\n    -webkit-transform: scale(1);\n            transform: scale(1);\n    opacity: 1;\n}\n.p-speeddial-opened .p-speeddial-rotate {\n    -webkit-transform: rotate(45deg);\n            transform: rotate(45deg);\n}\n\n/* Direction */\n.p-speeddial-direction-up {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: column-reverse;\n            flex-direction: column-reverse;\n}\n.p-speeddial-direction-up .p-speeddial-list {\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: column-reverse;\n            flex-direction: column-reverse;\n}\n.p-speeddial-direction-down {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-speeddial-direction-down .p-speeddial-list {\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-speeddial-direction-left {\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: row-reverse;\n            flex-direction: row-reverse;\n}\n.p-speeddial-direction-left .p-speeddial-list {\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: reverse;\n        -ms-flex-direction: row-reverse;\n            flex-direction: row-reverse;\n}\n.p-speeddial-direction-right {\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: row;\n            flex-direction: row;\n}\n.p-speeddial-direction-right .p-speeddial-list {\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: row;\n            flex-direction: row;\n}\n"),r.render=function(e,i,t,s,o,l){const r=n.resolveComponent("SDButton"),a=n.resolveDirective("tooltip"),c=n.resolveDirective("ripple");return n.openBlock(),n.createBlock(n.Fragment,null,[n.createVNode("div",{ref:l.containerRef,class:l.containerClass,style:t.style},[n.renderSlot(e.$slots,"button",{toggle:l.onClick},(()=>[n.createVNode(r,{type:"button",class:l.buttonClassName,icon:l.iconClassName,onClick:i[1]||(i[1]=e=>l.onClick(e)),disabled:t.disabled},null,8,["class","icon","disabled"])])),n.createVNode("ul",{ref:l.listRef,class:"p-speeddial-list",role:"menu"},[(n.openBlock(!0),n.createBlock(n.Fragment,null,n.renderList(t.model,((i,s)=>(n.openBlock(),n.createBlock("li",{key:s,class:"p-speeddial-item",style:l.getItemStyle(s),role:"none"},[e.$slots.item?(n.openBlock(),n.createBlock(n.resolveDynamicComponent(e.$slots.item),{key:1,item:i},null,8,["item"])):n.withDirectives((n.openBlock(),n.createBlock("a",{key:0,href:i.url||"#",role:"menuitem",class:["p-speeddial-action",{"p-disabled":i.disabled}],target:i.target,onClick:e=>l.onItemClick(e,i)},[i.icon?(n.openBlock(),n.createBlock("span",{key:0,class:["p-speeddial-action-icon",i.icon]},null,2)):n.createCommentVNode("",!0)],10,["href","target","onClick"])),[[a,{value:i.label,disabled:!t.tooltipOptions},t.tooltipOptions],[c]])],4)))),128))],512)],6),t.mask?(n.openBlock(),n.createBlock("div",{key:0,class:l.maskClassName,style:t.maskStyle},null,6)):n.createCommentVNode("",!0)],64)},r}(primevue.button,primevue.ripple,primevue.utils,Vue);');
				break;



		}


	}

	/**
	 * A simple PHP function that calculates the percentage of a given number.
	 *
	 * @param   int  $number   The number you want a percentage of.
	 * @param   numeric  $percent  The percentage that you want to calculate.
	 *
	 * @return int The final result.
	 * @since 1.0
	 */

	public static function getPercentOfNumber(int $number, $percent)
	{
		return ($percent / 100) * $number;
	}


	function hex2rgba($color, $opacity = false)
	{

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if (empty($color))
			return $default;

		//Sanitize $color if "#" is provided
		if ($color[0] == '#')
		{
			$color = substr($color, 1);
		}

		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6)
		{
			$hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		}
		elseif (strlen($color) == 3)
		{
			$hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		}
		else
		{
			return $default;
		}

		//Convert hexadec to rgb
		$rgb = array_map('hexdec', $hex);

		//Check if opacity is set(rgba or rgb)
		if ($opacity)
		{
			if (abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
		}
		else
		{
			$output = 'rgb(' . implode(",", $rgb) . ')';
		}

		//Return rgb(a) color string
		return $output;
	}

	public static function getVariant(array $product_ids = null)
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true);

		$query->select('*')
			->from($db->quoteName('#__commercelab_shop_product_variant'));

		if ($product_ids)
		{
			$query->where($db->quoteName('product_id') . ' IN (' . implode(',', $product_ids) . ')');
		}

		$query->group('name');

		$db->setQuery($query);

		return $db->loadObjectList();
	}


}

