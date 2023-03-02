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



?>

<div id="addOptionTypeModal" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_OPTIONS_ADD_PRODUCT_OPTION_TYPE'); ?></h2>
        </div>
        <div class="uk-modal-body">

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_MODAL_NAME'); ?></label>
                <div class="uk-form-controls">
                    <input v-model="newOptionTypeName" class="uk-input" id="form-stacked-text" type="text" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_MODAL_NAME'); ?>">
                    <span class="uk-text-meta uk-text-warning" v-show="showNewOptionTypeNameWarning">Name Required</span>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_MODAL_OPTION_TYPE_SELECT_DEFAULT'); ?></label>
                <div class="uk-form-controls">
                    <select v-model="newOptionTypeType"  class="uk-select" id="form-stacked-select">
                        <option value="Dropdown"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_MODAL_OPTION_TYPE_DROPDOWN'); ?></option>
                        <option value="Radio"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_MODAL_OPTION_TYPE_RADIO'); ?></option>
                        <option value="Checkbox"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_MODAL_OPTION_TYPE_CHECKBOX'); ?></option>

                    </select>
                </div>
            </div>

        </div>
        <div class="uk-modal-footer uk-text-right">
            <button @click="saveNewOptionType" class="uk-button uk-button-primary uk-margin-left" type="button"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_MODAL_SAVE'); ?>
            </button>
        </div>
    </div>
</div>

