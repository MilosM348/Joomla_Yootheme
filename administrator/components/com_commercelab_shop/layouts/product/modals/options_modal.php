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

<div id="editProductOption" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_EDIT_PRODUCT_OPTION'); ?></h2>
        </div>
        <div class="uk-modal-body">
            <div>
                <div class="uk-margin">

                    <label> <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_OPTION_LABEL'); ?> <input
                                placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_OPTION_LABEL_PLACEHOLDER'); ?>"
                                class="uk-input" v-model="option_for_edit.optionname" />
                    </label>

                </div>
                <div class="uk-margin">

                    <label> <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER'); ?>
                        <select class="uk-select" v-model="option_for_edit.modifier">
                            <option value=""><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_SELECT'); ?></option>
                            <option value="add"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_ADD'); ?></option>
                            <option value="subtract"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_SUBTRACT'); ?></option>
                        </select>
                    </label>

                </div>
                <div class="uk-margin">

                    <label> <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE'); ?>
                        <select class="uk-select" v-model="option_for_edit.modifiertype" @change="processModifierValue(option_for_edit)">
                            <option value=""><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_SELECT'); ?></option>
                            <option value="perc"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_PERCENT'); ?></option>
                            <option value="amount"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_AMOUNT'); ?></option>
                        </select>
                    </label>

                </div>
                <div class="uk-margin">

                    <label> <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_VALUE'); ?>
                        <input
                                placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_VALUE_PLACEHOLDER'); ?>"
                                type="number"
                                class="uk-input"
                                v-model="option_for_edit.modifiervalueFloat"
                                @input="processModifierValue(option_for_edit)"
                                pattern="^[0-9]+(.[0-9]{1,2})?$"
                                />
                    </label>

                </div>
                <div class="uk-margin">

                    <label> <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_SKU'); ?>
                        <input placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_SKU_PLACEHOLDER'); ?>"
                                class="uk-input"
                                v-model="option_for_edit.optionsku"
                                />
                    </label>

                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-primary uk-margin-left  uk-modal-close" type="button"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_SAVE'); ?>
            </button>
        </div>
    </div>
</div>
