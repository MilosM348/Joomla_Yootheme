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

<div id="p2s_emaillogs" v-cloak>
	<!-- <div class="uk-margin-left"> -->
		<div class="main-section">   
		<div class="uk-grid center-section" uk-grid="">
			<div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
				<div class="uk-card uk-card-default">
					<div class="uk-card-header">
						<div class="uk-grid uk-grid-small">
							<div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
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
									<?= Text::_('COM_COMMERCELAB_SHOP_EMAILLOGS_TITLE'); ?>
								</h3>
							</div>
							<div class="uk-width-1-2@s uk-width-1-2@m uk-width-1-2@l uk-width-1-2@xl">
								<div class="uk-grid uk-grid-small " uk-grid="">
									<div class="uk-width-auto uk-margin-auto-left">
										<input @input="doTextSearch($event)" type="text" placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_TABLE_SEARCH_PLACEHOLDER'); ?>">
									</div>
									<!-- <div class="uk-width-auto"></div> -->
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

								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILLOGS_TABLE_ID'); ?>
									<a href="#" @click="sort('id')" class="uk-margin-small-right uk-icon"
									   uk-icon="triangle-down">
									</a>
								</th>
								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILLOGS_TABLE_ADDRESS'); ?>
									<a href="#" @click="sort('emailaddress')" class="uk-margin-small-right uk-icon"
									   uk-icon="triangle-down">
									</a>
								</th>

								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILLOGS_TABLE_EMAIL_TYPE'); ?>
									<a href="#" @click="sort('emailtype')" class="uk-margin-small-right uk-icon"
									   uk-icon="triangle-down">
									</a>
								</th>
								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILLOGS_TABLE_DATE_SENT'); ?>
									<a href="#" @click="sort('sentdate')" class="uk-margin-small-right uk-icon"
									   uk-icon="triangle-down">
									</a>
								</th>
								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILLOGS_TABLE_CUSTOMER'); ?>
									<a href="#" @click="sort('customerid')" class="uk-margin-small-right uk-icon"
									   uk-icon="triangle-down">
									</a>
								</th>
								<th class="uk-text-left"><?= Text::_('COM_COMMERCELAB_SHOP_EMAILLOGS_TABLE_ORDER_NUMBER'); ?>
									<a href="#" @click="sort('order_id')" class="uk-margin-small-right uk-icon"
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
									{{item.id}}
								</td>
								<td>
									{{item.emailaddress}}
								</td>
								<td>
									{{item.emailtype}}
								</td>
								<td>
									{{item.sentdate}}
								</td>
								<td>
                                    <a :href="'index.php?option=COM_COMMERCELAB_SHOP&view=customer&id=' + item.customer_id">{{item.customer_name}}</a>
								</td>
								<td>
                                    <a :href="'index.php?option=COM_COMMERCELAB_SHOP&view=order&id=' + item.order_id">{{item.order_number}}</a>
								</td>
								<td >

								</td>


							</tr>


							</tbody>
						</table>

						<h5 v-show="itemsChunked.length == 0"><?= Text::_('COM_COMMERCELAB_SHOP_EMAIL_LOGS_EMPTY_TABLE'); ?></h5>
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
							<h4> Controls</h4>
						</div>
						<div class="uk-card-body">
							<ul class="uk-nav-default uk-nav-parent-icon" uk-nav>


								<li class="uk-nav-divider"></li>
								<li>
									<a  @click="trashSelected"  :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
										<span class="uk-margin-small-right" uk-icon="icon: trash"></span>
										Trash Selected
									</a>
								</li>
								<li>
									<a  @click="toggleSelected"  :class="[selected.length == 0 ? 'uk-disabled' : ' uk-text-bold uk-text-emphasis']">
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