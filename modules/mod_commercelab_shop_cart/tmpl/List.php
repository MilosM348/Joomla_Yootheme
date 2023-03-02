<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

/** @var $checkoutLink */
/** @var $count */
/** @var $total */
/** @var $cartItems */
/** @var $locale */
/** @var $currency */
/** @var $params */

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$card_items_header_count = [];

if ($params->get('items_show_image')) {
    $card_items_header_count[] = 'image';
}

if ($params->get('items_show_title')) {
    $card_items_header_count[] = 'title';
}

if ($params->get('items_show_quantity')) {
    $card_items_header_count[] = 'quantity';
}

if ($params->get('items_show_price_per_quantity')) {
    $card_items_header_count[] = 'price';
}

if ($params->get('items_show_remove_product_button')) {
    $card_items_header_count[] = 'remove';
}

?>



<div class="uk-card-header">
    <div class="uk-child-width-1-<?= count($card_items_header_count); ?> <?= $params->get('items_spacing'); ?>" uk-grid>
        
        <?php if ($params->get('items_show_image')) : ?>
        <!-- Image Empty Header -->
        <div>&nbsp;</div>
        <?php endif; ?>

        <?php if ($params->get('items_show_title')) : ?>
        <!-- Title Header -->
        <div>
            <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_PRODUCT'); ?>
        </div>
        <?php endif; ?>

        <?php if ($params->get('items_show_quantity')) : ?>
        <!-- Quantity Header -->
        <div>
            <?= Text::_('QUANTITY'); ?>
        </div>
        <?php endif; ?>

        <?php if ($params->get('items_show_price_per_quantity')) : ?>
        <!-- Price Header -->
        <div>
            <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_TOTAL'); ?>
        </div>
        <?php endif; ?>

        <?php if ($params->get('items_show_remove_product_button')) : ?>
        <!-- Remove Item Empty Header -->
            <div>&nbsp;</div>
        <?php endif; ?>

        <!-- Close Cart -->
        <!-- <a id="close-cart-<?= $id ?>" @click="closeCart()" href="javascript:void(0);" uk-icon="icon: close"></a> -->

    </div>
</div>

<div id="yps-iconcart-tablebody" class="uk-card-body">

    <div v-for="item in cartItems" class="uk-child-width-1-<?= count($card_items_header_count); ?> <?= $params->get('items_spacing'); ?>"
        uk-grid>
        <!-- @click="goToProduct(item.product.link)"  -->

        <?php if ($params->get('items_show_image')) : ?>
        <div>
            <!-- Image -->
            <div class="<?= $params->get('items_image_design') ?> uk-background-cover" 
                :style="{'background-image':'url('+item.product.teaserImagePath+')', 'width': '<?= $params->get('items_image_width', 80); ?>px', 'height': '<?= $params->get('items_image_width', 80); ?>px'}"
            ></div>

        </div>
        <?php endif; ?>

        <?php if ($params->get('items_show_title')) : ?>
        <!-- Title -->
        <div @click="goToProduct(item.product.link)">
            <h6>{{item.product.joomlaItem.title}}</h6>
            <ul class="uk-list uk-list-collapse">
                <li v-for="option in item.product.options" class="">
                    {{option.option_name}}:
                    {{option.modifier_value_translated}}
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($params->get('items_show_quantity')) : ?>
        <!-- QUantity -->
        <div>
            <input @input="changeCountDelay(item)" v-model="item.amount" class="uk-input" style="width: 70px;"
                min="0"
                :max="(parseInt(item.product.manage_stock) === 1 ? item.product.stock : '')"
                type="number">
            </span>
        </div>
        <?php endif; ?>

        <?php if ($params->get('products_with_taxes')) : ?>
            <div>
                {{ item.total_bought_at_price_formattedWithTax }}
            </div>
        <?php else : ?>
            <div>
                {{ item.total_bought_at_price_formattedWithoutTax }}
            </div>
        <?php endif; ?>
        
        <?php if ($params->get('items_show_remove_product_button')) : ?>
        <div class="uk-text-right">
            <a href="javascript:void(0);" @click="remove(item.id, item.cart_id, item.joomla_item_id)" uk-icon="icon: trash"></a>
        </div>
        <?php endif; ?>

    </div>
</div>

<div class="uk-card-footer">
    <span v-if="loading" uk-spinner></span>
    <a class="uk-button uk-button-primary uk-float-right" href="<?= $checkoutLink; ?>">
        <?= Text::_('COM_COMMERCELAB_SHOP_CHECKOUT_BUTTON'); ?>
    </a>
</div>