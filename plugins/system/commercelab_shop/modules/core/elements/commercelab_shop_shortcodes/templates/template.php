<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


$id = uniqid('cls_short_codes');

$el = $this->el('div', [

    'class' => [
        'uk-panel {@!style}',
        'uk-card uk-card-body uk-{style}',
    ]
]);

$value = $this->el($props['codetype_element'], [

    'class' => [
        'uk-{codetype_style}',
        'uk-heading-{codetype_decoration}',
        'uk-font-{codetype_font_family}',
        'uk-text-{codetype_color} {@!codetype_color: background}',
        'uk-margin-remove {position: absolute}',
    ]

]);

$title = $this->el($props['title_element'], [

    'class' => [
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-margin-remove {position: absolute}',
    ]

]);

?>

<div id="<?= $id; ?>" v-cloak>
    <?= $el($props); ?>

        <?php if ($node->props['show_title']) : ?>
            <?= $title($props); ?>
                <?= $node->props['codetype_title']; ?>
            <?= $title->end(); ?>
        <?php endif; ?>

        <?php if ($node->props['show_codetype']) : ?>
            <?= $value($props); ?>
                <?= $node->props['codetype']; ?>
            <?= $value->end(); ?>
        <?php endif; ?>

    <?= $el->end(); ?>
</div>

<script>
    const <?= $id; ?> = {
        data() {
            return {

            }

        },
        created() {
        },
        computed: {
        },
        methods: {
            async someMethod() {

            }
        }
    }
    
    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

</script>


