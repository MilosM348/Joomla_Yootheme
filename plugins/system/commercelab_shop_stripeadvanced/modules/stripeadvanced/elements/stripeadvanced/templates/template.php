<?php
/**
 * @package     CommerceLab Shop - Stripe Advanced
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$id = uniqid('yps_stripeadvanced');


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

    <div id="<?= $id; ?>">

        <button class="uk-button 
            <?= $props['button_size'] ?> 
            <?= ($props['fullwidth']) ? 'uk-width-1-1' : '' ?>
            " 
            @click="initPayment"
            :class="{'uk-disabled': loading, '<?= $props['button_style'] ?>': isValidStatus, '<?= $props['button_style_inactive'] ?>': !isValidStatus}"
        >

        <?php if ($props['icon']) : ?>

            <?php if ($props['icon_align'] == 'left') : ?>
                <span class="uk-margin-small-right">
                <?php if ($props['icon'] == 'stripe') : ?>
                    <svg width="<?= $props['icon_width']; ?>" aria-hidden="true" focusable="false" data-prefix="fab"
                         data-icon="stripe"
                         class="svg-inline--fa fa-stripe fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 640 512">
                        <path fill="currentColor"
                              d="M165 144.7l-43.3 9.2-.2 142.4c0 26.3 19.8 43.3 46.1 43.3 14.6 0 25.3-2.7 31.2-5.9v-33.8c-5.7 2.3-33.7 10.5-33.7-15.7V221h33.7v-37.8h-33.7zm89.1 51.6l-2.7-13.1H213v153.2h44.3V233.3c10.5-13.8 28.2-11.1 33.9-9.3v-40.8c-6-2.1-26.7-6-37.1 13.1zm92.3-72.3l-44.6 9.5v36.2l44.6-9.5zM44.9 228.3c0-6.9 5.8-9.6 15.1-9.7 13.5 0 30.7 4.1 44.2 11.4v-41.8c-14.7-5.8-29.4-8.1-44.1-8.1-36 0-60 18.8-60 50.2 0 49.2 67.5 41.2 67.5 62.4 0 8.2-7.1 10.9-17 10.9-14.7 0-33.7-6.1-48.6-14.2v40c16.5 7.1 33.2 10.1 48.5 10.1 36.9 0 62.3-15.8 62.3-47.8 0-52.9-67.9-43.4-67.9-63.4zM640 261.6c0-45.5-22-81.4-64.2-81.4s-67.9 35.9-67.9 81.1c0 53.5 30.3 78.2 73.5 78.2 21.2 0 37.1-4.8 49.2-11.5v-33.4c-12.1 6.1-26 9.8-43.6 9.8-17.3 0-32.5-6.1-34.5-26.9h86.9c.2-2.3.6-11.6.6-15.9zm-87.9-16.8c0-20 12.3-28.4 23.4-28.4 10.9 0 22.5 8.4 22.5 28.4zm-112.9-64.6c-17.4 0-28.6 8.2-34.8 13.9l-2.3-11H363v204.8l44.4-9.4.1-50.2c6.4 4.7 15.9 11.2 31.4 11.2 31.8 0 60.8-23.2 60.8-79.6.1-51.6-29.3-79.7-60.5-79.7zm-10.6 122.5c-10.4 0-16.6-3.8-20.9-8.4l-.3-66c4.6-5.1 11-8.8 21.2-8.8 16.2 0 27.4 18.2 27.4 41.4.1 23.9-10.9 41.8-27.4 41.8zm-126.7 33.7h44.6V183.2h-44.6z"></path>
                    </svg>
                <?php endif ?>
                    <?php if ($props['icon'] == 'stripe-s') : ?>
                        <svg width="<?= $props['icon_width']; ?>" aria-hidden="true" focusable="false" data-prefix="fab"
                             data-icon="stripe-s"
                             class="svg-inline--fa fa-stripe-s fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 384 512">
                        <path fill="currentColor"
                              d="M155.3 154.6c0-22.3 18.6-30.9 48.4-30.9 43.4 0 98.5 13.3 141.9 36.7V26.1C298.3 7.2 251.1 0 203.8 0 88.1 0 11 60.4 11 161.4c0 157.9 216.8 132.3 216.8 200.4 0 26.4-22.9 34.9-54.7 34.9-47.2 0-108.2-19.5-156.1-45.5v128.5a396.09 396.09 0 0 0 156 32.4c118.6 0 200.3-51 200.3-153.6 0-170.2-218-139.7-218-203.9z"></path>
                    </svg>
                    <?php endif ?>
                    <?php if ($props['icon'] == 'cc-stripe') : ?>
                        <svg width="<?= $props['icon_width']; ?>" aria-hidden="true" focusable="false" data-prefix="fab"
                             data-icon="cc-stripe"
                             class="svg-inline--fa fa-cc-stripe fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 576 512">
                        <path fill="currentColor"
                              d="M492.4 220.8c-8.9 0-18.7 6.7-18.7 22.7h36.7c0-16-9.3-22.7-18-22.7zM375 223.4c-8.2 0-13.3 2.9-17 7l.2 52.8c3.5 3.7 8.5 6.7 16.8 6.7 13.1 0 21.9-14.3 21.9-33.4 0-18.6-9-33.2-21.9-33.1zM528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM122.2 281.1c0 25.6-20.3 40.1-49.9 40.3-12.2 0-25.6-2.4-38.8-8.1v-33.9c12 6.4 27.1 11.3 38.9 11.3 7.9 0 13.6-2.1 13.6-8.7 0-17-54-10.6-54-49.9 0-25.2 19.2-40.2 48-40.2 11.8 0 23.5 1.8 35.3 6.5v33.4c-10.8-5.8-24.5-9.1-35.3-9.1-7.5 0-12.1 2.2-12.1 7.7 0 16 54.3 8.4 54.3 50.7zm68.8-56.6h-27V275c0 20.9 22.5 14.4 27 12.6v28.9c-4.7 2.6-13.3 4.7-24.9 4.7-21.1 0-36.9-15.5-36.9-36.5l.2-113.9 34.7-7.4v30.8H191zm74 2.4c-4.5-1.5-18.7-3.6-27.1 7.4v84.4h-35.5V194.2h30.7l2.2 10.5c8.3-15.3 24.9-12.2 29.6-10.5h.1zm44.1 91.8h-35.7V194.2h35.7zm0-142.9l-35.7 7.6v-28.9l35.7-7.6zm74.1 145.5c-12.4 0-20-5.3-25.1-9l-.1 40.2-35.5 7.5V194.2h31.3l1.8 8.8c4.9-4.5 13.9-11.1 27.8-11.1 24.9 0 48.4 22.5 48.4 63.8 0 45.1-23.2 65.5-48.6 65.6zm160.4-51.5h-69.5c1.6 16.6 13.8 21.5 27.6 21.5 14.1 0 25.2-3 34.9-7.9V312c-9.7 5.3-22.4 9.2-39.4 9.2-34.6 0-58.8-21.7-58.8-64.5 0-36.2 20.5-64.9 54.3-64.9 33.7 0 51.3 28.7 51.3 65.1 0 3.5-.3 10.9-.4 12.9z"></path>
                    </svg>
                    <?php endif ?>
                </span>
            <?php endif ?>

            <span class="uk-text-middle"><?= $props['content'] ?></span>

            <?php if ($props['icon_align'] == 'right') : ?>
                <span class="uk-margin-small-left">
                <?php if ($props['icon'] == 'stripe') : ?>
                    <svg aria-hidden="true" focusable="false" data-prefix="fab"
                         data-icon="stripe" class="svg-inline--fa fa-stripe fa-w-20" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:<?= $props['icon_width']; ?>; height: auto !important;">
                        <path fill="currentColor"
                              d="M165 144.7l-43.3 9.2-.2 142.4c0 26.3 19.8 43.3 46.1 43.3 14.6 0 25.3-2.7 31.2-5.9v-33.8c-5.7 2.3-33.7 10.5-33.7-15.7V221h33.7v-37.8h-33.7zm89.1 51.6l-2.7-13.1H213v153.2h44.3V233.3c10.5-13.8 28.2-11.1 33.9-9.3v-40.8c-6-2.1-26.7-6-37.1 13.1zm92.3-72.3l-44.6 9.5v36.2l44.6-9.5zM44.9 228.3c0-6.9 5.8-9.6 15.1-9.7 13.5 0 30.7 4.1 44.2 11.4v-41.8c-14.7-5.8-29.4-8.1-44.1-8.1-36 0-60 18.8-60 50.2 0 49.2 67.5 41.2 67.5 62.4 0 8.2-7.1 10.9-17 10.9-14.7 0-33.7-6.1-48.6-14.2v40c16.5 7.1 33.2 10.1 48.5 10.1 36.9 0 62.3-15.8 62.3-47.8 0-52.9-67.9-43.4-67.9-63.4zM640 261.6c0-45.5-22-81.4-64.2-81.4s-67.9 35.9-67.9 81.1c0 53.5 30.3 78.2 73.5 78.2 21.2 0 37.1-4.8 49.2-11.5v-33.4c-12.1 6.1-26 9.8-43.6 9.8-17.3 0-32.5-6.1-34.5-26.9h86.9c.2-2.3.6-11.6.6-15.9zm-87.9-16.8c0-20 12.3-28.4 23.4-28.4 10.9 0 22.5 8.4 22.5 28.4zm-112.9-64.6c-17.4 0-28.6 8.2-34.8 13.9l-2.3-11H363v204.8l44.4-9.4.1-50.2c6.4 4.7 15.9 11.2 31.4 11.2 31.8 0 60.8-23.2 60.8-79.6.1-51.6-29.3-79.7-60.5-79.7zm-10.6 122.5c-10.4 0-16.6-3.8-20.9-8.4l-.3-66c4.6-5.1 11-8.8 21.2-8.8 16.2 0 27.4 18.2 27.4 41.4.1 23.9-10.9 41.8-27.4 41.8zm-126.7 33.7h44.6V183.2h-44.6z"></path>
                    </svg>
                <?php endif ?>
                    <?php if ($props['icon'] == 'stripe-s') : ?>
                        <svg width="<?= $props['icon_width']; ?>" aria-hidden="true" focusable="false" data-prefix="fab"
                             data-icon="stripe-s" class="svg-inline--fa fa-stripe-s fa-w-12" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path fill="currentColor"
                              d="M155.3 154.6c0-22.3 18.6-30.9 48.4-30.9 43.4 0 98.5 13.3 141.9 36.7V26.1C298.3 7.2 251.1 0 203.8 0 88.1 0 11 60.4 11 161.4c0 157.9 216.8 132.3 216.8 200.4 0 26.4-22.9 34.9-54.7 34.9-47.2 0-108.2-19.5-156.1-45.5v128.5a396.09 396.09 0 0 0 156 32.4c118.6 0 200.3-51 200.3-153.6 0-170.2-218-139.7-218-203.9z"></path>
                    </svg>
                    <?php endif ?>
                    <?php if ($props['icon'] == 'cc-stripe') : ?>
                        <svg width="<?= $props['icon_width']; ?>" aria-hidden="true" focusable="false" data-prefix="fab"
                             data-icon="cc-stripe" class="svg-inline--fa fa-cc-stripe fa-w-18" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path fill="currentColor"
                              d="M492.4 220.8c-8.9 0-18.7 6.7-18.7 22.7h36.7c0-16-9.3-22.7-18-22.7zM375 223.4c-8.2 0-13.3 2.9-17 7l.2 52.8c3.5 3.7 8.5 6.7 16.8 6.7 13.1 0 21.9-14.3 21.9-33.4 0-18.6-9-33.2-21.9-33.1zM528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM122.2 281.1c0 25.6-20.3 40.1-49.9 40.3-12.2 0-25.6-2.4-38.8-8.1v-33.9c12 6.4 27.1 11.3 38.9 11.3 7.9 0 13.6-2.1 13.6-8.7 0-17-54-10.6-54-49.9 0-25.2 19.2-40.2 48-40.2 11.8 0 23.5 1.8 35.3 6.5v33.4c-10.8-5.8-24.5-9.1-35.3-9.1-7.5 0-12.1 2.2-12.1 7.7 0 16 54.3 8.4 54.3 50.7zm68.8-56.6h-27V275c0 20.9 22.5 14.4 27 12.6v28.9c-4.7 2.6-13.3 4.7-24.9 4.7-21.1 0-36.9-15.5-36.9-36.5l.2-113.9 34.7-7.4v30.8H191zm74 2.4c-4.5-1.5-18.7-3.6-27.1 7.4v84.4h-35.5V194.2h30.7l2.2 10.5c8.3-15.3 24.9-12.2 29.6-10.5h.1zm44.1 91.8h-35.7V194.2h35.7zm0-142.9l-35.7 7.6v-28.9l35.7-7.6zm74.1 145.5c-12.4 0-20-5.3-25.1-9l-.1 40.2-35.5 7.5V194.2h31.3l1.8 8.8c4.9-4.5 13.9-11.1 27.8-11.1 24.9 0 48.4 22.5 48.4 63.8 0 45.1-23.2 65.5-48.6 65.6zm160.4-51.5h-69.5c1.6 16.6 13.8 21.5 27.6 21.5 14.1 0 25.2-3 34.9-7.9V312c-9.7 5.3-22.4 9.2-39.4 9.2-34.6 0-58.8-21.7-58.8-64.5 0-36.2 20.5-64.9 54.3-64.9 33.7 0 51.3 28.7 51.3 65.1 0 3.5-.3 10.9-.4 12.9z"></path>
                        </svg>
                    <?php endif ?>
                </span>
            <?php endif ?>

        <?php else : ?>
            <?= $props['content'] ?>
        <?php endif ?>

        </button>

    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {

                    paymentType: 'Stripeadvanced',
                    publishable_key: '<?= $props['publishable_key']; ?>',
                    completionurl: '<?= $props['confirmation'] ?>',
                    set: true,
                    loading: false,
                    complete: false,
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
                emitter.on('yps_cart_validation_update', this.setValidationStatus);
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

                // Validation Methods Accross Checkout Elements
                async setValidationStatus(status) {
                    this.globalValidationStatus = status;
                    this.isValidStatus          = <?= $props['required_status'] ?> <= status;
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

                    const params = {
                        'paymentType':  this.paymentType
                    };

                    const response = await this.makeACall(params , '&type=payment.initpayment');

                    if (response)
                    {
                        const stripe = Stripe(this.publishable_key);
                        stripe.redirectToCheckout({
                            sessionId: response.id
                        });

                    }

                }
            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

    </script>

<?= $el->end(); ?>