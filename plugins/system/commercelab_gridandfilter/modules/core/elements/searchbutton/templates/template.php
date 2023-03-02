<?php
/**
 * @package CommerceLab Grid & Filter
 *
 * @copyright   Copyright (C) 2020 Cloud Chief - CommerceLab.solutions - https://commerceLab.solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$id = uniqid('yps_gridandfilter_searchbutton');

$el = $this->el('div');

$search_button = $this->el('button', [

    'class' => [
        'uk-button',
        '{search_button_style}',
        '{search_button_size}',
        'uk-width-1-1 {@search_button_full_width}'
    ],

    '@click' => 'startSearch()',

]);

?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>">

        <?= $search_button($props, $attrs) ?>

            <?php if ($props['search_button_icon'] != '' && $props['search_button_icon_position'] == 'left') : ?>
                <span class="uk-margin-small-right" uk-icon="icon: <?= $props['search_button_icon']; ?>; ratio: <?= $props['search_button_icon_size']; ?>"></span>
            <?php endif; ?>

            <span>
                <?= $props['search_button_text']; ?>
            </span>

            <?php if ($props['search_button_icon'] != '' && $props['search_button_icon_position'] == 'right') : ?>
                <span class="uk-margin-small-left" uk-icon="icon: <?= $props['search_button_icon']; ?>; ratio: <?= $props['search_button_icon_size']; ?>"></span>
            <?php endif; ?>

        <?= $search_button->end() ?>

    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
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
            beforeMount(){

            },
            mounted() {
            },
            methods: {
                startSearch() {
                    emitter.emit("gridandfilter_perform_query");
                }
            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');

    </script>

<?= $el->end(); ?>
