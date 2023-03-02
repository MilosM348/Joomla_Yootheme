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

<script id="base_url" type="application/json"><?= Uri::base(); ?></script>
<script id="items_data" type="application/json"><?= json_encode($vars['items']); ?></script>
<script id="page_size" type="application/json"><?= $vars['list_limit']; ?></script>

<div id="p2s_productoptions">
    <div class="uk-margin-left">
        <div class="uk-grid" uk-grid="">
            <div class="uk-width-3-4">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-expand">
                                <h3>
                                    <svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="ballot-check" class="svg-inline--fa fa-ballot-check fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M112 432h32c17.7 0 32-14.4 32-32v-32c0-17.6-14.3-32-32-32h-32c-17.7 0-32 14.4-32 32v32c0 17.6 14.3 32 32 32zm0-64h32v32h-32v-32zm0-192h32c17.7 0 32-14.4 32-32v-32c0-17.6-14.3-32-32-32h-32c-17.7 0-32 14.4-32 32v32c0 17.6 14.3 32 32 32zm0-64h32v32h-32v-32zM416 0H32C14.3 0 0 14.4 0 32v448c0 17.6 14.3 32 32 32h384c17.7 0 32-14.4 32-32V32c0-17.6-14.3-32-32-32zm0 480H32V32h384v448zM216 144h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0 128h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0 128h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm-97.4-113.6c2.1 2.1 5.5 2.1 7.6 0l64.2-63.6c2.1-2.1 2.1-5.5 0-7.6l-12.6-12.7c-2.1-2.1-5.5-2.1-7.6 0l-47.6 47.2-20.6-20.9c-2.1-2.1-5.5-2.1-7.6 0l-12.7 12.6c-2.1 2.1-2.1 5.5 0 7.6l36.9 37.4z"></path>
                                    </svg>
                                    &nbsp; <?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_VALUES_LIST'); ?></h3>
                            </div>
                            <div class="uk-width-auto uk-text-right">
                                <div class="uk-grid uk-grid-small" uk-grid="">
                                    <div class="uk-width-auto">
                                        <input  @input="doTextSearch($event)" type="text" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
                                    </div>
                                    <div class="uk-width-auto">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-body">

                        <table class="uk-table uk-table-striped uk-table-divider uk-table-hover uk-table-responsive  uk-table-middle">
                            <thead>
                            <tr>
                            <th class="uk-text-left">
                                    <input @change="selectAll($event)" type="checkbox">
                                </th>
                                <th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TABLE_NAME'); ?>
                                    <a href="#" @click="sort('name')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>
                                <th class="uk-text-left uk-table-expand"><?= Text::_('Option Name'); ?>
                                    <a href="#" @click="sort('option_type')" class="uk-margin-small-right uk-icon"
                                       uk-icon="triangle-down">
                                    </a>
                                </th>

                                <th class="uk-width-small">
                                </th>
                            </tr>
                            </thead>

                            <tbody class="mainitems" uk-sortable="cls-custom: uk-box-shadow-small uk-flex uk-flex-middle uk-background">
                            <tr class="el-item" v-for="item in itemsChunked[currentPage]" :id="item.id">
                                <td>
                                    <div>
                                        <input v-model="selected" :value="item" type="checkbox">
                                        <span class="uk-padding-small uk-sortable-handle uk-margin-small-right uk-text-center uk-icon" uk-icon="icon: table"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="1" y="3" width="18" height="1"></rect><rect x="1" y="7" width="18" height="1"></rect><rect x="1" y="11" width="18" height="1"></rect><rect x="1" y="15" width="18" height="1"></rect></svg></span>
                                    </div>
                                </td>
                                <td>
                                    <div>{{item.name}}</div>
                                </td>
                                <td>
                                    <div>{{item.option_name}}</div>
                                </td>
                                <td class="uk-text-right">
                                    <ul class="uk-iconnav">
                                        <li>
                                            <a @click="editTemplateOptionValues(item)"><span uk-icon="icon: pencil"></span></a>
                                        </li>
                                        <!-- <li>
                                            <a><span uk-icon="icon: trash"></span></a>
                                        </li> -->
                                    </ul>
                                </td>


                            </tr>


                            </tbody>

                        </table>


                    </div>
                    <div class="uk-card-footer"></div>
                </div>
            </div>
            <div class="uk-width-1-4">
                <div>
                    <div class="uk-card uk-card-default" uk-sticky="offset: 100">
                        <div class="uk-card-header">
                            <h3>Options</h3>
                        </div>
                        <div class="uk-card-body">
                            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
                              
                                <li>
                                    <a @click="addOptionTemplateValues">
                                    <span class="uk-margin-small-right" uk-icon="icon: plus-circle"></span>
                                        <?= Text::_('Add Option Value'); ?>
                                    </a>
                                </li>
                                
                                <li class="uk-nav-header"><?= Text::_('COM_COMMERCELAB_SHOP_BATCH_ACTIONS'); ?></li>
                                <li class="uk-nav-divider"></li>
                                <li>
                                    <a @click="trashSelected"
                                       :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
                                        <span class="uk-margin-small-right" uk-icon="icon: trash"></span>
										<?= Text::_('COM_COMMERCELAB_SHOP_TRASH_SELECTED'); ?>
                                    </a>
                                </li>
                                
                            </ul>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= LayoutHelper::render('optiontemplates.optiontemplatevaluesmodal', array(
            'items' => $items
        )); ?> 
    </div>
   
</div>
<script>
var util = UIkit.util;
		util.ready(function () {
           
			util.on('.mainitems', 'stop', function (e, sortable, el) { 
                const newItemList = [];
				sortable.items.forEach(function(item, index) {
					newItemList.push({
                            "id": item.id,
                            "ordering": index,
                        });
				});
                
                const params = {'items': newItemList,};
                        let base_urls = '';
						const base_url = document.getElementById('base_url');
                        if (base_url != null) {
                            try {
                               base_urls = base_url.innerText;
                                base_url.remove();
                            } catch (err) {
                            }
                        }
						const request = fetch(base_urls + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=optiontemplates.optiontemplatesvaluesordering&format=raw", {
							method: 'POST',
							mode: 'cors',
							cache: 'no-cache',
							credentials: 'same-origin',
							headers: {
								'Content-Type': 'application/json'
							},
							redirect: 'follow',
							referrerPolicy: 'no-referrer',
							body: JSON.stringify(params)
						});
			});
		});
</script>

