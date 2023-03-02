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


<table class="uk-table uk-table-small">
    <thead>
        <tr>
            <th></th>
            <th>
                <span style="<?= ($params->get('drop_card_color') == 'custom') 
                    ? 'color:' . $params->get('custom_dropdown_text_color') . ';' 
                    : '' ?>">
                        <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_PRODUCT'); ?>
                </span>
            </th>
            <th>
                <span
                    style="<?= ($params->get('drop_card_color') == 'custom') 
                        ? 'color:' . $params->get('custom_dropdown_text_color') . ';' 
                        : '' ?>"
                    class="uk-width-small uk-text-nowrap">
                    <?= Text::_('QUANTITY'); ?>
                </span>
            </th>
            <th>
                <span
                    style="<?= ($params->get('drop_card_color') == 'custom') 
                        ? 'color:' . $params->get('custom_dropdown_text_color') . ';' 
                        : '' ?>"
                    class="uk-width-small uk-text-nowrap">
                    <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_TOTAL'); ?>
                </span>
            </th>

            <!-- Close Cart -->
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(item, index) in cartItems"
                :style="((index+1) % 2 == 1) ? 'background: rgb(222 222 222 / 50%);' : ''"
            >

            <!-- Image -->
            <!-- goToProduct(item.product.link) -->
            <td class="uk-table-shrink uk-padding-remove-right" @click="">                                    
                <a :href="item.product.link">
                    <div 
                        class="<?= $params->get('items_image_design') ?> uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
                        :style="{'background-image':'url(\'' + item.product.teaserImagePath + '\')', 'width': '<?= $params->get('items_image_width', 80); ?>px', 'height': '<?= $params->get('items_image_width', 80); ?>px'}"
                    ></div>
                </a>
            </td>

            <!-- Title -->
            <td class="uk-table-expand uk-padding-remove-right" @click="">
                <h6 class="uk-margin-small">                            
                    <a :href="item.product.link">
                        <span style="<?= ($params->get('drop_card_color') == 'custom') 
                            ? 'color:' . $params->get('custom_dropdown_text_color') . ';' 
                            : '' ?>"
                        >
                            {{item.product.joomlaItem.title}} x {{item.amount}}
                        </span>
                    </a>
                </h6>
                <ul class="uk-list uk-list-collapse uk-margin-remove">
                    <li v-if="item.selected_variant">
                        <span class="uk-h6">
                            {{ item.product.variants[0].name }}: 
                        </span>
                        {{item.selected_variant.labels_csv}}
                    </li>
                    <li v-for="option in item.selected_options" class="">
                        <span class="uk-h6">
                            {{option.option_name}}:
                        </span>
                        {{option.modifier_value_translated}}
                    </li>
                </ul>
            </td>

            <!-- QUantity -->
            <td class="uk-width-small uk-text-nowrap uk-padding-remove-right">
                <input style="width:45%;" @input="changeCountDelay(item)" v-model="item.amount" class="uk-input" style="width: 70px;"
                    min="0"
                    :max="(parseInt(item.product.manage_stock) === 1 ? item.product.stock : '')"
                    type="number">
                </span>
            </td>

            <td class="uk-width-small uk-text-nowrap uk-padding-remove-right">
                <span 
                    style="<?= ($params->get('drop_card_color') == 'custom') 
                        ? 'color:' . $params->get('custom_dropdown_text_color') . ';' 
                        : '' ?>"
                    class="h6" :class="updatedCart['item' + item.id]">

                    <?php if ($params->get('products_with_taxes')) : ?>
                        {{ item.total_bought_at_price_formattedWithTax }}
                    <?php else : ?>
                        {{ item.total_bought_at_price_formattedWithoutTax }}
                    <?php endif; ?>
                    
                </span>
            </td>

            <td class="uk-table-shrink uk-text-nowrap">
                <a  class="uk-display-block" 
                    style="width:20px; height: 20px;"
                    uk-icon="icon: trash"
                    @click="remove(item.id, item.cart_id, item.joomla_item_id)" 
                    href="javascript:void(0);" >
                </a>
            </td>

        </tr>
    </tbody>
</table>
