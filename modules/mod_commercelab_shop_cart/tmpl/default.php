<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

/** @var $count */
/** @var $total */
/** @var $cartItems */
/** @var $locale */
/** @var $currency */
/** @var $params */

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Helper\ModuleHelper;

use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Config\ConfigFactory;

$user = UserFactory::getActiveUser();

$id = uniqid('cls_cart_module');

$php_variables                   = [];
$php_variables['cartTotal']      = $total;
$php_variables['cartItemsCount'] = $count; 

// DropDown Combined Params
$drop_params = [
    'boundary: #' . $id . '_cls_cart_module',
    'delay-hide: 100',
    'boundary-align: true',
    'animation: uk-animation-slide-top-small uk-animation-fast',
    'duration: 500',
    'mode: click',
    'pos:' . $params->get('dropdown_pos', 'bottom-right'),
    'offset:' . $params->get('dropdown_offset', 0)
];

// Off-canvas Combined Params
$offcanvas_params = [
    'overlay:' . $params->get('offcanvas_overlay', 'false'),
    'flip:' . $params->get('offcanvas_flip', 'false'),
    'mode:' . $params->get('offcanvas_mode', 'slide'),
    'bg-close:' . $params->get('offcanvas_close_bg', 'true'),
    'esc-close:' . $params->get('offcanvas_close_esc', 'true')
];

// Off-canvas Combined Params
$modal_params = [
    'bg-close:' . $params->get('modal_close_bg', 'true'),
    'esc-close:' . $params->get('modal_close_esc', 'true')
];

// Main Buttn Icon Generation
$button_icon = ($params->get('main_button_icon')) 
    ? (($params->get('main_button_icon') == 'custom') 
        ? $params->get('main_button_custom_icon')
        : $params->get('main_button_icon'))
    : (($params->get('main_button') == 'icon_type')
        ? 'cart'
        : false);

$main_button_classes = ($params->get('main_button') != 'icon_type')
    ? $params->get('main_button_size')
    : '';

$main_button_classes .= ($params->get('main_button') == 'icon_type') 
    ? 'uk-button-link'
    :  (($params->get('main_button_style') != 'custom')
        ? $params->get('main_button_style')
        : '');

?>

