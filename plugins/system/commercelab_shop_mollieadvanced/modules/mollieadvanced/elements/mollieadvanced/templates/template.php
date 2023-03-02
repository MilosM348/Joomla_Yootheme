<?php
/**
 * @package     Pro2Store - Add To Cart
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - Pro2Store. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Config\Config;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Utilities\Utilities;

$id = uniqid('yps_mollieadvanced');

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

    <div id="<?= $id; ?>" v-cloak xmlns="http://www.w3.org/1999/html">

        <button class="uk-button uk-button-<?= $props['button_style'] ?> uk-button-<?= $props['button_size'] ?> <?= ($props['fullwidth']) ? "uk-width-1-1" : "" ?>"
            @click="initPayment" 
            :class="{'uk-disabled': loading}"
        >        
            <span v-if="loading" class="uk-margin-small-right" style=" width: 15px; height: 15px;" uk-spinner></span>
            <span v-if="buttonState == 'set'"><?= $props['button_text']; ?></span>
            <span v-if="buttonState == 'processing'"><?= $props['button_processing_text']; ?></span>

        </button>

    </div>

    <script>

        const <?= $id; ?> = {
            data() {
                return {
                    paymentType: 'Mollieadvanced', // NO Spaces
                    buttonState: 'set',
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
            mounted: function () {
                emitter.on('yps_cart_validation_update', this.setValidationStatus);
            },
            async beforeMount() {},
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

                    this.loading     = true;
                    this.buttonState = 'processing';

                    const params = {
                        'paymentType':  this.paymentType
                    };

                    const response = await this.makeACall(params , '&type=payment.initpayment');

                    if (response)
                    {
                        this.buttonState     = 'set';
                        this.loading         = false;

                        window.location.href = response;

                        // window.open(response.data, '_blank', 'location=yes,height=800,width=800,scrollbars=no,status=yes');


                    }


                }
            }
        }


        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

    </script>

<?= $el->end(); ?>