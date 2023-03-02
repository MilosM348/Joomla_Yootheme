<?php
/**
 * @package   CommerceLab Shop
 * @author    Cloud Chief - CommerceLab Shop
 * @copyright Copyright (C) 2021 Cloud Chief - CommerceLab Shop
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 *
 * @since		2.0
 */
class plgQuickiconCommercelab_shop extends JPlugin
{
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);

        $app = Factory::getApplication();

        // only in Admin and only if the component is enabled
        if ($app->getClientId() !== 1 || ComponentHelper::getComponent('com_commercelab_shop', true)->enabled === false) {
            return;
        }

		\CommerceLabShop\Language\LanguageFactory::load();

    }

    public function onGetIcons($context)
    {
        if ($context != $this->params->get('context', 'mod_quickicon')) {
            return;
        }


        return array(array(
            'link'      => 'index.php?option=com_commercelab_shop',
            'image'     => 'fas fa-shopping-cart',
            'text'      => Text::_('COM_COMMERCELAB_SHOP'),
            'id'        => 'plg_quickicon_commercelab_shop',
        ));
    }
}
