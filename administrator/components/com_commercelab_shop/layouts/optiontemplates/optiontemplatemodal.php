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
<div id="modal-option-template" uk-modal>
    <div class="uk-modal-dialog">
        <form>
            <button class="uk-modal-close-default " type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_TITLE'); ?></h2>
            </div>
            <div class="uk-modal-body">
                <div class="">


                    <div class="el-content uk-panel">
                       
                        <div class="uk-margin" v-if="isShow=='variant_option'">
                            <label for="option-template-variant-name"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_PRODUCT_VARIANT_NAME'); ?></label>
                            <input   type="text" id="option-template-variant-name"
                                   name="option_template_variant_name" class="uk-input" v-model="template_name"
                                  >
                        </div>
                        <!-- <div class="uk-margin" v-if="isShow=='variant_option'">
                            <label for="option-template-variant-name"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_PRODUCT_VARIANT_PRICE'); ?></label>
                            <input   type="text" id="option-template-variant-name"
                                   name="option_template_variant_name" class="uk-input" v-model="option_variant_price"
                                   >
                        </div>
                        <div class="uk-margin" v-if="isShow=='variant_option'">
                            <label for="option-template-variant-name"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_PRODUCT_VARIANT_STOCK'); ?></label>
                            <input   type="text" id="option-template-variant-name"
                                   name="option_template_variant_name" class="uk-input" v-model="option_variant_stock"
                                   >
                        </div> -->
                        <div class="uk-margin" v-if="isShow=='checkbox_option'">
                            <label for="option-template-variant-name"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_PRODUCT_VARIANT_NAME'); ?></label>
                            <input type="text" id="option-template-variant-name" name="option_template_variant_name" class="uk-input" v-model="template_name"
                                   >
                        </div>

                        <div v-if="isShow=='checkbox_option'">
                                <div class="uk-margin" v-if="isShow=='checkbox_option'">
                                <label for="option-template-variant-name"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE'); ?></label>
                                    <select class="uk-select" v-model="optionscheckbox.modifier_type">
                                        <option value="amount" selected><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_AMOUNT'); ?></option>
                                        <option value="perc"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_PERCENT'); ?></option>
                                    </select>
                                </div>

                                <div class="uk-margin" v-if="isShow=='checkbox_option'">
                                    <p-inputnumber v-if="optionscheckbox.modifier_type == 'amount'" mode="currency" :currency="p2s_currency.iso" :step="0.01"
                                        :locale="p2s_locale" v-model="optionscheckbox.modifier_valueFloat"></p-inputnumber>
                                    <p-inputnumber v-if="optionscheckbox.modifier_type == 'perc'"
                                        v-model="optionscheckbox.modifier_valueFloat" locale="en-US" suffix="%" :step="0.05" :min="0.00" :max="100.00" format="false" buttonLayout="stacked"></p-inputnumber>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_CANCEL'); ?></button>
                <button @click="itemId  ? updateVariantTemplate() : saveVariantTemplate()"  class="uk-button uk-button-primary uk-margin-small-left"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_SAVE'); ?></button>
            </div>
        </form>
    </div>
</div>