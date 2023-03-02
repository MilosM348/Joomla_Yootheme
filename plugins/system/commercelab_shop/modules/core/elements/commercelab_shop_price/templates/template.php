<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


$id = uniqid('yps_price');

// Create div tag
$el = $this->el($props['title_element'], [

    'class' => [
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-margin-remove {position: absolute}',
    ]

]);

?>

<?= $el($props, $attrs) ?>
    <div id="<?= $id ?>">

        <span class="uk-text-<?= $props['content_before_color']; ?>">
            <?= $props['content_before']; ?>
        </span>

        <span style="<?= ($props['strikethru']) ? 'text-decoration: line-through;' : '' ?>">
            <?= $props['price_type_data']; ?>
        </span>
        <span class="uk-text-<?= $props['content_after_color']; ?>">
            <?= $props['content_after']; ?>
        </span>

    </div>
<?= $el->end(); ?>
