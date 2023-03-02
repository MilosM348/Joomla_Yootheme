<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Language\LanguageFactory;


/** @var $props array */
/** @var $attrs array */

LanguageFactory::load();

$id = uniqid('yps_cartitems_table');

$componentParams = ConfigFactory::get();

?>


<?php if (!empty($props['cartItems'])) : ?>
    <div class="uk-overflow-auto" id="<?= $id; ?>">
        <table v-cloak class="uk-table uk-table-middle">
            <tbody>

                <tr v-for="item in cartItems">
                    <td class="uk-table-shrink">
                        <img v-if="isRemotePath(item.product.images.image_intro)"
                            class="uk-preserve-width" alt="" :width="'80'" style="width: 80px" 
                            :src="item.product.images.image_intro"
                        >
                        <img v-else
                            class="uk-preserve-width" alt="" :width="'80'" style="width: 80px" 
                            :src="'<?= $props['baseUrl']; ?>' + item.product.images.image_intro"
                        >
                    </td>
                    <td class="uk-table-expand">

                        <h4 class="uk-margin-small">{{item.product.joomlaItem.title}}</h4>
                        <ul class="uk-list uk-margin-remove uk-list-collapse">
                            <li v-if="item.selected_variant">
                                <span class="uk-h6">
                                    {{ item.product.variants[0].name }}: 
                                </span>
                                {{item.selected_variant.labels_csv}}
                            </li>
                            <li v-for="selected_option in item.selected_options">
                                <span class="uk-h6">
                                    {{selected_option.option_name}}:
                                </span>
                                {{selected_option.modifier_value_translated}}
                            </li>
                        </ul>
                    
                    </td>
                    <td class="uk-table-shrink">

                        <?php if ($props['include_tax']) : ?>
                            <h5 class="uk-h5 uk-margin-bottom">
                                <span v-if="!loading">
                                    {{item.total_bought_at_price_formattedWithTax}}
                                </span>
                                <span uk-spinner="ratio: 0.8" v-if="loading"></span>
                            </h5>
                        <?php else : ?>
                            <h5 class="uk-h5 uk-margin-bottom">
                                <span v-if="!loading">
                                    {{item.total_bought_at_price_formattedWithoutTax}}
                                </span>
                                <span uk-spinner="ratio: 0.8" v-if="loading"></span>
                            </h5>
                        <?php endif; ?>
                        
                        <input @input="changeCountDelay(item)" v-model="item.amount" class="uk-input" style="width: 70px;"
                            min="0"
                            :max="(parseInt(item.product.manage_stock) === 1 ? item.product.stock : '')"
                            type="number"
                        >
                    </td>


                    <td class="uk-table-shrink uk-text-nowrap uk-text-right"><span
                        @click="remove(item.id, item.cart_id)" uk-icon="icon: trash"
                        style="width: 20px; cursor: pointer"></span>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
<?php endif; ?>

<script>

    const <?= $id; ?> = {
        data() {
            return {
                cartItems: <?= json_encode($props['cartItems']); ?>,
                COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART: '<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART'); ?>',
                loading: false,
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
            window.removeItemFromCart = this.removeItemFromCart;
            console.log(this.cartItems, 'cartItems');
        },
        created() {
            emitter.on("yps_cart_update", this.fetchCartItems);
            emitter.on("yps_product_update", this.fetchCartItems);
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
            isRemotePath(path) {

                let url;

                try {

                    url = new URL(path);

                } catch (_) {

                    return false;  
                }

                return url.protocol === "http:" || url.protocol === "https:";
            
            },
            async changeCount(item) {

                // make sure we can't go over the stock level
                if (parseInt(item.product.manage_stock) === 1) {
                    if (parseInt(item.amount) > parseInt(item.product.stock)) {
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
                    emitter.emit("yps_cart_update");
                } else {
                    UIkit.notification({
                        message: 'There was an error updating the amount.',
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                }

            },
            async fetchCartItems() {

                const response = await this.makeACall({}, '&type=cart.update');

                if (response)
                {
                    this.cartItems = response.cartItems;
                    this.loading   = false;

                } else {
                    UIkit.notification({
                        message: 'There was an error fetching the items.',
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                }

            },
            async removeItemFromCart(uid, cart_id) {

                const response = await this.makeACall({uid, cart_id}, '&type=cart.remove');

                if (response)
                {
                    emitter.emit('yps_cart_update');
                }
            },
            async remove(uid, cart_id) {

                UIkit.modal.confirm(this.COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART).then(function() {
                    window.removeItemFromCart(uid, cart_id);
                });

            },
            changeCountDelay(item) {

                this.loading = true;

                if (this.timeout) {
                    clearTimeout(this.timeout)
                }
                this.timeout = setTimeout(() => {
                    this.changeCount(item);
                }, 750);
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
    }
    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

</script>

