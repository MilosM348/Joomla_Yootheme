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
<div id="modal-option-template-checkbox-list" uk-modal >
    <div class="uk-modal-dialog">
    
        <form>
            <button class="uk-modal-close-default " type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title "><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_TITLE'); ?></h2>
            </div>
           
            <div class="uk-modal-body">
                <div v-if="!optionCheckboxtemplates.length" class="uk-text-center"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_EMPTY'); ?></div>
                    <div class="">
                    <table class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-middle" >
                        <thead>
                        <tr>
                            <th ></th>
                            <th ><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATE_NAME'); ?></th>
                        
                        </tr>
                        </thead>
                        <tbody>
                           
                        <tr v-for="(item, index) in optionCheckboxtemplates" >
                            <td>
                            <input v-model="selected" :value="item" type="checkbox">
                            </td>
                            <td class="">
                                {{item.name}} 
                            </td>
                            
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close"
                            type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_CANCEL'); ?></button>
                    <button @click="setSelectedOptionTemplateCheckbox"  class="uk-button uk-button-primary uk-margin-small-left"
                            type="button"><?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_SAVE'); ?></button>
                </div>
        </form>
    </div>
</div>