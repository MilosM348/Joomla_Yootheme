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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('jquery.framework');


$domain         = $_SERVER['HTTP_HOST'];
$domainhostname = gethostbyname($_SERVER['HTTP_HOST']);
$ip             = file_get_contents('https://api.ipify.org');
$localhost      = (str_starts_with($domainhostname, '127.0.0.1') || str_starts_with($domainhostname, 'localhost')) ? '1' : '0';

// Factory::getApplication()->enqueueMessage($vars['message_html'], 'error');

// init vars
/** @var array $vars */

?>
<!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.1/dist/css/uikit.min.css" />

<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.1/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.1/dist/js/uikit-icons.min.js"></script>


<div id="cls_inactive">

	<div class="uk-container uk-margin-large-top">

		<?= $vars['message_html'] ?>

	</div>

</div>

<div style="margin-top: 100px; font-size: 13px; padding-left: 30px;">
    <a class="see-validation-details" href="javascript:void(0);">See validation details</a>
    <div class="validation-details" style="display: none;">
        Domain: <?= $domain; ?> <br />
        Host: <?=  $domainhostname; ?> <br />
        IP: <?=  $ip; ?> <br />    
        Is Localhost: <?=  $localhost; ?> <br />    
    </div>
</div>

<script type="text/javascript">
    jQuery( window ).ready(function($) {
        $('.see-validation-details').click(function() {
            $('.validation-details').toggle();
        });
    });
</script>