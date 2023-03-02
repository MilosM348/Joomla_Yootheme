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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;


use CommerceLabShop\Route\Route;
use CommerceLabShop\Setup\Setup;


HTMLHelper::_('behavior.keepalive');

$rootUrl = Uri::root();

$input = Factory::getApplication()->input;
$user  = Factory::getUser();

// Access check.
if (!$user->authorise('core.manage', 'com_commercelab_shop'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

// Add CSS file for all pages
$document = Factory::getDocument();
$document->addStyleSheet("https://cdn.jsdelivr.net/npm/uikit@latest/dist/css/uikit.min.css");
$document->addStyleSheet($rootUrl . "media/com_commercelab_shop/css/style.css");
$document->addStyleSheet($rootUrl . "media/com_commercelab_shop/js/angular/{{styles}}");
$document->addScript("https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit.min.js");
$document->addScript("https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit-icons.min.js");
$document->addScript("https://kit.fontawesome.com/6afbbf2d93.js");

// routing
$routeHelper = new Route;

// version
$xml = simplexml_load_file(JPATH_ADMINISTRATOR . "/components/com_commercelab_shop/commercelab_shop.xml");
if (isset($xml->version))
{
	$version = $xml->version;
}

$setup = new Setup();

// get params
$params = ComponentHelper::getParams('com_commercelab_shop');

$doc = Factory::getDocument();
$doc->setBase($rootUrl . "administrator/index.php?");

$messages = Factory::getApplication()->getMessageQueue();

if (!empty($messages))
{
	foreach ($messages as $message)
	{

		switch ($message['type'])
		{
			case 'notice':
			case 'info':
				$type = 'primary';
				break;
			case 'warning':
				$type = 'warning';
				break;
			case 'error':
				$type = 'danger';
				break;
			case 'message':
				$type = 'success';
				break;
		}
		echo "<script>UIkit.notification({message: '" . $message['message'] . "',status: '" . $type . "',pos: 'top-center',timeout: 5000});</script>";
	}
}

?>

<app-root navigate="<?= $routeHelper->route; ?>" version="<?= $version; ?>" adminname="<?= $user->name; ?>" uriroot="<?= $rootUrl; ?>"
          adminid="<?= $user->id; ?>"
          adminusername="<?= $user->username; ?>" adminemail="<?= $user->email; ?>"
          issetupdone="<?= $setup->issetup; ?>"></app-root>


<script src="<?= $rootUrl; ?>media/com_commercelab_shop/js/angular/{{runtime-es2015}}"
        type="module"></script>
<script src="<?= $rootUrl; ?>media/com_commercelab_shop/js/angular/{{runtime-es5}}" nomodule
        defer></script>
<script src="<?= $rootUrl; ?>media/com_commercelab_shop/js/angular/{{polyfills-es5}}" nomodule
        defer></script>
<script src="<?= $rootUrl; ?>media/com_commercelab_shop/js/angular/{{polyfills-es2015}}"
        type="module"></script>
<script src="<?= $rootUrl; ?>media/com_commercelab_shop/js/angular/{{main-es2015}}"
        type="module"></script>
<script src="<?= $rootUrl; ?>media/com_commercelab_shop/js/angular/{{main-es5}}" nomodule defer></script>

<?php if ($setup->issetup == 'false') : ?>

    <style>
        #content {
            margin-left: 0px !important;
        }
    </style>

<?php endif; ?>

<script>
    // Remove Joomla admin headers and toolbars
    jQuery(document).ready(function () {
        jQuery('#isisJsData').hide();
        jQuery('header').hide();
    });
    // remove system message for Uikit Replacement
    jQuery(document).ready(function () {
        jQuery('#system-message-container').hide();
        jQuery('#j-main-container').removeClass('span10');

    });
</script>





