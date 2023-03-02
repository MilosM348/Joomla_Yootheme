<?php
/**
 * @package     CommerceLab Shop - Customer Orders
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

use CommerceLabShop\Address\Address;
use CommerceLabShop\Utilities\Utilities;

/**  @var $params */
/**  @var $orders array */
/**  @var $order CommerceLabShop\Order\Order */
/**  @var $product CommerceLabShop\Order\OrderedProduct */
/**  @var $address Address */


\CommerceLabShop\Language\LanguageFactory::load();

?>


<table class="uk-table uk-table-hover uk-table-divider uk-table-striped uk-table-responsive">
    <thead>
    <tr>
        <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_NUMBER'); ?></th>
        <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_STATUS'); ?></th>
        <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_DATE'); ?></th>
        <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_PAID'); ?></th>
        <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_TOTAL'); ?></th>
    </tr>
    </thead>
    <tbody>

	<?php foreach ($orders as $order) : ?>
        <tr>
            <td><a href="#order<?= $order->id; ?>" uk-toggle><?= $order->order_number; ?></a></td>
            <td>
                <span class="uk-label uk-label-<?= strtolower($order->order_status); ?>"><?= Text::_(Utilities::selectionTranslation($order->order_status, 'order_status')); ?></span>
            </td>
            <td><?= HtmlHelper::date($order->order_date, Text::_($params->get('date_format', 'DATE_FORMAT_LC6'))); ?></td>
            <td><?= Text::_(Utilities::selectionTranslation($order->order_paid, 'order_paid')); ?></td>
            <td><?= $order->order_total_formatted ?></td>
        </tr>

	<?php endforeach; ?>
    </tbody>
</table>

