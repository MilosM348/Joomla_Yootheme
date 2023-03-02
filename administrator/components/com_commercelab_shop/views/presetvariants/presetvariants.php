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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var array $vars */

?>


<div id="p2s_presetvariants">
	<div class="uk-margin-left">
		<div class="uk-grid" uk-grid="">
			<div class="uk-width-3-4">
				<div class="uk-card uk-card-default">
					<div class="uk-card-header">
						<div class="uk-grid uk-grid-small">
							<div class="uk-width-expand">
								<h3>
                                    <svg width="18px" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="ballot" class="svg-inline--fa fa-ballot fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M144 80h-32c-17.7 0-32 14.4-32 32v32c0 17.6 14.3 32 32 32h32c17.7 0 32-14.4 32-32v-32c0-17.6-14.3-32-32-32zm0 64h-32v-32h32v32zM416 0H32C14.3 0 0 14.4 0 32v448c0 17.6 14.3 32 32 32h384c17.7 0 32-14.4 32-32V32c0-17.6-14.3-32-32-32zm0 480H32V32h384v448zm-72-240H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm-200 96h-32c-17.7 0-32 14.4-32 32v32c0 17.6 14.3 32 32 32h32c17.7 0 32-14.4 32-32v-32c0-17.6-14.3-32-32-32zm0 64h-32v-32h32v32zm200-32H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm0-256H216c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h128c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm-200 96h-32c-17.7 0-32 14.4-32 32v32c0 17.6 14.3 32 32 32h32c17.7 0 32-14.4 32-32v-32c0-17.6-14.3-32-32-32zm0 64h-32v-32h32v32z"></path></svg>
									<?= Text::_('COM_COMMERCELAB_SHOP_PRESET_VARIANTS'); ?>
								</h3>
							</div>

							<div class="uk-width-auto uk-text-right">
								<div class="uk-grid uk-grid-small " uk-grid="">

									<div class="uk-width-auto">

										<div class="uk-grid uk-grid-small" uk-grid="">
											<div class="uk-width-expand  ">
												<input v-model="enteredText"
												       @input="doTextSearch($event)"
												       type="text"
												       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
											</div>
											<div class="uk-width-auto uk-grid-item-match uk-flex-middle">
                                            <span style="width: 20px">
                                            <span @click="cleartext" v-show="enteredText" style="cursor: pointer"
                                                  uk-icon="icon: close"></span>
                                                </span>
											</div>
										</div>


									</div>
									<div class="uk-width-auto">

									</div>
									<div class="uk-width-auto">

									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="uk-card-body">

						<table v-show="itemsChunked.length > 0"
						       class="uk-table uk-table-striped uk-table-divider uk-table-hover uk-table-responsive  uk-table-middle">
							<thead>
							<tr>

								<th class="uk-text-left">
								</th>
								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_PRESET_VARIANTS_NAME'); ?>
									<a href="#" @click="sort('name')" class="uk-margin-small-right uk-icon"
									   uk-icon="triangle-down">
									</a>
								</th>
								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_PRESET_VARIANTS_ITEMS'); ?>
									<a href="#" @click="sort('items')" class="uk-margin-small-right uk-icon"
									   uk-icon="triangle-down">
									</a>
								</th>
							</tr>
							</thead>

							<tbody>
							<tr v-for="item in itemsChunked[currentPage]">
								<td>
									<div><input type="checkbox"></div>
								</td>
								<td>
									<a :href="'index.php?option=com_commercelab_shop&view=order&id=' + order.id">{{item.name}}</a>
								</td>
								<td>
									{{item.items}}
								</td>



							</tr>


							</tbody>

						</table>

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
			<div class="uk-width-1-4">
				<div>

				</div>
			</div>
		</div>

	</div>
</div>
