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

?>

<div class="uk-grid" uk-grid>

    <div v-if="pages > 1" class="uk-width-auto">
        <ul class="uk-pagination" uk-margin>

            <li :class="{'uk-disabled': currentPage === 0}">
                <a @click.prevent="currentPage = currentPage-1, filter()">
                    <span uk-pagination-previous></span>
                </a>
            </li>

            <li v-for="(page, index) in pages" v-if="pages > 10">
                <a 
                    :class="{'uk-text-emphasis': (index == currentPage)}" 
                    v-if="( index > (currentPage - 5) ) && (index < (currentPage + 5))" 
                    :style="{'cursor':((index == currentPage) ? 'default' : 'pointer')}" 
                    @click.prevent="(index != currentPage) ? changePage(index) : false">
                        {{page}}
                </a>
            </li>

            <li v-for="(page, index) in pages" v-if="pages < 10">
                <a 
                    :class="{'uk-text-emphasis': (index == currentPage)}" 
                    :style="{'cursor':((index == currentPage) ? 'default' : 'pointer')}" 
                    @click.prevent="(index != currentPage) ? changePage(index) : false">
                        {{page}}
                </a>
            </li>

            <li :class="{'uk-disabled': currentPage === pages - 1}">
                <a @click.prevent="currentPage = currentPage+1, filter()">
                    <span uk-pagination-next></span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Items per Page -->
    <div class="uk-width-auto">
        <select v-model="show" @change="currentPage = 0, filter()" class="uk-select uk-form-width-small">
            <option v-for="pagesize in pagesizes" :value="pagesize">
                Show {{pagesize}}
            </option>
        </select>
    </div>
</div>
