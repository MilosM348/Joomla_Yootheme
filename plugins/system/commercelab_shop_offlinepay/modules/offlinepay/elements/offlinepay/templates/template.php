<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$id = uniqid('yps_offlinepay');

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
    <script id="yps_offlinepay_data-buttontext" type="application/json"><?= $props['button_text']; ?></script>
    <script id="yps_offlinepay_data-buttonprocessingtext" type="application/json"><?= $props['button_processing_text']; ?></script>
    <script id="yps_offlinepay_data-buttoncompletetext"  type="application/json"><?= $props['button_complete_text']; ?></script>
    <script id="yps_offlinepay_data-showcompleteicon"  type="application/json"><?= $props['complete_icon']; ?></script>
    <script id="yps_offlinepay_data-completionurl"  type="application/json"><?=  $props['completionurl']; ?></script>


    <div v-cloak id="<?= $id; ?>">
            <!-- :class="{'uk-disabled': !isValidStatus}"  -->
        <button 
            @click="initPayment" 
            class="
                uk-button 
                <?= $props['button_style'] ?> 
                <?= $props['button_size'] ?> 
                <?= ($props['fullwidth'] ? "uk-width-1-1" : "") ?>
            "
            :class="{'uk-disabled': loading}"
        >
            <!-- :style="{'opacity': (!isValidStatus ? '0.6' : 1)}" -->
            <?php if ($props['icon']) : ?>
                <?php if ($props['icon_align'] == 'left') : ?>
                    <span v-show="set" uk-icon="<?= $props['icon'] ?>"></span>
                <?php endif; ?>
            <?php endif; ?>
            
            <span>{{buttontext}}</span>

            <?php if ($props['icon']) : ?>
                <?php if ($props['icon_align'] == 'right') : ?>
                    <span v-show="set" uk-icon="<?= $props['icon'] ?>"></span>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($props['complete_icon']) : ?>
                <span v-show="complete" uk-icon="check"></span>
            <?php endif; ?>
            <div v-show="loading" id="yps-offline-payment-submit-spinner" uk-spinner></div>
        </button>
    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    paymentType: 'Offlinepay',
                    buttontext: '<?= $props['button_text'] ?>',
                    buttonprocessingtext: '',
                    buttoncompletetext: '',
                    set: true,
                    loading: false,
                    complete: false,
                    showcompleteicon: false,
                    completionurl: '',
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
                emitter.on('yps_cart_validation_update', this.setValidationStatus);
            },
            async beforeMount() {

                const buttontext = document.getElementById('yps_offlinepay_data-buttontext');
                this.buttontext  = buttontext.innerText;
                buttontext.remove();

                const buttonprocessingtext = document.getElementById('yps_offlinepay_data-buttonprocessingtext');
                this.buttonprocessingtext  = buttonprocessingtext.innerText;
                buttonprocessingtext.remove();

                const buttoncompletetext = document.getElementById('yps_offlinepay_data-buttoncompletetext');
                this.buttoncompletetext  = buttoncompletetext.innerText;
                buttoncompletetext.remove();

                const showcompleteicon = document.getElementById('yps_offlinepay_data-showcompleteicon');
                this.showcompleteicon  = showcompleteicon.innerText;
                showcompleteicon.remove();

                const completionurl = document.getElementById('yps_offlinepay_data-completionurl');
                this.completionurl  = completionurl.innerText;
                completionurl.remove();

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
                        return true;
                    }
                    else
                    {
                        this.isValidStatus = false;
                        return false;
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
                scrollAndAlert(element)
                {
                    const fixedOffset = (element.closest('.cls-element-container').getBoundingClientRect().top + window.scrollY - 80).toFixed();
                    const onScroll = function () {
                        if (window.pageYOffset.toFixed() === fixedOffset
                            || window.pageYOffset.toFixed() < fixedOffset) {
                            setTimeout(function(element_id) {
                                console.log('scrollAndAlert yps_cart_set_alert', element_id);
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
                        console.info('!this.isValidStatus Offline Payment: ' + this.globalValidationStatus, element);
                        if (element) this.scrollAndAlert(element);
                        return;
                    }

                    this.loading    = true;
                    this.set        = false;
                    this.buttontext = this.buttonprocessingtext;

                    const response = await this.makeACall(
                        {
                            'paymentType':  this.paymentType
                        },
                        '&type=payment.initpayment'
                    );

                    if (response)
                    {
                        this.buttontext = this.buttoncompletetext;
                        this.loading    = false;
                        
                        if (this.showcompleteicon) this.complete = true;
                        if (response.orderid) window.location.href = this.completionurl + '&cls_order_id=' + response.orderid;

                    }
                }
            }
        }


        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

    </script>
<?= $el->end(); ?>