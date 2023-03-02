<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

/** @var $props array */
/** @var $attrs array */

use CommerceLabShop\Currency\CurrencyFactory;

?>

<?php if (in_array('price', $props['search_within'])) : ?>

    <?php if (isset($props['slider']) && $props['slider'] === true) : ?>

        <!-- Slider -->
        <div class="uk-width-1-1">
            <input class="uk-width-full" type="hidden" name="<?= $id; ?>_priceRange" id="<?= $id; ?>_priceRange">
        </div>

    <?php else : ?>

        <div class="uk-grid-small" uk-grid>
            
            <div class="uk-inline uk-width-1-2">

                <?php if ($props['show_icon']) : ?>
                <span 
                    class="uk-form-icon <?= ($props['icon_position'] == 'right') ? 'uk-form-icon-flip' : '' ?>"
                    uk-icon="icon: <?= $props['price_icon'] ?>">
                        <?php if ($props['price_icon'] == 'CurrencySymbol') : ?>
                            <?= CurrencyFactory::getCurrent()->currencysymbol ?>
                        <?php endif; ?>
                </span>
                <?php endif; ?>

                <!-- Price Frpm -->
                <input type="text" class="uk-input uk-width-1-1"
                    placeholder="<?= $props['search_price_from_placeholder'] ?>" 
                    v-model="priceFrom" 
                    @input="onChange($event)" 
                    id="<?= $id; ?>_priceFrom"
                    name="<?= $id; ?>_priceFrom"
                >

            </div>

            <div class="uk-inline uk-width-1-2">

                <?php if ($props['show_icon']) : ?>
                <span 
                    class="uk-form-icon <?= ($props['icon_position'] == 'right') ? 'uk-form-icon-flip' : '' ?>" 
                    uk-icon="icon: <?= $props['price_icon'] ?>">
                        <?php if ($props['price_icon'] == 'CurrencySymbol') : ?>
                            <?= CurrencyFactory::getCurrent()->currencysymbol ?>
                        <?php endif; ?>
                </span>
                <?php endif; ?>

                <!-- Price To -->
                <input type="text" class="uk-input uk-width-1-1"
                    placeholder="<?= $props['search_price_to_placeholder'] ?>" 
                    v-model="priceTo" 
                    @input="onChange($event)" 
                    id="<?= $id; ?>_priceTo"
                    name="<?= $id; ?>_priceTo"
                >

            </div>

        </div>

    <?php endif; ?>

<?php else : ?>

    <?php if (isset($props['slider']) && $props['slider'] === true) : ?>

        <!-- Slider -->
        <div class="uk-width-1-1">
            <input class="uk-width-full" type="hidden" name="<?= $id; ?>_searchTerm" id="<?= $id; ?>_searchTerm">
        </div>

    <?php else : ?>

        <div class="uk-inline uk-width-1-1">

            <?php if ($props['show_icon']) : ?>
            <span 
                class="uk-form-icon <?= ($props['icon_position'] == 'right') ? 'uk-form-icon-flip' : '' ?>" 
                uk-icon="icon: <?= $props['search_icon'] ?>">        
            </span>
            <?php endif; ?>

            <!-- Search Bar -->
            <input type="text" class="uk-input uk-width-1-1"
                placeholder="<?= $props['searchbar_placeholder'] ?>" 
                v-model="searchTerm" 
                @input="onChange($event)" 
                id="<?= $id; ?>_searchTerm"
                name="<?= $id; ?>_searchTerm"
            >

        </div>
    <?php endif; ?>

<?php endif; ?>