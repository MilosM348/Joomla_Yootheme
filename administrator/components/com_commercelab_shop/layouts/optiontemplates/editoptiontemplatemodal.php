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
<div id="edit-modal-option-template-options" uk-modal>
    <div class="uk-modal-dialog"  >
        <form>
            <button class="uk-modal-close-default " type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_PRODUCT_VARIANTS'); ?></h2>
            </div>
            <div class="uk-modal-body">
                <div class="">


                    <!-- <div class="el-content uk-panel">
                        <div class="uk-margin" >
                            <label for="option-template-variant-name"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_PRODUCT_VARIANT_NAME'); ?></label>
                            <input   type="text" id="option-template-variant-name"
                                   name="option_template_variant_name" class="uk-input" v-model="option_name"
                                   placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_PRODUCT_VARIANT_PLACEHOLDER'); ?>">
                        </div>

                    </div> -->
                   
                    <div class=" uk-margin-small-bottom" v-for="(variant, index) in variants" :id="variant.id">
              
                <div class="uk-grid" uk-grid>
                    <div class="uk-width-1-1 uk-grid-item-match uk-flex-middle">


                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text"><?= Text::_('COM_COMMERCELAB_SHOP_PRODUCT_VARIANT_TYPE'); ?></label>
                            <div class="uk-form-controls">
                                <input v-model="variants[index].option_name" class="uk-input uk-form-large" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_PRODUCT_VARIANT_TYPE_PLACEHOLSER'); ?>" >
                            </div>
                        </div>

                    </div>
                    <div class="uk-width-1-1">


                        <div class="uk-margin">
                            
                            <label class="uk-form-label" for="form-stacked-text">
                                <?= Text::_('COM_COMMERCELAB_SHOP_PRODUCT_VARIANT_OPTIONS'); ?>        
                            </label>

                            <div class="uk-form-controls" >
                                <p-chips  v-model="variants[index].labels" @remove="itemId  ? removeLabel($event,index,itemId) : '' " @add="itemId  ? onUpdateNewLabel($event) : onAddNewLabel($event,index) "   :addOnBlur="true" :allowDuplicate="false" >
                                    <template #chip="slotProps" >
                                        {{slotProps.value}}
                                    </template>
                                </p-chips>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_CANCEL'); ?></button>
                <button :disabled='isDisabled' @click="itemId  ? updateTemplateOptions() : saveTemplateOptions() "  class="uk-button uk-button-primary uk-margin-small-left"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_SAVE'); ?></button>
            </div>
        </form>
    </div>
</div>