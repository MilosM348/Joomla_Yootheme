<?php
/**
 * @package     CommerceLab Shop - Grid & Filter
 *
 * @copyright   Copyright (C) 2021 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = uniqid('yps_gridandfilter_filter');

$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        'uk-card uk-card-default {panel_card_style} uk-card-body {@panel_card}',
        '{panel_padding}',
        '{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
    ],

    'style' => [
        'border-bottom: 1px solid {panel_border_bottom_color}; {@panel_border_bottom}'
    ]

]);

?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>" class="uk-form">
        <?= $this->render("{$__dir}/layout/" . $props['layout'], compact('props', 'id')) ?>
    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    window_width: window.innerWidth,
                    accordion_opened: <?= ($props['layout']  == 'accordion' && $props['accordion_opened']) ? 'true' : 'false' ?>,
                    close_on_mobiles: <?= ($props['layout']  == 'accordion' && $props['accordion_closed_small_devices']) 
                        ? (($props['accordion_close_bellow'] != '') 
                            ? $props['accordion_close_bellow']
                            : 'false') 
                        : 'false' ?>,
                    filter_list: <?= json_encode($props['filter_list']) ?>,
                    filtered: [],
                    loaded: true,
                    queryLoading: false,
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
            },
            created() {
                emitter.on("gridandfilter_reset_filters", this.resetFilter);
            },
            mounted() {
                <?php if ($props['layout']  == 'accordion') : ?>

                    document.setAccordionState<?= $id; ?> = this.setAccordionState;

                    UIkit.util.on(document, 'shown', '#<?= $id; ?>_accordion', function (element) {
                        document.setAccordionState<?= $id; ?>(true);
                    });
                    UIkit.util.on(document, 'hidden', '#<?= $id; ?>_accordion', function (element) {
                        document.setAccordionState<?= $id; ?>(false);
                    });

                    // Close Accordion on mobiles
                    if (this.close_on_mobiles)
                    {
                        if (window.innerWidth < this.close_on_mobiles && this.accordion_opened)
                        {
                            UIkit.accordion('#<?= $id; ?>_accordion').toggle();
                            // window.dispatchEvent(new Event('resize'));
                        }
                        // addEventListener('resize', (event) => {
                        //     if (window.innerWidth < this.close_on_mobiles)
                        //     {
                        //         if (this.accordion_opened)
                        //         {
                        //             UIkit.accordion('#<?= $id; ?>_accordion').toggle();
                        //         }
                        //     }
                        //     else
                        //     {
                        //         if (!this.accordion_opened && <?= ($props['accordion_opened']) ? 'true' : 'false' ?>)
                        //         {
                        //             UIkit.accordion('#<?= $id; ?>_accordion').toggle();
                        //         }    
                        //     }
                        // });
                    }
                <?php endif; ?>
            },
            methods: {
                async setAccordionState(state) {
                    this.accordion_opened = state;
                },
                setFilter(event)
                {
                    switch('<?= $node->props['filter_type'] ?>')
                    {

                        case 'categories':
                            filterValues = this.filtered;
                            break;

                        default:
                            filterValues = [...this.filter_list].filter(filter_element => {
                                if (Array.isArray(this.filtered))
                                {
                                    return this.filtered.includes(filter_element.id);
                                }
                                else
                                {
                                    return this.filtered == filter_element.id;
                                }
                            });
                            break;
                    }

                    emitter.emit(
                        "gridandfilter_update_filters", 
                        {
                            filterType: '<?= $node->props['filter_type'] ?>',
                            filterValues,
                            el_id: '<?= $id ?>',
                            performQuery: true
                        }
                    );
                },
                resetFilter() {
                    this.filtered = [];
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