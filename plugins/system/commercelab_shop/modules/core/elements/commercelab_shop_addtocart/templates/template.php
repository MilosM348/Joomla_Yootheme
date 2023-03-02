<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/** @var array $attrs */
/** @var array $props */

$id = uniqid('yps_add_to_cart');

	$el = $this->el('div', [
		'class' => [
			'uk-panel {@!panel_style}',
			'uk-card uk-{panel_style} [uk-card-{panel_size}]',
			'uk-card-body {@panel_style}'
		]
	]);

    $newButton = '<button 
        id="button_' . $id . '" 
        :class="[disableAddToCartButton ? \'uk-disabled\' : \'\']" 
        @click="yps_addtocart" v-show="!hideAddToCartButton" class="uk-button uk-animation-fade uk-animation-fast addtocartag 
        ' . $props['add_to_cart_button_style'] . ' 
        ' . $props['add_to_cart_button_size'] . ' 
        ' . ($props['add_to_cart_button_fullwidth'] ? "uk-width-1-1" : "") . 
    '">';

    $checkoutbutton = '<button 
        v-show="showCheckoutButton" 
         @click="yps_gotocheckout" 
         class="uk-animation-fade uk-animation-fast uk-button 
         ' . $props['checkout_button_style'] . ' 
         ' . $props['checkout_button_size'] . ' 
         ' . ($props['checkout_button_fullwidth'] ? "uk-width-1-1" : "") . 
    '">';

?>
<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>">

        <!-- Out of Stock Message -->
        <span v-show="showOutOfStockMessage">
            <?= '<' . $props['oos_element'] . 
                ' class="' . 
                    $props['oos_style'] . ' ' .
                    $props['oos_decoration'] . ' ' .
                    $props['oos_font_family'] . ' ' .
                    $props['oos_color'] . ' ' .
                    $props['oos_element'] . 
                ' uk-animation-fade uk-animation-fast">' ?>

                    <?php if ($props['oos_color'] == 'uk-text-background') : ?>
                        <span class="uk-text-background"><?= Text::_($props['oos_message']); ?></span>
                    <?php elseif ($props['oos_decoration'] == 'uk-heading-line') : ?>
                        <span><?= Text::_($props['oos_message']); ?></span>
                    <?php else : ?>
                        <?= Text::_($props['oos_message']); ?>
                    <?php endif ?>

            <?= '</' . $props['oos_element'] . '>' ?>
        </span>

		<?= $newButton ?>

    		<?php if ($props['add_to_cart_button_with_icon'] && $props['add_to_cart_button_icon']) : ?>

    			<?php if ($props['add_to_cart_button_icon_align'] == 'left') : ?>
                    <span v-if="!loading" class="uk-margin-small-right" uk-icon="<?= $props['add_to_cart_button_icon'] ?>"></span>
                    <span v-else class="uk-margin-small-right" style=" width: 15px; height: 15px;" uk-spinner></span>
    			<?php endif ?>

                <span class="uk-text-middle"><?= $props['add_to_cart_button_text'] ?></span>

    			<?php if ($props['add_to_cart_button_icon_align'] == 'right') : ?>
                    <span v-if="!loading" class="uk-margin-small-left" uk-icon="<?= $props['add_to_cart_button_icon'] ?>"></span>
                    <span v-else class="uk-margin-small-left" style=" width: 15px; height: 15px;" uk-spinner></span>
    			<?php endif ?>

    		<?php else : ?>
                <span v-if="loading" class="uk-margin-small-right uk-position-absolute" style="width: 15px; height: 15px; top: 50%; left: 10px; margin-top: -7px;" uk-spinner></span>
                <span class="uk-padding-small">   
    			 <?= $props['add_to_cart_button_text'] ?>
                </span>
    		<?php endif ?>

        </button>

        <span v-show="checkout_show" class="<?= ($props['checkout_button_fullwidth'] || $props['add_to_cart_button_fullwidth']) ? 'uk-margin-top uk-display-block' : 'uk-margin-left' ?>">
			<?= $checkoutbutton ?>

    			<?php if ($props['checkout_button_with_icon'] && $props['checkout_button_icon']) : ?>

    				<?php if ($props['checkout_button_icon_align'] == 'left') : ?>
                        <span class="uk-margin-right" uk-icon="<?= $props['checkout_button_icon'] ?>"></span>
    				<?php endif ?>

                    <span class="uk-text-middle"><?= $props['checkout_button_text'] ?></span>

    				<?php if ($props['checkout_button_icon_align'] == 'right') : ?>
                        <span class="uk-margin-left" uk-icon="<?= $props['checkout_button_icon'] ?>"></span>
    				<?php endif ?>

    			<?php else : ?>
    				<?= $props['checkout_button_text'] ?>
    			<?php endif ?>

            </button>
        </span>
    </div>

</div>


