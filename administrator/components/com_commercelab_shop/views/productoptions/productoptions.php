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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var array $vars */

?>

<script id="base_url" type="application/json"><?= Uri::base(); ?></script>
<script id="items_data" type="application/json"><?= json_encode($vars['items']); ?></script>
<script id="page_size" type="application/json"><?= $vars['list_limit']; ?></script>

<div id="p2s_productoptions">
    <div class="uk-margin-left">
        <div class="uk-grid" uk-grid="">
            <div class="uk-width-3-4">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-expand">
                                <h3>
                                    <svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="ballot-check" class="svg-inline--fa fa-ballot-check fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M112 432h32c17.7 0 32-14.4 32-32v-32c0-17.6-14.3-32-32-32h-32c-17.7 0-32 14.4-32 32v32c0 17.6 14.3 32 32 32zm0-64h32v32h-32v-32zm0-192h32c17.7 0 32-14.4 32-32v-32c0-17.6-14.3-32-32-32h-32c-17.7 0-32 14.4-32 32v32c0 17.6 14.3 32 32 32zm0-64h32v32h-32v-32zM416 0H32C14.3 0 0 14.4 0 32v448c0 17.6 14.3 32 32 32h384c17.7 0 32-14.4 32-32V32c0-17.6-14.3-32-32-32zm0 480H32V32h384v448zM216 144h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0 128h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0 128h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm-97.4-113.6c2.1 2.1 5.5 2.1 7.6 0l64.2-63.6c2.1-2.1 2.1-5.5 0-7.6l-12.6-12.7c-2.1-2.1-5.5-2.1-7.6 0l-47.6 47.2-20.6-20.9c-2.1-2.1-5.5-2.1-7.6 0l-12.7 12.6c-2.1 2.1-2.1 5.5 0 7.6l36.9 37.4z"></path>
                                    </svg>
                                    &nbsp; <?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TITLE'); ?></h3>
                            </div>
                            <div class="uk-width-auto uk-text-right">
                                <div class="uk-grid uk-grid-small" uk-grid="">
                                    <div class="uk-width-auto">
                                        <input  @input="doTextSearch($event)" type="text" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
                                    </div>
                                    <div class="uk-width-auto">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-body">

                        <table class="uk-table uk-table-striped uk-table-divider uk-table-hover uk-table-responsive  uk-table-middle">
                            <thead>
                            <tr>

                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TABLE_NAME'); ?>
                                    <a href="#" @click="sort('name')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left uk-table-expand"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TABLE_TYPE'); ?>
                                    <a href="#" @click="sort('option_type')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-width-small">
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr class="el-item" v-for="item in itemsChunked[currentPage]">

                                <td>
                                    <div>{{item.name}}</div>
                                </td>
                                <td>
                                    <div>{{item.option_type}}</div>
                                </td>
                                <td class="uk-text-right">
                                    <ul class="uk-iconnav">
                                        <li>
                                            <a><span uk-icon="icon: pencil"></span></a>
                                        </li>
                                        <li>
                                            <a><span uk-icon="icon: trash"></span></a>
                                        </li>
                                    </ul>
                                </td>


                            </tr>


                            </tbody>

                        </table>


                    </div>
                    <div class="uk-card-footer"></div>
                </div>
            </div>
            <div class="uk-width-1-4">
                <div>
                    <div class="uk-card uk-card-default" uk-sticky="offset: 100">
                        <div class="uk-card-header">
                            <h3>Options</h3>
                        </div>
                        <div class="uk-card-body">
                            <button @click="newProduct"
                                    class="uk-button uk-button-primary"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_TITLE'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>

    const <?= $id; ?> = {
        data() {
            return {
                products: <?= json_encode($vars['items']); ?>,
                productsChunked: [],
                categories: <?= json_encode($vars['categories']); ?>,
                selectedCategory: '',
                currentSort: 'title',
                currentSortDir: 'asc',
                currentPage: 0,
                pages: [],
                pagesizes: [5, 10, 20, 30, 50, 100],
                show: 25,
            };
        },
        mounted: function () {
            this.changeShow();
        },
        computed: {},

        methods: {

            async updateList() {
                const request = await fetch("index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=products.updatelist&format=raw&limit=0", {
                    method: 'post'
                });

                const response = await request.json();

                if (response.success) {


                } else {
                    UIkit.notification({
                        message: 'There was an error.',
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                }
            },
            async filter() {

                this.loading = true;

                const params = {
                    'limit': this.show,
                    'offset': (this.currentPage * this.show),
                    'category': this.selectedCategory,
                    'searchTerm': this.enteredText,
                };

                const URLparams = this.serialize(params);

                const request = await fetch('<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=products.filter&format=raw&' + URLparams, {method: 'post'});

                const response = await request.json();

                if (response.success) {
                    this.products = response.data.products;
                    this.loading = false;

                    if (this.products) {
                        this.changeShow();
                    } else {
                        this.productsChunked = [];
                        this.pages = 1;
                        this.currentPage = 0;
                    }
                }

            },
            changeShow() {

                this.productsChunked = this.products.reduce((resultArray, item, index) => {
                    const chunkIndex = Math.floor(index / this.show)
                    if (!resultArray[chunkIndex]) {
                        resultArray[chunkIndex] = []
                    }
                    resultArray[chunkIndex].push(item)
                    return resultArray
                }, []);
                this.pages = this.productsChunked.length;
                this.currentPage = 0;
            },
            changePage(i) {
                this.currentPage = i;
            },
            async doTextSearch(event) {
                this.enteredText = null;
                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => {
                    this.enteredText = event.target.value
                    this.filter();
                }, 600)
            },
            sort(s) {
                //if s == current sort, reverse
                if (s === this.currentSort) {
                    this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
                }
                this.currentSort = s;
                return this.productsChunked[this.currentPage].sort((a, b) => {
                    let modifier = 1;
                    if (this.currentSortDir === 'desc') modifier = -1;
                    if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                });
            },
            serialize(obj) {
                var str = [];
                for (var p in obj)
                    if (obj.hasOwnProperty(p)) {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                return str.join("&");
            }

        }
    }

    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')


</script>
