<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Product\ProductFactory;


$language = Factory::getLanguage();
$language->load('com_commercelab_shop', JPATH_ADMINISTRATOR);

$config = $displayData['config'];
//
$shop_name              = $config->get('shop_name');
$shop_logo              = Uri::root() . $config->get('shop_logo');
$supportemail           = $config->get('supportemail');
$shop_brandcolour       = $config->get('shop_brandcolour');
$shop_brandcolour_light = Utilities::adjustBrightness($shop_brandcolour, 2);

$order = $displayData['order'];
$body  = $displayData['body'];

?>

<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">

    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <style>
        td, th, div, p, a, h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", sans-serif;
            mso-line-height-rule: exactly;
        }
    </style>
    <![endif]-->
    <title><?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_THANK_YOU_FOR_YOUR_PURCHASE'); ?></title>
    <style>
        .hover-text-brand-500:hover {
            color: <?= $shop_brandcolour; ?> !important;
        }

        .hover-text-brand-700:hover {
            color: <?= $shop_brandcolour_light; ?> !important;
        }

        .hover-underline:hover {
            text-decoration: underline !important;
        }

        @media (max-width: 640px) {
            .sm-block {
                display: block !important;
            }

            .sm-inline-block {
                display: inline-block !important;
            }

            .sm-h-24 {
                height: 24px !important;
            }

            .sm-h-32 {
                height: 32px !important;
            }

            .sm-h-64 {
                height: 64px !important;
            }

            .sm-mt-16 {
                margin-top: 16px !important;
            }

            .sm-px-0 {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .sm-px-16 {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .sm-py-24 {
                padding-top: 24px !important;
                padding-bottom: 24px !important;
            }

            .sm-pb-32 {
                padding-bottom: 32px !important;
            }

            .sm-align-top {
                vertical-align: top !important;
            }

            .sm-w-auto {
                width: auto !important;
            }

            .sm-w-full {
                width: 100% !important;
            }

            .dots {
                flex: 0 1 auto;
                /*Allows too long content to be hidden.*/
                overflow: hidden;
            }

            .dots::before {
                display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: clip;
                content: ". . . . . . . . . . . . . . . . . . . . " ". . . . . . . . . . . . . . . . . . . . " ". . . . . . . . . . . . . . . . . . . . " ". . . . . . . . . . . . . . . . . . . . "
            }
        }
    </style>
</head>
<body lang="en" style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased"
      bgcolor="#ffffff">
<div style="display: none; font-size: 0; line-height: 0"><?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_THANK_YOU_FOR_YOUR_PURCHASE'); ?>
    &#847; &#847; &#847; &#847; &#847;
    &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847;
    &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847;
    &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847;
    &#847; &#847; &#847; &zwnj;
    &#160;&#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847;
    &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847;
    &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847;
    &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &#847; &zwnj;
    &#160;&#847; &#847; &#847; &#847; &#847;
</div>
<div role="article" aria-roledescription="email" aria-label="Thank you for your purchase!" lang="en">
    <table style="font-family: -apple-system, 'Segoe UI', sans-serif; width: 100%" cellpadding="0" cellspacing="0"
           role="presentation">
        <tr>
            <td align="center" bgcolor="#ffffff">
                <table class="sm-w-full" style="width: 640px" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td align="left" class="sm-px-16 sm-py-24" style="padding: 48px 40px" bgcolor="#ffffff">


                            <?php if ($config->get('shop_logo') != '') : ?>
                            <div style="margin-bottom: 24px">
                                <a href="<?= Uri::root(); ?>" style="color: #0047c3; text-decoration: none">
                                    <img src="<?= $shop_logo; ?>" alt="<?= $shop_name; ?>" width="119" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle">
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Email Body -->
                            <p style="font-size: 16px; line-height: 22px; margin: 0;">
								<?= str_replace('<p>', '<p style="font-size: 16px; line-height: 22px; margin: 0;">', $body) ?>
                            </p>
                            <!-- Email Body -->

                            <div class="sm-h-32" style="line-height: 16px">&nbsp;</div>

                            <p style="font-size: 16px; line-height: 22px; margin-top: 0; margin-bottom: 16px;"><?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_ORDER_SUMMARY'); ?></p>

                            <!-- Order Summary -->
                            <table style="width: 100%" cellpadding="0" cellspacing="0" role="presentation">
								<?php foreach ($order->ordered_products as $product) : 

                                    $productObject   = ProductFactory::get($product->j_item);
                                    $selectedVariant = null;
                                    foreach ($productObject->variantList as $variantList) if ($variantList->id == $product->variant_id)
                                    {
                                        $selectedVariant = $variantList;
                                    }

                                ?>

                                    <tr style="">
                                        <td class="" style="padding-top: 5px; text-align: left; vertical-align: top;" align="left" valign="top">

                                            <p style="margin-top: 0;">
                                                <a href="<?= Route::_(Uri::root() . 'index.php?option=com_content&view=article&id=' . $product->j_item); ?>" style="text-decoration: none; font-weight: 700; color: #4a5566">
                                                    <?= $product->amount; ?> X <?= $product->j_item_name; ?>
                                                </a>
                                            </p>

                                            <table cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td class="" style="font-size: 16px; line-height: 12px; padding-left: 8px;">
                                                        <ul>

                                                            <?php if ($product->item_options_array) : ?>
    														    <?php foreach ($product->item_options_array as $option) : ?>
                                                                <li>
    															    <?= $option->option_name; ?>: <?= $option->modifier_value_translated; ?>
                                                                </li>
    														    <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td class="" style="font-size: 16px; line-height: 12px; padding-left: 8px;">
                                                        <?php if ($selectedVariant) : ?>
                                                            <ul class="">
                                                                <?php foreach ($productObject->variants as $variant) : ?>
                                                                    <?php foreach ($variant->labels as $label) : ?>
                                                                        <?php if (in_array($label->id, explode(',', $selectedVariant->label_ids))) : ?>
                                                                            <li>
                                                                                <?= $variant->name ?>: <span class="uk-text-bold"><?= $label->name ?></span>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>

                                        <td style="font-weight: 700; padding-top: 14px; text-align: right; color: #4a5566; vertical-align: top; min-width:100px" align="right" valign="top">
                                            <?= $product->subtotal_formatted; ?>
                                        </td>
                                    </tr>
								<?php endforeach; ?>
                            </table>

                            <table style="width: 100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="padding-top: 12px; padding-bottom: 12px">
                                        <div style="background-color: #e1e1ea; height: 2px; line-height: 2px">&nbsp;
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Subtotal -->
                            <table style="width: 100%" cellpadding="0" cellspacing="0" role="presentation">

                                <tr style="">
                                    <td class="sm-w-auto"
                                        style="padding-top: 14px; text-align: left; vertical-align: top;"
                                        align="left" valign="top">
                                        <p style="margin-top: 0; margin-bottom: 12px">
											<?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_SUBTOTAL'); ?>
                                        </p>
                                    </td>
                                    <td style="font-weight: 700; padding-top: 14px; text-align: right; color: #4a5566; vertical-align: top;"
                                        align="right"
                                        valign="top"><?= $order->order_subtotal_formatted; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="sm-w-auto"
                                        style="padding-top: 14px; text-align: left; vertical-align: top;"
                                        align="left" valign="top">
                                        <p style="margin-top: 0; margin-bottom: 12px">
											<?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_SHIPPING'); ?>
                                            <span class="dots" style="overflow: hidden;max-width: 400px"></span>
                                        </p>

                                    </td>
                                    <td style="font-weight: 700; padding-top: 14px; text-align: right; color: #4a5566; vertical-align: top; "
                                        align="right"
                                        valign="top"><?= $order->shipping_total_formatted; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="sm-w-auto"
                                        style="padding-top: 14px; text-align: left; vertical-align: top; "
                                        align="left" valign="top">
                                        <p style="margin-top: 0; margin-bottom: 12px">
											<?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_TAXES'); ?>
                                        </p>
                                    </td>
                                    <td style="font-weight: 700; padding-top: 14px; text-align: right; color: #4a5566; vertical-align: top; min-width:185px"

                                        valign="top"><?= $order->tax_total_formatted; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sm-w-auto"
                                        style="padding-top: 14px; text-align: left; vertical-align: top; "
                                        align="left" valign="top">
                                        <p style="margin-top: 0; margin-bottom: 12px">
											<?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_DISCOUNTS'); ?> <?= ($order->discount_code ? '(' . Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_DISCOUNTS_CODE') . ' ' . $order->discount_code . ')' : ''); ?>
                                        </p>
                                    </td>
                                    <td style="font-weight: 700; padding-top: 14px; text-align: right; color: #4a5566; vertical-align: top; min-width:185px"

                                        valign="top"><?= $order->discount_total_formatted; ?>
                                    </td>
                                </tr>

                                <tr>

                                    <td class="sm-w-auto"
                                        style="padding-top: 14px; text-align: left; vertical-align: top;"
                                        align="left" valign="top">
                                        <p style="margin-top: 0; margin-bottom: 12px">
											<?= Text::_('COM_COMMERCELAB_SHOP_DEFAULT_EMAIL_TOTAL'); ?>
                                        </p>
                                    </td>

                                    <td style="font-weight: 700; font-size: 21px; line-height: 28px; margin: 0; color: #4a5566" align="right" valign="top">
                                        <?= $order->order_total_formatted; ?>
                                    </td>

                                </tr>

                            </table>
                            <div class="sm-h-64" style="line-height: 64px">&nbsp;</div>

<!--                             <p style="font-size: 12px; line-height: 16px; margin: 0;">
								<?= Text::sprintf('COM_COMMERCELAB_SHOP_TRANSACTION_EMAIL_FOOTER_SUPPORT_MESSAGE', $supportemail, $supportemail); ?>
                            </p> -->

                            <div style="text-align: left">
                                <table style="width: 100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td style="padding-bottom: 16px; padding-top: 64px">
                                            <div style="background-color: #e1e1ea; height: 1px; line-height: 1px">
                                                &nbsp;
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <p style="font-size: 12px; line-height: 16px; margin-top: 0; margin-bottom: 16px;">
									<?= Text::sprintf('COM_COMMERCELAB_SHOP_TRANSACTION_EMAIL_FOOTER1', Uri::base(), $shop_brandcolour, Uri::base()); ?>
                                </p>
                                <p style="font-size: 12px; line-height: 16px; margin: 0;">
                                    &copy; <?= date('Y'); ?> <?= $shop_name; ?>
                                    . <?= Text::_('COM_COMMERCELAB_SHOP_TRANSACTION_EMAIL_FOOTER_ALLRIGHTS_RESERVED'); ?></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
