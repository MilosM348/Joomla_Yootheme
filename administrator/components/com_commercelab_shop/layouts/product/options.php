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
use Joomla\CMS\Layout\LayoutHelper;

$data = $displayData;

?>

<div v-for="(option, index) in form.jform_options">
    <div class="uk-grid uk-grid-small uk-margin-small-bottom" uk-grid="" v-if="!option.delete">
        <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-3@m uk-width-1-3@l uk-width-1-3@xl">
            <input class="uk-input" type="text" v-model="option.option_name"
                   placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_NAME_PLACEHOLDER'); ?>">
        </div>
        <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-3@m uk-width-1-3@l uk-width-1-3@xl">
            <select class="uk-select" v-model="option.modifier_type">
                <option value="amount"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_AMOUNT'); ?></option>
                <option value="perc"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_OPTION_MODIFIER_TYPE_PERCENT'); ?></option>
            </select>
        </div>
        <div class="uk-width-1-1 uk-width-1-3@s uk-width-1-3@m uk-width-1-3@l uk-width-1-3@xl">

            <div class="uk-grid" uk-grid="">
                <div class="uk-width-expand">
                    <p-inputnumber v-if="option.modifier_type == 'amount'" mode="currency" :currency="p2s_currency.iso" :step="0.01"
                                   :locale="p2s_locale" v-model="option.modifier_valueFloat"></p-inputnumber>
                    <p-inputnumber v-if="option.modifier_type == 'perc'"
                                   v-model="option.modifier_valueFloat" locale="en-US" suffix="%" :step="0.05" :min="0.00" :max="100.00" format="false" buttonLayout="stacked"></p-inputnumber>
                </div>
                <div class="uk-width-auto">
                    <ul class="uk-iconnav">
                        <li>
                            <button uk-icon="icon: trash" type="button" @click="removeOption(option)"></button>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>



