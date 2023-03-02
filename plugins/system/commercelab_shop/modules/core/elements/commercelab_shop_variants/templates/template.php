<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

$id = uniqid('yps_productvariants');

// Create div tag
$el = $this->el('div', [

	'class' => [
		'uk-panel {@!panel_style}',
		'uk-card uk-{panel_style} [uk-card-{panel_size}]',
		'uk-card-hover {@!panel_style: |card-hover}',
		'uk-card-body {@panel_style}',
	],

]);

// Content
$content = $this->el('div', [

	'class' => [
		'uk-card-body uk-margin-remove-first-child {@panel_style}',
		'uk-padding[-{!panel_content_padding: |default}] uk-margin-remove-first-child {@!panel_style} {@has_panel_content_padding}',
	],

]);

/** @var array $props */
/** @var array $attrs */

?>

<?= $el($props, $attrs) // Output div tag                       ?>

    <div id="<?= $id; ?>">

    	<?= $content($props, $attrs) // Content div tag                       ?>

            <?php if ($props['layout'] == 'dropdown') : ?>

                <div class="uk-form-controls uk-margin-top" v-for="variant in variants">

                    <label class="uk-form-label">{{variant.name}}</label>

                    <select class="uk-select" @change="selectedVariants[variant.id] = $event.target.value, updateVariants()">
                        <template v-for="label in variant.labels">

                            <option v-if="label.variant_id == variant.id" 
                                :value="label.id"
                                :selected="selectedVariants[variant.id] == label.id">

                                    {{label.name}}
                            
                                    <span v-if="!Array.isArray(label.id)" v-for="data in variantData.variantList">

                                        <span class="uk-margin-small-left" v-if="data.label_ids == label.id && !data.isZero">

                                            <?php if ($props['variant_price_type'] == 'relative') : ?>
                                                <span v-if="!data.bellowZero" class="uk-margin-small-left">+</span>
                                                <span v-if="data.bellowZero" class="uk-margin-small-left">-</span>
                                            <?php endif; ?>

                                            <span>
                                                {{data.priceInt}}
                                            </span>

                                        </span>

                                    </span>

                            </option>
                        </template>
                    </select>

                </div>

            <?php endif; ?>

            <?php if ($props['layout'] == 'radio') : ?>

                <div class="uk-form-controls uk-margin-top" v-for="variant in variants">
                    <div class="uk-h5">{{variant.name}}</div>
                    <ul class="uk-list uk-list-divider">

                        <li v-for="label in variant.labels">

                            <label>
                                <input @change="selectedVariants[variant.id] = label.id, updateVariants()" 
                                    type="radio" 
                                    :name="'variants_' + variant.id" 
                                    :checked="selectedVariants[variant.id] == label.id" 
                                    :value="label.id" 
                                    class="uk-radio uk-margin-small-right"
                                >
                                <span class="uk-margin-remove uk-h5">{{label.name}}</span>

                                <span v-if="!Array.isArray(label.id)" v-for="data in variantData.variantList">

                                    <span class="uk-margin-small-left" v-if="data.label_ids == label.id && !data.isZero">

                                        <?php if ($props['variant_price_type'] == 'relative') : ?>
                                            <span v-if="!data.bellowZero" class="uk-margin-small-left">+</span>
                                            <span v-if="data.bellowZero" class="uk-margin-small-left">-</span>
                                        <?php endif; ?>

                                        <span>
                                            {{data.priceInt}}
                                        </span>

                                    </span>

                                </span>

                            </label>

                        </li>
                    </ul>
                </div>

            <?php endif; ?>

            <?php if ($props['layout'] == 'buttons') : ?>

                <div class="uk-form-controls uk-margin-top" v-for="variant in variants">

                    <div class="uk-h5">{{variant.name}}</div>

                    <div class="uk-button-group">

                        <button @click="selectedVariants[variant.id] = label.id, updateVariants()" v-for="label in variant.labels" class="uk-margin-small-right uk-button <?= $props['button_size'] ?> <?= $props['button_style'] ?> " class="uk-width-auto"
                            :class="{'uk-active': selectedVariants[variant.id] == label.id}"
                        >
                            <span class="">{{label.name}}</span>

                            <span v-if="!Array.isArray(label.id)" v-for="data in variantData.variantList">

                                <span class="uk-margin-small-left" v-if="data.label_ids == label.id && !data.isZero">

                                    <?php if ($props['variant_price_type'] == 'relative') : ?>
                                        <span v-if="!data.bellowZero" class="uk-margin-small-left">+</span>
                                        <span v-if="data.bellowZero" class="uk-margin-small-left">-</span>
                                    <?php endif; ?>

                                    <span>
                                        {{data.priceInt}}
                                    </span>

                                </span>

                            </span>

                            <!-- 
                            <label style="cursor: pointer;">

                                <input @change="recalc" 
                                    type="radio" 
                                    :name="'variants_' + variant.id" 
                                    :checked="selected.includes(label.id.toString())" 
                                    :value="label.id" 
                                    class="uk-hidden yps_variant uk-width-full uk-height-full"
                                > -->

                            <!-- </label> -->

                        </button>

                    </div>
                </div>

            <?php endif; ?>

            <span v-show="unavailableMessage"><?= $props['unavailableMessage']; ?></span>

        </div><!--Vue div tag-->
    </div><!--Content div tag-->

</div><!--Output div tag-->
<script>

    const <?= $id; ?> = {
        data() {
            return {
                item_id: <?= $props['item_id'] ?>,
                joomla_item_id: <?= $props['joomla_item_id'] ?>,
                variants: <?= json_encode($props['variants']) ?>,
                variantDefault: <?= json_encode($props['variantDefault']) ?>,
                variantData: <?= json_encode($props['variantData']) ?>,
                selectedVariants: <?= json_encode($props['selectedVariants']) ?>,
                previouslySelectedVariants: <?= json_encode($props['selectedVariants']) ?>,
                unavailableMessage: false,
            }
        },
        beforeMount() {},
        mounted() {},
        created() {

            document.addEventListener("DOMContentLoaded", () => {
                Joomla_cls.selectedVariants[this.item_id] = this.selected = this.variantDefault;
                emitter.emit('yps_variantsChange' + this.item_id);
            });

        },
        methods: {
            async updateVariants() {

                emitter.emit('yps_total_loading' + this.item_id, true);

                const params = {
                    'joomla_item_id': this.joomla_item_id,
                    'selected': Object.values(this.selectedVariants)
                };

                const request = await fetch(Joomla_cls.uri_base + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=product.checkvariantavailability&format=raw", {
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

                if (response.success)
                {

                    if (response.data.active)
                    {
                        Joomla_cls.selectedVariants[this.item_id] = this.selectedVariants;
                        this.previouslySelectedVariants           = JSON.parse(JSON.stringify(this.selectedVariants));
                        
                        emitter.emit('yps_variantsChange' + this.item_id);
                        this.unavailableMessage                   = false;

                    }
                    else
                    {
                        this.selectedVariants = JSON.parse(JSON.stringify(this.previouslySelectedVariants));

                        emitter.emit('yps_total_loading' + this.item_id, false);
                        this.unavailableMessage = true;
                    }

                }

            },
            checkIfAvailable(variant) {
                return false;
            },
            arraysMatch(arr1, arr2) {
                // check if 2 arrays are the same
                if (arr1.length !== arr2.length) return false;

                for (var i = 0; i < arr1.length; i++) {
                    if (arr1[i] !== arr2[i]) return false;
                }

                return true;

            }
        }
    }

    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')


</script>
