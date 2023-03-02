<?php
/**
 * @package     CommerceLab Shop - Grid & Filter
 *
 * @copyright   Copyright (C) 2021 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = uniqid('yps_gridandfilter_result');

$el = $this->el('div');
// htmlspecialchars($props['items'])
?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>">
        <?= $this->render("{$__dir}/layouts/" . $props['layout'], compact('props')) ?>
    </div>

    <script>

        // Joomla_cls.gaf['sort'] = {                    
        //     sortOption: '<?= $node->props['sorted_by'] ?>',
        //     sortOrder: '<?= $node->props['sort_direction'] ?>'
        // };
        // Joomla_cls.gaf['pagination'] = {                    
        //     itemsPerPage: <?= (int) $node->props['items_per_page'] ?>,
        //     totalItems: <?= (int) $node->props['filtered_query']['totalfiltered'] ?>,
        //     actualPage: <?= (int) ($node->props['offset'] + 1) ?>
        // };

        const <?= $id; ?> = {
            data() {
                return {
                    items: <?= json_encode($props['items']) ?>,
                    type_source: <?= json_encode($props['type_source']) ?>,
                    loaded: true,
                    uri_base: Joomla_cls.uri_base,
                    filtered_query: [],
                    queryLoading: false,
                    queryLoading: false,
                    itemsPerPage: <?= (int) $node->props['items_per_page'] ?>,
                    totalItems: <?= (int) $node->props['filtered_query']['totalfiltered'] ?>,
                    totalfiltered: <?= (int) $node->props['filtered_query']['totalfiltered'] ?>,
                    actualPage: <?= (int) ($node->props['offset'] + 1) ?>,
                    onLoadSearchValues: {},
                    onLoadCategories: <?= json_encode($node->props['root_categories']) ?>,
                    onLoadTags: <?= json_encode($node->props['filtered_tags']) ?>,
                    searchValues: {
                        limit: <?= $node->props['items_per_page'] ?>,
                        offset: 0,
                        categories: {},
                        options: {},
                        variants: {},
                        filter_custom_fields: {},
                        tags: {},
                        searchTerms: {},
                        customFieldsSearchTerms: {},
                        priceFrom: null,
                        priceTo: null,
                        orderBy: '<?= $node->props['sorted_by'] ?>',
                        orderDir: '<?= $node->props['sort_direction'] ?>',
                        node: '<?= base64_encode(json_encode($node)) ?>'
                    },
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
            beforeMount() {

                // Store Initial Search Values for reseting
                this.onLoadSearchValues = JSON.parse(JSON.stringify(
                    this.searchValues
                ));
                emitter.on("gridandfilter_update_values", this.updateValues);
                emitter.on("gridandfilter_update_filters", this.updateFilters);
                emitter.on("gridandfilter_perform_query", this.performQuery);
                emitter.on("gridandfilter_reset_all", this.resetAll);
                emitter.on("gridandfilter_sort", this.sort);
                emitter.on("gridandfilter_change_offset", this.paginate);

                emitter.on("gridandfilter_get_sort", this.setSort);
                emitter.on("gridandfilter_get_total", this.setTotal);
                emitter.on("gridandfilter_get_pagination", this.setPagination);

                emitter.on("item_removed_from_cart", this.removeItemFromCart);
            },
            created() {
                // console.log(this.items);
                // console.log(this.type_source);
            },
            mounted() {
                this.setSort();
                this.setTotal();
                this.setPagination();
            },
            methods: {

                async goToLink(link) {
                    window.location = link
                },
                async addToCart(item_id, amount, callback) {
                    var params = {
                        'j_item_id': item_id,
                        'amount': amount
                    };

                    if (Joomla_cls.selectedOptions[item_id]) {
                        params.options = Joomla_cls.selectedOptions[item_id];
                    }

                    if (Joomla_cls.selectedVariants[item_id]) {
                        params.variant = Joomla_cls.selectedVariants[item_id];
                    }

                    const response = await this.makeACall(params , '&type=product.addtocart');

                    // this.loading   = false;
                    if (response)
                    {
                        this.items.forEach(item => {
                            if (item.joomla_item_id == item_id)
                            {
                                item.product.in_cart = item.product.in_cart + amount;
                            }
                        });
                        // first tell all the other Vue instances that we've updated the cart
                        emitter.emit('yps_cart_update');

                        // Show Cart
                        if (callback.action == 'open_cart') {
                            emitter.emit("cls_scroll_and_show_cart", true);
                        }

                        //  Go to Checkout
                        if (callback.action == 'go_to_checkout') {
                            window.location.replace(Joomla_cls.checkoutLink);
                        }


                    } else {
                        UIkit.notification({
                            message: response.message,
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });
                    }

                },
                async removeItemFromCart(cart_item) {
                    this.items.forEach(item => {
                        if (item.joomla_item_id == cart_item)
                        {
                            item.product.in_cart = 0;
                        }
                    });

                },
                yps_gotocheckout() {
                    window.location.replace(this.checkoutLink);
                },
                async setSort() {
                    emitter.emit("gridandfilter_set_sort", {
                        sortOption: '<?= $node->props['sorted_by'] ?>',
                        sortOrder: '<?= $node->props['sort_direction'] ?>'
                    });
                },
                async setTotal() {
                    emitter.emit("gridandfilter_set_total", this.totalItems);
                },
                async setPagination() {
                    emitter.emit("gridandfilter_set_pagination", {
                        itemsPerPage: this.itemsPerPage,
                        totalItems: this.totalItems,
                        totalfiltered: this.totalfiltered,
                        actualPage: this.actualPage
                    });
                },
                async sort(sortOptions) {
                    this.searchValues.orderBy  = sortOptions.sortOption;
                    this.searchValues.orderDir = sortOptions.sortOrder;
                    
                    this.performQuery(); // Do not reset pagination
                },
                async paginate(pagination) {
                    this.searchValues.offset = pagination.offset;
                    this.performQuery(); // Do not reset pagination
                },
                async resetAll() {

                    emitter.emit("gridandfilter_reset_searchbars");
                    emitter.emit("gridandfilter_reset_filters");
                    emitter.emit("gridandfilter_reset_sort");
                    emitter.emit("gridandfilter_reset_sort");

                    this.onLoadSearchValues.categories = [];
                    this.searchValues                  = this.onLoadSearchValues;

                    this.performQuery(true);
                },
                updateFilters(options) {

                    this.searchValues[options.filterType][options.el_id] = (Array.isArray(options.filterValues)) 
                        ? options.filterValues 
                        : [options.filterValues];

                    // remove unchecked/empty filters
                    Object.keys(this.searchValues.categories).forEach(category_block => {
                        if (!this.searchValues.categories[category_block].length)
                        {
                            delete this.searchValues.categories[category_block];
                        }
                    });
                    if (options.performQuery)
                    {
                        this.performQuery(true);
                    }
                },
                updateValues(options) {

                    switch(options.searchTerms)
                    {
                        case 'priceFrom':
                        case 'priceTo':
                            // this.searchValues[options.searchTerms][options.el_id] = options.searchValue;
                            this.searchValues[options.searchTerms] = options.searchValue;
                            break;

                        default:
                            const search_queries = {};
                            Object.values(options.searchTerms).forEach(searchTerm => {
                                search_queries[searchTerm] = options.searchValue;   
                            });

                            if (Object.keys(options.searchTerms).includes('custom_fields'))
                            {
                                // Object.keys(options.searchTerms).forEach(custom_field => {
                                //     console.log(options.searchTerms[custom_field]);
                                // });
                                this.searchValues.customFieldsSearchTerms[options.el_id] = search_queries;
                            }
                            else
                            {
                                this.searchValues.searchTerms[options.el_id] = search_queries;
                            }
                            break;
                    }

                    if (options.performQuery)
                    {
                        this.performQuery(true);
                    }

                },
                async performQuery(resetPagination) {

                    this.queryLoading = true;
                    emitter.emit("gridandfilter_loading", true);

                    if (resetPagination)
                    {
                        this.searchValues.offset = 0;
                    }

                    delete this.searchValues.categories['on_load_categories'];
                    if (!Object.values(this.searchValues.categories).length) // Set Default Category if no category is present
                    {
                        this.searchValues.categories = {};
                        if (this.onLoadCategories.length)
                        {
                            this.searchValues.categories['on_load_categories'] = this.onLoadCategories;
                        }
                    }

                    const response = await this.makeACall(this.searchValues, '&type=product.gridandfilterlist');

                    emitter.emit("gridandfilter_loading", false);
                    this.queryLoading = false;

                    if (response)
                    {
                        this.items = response.render;

                        emitter.emit("gridandfilter_set_total", response.totalfiltered);
                        emitter.emit("gridandfilter_set_pagination", {
                            itemsPerPage: this.itemsPerPage,
                            totalItems: this.totalItems,
                            totalfiltered: response.totalfiltered,
                            actualPage: (this.searchValues.offset / this.itemsPerPage) + 1
                        });

                    } else {
                    }

                },
                async makeACall(params, url) {

                    const send = JSON.parse(JSON.stringify(this.ajax_headers));
                    send.body  = JSON.stringify(params);

                    const request  = await fetch(this.task_url + url, send);
                    const response = await request.json();

                    if (response.success)
                    {
                        return response.data;
                    }
                    else
                    {
                        UIkit.notification({
                            message: response.message,
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });

                        return false;
                    }
                }
            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

    </script>

<?= $el->end(); ?>