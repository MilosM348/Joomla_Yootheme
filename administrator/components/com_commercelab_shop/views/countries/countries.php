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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Layout\LayoutHelper;
/** @var array $vars */
?>


<div id="p2s_countries" v-cloak>
    <!-- <div class="uk-margin-left"> -->
<div class="main-section">         
        <div class="uk-grid center-section" uk-grid="">
            <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <div class="uk-grid-small"> <!-- ADD LINE -->
                            <div class="uk-width-expand">
                                <h3>
                                    <svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal"
                                         data-icon="globe-africa"
                                         class="svg-inline--fa fa-globe-africa fa-w-16" role="img"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 496 512">
                                        <path fill="currentColor"
                                              d="M248 8C111.04 8 0 119.03 0 256s111.04 248 248 248 248-111.03 248-248S384.96 8 248 8zm193.21 152H423.5c-17.38 0-31.5 14.12-31.5 31.5l.28 6.47-12.62 6.69c-2.66.48-8.41.66-15.09.97-32.31 1.52-46.88 2.67-52.91 14.61l-4 10.12 18.44 27.61A31.427 31.427 0 0 0 352.29 272l7.72-.5.09 11.02-18.81 25.09a31.937 31.937 0 0 0-5.66 12.97l-4.19 22.56c-10.38 9.5-19.62 20.3-27.47 32.08l-13.03 19.53c-4.66 6.98-16.53 6.33-20.28-1.28a62.926 62.926 0 0 1-6.66-28.09V335.5c0-17.38-14.12-31.5-31.5-31.5h-25.88c-10.31 0-20-4.02-27.31-11.31-7.28-7.3-11.31-17-11.31-27.31v-14.06c0-12.09 5.78-23.66 15.44-30.91l27.62-20.69c10.94-8.27 27.72-10.42 41.31-3.64l14.72 7.36c7.5 3.73 16.03 4.38 24.06 1.7l47.31-15.77a31.466 31.466 0 0 0 21.53-29.88c0-17.38-14.12-31.5-31.5-31.5l-9.72.16-6.94-6.94c-5.94-5.94-13.84-9.22-22.25-9.22l-89.58.51-.38-3.92 14.44-3.61c7.66-1.91 14.25-6.56 18.56-13.06L240.28 80h24.22c17.38 0 31.5-14.12 31.5-31.5v-2.94C359.74 60.1 412.7 102.86 441.21 160zM248 472c-119.1 0-216-96.9-216-216S128.9 40 248 40c5.54 0 10.96.42 16.39.83l.11 7.17h-24.22c-10.53 0-20.34 5.25-26.19 14.02l-7.78 11.92-14.47 3.61C177.81 81.08 168 93.64 168 108.09v4.41c0 17.38 14.12 31.5 31.5 31.5l89.72-.16 6.94 6.94c5.94 5.95 13.84 9.22 22.25 9.22l9.94-.97-46.94 15.78-14.72-7.36c-22.34-11.17-53.38-9.5-74.84 6.67l-27.59 20.69c-17.7 13.27-28.26 34.39-28.26 56.5v14.06c0 18.86 7.34 36.59 20.69 49.94S187.75 336 206.62 336l25.38-.5v29.88c0 14.69 3.47 29.38 10.03 42.42 7.44 14.92 22.44 24.2 39.12 24.2 14.66 0 28.25-7.28 36.41-19.48l13.03-19.55c6.44-9.64 14-18.47 22.41-26.17 5.09-4.62 8.47-10.66 9.75-17.45l4.22-22.62 18.75-25c4.06-5.42 6.28-12.12 6.28-18.89V271.5c0-17.38-14.12-31.5-31.5-31.5l-7.78.2-1.22-1.83c5.38-.34 10.81-.61 14.53-.78 15.88-.73 20.66-1.05 25.16-3.3l15.41-7.7c10.75-5.38 17.41-16.17 17.41-28.17l-.5-6.42h30.81c6.29 20.23 9.69 41.73 9.69 64C464 375.1 367.1 472 248 472z">
                                        </path>
                                    </svg>
                                    &nbsp
									<?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES'); ?>
                                </h3>
                            </div>
                            <div class="uk-width-auto uk-text-right">
                                <div class="uk-grid uk-grid-small uk-flex-right" uk-grid=""> <!-- ADD LINE -->
                                    <div class="uk-width-auto uk-grid-item-match uk-flex-middle">
                                        <div class="uk-grid uk-grid-small" uk-grid="">
                                            <div class="uk-width-expand uk-grid-item-match uk-flex-middle ">  <?= Text::_('COM_COMMERCELAB_SHOP_SHOW_ONLY_PUBLISHED'); ?></div>
                                            <div class="uk-width-auto">
                                                <p-inputswitch v-model="publishedOnly" @change="filter"></p-inputswitch>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-auto">

                                        <div class="uk-grid uk-grid-small" uk-grid="">
                                            <div class="uk-width-expand  ">
                                                <input v-model="enteredText"
                                                       @input="doTextSearch($event)"
                                                       type="text"
                                                       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
                                            </div>
                                       <!--      <div class="uk-width-auto uk-grid-item-match uk-flex-middle">
                                            <span style="width: 20px">
                                            <span @click="cleartext" v-show="enteredText" style="cursor: pointer" uk-icon="icon: close"></span>
                                                </span>
                                            </div> -->
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
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_TABLE_COUNTRYNAME'); ?>
                                    <a href="#" @click="sort('country_name')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_TABLE_ISO2'); ?>
                                    <a href="#" @click="sort('country_isocode_2')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_TABLE_ISO3'); ?>
                                    <a href="#" @click="sort('country_isocode_3')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_ENABLE_VAT'); ?>
                                    <a href="#" @click="sort('requires_vat')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_TAXRATE'); ?>
                                    <a href="#" @click="sort('taxrate')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left"><?= Text::_('Red. Taxrate'); ?>
                                    <a href="#" @click="sort('taxrate_reduced')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left"><?= Text::_('Extra. Taxrate'); ?>
                                    <a href="#" @click="sort('taxrate_extra')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_TABLE_PUBLISHED'); ?>
                                    <a href="#" @click="sort('published')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_TABLE_DEFAULT'); ?>
                                    <a href="#" @click="sort('default')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                            </tr>
                            </thead>

                            <tbody>
                            <tr class="el-item" v-for="item in itemsChunked[currentPage]">
                                <td>
                                    <div><input v-model="selected" :value="item" type="checkbox"></div>
                                </td>
                                <td>
                                    <a :href="'index.php?option=com_commercelab_shop&view=country&id=' + item.id">{{item.country_name}}</a>
                                </td>
                                <td>
                                    {{item.country_isocode_2}}
                                </td>
                                <td>
                                    {{item.country_isocode_3}}
                                </td>
                                <td>

                                    <span v-if="item.requires_vat == '1'"
                                          style="font-size: 18px; color: green;">
                                      <i class="fas fa-check-circle"></i>
                                  </span>
                                    <span
                                            v-if="item.requires_vat == '0'"

                                            style="font-size: 18px; color: red;">
                                        <i class="fas fa-times-circle"></i>
                                    </span>


                                </td>

                                <td>
                                    {{item.taxrate}}
                                </td>

                                <td v-if="item.taxrate_reduced">
                                    {{item.taxrate_reduced}}
                                </td>
                                <td v-else>
                                    --
                                </td>

                                <td v-if="item.taxrate_extra">
                                    {{item.taxrate_extra}}
                                </td>
                                <td v-else>
                                    --
                                </td>

                                <td class="uk-text-left@s uk-text-center@m uk-text-center@l uk-text-center@xl">
                                  <span v-if="item.published == '1'"
                                        @click="togglePublished(item)"
                                        style="font-size: 18px; color: green; cursor: pointer;">
                                      <i class="fas fa-check-circle"></i>
                                  </span>
                                    <span
                                            v-if="item.published == '0'"

                                            @click="togglePublished(item)"
                                            style="font-size: 18px; color: red; cursor: pointer;">
                                        <i class="fas fa-times-circle"></i>
                                    </span>
                                </td>
                                <td class="uk-text-left@s uk-text-center@m uk-text-center@l uk-text-center@xl">
                                  <span v-if="item.default == '1'"
                                        @click="toggleDefault(item)"
                                        style="font-size: 18px; color: green; cursor: pointer;">
                                      <i class="fas fa-check-circle"></i>
                                  </span>
                                    <span
                                            v-if="item.default == '0'"

                                            @click="toggleDefault(item)"
                                            style="font-size: 18px; color: red; cursor: pointer;">
                                        <i class="fas fa-times-circle"></i>
                                    </span>
                                </td>

                            </tr>


                            </tbody>

                        </table>
                        <h5 v-show="itemsChunked.length == 0"><?= Text::_('COM_COMMERCELAB_SHOP_COUNTRIES_EMPTY_TABLE'); ?></h5>

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
            </div>
            </div>

           <div class="right-bar">
                <div class="right-bar-inner">
                    <div class="uk-card uk-card-default ">

                        <div class="uk-card-header">
                            <h4> <?= Text::_('COM_COMMERCELAB_SHOP_CONTROLS'); ?></h4>
                        </div>
                        <div class="uk-card-body">
                            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
                                <li>
                                    <a class="uk-text-emphasis" href="index.php?option=com_commercelab_shop&view=country">
                                        <span class="uk-margin-small-right" uk-icon="icon: plus-circle"></span>
                                       <?= Text::_('COM_COMMERCELAB_SHOP_COUNTRY_ADD'); ?>
                                    </a>
                                </li>
                                <li class="uk-nav-divider"></li>
                                <li>
                                    <a  @click="trashSelected"  :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: trash"></span>
			                            <?= Text::_('COM_COMMERCELAB_SHOP_TRASH_SELECTED'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a  @click="toggleSelected"  :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: check"></span>
							            <?= Text::_('COM_COMMERCELAB_SHOP_TOGGLE_PUBLISHED'); ?>
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