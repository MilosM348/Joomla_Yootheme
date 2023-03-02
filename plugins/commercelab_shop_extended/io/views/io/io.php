<?php
/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

/** @var array $vars */


?>
<div id="p2s_io">
   <!-- <div class="uk-margin-left"> -->
   <div class="uk-grid" uk-grid="">
        <div class="uk-width-3-4">
            <div class="uk-grid uk-margin-bottom" uk-grid="">
                <div class="uk-width-expand">
                    <h1>Import/Export</h1>
                </div>
                <div class="uk-width-auto"></div>
            </div>
        </div>
        <div class="uk-width-1-4">
            <div></div>
        </div>
   </div>
   <div class="uk-text-center">
        <div class="uk-grid uk-child-width-1-1 uk-child-width-1-3@s" uk-grid>
            <div>
                <div :class="[selectedType == 'products' ? 'uk-card uk-card-primary uk-card-body uk-card-small uk-card-hover' : 'uk-card uk-card-default uk-card-body uk-card-small uk-card-hover']"
                   style="cursor: pointer" @click="selectedType = 'products'">
                    <h3 class="uk-h1 uk-margin-remove">
                        <svg width="30px" class="svg-inline--fa fa-boxes" aria-hidden="true"
                            focusable="false"
                            data-prefix="fad"
                            data-icon="boxes" role="img" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 576 512"
                            data-fa-i2svg="">
                                <g class="fa-group">
                                    <path class="fa-secondary" fill="currentColor" d="M480 288v96l-32-21.3-32 21.3v-96zM320 0v96l-32-21.3L256 96V0zM160 288v96l-32-21.3L96 384v-96z"></path>
                                    <path class="fa-primary" fill="currentColor" d="M560 288h-80v96l-32-21.3-32 21.3v-96h-80a16 16 0 0 0-16 16v192a16 16 0 0 0 16 16h224a16 16 0 0 0 16-16V304a16 16 0 0 0-16-16zm-384-64h224a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16h-80v96l-32-21.3L256 96V0h-80a16 16 0 0 0-16 16v192a16 16 0 0 0 16 16zm64 64h-80v96l-32-21.3L96 384v-96H16a16 16 0 0 0-16 16v192a16 16 0 0 0 16 16h224a16 16 0 0 0 16-16V304a16 16 0 0 0-16-16z"></path>
                                </g>
                        </svg>
                        <?= Text::_('COM_COMMERCELAB_SHOP_PRODUCTS_TITLE'); ?>
                    </h3>
                </div>
            </div>
        <div>
            <div @click="selectedType = 'customers'" :class="[selectedType == 'customers' ? 'uk-card uk-card-primary uk-card-body uk-card-small uk-card-hover' : 'uk-card uk-card-default uk-card-body uk-card-small uk-card-hover']" style="cursor: pointer">
                <h3 class="uk-h1 uk-margin-remove">
                    <svg width="30px" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="box-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-box-check">
                        <path _ngcontent-yfu-c67="" fill="currentColor" d="M492.5 133.4L458.9 32.8C452.4 13.2 434.1 0 413.4 0H98.6c-20.7 0-39 13.2-45.5 32.8L2.5 184.6c-1.6 4.9-2.5 10-2.5 15.2V464c0 26.5 21.5 48 48 48h400c106 0 192-86 192-192 0-90.7-63-166.5-147.5-186.6zM272 32h141.4c6.9 0 13 4.4 15.2 10.9l28.5 85.5c-3-.1-6-.5-9.1-.5-56.8 0-107.7 24.8-142.8 64H272V32zM83.4 42.9C85.6 36.4 91.7 32 98.6 32H240v160H33.7L83.4 42.9zM48 480c-8.8 0-16-7.2-16-16V224h249.9c-16.4 28.3-25.9 61-25.9 96 0 66.8 34.2 125.6 86 160H48zm400 0c-88.2 0-160-71.8-160-160s71.8-160 160-160 160 71.8 160 160-71.8 160-160 160zm64.6-221.7c-3.1-3.1-8.1-3.1-11.2 0l-69.9 69.3-30.3-30.6c-3.1-3.1-8.1-3.1-11.2 0l-18.7 18.6c-3.1 3.1-3.1 8.1 0 11.2l54.4 54.9c3.1 3.1 8.1 3.1 11.2 0l94.2-93.5c3.1-3.1 3.1-8.1 0-11.2l-18.5-18.7z"></path>
                    </svg>
                    &nbsp;
                    <?= Text::_('COM_COMMERCELAB_SHOP_ORDERS'); ?>
                </h3>
            </div>
         </div>
         <div>
            <div @click="selectedType = 'orders'" :class="[selectedType == 'orders' ? 'uk-card uk-card-primary uk-card-body uk-card-small uk-card-hover' : 'uk-card uk-card-default uk-card-body uk-card-small uk-card-hover']" style="cursor: pointer">
                <h3 class="uk-h1 uk-margin-remove">
                    <svg width="30px" aria-hidden="true" focusable="false" data-prefix="fad"
                        data-icon="users" role="img" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 640 512" class="svg-inline--fa fa-users">
                        <g class="fa-group">
                            <path fill="currentColor" d="M96 224a64 64 0 1 0-64-64 64.06 64.06 0 0 0 64 64zm480 32h-64a63.81 63.81 0 0 0-45.1 18.6A146.27 146.27 0 0 1 542 384h66a32 32 0 0 0 32-32v-32a64.06 64.06 0 0 0-64-64zm-512 0a64.06 64.06 0 0 0-64 64v32a32 32 0 0 0 32 32h65.9a146.64 146.64 0 0 1 75.2-109.4A63.81 63.81 0 0 0 128 256zm480-32a64 64 0 1 0-64-64 64.06 64.06 0 0 0 64 64z" opacity="0.4" class="fa-secondary"></path>
                            <path fill="currentColor" d="M396.8 288h-8.3a157.53 157.53 0 0 1-68.5 16c-24.6 0-47.6-6-68.5-16h-8.3A115.23 115.23 0 0 0 128 403.2V432a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48v-28.8A115.23 115.23 0 0 0 396.8 288zM320 256a112 112 0 1 0-112-112 111.94 111.94 0 0 0 112 112z" class="fa-primary"></path>
                        </g>
                    </svg>
                    <?= Text::_('COM_COMMERCELAB_SHOP_CUSTOMERS_TITLE'); ?>
                </h3>
            </div>
         </div>
      </div>
   </div>
   <section v-show="selectedType == 'products'">
        <div class="uk-section uk-section-default products-io-section">
            <div class="uk-grid">

                <div class="uk-width-auto@m tabs">
                    <ul class="uk-tab-left" uk-tab="connect: #import-export-selection; animation: uk-animation-fade">
                        <li>
                            <a href="#">
                                <h3 class="uk-margin-remove uk-padding-small">Import</h3>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <h3 class="uk-margin-remove uk-padding-small">Export</h3>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="uk-width-expand@m" style="padding-left: 0;">
                    <ul id="import-export-selection" class="uk-switcher">
                        <li>
                            <!-- IMPORT -->
                            <div class="uk-card uk-card-default uk-margin-bottom">

                                <!-- <div class="uk-card-header">
                                    <h3>Product Import</h3>
                                </div> -->

                                <div class="" uk-grid>

                                    <div class="uk-width-auto@m">
                                        <ul class="uk-tab-left" uk-tab="connect: #import-options; animation: uk-animation-fade uk-height-full">
                                            <li>
                                                <a href="#">
                                                    <h5>
                                                    Joomla Articles
                                                    </h5>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <h5>
                                                        CSV
                                                    </h5>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="uk-width-expand@m" style="border-left: 1px solid #c8c8c8; padding: 0;">
                                        <div class="">

                                            <ul id="import-options" class="uk-switcher">
                                                    
                                                <li>
                                                    <div class="uk-card">
                                                        
                                                        <div class="uk-card-header">
                                                            <h5 class="uk-margin-remove">Import from Joomla Articles</h5>
                                                        </div>

                                                        <div class="uk-card-body">

                                                            

                                                            <?php $select_articles = Route::_('index.php?option=com_content&view=articles&layout=modal&tmpl=component&function=addArticlesForImport&' . Session::getFormToken() . '=1'); ?>
