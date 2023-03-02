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

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Joomla\CMS\Editor\Editor;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

use CommerceLabShop\MediaManager\MediaManagerFactory;
use CommerceLabShop\Optiontemplates\Optiontemplates;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Product\Product;
use CommerceLabShop\Tag\TagFactory;
use CommerceLabShop\Render\Render;

/**
 *
 * @since      1.6
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
	public static $view = 'product';

	public function __construct()
	{

		$input = Factory::getApplication()->input;
		$id    = $input->get('id');

		$this->init($id);

		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/' . self::$view . '/' . self::$view . '.php', $this->vars);

	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	private function init($id)
	{

		$config = ConfigFactory::get();

		$this->vars['item']                  = false;
		$this->vars['folderTree']            = MediaManagerFactory::getFolderTree();
		$this->vars['currentPath']           = MediaManagerFactory::getHomePath();
		$this->vars['builderLink']           = $this->getBuilderLink();
		$this->vars['editor_name']           = (Factory::getApplication()->get('editor') == 'jce') ? 'tinymce' : Factory::getApplication()->get('editor');
		$this->vars['editor_field']          = JEditor::getInstance(Factory::getApplication()->get('editor'));
		$this->vars['available_tags']        = TagFactory::getAvailableTags();
		$this->vars['available_options']     = [];
		$this->vars['default_category']      = $config->get('defaultproductcategory', ProductFactory::getUncategorisedId());
		$this->vars['default_category_name'] = ProductFactory::getCategoryName($this->vars['default_category']);
		$this->vars['category_parents_tree'] = (JVERSION >= "4.0.0") ? ProductFactory::getCategoryParentsTree($this->vars['default_category']) : [];
		if ($id)
		{
			$this->vars['item']                  = $this->getTheItem($id);
			$this->vars['custom_fields']         = (JVERSION >= "4.0.0") ? ProductFactory::getAvailableCustomFields($this->vars['item']->joomlaItem, $this->vars['item']->joomlaItem->catid) : [];
			$this->vars['available_options']     = ($this->vars['item']->options) ? $this->vars['item']->options : [];
			$this->vars['available_tags']        = TagFactory::getAvailableTags($id);
			$this->vars['default_category']      = $this->vars['item']->joomlaItem->catid;
			$this->vars['default_category_name'] = ProductFactory::getCategoryName($this->vars['item']->joomlaItem->catid);
			$this->vars['category_parents_tree'] = (JVERSION >= "4.0.0") ? ProductFactory::getCategoryParentsTree($this->vars['item']->joomlaItem->catid) : [];
		} else {
			$this->vars['custom_fields']         = (JVERSION >= "4.0.0") ? ProductFactory::getAvailableCustomFields() : [];
		}
		$this->vars['extensions']              = Factory::getApplication()->triggerEvent('onGetProductAddons');	
		$this->vars['optiontemplates']         = Optiontemplates::getOptionList($type='variant_option');
		$this->vars['optionCheckboxtemplates'] = Optiontemplates::getOptionList($type='checkbox_option');
		
		$this->addScripts();
		$this->addStylesheets();
		$this->addTranslationStrings();		
		$this->vars['form'] = $this->getForm(array('item' => $this->vars['item']), true);

	}

	/**
	 *
	 * @return Product|null
	 *
	 * @since 2.0
	 */

	public function getTheItem($id)
	{
		return ProductFactory::get($id);
	}

	private function getBuilderLink()
	{
		if (!$this->getYtpTemplate())
		{
			Factory::getApplication()->enqueueMessage('Please install <a target="_blank" href="https://yootheme.com/page-builder">YOOtheme Pro</a> in order to use the builder', 'notice');
			return 'javascript:void(0);';
		}

		$templateStyle = $this->getYtpTemplate()->id;
		return  'index.php?option=com_ajax&p=customizer&templateStyle=' . $templateStyle . '&format=html&site=JOOMLA_LINK&return=' . urlencode('index.php?option=com_commercelab_shop&view=product&id=PRODUCT_ID');
	}

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


	/** First Item Data Bind
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

		$form = $this->loadForm('com_commercelab_shop.' . 'product', 'product', array('control' => 'jform', 'load_data' => $loadData));

		if ($item)
		{
			$form->setValue('title', null, $item->joomlaItem->title);
			$form->setValue('subtitle', null, $item->subtitle);
			$form->setValue('short_desc', null, $item->short_desc);
			$form->setValue('long_desc', null, $item->long_desc);
			$form->setValue('access', null, $item->joomlaItem->access);
			$form->setValue('teaserimage', null, $item->images['image_intro']);
			$form->setValue('fullimage', null, $item->images['image_fulltext']);
			$form->setValue('state', null, $item->joomlaItem->state);
			$form->setValue('publish_up_date', null, $item->joomlaItem->publish_up);
			$form->setValue('taxclass', null, $item->taxclass);
			$form->setValue('apply_discount', null, $item->apply_discount);
			$form->setValue('discount', null, $item->discountFloat);
			$form->setValue('base_price', null, $item->basepriceFloat);
			$form->setValue('manage_stock', null, $item->manage_stock);
			$form->setValue('shipping_mode', null, $item->shipping_mode);			
			$tagsHelper = new TagsHelper();
			$form->setValue('tags', null, $tagsHelper->getTagIds($item->joomlaItem->id, "com_content.article"));
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
		$doc->addScript('../media/com_commercelab_shop/js/vue/' . self::$view . '/' . self::$view . '.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


		// include prime
		Utilities::includePrime(array('inputswitch', 'button', 'chip', 'chips', 'inputtext', 'inputnumber'));
		
		if ($this->vars['item'])
		{
			$doc->addCustomTag('<script id="root_path" type="application/json">' .URI::root() . '</script>');
			foreach ($this->vars['item'] as $key => $value)
			{
				if (is_string($value))
				{
					if ($key === 'id')
					{
						$key = 'product_id';
					}

					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . $value . '</script>');
				}
				else
				{
					if ($key === 'id')
					{
						$key = 'product_id';
					}

					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . json_encode($value) . '</script>');
				}


			}
			foreach ($this->vars['item']->joomlaItem as $key => $value)
			{
				if (is_string($value))
				{
					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . $value . '</script>');
				}
				else
				{
					$doc->addCustomTag('<script id="jform_' . $key . '_data" type="application/json">' . json_encode($value) . '</script>');
				}

			}

		}

		
		$doc->addCustomTag(' <script id="editor" type="application/json">' . $this->vars['editor_name'] . '</script>');
		if (JVERSION >= "4.0.0") {
			$doc->addCustomTag(' <script id="custom_fields_data" type="application/json">' . json_encode($this->vars['custom_fields']) . '</script>');
		}
		$doc->addCustomTag(' <script id="available_tags_data" type="application/json">' . json_encode($this->vars['available_tags']) . '</script>');
		$doc->addCustomTag(' <script id="available_options_data" type="application/json">' . json_encode($this->vars['available_options']) . '</script>');
		$doc->addCustomTag(' <script id="default_category" type="application/json">' . $this->vars['default_category'] . '</script>');
		$doc->addCustomTag(' <script id="default_category_name" type="application/json">' . $this->vars['default_category_name'] . '</script>');
		$doc->addCustomTag(' <script id="category_parents_tree_data" type="application/json">' . json_encode($this->vars['category_parents_tree']) . '</script>');
		$doc->addCustomTag(' <script id="folderTree_data" type="application/json">' . json_encode($this->vars['folderTree']) . '</script>');
		$doc->addCustomTag(' <script id="currentPath_data" type="application/json">' . json_encode($this->vars['currentPath']) . '</script>');
		$doc->addCustomTag(' <script id="optionTemplates_data" type="application/json">' . json_encode($this->vars['optiontemplates']) . '</script>');
		$doc->addCustomTag(' <script id="optionCheckboxtemplates_data" type="application/json">' . json_encode($this->vars['optionCheckboxtemplates']) . '</script>');


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

		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED') . '</script>');
		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT') . '</script>');
		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE') . '</script>');
		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT') . '</script>');
		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL') . '</script>');
		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL') . '</script>');
		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE') . '</script>');
		
		$doc->addCustomTag(' <script id="COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY" type="application/json">' . Text::_('COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY') . '</script>');

	}

}

