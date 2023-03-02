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

use CommerceLabShop\Language\LanguageFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Render\Render;

/** @var $props array */
/** @var $attrs array */


LanguageFactory::load();

$id = uniqid('yps_cartitems_grid');

?>

<style type="text/css">
    .hover-tab:hover {
        text-decoration: none;
    }
</style>

<div id="<?= $id; ?>">

	<?php if (!empty($props['cartItems'])) : ?>

        <div v-for="item in cartItems" class="uk-animation-fade" v-cloak
             style="overflow:hidden;transition:height 0.3s ease-out;height:auto;">

            <div class="uk-position-relative uk-float-right">
                <span uk-tooltip="<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTITEMS_REMOVE_FROM_CART'); ?>"
                    @click="remove(item.id, item.cart_id)"
                    style="cursor: pointer"
                >
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="times-circle"
                        width="20px"
                        class="svg-inline--fa fa-times-circle fa-w-16" role="img"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                    >
                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 464c-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216 0 118.7-96.1 216-216 216zm94.8-285.3L281.5 256l69.3 69.3c4.7 4.7 4.7 12.3 0 17l-8.5 8.5c-4.7 4.7-12.3 4.7-17 0L256 281.5l-69.3 69.3c-4.7 4.7-12.3 4.7-17 0l-8.5-8.5c-4.7-4.7-4.7-12.3 0-17l69.3-69.3-69.3-69.3c-4.7-4.7-4.7-12.3 0-17l8.5-8.5c4.7-4.7 12.3-4.7 17 0l69.3 69.3 69.3-69.3c4.7-4.7 12.3-4.7 17 0l8.5 8.5c4.6 4.7 4.6 12.3 0 17z"></path>
                    </svg>
                </span>
            </div>

            <div class="uk-grid-margin uk-margin" uk-grid>
                <div class="uk-width-auto">
                    <div class="uk-margin">
                        <a :href="item.product.link">
                            <div 
                                class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
                                :style="{'background-image':'url('+item.product.teaserImagePath+')', 'width': '80px', 'height': '80px'}"
                            ></div>
                        </a>
                    </div>
                </div>

                <div class="uk-width-expand">
                    <a :href="item.product.link">
                        <h4 class="uk-h4 uk-margin-remove">
                            {{item.product.joomlaItem.title}} x {{item.amount}}
                        </h4>
                    </a>

                    <?php if ($props['include_tax']) : ?>
                        <h5 class="uk-h5 uk-margin-remove">
                            {{item.total_bought_at_price_formattedWithTax}}
                        </h5>
                    <?php else : ?>
                        <h5 class="uk-h5 uk-margin-remove">
                            {{item.total_bought_at_price_formattedWithoutTax}}
                        </h5>
                    <?php endif; ?>

                    <ul class="uk-list uk-list-collapse uk-margin-remove">
                        <li v-if="item.listedVariants && item.listedVariants.length" v-for="variant in item.listedVariants">
                            <span class="uk-h6">
                                {{ variant.name }}: 
                                <span class="uk-text-bold">
                                    {{variant.label}}
                                </span>
                            </span>
                        </li>
                    </ul>

                    <ul class="uk-list uk-list-collapse uk-margin-remove">
                        <li v-for="selected_option in item.selected_options">
                            <span class="uk-h6">
                                {{selected_option.option_name}}:
                                <span class="uk-text-bold">
                                    {{selected_option.modifier_value_translated}}
                                </span>
                            </span>
                        </li>
                    </ul>
                    
                    <!-- Render Shop Picker -->
                    <?php if (Utilities::isPluginActive('system', 'commercelab_shop_shops')) : ?>
                        <?= Render::render(JPATH_PLUGINS . '/commercelab_shop_extended/shops/layouts/shoppicker.php', []); ?>
                    <?php endif; ?>

                </div>

            </div>
			<?php if (count($props['cartItems']) > 1) : ?>
                <hr class="uk-divider-icon">
			<?php endif; ?>
        </div>


	<?php endif; ?>
</div>

<script>


    const <?= $id; ?> = {

        data() {
            return {
                cartItems: <?= json_encode($props['cartItems']); ?>,
                COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART: '<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CARTITEMS_ALERT_REMOVE_ALL_FROM_CART'); ?>',
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
            async fetchCartItems() {

                const response = await this.makeACall({}, '&type=cart.update');

                if (response)
                {
                    this.cartItems = response.cartItems;
                } else {
                    UIkit.notification({
                        message: 'There was an error.',
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
            getNextFiveDays(pickuptimes) {

                const new_pickups_list   = [];

                let corelative_day_index = 0,
                    i = 0;

                do {

                    pickuptimes.forEach(day => {
                        corelative_day_index++;
                        if (day.workingday && day.timeslots.length)
                        {
                            day.date = this.getDate(pickuptimes[0].start_date.date, corelative_day_index);
                            new_pickups_list.push(day);
                            i++;
                        }
                    });
                    
                } while (i < 5);


                console.log(new_pickups_list);

                return new_pickups_list;
            },
            getDate(date, index) {

                const dateObject = new Date(date);
                const nextDate   = new Date(dateObject.getTime() + (86400000 * (index + 1)));
                console.log(dateObject, index, nextDate);

                return nextDate.toLocaleDateString('pe-PE');
            },
            choosePickupTimeslot() {
                console.log('choosePickupTimeslot');
            },
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
            }
        }
    }
    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

</script>
