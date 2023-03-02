<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>

<div id="p2s_module_latestorders" class="uk-card uk-card-default uk-card-small uk-card-hover">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-auto">
                <h4><?= Text::_('COM_COMMERCELAB_SHOP_LATEST_ORDERS'); ?>
                    <svg width="18px" class="svg-inline--fa fa-box-check fa-w-20" aria-hidden="true"
                         focusable="false" data-prefix="fad" data-icon="box-check" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                        <g class="fa-group">
                            <path class="fa-secondary" fill="currentColor"
                                  d="M448 128c-106 0-192 86-192 192s86 192 192 192 192-86 192-192-86-192-192-192zm114.1 147.8l-131 130a11 11 0 0 1-15.6-.1l-75.7-76.3a11 11 0 0 1 .1-15.6l26-25.8a11 11 0 0 1 15.6.1l42.1 42.5 97.2-96.4a11 11 0 0 1 15.6.1l25.8 26a11 11 0 0 1-.1 15.5z"></path>
                            <path class="fa-primary" fill="currentColor"
                                  d="M240 0H98.6a47.87 47.87 0 0 0-45.5 32.8L2.5 184.6c-.8 2.4-.8 4.9-1.2 7.4H240zm208 80a221.93 221.93 0 0 1 27.2 1.7l-16.3-48.8A47.83 47.83 0 0 0 413.4 0H272v157.4C315.9 109.9 378.4 80 448 80zM208 320a238.53 238.53 0 0 1 20.2-96H0v240a48 48 0 0 0 48 48h256.6C246.1 468.2 208 398.6 208 320zm354.2-59.7l-25.8-26a11 11 0 0 0-15.6-.1l-97.2 96.4-42.1-42.5a11 11 0 0 0-15.6-.1l-26 25.8a11 11 0 0 0-.1 15.6l75.7 76.3a11 11 0 0 0 15.6.1l131-130a11 11 0 0 0 .1-15.5z"></path>
                        </g>
                    </svg>
                </h4>
            </div>
            <div class="uk-width-expand uk-text-right panel-icons">
                <a title="" data-uk-tooltip=""
                        data-uk-icon="icon: arrow-right" class="uk-icon-link uk-icon"
                        href="/administrator/index.php?option=com_commercelab_shop&view=orders">See All
                    <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" points="10 5 15 9.5 10 14"></polyline>
                        <line fill="none" stroke="#000" x1="4" y1="9.5" x2="15" y2="9.5"></line>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <div>
            <table id="orderList"
                   class="uk-table uk-table-striped uk-table-hover uk-table-responsive">
                <thead></thead>
                <thead>
                <tr>
                    <th> Order Number</th>
                    <th> Order Notes</th>
                    <th> Customer</th>
                    <th> Status</th>
                    <th> Date</th>
                    <th> Total</th>
                </tr>
                </thead>
                <div uk-spinner="ratio: 0.75" class="uk-icon uk-spinner" hidden="">
                    <svg width="22.5" height="22.5" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                        <circle fill="none" stroke="#000" cx="15" cy="15" r="14"
                                style="stroke-width: 1.33333px;"></circle>
                    </svg>
                </div>
                <tbody class="uk-animation-fade">
                <tr>
                    <td>
                        <div class="name">
                            <a href="/administrator/index.php/order/482">DJNIH54425</a>
                        </div>
                    </td>
                    <td><a uk-toggle=""
                           uk-tooltip="See Customers Notes" href="#notesmodal0" title=""
                           aria-expanded="false">
                            <svg width="25" height="25" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg" data-svg="file-text" style="color: black;">
                                <rect fill="none" stroke="#000" width="13" height="17"
                                      x="3.5" y="1.5"></rect>
                                <line fill="none" stroke="#000" x1="6" x2="12" y1="12.5"
                                      y2="12.5"></line>
                                <line fill="none" stroke="#000" x1="6" x2="14" y1="8.5"
                                      y2="8.5"></line>
                                <line fill="none" stroke="#000" x1="6" x2="14" y1="6.5"
                                      y2="6.5"></line>
                                <line fill="none" stroke="#000" x1="6" x2="14" y1="10.5"
                                      y2="10.5"></line>
                            </svg>
                        </a>
                        <div uk-modal="" id="notesmodal0" class="uk-modal">
                            <div class="uk-modal-dialog uk-modal-body">
                                <button type="button" uk-close=""
                                        class="uk-modal-close-outside uk-icon uk-close">
                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13"
                                              y2="13"></line>
                                        <line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1"
                                              y2="13"></line>
                                    </svg>
                                </button>
                                <h2 class="uk-modal-title">Customer Notes for order
                                    DJNIH54425</h2>
                                <p>Sed fringilla mauris sit amet nibh. Donec elit libero,
                                    sodales nec, volutpat a, suscipit non, turpis. Aenean commodo ligula eget
                                    dolor. s</p></div>
                        </div>
                    </td>
                    <td> CommerceLab</td>
                    <td><span class="uk-label uk-label-p">Pending</span></td>
                    <td> 2020-11-16 10:51:15</td>
                    <td> £240.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
