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

    <div :id="<?= $container; ?> + '_wrapper'" class="controls user_subform">
        <div :uk-lightbox="'container: #' + <?= $container; ?>" data-type="iframe" :id="<?= $container; ?> + '_trigger'">
            <a :href="'<?= new Uri('index.php?option=com_users&view=users&layout=modal&tmpl=component&required=' . $required . '&field=' ) ?>' + <?= $container ?>" class="rise uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></a>
            <input placeholder="<?= Text::_('JLIB_FORM_SELECT_USER') ?>" disabled type="text" 
                :value="<?= $value ?>"
                v-model="<?= $value ?>"
                class="bind-input-subform"
                :id="<?= $container; ?> + '_username'" 
            >
            <input type="hidden"
                :id="<?= $container; ?> + '_userid'" 
                :name="<?= $name ?>"
                :value="<?= $rawvalue ?>"
                class="bind-input-subform"
                v-model="<?= $rawvalue ?>"
            >
        </div>
    </div>

    <div :id="<?= $container ?>"></div>