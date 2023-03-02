<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


$id = uniqid('yps_total');
/** @var array $attrs */
/** @var array $props */
// Create div tag

$el = $this->el('div', [

	// 'class' => [
	// 	'uk-{title_style}',
	// 	'uk-heading-{title_decoration}',
	// 	'uk-font-{title_font_family}',
	// 	'uk-text-{title_color} {@!title_color: background}',
	// ]

]);

$price = $this->el($props['title_element'], [

    'class' => [
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
    ]

]);

if ($props['before']) {

    $before = $this->el($props['before_element'], [

        'class' => [
            'uk-{before_style}',
            'uk-heading-{before_decoration}',
            'uk-font-{before_font_family}',
            'uk-text-{before_color} {@!before_color: background}',
        ]

    ]);
}

if ($props['after']) {

    $after = $this->el($props['after_element'], [

        'class' => [
            'uk-{after_style}',
            'uk-heading-{after_decoration}',
            'uk-font-{after_font_family}',
            'uk-text-{after_color} {@!after_color: background}',
        ]

    ]);
}

?>

<?= $el($props, $attrs) ?>
<div id="<?= $id; ?>">

    <div v-show="loading" id="<?= $id ?>_yps-total-spinner" uk-spinner></div>

    <span v-show="!loading" style="display: none">

        <?php if ($props['before']) : ?>
            <?= $before($props, $attrs) ?>
                <?= $props['before']; ?>
            <?= $before->end(); ?>
        <?php endif; ?>
        
        <?= $price($props, $attrs) ?>
            {{ total }}
        <?= $price->end(); ?>

        <?php if ($props['after']) : ?>
            <?= $after($props, $attrs) ?>
                <?= $props['after']; ?>
            <?= $after->end(); ?>
        <?php endif; ?>

    </span>

</div>

<script>

    window.addEventListener('load', function () {
        const <?= $id; ?> = {
            data() {
                return {
                    base_url: '<?= \Joomla\CMS\Uri\Uri::base(); ?>',
                    total: 0,
                    loading: false,
                    item_id: <?= $props['item_id']; ?>,
                    with_tax: <?= ($props['with_tax']) ? 1 : 0; ?>,
                    multiplier: 1,
                    variants: [],
                    options: [],
                }
            },
            created() {
                emitter.on('yps_amountChange' + this.item_id, this.setMultiplier)
                emitter.on('yps_product_update' + this.item_id, this.recalculateTotal)

                emitter.on('yps_optionsChange' + this.item_id, this.recalculateTotal)
                emitter.on('yps_variantsChange' + this.item_id, this.recalculateTotal)

                emitter.on('yps_total_loading' + this.item_id, this.totalLoading)
            },

            async mounted() {
                this.recalculateTotal();
            },
            methods: {

                async totalLoading(state) {
                    this.loading = state;
                },
                async recalculateTotal() {

                    this.loading = true;

                    var params = {
                        'joomla_item_id': this.item_id,
                        'selectedVariants': (Joomla_cls.selectedVariants[this.item_id]) ? Joomla_cls.selectedVariants[this.item_id] : this.variants,
                        'selectedOptions': (Joomla_cls.selectedOptions[this.item_id]) ? Joomla_cls.selectedOptions[this.item_id] : this.options,
                        'multiplier': this.multiplier,
                        'with_tax': this.with_tax
                    };

                    const request = await fetch(this.base_url + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=product.calculateprice&format=raw", {
                        method: 'POST',
                        mode: 'cors',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-Token': Joomla_cls.token,
                            'Content-Type': 'application/json'
                        },
                        redirect: 'follow',
                        referrerPolicy: 'no-referrer',
                        body: JSON.stringify(params)
                    });

                    const response = await request.json();

                    if (response.success) {
                        this.total   = response.data.string;
                        this.loading = false;
                    } else {
                        UIkit.notification({
                            message: response.message,
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });
                    }

                },
                setMultiplier(multiplier) {
                    //set the amount
                    this.multiplier = multiplier;
                }

            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')
    });
</script>
<?= $el->end(); ?>
