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
use Joomla\CMS\HTML\HTMLHelper;

/** @var array $vars */
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Factory;

// //   echo HTMLHelper::_('select.genericlist', $options, '', trim($attr), 'value', 'text', 'value', 'id');
// function getCategoryTreeForParentId($parent_id = 0) {

    
//     $db = Factory::getDbo();

// 		$query = $db->getQuery(true);

// 		$query->select('*');
// 		$query->from($db->quoteName('#__categories'));
// 		$query->where($db->quoteName('extension') . ' = ' . $db->quote('com_content'));
//         if($parent_id){
//             $query->where($db->quoteName('parent_id') . ' = ' . $db->quote($parent_id));
//         }

// 		$db->setQuery($query);
//       $result =   $db->loadObjectList();

//     foreach ($result as $mainCategory) {
//       $category = array();
//       $category['id'] = $mainCategory->id;
//       $category['name'] = $mainCategory->title;
//       $category['parent_id'] = $mainCategory->parent_id;
//       $category['sub_categories'] = getCategoryTreeForParentId($category['id']);
//       $categories[$mainCategory->id] = $category;
//     }
//     return $categories;
//   }
//   $categories = getCategoryTreeForParentId();

$filter_category_selector = $vars['filter_category_selector'];
$change_category_selector = $vars['change_category_selector'];

?>


<div id="cls_addons" v-cloak class="uk-animation-fade">
    <!-- <div class="uk-margin-left"> -->