<!--                                                             <div uk-lightbox="" data-type="iframe" id="io-articles-selector" class="uk-width-expand uk-inline-block category-selector">
                                                                <a href="<?= $select_articles ?>" uk-icon="icon: search" class="uk-button uk-button-default">
                                                                    Select the Articles
                                                                </a>
                                                            </div> -->

                                                            <!-- This is the anchor toggling the modal -->
                                                            <!-- <a href="javascript:void(0);" @click="showArticlesModal()"> Select the Articles</a> -->
                                                            <button class="uk-button uk-button-primary" uk-toggle="target:#articles-iframe-modal">
                                                                Select the Articles
                                                            </button>

                                                            <div id="articles-iframe-modal" class="uk-modal-full" uk-modal>
                                                                <div class="uk-modal-dialog uk-height-1-1">
                                                                    <!-- <a href="" class="uk-modal-close uk-close uk-close-alt"></a> -->
                                                                    <div class="uk-modal-header"></div>
                                                                    <div class="uk-modal-body">
                                                                        <iframe id="articles-iframe-modal-document" uk-height-viewport="offset-bottom: 200px" src="<?= $select_articles ?>" frameborder="0" allowfullscreen="" class="uk-lightbox-iframe uk-width-full uk-height-full"></iframe>
                                                                    </div>
                                                                    <div class="uk-modal-footer uk-text-right uk-position-relative">

                                                                        <button type="button" uk-close class="uk-modal-close-full uk-close-large uk-button uk-button-danger uk-button-small uk-margin-right"
                                                                            style="left: 20px; display: inline-block; width: 150px; top: 10px; height: 50px;"
                                                                        >
                                                                            Cancel
                                                                        </button>

                                                                        <button class="uk-button uk-button-primary uk-button-small" @click="getFormResult()">
                                                                            Import Filtered Articles
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </li>

