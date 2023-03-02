<?php
/**
 * @package     Pro2Store - Grid & Filter
 *
 * @copyright   Copyright (C) 2021 Ray Lawlor - Pro2Store. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = uniqid('yps_gridandfilter_sort');

$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        '{panel_padding}',
        '{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
    ],

    'style' => [
        'border-bottom: 1px solid {panel_border_bottom_color}; {@panel_border_bottom}'
    ]

]);

?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>" class="uk-form uk-width-1-1">

        <?php if ($props['layout'] == 'dropdown') : ?>

            <div class="uk-grid-small" uk-grid>
                
                <div class="uk-width-auto">
                    
                    <a href="javascript:void(0);" @click="sortOrder = 'ASC', sort()" 
                        :class="{'uk-active': sortOrder == 'ASC'}"
                        uk-icon="icon: <?= $props['asc_icon']; ?>"
                    >
                        <?= $props['asc_text']; ?>
                    </a>

                    <a href="javascript:void(0);" @click="sortOrder = 'DESC', sort()" 
                        :class="{'uk-active': sortOrder == 'DESC'}"
                        uk-icon="icon: <?= $props['desc_icon']; ?>"
                    >
                        <?= $props['desc_text']; ?>
                    </a>

                </div>

                <div class="uk-width-expand">
                    
                    <select @change="sort()" class="uk-select uk-width-1-1" v-model="sortOption">
                        <?php foreach ($props['sorted_by'] as $key => $sort_option) : ?>
                        <option value="<?= $sort_option ?>">
                            <?= $props['all_sort_options'][$sort_option]; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    
                </div>
                
            </div>

        <?php endif ?>

        <?php if ($props['layout'] == 'buttons') : ?>
            <button class="uk-button <?= $props['button_styling']; ?> <?= $props['button_size']; ?>"
                :class="{'uk-text-bold': sortOrder == '<?= $props['button_sorted_direction']; ?>' && sortOption == '<?= $props['button_sorted_by']; ?>'}"
                @click="sortOrder = '<?= $props['button_sorted_direction']; ?>', sortOption = '<?= $props['button_sorted_by']; ?>', sort()"
            >
                <?= $props['button_text']; ?>
            </button>
        <?php endif ?>

    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    onLoadsortOption: '',
                    onLoadsortOrder: '',
                    sortOption: '',
                    sortOrder: '',
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
                    task_url: Joomla_cls.uri_base + 'index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&format=raw'
                }
            },
            beforeMount(){
                emitter.on("gridandfilter_reset_sort", this.resetSort);
                emitter.on("gridandfilter_set_sort", this.getSort);
            },
            created() {
            },
            mounted() {
                this.setSort();
            },
            methods: {
                changeSort(sort) {
                    this.sortOption = sort;
                    this.sort();
                },

                changeDirection(direction) {
                    this.sortOrder = direction;
                    this.sort();
                },

                async setSort() {
                    emitter.emit("gridandfilter_get_sort");
                },
                async getSort(onLoadSort) {
                    this.sortOption = this.onLoadsortOption = onLoadSort.sortOption;
                    this.sortOrder  = this.onLoadsortOrder  = onLoadSort.sortOrder;
                },
                async resetSort() {
                    this.sortOption = this.onLoadsortOption;
                    this.sortOrder  = this.onLoadsortOrder;
                },
                async sort() {
                    emitter.emit("gridandfilter_sort", {
                        sortOption: this.sortOption,
                        sortOrder: this.sortOrder
                    });
                }
            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

    </script>

<?= $el->end(); ?>