<div id="<?= $id; ?>">

    <!-- Cart -->
    <?php if ($params->get('main_display') == 'layout_products') : ?> 

        <div v-if="cartItems" class="uk-width-1-1">
            <?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', $params->get('products_layout', 'Table')); ?>
        </div>

        <!-- No Items -->
        <div v-else class="uk-card-body uk-overflow-auto">
            <h5 class="uk-text-center">
                <!-- <span uk-icon="icon: cart; ratio: 2"></span> -->
                <?= $params->get('empty_cart', 'THERE ARE NO ITEMS IN YOUR CART'); ?>
            </h5>
        </div>

    <?php endif; ?>
    <!-- Cart -->

    <div id="<?= $id; ?>_cls_cart_module" class="uk-inline boundary-align">

        <!-- <button> -->
        <?php if ($params->get('main_display') != 'layout_products') : ?> 

            <!-- Button is a link Only -->
            <?php if ($params->get('main_display') == 'layout_button' && $params->get('main_button_is_link')) : ?>
            <button id="<?= $id; ?>_cls_cart_button"
                class="uk-button <?= $main_button_classes; ?>" 
                @click="(cart_loaded) ? <?= $params->get('main_button_link') ?> : null"
                style="<?= ($params->get('main_button_style') == 'custom') ? 'background-color: ' . $params->get('main_button_custom_style') . '; color: ' . $params->get('main_button_custom_style_text') . '; border: 1px solid transparent;' : ''; ?>">

            <?php else : ?>
            <!-- Button Opens Cart Dropdown, Modal or Offncavas -->
            <button id="<?= $id; ?>_cls_cart_button"
                uk-toggle="target: #<?= $id ?>cart<?= $params->get('show_products_in') ?>"
                class="uk-button <?= $main_button_classes; ?>" 
                style="<?= ($params->get('main_button_style') == 'custom') ? 'background-color: ' . $params->get('main_button_custom_style') . '; color: ' . $params->get('main_button_custom_style_text') . '; border: 1px solid transparent;' : ''; ?>">
                
            <?php endif; ?>
            <span class="uk-display-block">

                <!-- Icon on Left -->

                <?php if ($button_icon && $params->get('main_button_icon_side') == 'left' 
                    || $params->get('main_button') == 'icon_type' && ($params->get('main_button_icon_side') == 'left')) : ?>

                    <span uk-icon="icon: <?= $button_icon ?>; ratio: <?= $params->get('main_button_icon_size') ?>"></span>

                    <?php if ($params->get('main_button') == 'icon_type') : ?>
                    <span style="<?= ($params->get('main_button_style') == 'custom') 
                            ? 'color: ' . $params->get('main_button_icon_badge_text_color', '#ffffff') . ' !important; background: ' . $params->get('main_button_icon_badge_background_color', '#ff0900') . ' !important;' 
                            : '' ?>" 
                        class="uk-badge uk-margin-small-right">
                        <!-- Badge -->
                        <span v-show="!cart_loaded"><?= $count; ?></span>
                        <span v-show="cart_loaded" :class="updatedCart.total" v-cloak>{{ cartItemsCount }}</span>
                    </span>
                    <?php endif; ?>

                <?php endif; ?>

                <!-- Main Text -->

                <!-- Show it on Load -->
                <span class="uk-text-middle uk-display-inline-block">
                    <?php preg_match('/\[(.*?)\]/m', $params->get('main_button_text'), $matches); ?>
                    <span v-show="!cart_loaded"><?= str_replace($matches[0], $php_variables[$matches[1]], $params->get('main_button_text')); ?></span>
                </span>

                <!-- Pure VueJS -->
                <span :class=uk-display-inline-block class="uk-text-middle" v-cloak>
                    <?= preg_replace('/\[(.*?)\]/m', '<span v-show="cart_loaded" :class="updatedCart.total">{{$1}}</span>', $params->get('main_button_text')); ?>
                </span>

                <!-- Main Text -->

                <!-- Icon on Right -->
                <?php if ($button_icon && ($params->get('main_button_icon_side') == 'right') 
                    || $params->get('main_button') == 'icon_type' && ($params->get('main_button_icon_side') == 'right')) : ?>

                    <span class="uk-margin-small-left" uk-icon="icon: <?= $button_icon ?>; ratio: <?= $params->get('main_button_icon_size') ?>"></span>

                    <?php if ($params->get('main_button') == 'icon_type') : ?>

                        <span style="<?= ($params->get('main_button_style') == 'custom') 
                                ? 'color: ' . $params->get('main_button_icon_badge_text_color', '#ffffff') . ' !important; background: ' . $params->get('main_button_icon_badge_background_color', '#ff0900') . ' !important;' 
                                : '' ?>" 
                            class="uk-badge"
                        >

                            <!-- Badge -->
                            <span v-show="!cart_loaded"><?= $count; ?></span>
                            <span v-show="cart_loaded" :class="updatedCart.total" v-cloak>{{ cartItemsCount }}</span>

                        </span>

                    <?php endif; ?>
                    
                <?php endif; ?>

            </span>

        </button>
        <?php endif; ?>
        <!-- </button> -->

        <?php if ($params->get('main_display') == 'layout_button_and_products') : ?> 

            <!-- DropDown -->
            <?php if ($params->get('show_products_in') == 'dropdown') : ?> 
            <div id="<?= $id ?>cartdropdown" uk-dropdown="<?= implode(';', $drop_params) ?>" class="cartdropdown uk-padding-remove"
                    style="background: transparent; color: transparent; box-shadow: none; z-index: 1009;"
                > 

                <div class="uk-card uk-position-relative
                    <?= $params->get('drop_card_width'); ?> 
                    <?= $params->get('dropdown_spacing'); ?> 
                    <?= $params->get('drop_card_corners'); ?> 
                    <?= $params->get('dropdown_shadow'); ?> 
                    <?= $params->get('drop_card_color'); ?> 
                    <?= $params->get('text_colour'); ?>" 
                    style="<?= ($params->get('drop_card_color') == 'custom') 
                        ? 'background-color:' . $params->get('custom_dropdown_bg_color') . ';' . 'color:' . $params->get('custom_dropdown_text_color') . ';' 
                        : '' ?>">

                    <?php if ($params->get('drop_card_close_button', 0)) : ?>
                        <a class="uk-position-absolute uk-position-right uk-display-block uk-padding-small" 
                            style="bottom: unset; z-index: 10;" 
                            id="close-cart-<?= $id ?>" 
                            @click="closeCart(true)" 
                            href="javascript:void(0);" 
                            uk-icon="icon: close">
                        </a>
                    <?php endif; ?>

                    <!-- Heading -->
                    <?php if ($params->get('dropdown_heading', '') != '') : ?>
                        <div v-if="cartItems" class="uk-card-header uk-padding-remove-bottom uk-padding-remove-top uk-padding-remove-left uk-padding-remove-right">

                            <div class="
                                <?= $params->get('dropdown_heading_alignment') ?>
                                <?= $params->get('dropdown_heading_style') ?>
                                <?= $params->get('dropdown_heading_color') ?>
                                <?= $params->get('dropdown_heading_decoration') ?>
                                <?= $params->get('dropdown_heading_fontfamily') ?>
                            ">
                                <?= $params->get('dropdown_heading') ?>
                            </div>

                        </div>
                    <?php elseif ($params->get('drop_card_close_button', 0)) : ?>
                        <div class="">
                            &nbsp;
                        </div>
                    <?php endif; ?>


                    <div class="uk-card-body uk-padding-remove-bottom uk-padding-remove-top" style="padding: 0 40px 0 40px !important;">

                        <div v-if="cartItems">
                            <?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', $params->get('products_layout', 'Table')); ?>
                        </div>

                        <!-- No Items -->
                        <div v-else class="uk-card-body uk-overflow-auto">
                            <h5 class="uk-text-center">
                                <!-- <span uk-icon="icon: cart; ratio: 2"></span> -->
                                <?= $params->get('empty_cart', 'THERE ARE NO ITEMS IN YOUR CART'); ?>
                            </h5>
                        </div>

                    </div>

                    <?php if ($params->get('buttons_products_list') > 0) : ?> 
                    <div v-if="cartItems" class="uk-card-footer uk-padding-small">
                        <?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', 'BottomButtons'); ?>
                    </div>
                    <?php endif; ?>

                </div>

            </div>
            <?php endif; ?>

            <!-- Modal -->
            <?php if ($params->get('show_products_in') == 'modal') : ?> 
            <div id="<?= $id ?>cartmodal" class="<?= $params->get('modal_center'); ?> <?= $params->get('modal_container'); ?>" uk-modal="<?= implode(';', $modal_params) ?>">
                <div class="uk-modal-dialog <?= ($params->get('modal_center') != '') ? 'uk-margin-auto-vertical' : '' ?>">

                    <?php if ($params->get('modal_close')) : ?>
                    <button class="<?= $params->get('modal_close_position'); ?>" type="button" uk-close></button>
                    <?php endif; ?>

                    <!-- Heading -->
                    <?php if ($params->get('modal_heading', '') != '') : ?>
                    <div class="uk-modal-header">
                        <div class="
                            <?= $params->get('modal_heading_alignment') ?>
                            <?= $params->get('modal_heading_style') ?>
                            <?= $params->get('modal_heading_color') ?>
                            <?= $params->get('modal_heading_decoration') ?>
                            <?= $params->get('modal_heading_fontfamily') ?>
                        ">
                            <?= $params->get('modal_heading') ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="uk-modal-body">

                        <div v-if="cartItems">
                            <?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', $params->get('products_layout', 'Table')); ?>
                        </div>

                        <!-- No Items -->
                        <div v-else class="uk-card-body uk-overflow-auto">
                            <h5 class="uk-text-center">
                                <!-- <span uk-icon="icon: cart; ratio: 2"></span> -->
                                <?= $params->get('empty_cart', 'THERE ARE NO ITEMS IN YOUR CART'); ?>
                            </h5>
                        </div>

                    </div>

                    <?php if ($params->get('buttons_products_list') > 0) : ?> 
                    <div v-if="cartItems" class="uk-modal-footer">
                        <?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', 'BottomButtons'); ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endif; ?>

            <!-- Off-canvas -->
            <?php if ($params->get('show_products_in') == 'offcanvas') : ?> 
            <div id="<?= $id ?>cartoffcanvas" uk-offcanvas="<?= implode(';', $offcanvas_params) ?>">
                <div class="uk-offcanvas-bar">

                    <?php if ($params->get('offcanvas_close_button', 1)) : ?> 
                    <button class="uk-offcanvas-close" type="button" uk-close></button>
                    <?php endif; ?>

                    <!-- Heading -->
                    <?php if ($params->get('offcanvas_heading', '') != '') : ?>
                        <div class="
                            <?= $params->get('offcanvas_heading_alignment') ?>
                            <?= $params->get('offcanvas_heading_style') ?>
                            <?= $params->get('offcanvas_heading_color') ?>
                            <?= $params->get('offcanvas_heading_decoration') ?>
                            <?= $params->get('offcanvas_heading_fontfamily') ?>
                        ">
                            <?= $params->get('offcanvas_heading') ?>
                        </div>
                    <?php endif; ?>

                    <div v-if="cartItems" class="uk-margin-small-bottom">
                        <?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', 'OffcanvasTable'); ?>
                    </div>

                    <!-- No Items -->
                    <div v-else class="uk-card-body uk-overflow-auto">
                        <h5 class="uk-text-center">
                            <!-- <span uk-icon="icon: cart; ratio: 2"></span> -->
                            <?= $params->get('empty_cart', 'THERE ARE NO ITEMS IN YOUR CART'); ?>
                        </h5>
                    </div>

                    <?php if ($params->get('buttons_products_list') > 0) : ?> 
                        <div v-if="cartItems">
                            <?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_cart', 'BottomButtons'); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</div>

