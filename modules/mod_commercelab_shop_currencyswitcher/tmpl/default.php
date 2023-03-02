<?php
/**
 * @package     CommerceLab Shop - Currency Switcher
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Currency\Currency;
use CommerceLabShop\Currency\CurrencyFactory;

$id = uniqid('cls_currencyselect');

$currency_list   = CurrencyFactory::getList(0, 0, true);
$active_currency = CurrencyFactory::getCurrent();
$currency_text   = $params->get('currency_text', 'currencysymbol');

?>

<div id="<?= $id; ?>">

    <?php if ($params->get('switcher_style', 'dropdown') == 'dropdown') : ?>
    <div class="uk-form">
        <select @change="switchCurrencyEvent($event)" class="uk-select" v-model="active_currency_id">
        	<?php foreach ($currency_list as $currency) : ?>

                <option value="<?= $currency->id ?>" <?= ($active_currency->id == $currency->id ? 'selected' : ''); ?>>
                    <?= $currency->$currency_text; ?>        
                </option>

        	<?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>

    <?php if ($params->get('switcher_style', 'dropdown') == 'buttons') : ?>
    <div class="uk-button-group">
        <?php foreach (CurrencyFactory::getList(0, 0, true) as $currency) : ?>

            <button @click="active_currency_id = <?= $currency->id; ?>, switchCurrencyButton(<?= $currency->id; ?>)" 
                class="
                    uk-button 
                <?= $params->get('switcher_button_style', 'uk-button-default'); ?>
                <?= $params->get('switcher_button_size', ''); ?>
                "
                :class="{'uk-active': active_currency_id == <?= $currency->id; ?>}"
            >
                <?= $currency->$currency_text; ?>        
            </button>

        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($params->get('switcher_style', 'dropdown') == 'buttons_dropdown') : ?>

    <button class="
        uk-button
        <?= $params->get('switcher_button_style', 'uk-button-default'); ?>
        <?= $params->get('switcher_button_size', ''); ?>
    ">
        <?= $active_currency->$currency_text ?>
    </button>

    <div uk-dropdown="mode: <?= $params->get('buttons_dropdown_showon', 'click'); ?>; pos: <?= $params->get('buttons_dropdown_pos', 'bottom-right'); ?>"
        class="uk-padding-small" style="min-width: 10px;">
        <ul class="uk-nav uk-dropdown-nav">
        <?php $index = 0; foreach (CurrencyFactory::getList(0, 0, true) as $currency) : ?>

            <?php if ($currency->id != $active_currency->id) : ?>
            <li class="<?= ($index != 0) ? 'uk-nav-divider' : '' ?> uk-margin-remove uk-padding-small">
                <a @click="active_currency_id = <?= $currency->id; ?>, switchCurrencyButton(<?= $currency->id; ?>)" 
                    href="javascript:void(0);"
                    class="uk-padding-remove"
                >
                    <?= $currency->$currency_text ?>
                </a>
            </li>
            <?php $index++; endif; ?>

        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

</div>

<script>

    const <?= $id; ?> = {
        data() {
            return {
                currency_list: <?= json_encode($currency_list); ?>,
                active_currency_id: <?= $active_currency->id ?>,
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

            switchCurrencyEvent(event) {
                this.switchCurrency(event.target.value);
            },

            switchCurrencyButton(currency_id) {
                this.switchCurrency(currency_id);
            },

            async switchCurrency(currency_id) {

                const params = {
                    currency_id
                }

                const response = await this.makeACall(params, '&type=currency.switch');

                if (response)
                {
                    location.reload();
                }
            }
            
        }
    }

    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

</script>
