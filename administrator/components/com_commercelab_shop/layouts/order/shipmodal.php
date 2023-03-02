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


<div id="shipmodal" uk-modal>
    <div class="uk-modal-dialog">
        <form>
            <button class="uk-modal-close-default " type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_UPDATE_ORDER'); ?></h2>
            </div>
            <div class="uk-modal-body">
                <div class="">


                    <div class="el-content uk-panel">
                        <div class="uk-margin">
                            <div class="uk-grid" uk-grid="">
                                <div class="uk-width-auto">
                                    <p-inputswitch v-model="emailTrackingActive"></p-inputswitch>
                                </div>
                                <div class="uk-width-expand"><span class=""> Send Tracking Email on save?</span>
                                </div>
                            </div>
                        </div>
                        <div class="uk-margin">
                            <label for="trackingcode"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_TRACKING_CODE'); ?></label>
                            <input  v-model="order.tracking_code" type="text" id="trackingcode"
                                   name="trackingcode" class="uk-input"
                                   placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_ORDER_TRACKING_CODE'); ?>">
                        </div>
                        <div class="uk-margin">
                            <label for="trackingcodeprovider"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_SHIPPING_PROVIDER'); ?></label>
                            <select v-model="order.tracking_provider"
                                    id="trackingcodeprovider" class="uk-select" name="trackingcodeprovider">
                                <option value="" disabled
                                        selected><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_SHIPPING_PROVIDER_SELECT_DEFAULT'); ?></option>
                                <option value="dhl">DHL</option>
                                <option value="fedex">FEDEX</option>
                                <option value="ups">UPS</option>
                                <option value="usps">USPS</option>
                                <option value="royalmail">Royal Mail</option>
                                <option value="custom">Custom URL</option>
                            </select>
                        </div>
                        <div class="uk-margin">
                            <label for="trackingcodeurl"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_FULL_TRACKING_URL'); ?></label>

                            <input type="text"

                                   v-model="order.tracking_link"
                                   name="trackingcodeurl" id="trackingcodeurl" class="uk-input"
                                   placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_ORDER_FULL_TRACKING_URL_PLACEHOLDER'); ?>">
                        </div>

                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_BUTTON_CANCEL'); ?></button>
                <button @click="saveTracking" class="uk-button uk-button-primary uk-margin-small-left"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_BUTTON_SAVE'); ?></button>
            </div>
        </form>
    </div>
</div>
