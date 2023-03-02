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
use Joomla\CMS\Uri\Uri;

/** @var array $displayData */
$data      = $displayData;
$required  = $data['required'];
$name      = $data['name'];
$value     = $data['value'];
$rawvalue  = $data['rawvalue'];
$container = $data['container'];

?>

    <div class="controls">
        <div uk-lightbox="container: #<?= $container; ?>" data-type="iframe" id="<?= $container; ?>_trigger">
            <a href="<?= new Uri('index.php?option=com_users&view=users&layout=modal&tmpl=component&required=' . $required . '&field=' ) ?><?= $container ?>" class="rise uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></a>
            <input placeholder="<?= Text::_('JLIB_FORM_SELECT_USER') ?>" disabled type="text" 
                :value="<?= $value ?>"
                v-model="<?= $value ?>"
                class="bind-input"
                id="<?= $container; ?>_username" 
            >
            <input type="hidden"
                id="<?= $container; ?>_userid" 
                :name="<?= $name ?>"
                :value="<?= $rawvalue ?>"
                class="bind-input"
                v-model="<?= $rawvalue ?>"
            >
        </div>
    </div>
    <script type="text/javascript">
        UIkit.util.on(document, 'itemshow', "#<?= $container ?>", function (element) {

            const iframe = document.getElementById("<?= $container ?>").querySelector('iframe');
            iframe.addEventListener("load", function() {
                const userNames   = this.contentWindow.document.getElementsByClassName("pointer");
                const noUserNames = this.contentWindow.document.getElementsByClassName("btn-primary button-select");
                noUserNames[0].addEventListener('click', function(eventObj) {

                    document.getElementById("<?= $container; ?>_username").value = '<?= Text::_('JLIB_FORM_SELECT_USER') ?>';
                    document.getElementById("<?= $container; ?>_userid").value = 0;

                    jQuery("#<?= $container; ?>_username")[0].dispatchEvent(new Event('input'));
                    jQuery("#<?= $container; ?>_userid")[0].dispatchEvent(new Event('input'));

                    UIkit.lightbox("#<?= $container; ?>_trigger").hide();

                });

                for (var i = 0; i < userNames.length; i++) {
                    userNames[i].addEventListener('click', function(eventObj) {

                        const userDataSet = eventObj.target.dataset;

                        document.getElementById("<?= $container; ?>_username").value = userDataSet.userName;
                        document.getElementById("<?= $container; ?>_userid").value = userDataSet.userValue;

                        jQuery("#<?= $container; ?>_username")[0].dispatchEvent(new Event('input'));
                        jQuery("#<?= $container; ?>_userid")[0].dispatchEvent(new Event('input'));

                        UIkit.lightbox("#<?= $container; ?>_trigger").hide();
                    });
                }
            });

        });

        // // Make VueJS Reactive
        // jQuery('.bind-input').on('change', function() {
        //     console.log($(this), 'changed');
        //     jQuery(this)[0].dispatchEvent(new Event('input'));
        // });
    </script>
