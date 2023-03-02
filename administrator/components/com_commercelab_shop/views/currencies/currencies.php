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


<div id="p2s_currencies" v-cloak>
   <!-- <div class="uk-margin-left"> -->

<div class="main-section">

   <div class="uk-grid center-section" uk-grid="">
      <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
         <div class="uk-card uk-card-default">
            <div class="uk-card-header">
               <div class="uk-grid uk-grid-small">
                  <!-- ADD LINE -->
                  <div class="uk-width-1-1@s uk-width-1-1@m uk-width-1-2@l uk-width-2-3@xl uk-margin-small-bottom">
                     <h3>
                        <svg width="16px" class="svg-inline--fa fa-boxes fa-w-16" aria-hidden="true"
                           focusable="false"
                           data-prefix="fad"
                           data-icon="boxes" role="img" xmlns="http://www.w3.org/2000/svg"
                           viewBox="0 0 576 512"
                           data-fa-i2svg="">
                           <g class="fa-group">
                              <path class="fa-secondary" fill="currentColor"
                                 d="M480 288v96l-32-21.3-32 21.3v-96zM320 0v96l-32-21.3L256 96V0zM160 288v96l-32-21.3L96 384v-96z">
                              </path>
                              <path class="fa-primary" fill="currentColor"
                                 d="M560 288h-80v96l-32-21.3-32 21.3v-96h-80a16 16 0 0 0-16 16v192a16 16 0 0 0 16 16h224a16 16 0 0 0 16-16V304a16 16 0 0 0-16-16zm-384-64h224a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16h-80v96l-32-21.3L256 96V0h-80a16 16 0 0 0-16 16v192a16 16 0 0 0 16 16zm64 64h-80v96l-32-21.3L96 384v-96H16a16 16 0 0 0-16 16v192a16 16 0 0 0 16 16h224a16 16 0 0 0 16-16V304a16 16 0 0 0-16-16z">
                              </path>
                           </g>
                        </svg>
                        &nbsp;
                        <?= Text::_('COM_COMMERCELAB_SHOP_CURRENCIES_TITLE'); ?>
                     </h3>
                  </div>

                  <div class="uk-width-1-1@s uk-width-1-2@m uk-width-1-2@l uk-width-1-3@xl uk-text-right uk-margin-small-bottom">
                     <div class="uk-width-auto uk-grid-item-match uk-flex-middle">
                        <div class="uk-grid uk-grid-small" uk-grid="">
                           <div class="uk-width-expand">  <?= Text::_('COM_COMMERCELAB_SHOP_SHOW_ONLY_PUBLISHED'); ?></div>
                           <div class="uk-width-auto">
                              <p-inputswitch v-model="publishedOnly" @change="filter"></p-inputswitch>
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="uk-width-1-1@s uk-width-1-2@m uk-width-1-1@l uk-width-1-1@xl uk-text-right">
                     <div class="uk-grid uk-grid-small uk-flex-right" uk-grid="">
                        <div class="uk-width-auto">
                           <div class="uk-grid uk-grid-small uk-position-relative" uk-grid="">
                              <div class="uk-width-expand">
                                 <input v-model="enteredText"
                                    @input="doTextSearch($event)"
                                    type="text"
                                    placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
                              </div>
                                    <div class="search-close uk-position-absolute">
                                 <span style="width: 20px">
                                 <span @click="cleartext" v-show="enteredText" style="cursor: pointer" uk-icon="icon: close"></span>
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
                        <th class="uk-text-left">Name
                           <a href="#" @click="sort('name')" class="uk-margin-small-right uk-icon"
                              uk-icon="triangle-down">
                           </a>
                        </th>
                        <th class="uk-text-left">ISO
                           <a href="#" @click="sort('iso')" class="uk-margin-small-right uk-icon"
                              uk-icon="triangle-down">
                           </a>
                        </th>
                        <th class="uk-text-left">Symbol
                           <a href="#" @click="sort('currencysymbol')" class="uk-margin-small-right uk-icon"
                              uk-icon="triangle-down">
                           </a>
                        </th>
                        <th class="uk-text-left">Rate
                           <a href="#" @click="sort('rate')" class="uk-margin-small-right uk-icon"
                              uk-icon="triangle-down">
                           </a>
                        </th>
                        <th class="uk-text-left">Published
                           <a href="#" @click="sort('published')" class="uk-margin-small-right uk-icon"
                              uk-icon="triangle-down">
                           </a>
                        </th>
                        <th class="uk-text-left">Default
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
                           <a :href="'index.php?option=com_commercelab_shop&view=currency&id=' + item.id">{{item.name}}</a>
                        </td>
                        <td>
                           {{item.iso}}
                        </td>
                        <td>
                           {{item.currencysymbol}}
                        </td>
                        <td>
                           {{item.rate}}
                        </td>
                        <td class="uk-text-center">
                           <span v-if="item.published == '1'"  @click="togglePublished(item)"
                              :style="[item.default == '1' ? 'font-size: 18px; color: green;' : 'font-size: 18px; color: green; cursor: pointer;']"
                              :uk-tooltip="[item.default == '1' ? 'title: <?= addslashes(Text::_('COM_COMMERCELAB_SHOP_ADD_CURRENCY_DEFAULT_CLICK_TOOLTIP')); ?>' : 'title:']"
                              >
                              <i class="fas fa-check-circle uk-text-success"></i>
                           </span>
                           <span
                              v-if="item.published == '0'"
                              class="yps_currency_published_icon"
                              @click="togglePublished(item)"
                              style="font-size: 18px; cursor: pointer;">
                              <i class="fas fa-times-circle uk-text-danger"></i>
                           </span>
                        </td>
                        <td class="uk-text-center">
                           <span v-if="item.default == '1'"
                              style="font-size: 18px;">
                              <i class="fas fa-check-circle uk-text-success"></i>
                           </span>
                           <span
                              v-if="item.default == '0'"
                              @click="toggleDefault(item)"
                              style="font-size: 18px; cursor: pointer;">
                              <i class="fas fa-times-circle uk-text-danger"></i>
                           </span>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <h5 v-show="itemsChunked.length == 0"><?= Text::_('COM_COMMERCELAB_SHOP_CURRENCIES_EMPTY_TABLE'); ?></h5>
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