<?php
/**
 * @package     Pro2Store - Grid & Filter
 *
 * @copyright   Copyright (C) 2021 Ray Lawlor - Pro2Store. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = uniqid('yps_gridandfilter_pagination');

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

    <div id="<?= $id; ?>" class="uk-form uk-width-1-1" v-cloak>

        <ul v-if="totalPages > 1" class="uk-pagination <?= $props['align_pagination'] ?>">

            <?php if ($props['prevnext'] == 'separated') : ?>
            <li class="uk-margin-auto-right">
                <a href="javascript:void(0);" @click="changePage(((actualPage - 1) * itemsPerPage) - itemsPerPage)"
                    :class="{'uk-disabled': (actualPage - 1) == 0}"
                >
                    <span class="uk-margin-small-right" uk-pagination-previous></span>
                    <?= $props['prev_text'] ?>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($props['prevnext'] == 'stacked') : ?>
            <li>
                <a href="javascript:void(0);" @click="changePage(((actualPage - 1) * itemsPerPage) - itemsPerPage)"
                    :class="{'uk-disabled': (actualPage - 1) == 0}"
                >
                    <span uk-pagination-previous></span>
                </a>
            </li>
            <?php endif; ?>

            <!-- Left Edge -->
            <li 
                v-for="page in pages.edge_l"
                :class="{'uk-active': page == actualPage}"
            >
                <a 
                    v-if="page != actualPage"
                    href="javascript:void(0);"
                    @click="changePage((page * itemsPerPage) - itemsPerPage)"
                >
                    {{page}}
                </a>
                <span v-else>{{page}}</span>
            </li>

            <!-- Separator L -->
            <li v-if="pages.separator_l" class="uk-disabled"><span>…</span></li>

            <!-- Middle Pages -->
            <li 
                v-for="page in pages.middle"
                :class="{'uk-active': page == actualPage}"
            >
                <a 
                    v-if="page != actualPage"
                    href="javascript:void(0);"
                    @click="changePage((page * itemsPerPage) - itemsPerPage)"
                >
                    {{page}}
                </a>
                <span v-else>{{page}}</span>
            </li>

            <!-- Separator R -->
            <li v-if="pages.separator_r" class="uk-disabled"><span>…</span></li>

            <!-- Right Edge -->
            <li 
                v-for="page in pages.edge_r"
                :class="{'uk-active': page == actualPage}"
            >
                <a 
                    v-if="page != actualPage"
                    href="javascript:void(0);"
                    @click="changePage((page * itemsPerPage) - itemsPerPage)"
                >
                    {{page}}
                </a>
                <span v-else>{{page}}</span>
            </li>

            <?php if ($props['prevnext'] == 'stacked') : ?>
            <li>
                <a href="javascript:void(0);" @click="changePage(((actualPage + 1) * itemsPerPage) - itemsPerPage)"
                    :class="{'uk-disabled': (actualPage + 1) > totalPages}"
                >
                    <span uk-pagination-next></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if ($props['prevnext'] == 'separated') : ?>
            <li class="uk-margin-auto-left">
                <a href="javascript:void(0);" @click="changePage(((actualPage + 1) * itemsPerPage) - itemsPerPage)"
                    :class="{'uk-disabled': (actualPage + 1) > totalPages}"
                >
                    <?= $props['next_text'] ?>
                    <span class="uk-margin-small-left" uk-pagination-next></span>
                </a>
            </li>
            <?php endif; ?>

        </ul>

    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    gafParams: Joomla_cls.gaf,
                    middlePages: <?= $props['middle_pages'] ?>,
                    edgePages: <?= $props['edge_pages'] ?>,
                    itemsPerPage: 0,
                    totalItems: 0,
                    totalfiltered: 0,
                    totalPages: 0,
                    actualPage: 1,
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
                emitter.on("gridandfilter_set_pagination", this.getPagination);
                emitter.on("gridandfilter_reset_pagination", this.resetPagination);
            },
            created() {},
            computed: {
                pages() {

                    const middlePageHalf = (this.middlePages - 1) / 2;

                    const pagesGroup = {};
                    pagesGroup['edge_l']      = [];
                    pagesGroup['separator_l'] = false;
                    pagesGroup['middle']      = [];
                    pagesGroup['separator_r'] = false;
                    pagesGroup['edge_r']      = [];

                    if (this.totalPages <= this.middlePages)
                    {
                        pagesGroup['edge_l'] = this.pagesRange(1, this.totalPages);
                    } 
                    else if (this.totalPages > this.middlePages && this.totalPages < (this.middlePages + (this.edgePages * 2)) )
                    {
                        pagesGroup['edge_l']       = this.pagesRange(1, this.middlePages);
                        pagesGroup['separator_r'] = true;
                        pagesGroup['edge_r']       = this.pagesRange((this.totalPages - this.edgePages) + 1, this.totalPages);
                    }
                    else
                    {
                        pagesGroup['edge_l'] = this.pagesRange(
                            1, 
                            this.edgePages
                        );

                        pagesGroup['separator_l'] = (this.actualPage > (this.edgePages + middlePageHalf)) 
                            ? true 
                            : false;

                        pagesGroup['middle'] = (this.actualPage > (this.totalPages - (this.edgePages + 1)))
                            ? []
                            : (this.pagesRange(
                                ((this.actualPage > (this.edgePages + middlePageHalf))
                                    ? ((this.actualPage - middlePageHalf > this.edgePages + middlePageHalf)
                                        ? (this.actualPage - middlePageHalf)
                                        : (this.actualPage - middlePageHalf) + 1)
                                    : this.edgePages + 1), // Near to Edge L
                                ((this.actualPage > (this.edgePages + middlePageHalf))
                                    ? ((this.actualPage - middlePageHalf > this.edgePages + middlePageHalf)
                                        ? this.actualPage + middlePageHalf
                                        : this.actualPage + (this.middlePages - 1))
                                    : this.edgePages + this.middlePages)
                                ) // Near to Edge L
                            );

                        pagesGroup['separator_r'] = (this.actualPage < (this.totalPages - this.edgePages))
                            ? true 
                            : false;

                        pagesGroup['edge_r'] = this.pagesRange(
                            ((this.actualPage > ((this.totalPages - 1) - this.edgePages))
                                ? this.totalPages - this.middlePages
                                : (this.totalPages + 1) - this.edgePages),
                            this.totalPages
                        );
                    }
                    
                    return pagesGroup;
                }
            },
            mounted() {
                console.log(this.pages);
                this.setPagination();
            },
            methods: {
                pagesRange(start, end) {
                    const list = [];
                    for (var i = start; i <= end; i++) {
                        list.push(i);
                    }
                    return list;
                },
                changePage(offset) {
                    console.log(offset);
                    emitter.emit("gridandfilter_change_offset", {offset});
                },
                async setPagination() {
                    emitter.emit("gridandfilter_get_pagination");
                },
                async getPagination(pagination) {
                    this.itemsPerPage  = pagination.itemsPerPage;
                    this.totalItems    = pagination.totalItems;
                    this.totalfiltered = pagination.totalfiltered;
                    this.totalPages    = Math.ceil(this.totalfiltered / this.itemsPerPage);
                    this.actualPage    = pagination.actualPage;
                },
                async paginate() {
                    emitter.emit("gridandfilter_paginate", {
                        page: this.page
                    });
                }

                // changeSort(sort) {
                //     this.sortOption = sort;
                //     this.sort();
                // },

                // changeDirection(direction) {
                //     this.sortOrder = direction;
                //     this.sort();
                // },

                // resetSort() {
                //     this.sortOption = this.onLoadsortOption;
                //     this.sortOrder  = this.onLoadsortOrder;
                // },

            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

    </script>

<?= $el->end(); ?>