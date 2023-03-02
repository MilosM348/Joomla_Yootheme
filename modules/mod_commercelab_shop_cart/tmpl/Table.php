<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;


?>

<ul class="uk-nav uk-margin-small-bottom">

    <li class="uk-position-relative" v-for="(item, index) in cartItems">

        <hr v-if="index > 0" class="uk-margin-small-top uk-margin-small-bottom">
        <div v-if="index == 0" class="uk-overflow-hidden uk-margin-small-top uk-margin-small-bottom"></div>

        <a class="uk-position-absolute" 
            style="width: 20px; height: 20px; left: -29px; top: 22px;"
            uk-icon="icon: trash"
            uk-tooltip="<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTITEMS_REMOVE_FROM_CART') ?>"
            @click="remove(item.id, item.cart_id, item.joomla_item_id)" 
            href="javascript:void(0);" >
        </a>

        <!-- Smaller Mobile Phones Only -->
        <div class="<?= ($params->get('show_products_in') == 'offcanvas') ? '' : 'uk-hidden@s' ?>">
            
            <div class="uk-grid-small" uk-grid>
            
                <div class="uk-width-auto">

                    <a :href="item.product.link">

                        <div class="
                                <?= $params->get('items_image_design') ?> 
                                uk-background-cover uk-height-medium uk-panel 
                                uk-flex uk-flex-center uk-flex-middle
                            " 
                            :style="{'background-image':'url(\'' + item.product.teaserImagePath + '\')', 'width': '<?= $params->get('items_image_width', 45); ?>px', 'height': '<?= $params->get('items_image_width', 45); ?>px'}"
                        ></div>

                    </a>

                </div>

                <div class="uk-width-expand">            

                    <h6 class="uk-margin-remove uk-margin-small-top">

                        <a :href="item.product.link">
                            {{item.product.joomlaItem.title}}
                        </a>

                    </h6>

                    <ul class="uk-list uk-list-collapse">
                        <li v-if="item.listedVariants && item.listedVariants.length" v-for="variant in item.listedVariants">
                            <span class="uk-h6">
                                {{ variant.name }}: 
                                <span class="uk-text-bold">
                                    {{variant.label}}
                                </span>
                            </span>
                        </li>
                        <li v-for="option in item.selected_options" class="">
                            <span class="uk-h6">
                                {{option.option_name}}:
                                <span class="uk-text-bold">
                                    {{option.modifier_value_translated}}
                                </span>
                            </span>
                        </li>
                    </ul>

                </div>

                <div class="uk-width-1-1 uk-text-right">

                    <div class="uk-h5 uk-margin-remove" :class="updatedCart['item' + item.id]">

                        <span class="uk-h5 uk-margin-remove">
                            <span v-if="loading['item' + item.id]"class="uk-margin-small-right" style="width: 20px; height: 20px;" uk-spinner></span>
                            {{item.amount}} <span class="uk-h6 uk-text-small uk-text-muted uk-margin-small-right">X</span>
                        </span>

                        <?php if ($params->get('products_with_taxes')) : ?>
                            {{ item.total_bought_at_price_formattedWithTax }}
                        <?php else : ?>
                            {{ item.total_bought_at_price_formattedWithoutTax }}
                        <?php endif; ?>
                        
                    </div>

                </div>

            </div>

        </div>

        <!-- Larber Mobile Phones and Bigger -->
        <div class="<?= ($params->get('show_products_in') == 'offcanvas') ? 'uk-hidden' : 'uk-visible@s' ?> uk-grid-small" uk-grid>
            
            <div class="uk-width-auto">
                <a :href="item.product.link">
                    <div class="
                            <?= $params->get('items_image_design') ?> 
                            uk-background-cover uk-height-medium uk-panel 
                            uk-flex uk-flex-center uk-flex-middle
                        " 
                        :style="{'background-image':'url(\'' + item.product.teaserImagePath + '\')', 'width': '<?= $params->get('items_image_width', 45); ?>px', 'height': '<?= $params->get('items_image_width', 45); ?>px'}"
                    ></div>
                </a>
            </div>

            <div class="uk-width-expand">            

                <h6 class="uk-margin-remove">                            
                    <a :href="item.product.link">
                        {{item.product.joomlaItem.title}}
                    </a>
                </h6>

                <ul class="uk-list uk-list-collapse">
                    <li v-if="item.listedVariants && item.listedVariants.length" v-for="variant in item.listedVariants">
                        <span class="uk-h6">
                            {{ variant.name }}: 
                            <span class="uk-text-bold">
                                {{variant.label}}
                            </span>
                        </span>
                    </li>
                    <li v-for="option in item.selected_options" class="">
                        <span class="uk-h6">
                            {{option.option_name}}:
                            <span class="uk-text-bold">
                                {{option.modifier_value_translated}}
                            </span>
                        </span>
                    </li>
                </ul>

            </div>

            <div class="uk-width-auto uk-margin-small-right">

                <div class="uk-h5 uk-margin-remove" :class="updatedCart['item' + item.id]">

                    <?php if ($params->get('products_with_taxes')) : ?>
                        {{ item.total_bought_at_price_formattedWithTax }}
                    <?php else : ?>
                        {{ item.total_bought_at_price_formattedWithoutTax }}
                    <?php endif; ?>
                    
                </div>

                <div class="uk-h5 uk-margin-remove uk-text-right">
                    <span class="uk-h6 uk-text-small uk-text-muted">
                        <span v-if="loading['item' + item.id]"class="uk-margin-small-right" style="width: 20px; height: 20px;" uk-spinner></span>
                        X
                    </span> {{item.amount}}
                </div>

            </div>

        </div>

        <div class="uk-position-absolute" style=" right: -25px; top: 8px;">
            <a href="javascript:void(0);" 
                @click="item.amount = item.amount + 1, changeCountDelay(item)" 
                uk-icon="icon: plus-circle" class="uk-display-block">
            </a>

            <a href="javascript:void(0);" 
                :class="{'uk-disabled': item.amount == 1}"
                @click="(item.amount > 1) ? item.amount = item.amount - 1 : null, changeCountDelay(item)" 
                uk-icon="icon: minus-circle" class="uk-display-block uk-margin-small-top">
            </a>

        </div>

        <input @input="changeCountDelay(item)" v-model="item.amount" class="uk-input" style="width: 30px;"
            min="0"
            :max="(parseInt(item.product.manage_stock) === 1 ? item.product.stock : '')"
            type="hidden">
        </span>

    </li>

</ul>
