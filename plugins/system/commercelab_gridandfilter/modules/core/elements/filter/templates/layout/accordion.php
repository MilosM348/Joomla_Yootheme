<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

use Joomla\CMS\Factory;

/** @var $props array */
/** @var $attrs array */

if ($props['accordion_limit_height'])
{
    // \Joomla\CMS\Factory::getDocument()->addStylesheet('plugins/system/commercelab_gridandfilter/assets/accordion/css/accordion.css');
    $wa = Factory::getDocument()->getWebAssetManager();
    
    if (!$wa->assetExists('style', 'accordion_css'))
    {
        $wa->registerStyle('accordion_css', 'plugins/system/commercelab_gridandfilter/assets/accordion/css/accordion.css');
        $wa->useStyle('accordion_css');
    }
}

?>

<ul id="<?= $id; ?>_accordion" 
    class="uk-margin-remove" uk-accordion>


    <li class="<?= ($props['accordion_opened']) ? 'uk-open' : '' ?>">

        <a class="uk-accordion-title uk-margin-remove">
            <?= $props['filter_title'] ?>
            <?php if ($props['show_total_count']) : ?>
                <span class="uk-text-muted uk-text-small uk-margin-small-left">
                    <?= $props['total_count']; ?>
                </span>
            <?php endif; ?>
        </a>

        <div class="uk-accordion-content">
            <ul class="uk-list <?= ($props['list_divider']) ? 'uk-list-divider' : '' ?>
                    <?= ($props['accordion_limit_height']) ? 'tm-scrollbox' : ''; ?>
                "
                style="<?= ($props['accordion_limit_height']) ? 'max-height: ' . $props['accordion_limit_height_px'] . 'px;' : ''; ?>"
            >
                <li v-for="filter_option in filter_list">
                    <?= $this->render("{$__dir}/sublayout/" . $props['sublayout'], compact('props')) ?>
                </li>
            </ul>
        </div>

    </li>

</ul>