<?php foreach ($orders as $order) : ?>
    <div id="order<?= $order->id; ?>" class="uk-modal-container yps-order-modal" uk-modal>
        <div class="uk-modal-dialog ">
            <button class="uk-modal-close-outside" type="button" uk-close></button>
            <div class="uk-modal-header">
                <div class="uk-grid" uk-grid>
                    <div class="uk-width-expand"><h2 class="uk-modal-title "><?= Text::_('COM_COMMERCELAB_SHOP_ORDER'); ?>
                            #<?= $order->order_number; ?></h2></div>
                    <div class="uk-width-auto">
                        <span class="uk-label uk-label-<?= strtolower($order->order_status); ?>"><?= Text::_(Utilities::selectionTranslation($order->order_status, 'order_status')); ?></span>
                    </div>
                </div>

            </div>
            <div class="uk-modal-body">
                <div class="uk-grid" uk-grid>

                    <div class="uk-width-1-2@m">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
								<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_ORDER_DETAILS'); ?>
                            </div>
                            <div class="uk-card-body">
                                <ul class="uk-list uk-margin-medium uk-width-1-1">
									<?php foreach ($order->ordered_products as $product) : ?>
                                        <li class="el-item">
                                            <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                                 uk-grid="">
                                                <div class="uk-width-expand uk-first-column">
                                         <span class="el-title uk-display-block uk-leader" uk-leader="">
                                             <span class="uk-leader-fill"><?= $product->j_item_name; ?></span></span>
                                                </div>
                                                <div>
                                                    <div class=" uk-h5 uk-margin-remove"><?= $product->price_at_sale_formatted; ?></div>
                                                </div>
                                            </div>
                                        </li>

									<?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="uk-card uk-card-default uk-margin-top">
                            <div class="uk-card-header">
								<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_ORDER_SUMMARY'); ?>
                            </div>
                            <div class="uk-card-body">
                                <ul class="uk-list uk-margin-medium uk-width-1-1">
                                    <li class="el-item">
                                        <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                             uk-grid="">
                                            <div class="uk-width-expand uk-first-column">
                <span class="el-title uk-display-block uk-leader" uk-leader="">
                    <span class="uk-leader-fill"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_SUBTOTAL'); ?></span></span></div>
                                            <div>
                                                <div class=" uk-h5 uk-margin-remove"><?= $order->order_subtotal_formatted; ?></div>
                                            </div>
                                        </div>


                                    </li>
                                    <li class="el-item">

                                        <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                             uk-grid="">
                                            <div class="uk-width-expand uk-first-column">
                <span class="el-title uk-display-block uk-leader" uk-leader=""><span
                            class="uk-leader-fill"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_ORDER_SHIPPING'); ?></span></span>
                                            </div>
                                            <div>
                                                <div class=" uk-h5 uk-margin-remove"><?= $order->shipping_total_formatted; ?></div>
                                            </div>
                                        </div>


                                    </li>
                                    <li class="el-item">

                                        <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                             uk-grid="">
                                            <div class="uk-width-expand uk-first-column">
                <span class="el-title uk-display-block uk-leader" uk-leader=""><span
                            class="uk-leader-fill"><?= Text::_('COM_COMMERCELAB_SHOP_DISCOUNTS_TITLE'); ?></span></span>
                                            </div>
                                            <div>
                                                <div class=" uk-h5 uk-margin-remove "><?= $order->discount_total_formatted; ?></div>
                                            </div>
                                        </div>

                                    </li>
                                    <li class="el-item">

                                        <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                             uk-grid="">
                                            <div class="uk-width-expand uk-first-column">
                <span class="el-title uk-display-block uk-leader" uk-leader=""><span
                            class="uk-leader-fill"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_ORDER_TAX'); ?></span></span>
                                            </div>
                                            <div>
                                                <div class=" uk-h5 uk-margin-remove"><?= $order->tax_total_formatted; ?></div>
                                            </div>
                                        </div>

                                    </li>


                                    <li class=" el-item">

                                        <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                             uk-grid="">
                                            <div class="uk-width-expand uk-first-column">
                                            <span class="el-title uk-display-block uk-leader" uk-leader=""><span
                                                        class="uk-leader-fill"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_TOTAL'); ?></span></span>
                                            </div>
                                            <div>
                                                <div class=" uk-h5 uk-margin-remove"><?= $order->order_total_formatted; ?></div>
                                            </div>
                                        </div>


                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-2@m">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
								<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_PAYMENT_DETAILS'); ?>
                            </div>
                            <div class="uk-card-body">
                                <ul class="uk-list uk-margin-medium uk-width-1-1">
                                    <li class="el-item">
                                        <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                             uk-grid="">
                                            <div class="uk-width-expand uk-first-column">
                                         <span class="el-title uk-display-block uk-leader" uk-leader="">
                                             <span class="uk-leader-fill"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_PAYMENT_METHOD'); ?></span></span>
                                            </div>
                                            <div>
                                                <div class=" uk-h5 uk-margin-remove"><?= $order->payment_method; ?></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="el-item">
                                        <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                             uk-grid="">
                                            <div class="uk-width-expand uk-first-column">
                                         <span class="el-title uk-display-block uk-leader" uk-leader="">
                                             <span class="uk-leader-fill"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_PAYMENT_STATUS'); ?></span></span>
                                            </div>
                                            <div>

                                                <div class=" uk-h5 uk-margin-remove"><?= ($order->order_paid == '1' ? Text::_('COM_COMMERCELAB_SHOP_ORDER_ORDER_PAID_LABEL') : Text::_('COM_COMMERCELAB_SHOP_ORDER_ORDER_UNPAID')); ?></div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="uk-card uk-card-default uk-margin-top">
                            <div class="uk-card-header">
								<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_SHIPPING_DETAILS'); ?>
                            </div>
                            <div class="uk-card-body">
								<?php $address = $order->shipping_address; ?>
								<?= $address->address_as_csv; ?>
                            </div>
                        </div>
						<?php if ($order->tracking_code) : ?>
                            <div class="uk-card uk-card-default uk-margin-top">
                                <div class="uk-card-header">
									<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERORDERS_TRACKING_DETAILS'); ?>
                                </div>
                                <div class="uk-card-body">
                                    <ul class="uk-list uk-margin-medium uk-width-1-1">
                                        <li class="el-item">
                                            <div class="uk-child-width-auto uk-grid-small uk-flex-bottom uk-grid"
                                                 uk-grid="">
                                                <div class="uk-width-expand uk-first-column">
                                                     <span class="el-title uk-display-block uk-leader" uk-leader="">
                                                         <span class="uk-leader-fill">
                                                             <?php
                                                             $url = parse_url($order->tracking_link);
                                                             echo $url['host'];
                                                             ?>
                                                         </span>
                                                     </span>
                                                </div>
                                                <div>
                                                    <div class="uk-margin-remove">
                                                        <a href="<?= $order->tracking_link; ?>" target="_blank">
															<?= $order->tracking_code; ?>
                                                            <svg width="15px" aria-hidden="true" focusable="false"
                                                                 data-prefix="fal" data-icon="external-link"
                                                                 class="svg-inline--fa fa-external-link fa-w-8"
                                                                 role="img" xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 512 512">
                                                                <path fill="currentColor"
                                                                      d="M440,256H424a8,8,0,0,0-8,8V464a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V112A16,16,0,0,1,48,96H248a8,8,0,0,0,8-8V72a8,8,0,0,0-8-8H48A48,48,0,0,0,0,112V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V264A8,8,0,0,0,440,256ZM500,0,364,.34a12,12,0,0,0-12,12v10a12,12,0,0,0,12,12L454,34l.7.71L131.51,357.86a12,12,0,0,0,0,17l5.66,5.66a12,12,0,0,0,17,0L477.29,57.34l.71.7-.34,90a12,12,0,0,0,12,12h10a12,12,0,0,0,12-12L512,12A12,12,0,0,0,500,0Z"></path>
                                                            </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
						<?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        if (location.hash) {
            UIkit.modal(location.hash).show();
        }
    });
</script>