<div class="main-section">        
        <div class="uk-grid center-section" uk-grid="">

            <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
                <div class="uk-card uk-card-default ">
                    <div class="uk-card-header">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-1@s uk-width-1-1@m uk-width-1-1@l uk-width-1-2@xl uk-margin-small">

                                <h3 class="uk-flex">

                                    <span style="min-width: 20px">
                                        <svg v-show="!filterLoading" width="16px" class="svg-inline--fa fa-boxes fa-w-16" aria-hidden="true"
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
                                        <span style=" width: 20px; height: 20px;" v-show="filterLoading" uk-spinner></span>
                                    </span> 

                                    &nbsp; <?= Text::_('COM_COMMERCELAB_SHOP_PRODUCTS_TITLE'); ?> 
                                    &nbsp; <span class="uk-text-small" style="margin-top: 3px;" v-show="totalItems">(<span v-show="totalItems != filteredItems">{{filteredItems}}/</span>{{totalItems}})</span>

                                </h3> 
                            </div>
                            <div class="uk-width-1-1@s uk-width-1-1@m uk-width-1-1@l uk-width-1-2@xl uk-text-right">
                                <div class="uk-grid uk-grid-small" uk-grid="">

                                    <div class="uk-width-1-2@s uk-width-2-3@m uk-width-2-3@l uk-width-2-3@xl uk-grid">
                                        <div class="uk-width-auto uk-remove-padding">
                                            <label>
                                                <input @change="filterByActiveOnly()" type="checkbox" :checked="showActiveOnly == 1" class="uk-margin-small-right">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_TABLE_ONLY_ACTIVE_PLACEHOLDER'); ?>
                                            </label>
                                        </div>
                                        <div class="uk-width-expand">
                                            <input :value="searchText" @change="doTextSearch($event)" type="text" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
                                        </div>
                                    </div>

                                    <div class="uk-width-1-2@s uk-width-1-3@m uk-width-1-3@l uk-width-1-3@xl uk-margin-remove" uk-grid>
                                        <div uk-lightbox data-type="iframe" id="category-selector" class="uk-width-expand uk-inline-block category-selector">
                                            <a href="<?= $filter_category_selector ?>" class="uk-form-icon uk-form-icon-flip" uk-icon="icon: file-edit"></a>
                                            <input disabled type="text" :value="selectedCategoryName" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_FILTER_CATEGORY_PLACEHOLDER'); ?>">
                                        </div>
                                        <div class="uk-width-auto">
                                            <a class="uk-icon" href="javascript:void(0);" uk-icon="icon: close" @click="resetFilter()"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-body uk-animation-fade uk-animation-fast uk-overflow-auto">
                        
                        <table class="uk-table uk-table-striped uk-table-divider uk-table-hover uk-table-responsive uk-table-middle">
                            <thead>
                            <tr>

                                <th class="uk-text-left">
                                    <input @change="selectAll($event)" type="checkbox">
                                </th>
                                <th class="uk-text-left">
                                    <a href="javascript:void(0);" 
                                        :class="{'uk-text-bolder': currentSort == 'a.title'}"
                                        @click="sort('a.title')">
                                            Name
                                            <span v-if="currentSort == 'a.title'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                    </a>
                                </th>
                                <th class="uk-text-left">Image
                                </th>
                                <th class="uk-text-left">
                                    <a href="javascript:void(0);" 
                                        :class="{'uk-text-bolder': currentSort == 'c.title'}"
                                        @click="sort('c.title')">
                                            Category
                                            <span v-if="currentSort == 'c.title'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                    </a>
                                <th class="uk-text-left">
                                    <a href="javascript:void(0);" 
                                        :class="{'uk-text-bolder': currentSort == 'p.base_price'}"
                                        @click="sort('p.base_price')">
                                            Price
                                            <span v-if="currentSort == 'p.base_price'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                    </a>
                                </th>

                                <th class="uk-text-left">
                                    <a href="javascript:void(0);" 
                                        :class="{'uk-text-bolder': currentSort == 'p.stock'}"
                                        @click="sort('p.stock')">
                                            Stock
                                            <span v-if="currentSort == 'p.stock'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                    </a>
                                </th>
                                <th class="uk-text-left">
                                    <a href="javascript:void(0);" 
                                        :class="{'uk-text-bolder': currentSort == 'a.state'}"
                                        @click="sort('a.state')">
                                            Published
                                            <span v-if="currentSort == 'a.state'" :uk-icon="(currentSortDir == 'DESC') ? 'icon:triangle-down' : 'icon:triangle-up'"></span>
                                    </a>
                                </th>

                            </tr>
                            </thead>

                            <tbody>
                            <tr class="el-item uk-animation-fade uk-animation-fast" v-for="product in items">
                                <td>
                                    <div><input :title="product.id" v-model="selected" :value="product" type="checkbox"></div>
                                </td>
                                <td>
                                    <a :href="'index.php?option=com_commercelab_shop&view=product&id=' + product.joomla_item_id">{{product.joomlaItem.title}}</a>
                                </td>
                                <td>

                                    <div uk-lightbox="animation: slide" v-if="product.teaserImagePath && product.teaserImagePath != ''">
                                        <a :href="product.teaserImagePath" :data-caption="product.title" data-type="image">
                                            <div
                                                class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
                                                :style="{'background-image':'url(\'' + product.teaserImagePath + '\')', 'width': '80px', 'height': '80px'}"
                                            ></div>
                                        </a>
                                        <a v-if="product.fullImagePath && product.fullImagePath != ''" data-type="image" 
                                            :href="product.fullImagePath" :data-caption="product.title"
                                            class="uk-button">
                                        </a>
                                    </div>
                                    <div v-else
                                        class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
                                        :style="{'background-image':'url(../media/com_commercelab_shop/images/no-image.png)', 'width': '80px', 'height': '80px'}">
                                    </div>
                                </td>
                                <td>
                                    <div>{{product.categoryName}}</div>
                                </td>
                                <td>
                                    <div v-show="!product.editPrice" @click="openEditPrice(product)">
                                        {{product.base_price_formatted}}
                                    </div>
                                    <div v-show="product.editPrice">
                                        <div class="uk-margin">
                                            <p-inputnumber @input="updateBasePriceFloat($event, product)"
                                               @blur="saveProductPrice(product)" mode="currency"
                                               :currency="p2s_currency.iso" :locale="p2s_locale"
                                               v-model="product.basepriceFloat" id="hello"
                                               name="heelo"></p-inputnumber>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div v-show="!product.editStock" @click="openEditStock(product)">{{product.stock}}
                                    </div>
                                    <div v-show="product.editStock">
                                        <div class="uk-margin">
                                            <input class="uk-input uk-form-width-xsmall" type="number"
                                                placeholder="Stock" @blur="saveProductStock(product)"
                                                v-model="product.stock" style="width: 60px!important;">
                                        </div>
                                    </div>
                                </td>
                                <td class="uk-text-center">

                                    <span v-if="product.published == '1' && product.isPendingState" class="yps_currency_published_icon"
                                        uk-tooltip="<?= Text::_('JARCHIVED') ?>"
                                        @click="togglePublished(product)"
                                        style="font-size: 18px; color: orange; cursor: pointer;">
                                            <i class="fas fa-check-circle"></i>
                                    </span>
                                    <span v-if="product.published == '1' && !product.isPendingState" class="yps_currency_published_icon"
                                        uk-tooltip="<?= Text::_('JPUBLISHED') ?>"
                                        @click="togglePublished(product)"
                                        style="font-size: 18px; cursor: pointer;">
                                            <i class="fas fa-check-circle uk-text-success"></i>
                                    </span>
                                    <span
                                        v-if="product.published == '0'"
                                        uk-tooltip="<?= Text::_('JUNPUBLISHED') ?>"
                                        class="yps_currency_published_icon"
                                        @click="togglePublished(product)"
                                        style="font-size: 18px; cursor: pointer;">
                                            <i class="fas fa-times-circle uk-text-danger"></i>
                                    </span>
                                </td>


                            </tr>


                            </tbody>
                        </table>

                        <h5 v-show="totalItems.length == 0"><?= Text::_('COM_COMMERCELAB_SHOP_PRODUCTS_EMPTY_TABLE'); ?></h5>
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
                    <div class="uk-card uk-card-default" uk-sticky="offset: 100">
                        <div class="uk-card-header">
                            <h3><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS'); ?></h3>
                        </div>
                        <div class="uk-card-body">

                            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>

                                <li>
                                    <a class="uk-text-emphasis" href="index.php?option=com_commercelab_shop&view=product">
                                        <span class="uk-margin-small-right" uk-icon="icon: plus-circle"></span>
										<?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_TITLE'); ?>
                                    </a>
                                </li>
                                <li class="options-templates-in">
                                    <a class="uk-text-emphasis" href="index.php?option=com_commercelab_shop&view=optiontemplates">
                                        <span class="uk-margin-small-right" uk-icon="icon: cog"></span>
                                        <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_OPTIONS_TEMPLATES'); ?>
                                    </a>
                                </li> 

                                <li class="uk-nav-header"><?= Text::_('COM_COMMERCELAB_SHOP_BATCH_ACTIONS'); ?></li>
                                <li class="uk-nav-divider"></li>
                                <li>
                                    <a @click="duplicateSelected"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: copy"></span>
                                        <?= Text::_('COM_COMMERCELAB_SHOP_DUPLICATE_SELECTED'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a @click="trashSelected"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: trash"></span>
										<?= Text::_('COM_COMMERCELAB_SHOP_TRASH_SELECTED'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a @click="toggleSelected"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: check"></span>
										<?= Text::_('COM_COMMERCELAB_SHOP_TOGGLE_PUBLISHED'); ?>
                                    </a>

                                </li>
                                <li>
                                    <a @click="openChangeCategory"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: album"></span>
										<?= Text::_('COM_COMMERCELAB_SHOP_CHANGE_CATEGORY'); ?>
                                    </a>

                                </li>
                                <li>
                                    <div v-show="showChangeCat">
                                        <div class="uk-container uk-padding-left uk-padding-right"
                                             style="padding-left: 40px!important; padding-right:  40px!important;">
                                            <div class="uk-grid uk-grid-small" uk-grid="">
                                                <div class="uk-width-expand">
                                                    <div uk-lightbox data-type="iframe" id="chamge-category-selector" class="uk-width-expand">
                                                        <a href="<?= $change_category_selector ?>">
                                                            <input type="text" :value="selectedChangeCategoryName" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_CHANGE_CATEGORY_PLACEHOLDER'); ?>">
                                                        </a>
                                                    </div>
<!--                                                     <select class="uk-select" v-model="changeCategory">
                                                        <option v-for="category in categories" :value="category.id">
                                                            {{category.title}}
                                                        </option>
                                                    </select> -->
                                                </div>
                                                <div class="uk-width-auto">
                                                    <button type="button"
                                                            class="uk-button uk-button-small uk-button-default"
                                                            @click="runChangeCategory">
														<?= Text::_('COM_COMMERCELAB_SHOP_CHANGE'); ?>
                                                        <i class="fal fa-exchange"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a @click="openChangeStock"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: bag"></span>
										<?= Text::_('COM_COMMERCELAB_SHOP_CHANGE_STOCK'); ?>
                                    </a>

                                </li>
                                <li>
                                    <div v-show="showChangeStock">
                                        <div class="uk-container uk-padding-left uk-padding-right"
                                             style="padding-left: 40px!important; padding-right:  40px!important;">
                                            <div class="uk-grid uk-grid-small" uk-grid="">
                                                <div class="uk-width-expand">

                                                    <input class="uk-input" type="number" v-model="changeStock">

                                                </div>
                                                <div class="uk-width-auto">
                                                    <button type="button"
                                                            class="uk-button uk-button-small uk-button-default"
                                                            @click="runChangeStock">
														<?= Text::_('COM_COMMERCELAB_SHOP_CHANGE'); ?>
                                                        <i class="fal fa-exchange"></i>

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a @click="exportSelected"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: pull"></span>
			                            Export
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
