<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


$id = uniqid('yps_checkoutalerts');

?>

<div id="<?= $id; ?>" v-cloak>

    <div v-show="!checkout_status" class="<?= $props['alert_style']; ?> uk-width-1-1" uk-alert>

        <?php if ($props['allow_close_alert']) : ?>
            <a class="uk-alert-close" uk-close></a>
        <?php endif; ?>

        <?= $props['alert_title']; ?>

        <ul class="uk-list uk-width-1-1">
            <li v-for="(status, status_type) in validation_status">

                <div v-if="!status.status && status_type == 'status_1'">
                    <span v-html="status.message"></span>
                </div>

                <div v-if="!status.status && status_type != 'status_1'">
                    <span>{{ status.message }}</span>
                </div>

            </li>
        </ul>
    </div>

</div>

<script>
    const <?= $id; ?> = {
        data() {
            return {
                base_url: '<?= $props['baseUrl']; ?>',
                validation_status: <?= json_encode($props['validation_status']) ?>,
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
                task_url: 'index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&format=raw
            }

        },
        created() {
            window.cls = {
                checkoutAlerts: this.validation_status
            };
            emitter.on("yps_cart_update", this.validateStatus);
        },
        computed: {
            checkout_status() {
                let checkout_status = true;
                Object.values(this.validation_status).forEach(status => {
                    if (!status.status) {
                        checkout_status = false;
                    }
                });

                return checkout_status;
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
            async validateStatus() {

                const response = await this.makeACall(params , '&type=checkout.status');

                this.gallery_loading = false;

                if (response)
                    Object.keys(response).forEach(status => {
                        if (response.data[status]) {
                            this.validation_status[status].status = response[status].status;
                        }
                    });

                    // Emit Validation Event
                    emitter.emit("yps_cart_validation_update", response);
                }

            },
            // async getValidationMessages() {

            //     const request = await fetch(this.base_url + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=checkout.validationmessages&format=raw", { method: 'post'});

            //     const response           = await request.json();
            //     this.validation_messages = response.data;

            // },
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


