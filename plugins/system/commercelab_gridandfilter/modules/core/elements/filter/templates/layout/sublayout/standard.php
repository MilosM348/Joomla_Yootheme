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

?>
            

<label 
    style="cursor: pointer;" 
    :class="{'uk-active': filter_list.indexOf(filter_option.id) !== -1}"
>
    <input 
        @change="setFilter($event)"
        :id="'<?= $id ?>_filter_' + filter_option.id" 
        :value="filter_option.id"
        v-model="filtered"
        type="<?= ($props['multi_select']) ? 'checkbox' : 'radio'; ?>" 
        class="<?= ($props['multi_select']) ? 'uk-checkbox' : 'uk-radio'; ?> uk-margin-small-right" 
    >

    <span>
        {{ filter_option.title }}
    </span>
    <?php if ($props['show_number_items']) : ?>
        <span class="uk-text-muted uk-text-small uk-margin-small-left">
            {{ filter_option.numitems }}
        </span>
    <?php endif; ?>
</label>
