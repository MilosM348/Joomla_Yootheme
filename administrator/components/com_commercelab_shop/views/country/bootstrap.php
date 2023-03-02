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
use Joomla\CMS\Language\Text;

use CommerceLabShop\Render\Render;
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Utilities\Utilities;


/**
 *
 * @since       1.6
 */
class bootstrap extends AdminModel
{

	public $vars;

	public function __construct()
	{


		$input = Factory::getApplication()->input;
		$id    = $input->get('id');

		$this->init($id);
		$this->addScripts();
		$this->addStylesheets();

		echo Render::render(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/country/country.php', $this->vars);


	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	private function init($id)
	{


		$this->vars['item'] = false;
		$this->vars['successMessage'] = Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_SAVED');

		if($id) {
			$this->vars['item'] = $this->getTheItem($id);
		}



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
		return CountryFactory::get($id);
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

		$form = $this->loadForm('com_commercelab_shop.country', 'country', array('control' => 'jform', 'load_data' => $loadData));

		return $form;
	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	private function addScripts($add = false)
	{


		$doc = Factory::getDocument();

		// include the vue script - defer
		$doc->addScript('../media/com_commercelab_shop/js/vue/country/country.min.js', array('type' => 'text/javascript'), array('defer' => 'defer'));
		$doc->addCustomTag('<script id="successMessage" type="application/json">' . $this->vars['successMessage'] . '</script>');

		// include prime
		Utilities::includePrime(array('inputswitch'));

		if ($this->vars['item'])
		{

			foreach ($this->vars['item'] as $key => $value)
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


	}

	/**
	 *
	 *
	 * @since 2.0
	 */

	private function addStylesheets()
	{
	}

}

