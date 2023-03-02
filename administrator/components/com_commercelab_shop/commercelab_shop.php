<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Access\Exception\NotAllowed;

// use CommerceLabShop\Config\ConfigFactory;

HTMLHelper::_('behavior.keepalive');

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_commercelab_shop'))
{
    throw new NotAllowed(Text::_('JERROR_ALERTNOAUTHOR'), 403);
}

$isSetup = \CommerceLabShop\Setup\SetupFactory::isSetup();
if(!$isSetup && ComponentHelper::getParams('com_commercelab_shop')->get('subscription_key', '') == '') {
    include(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/firsttimeintro/intro.php');
} 

include(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/wrapper/bootstrapWrapper.php');
new bootstrapWrapper();


?>

<?php if (Version::MAJOR_VERSION === 3) : ?>

    <script>
        // Remove Joomla admin headers and toolbars
        jQuery(document).ready(function () {
            jQuery('#isisJsData').hide();
            /*jQuery('header').hide();*/
        });
        // remove system message for Uikit Replacement
        jQuery(document).ready(function () {
            jQuery('#system-message-container').hide();
            jQuery('#j-main-container').removeClass('span10');

        });

        // jQuery('link[rel=stylesheet][href*="isis/css/template"]').remove();
    </script>

<?php else : ?>


    <script>
        document.getElementById("subhead-container").remove();
    </script>

<?php endif; ?>