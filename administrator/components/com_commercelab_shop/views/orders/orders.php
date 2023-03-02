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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Factory;

/** @var array $vars */

?>


<div id="cls_orders" v-cloak class="uk-animation-fade">
    <div class="main-section">          

        <div class="center-section" uk-grid>
            <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
                <div class="uk-card uk-card-default">

                    <div class="uk-card-header">
                        <div class="uk-grid-small" uk-grid> <!-- ADD LINE -->
                            <div class="uk-margin-small-bottom uk-width-1-1@s uk-width-1-1@m uk-width-1-1@l uk-width-1-2@xl">
                                <h3 class="uk-flex">

                                    <span style="min-width: 20px">

                                        <svg v-show="!filterLoading" width="16px" aria-hidden="true" focusable="false" data-prefix="fal"
                                             data-icon="box-check" role="img" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 640 512" class="svg-inline--fa fa-box-check fa-w-16">
                                            <path _ngcontent-yfu-c67="" fill="currentColor"
                                                  d="M492.5 133.4L458.9 32.8C452.4 13.2 434.1 0 413.4 0H98.6c-20.7 0-39 13.2-45.5 32.8L2.5 184.6c-1.6 4.9-2.5 10-2.5 15.2V464c0 26.5 21.5 48 48 48h400c106 0 192-86 192-192 0-90.7-63-166.5-147.5-186.6zM272 32h141.4c6.9 0 13 4.4 15.2 10.9l28.5 85.5c-3-.1-6-.5-9.1-.5-56.8 0-107.7 24.8-142.8 64H272V32zM83.4 42.9C85.6 36.4 91.7 32 98.6 32H240v160H33.7L83.4 42.9zM48 480c-8.8 0-16-7.2-16-16V224h249.9c-16.4 28.3-25.9 61-25.9 96 0 66.8 34.2 125.6 86 160H48zm400 0c-88.2 0-160-71.8-160-160s71.8-160 160-160 160 71.8 160 160-71.8 160-160 160zm64.6-221.7c-3.1-3.1-8.1-3.1-11.2 0l-69.9 69.3-30.3-30.6c-3.1-3.1-8.1-3.1-11.2 0l-18.7 18.6c-3.1 3.1-3.1 8.1 0 11.2l54.4 54.9c3.1 3.1 8.1 3.1 11.2 0l94.2-93.5c3.1-3.1 3.1-8.1 0-11.2l-18.5-18.7z"></path>
                                        </svg>

                                        <span style=" width: 20px; height: 20px;" v-show="filterLoading" uk-spinner></span>
                                    </span> 

                                    &nbsp; <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS'); ?>
                                    &nbsp; <span class="uk-text-small" style="margin-top: 3px;" v-show="totalItems">(<span v-show="totalItems != filteredItems">{{filteredItems}}/</span>{{totalItems}})</span>

                                </h3>
                            </div>

                            <div class="uk-width-1-1@s uk-width-1-1@m uk-width-1-1@l uk-width-1-2@xl uk-text-right">
                                <div class="uk-grid uk-grid-small uk-flex-right" uk-grid="">    <!-- ADD LINE -->

                                    <div class="uk-width-expand">

                                        <div class="uk-grid-small uk-position-relative">
                                            <div class="uk-width-expand">
                                                <input
                                                    :value="searchText" 
                                                    @change="doTextSearch($event)"
                                                    type="text"
                                                    placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
                                            </div>
                                            <div class="search-close uk-position-absolute">
                                                <span style="width: 20px">
                                                    <span @click="cleartext" v-show="enteredText" style="cursor: pointer" uk-icon="icon: close"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="uk-width-1-3@s uk-width-1-3@m uk-width-1-4@l uk-width-1-3@xl">
                                        <select id="filterSelect" class="uk-select" v-model="selectedStatus" @change="filter" data-preSelectedStatus="<?= Factory::getApplication()->input->get('preFilter', 0)?>">
                                            <option value="0">
                                                -- <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_SELECT_A_STATUS'); ?> --
                                            </option>
                                            <option v-for="status in statuses" :value="status.id">
                                                {{status.title}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="uk-width-auto">
                                        <button class="uk-icon-button" :class="{ 'uk-button-primary': dateActive }" uk-icon="calendar"></button>
                                        <div id="ordersDateDrop" class="uk-width-xlarge" uk-drop="mode: click; pos: bottom-right; boundary: .boundary">
                                            <div class="uk-card uk-card-body uk-card-default">
                                                <div uk-grid>

                                                    <div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
                                                        <div class="uk-margin">
                                                            <label class="uk-form-label" for="date_from"><?= Text::_('COM_COMMERCELAB_SHOP_DATE_FROM'); ?></label>
                                                            <div class="uk-form-controls">
                                                                <input type="date" id="date_from" v-model="dateFrom" value="<?= HtmlHelper::date($vars['now'], 'Y-m-d'); ?>" min="2020-01-01">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
                                                        <div class="uk-margin">
                                                            <label class="uk-form-label" for="date_to"><?= Text::_('COM_COMMERCELAB_SHOP_DATE_TO'); ?></label>
                                                            <div class="uk-form-controls">
                                                                <input type="date" id="date_to" name="date_to" v-model="dateTo" value="<?= HtmlHelper::date($vars['now'], 'Y-m-d'); ?>" min="2020-01-01">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="uk-width-1-1">
                                                        <div class="uk-text-left">
                                                            <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS'); ?>:<br/>
                                                            <button type="button" class="uk-button uk-button-default uk-button-small" @click="setDateBand(7)">
                                                                <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS_7_DAYS'); ?>
                                                            </button>
                                                            <button type="button" class="uk-button uk-button-default uk-button-small uk-margin-small-left" @click="setDateBand(30)">
                                                                <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS_30_DAYS'); ?>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
                                                        <div class="uk-grid" uk-grid>
                                                            <div class="uk-width-expand">
                                                                <div class="uk-margin">
                                                                    <button class="uk-button uk-button-small uk-button-default" @click="clearDates">
                                                                        <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_CLEAR_SEARCH'); ?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="uk-width-auto">
                                                                <div class="uk-margin">
                                                                    <button class="uk-button uk-button-small uk-button-primary" @click="filter">
                                                                        <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-body uk-overflow-auto">

                        <table class="uk-table uk-table-striped uk-table-divider uk-table-hover uk-table-responsive  uk-table-middle">
                            <thead>
                                <tr>
                                    <th class="uk-text-left"></th>

                                    <th class="uk-text-left">
                                        <!-- <?= Text::_('COM_COMMERCELAB_SHOP_ORDER'); ?> -->
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_number'}"
                                            @click="sort('o.order_number')">
                                                <span uk-icon="icon: hashtag"></span>
                                                <span v-if="currentSort == 'o.order_number'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-left">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'c.name'}"
                                            @click="sort('c.name')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_TABLE_CUSTOMER'); ?>
                                                <span v-if="currentSort == 'c.name'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_status'}"
                                            @click="sort('o.order_status')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_TABLE_STATUS'); ?>
                                                <span v-if="currentSort == 'o.order_status'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.payment_method'}"
                                            @click="sort('o.payment_method')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_PAYMENT'); ?>
                                                <span v-if="currentSort == 'o.payment_method'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-left">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_date'}"
                                            @click="sort('o.order_date')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_TABLE_DATE'); ?>
                                                <span v-if="currentSort == 'o.order_date'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_paid'}"
                                            @click="sort('o.order_paid')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_TABLE_PAID'); ?>
                                                <span v-if="currentSort == 'o.order_paid'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>
                                    <th class="uk-text-left">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_total'}"
                                            @click="sort('o.order_total')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_TABLE_TOTAL'); ?>
                                                <span v-if="currentSort == 'o.order_total'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-left@m uk-text-nowrap"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="el-item uk-animation-fade uk-animation-fast" v-for="order in items">
                                    <td>
                                        <div><input v-model="selectedItems" :value="order.id" type="checkbox"></div>
                                    </td>
                                    <td class="uk-text-left uk-font-primary">
                                        <a :href="'index.php?option=com_commercelab_shop&view=order&id=' + order.id">
                                            {{order.order_number}}
                                        </a>
                                    </td>

                                    <td v-if="order.customer_name && order.customer_name != ''">
                                        {{ order.customer_name }}
                                    </td>

                                    <td v-else-if="order.billing_address !== null && order.billing_address.first_name && order.billing_address.first_name != ''">
                                        {{ order.billing_address.first_name }} {{ order.billing_address.last_name }} (Guest)
                                    </td>

                                    <td v-else-if="order.shipping_address !== null && order.shipping_address.first_name && order.shipping_address.first_name != ''">
                                        {{ order.shipping_address.first_name }} {{ order.shipping_address.last_name }} (Guest)
                                    </td>

                                    <td v-else>
                                        Guest
                                    </td>

                                    <td class="uk-text-center">
                                        <div :class="'uk-label uk-label-'+ order.order_status.toLowerCase()">
                                            {{order.order_status_formatted}}
                                        </div>
                                    </td>
                                    <td class="uk-text-center">
                                        <div>
                                            <img :src="order.payment_method_icon" />
                                        </div>
                                        <div>
                                            {{ order.payment_method }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="uk-font-primary">{{order.order_date}}</div>
                                    </td>
                                    <td class="uk-text-center">
                                            <!-- @click="togglePaid(order)" -->
                                        <span v-if="order.order_paid == '1'" style="font-size: 18px;">
                                            <i class="fas fa-check-circle uk-text-success"></i>
                                        </span>
                                        <span v-else style="font-size: 18px;">
                                            <i class="fas fa-times-circle uk-text-danger"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="uk-font-primary">{{order.order_total_formatted}}</div>
                                    </td>

                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <h5 v-show="items.length == 0 && selectedStatus == '0'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_EMPTY_TABLE'); ?></h5>
                        <h5 v-show="items.length == 0 && selectedStatus == 'P'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_P_EMPTY_TABLE'); ?></h5>
                        <h5 v-show="items.length == 0 && selectedStatus == 'C'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_C_EMPTY_TABLE'); ?></h5>
                        <h5 v-show="items.length == 0 && selectedStatus == 'X'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_X_EMPTY_TABLE'); ?></h5>
                        <h5 v-show="items.length == 0 && selectedStatus == 'R'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_R_EMPTY_TABLE'); ?></h5>
                        <h5 v-show="items.length == 0 && selectedStatus == 'S'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_S_EMPTY_TABLE'); ?></h5>
                        <h5 v-show="items.length == 0 && selectedStatus == 'F'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_F_EMPTY_TABLE'); ?></h5>
                        <h5 v-show="items.length == 0 && selectedStatus == 'D'"><?= Text::_('COM_COMMERCELAB_SHOP_ORDERS_D_EMPTY_TABLE'); ?></h5>

                        <a class="uk-text-small" @click="seeCallbackLogs()" href="javascript:void(0);">
                            <span v-if="callbackLoading" style="width: 20px; height: 20px;" uk-spinner></span>
                            See Callback Logs
                        </a>
                        <div id="callback_logs" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">

                                <button class="uk-modal-close-default" type="button" uk-close></button>

                                <div class="uk-width-1-1">
                                    <ul class="uk-list uk-list-divider">
                                        <li v-for="log in callbackLogs">
                                            {{ log }} 
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="uk-card-footer">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-expand">
                                <p class="uk-text-meta"></p>
                            </div>
                            <div class="uk-width-auto">
								<?= LayoutHelper::render('pagination'); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="right-bar">

            <div class="right-bar-inner">
                
                <div class="uk-card uk-card-default ">

                    <div class="uk-card-header">
                        <h4> <?= Text::_('COM_COMMERCELAB_SHOP_FILTERS'); ?></h4>
                    </div>
                    <div class="uk-card-body">
                        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>

                            <li>
                                <a class="uk-text-emphasis" @click="setDateBand(1)">
                                    <i class="uk-margin-small-right fas fa-calendar-day fa-2x"></i>
                                    <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS_TODAY'); ?>
                                </a>
                            </li>
                            <li>
                                <a class="uk-text-emphasis" @click="setDateBand(7)">
                                    <i class="uk-margin-small-right fas fa-calendar-week fa-2x"></i>
                                    <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS'); ?> <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS_7_DAYS'); ?>
                                </a>
                            </li>
                            <li>
                                <a class="uk-text-emphasis" @click="setDateBand(30)">
                                    <i class="uk-margin-small-right fas fa-calendar-alt fa-2x"></i>
                                    <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS'); ?> <?= Text::_('COM_COMMERCELAB_SHOP_PREVIOUS_30_DAYS'); ?>
                                </a>
                            </li>
                            <li class="uk-nav-divider"></li>
                            <li>
                                <a class="uk-text-emphasis" @click="clearSearch">
                                    <span class="uk-margin-small-right" uk-icon="icon: minus-circle"></span>
		                            <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_CLEAR_SEARCH'); ?>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="uk-card uk-card-default uk-margin-top">

                    <div class="uk-card-header">
                        <h4> <?= Text::_('Actions'); ?></h4>
                    </div>
                    <div class="uk-card-body">
                        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>

                            <li>
                                <a :class="{'uk-text-emphasis': selectedItems.length}" class="uk-text-muted" @click="trashSelected()">
                                    <span class="uk-margin-small-right" uk-icon="icon: trash; ratio 1.5"></span>
                                    <?= Text::_('Trash'); ?>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
            
        </div>

    </div>
</div>