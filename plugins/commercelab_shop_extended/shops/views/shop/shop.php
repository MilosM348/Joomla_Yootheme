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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');
/** @var array $vars */
$item      = $vars['item'];
$products  = $vars['products'];
$form      = $vars['form'];
$builderLink  = $vars['builderLink'];
$default_category = $vars['default_category'];
$default_category_name = $vars['default_category_name'];
$category_parents_tree = $vars['category_parents_tree'];
?>

<div id="cls_shop">
    <!-- Overlay FOr Forced Saving and Reloading -->
    <div v-cloak v-if="main_loading" class="uk-text-center uk-overlay uk-width-1-1 uk-height-1-1 uk-position-absolute uk-position-top uk-position-left" style="background: rgb(255 255 255 / 90%); z-index: 100000000;">
        <span class="uk-display-block" style="margin-top: 200px;"  uk-icon="icon: server; ratio: 3"></span>
        <span class="uk-spinner uk-margin-rigth"  uk-icon="icon: refresh; ratio: 0.9"></span> <span class="h1"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_SAVING') ?></span></h1>
    </div>
    <!-- Item Form -->
    <form @submit.prevent="saveShop" class="uk-form">
        <div uk-grid>
            <div class="uk-width-1-1">
                <div>
                    <nav class="uk-navbar-container uk-flex-wrap uk-padding-small editing-save" 
                        uk-navbar 
                        uk-sticky="show-on-up: true; animation: uk-animation-slide-top; bottom: #bottom"
                        style="border-radius: 8px; z-index: 980;" 
                    >
                        <div uk-grid>
                            <div class="uk-width-expand@m">
	                            <span class="uk-navbar-item uk-logo" v-cloak>
	                                <span v-show="shop.id">
	                                	<span class="uk-display-block uk-text-small uk-text-muted">
	                                		<?= Text::_('COM_COMMERCELAB_SHOP_ADD_DISCOUNTS_MODAL_EDITING'); ?>
	                                	</span>
	                                	{{shop.title}}
	                                </span>
	                                <span v-show="!shop.id">
	                                	<span class="uk-display-block uk-text-small uk-text-muted">
	                                		<?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_TITLE'); ?>
	                                	</span>
	                                	{{shop.title}}
	                                </span>
	                            </span>
	                        </div>
                            <div class="uk-width-auto@m uk-text-right uk-flex uk-flex-middle">
                                <button type="submit" @click="andClose = false" class="uk-button uk-button-default button-success uk-button-small uk-margin-right">
                                    <?= Text::_('JTOOLBAR_APPLY'); ?>
                                </button>
                                <button type="submit" @click="andClose = true" class="uk-button uk-button-default button-success uk-button-small uk-margin-right">
                                    <?= Text::_('JTOOLBAR_SAVE'); ?>
                                </button>
                                <a class="uk-button uk-button-default uk-button-small uk-margin-right"
                                   href="index.php?option=com_commercelab_shop&view=shops"><?= Text::_('JTOOLBAR_CANCEL'); ?>
                                </a>
                                <button type="submit" @click="openBuilder = true" @click="openBuilder" id="openBuilderButton" data-url="<?= $builderLink; ?>" 
	                            	class="uk-button uk-button-default button-primary uk-button-small">
									<span uk-icon="icon: desktop"></span> <?= Text::_('COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON'); ?>
	                            </button>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="uk-grid-margin" uk-grid> 
            <div class="uk-width-expand@l">
                <div class="uk-card uk-card-default uk-padding-small" uk-grid>
                    <div class="uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
                        <div class="">
                            <div class="control-label">
                                <label class="uk-card-title">
                                    Location Name
                                    <span class="star uk-text-danger">&nbsp;*</span>
                                </label>
                            </div>
                            <div class="controls">
                                <input class="uk-input uk-form-small" v-model="shop.title" type="text" name="name" required="" id="jform_title">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
                        <div class="">
                            <div class="control-label">
                                <label class="uk-card-title">
                                    Location Image
                                    <span class="star uk-text-danger">&nbsp;*</span>
                                </label>
                            </div>
                            <div class="">
                                <div class="uk-margin-bottom uk-margin-remove-top">
                                    <?=
                                        LayoutHelper::render('product/media', array(
                                            'id'           => 'jform_image', 
                                            'model'        => 'form.' . 'jform_image',
                                            'thumb_height' => '250px',
                                            'idStringify'  => true,
                                        ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Address -->
                <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl uk-card uk-card-default uk-padding-small">
                    <div class="uk-margin-bottom">
                        <div class="">
                            <div class="control-label">
                                <label class="uk-card-title">
                                    Address
                                </label>
                            </div>
                            <div class="controls">
                                <input v-model="shop.address" class="input-small uk-input uk-form-width-medium uk-form-large" type="text" name="name" required id="jform_title">
                            </div>
                        </div>
                    </div>
                    <div class="uk-margin-bottom">
                        <div uk-grid>
                            <div class="uk-width-expand@m">
                                <div class="control-label">
                                    <label class="uk-card-title">
                                        City
                                    </label>
                                </div>
                                <div class="controls">
                                    <input v-model="shop.city" class="input-small uk-input uk-form-width-medium uk-form-large" type="text" name="name" required id="jform_title">
                                </div>
                            </div>
                            <div class="uk-width-small@m">
                                <div class="control-label">
                                    <label class="uk-card-title">
                                        ZIP
                                    </label>
                                </div>
                                <div class="controls">
                                    <input v-model="shop.postalcode" class="input-small uk-input uk-form-width-medium uk-form-large" type="text" name="name" required id="jform_title">
                                </div>
                            </div>
                            <div class="uk-width-1-4@m">
                                <div class="control-label">
                                    <label class="uk-card-title">
                                        Country
                                    </label>
                                </div>
                                <div class="controls">
                                    <select class="uk-select" v-model="shop.country">
                                        <?php foreach ($countries as $key => $country) : ?>
                                            <option value="<?= $country->id ?>"><?= $country->country_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="uk-width-1-4@m">
                                <div class="control-label">
                                    <label class="uk-card-title">
                                        State
                                    </label>
                                </div>
                                <div class="controls">
                                    <select class="uk-select" v-model="shop.zone">
                                        <option v-for="zone in zones" :value="zone.id">{{ zone.zone_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Header -->
                <!-- Time schedules -->
                <div id="time-schedules" class="uk-card uk-card-default uk-padding-small">
                    <div>
                        <div class="uk-flex uk-flex-right uk-text-right">
                            <div class="control-label uk-margin-right">
                                <label class="uk-card-title">
                                    <span class="uk-display-block">
                                        <span :class="{'uk-text-muted': !shop.enableordertime}">
                                            Orders
                                        </span>
                                        <input type="checkbox" v-model="shop.enableordertime" value="1" class="uk-checkbox uk-margin-small-left"> 
                                    </span>
                                </label>
                                <span :class="{'uk-text-muted': shop.enableordertime}" class="uk-display-block">Same as working hours</span>
                            </div>
                            <div class="control-label">
                                <label class="uk-card-title">
                                    <span class="uk-display-block">
                                        <span :class="{'uk-text-muted': !shop.enablepickup}">
                                            Pickup times
                                        </span>
                                        <input type="checkbox" v-model="shop.enablepickup" value="1" class="uk-checkbox uk-margin-small-left"> 
                                    </span>
                                </label>
                                <span :class="{'uk-text-muted': shop.enablepickup}" class="uk-display-block">Same as working hours</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="uk-width-1-1">
                        <div class="uk-list uk-list-divider uk-list-striped uk-margin-remove">
                            <?php foreach ($item->workinghours as $weekday_index => $day) : ?>  
                                <li>
                                    <div class="uk-grid-small uk-grid-divider" uk-grid>                                        
                                        <div class="uk-width-small">
                                            <h3>
                                                <label>
                                                    <input type="checkbox" v-model="shop.workinghours[<?= $weekday_index ?>]['workingday']" value="1" class="uk-checkbox"> 
                                                    <span uk-tooltip="Enable or Disable this week day" 
                                                        :style="{'opacity':((!shop.workinghours[<?= $weekday_index ?>]['workingday']) ? '0.5' : '1')}"
                                                    >
                                                        <?= $day['name'] ?>
                                                    </span>
                                                </label>
                                            </h3>
                                        </div>
                                        <div class="uk-width-expand">
                                            <div class="uk-grid-small uk-grid-divider" uk-grid
                                                v-if="shop.workinghours[<?= $weekday_index ?>]['workingday']"
                                            >
                                                <div class="uk-width-1-1">

                                                    <div class="uk-width-1-1">
                                                        <div class="uk-margin-small uk-text-bold">
                                                            Working hours
                                                            <span class="uk-text-small uk-text-normal uk-text-lowercase uk-margin-small-left">
                                                                <label>
                                                                    <input type="checkbox" 
                                                                        :disabled="!shop.workinghours[<?= $weekday_index ?>]['workingday']" 
                                                                        v-model="shop.workinghours[<?= $weekday_index ?>]['straight']" 
                                                                        value="1" class="uk-checkbox" name=""
                                                                    > 
                                                                    <span uk-tooltip="If this Shop has a working pause">
                                                                        Full time
                                                                    </span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-1-1">
                                                        <div class="uk-child-width-1-2 uk-grid-small" uk-grid
                                                            :class="{'uk-grid-divider': !shop.workinghours[<?= $weekday_index ?>]['straight']}"
                                                        >
                                                            <div>
                                                                <div class="uk-grid-small" uk-grid>
                                                                    <div :class="((!shop.workinghours[<?= $weekday_index ?>]['straight']) ? 'uk-width-1-2' : 'uk-width-1-1')">
                                                                        <div class="uk-text-meta uk-margin-small-left">
                                                                            Start
                                                                        </div>
                                                                        <input 
                                                                            required
                                                                            class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                            :disabled="!shop.workinghours[<?= $weekday_index ?>]['workingday']" 
                                                                            v-model="shop.workinghours[<?= $weekday_index ?>]['workinghours']['start1']" 
                                                                        >
                                                                    </div>
                                                                    <div class="uk-width-1-2" v-if="!shop.workinghours[<?= $weekday_index ?>]['straight']">
                                                                        <div class="uk-text-meta uk-width-1-1 uk-text-right uk-margin-small-right">
                                                                            End <span class="uk-margin-small-left"></span>
                                                                        </div>
                                                                        <input 
                                                                            required
                                                                            class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                            :disabled="!shop.workinghours[<?= $weekday_index ?>]['workingday']" 
                                                                            v-model="shop.workinghours[<?= $weekday_index ?>]['workinghours']['end1']" 
                                                                        >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="uk-grid-small" uk-grid>
                                                                    <div class="uk-width-1-2" v-if="!shop.workinghours[<?= $weekday_index ?>]['straight']">
                                                                        <div class="uk-text-meta uk-margin-small-left">
                                                                            Start
                                                                        </div>
                                                                        <input 
                                                                            required
                                                                            class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                            :disabled="!shop.workinghours[<?= $weekday_index ?>]['workingday']" 
                                                                            v-model="shop.workinghours[<?= $weekday_index ?>]['workinghours']['start2']" 
                                                                        >
                                                                    </div>
                                                                    <div :class="((!shop.workinghours[<?= $weekday_index ?>]['straight']) ? 'uk-width-1-2' : 'uk-width-1-1')">
                                                                        <div class="uk-text-meta uk-width-1-1 uk-margin-small-right"
                                                                            :class="((!shop.workinghours[<?= $weekday_index ?>]['straight']) ? 'uk-text-right' : 'uk-margin-small-left')"
                                                                        >
                                                                            End <span class="uk-margin-small-left"></span>
                                                                        </div>
                                                                        <input 
                                                                            required
                                                                            class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                            :disabled="!shop.workinghours[<?= $weekday_index ?>]['workingday']" 
                                                                            v-model="shop.workinghours[<?= $weekday_index ?>]['workinghours']['end2']" 
                                                                        >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="shop.enableordertime" class="uk-width-1-1">
                                                    <div class="uk-width-1-1">
                                                        <div class="uk-margin-small uk-text-bold">
                                                            <label>
                                                                <input type="checkbox" v-model="shop.ordertimes[<?= $weekday_index ?>]['workingday']" value="1" class="uk-checkbox">
                                                                <span uk-tooltip="Enable/Disable for this specific week day">
                                                                    Order hours
                                                                </span>
                                                            </label>
                                                            <span v-if="shop.ordertimes[<?= $weekday_index ?>]['workingday']" class="uk-text-small uk-text-normal uk-text-lowercase uk-margin-small-left">
                                                                <label>
                                                                    <input type="checkbox" 
                                                                        :disabled="!shop.ordertimes[<?= $weekday_index ?>]['workingday']" 
                                                                        v-model="shop.ordertimes[<?= $weekday_index ?>]['straight']" 
                                                                        value="1" class="uk-checkbox uk-margin-small-left" name=""
                                                                    > 
                                                                    <span uk-tooltip="If this Shop has a working pause">
                                                                        Full time
                                                                    </span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="uk-width-1-1" v-if="shop.ordertimes[<?= $weekday_index ?>]['workingday']">
                                                            <div class="uk-child-width-1-2 uk-grid-small" uk-grid
                                                                :class="{'uk-grid-divider': !shop.ordertimes[<?= $weekday_index ?>]['straight']}"
                                                            >
                                                                <div>
                                                                    <div class="uk-grid-small" uk-grid>
                                                                        <div :class="((!shop.ordertimes[<?= $weekday_index ?>]['straight']) ? 'uk-width-1-2' : 'uk-width-1-1')">
                                                                            <div class="uk-text-meta uk-margin-small-left">
                                                                                Start
                                                                            </div>
                                                                            <input 
                                                                                required
                                                                                class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                                :disabled="!shop.ordertimes[<?= $weekday_index ?>]['workingday']" 
                                                                                v-model="shop.ordertimes[<?= $weekday_index ?>]['workinghours']['start1']" 
                                                                            >
                                                                        </div>
                                                                        <div class="uk-width-1-2" v-if="!shop.ordertimes[<?= $weekday_index ?>]['straight']">
                                                                            <div class="uk-text-meta uk-width-1-1 uk-text-right uk-margin-small-right">
                                                                                End <span class="uk-margin-small-left"></span>
                                                                            </div>
                                                                            <input 
                                                                                required
                                                                                class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                                :disabled="!shop.ordertimes[<?= $weekday_index ?>]['workingday']" 
                                                                                v-model="shop.ordertimes[<?= $weekday_index ?>]['workinghours']['end1']" 
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="uk-grid-small" uk-grid>
                                                                        <div class="uk-width-1-2" v-if="!shop.ordertimes[<?= $weekday_index ?>]['straight']">
                                                                            <div class="uk-text-meta uk-margin-small-left">
                                                                                Start
                                                                            </div>
                                                                            <input 
                                                                                required
                                                                                class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                                :disabled="!shop.ordertimes[<?= $weekday_index ?>]['workingday']" 
                                                                                v-model="shop.ordertimes[<?= $weekday_index ?>]['workinghours']['start2']" 
                                                                            >
                                                                        </div>
                                                                        <div :class="((!shop.ordertimes[<?= $weekday_index ?>]['straight']) ? 'uk-width-1-2' : 'uk-width-1-1')">
                                                                            <div class="uk-text-meta uk-width-1-1 uk-margin-small-right"
                                                                                :class="((!shop.ordertimes[<?= $weekday_index ?>]['straight']) ? 'uk-text-right' : 'uk-margin-small-left')"
                                                                            >
                                                                                End <span class="uk-margin-small-left"></span>
                                                                            </div>
                                                                            <input 
                                                                                required
                                                                                class="uk-input uk-form-small" type="time" name="name" id="jform_title"
                                                                                :disabled="!shop.ordertimes[<?= $weekday_index ?>]['workingday']" 
                                                                                v-model="shop.ordertimes[<?= $weekday_index ?>]['workinghours']['end2']" 
                                                                            >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            <h4 class="uk-text-muted uk-margin-small">
                                                                Orders will NOT be processes on this week day
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="shop.enablepickup" class="uk-width-1-1">
                                                    <div class="uk-margin-small-bottom">
                                                        <span uk-tooltip="When will the customer be able to pickup the product" class="uk-text-bold">
                                                            Pickup timeslots
                                                            <a href="javascript:void(0);" uk-tooltip="Add timeslot" 
                                                                @click="shop.pickuptimes[<?= $weekday_index ?>].timeslots.push({'name': '','start': '','end': ''})" 
                                                                class="uk-margin-small-left"
                                                            >
                                                                <span uk-icon="icon: plus-circle"></span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="uk-grid-small uk-grid-divider" uk-grid>
                                                        <div v-for="(slot, index) in shop.pickuptimes[<?= $weekday_index ?>].timeslots" class="uk-animation-fast uk-animation-slide-top-small uk-width-1-4@m">

                                                            <div class="uk-inline uk-width-1-1">
                                                                <a class="uk-form-icon uk-form-icon-flip" uk-tooltip="Delete this Timeslot" href="javascript:void(0);" 
                                                                    @click="shop.pickuptimes[<?= $weekday_index ?>].timeslots.splice(index, 1);" 
                                                                    uk-icon="icon: trash"
                                                                    style="top: 0px !important;"
                                                                ></a>
                                                                <input type="text" placeholder="Timeslot Name" class="uk-input uk-form-small" v-model="slot.name">
                                                            </div>
                                                            <div class="uk-width-1-1 uk-margin-small-top">
                                                                <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                                                    <div>
                                                                        <input required v-model="slot.start" class="uk-input uk-form-small" type="time" name="name" id="jform_title">
                                                                    </div>
                                                                    <div>
                                                                        <input required v-model="slot.end" class="uk-input uk-form-small" type="time" name="name" id="jform_title">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="uk-text-center uk-width-1-1 uk-flex uk-flex-middle uk-flex-center">
                                                <h2 class="uk-text-muted uk-margin-top">
                                                    Closed
                                                </h2>
                                            </div>
                                        </div>
                                    </div>                                
                                </li>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Products -->
            <div class="right-bar">
                <div class="right-bar-inner">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            <h3><?= Text::_('Products'); ?></h3>
                        </div>
                        <div class="uk-card-body">
                            <ul class="uk-list uk-list-divider uk-margin-remove">
                                <?php foreach ($products['items'] as $index => $product) : ?>
                                <li>
                                    <label>
                                        <input type="checkbox" class="uk-checkbox" value="<?= $product->joomla_item_id ?>" v-model="shop.products">
                                        <span class="uk-margin-small-left">
                                            <?= $product->title ?>
                                        </span>
                                    </label>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    const cls_shop = {
        data() {
            return {
                shop: <?= json_encode($item) ?>,
                zones: <?= json_encode($zones) ?>,
                
                loading: false,
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
                task_url: Joomla_cls.uri_base + 'index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&format=raw',
                andClose: false,
                form: {
                    jform_catid: '',
                    jform_access: '1',
                    jform_featured: false,
                    jform_taxclass: 'taxrate',
                    jform_publish_up_date: '',
                    jform_image: <?= json_encode($item->imagePath) ?>,
                    jform_category: <?= json_encode($default_category) ?>,
                },
                category_parents_tree: <?= json_encode($category_parents_tree)?>,
                openBuilder: false,
                base_url: '',
            }

        },
        computed: {
            timesets() {
                return (((this.shop.enablepickup + this.shop.enableordertime) + 1) == 2) ? 3 : 1;
            }
        },
        mounted() {
            
        },
        async beforeMount() {
            // TODO - I think we do not need ALL this, or at least it can be minified
            const base_url = document.getElementById('base_url');
            if (base_url != null) {
                try {
                    this.base_url = base_url.innerText;
                    base_url.remove();
                } catch (err) {
                }
            }
        },
        methods: {
            // addPickupTimeSlot(drop) {
            //     drop.push(JSON.parse(JSON.stringify(this.new_slot)));
            // },
            hideDropdown(drop) {
                UIkit.dropdown(drop).hide();
            },
            showDropdown(drop) {
                UIkit.dropdown(drop).show();
            },
            async makeACall(params, url) {

                const send = JSON.parse(JSON.stringify(this.ajax_headers));
                send.body  = JSON.stringify(params);

                const request  = await fetch(this.task_url + url, send);
                const response = await request.json();

                if (response.success)
                {
                    return response.data;
                }
                else
                {
                    UIkit.notification({
                        message: response.message,
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });

                    return false;
                }
            },
            isRemotePath(model) {

                let url;

                try {

                    url = new URL(model);

                } catch (_) {

                    return false;  
                }

                return url.protocol === "http:" || url.protocol === "https:";

            },
            async saveShop() {

                const params = {
                    ...this.shop,
                    'itemid': this.shop.joomla_item_id,
                    'category': this.form.jform_category,
                    'access': this.form.jform_access,
                    'featured': this.form.jform_featured
                };
                params.image = this.form.jform_image;
                const response = await this.makeACall(params, '&type=shop.save');
                if (response)
                {
                    UIkit.notification({
                        message: 'Shop saved',
                        status: 'success',
                        pos: 'top-center',
                        timeout: 5000
                    });
                    if (this.andClose) {
                        window.location.href = 'index.php?option=com_commercelab_shop&view=shops';
                    }
                    else {
                        this.shop.id = response.joomlaItem.id;
                        const url = window.location.href;
                        if (url.indexOf('&id=') == -1) {
                            history.replaceState('', '', url + '&id=' + this.shop.id);
                        }
                    }
                    if (this.openBuilder) {
                        const joomlaItem        = response.joomlaItem;
                        const builderRooute     = document.getElementById("openBuilderButton").dataset.url;
                        const joomla_live_link  = this.base_url + 'index.php?view=article&id=' + joomlaItem.id + '&catid=' + joomlaItem.catid;
                        const encodedJoomlaLink = encodeURIComponent(joomla_live_link.replace('administrator/', ''));
                        const url               = this.base_url + builderRooute.replace('SHOP_ID', joomlaItem.id).replace('JOOMLA_LINK', encodedJoomlaLink);

                        window.location.href = url;

                    }
                }
            },
            async getCategoryParentsTree(cat_id) {

                // return;
                const params = {
                    'cat_id': cat_id
                };

                const response = await this.makeACall(params , '&type=shop.getcategoryparentstree');

                if (response)
                {
                    return response;

                } else {
                    return [];
                }

            },
            async shopCategory(id, title) {
                this.form.jform_category = id;
                this.shopCategoryName = title;

                this.category_parents_tree = await this.getCategoryParentsTree(id);
                UIkit.lightbox('#edit-category-selector').hide();
            },
        }
    }
    Vue.createApp(cls_shop).mount('#cls_shop');
</script>