<!--                                                 <li>
                                                    <h3>CSV</h3>
                                                    <div class="uk-margin" uk-margin>
                                                        <h2 class="uk-margin-remove-bottom">Instructions</h2>
                                                        <p>Please supply a CSV file only.</p>
                                                        <a href="<?= \Joomla\CMS\Uri\Uri::root() . '../plugins/commercelab_shop_extended/io/files/pro2store_example_product_import_sheet.csv'; ?>" class="uk-button uk-button-default">
                                                            Example CSV <span uk-icon="icon: cloud-download"></span>
                                                        </a>
                                                        <h5>Import CSV file</h5>
                                                        <div class="p2s-image-upload" uk-form-custom>
                                                            <input type="file" v-model="productFile" multiple @change="importProducts($event)" accept=".csv">
                                                            <button class="uk-button uk-button-secondary uk-button-small" type="button" tabindex="-1">
                                                                <?= Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOAD'); ?> <span uk-icon="icon: upload"></span>
                                                            </button>
                                                        </div>

                                                    </div>
                                                </li> -->

                                            </ul>
                                        </div>

                                    </div>

                                </div>

                                <!-- <div class="uk-card-footer"></div> -->

                           </div>

                        </li>
                        <li>
                            <!-- EXPORT -->
                            <div class="uk-card uk-card-default">
<!--                                 <div class="uk-card-header">
                                    <h3>Product Export</h3>
                                </div> -->
                                <div class="uk-card-body">

                                    <div class="uk-margin" uk-margin>

                                        <h2 class="uk-margin-remove-bottom">
                                            Instructions
                                        </h2>

                                        <p>Please supply a CSV file only.</p>

                                        <a href="<?= \Joomla\CMS\Uri\Uri::root() . '../plugins/commercelab_shop_extended/io/files/pro2store_example_product_import_sheet.csv'; ?>" class="uk-button uk-button-default">
                                            Example CSV <span uk-icon="icon: cloud-download"></span>
                                        </a>
                                        <h5>Import CSV file</h5>

                                        <div class="p2s-image-upload" uk-form-custom>
                                            <input type="file" v-model="productFile" multiple @change="importProducts($event)" accept=".csv">
                                            <button class="uk-button uk-button-secondary uk-button-small" type="button" tabindex="-1">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOAD'); ?> <span uk-icon="icon: upload"></span>
                                            </button>
                                        </div>

                                    </div>

                                </div>
                                <!-- <div class="uk-card-footer"></div> -->
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
   </section>
<!--    <section v-show="selectedType == 'customers'" class="customers-tab-content">
      <h1>Comming Soon</h1>
   </section>
   <section v-show="selectedType == 'orders'" class="orders-tab-content">
      <h1>Comming Soon</h1>
   </section> -->
   <!-- </div> -->


    <div id="import-progress" class="uk-modal-full" uk-modal>
        <div class="uk-modal-dialog uk-height-1-1">
            <!-- <a href="" class="uk-modal-close uk-close uk-close-alt"></a> -->
            <div class="uk-modal-header">Importing, do not close this page</div>
            <div class="uk-modal-body">
                {{ importedItems }} / {{ onStartItemsToImport.length }}
                <progress class="uk-progress" :value="importedItems" :max="onStartItemsToImport.length">{{ (importedItems / onStartItemsToImport.length) * 100 }} %</progress>
            </div>
            <div class="uk-modal-footer uk-text-center">
                <h3 v-if="finishedImport">Done!</h3>
            </div>
        </div>
    </div>
    
