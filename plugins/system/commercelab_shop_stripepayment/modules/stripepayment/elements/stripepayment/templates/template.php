<?php
/**
 * @package     CommerceLab Shop - Stripe Payment
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$id = uniqid('yps_stripepayment');

$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        '{panel_padding}',
        '{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
    ]

]);

?>

<?= $el($props, $attrs) ?>

    <script id="yps_stripe_payment_data-publishable_key" type="application/json"><?= $props['publishable_key']; ?></script>
    <script id="yps_stripe_payment_data-completionurl" type="application/json"><?= $props['confirmation'] ?></script>

    <div id="<?= $id; ?>" >

        {{error}}

        <form id="payment-form" @submit.prevent="initPayment">

            <div class="uk-child-width-1-1" uk-grid>

                <div>
                    <div id="yps_card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                <div>

                    <button class="uk-button 
                        <?= $props['button_style'] ?> 
                        <?= $props['button_size'] ?> 
                        <?= ($props['fullwidth']) ? 'uk-width-1-1' : '' ?>" 
                        :class="{'uk-disabled': loading}">

                        <?php if ($props['icon']) : ?>
                            <?php if ($props['icon_align'] == 'left') : ?>
                                <span id="yps-stripe-payment-submit-icon" class="uk-margin-small-right"> uk-icon="<?= $props['icon'] ?>"></span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <span v-if="set"><?= $props['button_text']; ?></span>
                        <span v-if="loading"><?= $props['button_processing_text']; ?></span>
                        <span v-if="transactionComplete"><?= $props['button_complete_text']; ?></span>
                        <?php if ($props['icon']) : ?>
                            <?php if ($props['icon_align'] == 'right') : ?>
                                <span v-show="!loading" class="uk-margin-small-left" uk-icon="<?= $props['icon'] ?>"></span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <span v-show="loading" class="uk-margin-small-left" style=" width: 15px; height: 15px;" uk-spinner></span>
                    </button>
                </div>

            </div>

        </form>
    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    paymentType: 'Stripepayment',
                    stripe: '',
                    elements: '',
                    card: '',
                    publishable_key: '',
                    completionurl: '',
                    set: true,
                    loading: false,
                    transactionComplete: false,
                    error: '',
                    isValidButton: false,
                    isValidStatus: <?= $props['isValidStatus'] ? 'true' : 'false' ?>,
                    globalValidationStatus: <?= $props['globalValidationStatus'] ?>,
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
            created() {
                // emitter.on("yps_cart_update", this.validateStatus);

            },
            async beforeMount() {

                const completionurl = document.getElementById('yps_stripe_payment_data-completionurl');
                this.completionurl = completionurl.innerText;

                const publishable_key = document.getElementById('yps_stripe_payment_data-publishable_key');

                this.publishable_key = publishable_key.innerText;

                this.stripe = Stripe(this.publishable_key, {
                    locale: '<?= $props['locale']; ?>'
                });
                this.elements = this.stripe.elements();
                this.card     = undefined;
            },
            mounted: function () {

                emitter.on('yps_cart_validation_update', this.setValidationStatus);

                var style = {
                    base: {
                        color: '#32325d',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };

                this.card = this.elements.create(
                    'card', 
                    {
                        style: style,
                        disabled: <?= !$props['isValidStatus'] ? 'true' : 'false' ?>
                    }
                );

                this.card.mount('#yps_card-element');
                this.card.on('change', this.stripeChaged);
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

                stripeChaged(event) {
                    if (event.complete) {
                        this.isValidButton = true;
                    } else {
                        this.isValidButton = false;
                    }
                    if (event.error) {
                        this.error = event.error.message;
                    } else {
                        this.error = '';
                    }
                },
                // Validation Methods Accross Checkout Elements
                async setValidationStatus(status) {
                    this.globalValidationStatus = status;
                    this.isValidStatus          = <?= $props['required_status'] ?> <= status;
                    if (!this.isValidStatus) {
                        this.card.update({ disabled: true });
                    } else {
                        this.card.update({ disabled: false });
                    }
                },

                // Validates it's own Validation Status
                async validateStatus() {

                    const params = {
                        'required_status': <?= $props['required_status'] ?>
                    };

                    const response = await this.makeACall(params , '&type=checkout.validatestatus');

                    if (response)
                    {
                        this.isValidStatus = true;
                    } else {
                        this.isValidStatus = false;
                    }
                },

                // get Updated Global Validation Status
                async getValidationStatus() {

                    const params = {};

                    const response = await this.makeACall(params , '&type=checkout.validationstatus');

                    this.loading                = false;
                    this.globalValidationStatus = response;
                    return this.globalValidationStatus;
                },
                scrollAndAlert(element) {
                    const fixedOffset = (element.closest('.cls-element-container').getBoundingClientRect().top + window.scrollY - 80).toFixed();
                    const onScroll = function () {
                        if (window.pageYOffset.toFixed() === fixedOffset
                            || window.pageYOffset.toFixed() < fixedOffset) {
                            window.removeEventListener('scroll', onScroll);
                                setTimeout(function(element_id) {
                                    emitter.emit("yps_cart_set_alert", element_id);
                                }, 300, element.id);
                        }
                    }

                    window.addEventListener('scroll', onScroll);
                    onScroll();
                    window.scrollTo({
                        top: fixedOffset,
                        behavior: 'smooth'
                    });
                },
                async initPayment() {

                    if (!this.isValidStatus) {
                        const element = document.querySelector('[data-validation="' + this.globalValidationStatus + '"]');
                        if (element) {
                            this.scrollAndAlert(element);
                        }
                        return;
                    }

                    this.loading = true;
                    this.set     = false;

                    const stripeTransaction = await this.stripe.createToken(this.card);

                    if (stripeTransaction.error) {
                        this.error = stripeTransaction.error.message;
                        this.set     = true;
                        this.loading = false;

                    } else {

                        const params = {
                            'paymentType':  this.paymentType,
                            'stripeToken': stripeTransaction.token.id
                        };

                        const response = await this.makeACall(params, '&type=payment.initpayment');
                        this.loading = false;

                        console.log(response);
                        if (response.status == 'succeeded')
                        {

                            UIkit.notification({
                                message: 'Order Successfully Completed',
                                status: 'success',
                                pos: 'top-center',
                                timeout: 5000
                            });
                            this.transactionComplete = true;

                            if (response.description) {
                                window.location.href = this.completionurl + '&cls_order_id=' + response.description;
                            }

                        }
                    }
                }
            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

    </script>


    <style>
        /**
     * The CSS shown here will not be introduced in the Quickstart guide, but shows
     * how you can use CSS to style your Element's container.
     */
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
    
<?= $el->end(); ?>