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
$order = $data['item'];

?>


<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
					<?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>
            <div class="uk-width-auto">
                <a href="#addnotemodal" uk-toggle
                   class="uk-button uk-button-small uk-button-primary"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_NEW_INTERNAL_NOTE'); ?></a>
            </div>

        </div>
    </div>

    <div class="uk-card-body">
        <div v-for="note in order.internal_notes">
            <article class="uk-comment uk-comment-primary uk-margin-small-top">
                <div class="uk-comment-header">
                    <div class="uk-grid-medium uk-flex-middle" uk-grid>
                        <div class="uk-width-1-4">
                            <p-avatar label="RL" shape="circle" size="large" style="background-color:#2196F3; color: #ffffff"></p-avatar>

                        </div>
                        <div class="uk-width-expand">
                            <h4 class="uk-comment-title uk-margin-remove">{{note.created_by_name}} </h4>
                            <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                <li>{{note.created}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-comment-body">
                    <p>{{note.note}}</p>
                </div>
            </article>
        </div>
    </div>


    <!-- <div class="uk-card-footer"></div> -->
</div>

<div id="addnotemodal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_NEW_INTERNAL_NOTE'); ?></h2>
        <p><textarea class="uk-textarea" rows="5"
                     :placeholder="'Add note for Order ' + order.order_number"
                     v-model="newNoteText"></textarea>
        </p>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button"
                    @click="clearNote()">Cancel
            </button>
            <button class="uk-button uk-button-primary uk-margin-left" type="button"
                    @click="saveNote()"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_BUTTON_SAVE'); ?>
            </button>
        </p>
    </div>
</div>
