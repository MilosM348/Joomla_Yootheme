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
				<?php if ($order->billing_address) : ?>
                    <div class="uk-width-auto">
                        <button @click="copyToClipboard('<?= $order->billing_address->address_as_csv; ?>')"
                                type="button" class="uk-icon-button" uk-icon="copy"
                                uk-tooltip="Copy Billing Address"></button>
                    </div>
				<?php endif; ?>
            </div>
        </div>

        <div class="uk-card-body">
	        <?php if ($order->billing_address) : ?>
            <table class="uk-table uk-table-striped uk-table-hover">
                <tbody>

                <tr>
                    <td class="uk-text-nowrap uk-table-shrink">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_FIRST_NAME'); ?>:</div>
                    </td>
                    <td>
                        <div id="shipping_address_first_name"><?= $order->billing_address->first_name; ?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="uk-text-nowrap uk-table-shrink">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_LAST_NAME'); ?>:</div>
                    </td>
                    <td>
                        <div id="shipping_address_last_name"><?= $order->billing_address->last_name; ?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_ADDRESSLINE1'); ?>:
                        </div>
                    </td>
                    <td>
                        <div id="shipping_address_address1"><?= $order->billing_address->address1; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_ADDRESSLINE2'); ?>:
                        </div>
                    </td>
                    <td>
                        <div id="shipping_address_address2"><?= $order->billing_address->address2; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_ADDRESSLINE3'); ?>:
                        </div>
                    </td>
                    <td>
                        <div id="shipping_address_address3"><?= $order->billing_address->address3; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_CITY'); ?>:</div>
                    </td>
                    <td>
                        <div id="shipping_address_town"><?= $order->billing_address->city; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_STATE'); ?>:</div>
                    </td>
                    <td>
                        <div><?= $order->billing_address->zone_name; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_COUNTRY'); ?>:</div>
                    </td>
                    <td>
                        <div id="shipping_address_country"><?= $order->billing_address->country_name; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_POSTCODE'); ?>:</div>
                    </td>
                    <td>
                        <div id="shipping_address_postcode"><?= $order->billing_address->postcode; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_PHONE'); ?>:</div>
                    </td>
                    <td>
                        <div id="shipping_address_phone"><?= $order->billing_address->phone; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_MOBILE_PHONE'); ?>:
                        </div>
                    </td>
                    <td>
                        <div id="shipping_address_mobile_phone"><?= $order->billing_address->mobile_phone; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-nowrap">
                        <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ADDRESS_DETAILS_EMAIL'); ?>:</div>
                    </td>
                    <td>
                        <div id="shipping_address_email"><?= $order->billing_address->email; ?></div>
                    </td>
                </tr>
                </tbody>
            </table>
	        <?php endif; ?>
        </div>


        <!-- <div class="uk-card-footer"></div> -->
    </div>

