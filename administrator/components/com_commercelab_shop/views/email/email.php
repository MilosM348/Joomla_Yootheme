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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

/** @var array $vars */
$item = $vars['item'];

?>

<div id="cls_email_form" v-cloak class="uk-animation-fade">
	<form @submit.prevent="saveItem">
        <input type="hidden" id="copytext" :value="copytext">
		<div class="uk-grid" uk-grid="">
			<div class="uk-width-1-1">
				<div>
                    <nav class="uk-navbar-container uk-flex-wrap uk-padding-small editing-save" uk-navbar style="border-radius: 8px" style=" z-index: 980;" uk-sticky="show-on-up: true; animation: uk-animation-slide-top; bottom: #bottom">
                        <!-- <nav class="uk-navbar-container uk-padding-small editing-save" uk-navbar style="border-radius: 8px" uk-sticky="offset: 20"> -->
						<div class="uk-navbar-left">
                            <span class="uk-navbar-item uk-logo">
                                    <?= Text::_('COM_COMMERCELAB_SHOP_ADD_DISCOUNTS_MODAL_EDITING'); ?>  {{form.jform_subject}}
                            </span>
						</div>

						<div class="uk-navbar-right">

                            <button type="submit" class="uk-button uk-button-default button-success uk-button-small uk-margin-right">
								<?= Text::_('JTOOLBAR_APPLY'); ?>
							</button>
							<button type="submit" @click="andClose = true"  class="uk-button uk-button-default button-success uk-button-small uk-margin-right">
								<?= Text::_('JTOOLBAR_SAVE'); ?>
							</button>
							<a class="uk-button uk-button-default uk-button-small" href="index.php?option=com_commercelab_shop&view=emailmanager">
                                <?= Text::_('JTOOLBAR_CANCEL'); ?>
                            </a>

						</div>
					</nav>
				</div>
			</div>
        </div>
        <div class="main-section uk-grid-margin">
            <div class="uk-grid center-section" uk-grid="">
				<div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl">
					<?= LayoutHelper::render('card', [
						'form'      => $vars['form'],
						'cardStyle' => 'default',
						'cardTitle' => 'COM_COMMERCELAB_SHOP_ADDEMAIL_TITLE',
						'cardId'    => 'details',
						'fields'    => ['to', 'subject', 'emailtype', 'body', 'language', 'published']
					]); ?>
				</div>
            </div>
            <div class="right-bar">
                <div class="right-bar-inner">
                    <div class="uk-card uk-card-default uk-margin-bottom">
                        <div class="uk-card-header">
                            <h5><?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_AVAILABLE_SHORTCODES'); ?></h5>
                        </div>
                        <div class="uk-card-body">
                            <ul uk-accordion class="uk-margin-remove">
                                <li>
                                    <a class="uk-accordion-title" href="#">
                                        <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_GLOBAL'); ?>        
                                    </a>

                                    <div class="uk-accordion-content">
                                        <ul class="uk-list">

                                            <li style="cursor: pointer" @click="copyText('{site_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SITENAME'); ?> 
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block" class="uk-text-bold uk-display-block">&#123;site_name&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shop_name}')">
                                                <?= Text::_('Shop Name'); ?> 
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block" class="uk-text-bold uk-display-block">&#123;shop_name&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shop_logo}')">
                                                <?= Text::_('Shop Logo Url'); ?> 
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block" class="uk-text-bold uk-display-block">&#123;shop_logo&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shop_brandcolour}')">
                                                <?= Text::_('Shop Brand Color'); ?> 
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block" class="uk-text-bold uk-display-block">&#123;shop_brandcolour&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shop_email}')">
                                                <?= Text::_('Shop Email'); ?> 
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block" class="uk-text-bold uk-display-block">&#123;shop_email&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{admin_email}')">
                                                <?= Text::_('Admin Email (Global Config'); ?> 
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block" class="uk-text-bold uk-display-block">&#123;admin_email&#125;</span> 
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#"><?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_INFO'); ?></a>
                                    <div class="uk-accordion-content">
                                        <ul class="uk-list">

                                            <li style="cursor: pointer" @click="copyText('{order_number}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_NUMBER'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;order_number&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{order_grand_total}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_GRANDTOTAL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;order_grand_total&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{order_subtotal}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_SUBTOTAL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;order_subtotal&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{order_shipping_total}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_SHIPPINGTOTAL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;order_shipping_total&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{order_currency_symbol}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_CURRENCY'); ?> Symbol
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;order_currency_symbol&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{order_date}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_DATE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;order_date&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{order_payment_method}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_ORDER_PAYMENT_METHOD'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;order_payment_method&#125;</span> 
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#"><?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_TRACKING_INFO'); ?></a>
                                    <div class="uk-accordion-content">
                                        <ul class="uk-list">

                                            <li style="cursor: pointer" @click="copyText('{tracking_code}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_TRACKING_CODE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;tracking_code&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{tracking_url}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_TRACKING_URL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;tracking_url&#125;</span>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">
                                        <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_CUSTOMER_INFO'); ?>
                                    </a>
                                    <div class="uk-accordion-content">
                                        <ul class="uk-list">

                                            <li style="cursor: pointer" @click="copyText('{customer_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_CUSTOMER_NAME'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;customer_name&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{customer_email}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_CUSTOMER_EMAIL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;customer_email&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{customer_order_count}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_CUSTOMER_ORDERCOUNT'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;customer_order_count&#125;</span>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                <li>

                                    <a class="uk-accordion-title" href="#">
                                        <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS'); ?>        
                                    </a>

                                    <div class="uk-accordion-content">
                                        <ul class="uk-list">

                                            <li style="cursor: pointer" @click="copyText('{shipping_first_name}, {shipping_last_name}, {shipping_email}, {shipping_address1}, {shipping_address2}, {shipping_address3}, {shipping_city}, {shipping_state}, {shipping_country}, {shipping_postcode}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_FULL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;full_shipping_address&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_first_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_FIRST_NAME'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_first_name&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_last_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_LAST_NAME'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_last_name&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_email}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_EMAIL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_email&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_address1}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_LINE1'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_address1&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_address2}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_LINE2'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_address2&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_address3}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_LINE3'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_address3&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_city}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_CITY'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_city&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_state}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_STATE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_state&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_country}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_COUNTRY'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_country&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_postcode}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_POSTCODE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_postcode&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_email}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_EMAIL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_email&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_mobile}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_MOBILE'); ?> No.
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_mobile&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{shipping_phone}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_SHIPPING_ADDRESS_PHONE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_phone&#125;</span>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title" href="#">
                                        <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS'); ?>        
                                    </a>

                                    <div class="uk-accordion-content">
                                        <ul class="uk-list">

                                            <li style="cursor: pointer" @click="copyText('{billing_first_name}, {billing_last_name}, {billing_email}, {billing_address1}, {billing_address2}, {billing_address3}, {billing_city}, {billing_state}, {billing_country}, {billing_postcode}, {billing_vat}, {billing_company_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_FULL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;full_billing_address&#125;</span>
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_first_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_FIRST_NAME'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_first_name&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_last_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_LAST_NAME'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_last_name&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_email}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_EMAIL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_email&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_address1}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_LINE1'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_address1&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_address2}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_LINE2'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_address2&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_address3}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_LINE3'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_address3&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_city}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_CITY'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_city&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_state}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_STATE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_state&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_country}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_COUNTRY'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_country&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_postcode}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_POSTCODE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_postcode&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_email}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_EMAIL'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_email&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_mobile}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_MOBILE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_mobile&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_phone}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_ADDRESS_PHONE'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;shipping_phone&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_vat}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_VAT'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_vat&#125;</span> 
                                            </li>

                                            <li style="cursor: pointer" @click="copyText('{billing_company_name}')">
                                                <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_SHORTCODES_BILLING_COMPANY_NAME'); ?>
                                                <span uk-icon="icon: copy"></span>
                                                <span class="uk-text-bold uk-display-block">&#123;billing_company_name&#125;</span> 
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
<!--                     <div class="uk-card uk-card-default">
                        <div class="uk-card-header"><h5><?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_HELP'); ?></h5></div>
                        <div class="uk-card-body">
                            <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_TO_MODAL_MESSAGE'); ?>
                            <?= Text::_('COM_COMMERCELAB_SHOP_ADDEMAIL_EMAIL_TYPES_MODAL_MESSAGE'); ?>
                        </div>
                        <div class="uk-card-footer"></div>
                    </div> -->
                </div>
			</div>
		</div>
	</form>
</div>

</div>


