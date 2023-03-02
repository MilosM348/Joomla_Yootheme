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
use CommerceLabShop\Order\Order;

/** @var  $displayData array */
$data = $displayData;


?>

<div class="uk-card uk-card-default uk-card-small uk-card-hover">
    <div class="uk-card-header">

        <div class="uk-grid" uk-grid="">
            <div class="uk-width-expand">
                <h4><?= Text::_('COM_COMMERCELAB_SHOP_LATEST_ORDERS'); ?> &nbsp; <i class="fad fa-box-check"></i>
                </h4>

            </div>
            <div class="uk-width-auto">
                <a class="uk-icon-link uk-icon"
                   href="index.php?option=com_commercelab_shop&view=orders"
                   title="" data-uk-tooltip="" data-uk-icon="icon: arrow-right"
                   aria-expanded="false"><?= Text::_('COM_COMMERCELAB_SHOP_SEE_ALL'); ?></a>
            </div>
        </div>

    </div>
    <div class="uk-card-body uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover uk-table-responsive" id="orderList">
            <thead></thead>
            <thead>
            <tr>
                <th> <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_NUMBER'); ?></th>
                <th> <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_NOTES'); ?></th>
                <th> <?= Text::_('COM_COMMERCELAB_SHOP_CUSTOMER'); ?></th>
                <th> <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_STATUS'); ?></th>
                <th> <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_DATE'); ?></th>
                <th> <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_TOTAL'); ?></th>
            </tr>
            </thead>
            <tbody [hidden]="orderloading" class="uk-animation-fade uk-animation-fast">
			<?php if ($data['orders']) : ?>
				<?php
				/** @var Order $order */
				/** @var array $vars */
				foreach ($data['orders'] as $order) : ?>
                    <tr>
                        <td>
                            <div class="name">
                                <a href="index.php?option=com_commercelab_shop&view=order&id=<?= $order->id; ?>"><?= $order->order_number; ?></a>
                            </div>
                        </td>

                        <td>
							<?php if ($order->customer_notes) : ?>
                                <svg href="#notesmodal<?= $order->id; ?>" uk-toggle
                                     style="width: 12px; cursor: pointer" aria-hidden="true" focusable="false"
                                     data-prefix="fal" data-icon="file-alt"
                                     class="svg-inline--fa fa-file-alt fa-w-12" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path fill="currentColor"
                                          d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zm-22.6 22.7c2.1 2.1 3.5 4.6 4.2 7.4H256V32.5c2.8.7 5.3 2.1 7.4 4.2l83.9 83.9zM336 480H48c-8.8 0-16-7.2-16-16V48c0-8.8 7.2-16 16-16h176v104c0 13.3 10.7 24 24 24h104v304c0 8.8-7.2 16-16 16zm-48-244v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12z"></path>
                                </svg>
                                <!-- This is the modal -->
                                <div id="notesmodal<?= $order->id; ?>" uk-modal>
                                    <div class="uk-modal-dialog">
                                        <button class="uk-modal-close-outside" type="button" uk-close></button>
                                        <div class="uk-modal-header">
                                            <h4><?= Text::sprintf('COM_COMMERCELAB_SHOP_CUSTOMERNOTES_MODAL_TITLE', $order->order_number); ?></h4>
                                        </div>
                                        <div class="uk-modal-body">
                                            <p><?= $order->customer_notes; ?></p>
                                        </div>
                                        <div class="uk-modal-footer">
                                            <div class="uk-grid" uk-grid="">
                                                <div class="uk-width-expand"></div>
                                                <div class="uk-width-auto">
                                                    <button class="uk-button uk-button-default uk-button-small uk-modal-close"
                                                            type="button"><?= Text::_('COM_COMMERCELAB_SHOP_MODAL_CLOSE'); ?></button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php else : ?>
                                <svg style="width: 12px" aria-hidden="true" focusable="false" data-prefix="fal"
                                     data-icon="file"
                                     class="svg-inline--fa fa-file fa-w-12" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path fill="currentColor"
                                          d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zm-22.6 22.7c2.1 2.1 3.5 4.6 4.2 7.4H256V32.5c2.8.7 5.3 2.1 7.4 4.2l83.9 83.9zM336 480H48c-8.8 0-16-7.2-16-16V48c0-8.8 7.2-16 16-16h176v104c0 13.3 10.7 24 24 24h104v304c0 8.8-7.2 16-16 16z"></path>
                                </svg>
							<?php endif; ?>
                        </td>

                        <td><?= (!$order->guest_pin) ? $order->customer_name : 'Guest User'; ?></td>

                        <td>
                            <span class="uk-label uk-label-<?= strtolower($order->order_status); ?>">
                                <?= $order->order_status_formatted; ?>
                            </span>
                        </td>

                        <td><?= $order->order_date; ?></td>
                        <td> <?= $order->order_total_formatted; ?></td>
                    </tr>
				<?php endforeach; ?>
			<?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
