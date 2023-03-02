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

$data  = $displayData;
$order = $data['item'];

?>


<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
					<?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>
            <div class="uk-width-auto">
				<?php if ($order->customer_id === 0) : ?>
                    <button type="button" class="uk-button uk-button-primary uk-button-small">
                        <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_ATTACH_CUSTOMER_BUTTON'); ?>
                    </button>
				<?php endif; ?>
            </div>

        </div>
    </div>

    <div class="uk-card-body uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <tbody>
            <tr>
                <td class="uk-text-nowrap uk-table-shrink">
                    <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_CUSTOMER_FULL_NAME'); ?>:</div>
                </td>
                <td>
                    <div class="el-content uk-panel">
						<?php if ($order->guest_pin) : ?>
                            <span>
                            <?php if ($order->billing_address->first_name && $order->billing_address->first_name != '') : ?>

                                <?= $order->billing_address->first_name; ?> <?= $order->billing_address->last_name ?> (Guest)

                            <?php elseif ($order->shipping_address->first_name && $order->shipping_address->first_name != '') : ?>

                                <?= $order->billing_address->first_name; ?> <?= $order->billing_address->last_name ?> (Guest)

                            <?php else : ?>
                                Guest
                            <?php endif; ?>
                            </span>
						<?php else : ?>
                            <a href="index.php?option=com_commercelab_shop&view=customer&id=<?= $order->customer_id; ?>">
                                <?= $order->customer_name; ?>
                                <i class="fal fa-external-link"></i>
                            </a>
						<?php endif; ?>
                    </div>
                </td>
                <td class="uk-text-nowrap uk-table-shrink">
                    <span style="cursor: pointer;">
                        <svg class="svg-inline--fa fa-copy fa-w-14"
                            aria-hidden="true"
                            focusable="false" data-prefix="fal" data-icon="copy" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M433.941 65.941l-51.882-51.882A48 48 0 0 0 348.118 0H176c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h224c26.51 0 48-21.49 48-48v-48h80c26.51 0 48-21.49 48-48V99.882a48 48 0 0 0-14.059-33.941zM352 32.491a15.88 15.88 0 0 1 7.431 4.195l51.882 51.883A15.885 15.885 0 0 1 415.508 96H352V32.491zM288 464c0 8.822-7.178 16-16 16H48c-8.822 0-16-7.178-16-16V144c0-8.822 7.178-16 16-16h80v240c0 26.51 21.49 48 48 48h112v48zm128-96c0 8.822-7.178 16-16 16H176c-8.822 0-16-7.178-16-16V48c0-8.822 7.178-16 16-16h144v72c0 13.2 10.8 24 24 24h72v240z">
                            </path>
                        </svg>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="uk-text-nowrap">
                    <div class="el-title"><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_CUSTOMER_EMAIL'); ?>:</div>
                </td>
                <td>
                    <div id="customer_email" class="el-content uk-panel">

                        <?php if ($order->guest_pin) : ?>
                            <?php if ($order->billing_address->email && $order->billing_address->email != '') : ?>

                                <?= $order->billing_address->email; ?>

                            <?php elseif ($order->shipping_address->email && $order->shipping_address->email != '') : ?>

                                <?= $order->billing_address->email; ?>

                            <?php endif; ?>
                        <?php else : ?>
                            <?= $order->customer_email; ?>        
                        <?php endif; ?>
                    </div>
                </td>
                <td class="uk-text-nowrap uk-table-shrink">
                            <span style="cursor: pointer;">
                              <svg class="svg-inline--fa fa-copy fa-w-14"
                                   aria-hidden="true"
                                   focusable="false" data-prefix="fal" data-icon="copy" role="img"
                                   xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                      d="M433.941 65.941l-51.882-51.882A48 48 0 0 0 348.118 0H176c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h224c26.51 0 48-21.49 48-48v-48h80c26.51 0 48-21.49 48-48V99.882a48 48 0 0 0-14.059-33.941zM352 32.491a15.88 15.88 0 0 1 7.431 4.195l51.882 51.883A15.885 15.885 0 0 1 415.508 96H352V32.491zM288 464c0 8.822-7.178 16-16 16H48c-8.822 0-16-7.178-16-16V144c0-8.822 7.178-16 16-16h80v240c0 26.51 21.49 48 48 48h112v48zm128-96c0 8.822-7.178 16-16 16H176c-8.822 0-16-7.178-16-16V48c0-8.822 7.178-16 16-16h144v72c0 13.2 10.8 24 24 24h72v240z">
                                </path>
                              </svg>
                            </span>
                </td>
            </tr>
            </tbody>
        </table>

    </div>


    <!-- <div class="uk-card-footer"></div> -->
</div>
