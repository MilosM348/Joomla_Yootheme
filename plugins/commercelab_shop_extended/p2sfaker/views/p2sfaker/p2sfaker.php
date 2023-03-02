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
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Uri\Uri;
use CommerceLabShop\VueFields\FieldFactory;


$form = $vars['form'];


?>


<script id="base_url" type="application/json"><?= Uri::base(); ?></script>

<div id="p2s_faker">
    <!-- <div class="uk-margin-left"> -->
        <div class="uk-grid" uk-grid="">
            <div class="uk-width-1-1">
                <div class="uk-grid uk-margin-bottom" uk-grid="">
                    <div class="uk-width-expand">

                    </div>
                    <div class="uk-width-auto">

                        <button @click="randomise" type="button"
                                class="uk-button uk-button-primary uk-button-small">Randomise! <span
                                    uk-icon="icon: refresh"></span>
                        </button>
                    </div>
                </div>


                <form @submit.prevent="generate()" v-show="!loading">

					<?= LayoutHelper::render('card', array(
						'form'      => $vars['form'],
						'cardTitle' => 'GENERATE FAKE DATA FOR TESTING',
						'cardStyle' => 'default',
						'cardId'    => 'organisation',
						'fields'    => array('products', 'category', 'customers', 'orders')
					)); ?>

                    <div class="uk-grid" uk-grid="">
                    <div class="uk-width-expand">
                        <button type="submit" class="uk-button uk-button-secondary uk-button-large">Generate!
                        </button>
                    </div>
                    <div class="uk-width-auto">

                    </div>
                    </div>


                </form>
                <div v-show="loading">
                    <i class="fas fa-spinner fa-spin fa-5x"></i>
                </div>


            </div>
            <div class="uk-width-1-4">
                <div>

                </div>
            </div>
        </div>

    <!-- </div> -->
</div>


<script>
    const p2s_faker = {
        data() {
            return {
                base_url: '',
                form: {
                    orders: 0,
                    customers: 0,
                    products: 0,
                    category: 0
                },
                loading: false

            }

        },
        mounted() {

        },
        computed: {},
        async beforeMount() {

            const base_url = document.getElementById('base_url');
            this.base_url = base_url.innerText;
            base_url.remove();


        },
        methods: {

            randomise() {
                this.form.products = this.getRandomInt(15);
                this.form.customers = this.getRandomInt(15);
                this.form.orders = this.getRandomInt(15);

                const select  = document.getElementById('category');

                // fetch all options within the dropdown
                const options = select.children;

                // generate a random number between 0 and the total amount of options
                // the number will always be an index within the bounds of the array (options)
                const random  = Math.floor(Math.random() * options.length);

                // set the value of the dropdown to a random option
                this.form.category = options[random].value;

            },

            async generate() {

                this.loading = true;

                if (this.form.products > 15) {
                    this.form.products = 15;
                }
                if (this.form.orders > 15) {
                    this.form.orders = 15;
                }
                if (this.form.customers > 15) {
                    this.form.customers = 15;
                }

                const request = await fetch(this.base_url + "index.php?option=com_ajax&plugin=p2sfaker&group=commercelab_shop_extended&format=raw", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer',
                    body: JSON.stringify(this.form)
                });


                const response = await request.json();


                if (response.success) {
                    this.loading = false;
                    UIkit.notification({
                        message: 'Generated!',
                        status: 'success',
                        pos: 'top-center',
                        timeout: 5000
                    });
                } else {
                    UIkit.notification({
                        message: 'There was an error.',
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                }


            },
            getRandomInt(max) {
                return Math.floor(Math.random() * max);
            },

        },
        components: {
            'p-inputswitch': primevue.inputswitch
        }
    }
    Vue.createApp(p2s_faker).mount('#p2s_faker');


</script>

