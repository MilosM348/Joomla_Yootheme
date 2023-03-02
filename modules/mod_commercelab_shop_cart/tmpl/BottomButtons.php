<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>

<!-- Links -->
<div class="uk-grid-small" uk-grid>

    <?php if ($params->get('buttons_products_list') > 0) : ?> 
    <div class="<?= ($params->get('main_button1_fixed_width') != '') ? $params->get('main_button1_fixed_width') : '' ?>">
        <button 
            class="
                uk-button 
                <?= ($params->get('main_button1_fixed_width') != '') ? 'uk-width-1-1' : '' ?>
                <?= $params->get('main_button1_size') ?>
                <?= ($params->get('main_button1_style') != 'custom') ? $params->get('main_button1_style') : '' ?>
            " 
            @click="<?= ($params->get('main_button1_link') == 'goToCustomLink') 
                ? 'goToCustomLink(\'' . $params->get('main_button1_link_custom') . '\')'
                : $params->get('main_button1_link') ?>
            "
            style="<?= ($params->get('main_button1_style') == 'custom') ? 'background-color: ' . $params->get('main_button1_custom_style') . '; color: ' . $params->get('main_button1_custom_style_text') . '; border: 1px solid transparent;' : ''; ?>">

                <span class="uk-display-block">

                    <!-- Icon on Left -->
                    <?php if ($params->get('main_button1_icon') && $params->get('main_button1_icon_side') == 'left') : ?>
                        <span class="uk-margin-small-right" 
                            uk-icon="
                                icon: <?= ($params->get('main_button1_icon') == 'custom') 
                                    ? $params->get('main_button1_custom_icon') 
                                    : $params->get('main_button1_icon') ?>; 
                                ratio: <?= $params->get('main_button1_icon_size') ?>
                        "></span>
                    <?php endif; ?>

                    <!-- Main Text -->
                    <span class="uk-text-middle uk-display-inline-block">
                        <?= $params->get('main_button1_text'); ?>
                    </span>

                    <!-- Icon on Right -->
                    <?php if ($params->get('main_button1_icon') && $params->get('main_button1_icon_side') == 'right') : ?>
                        <span class="uk-margin-small-left" 
                            uk-icon="
                                icon: <?= ($params->get('main_button1_icon') == 'custom') 
                                    ? $params->get('main_button1_custom_icon') 
                                    : $params->get('main_button1_icon') ?>; 
                                ratio: <?= $params->get('main_button1_icon_size') ?>
                        "></span>
                    <?php endif; ?>

                </span>
                
        </button>

    </div>
    <?php endif; ?>

    <?php if ($params->get('buttons_products_list') == 2) : ?> 
    <div class="<?= ($params->get('main_button2_fixed_width') != '') ? $params->get('main_button2_fixed_width') : '' ?>">

        <button 
            class="
                uk-button 
                <?= ($params->get('main_button2_fixed_width') != '') ? 'uk-width-1-1' : '' ?>
                <?= $params->get('main_button2_size') ?>
                <?= ($params->get('main_button2_style') != 'custom') ? $params->get('main_button2_style') : '' ?>
            " 
            @click="<?= ($params->get('main_button2_link') == 'goToCustomLink') 
                ? 'goToCustomLink(\'' . $params->get('main_button2_link_custom') . '\')'
                : $params->get('main_button2_link') ?>
            "
            style="<?= ($params->get('main_button2_style') == 'custom') ? 'background-color: ' . $params->get('main_button2_custom_style') . '; color: ' . $params->get('main_button2_custom_style_text') . '; border: 1px solid transparent;' : ''; ?>">

                <span class="uk-display-block">

                    <!-- Icon on Left -->
                    <?php if ($params->get('main_button2_icon') && $params->get('main_button2_icon_side') == 'left') : ?>
                        <span class="uk-margin-small-right" 
                            uk-icon="
                                icon: <?= ($params->get('main_button2_icon') == 'custom') 
                                    ? $params->get('main_button2_custom_icon') 
                                    : $params->get('main_button2_icon') ?>; 
                                ratio: <?= $params->get('main_button2_icon_size') ?>
                        "></span>
                    <?php endif; ?>
                    <!-- Main Text -->
                    <span class="uk-text-middle uk-display-inline-block">
                        <?= $params->get('main_button2_text'); ?>
                    </span>

                    <!-- Icon on Right -->
                    <?php if ($params->get('main_button2_icon') && $params->get('main_button2_icon_side') == 'right') : ?>
                        <span class="uk-margin-small-left" 
                            uk-icon="
                                icon: <?= ($params->get('main_button2_icon') == 'custom') 
                                    ? $params->get('main_button2_custom_icon') 
                                    : $params->get('main_button2_icon') ?>; 
                                ratio: <?= $params->get('main_button2_icon_size') ?>
                        "></span>
                    <?php endif; ?>

                </span>

        </button>

    </div>
    <?php endif; ?>

</div>