</div>

<script>
    const p2s_io = {
        data() {
            return {
                base_url: '',
                form: {
                    orders: 0,
                    customers: 0,
                    products: 0,
                    category: 0
                },
                loading: false,
                finishedImport: false,
                selectedType: 'products',
                productFile: '',
                importedItems: 0,
                itemsToImport: [],
                onStartItemsToImport: [],
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
        mounted() {
            window.importLoop           = this.importLoop;
            window.addArticlesForImport = this.addArticlesForImport;
            window.startImportArticles  = this.startImportArticles;
        },
        computed: {},
        async beforeMount() {

            const base_url = document.getElementById('base_url');
            this.base_url = base_url.innerText;
            base_url.remove();

        },
        methods: {
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
            },
            showArticlesModal() {
                UIkit.modal("#articles-iframe").show();
            },
            addArticlesForImport(article_id, article_name, what) {
                // console.log(article_id, article_name);
                // console.log(what, 'addArticlesForImport');
                // if (articles) {
                //     this.articlesToImport = article;
                // } else {
                //     this.articlesToImport.push(article);
                // }

            },

            importProducts(e) {

                let files = e.target.files;

                [...files].forEach((file) => {

                    let formData = new FormData();
                    formData.append("csv", file, file.name);

                    this.productFile = '';

                    fetch(this.base_url + "index.php?option=com_ajax&group=commercelab_shop_extended&plugin=io&method=post&format=raw&importType=products", {
                        method: 'POST',
                        mode: 'cors',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        redirect: 'follow',
                        referrerPolicy: 'no-referrer',
                        body: formData
                    })
                    .then(response => response.json())
                    .then((response) => {

                        if (response.success) {

                            UIkit.notification({
                                message: '<?= Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL'); ?>',
                                status: 'success',
                                pos: 'bottom-right',
                                timeout: 5000
                            });
                        }


                    });


                });

                UIkit.notification({
                    message: this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL,
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });

            },
            async getFormResult() {

                // Get Form Filter options, in order to get items from Modle
                const form          = document.getElementById('articles-iframe-modal-document').contentWindow.document.getElementById('adminForm');
                const filter_params = Array.from(new FormData(form));

                let params        = {};
                const category_id = [];
                const access      = [];
                const author_id   = [];

                filter_params.forEach(filter_param => {

                    if (filter_param[0].startsWith('filter[')) {

                        const match = filter_param[0].match(/filter\[(.*?)\]/);

                        switch(match[1])
                        {

                            case 'category_id':
                                category_id.push(filter_param[1]);
                                break;

                            case 'access':
                                access.push(filter_param[1]);
                                break;

                            case 'author_id':
                                author_id.push(filter_param[1]);
                                break;

                            default:
                                params[match[1]] = filter_param[1];
                                break;

                        }

                    }

                });

                if (category_id.length) {
                    params['category_id'] = category_id;
                }

                if (access.length) {
                    params['access'] = access;
                }

                if (author_id.length) {
                    params['author_id'] = author_id;
                }

                const response = await this.makeACall(params , '&type=io.filterarticles');

                if (response && response.length)
                {               

                    // Processed Items will be deducted from itemsToImport
                    // onStartItemsToImport will be kept untill process finished in order to have more controll

                    this.itemsToImport = this.onStartItemsToImport = response;

                    UIkit.modal.confirm('You will import ' + response.length + ' articles').then(function() {
                        window.startImportArticles();
                    });

                }

            },
            async importLoop() {


                const index = this.importedItems;
                const params = {
                    article: this.itemsToImport[index]
                };

                const response = await this.makeACall(params , '&type=io.importarticle');

                if (response)
                {
                    this.importedItems = this.importedItems + 1;
                    if ((index + 1) < this.onStartItemsToImport.length)
                    {
                        await this.importLoop();

                    }
                    else
                    {
                        this.finishedImport = true;
                        setTimeout(function() {
                            UIkit.modal("#import-progress").hide();
                        }, 1500);
                    }
                }

            },
            async startImportArticles() {
                UIkit.modal("#import-progress").show();

                this.finishedImport = false;
                this.importLoop();

            }
        },
        components: {
            'p-inputswitch': primevue.inputswitch
        }
    }
    Vue.createApp(p2s_io).mount('#p2s_io');


</script>

