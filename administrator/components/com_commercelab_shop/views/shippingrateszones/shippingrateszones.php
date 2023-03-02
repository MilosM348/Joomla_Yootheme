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

/** @var array $vars */

?>

<div id="p2s_shippingrateszones" v-cloak>
    <!-- <div class="uk-margin-left"> -->
        <div class="main-section">   
        <div class="uk-grid center-section" uk-grid="">
            <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                       <div class="uk-grid uk-grid-small"> <!-- ADD LINE -->
                            <div class="uk-width-1-1@s uk-width-1-1@m uk-width-1-1@l uk-width-1-2@xl uk-margin-small">
                                <h3>
                                    <svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal"
                                         data-icon="tags"
                                         class="svg-inline--fa fa-tags fa-w-20" role="img"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 640 512">
                                        <path fill="currentColor"
                                              d="M625.941 293.823L421.823 497.941c-18.746 18.746-49.138 18.745-67.882 0l-1.775-1.775 22.627-22.627 1.775 1.775c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L391.431 36.686A15.895 15.895 0 0 0 380.117 32h-19.549l-32-32h51.549a48 48 0 0 1 33.941 14.059L625.94 225.941c18.746 18.745 18.746 49.137.001 67.882zM252.118 32H48c-8.822 0-16 7.178-16 16v204.118c0 4.274 1.664 8.292 4.686 11.314l211.882 211.882c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L263.431 36.686A15.895 15.895 0 0 0 252.118 32m0-32a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.746 18.746-49.138 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118V48C0 21.49 21.49 0 48 0h204.118zM144 124c-11.028 0-20 8.972-20 20s8.972 20 20 20 20-8.972 20-20-8.972-20-20-20m0-28c26.51 0 48 21.49 48 48s-21.49 48-48 48-48-21.49-48-48 21.49-48 48-48z">
                                        </path>
                                    </svg>
									<?= Text::_('COM_COMMERCELAB_SHOP_ZONESHIPPINGRATES_TITLE'); ?>
                                </h3>
                            </div>
                            <div class="uk-width-1-1@s uk-width-1-1@m uk-width-1-1@l uk-width-1-2@xl uk-text-right">
                                 <div class="uk-grid uk-grid-small uk-flex-right" uk-grid=""> <!-- ADD LINE -->
                                    <div class="uk-width-auto">
                                        <select class="uk-select" v-model="selectedZone" @change="filter">
                                            <option value="0">
				                                <?= Text::_('COM_COMMERCELAB_SHOP_ADD_SHIPPING_RATE_MODAL_ZONE_SELECT_DEFAULT'); ?>

                                            </option>
                                            <option v-for="zone in zones" :value="zone.id">
                                                {{zone.zone_name}}
                                            </option>
                                        </select>


                                    </div>
                                    <div class="uk-width-auto">
                                        <select class="uk-select" v-model="selectedCountry" @change="filter">
                                            <option value="0">
												<?= Text::_('COM_COMMERCELAB_SHOP_ADD_SHIPPING_RATE_MODAL_COUNTRY_SELECT_DEFAULT'); ?>

                                            </option>
                                            <option v-for="country in countries" :value="country.id">
                                                {{country.country_name}}
                                            </option>
                                        </select>


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

                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_ZONESHIPPINGRATES_TABLE_ZONENAME'); ?>
                                    <a href="#" @click="sort('country_name')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_ZONESHIPPINGRATES_TABLE_WEIGHT_FROM'); ?>
                                    <a href="#" @click="sort('weight_from')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_ZONESHIPPINGRATES_TABLE_WEIGHT_TO'); ?>
                                    <a href="#" @click="sort('weight_to')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_ZONESHIPPINGRATES_TABLE_COST'); ?>
                                    <a href="#" @click="sort('cost')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_ZONESHIPPINGRATES_TABLE_HANDLING_COST'); ?>
                                    <a href="#" @click="sort('handling_cost')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-text-left@m uk-text-nowrap">
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <template v-for="item in itemsChunked[currentPage]">
                                <tr class="el-item">
                                    <td>
                                        <div><input v-model="selected" :value="item" type="checkbox"></div>
                                    </td>
                                    <td>
                                        <a @click="item.showEdit = true">{{item.zone_name}}</a>
                                    </td>
                                    <td>
                                        {{item.weight_from}}
                                    </td>
                                    <td>
                                        {{item.weight_to}}
                                    </td>
                                    <td>
                                        {{item.costFormatted}}
                                    </td>
                                    <td>
                                        {{item.handling_costFormatted}}
                                    </td>
                                    <td class="uk-text-center">
                                  <span v-if="item.published == '1'"
                                        @click="togglePublished(item)"
                                        style="font-size: 18px; color: green; cursor: pointer;">
                                      <i class="fas fa-check-circle"></i>
                                  </span>
                                        <span v-if="item.published == '0'"
                                              @click="togglePublished(item)"
                                              style="font-size: 18px; color: red; cursor: pointer;">
								            <i class="fas fa-times-circle"></i>
								      </span>
                                    </td>


                                </tr>
                                <tr v-show="item.showEdit">
                                        <td>
                                            <button class="uk-button uk-button-link" @click="cancel()"><i style="width: 25px; height: 25px" class="fal fa-window-close fa-lg"></i></button>
                                        </td>
                                        <td>
                                            <select v-model="item.zone_id">
                                                <option v-for="zone in zones" :value="zone.id">{{zone.zone_name}}</option>
                                            </select>
                                        </td>
                                    <td>
                                        <input type="number" class="uk-input" v-model="item.weight_from">
                                        </td>
                                    <td>
                                        <input type="number" class="uk-input" v-model="item.weight_to">
                                    </td>
                                    <td>
                                        <p-inputnumber mode="currency" :currency="p2s_currency.iso" :locale="p2s_local" v-model="item.costFloat" name="cost" :minFractionDigits="2"></p-inputnumber>
                                    </td>
                                    <td>
                                        <p-inputnumber mode="currency" :currency="p2s_currency.iso" :locale="p2s_local" v-model="item.handling_costFloat" :minFractionDigits="2"></p-inputnumber>
                                        </td>
                                    <td class="uk-text-center">
                                        <button class="uk-button uk-button-link" @click="save(item)"><i style="width: 25px; height: 25px" class="fal fa-save fa-lg"></i></button>
                                </td>
                                    

                                </tr>

                            </template>

                            </tbody>

                        </table>

                        <h5 v-show="itemsChunked.length == 0"><?= Text::_('COM_COMMERCELAB_SHOP_ZONE_SHIPPING_RATES_EMPTY_TABLE'); ?></h5>
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
            </div></div>
            <div class="right-bar">
                <div class="right-bar-inner">
                    <div class="uk-card uk-card-default ">

                        <div class="uk-card-header">
                            <h4> Controls</h4>
                        </div>
                        <div class="uk-card-body">
                            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>

                                <li>
                                    <a class="uk-text-emphasis" href="index.php?option=com_commercelab_shop&view=shippingrateszone">
                                        <span class="uk-margin-small-right" uk-icon="icon: plus-circle"></span>
                                        <?= Text::_('COM_COMMERCELAB_SHOP_ADD_ZONE_SHIPPING_RATE_MODAL_TITLE'); ?>
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