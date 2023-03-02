<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

?>

<ul class="uk-nav">

    <li class="" v-for="(item, index) in cartItems">

        <hr v-if="index > 0" class="uk-margin-small-top uk-margin-small-bottom">
        <!-- <div v-if="index == 0" class="uk-overflow-hidden uk-margin-small-top uk-margin-small-bottom"></div> -->

        <div>
            
            <div class="uk-grid-small" uk-grid>
            
                <div class="uk-width-expand uk-grid-small" uk-grid>

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

                        <div class="uk-margin-remove uk-margin-small-top" style="line-height: 100%;">
                            <a :href="item.product.link">
                                {{item.product.joomlaItem.title}}
                            </a>
                        </div>

                        <div class="uk-text-small uk-margin-remove" :class="updatedCart['item' + item.id]">

                            <?php if ($params->get('products_with_taxes')) : ?>
                                {{ item.total_bought_at_price_formattedWithTax }}
                            <?php else : ?>
                                {{ item.total_bought_at_price_formattedWithoutTax }}
                            <?php endif; ?>
                            
                            <span v-if="loading['item' + item.id]" class="uk-margin-small-left" style="width: 20px; height: 20px;" uk-spinner></span>
                        </div>

                        <div v-for="option in item.selected_options" style="line-height: 100%;" class="uk-text-small">
                            {{option.option_name}}: +{{option.modifier_value_translated}}
                        </div>

                    </div>

                    <div class="uk-width-1-1 uk-margin-remove">

                        <ul class="uk-list uk-list-collapse">
                            <li v-if="item.listedVariants && item.listedVariants.length" v-for="variant in item.listedVariants">
                                <span class="uk-h6">
                                    {{ variant.name }}: 
                                    <span class="uk-text-bold">
                                        {{variant.label}}
                                    </span>
                                </span>
                            </li>
                        </ul>

                    </div>

                </div>

                <div class="uk-width-auto uk-text-center">

                    <div class="uk-width-1-1 uk-position-relative uk-margin-bottom ">
                        <a class="uk-position-absolute" 
                            style="right: -7px; top: -7px;"
                            uk-icon="icon: trash; ratio: 0.7"
                            uk-tooltip="<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTITEMS_REMOVE_FROM_CART') ?>"
                            @click="remove(item.id, item.cart_id, item.joomla_item_id)" 
                            href="javascript:void(0);" >
                        </a>
                    </div>

                    <div class="uk-width-1-1">
                        <a href="javascript:void(0);" 
                            :class="{'uk-disabled': item.amount == 1}"
                            @click="(item.amount > 1) ? item.amount = item.amount - 1 : null, changeCountDelay(item)" 
                            uk-icon="icon: minus-circle" class="uk-display-block">
                        </a>
                    </div>

                    <div class="uk-width-1-1" style="line-height: 100%;">
                        <span>
                            {{item.amount}}
                        </span>
                    </div>

                    <div class="uk-width-1-1">
                        <a href="javascript:void(0);" 
                            @click="item.amount = item.amount + 1, changeCountDelay(item)" 
                            uk-icon="icon: plus-circle" class="uk-display-block">
                        </a>
                    </div>

                </div>

            </div>

        </div>

        <input @input="changeCountDelay(item)" v-model="item.amount" class="uk-input" style="width: 30px;"
            min="0"
            :max="(parseInt(item.product.manage_stock) === 1 ? item.product.stock : '')"
            type="hidden">
        </span>

    </li>

</ul>
