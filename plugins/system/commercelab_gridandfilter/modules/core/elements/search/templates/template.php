<?php
/**
 * @package CommerceLab Grid & Filter
 *
 * @copyright   Copyright (C) 2020 Cloud Chief - CommerceLab.solutions - https://commerceLab.solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

$id = uniqid('yps_gridandfilter_search');

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

if (isset($props['slider']) && $props['slider'] === true && (in_array('price', $props['search_within']) || in_array('stock', $props['search_within'])))
{

    // \Joomla\CMS\Factory::getDocument()->addStylesheet('plugins/system/commercelab_gridandfilter/assets/slider/css/gaf_slider.css');
    // \Joomla\CMS\Factory::getDocument()->addScript('plugins/system/commercelab_gridandfilter/assets/slider/js/gaf_slider.min.js');

    $wa = Factory::getDocument()->getWebAssetManager();

    if (!$wa->assetExists('style', 'gaf_slider_css'))
    {
        $wa->registerStyle('gaf_slider_css', 'plugins/system/commercelab_gridandfilter/assets/slider/css/gaf_slider.css');
        $wa->useStyle('gaf_slider_css');
    }

    if (!$wa->assetExists('script', 'gaf_slider_js'))
    {
        $wa->registerScript('gaf_slider_js', 'plugins/system/commercelab_gridandfilter/assets/slider/js/gaf_slider.js');
        $wa->useScript('gaf_slider_js');
    }

}

?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>" class="uk-form">
        <?= $this->render("{$__dir}/layout/" . $props['layout'], compact('props', 'id')) ?>
    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    accordion_opened: <?= ($props['layout']  == 'accordion' && $props['accordion_opened']) ? 'true' : 'false' ?>,
                    close_on_mobiles: <?= ($props['layout']  == 'accordion' && $props['accordion_closed_small_devices']) 
                        ? (($props['accordion_close_bellow'] != '') 
                            ? $props['accordion_close_bellow']
                            : 'false') 
                        : 'false' ?>,
                    searchTerm: '',
                    priceFrom: '',
                    priceTo: '',
                    searchTerms: <?= json_encode($props['search_within']) ?>,
                    debounce: null,
                    priceQuery: {},
                    loadedSliders: {
                        'slider_<?= $id; ?>': false
                    },
                    sliderEnabled: <?= isset($props['slider']) && $props['slider'] === true && (in_array('price', $props['search_within']) || in_array('stock', $props['search_within'])) ? 'true' : 'false' ?>,
                    performQuery: <?= ($props['perform_query']) ? 'true' : 'false' ?>,
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

                // Slider Options
                <?php if (isset($props['slider']) && $props['slider'] === true && (in_array('price', $props['search_within']) || in_array('stock', $props['search_within']))) : ?>

                    window.prepareQuery<?= $id; ?> = this.prepareQuery;
                    this.parentWasHidden = this.close_on_mobiles && window.innerWidth < this.close_on_mobiles && this.accordion_opened;

                    // set: [<?php // $props['slider_values_set'] ?>],
                    const slider_id = '#<?= (in_array('price', $props['search_within'])) ? $id . '_priceRange' : $id . '_searchTerm'; ?>',
                        sliderOptions = {
                            target: slider_id,
                            range: <?= (in_array('price', $props['search_within'])) ? 'true' : 'false' ?>,
                            hiddenParent: this.parentWasHidden,
                            tooltip: <?= ($props['slider_tooltip']) ? 'true' : 'false' ?>,
                            labels: <?= ($props['slider_labels']) ? 'true' : 'false' ?>,
                            scale: <?= ($props['slider_scale']) ? 'true' : 'false' ?>,
                            // barColor: '<?= ($props['slider_bar_color'] != 'custom') ? $props['slider_bar_color'] : $props['slider_custom_bar_color'] ?>',
                            pointerColor: '<?= $props['slider_scale'] ?>',
                            // disabled: true,
                            onChange: function (value) {

                                <?php if (in_array('price', $props['search_within'])) : ?>
                                    value.split(',').forEach((value, index) => {

                                        if (value == '∞') value = '';

                                        if (index == 0) window.prepareQuery<?= $id; ?>(value, '<?= $id; ?>_priceFrom');
                                        else window.prepareQuery<?= $id; ?>(value, '<?= $id; ?>_priceTo');
                                    });
                                <?php endif; ?>

                                <?php if (in_array('stock', $props['search_within'])) : ?>
                                        if (value == '∞') value = '';
                                        window.prepareQuery<?= $id; ?>(value, '<?= $id; ?>_searchTerm');
                                <?php endif; ?>

                            }
                        };

                    <?php if ($props['slider_values_type'] == 'manual') : ?>
                        sliderOptions.values = <?= json_encode( explode(',', $props['slider_manual_values'])) ?>;
                    <?php endif; ?>

                    <?php if ($props['slider_values_type'] == 'auto') : ?>
                        sliderOptions.values = {min: <?= $props['slider_auto_values_start'] ?>, max: <?= $props['slider_auto_values_end'] ?>};
                        sliderOptions.step   = <?= $props['slider_auto_values_step'] ?>;
                    <?php endif; ?>

                    addEventListener('load', (event) => {
                        Joomla_cls['slider_<?= $id; ?>'] = new rSlider(sliderOptions);
                    });

                <?php endif; ?>
            },
            created() {
                emitter.on("gridandfilter_reset_searchbars", this.resetSearchBars);
            },
            mounted() {
                <?php if ($props['layout']  == 'accordion') : ?>

                    document.setAccordionState<?= $id; ?> = this.setAccordionState;
                    document.checkSlider<?= $id; ?> = this.checkSlider;

                    UIkit.util.on(document, 'shown', '#<?= $id; ?>_accordion', function (element) {
                        document.setAccordionState<?= $id; ?>(true);
                        document.checkSlider<?= $id; ?>();
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
                async resetSearchBars() {
                    this.priceFrom = this.priceTo = this.searchTerm  = '';
                    if (Joomla_cls['slider_<?= $id; ?>'])
                    {
                        Joomla_cls['slider_<?= $id; ?>'].destroy();
                        Joomla_cls['slider_<?= $id; ?>'].init(true);
                    }
                },
                async checkSlider() { // Reset Slider if was inside a closed Accordion

                    console.log(this.parentWasHidden);
                    if (this.parentWasHidden && Joomla_cls['slider_<?= $id; ?>'])
                    {
                        if (!this.loadedSliders['slider_<?= $id; ?>'])
                        {
                            // Joomla_cls['slider_<?= $id; ?>'].destroy();
                            Joomla_cls['slider_<?= $id; ?>'].init();
                            this.loadedSliders['slider_<?= $id; ?>'] = true;
                        }
                    }
                },
                async prepareQuery(searchValue, targetName) {

                    const performQuery = this.performQuery;

                    // let searchValue = event.target.value;
                    let searchTerms = this.searchTerms;

                    // Price
                    if (Object.values(this.searchTerms).includes('price'))
                    {
                        if (searchValue == '')
                        {
                            searchValue = null;
                        }

                        searchTerms = targetName.replace('<?= $id; ?>_', '');
                        const searchOptions = {
                            searchTerms,
                            searchValue,
                            performQuery,
                            el_id: '<?= $id ?>'
                        }
                        
                        emitter.emit("gridandfilter_update_values", searchOptions);
                    }
                    else // All other fields
                    {
                        const searchOptions = {
                            searchTerms,
                            searchValue,
                            performQuery,
                            el_id: '<?= $id ?>'
                        }

                        clearTimeout(this.debounce)
                        this.debounce = setTimeout((searchOptions) => {
                            emitter.emit("gridandfilter_update_values", searchOptions);
                        }, 600, searchOptions);

                    }
                },
                async onChange(event) {
                    await this.prepareQuery(event.target.value, event.target.name);
                }
            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>');
    </script>

<?= $el->end(); ?>
