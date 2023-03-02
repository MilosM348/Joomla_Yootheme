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
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\Registry\Registry;

use CommerceLabShop\Render\Render;
use CommerceLabShop\Shop\ShopFactory;
use CommerceLabShop\Order\OrderFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Config\ConfigFactory;

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
	public static $view = 'shop';

	public function __construct()
	{
		// $this->getForm();
		$input = Factory::getApplication()->input;
		$id    = $input->get('id');
		$this->init($id);
		echo Render::render(JPATH_PLUGINS . '/commercelab_shop_extended/shops/views/'.self::$view.'/'.self::$view.'.php', $this->vars);
	}

	/**
	 *
	 * @return void
	 *
	 * @since 2.0
	 */

	private function init($id)
	{
		$config = ConfigFactory::get();

		$default_country         = CountryFactory::getDefault();
		$this->vars['currency']  = CurrencyFactory::getDefault();
		$this->vars['locale']    = Factory::getLanguage()->get('tag');
		$this->vars['products']  = ProductFactory::getList();
		$this->vars['countries'] = CountryFactory::getList(0, 0, true);
		$this->vars['zones']     = CountryFactory::getZoneList(0, 0, true, null, $default_country->id);
		$this->vars['builderLink'] = $this->getBuilderLink();
		$this->vars['default_category']      = $config->get('defaultproductcategory', ShopFactory::getUncategorisedId());
		$this->vars['default_category_name'] = ShopFactory::getCategoryName($this->vars['default_category']);
		$this->vars['category_parents_tree'] = (JVERSION >= "4.0.0") ? ShopFactory::getCategoryParentsTree($this->vars['default_category']) : [];
		// $this->addScripts();
		// $this->addStylesheets();

		if ($id)
		{
			$item = ShopFactory::get($id);
			$this->vars['default_category']      = $item->joomlaItem->catid;
			$this->vars['default_category_name'] = ShopFactory::getCategoryName($item->joomlaItem->catid);
			$this->vars['category_parents_tree'] = (JVERSION >= "4.0.0") ? ShopFactory::getCategoryParentsTree($item->joomlaItem->catid) : [];
		}
		else
		{

			$item = new stdClass();

			$item->title           = '';
			$item->address         = '';
			$item->city            = '';
			$item->zone            = '';
			$item->country         = $default_country->id;
			$item->products        = [];
			$item->enablepickup    = 0;
			$item->enableordertime = 0;
			$item->imagePath           = "";
			$item->published       = true;
			
			$item->pickuptimes = [
			    0 => [
			        'name' => Text::_('Monday'),
			        'workingday' => true,
					'timeslots' => []
			    ],
			    1 => [
			        'name' => Text::_('Tuesday'),
			        'workingday' => true,
					'timeslots' => []
			    ],
			    2 => [
			        'name' => Text::_('Wednesday'),
			        'workingday' => true,
					'timeslots' => []
			    ],
			    3 => [
			        'name' => Text::_('Thursday'),
			        'workingday' => true,
					'timeslots' => []
			    ],
			    4 => [
			        'name' => Text::_('Friday'),
			        'workingday' => true,
					'timeslots' => []
			    ],
			    5 => [
			        'name' => Text::_('Saturday'),
			        'workingday' => true,
					'timeslots' => []
			    ],
			    6 => [
			        'name' => Text::_('Sunday'),
			        'workingday' => false,
					'timeslots' => []
			    ],
			];
			$item->workinghours = [
			    0 => [
			        'name' => Text::_('Monday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    1 => [
			        'name' => Text::_('Tuesday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    2 => [
			        'name' => Text::_('Wednesday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    3 => [
			        'name' => Text::_('Thursday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    4 => [
			        'name' => Text::_('Friday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    5 => [
			        'name' => Text::_('Saturday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    6 => [
			        'name' => Text::_('Sunday'),
			        'workingday' => false,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			];
			$item->ordertimes = [
			    0 => [
			        'name' => Text::_('Monday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    1 => [
			        'name' => Text::_('Tuesday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    2 => [
			        'name' => Text::_('Wednesday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    3 => [
			        'name' => Text::_('Thursday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    4 => [
			        'name' => Text::_('Friday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    5 => [
			        'name' => Text::_('Saturday'),
			        'workingday' => true,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			    6 => [
			        'name' => Text::_('Sunday'),
			        'workingday' => false,
			        'workinghours' => [
			            'start1' => '08:00',
			            'end1' => '',
			            'start2' => '',
			            'end2' => '19:00',
			        ],
			        'straight' => true
			    ],
			];
		}

		$this->vars['item'] = $item;

		$this->vars['form'] = $this->getForm(array('item' => $this->vars['item']), true);

	}

	/**
	 * @param   array  $data
	 * @param   bool   $loadData
	 *
	 * @return bool
	 *
	 * @since version
	 */

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$item = $data['item'];
		// $form = $this->loadForm('com_commercelab_shop.' . 'product', 'product', array('control' => 'jform', 'load_data' => $loadData));
		$form = new Form('commercelab_shop_extended.shops.shop');
		$form->loadFile(
			JPATH_PLUGINS . '/commercelab_shop_extended/shops/forms/shop.xml', 
			[
				'control' => 'jform', 
				'load_data' => $loadData
			]
		);
		if ($item)
		{
			$form->setValue('title', null, $item->title);
			$form->setValue('image', null, $item->imagePath);
		}
		$form->addFieldPath('administrator/components/com_commercelab_shop/models/fields');
		return $form;
	}

	/**
	 *
	 *
	 * @since version
	 */

	// private function addScripts()
	// {

	// 	$doc = Factory::getDocument();


	// 	// include the vue script - defer
	// 	$doc->addScript('../media/com_commercelab_shop/js/vue/'.self::$view.'/'.self::$view.'.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));


	// 	//set up data for vue:
	// 	if ($this->vars['item'])
	// 	{


	// 			$doc->addCustomTag('<script id="p2s_order" type="application/json">' . json_encode($this->vars['item']) . '</script>');


	// 	}


	// 	// include whatever PrimeVue component scripts we need
	// 	Utilities::includePrime(array('inputswitch', 'timeline', 'avatar'));


	// }

	// /**
	//  *
	//  *
	//  * @since version
	//  */

	// private function addStylesheets()
	// {
	// }

	private function getBuilderLink()
	{
		if (!$this->getYtpTemplate())
		{
			Factory::getApplication()->enqueueMessage('Please install <a target="_blank" href="https://yootheme.com/page-builder">YOOtheme Pro</a> in order to use the builder', 'notice');
			return 'javascript:void(0);';
		}

		$templateStyle = $this->getYtpTemplate()->id;
		return  'index.php?option=com_ajax&p=customizer&templateStyle=' . $templateStyle . '&format=html&site=JOOMLA_LINK&return=' . urlencode('index.php?option=com_commercelab_shop&extended=shops&view=shop&id=SHOP_ID');
	}
	
	/**
	 * Function to get active YOOtheme Pro template ID
	 *
	 * @return object
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
		return null;
	 }
}

