<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
use Joomla\CMS\Uri\Uri;

$id = uniqid('yps_tandcs');

$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        '{panel_padding}',
        '{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
    ]

]);


?>
<script id="yps_tandcs_checkbox-baseUrl" type="application/json"><?= Uri::base() ?></script>
<script id="yps_tandcs_checkbox-data" type="application/json"><?= ($props['checked'] ? 'true' : 'false'); ?></script>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>" class="uk-animation-fade uk-animation-fast cls-element-container" data-validation="<?= $node->props['required_status'] ?>">
        
        <div :class="{'uk-text-danger': isAlerted}">
            
            <?php if ($props['leftorright']) : ?>

                <input class="uk-checkbox" type="checkbox" v-model="checked" @change="check($event)"
                    style="width: <?= $props['width']; ?>px; height: <?= $props['height']; ?>px; border-radius: <?= $props['border_radius']; ?>px; ">

            <?php endif; ?>

            <?php if ($props['linktotandcs']) : ?>

                <a target="_blank" href="<?= $props['termsUrl']; ?>">
                    <?php endif; ?>
                    <?= $props['tandcs_text']; ?>
                    <?php if ($props['linktotandcs']) : ?>
                </a>

            <?php endif; ?>

            <?php if (!$props['leftorright']) : ?>

                <input class="uk-checkbox" type="checkbox" v-model="checked" @change="check($event)"
                    style="width: <?= $props['width']; ?>px; height: <?= $props['height']; ?>px; border-radius: <?= $props['border_radius']; ?>px; ">

            <?php endif; ?>
            
        </div>

    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    checked: false,
                    isAlerted: false,
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
            async beforeMount() {
                // set the data from the inline scripts
                const checked = document.getElementById('yps_tandcs_checkbox-data');
                this.checked  = checked.innerText;
                checked.remove();
            },
            mounted() {
                // emitter.on('yps_cart_update', this.validateStatus);
                emitter.on('yps_cart_set_alert', this.setAlert);
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
                setAlert(element_id) {
                    console.log(element_id);
                    if (element_id == '<?= $id; ?>')
                    {
                        this.isAlerted = true;
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
                async getValidationStatus(notify) {

                    const params = {};

                    const response = await this.makeACall(params , '&type=checkout.validationstatus');

                    this.globalValidationStatus = response;
                    if (notify) {
                        emitter.emit("yps_cart_validation_update", response);
                    }
                },
                
                async check(e) {
                    const params = {
                        'state': (this.checked ? 'checked' : 'unchecked'),
                    };

                    const response = await this.makeACall(params , '&type=tandcs.toggle');

                    if (response)
                    {
                        this.getValidationStatus(true);
                    } else {
                        UIkit.notification({
                            message: 'There was an error.',
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });
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
        }
        
        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

    </script>

<?= $el->end(); ?>