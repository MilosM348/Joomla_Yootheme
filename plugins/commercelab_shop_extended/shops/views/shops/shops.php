<?php
/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Layout\LayoutHelper;

/** @var array $vars */
$items = $vars['items'];
?>
<div id="cls_shops">

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

                                    &nbsp; <?= Text::_('COM_COMMERCELAB_SHOP_STORE_LOCATIONS'); ?>
                                    &nbsp; <span class="uk-text-small" style="margin-top: 3px;" v-show="totalItems">(<span v-show="totalItems != filteredItems">{{filteredItems}}/</span>{{totalItems}})</span>

                                </h3>
                            </div>

                            <div class="uk-width-1-1@s uk-width-1-1@m uk-width-1-1@l uk-width-1-2@xl uk-text-right">
                                <div class="uk-grid-small uk-flex uk-flex-right" uk-grid>

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
                                                                <!-- <input type="date" id="date_from" v-model="dateFrom" value="<?= HtmlHelper::date($vars['now'], 'Y-m-d'); ?>" min="2020-01-01"> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
                                                        <div class="uk-margin">
                                                            <label class="uk-form-label" for="date_to"><?= Text::_('COM_COMMERCELAB_SHOP_DATE_TO'); ?></label>
                                                            <div class="uk-form-controls">
                                                                <!-- <input type="date" id="date_to" name="date_to" v-model="dateTo" value="<?= HtmlHelper::date($vars['now'], 'Y-m-d'); ?>" min="2020-01-01"> -->
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
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'c.name'}"
                                            @click="sort('c.name')"
                                        >
                                            Name
                                            <span v-if="currentSort == 'c.name'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.payment_method'}"
                                            @click="sort('o.payment_method')"
                                        >
                                            Store Image
                                            <span v-if="currentSort == 'o.payment_method'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.payment_method'}"
                                            @click="sort('o.payment_method')"
                                        >
                                            Store Address
                                            <span v-if="currentSort == 'o.payment_method'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>

                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_paid'}"
                                            @click="sort('o.order_paid')"
                                        >
                                            Opening Hours
                                            <span v-if="currentSort == 'o.order_paid'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>
                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_paid'}"
                                            @click="sort('o.order_paid')"
                                        >
                                            Pickup timeslots
                                            <span v-if="currentSort == 'o.order_paid'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>
                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_paid'}"
                                            @click="sort('o.order_paid')"
                                        >
                                            Selected Products
                                            <span v-if="currentSort == 'o.order_paid'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>
                                    
                                    <th class="uk-text-center">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_status'}"
                                            @click="sort('o.order_status')"
                                        >
                                            Published
                                            <span v-if="currentSort == 'o.order_status'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th>
                                    <!-- <th class="uk-text-left">
                                        <a href="javascript:void(0);" 
                                            :class="{'uk-text-bolder': currentSort == 'o.order_total'}"
                                            @click="sort('o.order_total')"
                                        >
                                            Order Hours
                                            <span v-if="currentSort == 'o.order_total'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                        </a>
                                    </th> -->

                                    <th class="uk-text-left@m uk-text-nowrap"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="el-item uk-animation-fade uk-animation-fast" v-for="shop in items">
                                    <td>
                                        <div><input v-model="selectedItems" :value="shop.id" type="checkbox"></div>
                                    </td>
                                    <td class="uk-text-left uk-font-primary">
                                        <a :href="'index.php?option=com_commercelab_shop&extended=shops&view=shop&id=' + shop.joomla_item_id">
                                            {{ shop.title }}
                                        </a>
                                    </td>
                                    <td class="uk-text-left uk-font-primary">
                                        <div
                                            class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
                                            :style="{'background-image':'url(\'' + shop.image + '\')', 'width': '80px', 'height': '80px'}"
                                        ></div>
                                    </td>
                                    <td class="uk-text-center">
                                        {{ shop.address }}, {{ shop.city }}, {{ shop.postalcode }}, {{ shop.country }}
                                    </td>
                                    <td class="uk-text-center">
                                        <a href="javascript:void(0);" :uk-toggle="'target: #workinghours_' + shop.id" type="button">
                                            See Hours 
                                        </a>
                                        <div :id="'workinghours_' + shop.id" uk-modal style="z-index: 9999;">
                                            <div class="uk-modal-dialog uk-modal-body">
                                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                                <ul class="uk-list uk-list-divider uk-margin-remove">
                                                    <li v-for="day in shop.workinghours" :class="{'uk-text-muted': day.workingday != '1'}">
                                                        <span class="uk-display-block">
                                                            {{ day.name }}
                                                        </span>
                                                        <span class="uk-text-small uk-display-block" v-if="day.straight">
                                                            {{ day.workinghours.start1 }} - {{ day.workinghours.end2 }}
                                                        </span>
                                                        <span v-else class="uk-text-small uk-display-block">
                                                            {{ day.workinghours.start1 }} - {{ day.workinghours.end1 }} | {{ day.workinghours.start2 }} - {{ day.workinghours.end2 }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="uk-text-center">
                                        <a href="javascript:void(0);" :uk-toggle="'target: #pickup_' + shop.id" type="button">
                                            See timeslots 
                                        </a>
                                        <div :id="'pickup_' + shop.id" uk-modal style="z-index: 9999;">
                                            <div class="uk-modal-dialog uk-modal-body">
                                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                                <ul class="uk-list uk-list-divider uk-margin-remove">
                                                    <li v-for="day in shop.pickuptimes" :class="{'uk-text-muted': day.workingday != '1'}">
                                                        <span class="uk-display-block">
                                                            {{ day.name }}
                                                        </span>
                                                        <div uk-grid>
                                                            <div class="uk-float-left" v-for="slot in day.timeslots">
                                                                <a href="javascript:void(0);" class="uk-button uk-button-default">
                                                                    {{ slot.name }}: {{ slot.start }} - {{ slot.end }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="uk-text-center">
                                        <a href="javascript:void(0);" :uk-toggle="'target: #product_' + shop.id" type="button">
                                            See Seleted Products
                                        </a>
                                        <div :id="'product_' + shop.id" uk-modal style="z-index: 9999;">
                                            <div class="uk-modal-dialog uk-modal-body">
                                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                                <ul class="uk-list uk-list-divider uk-margin-remove">
                                                    <li v-for="product in shop.products" :class="uk-text-muted">
                                                        <span class="uk-display-block">
                                                            {{ product.title }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="uk-text-center"  >
                                        <span v-if="shop.published == '1'" style="font-size: 18px;">
                                            <i class="fas fa-check-circle uk-text-success"></i>
                                        </span>
                                        <span v-else style="font-size: 18px;">
                                            <i class="fas fa-times-circle uk-text-danger"></i>
                                        </span>
                                    </td>
                                    <!-- <td>
                                        <span v-if="!shop.enableordertime">
                                            Same as Pickup
                                        </span>
                                        <ul v-else class="uk-list uk-list-divider">
                                            <li v-for="day in shop.ordertimes" :class="{'uk-text-muted': day.workingday != '1'}">

                                                <span class="uk-display-block">
                                                    {{ day.name }}
                                                </span>
                                                <span class="uk-text-small uk-display-block" v-if="day.straight">
                                                    {{ day.workinghours.start1 }} - {{ day.workinghours.end2 }}
                                                </span>
                                                <span v-else class="uk-text-small uk-display-block">
                                                    {{ day.workinghours.start1 }} - {{ day.workinghours.end1 }} | {{ day.workinghours.start2 }} - {{ day.workinghours.end2 }}
                                                </span>
                                                
                                            </li>
                                        </ul>
                                    </td> -->
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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
                        <h4> <?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS'); ?></h4>
                    </div>
                    <div class="uk-card-body">

                        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>

                            <li>
                                <a class="uk-text-emphasis" href="index.php?option=com_commercelab_shop&extended=shops&view=shop">
                                    <span class="uk-margin-small-right" uk-icon="icon: plus-circle"></span>
                                    <?= Text::_('COM_COMMERCELAB_SHOP_ADD_STORE_LOCATION_TITLE'); ?>
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

<script>
    const cls_shops = {
        data() {
            return {
                items: <?= json_encode($items); ?>,
                form: {
                    orders: 0,
                    customers: 0,
                    products: 0,
                    category: 0
                },
                loading: false,
                finishedImport: false,
                selectedType: 'products',
                productFile: '',
                importedItems: 0,
                itemsToImport: [],
                selectedItems: [],
                onStartItemsToImport: [],
                ajax_headers: {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-Token': Joomla_cls.token,
                        'Content-Type': 'application/json'
                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer'
                },
                task_url: Joomla_cls.uri_base + 'index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&format=raw'

            }

        },
        mounted() {
            console.log(this.items)
        },

    };

    Vue.createApp(cls_shops).mount('#cls_shops');


</script>