<script>
    const <?= $id; ?> = {
        data() {
            return {
                isVisibleCart: document.getElementById('<?= $id ?>').offsetParent !== null,
                updatedCart: [],
                cartItemsCount: <?= $count; ?>,
                cartTotal: '<?= $total; ?>',
                cartItems: <?= json_encode($cartItems); ?>,
                activeUser: <?= json_encode($user); ?>,
                locale: '<?= $locale ?>',
                iso: '<?= $currency->iso ?>',
                cartType: '<?= $params->get('show_products_in') ?>',
                cartOpened: false,
                cart_loaded: true,
                loading: [],
                COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART: '<?= addslashes(Text::_('COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART')); ?>',
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

            addEventListener('resize', (event) => {
                this.isVisibleCart = document.getElementById('<?= $id ?>').offsetParent !== null
            });

            this.updatedCart.total = '';
            this.loading.global    = false;

            window.removeItemFromModuleCart = this.removeItemFromCart;

            // Global Cart Show/Hide
            window.cartOpened   = this.cartOpened;
            window.closeCart    = this.closeCart;
            window.openCart     = this.openCart;
            window.canCloseCart = this.canCloseCart;

            // Listening to events
            emitter.on("yps_cart_update", this.fetchCartItems);
            emitter.on("cls_scroll_and_show_cart", this.openCart);

            <?php if ($params->get('show_products_in') == 'dropdown' && !$params->get('drop_card_close_on_outclik')) : ?>

                UIkit.util.on(document, 'show', '#<?= $id ?>cartdropdown', function(e) {
                    window.canCloseCart = false;
                });

                UIkit.util.on(document, 'beforehide', '#<?= $id ?>cartdropdown', function(e) {
                    if (!window.canCloseCart) {
                        e.preventDefault();
                    }
                });

                UIkit.util.on(document, 'hidden', '#<?= $id ?>cartdropdown', function(e) {
                    window.cartOpened = false;
                });

                UIkit.util.on(document, 'shown', '#<?= $id ?>cartdropdown', function(e) {
                    window.cartOpened  = true;
                });
                
            <?php endif; ?>

            // Open Dropdown on Hover
            <?php if ($params->get('dropshow') == 'hover') : ?>
                document.getElementById("<?= $id; ?>_cls_cart_button").addEventListener('hover', function(e)
                {
                    // Applies only to an open Cart
                    if (window.cartOpened) return;

                    window.openCart();

                }, true);
            <?php endif; ?>

            // Same Button that opens it
            <?php if ($params->get('drop_card_close_on_samebutton')) : ?>
                document.body.addEventListener('click', function(e)
                {
                    // Applies only to an open Cart
                    if (!window.cartOpened) return;

                    e = e || window.event;

                    const target = e.target || e.srcElement;   

                    // Same Button that Opens It
                    <?php if ($params->get('drop_card_close_on_samebutton')) : ?>
                        if (target.id == "<?= $id; ?>_cls_cart_button" 
                            || target.closest("#<?= $id; ?>_cls_cart_button") !== null) {
                                window.closeCart(true);
                        }
                    <?php endif; ?>

                }, true);
            <?php endif; ?>

        },
        methods: {
            async makeACall(params, url) {

                const send = JSON.parse(JSON.stringify(this.ajax_headers));
                send.body  = JSON.stringify(params);

                const request  = await fetch(this.task_url + url, send);
                const response = await request.json();

                if (response.success) return response.data;
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
            closeCart(force)
            {
                if (force) window.canCloseCart = true;
                UIkit[this.cartType]('#<?= $id ?>cart' + this.cartType).hide();
            },
            openCart(afterScrollTo) {

                if (!this.isVisibleCart) return;

                if (afterScrollTo && this.cartType == 'dropdown') {
                    const offset = document.getElementById('<?= $id ?>').getBoundingClientRect().top + window.scrollY;
                    this.scrollAndOpenCart(
                        offset.toFixed()
                    );
                    return;
                }

                // Open Cart
                UIkit[this.cartType]('#<?= $id ?>cart' + this.cartType).show();


            },
            scrollAndOpenCart(fixedOffset) {

                const onScroll = function ()
                {    
                    if (window.pageYOffset.toFixed() === fixedOffset || window.pageYOffset.toFixed() < fixedOffset)
                    {
                        window.removeEventListener('scroll', onScroll);

                        setTimeout(function() {
                            window.openCart();
                        }, 300);

                    }
                }

                window.addEventListener('scroll', onScroll);
                onScroll();

                window.scrollTo({
                    top: fixedOffset,
                    behavior: 'smooth'
                });
            },
            async fetchCartItems(fromCallback) {


                this.updatedCart.total = '';
                this.loading.global    = true;

                const response = await this.makeACall({}, '&type=cart.update');

                if (response)
                {
                    this.updatedCart.total = 'uk-animation-scale-down uk-animation-fast';
                    if (fromCallback) {
                        this.updatedCart['item' + fromCallback.item_id] = 'uk-animation-scale-down uk-animation-fast';
                        this.loading['item' + fromCallback.item_id]     = false;
                    }
                    this.cartItems      = response.cartItems;
                    this.cartItemsCount = response.count;


                    // Taxes
                    <?php if ($params->get('products_with_taxes')) : ?>

                        this.cartTotal = response.subtotalWithTax;

                    <?php else : ?>

                        this.cartTotal = response.subtotalWithoutTax;

                    <?php endif; ?>

                    this.loading.global = false;
                }
            },
            async changeCount(item) {

                this.updatedCart['item' + item.id] = '';
                this.loading['item' + item.id]     = true;

                // make sure we can't go over the stock level
                if (parseInt(item.product.manage_stock) === 1)
                {
                    if (parseInt(item.amount) > parseInt(item.product.stock))
                    {
                        item.amount = item.product.stock;
                    }
                }

                const params = {
                    'cartitemid': item.id,
                    'newcount': item.amount,
                    'itemId': item.joomla_item_id,
                };

                const response = await this.makeACall(params, '&type=cart.changecount');

                if (response)
                {
                    emitter.emit("yps_cart_update", {response: response.data, item_id: item.id});
                }

            },

            serialize(obj) {
                var str = [];
                for (var p in obj)
                {
                    if (obj.hasOwnProperty(p))
                    {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                }
                return str.join("&");
            },

            changeCountDelay(item) {
                if (this.timeout)
                {
                    clearTimeout(this.timeout)
                }
                this.timeout = setTimeout(() => {
                    this.changeCount(item);
                }, 300);
            },

            goToProduct(link) {
                if (link)
                {
                    window.location.replace(link);
                }
            },

            goToCustomLink(link) {
                if (link)
                {
                    window.location.replace(link);
                }
            },

            goToCheckout(){
                window.location.replace('<?= Route::_(ConfigFactory::getSystemRedirectUrls()->checkout->short) ?>');
            },
           
            goToCart(){
                window.location.replace('<?= Route::_(ConfigFactory::getSystemRedirectUrls()->cart->short) ?>');
            },
           
            async removeItemFromCart(uid, cart_id, joomla_id) {

                const response = await this.makeACall({uid, cart_id}, '&type=cart.remove');

                if (response)
                {
                    emitter.emit('yps_cart_update');
                    emitter.emit('item_removed_from_cart', joomla_id);
                }
            },
            async remove(uid, cart_id, joomla_id) {

                <?php if ($params->get('alert_product_removed', 0)) : ?>

                    UIkit.modal.confirm(this.COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART).then(function() {
                        window.removeItemFromModuleCart(uid, cart_id, joomla_id);
                    });

                <?php else : ?>

                    this.removeItemFromCart(uid, cart_id, joomla_id);

                <?php endif; ?>

            },
            itemPrice(bought_at_price, count) {

                const num = (bought_at_price) / 100;

                return num.toLocaleString(this.locale, {
                    style: 'currency', currency: this.iso
                });
            }

        }
    }

    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

</script>

