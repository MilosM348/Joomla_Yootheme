<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

$id = uniqid('yps_couponfield');


$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        '{panel_margin}',
        '{panel_padding}',
        '{panel_color_inverse}'
    ]

]);


?>


<?= $el($props, $attrs) ?>
    <div id="<?= $id; ?>">

        <div v-if="!disableThisElement">
            <div v-if="isCouponApplied">
                <div class="uk-margin yps-coupon-applied">
                    <h5>{{couponapplied}}: {{appliedcouponcode}}</h5>
                    <button class="uk-button uk-button-small" @click="removeCoupon">{{removebuttontext}}</button>
                </div>
            </div>

            <div v-if="!isCouponApplied">
                <div class="uk-margin" uk-margin>
                    <div class="uk-grid uk-grid-small" uk-grid>
                        <div class="uk-width-expand">
                            <input :placeholder="entercouponcode" class="uk-input uk-width-1-1" type="text"
                                   v-model="couponCode">
                        </div>
                        <div>
                            <button @click="applyCoupon" class="uk-button uk-button-default">{{buttontext}}</button>
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
                    baseUrl: '',
                    disableThisElement: false,
                    isCouponApplied: false,
                    appliedcouponcode: '',
                    buttontext: '',
                    removebuttontext: '',
                    couponapplied: '',
                    entercouponcode: '',
                    couponremoved: '',
                    couponCode: '',
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

                // set the data from the inline script

                const isCouponApplied = document.getElementById('yps-coupon-field-isCouponApplied');
                try {
                    this.isCouponApplied = (isCouponApplied.innerText == 'true' ? true : false);
                    isCouponApplied.remove();

                } catch (err) {
                }

                const buttontext = document.getElementById('yps-coupon-field-buttontext');
                try {
                    this.buttontext = buttontext.innerText;
                    buttontext.remove();

                } catch (err) {
                }

                const appliedcouponcode = document.getElementById('yps-coupon-field-appliedcouponcode');
                try {
                    this.appliedcouponcode = appliedcouponcode.innerText;
                    appliedcouponcode.remove();
                } catch (err) {
                }

                const removebuttontext = document.getElementById('yps-coupon-field-removebuttontext');
                try {
                    this.removebuttontext = removebuttontext.innerText;
                    removebuttontext.remove();
                } catch (err) {
                }

                const couponapplied = document.getElementById('yps-coupon-field-couponapplied');
                try {
                    this.couponapplied = couponapplied.innerText;
                    couponapplied.remove();
                } catch (err) {
                }

                const entercouponcode = document.getElementById('yps-coupon-field-entercouponcode');
                try {
                    this.entercouponcode = entercouponcode.innerText;
                    entercouponcode.remove();
                } catch (err) {
                }

                const couponremoved = document.getElementById('yps-coupon-field-couponremoved');
                try {
                    this.couponremoved = couponremoved.innerText;
                    couponremoved.remove();
                } catch (err) {
                }
            },
            created() {
                // emitter.on('yps_cart_validation_update', this.checkElementValidation);

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
                async removeCoupon() {

                    const params = {};

                    const response = await this.makeACall(params , '&type=coupon.remove');

                    if (response)
                    {
                        UIkit.notification({
                            message: '<span uk-icon=\'icon: check\'></span>' + this.couponremoved,
                            status: 'success',
                            pos: 'top-center'
                        });
                        this.isCouponApplied = false;
                        emitter.emit("yps_cart_update")
                    }

                },
                async applyCoupon() {

                    const params = {
                        'couponCode': this.couponCode,
                    };

                    const response = await this.makeACall(params , '&type=coupon.apply');

                    if (response)
                    {
                        UIkit.notification({
                            message: '<span uk-icon=\'icon: check\'></span>' + this.couponapplied,
                            status: 'success',
                            pos: 'top-center'
                        });
                        this.isCouponApplied = true;
                        this.appliedcouponcode = this.couponCode;
                        emitter.emit("yps_cart_update")

                    }

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
        };

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

    </script>
<?= $el->end(); ?>
