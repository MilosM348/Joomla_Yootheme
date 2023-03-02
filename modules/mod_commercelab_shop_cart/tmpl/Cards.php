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


<!-- 
<div class="uk-card-header">
    <div class="<?= $params->get('items_spacing'); ?>">
        
    </div>
</div>
 -->
<div class="uk-card-body">

    <div v-for="item in cartItems" class="uk-child-width-1-1 <?= $params->get('items_spacing'); ?>" uk-grid>

        <div class="uk-card uk-card-default uk-card-border">
            
            <div class="uk-card-header">
                <span class="h5">{{ item.product.title }}</span>
                <span class="uk-text-right">{{ item.total_bought_at_price_with_tax_formatted }}</span>
            </div>

            <div class="uk-card-body">
                <div class="<?= $params->get('items_image_design') ?> uk-background-cover" 
                    :style="{'background-image':'url(' + item.product.teaserImagePath + ')', 'width': '<?= $params->get('items_image_width', 80); ?>px', 'height': '<?= $params->get('items_image_width', 80); ?>px'}"
                ></div>
            </div>

            <div class="uk-card-footer">

            </div>

        </div>

    </div>

</div>

<div class="uk-card-footer">
    <span v-if="loading" uk-spinner></span>
    <a class="uk-button uk-button-primary uk-float-right" href="<?= $checkoutLink; ?>">
        <?= Text::_('COM_COMMERCELAB_SHOP_CHECKOUT_BUTTON'); ?>
    </a>
</div>
