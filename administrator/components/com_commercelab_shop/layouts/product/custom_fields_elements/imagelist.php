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
use Joomla\CMS\HTML\HTMLHelper;

/** @var array $displayData */
$data      = $displayData;
// $field     = $data['field']; // Joomla Custom Field ID

$isSubField = $data['isSubField'];
$model      = $data['model']; // Index of field, depends of order set in Joomla Custom Fields
$name       = $data['name'];
$options    = $data['options'];
$multiple   = $data['multiple'];
$directory  = $data['directory'];

?>

    <div class="uk-grid-small uk-child-width-1-<?= ($isSubField) ? '3' : '5' ?> uk-grid-match uk-grid-small uk-text-center" uk-grid>

        <div v-for="(option, key) in <?= $options ?>">


            <div class="uk-inline-clip uk-transition-toggle" tabindex="0"
                    :class="[(<?= $model ?>.includes(option)) ? 'uk-active uk-transition-active' : '']"
                >

                <div 
                    class="uk-background-cover uk-height-medium uk-flex uk-flex-center uk-float-middle" 
                    :style="{'background-image':'url(\'<?= \Joomla\CMS\Uri\Uri::root(); ?>' + <?= $directory ?> +  option + '\')', 'width': '100%', 'height': '<?= (!$isSubField) ? '100px' : '75px' ?>', 'background-position': 'center center', 'opacity': '50%'}"
                ></div>

                <div class="uk-padding-remove uk-transition-fade uk-transition-fast uk-position-cover uk-overlay uk-overlay-default uk-flex uk-flex-center uk-flex-middle">
                    <label class="uk-width-1-1 uk-height-1-1" :title="option">
                        <input 
                            class="uk-position-absolute uk-position-left uk-position-top uk-margin-small-top uk-margin-small-left" 
                            type="checkbox" 
                            :value="option" 
                            @change="(!<?= $multiple ?>) ? <?= $model ?> = [option] : null" 
                            v-model="<?= $model ?>"
                        >
                         <div 
                            class="uk-background-cover uk-height-medium uk-flex uk-flex-center uk-float-middle" 
                            :style="{'background-image':'url(\'<?= \Joomla\CMS\Uri\Uri::root(); ?>' +  <?= $directory ?> +  option + '\')', 'width': '100%', 'height': '<?= (!$isSubField) ? '100px' : '75px' ?>', 'background-position': 'center center', 'opacity': '100%'}"
                        ></div>
                    </label>

                </div>
            </div>
        </div>

    </div>