<script>
    const <?= $id; ?> = {
        data() {
            return {
                item_id: <?= $props['item_id']; ?>,
                productInCart: <?= $props['product_in_cart']; ?>,
                amount_in_cart: <?= $props['amount_in_cart']; ?>,
                oos_message_behavioir: '<?= $props['oos_message_behavioir']; ?>',
                oos_button_behavioir: '<?= $props['oos_button_behavioir']; ?>',
                selectedOptions: [],
                selectedVariant: null,
                showCheckoutButton: false,
                loading: false,
                amount: 1,
                direct_to_checkout: '<?= $props['after_add_to_cart_behaviour'] == 'go_to_checkout'; ?>',
                checkoutLink: '<?= $props['checkoutlink']; ?>',
                checkout_show: <?= ($props['after_add_to_cart_behaviour'] == 'show_checkout_button' ? 'true' : 'false'); ?>,
                go_to_dropdown: <?= ($props['after_add_to_cart_behaviour'] == 'go_to_dropdown' ? 'true' : 'false'); ?>,
                show_alert: <?= ($props['after_add_to_cart_behaviour'] == 'show_alert' ? 'true' : 'false'); ?>,
                alert_message: '<?= $props['alert_message']; ?>',
                alert_style: '<?= $props['alert_style']; ?>',
                alert_position: '<?= $props['alert_position']; ?>',
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
            emitter.on('yps_cart_update', this.setAmountInCart)
            emitter.on('yps_amountChange' + this.item_id, this.setAmount)
            // emitter.on('yps_optionsChange', this.setSelectedOptions)
            // emitter.on('yps_variantsChange', this.setSelectedVariant)
        },
        mounted() {
        },
        computed: {
            disableAddToCartButton() {
                return this.oos_button_behavioir == 'disable' && !this.hasStock;
            },
            hideAddToCartButton() {
                return this.oos_button_behavioir == 'hide' && !this.hasStock;
            },
            showOutOfStockMessage() {
                return (
                    (this.oos_message_behavioir == 'added_to_cart' && !this.hasStock) 
                    || (this.oos_message_behavioir == 'no_real_stock' && !this.productInCart.stock)
                ) && this.productInCart.manage_stock;
            },
            hasStock() {

                if (this.productInCart && this.productInCart.manage_stock) {
                    return (Boolean(this.productInCart.stock - this.amount_in_cart) > 0);
                } else {
                    return true;
                }
            }
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

            setAmountInCart(product) {

                if (!product) {
                    return;
                }

                const productInCart = this.productInCart;
                if (!productInCart.manage_stock) {
                    return;
                }

                // Update value for amount of products in cart, for local stock disponibility calculation
                this.amount_in_cart  = (product.amount_in_cart) ? product.amount_in_cart : 0;
                const amount_in_cart = this.amount_in_cart;

                // Update dynamic content stock
                [].forEach.call(document.getElementsByClassName('stock-in-product-dyncon'), function (element) {
                    element.innerText = productInCart.stock - amount_in_cart;
                    element.className = 'uk-animation-scale-down uk-animation-fast';
                    setTimeout(function(element) {
                        element.className = 'stock-in-product-dyncon';
                    }, 100, element);
                });


            },
            async yps_addtocart() {

                this.loading = true;

                var params = {
                    'j_item_id': this.item_id,
                    'amount': this.amount
                };

                if (Joomla_cls.selectedOptions[this.item_id]) params.options = Joomla_cls.selectedOptions[this.item_id];
                if (Joomla_cls.selectedVariants[this.item_id]) params.variant = Joomla_cls.selectedVariants[this.item_id];
                
                const response = await this.makeACall(params , '&type=product.addtocart');

                this.loading = false;

                if (response)
                {
                    // first tell all the other Vue instances that we've updated the cart
                    emitter.emit('yps_cart_update');

                    // Show Cart
                    if (this.go_to_dropdown) {
                        emitter.emit("cls_scroll_and_show_cart", true);
                    }

                    if (this.checkout_show) {
                        this.showCheckoutButton = true;
                    }

                    if (this.direct_to_checkout) {
                        window.location.replace(this.checkoutLink);
                    }

                    if (this.show_alert == true) {
                        UIkit.notification({
                            message: this.alert_message,
                            status: this.alert_style,
                            pos: this.alert_position,
                            timeout: 5000
                        });
                    }

                }


            },
            yps_gotocheckout() {
                window.location.replace(this.checkoutLink);
            },
            setAmount(amount) {
                //set the amount
                this.amount = amount;
            },
            // setSelectedOptions() {
            //     if (Joomla_cls.selectedOptions[this.item_id]) this.selectedOptions = Joomla_cls.selectedOptions[this.item_id];
            // },
            // setSelectedVariant() {
            //     if (Joomla_cls.selectedVariants[this.item_id]) this.selectedVariant = Joomla_cls.selectedVariants[this.item_id];

            // }
            // serialize(obj) {
            //     var str = [];

            //     for (var p in obj)
            //         if (obj.hasOwnProperty(p)) str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));

            //     return str.join("&");
            // }

        }
    }

    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

</script>