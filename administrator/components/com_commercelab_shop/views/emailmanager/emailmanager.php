<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

/** @var array $vars */

?>

<div id="p2s_emailmanager" v-cloak class="uk-animation-fade">
    <!-- <div class="uk-margin-left"> -->

        <div class="main-section"> 
        <div class="uk-grid center-section" uk-grid="">
            <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
                                <h3>
                                    <span style="margin-bottom: 2px; margin-right: 3px;" uk-icon="icon: mail"></span>
									<?= Text::_('COM_COMMERCELAB_SHOP_EMAILMANAGER_TITLE'); ?>
                                </h3>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
                                <div class="uk-grid uk-grid-small " uk-grid="">
                                    <div class="uk-width-auto uk-margin-auto-left">
                                        <div class="uk-grid uk-grid-small uk-position-relative" uk-grid="">
                                            <div class="uk-width-expand">
                                                <input v-model="enteredText"
                                                       @input="doTextSearch($event)"
                                                       type="text"
                                                       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
                                            </div>
                                            <div class="search-close uk-position-absolute">
                                            <span style="width: 20px">
                                            <span @click="cleartext" v-show="enteredText" style="cursor: pointer"
                                                  uk-icon="icon: close"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-body uk-overflow-auto">

                        <table class="uk-table uk-table-striped uk-table-divider uk-table-hover uk-table-responsive  uk-table-middle">
                            <thead>
                            <tr>

                                <th class="uk-text-left">
                                    <input @change="selectAll($event)" type="checkbox">
                                </th>

                                <th class="uk-text-left"><?= Text::_('Subject'); ?>
                                    <a href="#" @click="sort('subject')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILMANAGER_TABLE_EMAIL_TYPE'); ?>
                                    <a href="#" @click="sort('type')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILMANAGER_TABLE_EMAIL_LANGUAGE'); ?>
                                    <a href="#" @click="sort('language')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left@m uk-text-nowrap">
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                                <tr class="el-item" v-for="item in itemsChunked[currentPage]">
                                    <td>
                                        <div><input v-model="selected" :value="item" type="checkbox"></div>
                                    </td>
                                    <td>
                                        <a :href="'index.php?option=com_commercelab_shop&view=email&id=' + item.id">{{item.subject}}</a>
                                    </td>
                                    <td>
                                        {{item.emailtype_string}}
                                    </td>
                                    <td class="uk-text-center">
                                        <span uk-tooltip="<?= Text::_('JALL') ?>" v-if="item.language == '*'"><span uk-icon="icon: world"></span></span>
                                        <img :uk-tooltip="item.language" v-if="item.language_image != '*'" :src="'<?= Uri::root(); ?>/media/mod_languages/images/' + item.language_image + '.gif'">
                                    </td>

                                    <td class="uk-text-center">
                                        <span v-if="item.published == '1'"
                                            uk-tooltip="<?= Text::_('JPUBLISHED') ?>"
                                            @click="togglePublished(item)"
                                            style="font-size: 18px; cursor: pointer;">
                                                <i class="fas fa-check-circle uk-text-success"></i>
                                        </span>
                                        <span v-if="item.published == '0'"
                                            uk-tooltip="<?= Text::_('JUNPUBLISHED') ?>"
                                            @click="togglePublished(item)"
                                            style="font-size: 18px; cursor: pointer;">
    								            <i class="fas fa-times-circle uk-text-danger"></i>
    								    </span>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <h5 v-show="itemsChunked.length == 0"><?= Text::_('COM_COMMERCELAB_SHOP_EMAIL_MANAGER_EMPTY_TABLE'); ?></h5>
                    </div>
                    <div class="uk-card-footer">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-expand">
                                <p class="uk-text-meta">

                                </p>
                            </div>
                            <div class="uk-width-auto">
								<?= LayoutHelper::render('pagination'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> </div>
            <div class="right-bar">
                <div class="right-bar-inner">
                    <div class="uk-card uk-card-default ">

                        <div class="uk-card-header">
                            <h4> Controls</h4>
                        </div>
                        <div class="uk-card-body">
                            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>

                                <li>
                                    <a class="uk-text-emphasis" href="index.php?option=com_commercelab_shop&view=email">
                                        <span class="uk-margin-small-right" uk-icon="icon: plus-circle"></span>
                                        Add Email
                                    </a>
                                </li>

                                <li class="uk-nav-divider"></li>
                                <li>
                                    <a @click="trashSelected"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: trash"></span>
                                        Trash Selected
                                    </a>
                                </li>
                                <li>
                                    <a @click="toggleSelected"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: check"></span>
                                        Toggle Published
                                    </a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
       

    <!-- </div> -->
</div>
</div>