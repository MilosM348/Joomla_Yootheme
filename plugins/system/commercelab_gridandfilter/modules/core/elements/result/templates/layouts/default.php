<?php
/**
 * @package     CommerceLab Shop - Grid & Filter
 *
 * @copyright   Copyright (C) 2021 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

?>

<!-- On load HTML -->
<div v-if="!loaded" class="<?= $props['items_per_row'] ?>" uk-grid>

    <?php foreach($props['items'] as $item_content) : ?>
    <div class="uk-animation-fade uk-animation-fast">

        <?php if (isset($item_content['image'])) : ?>
            <img src="<?= $item_content['image'] ?>">
        <?php endif; ?>
 
        <?php if (isset($item_content['title'])) : ?>
            <h3><?= $item_content['title'] ?></h3>
        <?php endif; ?>

        <?php if (isset($item_content['meta'])) : ?>
            <div class="uk-text-meta"><?= $item_content['meta'] ?></div>
        <?php endif; ?>

        <?php if (isset($item_content['content'])) : ?>
            <div><?= $item_content['content'] ?></div>
        <?php endif; ?>
        
    </div>
    <?php endforeach; ?>

</div>

<!-- After Load VueJS -->
<div v-if="loaded" class="uk-grid-<?= $props['grid_column_gap'] ?> <?= $props['items_per_row'] ?>" uk-grid
    :style="{'opacity':((queryLoading) ? '0.5' : '1')}"
>
    <div v-for="item in items" class="uk-animation-fade uk-animation-fast">

        <div class="<?= $props['panel_align'] ?> <?= $props['panel_padding'] ?> <?= $props['panel_background'] != '' ? 'uk-card uk-card-' . $props['panel_background'] . ' uk-card-hover' : '' ?>">

            <?php if ($props['image_source'] && $props['enable_image_source']) : ?>
                <div class="<?= $props['panel_background'] != '' ? 'uk-card-media-top' : '' ?>">
                <?php if ($props['title_source_link']) : ?>
                    <a :href="item.sources.link">
                <?php endif; ?>
                        <img v-if="item.image" :src="item.image" class="uk-width-full uk-height-auto">
                <?php if ($props['title_source_link']) : ?>
                    </a>
                <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="cls-grid-item-body <?= $props['panel_content_padding'] ?> <?= $props['panel_background'] != '' ? 'uk-card-body' : '' ?>">

                <?php if ($props['subtitle_source'] && $props['enable_subtitle_source'] && $props['subtitle_position'] == 'above_title') : ?>
                    <<?= $props['subtitle_text_element'] ?> v-if="item.subtitle"
                        class="el-meta cls-grid-item-subtitle el-meta
                            <?= $props['margin_subtitle_source'] ?>
                            <?= $props['subtitle_text_style'] ?>
                            <?= $props['subtitle_text_decoration'] ?>
                            <?= $props['subtitle_text_font_family'] ?>
                            <?= $props['subtitle_text_color'] ?>
                            <?= $props['margin_additional_subtitle_source'] ?>
                        "
                    >
                        {{ item.subtitle }}
                    </<?= $props['subtitle_text_element'] ?>>
                <?php endif; ?>
                
                <?php if ($props['title_source'] && $props['enable_title_source']) : ?>
                    <?php if ($props['title_source_link']) : ?>
                        <a :href="item.sources.link">
                    <?php endif; ?>
                        <<?= $props['title_text_element'] ?> v-if="item.title"
                            class="el-title cls-grid-item-title cls-grid-item-title
                                <?= $props['margin_title_source'] ?>
                                <?= $props['title_text_style'] ?>
                                <?= $props['title_text_decoration'] ?>
                                <?= $props['title_text_font_family'] ?>
                                <?= $props['title_text_color'] ?>
                            "
                        >
                            {{ item.title }}
                        </<?= $props['title_text_element'] ?>>

                    <?php if ($props['title_source_link']) : ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($props['subtitle_source'] && $props['enable_subtitle_source'] && $props['subtitle_position'] == 'bellow_title') : ?>
                    <<?= $props['subtitle_text_element'] ?> v-if="item.subtitle"
                        class="cls-grid-item-subtitle el-meta
                            <?= $props['margin_subtitle_source'] ?>
                            <?= $props['subtitle_text_style'] ?>
                            <?= $props['subtitle_text_decoration'] ?>
                            <?= $props['subtitle_text_font_family'] ?>
                            <?= $props['subtitle_text_color'] ?>
                            <?= $props['margin_additional_subtitle_source'] ?>
                        "
                    >
                        {{ item.subtitle }}
                    </<?= $props['subtitle_text_element'] ?>>
                <?php endif; ?>
                
                <?php if ($props['content_source'] && $props['enable_content_source']) : ?>
                <div v-if="item.content"
                    class="el-content cls-grid-item-content
                        <?= $props['margin_content_source'] ?>
                        <?= $props['content_text_style_content_source'] ?>
                    " 
                >
                    <span v-html="item.content"></span>
                </div>
                <?php endif; ?>

                <?php if ($props['additional_text'] && $props['enable_additional_text']) : ?>
                    <<?= $props['additional_text_text_element'] ?> v-if="item.title"
                        class="cls-grid-item-additional-text
                            <?= $props['margin_additional_text'] ?>
                            <?= $props['additional_text_text_style'] ?>
                            <?= $props['additional_text_text_decoration'] ?>
                            <?= $props['additional_text_text_font_family'] ?>
                            <?= $props['additional_text_text_color'] ?>
                        "
                    >
                        <?php if ($props['additional_text_pre'] != '') : ?>
                        <span>
                            <?= $props['additional_text_pre'] ?>
                        </span>
                        <?php endif; ?>

                        <span v-html="item.additional_text"></span>

                        <?php if ($props['additional_text_after'] != '') : ?>
                        <span>
                            <?= $props['additional_text_after'] ?>
                        </span>
                        <?php endif; ?>

                    </<?= $props['additional_text_text_element'] ?>>
                <?php endif; ?>

                <?php if ($props['additional_text2'] && $props['enable_additional_text2']) : ?>
                    <<?= $props['additional_text2_text_element'] ?> v-if="item.title"
                        class="cls-grid-item-additional-text-2
                            <?= $props['margin_additional_text2'] ?>
                            <?= $props['additional_text2_text_style'] ?>
                            <?= $props['additional_text2_text_decoration'] ?>
                            <?= $props['additional_text2_text_font_family'] ?>
                            <?= $props['additional_text2_text_color'] ?>
                        "
                    >
                        <?php if ($props['additional_text2_pre'] != '') : ?>
                        <span>
                            <?= $props['additional_text2_pre'] ?>
                        </span>
                        <?php endif; ?>

                        <span v-html="item.additional_text2"></span>

                        <?php if ($props['additional_text2_after'] != '') : ?>
                        <span>
                            <?= $props['additional_text2_after'] ?>
                        </span>
                        <?php endif; ?>

                    </<?= $props['additional_text2_text_element'] ?>>
                <?php endif; ?>

                <div class="button_links uk-grid-small uk-margin-top-small cls-grid-item-buttons-wrapper" uk-grid>

                    <?php if ($props['button1'] && $props['enable_button1']) : ?>
                        <div class="<?= $props['button1_width'] ?>">

                            <div class="uk-grid-small <?= $props['button1_margin'] ?>" uk-grid>
                                    
                                <?php if ($props['button1_show_quantity'] && $props['button1'] == 'add2cart') : ?>
                                <div class="uk-width-auto uk-form cls-grid-item-add2cart-quantityinput">
                                    <input class="uk-input" style="width: 70px;" type="number" v-model="item.add2cartquantity">
                                </div>
                                <?php endif; ?>

                                <div class="uk-width-expand">
                                    <button 
                                        @click="<?= ($props['button1'] == 'link') ? 'goToLink(item.sources.link)' : 'addToCart(item.joomla_item_id, item.add2cartquantity, {action: \'' . $props['button1_action'] . '\'})' ?>"
                                        class="uk-button uk-width-1-1 cls-grid-item-button-1
                                            <?= $props['button1_size'] ?>
                                            <?= ($props['button1'] == 'add2cart') 
                                                ? 'cls-grid-item-button-add2cart' 
                                                : 'cls-grid-item-button' ?>
                                        "
                                        :class="(item.product.in_cart && '<?= $props['button1'] == 'add2cart' ?>') ? 'cls-grid-item-button-add2cart-added <?= $props['button1_style_cart_added'] ?>' : '<?= $props['button1_style'] ?>'"
                                    >
                                        <?php if ($props['button1'] == 'add2cart') : ?>
                                            <span v-if="item.product.in_cart">
                                                <?= $props['button1_text_added_cart'] ?>
                                                <?php if ($props['button1_show_amount']) : ?>
                                                     x {{item.product.in_cart}}
                                                <?php endif; ?>
                                            </span>
                                            <span v-else>
                                                <?= $props['button1_text'] ?>
                                            </span>
                                        <?php else: ?>
                                            <?= $props['button1_text'] ?>
                                        <?php endif; ?>
                                    </button>
                                </div>

                            </div>

                        </div>
                    <?php endif; ?>

                    <?php if ($props['button2'] && $props['enable_button2']) : ?>
                        <div class="<?= $props['button2_width'] ?>">

                            <div class="uk-grid-small <?= $props['button2_margin'] ?>" uk-grid>
                                    
                                <?php if ($props['button2_show_quantity'] && $props['button2'] == 'add2cart') : ?>
                                <div class="uk-width-auto uk-form cls-grid-item-add2cart-quantityinput">
                                    <input class="uk-input" style="width: 70px;" type="number" v-model="item.add2cartquantity">
                                </div>
                                <?php endif; ?>

                                <div class="uk-width-expand">
                                    <button 
                                        @click="<?= ($props['button2'] == 'link') ? 'goToLink(item.sources.link)' : 'addToCart(item.joomla_item_id, item.add2cartquantity, {action: \'' . $props['button2_action'] . '\'})' ?>"
                                        class="uk-button uk-width-1-1
                                        <?= $props['button2_size'] ?>
                                            <?= ($props['button2'] == 'add2cart') 
                                                ? 'cls-grid-item-button-add2cart' 
                                                : 'cls-grid-item-button' ?>
                                        "
                                        :class="[(item.product.in_cart && '<?= $props['button2'] == 'add2cart' ?>') ? 'cls-grid-item-button-add2cart-added <?= $props['button2_style_cart_added'] ?>' : '<?= $props['button2_style'] ?>']"
                                    >
                                        <?php if ($props['button2'] == 'add2cart') : ?>
                                            <span v-if="item.product.in_cart">
                                                <?= $props['button2_text_added_cart'] ?>
                                                <?php if ($props['button2_show_amount']) : ?>
                                                     x {{item.product.in_cart}}
                                                <?php endif; ?>
                                            </span>
                                            <span v-else>
                                                <?= $props['button2_text'] ?>
                                            </span>
                                        <?php else: ?>
                                            <?= $props['button2_text'] ?>
                                        <?php endif; ?>
                                    </button>
                                </div>

                            </div>

                        </div>
                        <?php // if ($props['button1'] == 'link') ?>

                    <?php endif; ?>
                </div>

            </div>

        </div>

    </div>
</div>
