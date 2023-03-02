<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

/** @var $props array */
/** @var $attrs array */

?>

<ul id="<?= $id; ?>_accordion" class="uk-margin-remove" uk-accordion>

    <li class="<?= ($props['accordion_opened']) ? 'uk-open' : '' ?>">

        <a class="uk-accordion-title uk-margin-remove">
            <?= $props['searchbar_label']; ?>
        </a>

        <div class="uk-accordion-content">
            <?= $this->render("{$__dir}/sublayout/" . $props['sublayout'], compact('props', 'id')) ?>
        </div>

    </li>

</ul>