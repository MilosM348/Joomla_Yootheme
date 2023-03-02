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

$data  = $displayData;
$order = $data['items'];

?>
<div id="modal-option-template-values" uk-modal>
    <div class="uk-modal-dialog">
        <form>
            <button class="uk-modal-close-default " type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_VALUES_TITLE'); ?></h2>
            </div>
            <div class="uk-modal-body">
                <div class="">


                    <div class="el-content uk-panel">
                        <div class="uk-margin" >
                            <label for="option-template-option-value"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_VALUES_TITLE'); ?><span>*</span></label>
                            <input   type="text" id="option-template-option-value"
                                   name="option_template_variant_name" class="uk-input" v-model="option_value" >
                        </div>

                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_CANCEL'); ?></button>
                <button @click="itemId  ? updateOptionTemplateValue() : saveOptionTemplateValue()"  :disabled='isDisabled' class="uk-button uk-button-primary uk-margin-small-left"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_SAVE'); ?></button>
            </div>
        </form>
    </div>
</div>