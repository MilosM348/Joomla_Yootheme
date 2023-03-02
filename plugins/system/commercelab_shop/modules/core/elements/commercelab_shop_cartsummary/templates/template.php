<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

/** @var $attrs array */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;

$componentConfig = \CommerceLabShop\Config\ConfigFactory::get();

$id = uniqid('yps_cartsummary');

$language = Factory::getLanguage();
$language->load('com_commercelab_shop', JPATH_ADMINISTRATOR);

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

    <script id="yps-cart-summary-cart" type="application/json"><?= json_encode($props['cart']); ?></script>

    <div id="<?= $id; ?>">
        <ul class="uk-list uk-width-1-1">
            <li>
                <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid" uk-grid="">
                    <div class="uk-width-expand uk-first-column">

                        <span class="el-title uk-display-block uk-leader" uk-leader="fill: .">
                            <span class="uk-leader-fill">
                                <?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_SUBTOTAL'); ?>        
                            </span>
                        </span>

                    </div>
                    <div v-cloak>
                        <?php if ($props['subtotal_tax']) : ?>
                            <div class="uk-h5 uk-margin-remove yps-cartsummary-subtotal">{{cart.subtotalWithTax}}</div>
                        <?php else : ?>
                            <div class="uk-h5 uk-margin-remove yps-cartsummary-subtotal">{{cart.subtotalWithoutTax}}</div>
                        <?php endif; ?>
                    </div>
                </div>


            </li>
    		<?php if ($props['show_shipping']) : ?>
                <li v-if="showShipping">
                    <div class="uk-child-width-auto uk-grid-small uk-flex-bottom" uk-grid>
                        <div class="uk-width-expand uk-first-column">
                            <span class="el-title uk-display-block uk-leader" uk-leader="fill: .">
                                <span class="uk-leader-fill">
                                    <?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_SHIPPING'); ?>        
                                </span>
                            </span>
                        </div>
                        <div>
                            <div v-cloak class="uk-h5 uk-margin-remove yps-cartsummary-totalshipping">
                                <?php if ($props['shipping_tax']) : ?>
                                    {{ cart.totalShippingWithTax_formatted }}
                                <?php else : ?>
                                    {{ cart.totalShippingWithoutTax_formatted }}
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <li id="yps-cartsummary-totaldiscountList" v-if="showDiscount">
                <div class="uk-child-width-auto uk-grid-small uk-flex-bottom" uk-grid>
                    <div class="uk-width-expand uk-first-column">
                        <span class="el-title uk-display-block uk-leader" uk-leader="fill: .">
                            <span class="uk-leader-fill">
                                <?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_DISCOUNTS'); ?>        
                            </span>
                        </span>
                    </div>
                    <div>
                        <div v-cloak class=" uk-h5 uk-margin-remove yps-cartsummary-totaldiscount">
                            {{cart.totalDiscount}}
                        </div>
                    </div>
                </div>
            </li>

            <li id="yps-cartsummary-taxList" v-if="showTax">
                <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid" uk-grid="">
                    <div class="uk-width-expand uk-first-column">
                        <span class="el-title uk-display-block uk-leader" uk-leader="fill: .">
                            <span class="uk-leader-fill">
                                <?php if (trim(ComponentHelper::getParams('com_commercelab_shop')->get('tax_label', 'Tax')) == '') : ?>
                                    <?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_TAX'); ?>        
                                <?php else : ?>
                                    <?= ComponentHelper::getParams('com_commercelab_shop')->get('tax_label', 'Tax'); ?>
                                <?php endif; ?>
                            </span>
                        </span>
                    </div>
                    <div>
                        <div v-cloak class=" uk-h5 uk-margin-remove yps-cartsummary-totaltax">{{cart.tax}}</div>
                    </div>
                </div>
            </li>
            <li>
                <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid" uk-grid="">
                    <div class="uk-width-expand uk-first-column">
                    <span class="el-title uk-display-block uk-leader" uk-leader="fill: .">
                        <span class="uk-leader-fill">
                            <?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTSUMMARY_TOTAL'); ?>
                        </span>
                    </div>
                    <div>
                        <div v-cloak class="uk-h5 uk-margin-remove yps-cartsummary-grandtotal">
                            {{cart.totalWithTax}}
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    cart: <?= json_encode($props['cart']) ?>,
                    hide_zero_discount: <?= $props['hide_zero_discount'] ? 'true' : 'false'; ?>,
                    hide_zero_shipping: <?= $props['hide_zero_shipping'] ? 'true' : 'false'; ?>,
                    hide_zero_tax: <?= $props['hide_zero_tax'] ? 'true' : 'false'; ?>,
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
                console.log(this.cart);
                emitter.on("address_saved", this.yps_recalculateCartSummary);
                emitter.on("yps_cart_update", this.yps_recalculateCartSummary);
            },
            async beforeMount() {
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
                async yps_recalculateCartSummary() {

                    const response = await this.makeACall({}, '&type=cart.update');

                    if (response)
                    {
                        this.cart = response;
                        emitter.emit('total_cart_updated', response.totalWithTax);

                    }
                }
            },
            computed: {
                showDiscount: function () {

                    let show = true;

                    if (this.hide_zero_discount && (parseInt(this.cart.totalDiscountInt) > 0) === false) {
                        show = false;
                    }

                    return show;
                },
                showShipping: function () {

                    let show = true;

                    if (this.hide_zero_shipping && (parseInt(this.cart.totalShipping) > 0) === false) {
                        show = false;
                    }

                    return show;
                },
                showTax: function () {
                    const totalInt = this.cart.tax.replace(/\D/g, '');

                    if (!this.hide_zero_tax) {
                        return true;
                    }

                    if (this.hide_zero_tax && !(totalInt > 0)) {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

    </script>

<?= $el->end(); ?>