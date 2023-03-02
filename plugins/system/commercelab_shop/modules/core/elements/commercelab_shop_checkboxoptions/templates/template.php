<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

$id = uniqid('yps_checkboxoptions');

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

?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>" class="uk-margin-top">

    	<?= $content($props, $attrs) ?>

            <?php if ($props['checkbox_options_layout'] == 'default') : ?>
                <div 
                    v-for="(option, index) in options"
                    class="uk-form uk-margin-small-top <?= $props['checkbox_options_default_label']; ?>" 
                >
                    <div class="uk-form-label">{{option.option_name}}</div>
                    <div class="uk-form-controls">
                        <input @change="recalc" type="checkbox" v-model="selectedOptions" :value="option.id" class="uk-checkbox yps_option">
                        {{option.modifier_value_translated}}
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($props['checkbox_options_layout'] == 'list') : ?>
                <div class="uk-width-1-1">
                    <ul class="uk-list uk-list-divider uk-margin-small-top">
                        <li v-for="(option, index) in options">

                            <div class="uk-h5 uk-margin-remove">{{option.option_name}}</div>
                            <label>
                                <input @change="recalc" type="checkbox" v-model="selectedOptions" :value="option.id" class="uk-margin-small-right uk-checkbox yps_option">
                                <span>
                                    {{option.modifier_value_translated}}
                                </span>
                            </label>

                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($props['checkbox_options_layout'] == 'breadcrumb') : ?>
                <ul class="uk-list uk-list-divider uk-margin-small-top">
                    <li v-for="(option, index) in options">
                        <label>
                            <input @change="recalc" type="checkbox" v-model="selectedOptions" :value="option.id" class="uk-checkbox yps_option uk-margin-small-right">
                            <span class="uk-margin-remove uk-h5">{{option.option_name}}</span>
                            <span class="uk-margin-small-left" uk-icon="icon: plus; ratio: 0.6" style="margin-right: 4px; vertical-align: text-top; padding-top: 5px;"></span>
                            <span>{{option.modifier_value_translated}}</span>
                        </label>
                    </li>
                </ul>
            <?php endif; ?>

    	<?= $content->end() ?>

    </div>

    <script>

        const <?= $id; ?> = {
            data() {
                return {
                    item_id: <?= $props['item_id'] ?>,
                    options: <?= json_encode($props['options']) ?>,
                    selectedOptions: []
                }
            },
            created() {},
            beforeMount() {},
            methods: {

                async recalc() {

                    Joomla_cls.selectedOptions[this.item_id] = [...this.options].filter(option => {
                        return this.selectedOptions.includes(option.id);
                    })

                    emitter.emit('yps_optionsChange' + this.item_id);
                }

            }
        }

        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

    </script>
<?= $el->end() ?>
