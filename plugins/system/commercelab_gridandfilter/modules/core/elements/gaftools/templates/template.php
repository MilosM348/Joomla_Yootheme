<?php
/**
 * @package     CommerceLab Shop - Grid & Filter
 *
 * @copyright   Copyright (C) 2021 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = uniqid('yps_gridandfilter_reset');

$el = $this->el('div');

?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>">

        <?php if ($props['accessory_type'] == 'reset') : ?>
            <button class="uk-button <?= $props['reset_button_styling'] ?> <?= $props['reset_button_size'] ?>" 
                @click="resetAll()"
            >
                <?= $props['reset_text'] ?>
            </button>
        <?php endif; ?>

        <?php if ($props['accessory_type'] == 'total') : ?>
            <div class="<?= $props['total_style'] ?>">
                <span class="total_pre_text"><?= $props['total_pre_text'] ?></span>
                <span>{{ total }}</span>
                <span class="total_post_text"><?= $props['total_post_text'] ?></span>
            </div>
        <?php endif; ?>

        <?php if ($props['accessory_type'] == 'loading') : ?>
            <span v-if="loading || test_loading" uk-spinner
                style="width: <?= $props['loading_icon_size'] ?>px; height: <?= $props['loading_icon_size'] ?>px;" 
            ></span>
        <?php endif; ?>

    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    total: '',
                    loading: false,
                    test_loading: <?= ($props['test_loading']) ? 'true' : 'false' ?>,
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
                emitter.on("gridandfilter_set_total", this.setTotal);
                emitter.on("gridandfilter_loading", this.setLoading);
            },
            created() {
            },
            mounted() {
                emitter.emit("gridandfilter_get_total");
            },
            methods: {
                resetAll() {
                    emitter.emit("gridandfilter_reset_all");
                },
                setTotal(total) {
                    this.total = total;
                },
                setLoading(loadingState) {
                    this.loading = loadingState;
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

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

    </script>

<?= $el->end(); ?>