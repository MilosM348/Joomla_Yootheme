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

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Plugin\PluginHelper;

use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Order\OrderFactory;

PluginHelper::importPlugin('commercelab_shop_extended');

$last_order = count(OrderFactory::getList(1)['items']) ? OrderFactory::getList(1)['items'][0]->id : false;

$data          = $displayData;
$templateStyle = $data['templateStyle'];

$extensions = Factory::getApplication()->triggerEvent('onGetSidebarLink');
$input      = Factory::getApplication()->input;      
$view       = $input->get('view','home');
$menu_array = array("currencies", "currency", "countries", "country", "zones", "zone" , "shippingratescountry" , "shippingratescountries" , "shippingrateszone" , "shippingrateszones", "emailmanager", "email", "emaillogs", "io", "p2sfaker");

// dd($extensions);

?>

<div class="left-nav-wrap heightsidemenu uk-overflow-auto">
    <ul class="uk-nav uk-nav-primary uk-nav-parent-icon uk-margin-top"
            data-uk-nav id="left_menu_ul">

        <li class="home-in <?php if($view == "home"){echo "active";}?>">
            <a href="index.php?option=com_commercelab_shop">
                <svg width="1.125em" aria-hidden="true" focusable="false" data-prefix="fal"
                     data-icon="home" class="" role="img"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path fill="currentColor"
                          d="M541 229.16l-61-49.83v-77.4a6 6 0 0 0-6-6h-20a6 6 0 0 0-6 6v51.33L308.19 39.14a32.16 32.16 0 0 0-40.38 0L35 229.16a8 8 0 0 0-1.16 11.24l10.1 12.41a8 8 0 0 0 11.2 1.19L96 220.62v243a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16v-128l64 .3V464a16 16 0 0 0 16 16l128-.33a16 16 0 0 0 16-16V220.62L520.86 254a8 8 0 0 0 11.25-1.16l10.1-12.41a8 8 0 0 0-1.21-11.27zm-93.11 218.59h.1l-96 .3V319.88a16.05 16.05 0 0 0-15.95-16l-96-.27a16 16 0 0 0-16.05 16v128.14H128V194.51L288 63.94l160 130.57z"></path>
                </svg>
                <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_HOME'); ?>
            </a>
        </li>
        <li class="products-in <?php if(in_array($view, array("products", "product"))){echo "active";}?>">
            <a href="index.php?option=com_commercelab_shop&view=products">
                <svg width="1.125em" aria-hidden="true" focusable="false" data-prefix="fal"
                     data-icon="boxes" class="" role="img"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path fill="currentColor"
                          d="M624 224H480V16c0-8.8-7.2-16-16-16H176c-8.8 0-16 7.2-16 16v208H16c-8.8 0-16 7.2-16 16v256c0 8.8 7.2 16 16 16h608c8.8 0 16-7.2 16-16V240c0-8.8-7.2-16-16-16zm-176 32h64v62.3l-32-10.7-32 10.7V256zM352 32v62.3l-32-10.7-32 10.7V32h64zm-160 0h64v106.7l64-21.3 64 21.3V32h64v192H192V32zm0 224v62.3l-32-10.7-32 10.7V256h64zm-160 0h64v106.7l64-21.3 64 21.3V256h80v224H32V256zm576 224H336V256h80v106.7l64-21.3 64 21.3V256h64v224z"></path>
                </svg> <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_PRODUCTS'); ?>
            </a>
        </li>
       
        <li class="orders-in <?php if (in_array($view, array("orders", "order"))){echo "active";}?>">
            <a href="index.php?option=com_commercelab_shop&view=orders">
                <svg width="1.125em" aria-hidden="true" focusable="false" data-prefix="fal"
                     data-icon="box-check" class="" role="img"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path fill="currentColor"
                          d="M492.5 133.4L458.9 32.8C452.4 13.2 434.1 0 413.4 0H98.6c-20.7 0-39 13.2-45.5 32.8L2.5 184.6c-1.6 4.9-2.5 10-2.5 15.2V464c0 26.5 21.5 48 48 48h400c106 0 192-86 192-192 0-90.7-63-166.5-147.5-186.6zM272 32h141.4c6.9 0 13 4.4 15.2 10.9l28.5 85.5c-3-.1-6-.5-9.1-.5-56.8 0-107.7 24.8-142.8 64H272V32zM83.4 42.9C85.6 36.4 91.7 32 98.6 32H240v160H33.7L83.4 42.9zM48 480c-8.8 0-16-7.2-16-16V224h249.9c-16.4 28.3-25.9 61-25.9 96 0 66.8 34.2 125.6 86 160H48zm400 0c-88.2 0-160-71.8-160-160s71.8-160 160-160 160 71.8 160 160-71.8 160-160 160zm64.6-221.7c-3.1-3.1-8.1-3.1-11.2 0l-69.9 69.3-30.3-30.6c-3.1-3.1-8.1-3.1-11.2 0l-18.7 18.6c-3.1 3.1-3.1 8.1 0 11.2l54.4 54.9c3.1 3.1 8.1 3.1 11.2 0l94.2-93.5c3.1-3.1 3.1-8.1 0-11.2l-18.5-18.7z"></path>
                </svg> <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_ORDERS'); ?>
            </a>
        </li>
        <li class="customers-in <?php if(in_array($view, array("customers", "customer"))){echo "active";}?>">
            <a href="index.php?option=com_commercelab_shop&view=customers">
                <svg width="1.125em" aria-hidden="true" focusable="false" data-prefix="fal"
                     data-icon="users" class="" role="img"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path fill="currentColor"
                          d="M544 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zM320 256c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm0-192c44.1 0 80 35.9 80 80s-35.9 80-80 80-80-35.9-80-80 35.9-80 80-80zm244 192h-40c-15.2 0-29.3 4.8-41.1 12.9 9.4 6.4 17.9 13.9 25.4 22.4 4.9-2.1 10.2-3.3 15.7-3.3h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zM96 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zm304.1 180c-33.4 0-41.7 12-80.1 12-38.4 0-46.7-12-80.1-12-36.3 0-71.6 16.2-92.3 46.9-12.4 18.4-19.6 40.5-19.6 64.3V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c0-23.8-7.2-45.9-19.6-64.3-20.7-30.7-56-46.9-92.3-46.9zM480 432c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16v-44.8c0-16.6 4.9-32.7 14.1-46.4 13.8-20.5 38.4-32.8 65.7-32.8 27.4 0 37.2 12 80.2 12s52.8-12 80.1-12c27.3 0 51.9 12.3 65.7 32.8 9.2 13.7 14.1 29.8 14.1 46.4V432zM157.1 268.9c-11.9-8.1-26-12.9-41.1-12.9H76c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c5.5 0 10.8 1.2 15.7 3.3 7.5-8.5 16.1-16 25.4-22.4z"></path>
                </svg> <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_CUSTOMERS'); ?>
            </a>
        </li>    

        <li class="marketing-in <?php if(in_array($view, array("discounts", "discount"))){echo "active";}?>">
            <a href="index.php?option=com_commercelab_shop&view=discounts">
                <svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal" 
                    data-icon="tags" class="svg-inline--fa fa-tags fa-w-20" role="img" 
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path fill="currentColor" 
                        d="M625.941 293.823L421.823 497.941c-18.746 18.746-49.138 18.745-67.882 0l-1.775-1.775 22.627-22.627 1.775 1.775c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L391.431 36.686A15.895 15.895 0 0 0 380.117 32h-19.549l-32-32h51.549a48 48 0 0 1 33.941 14.059L625.94 225.941c18.746 18.745 18.746 49.137.001 67.882zM252.118 32H48c-8.822 0-16 7.178-16 16v204.118c0 4.274 1.664 8.292 4.686 11.314l211.882 211.882c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L263.431 36.686A15.895 15.895 0 0 0 252.118 32m0-32a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.746 18.746-49.138 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118V48C0 21.49 21.49 0 48 0h204.118zM144 124c-11.028 0-20 8.972-20 20s8.972 20 20 20 20-8.972 20-20-8.972-20-20-20m0-28c26.51 0 48 21.49 48 48s-21.49 48-48 48-48-21.49-48-48 21.49-48 48-48z"></path>
                </svg> <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_DISCOUNT_CODES'); ?>
            </a>            
        </li>

        <li class="marketing-in <?php if(in_array($view, array("shops", "shop"))){echo "active";}?>">
            <a href="index.php?option=com_commercelab_shop&view=shops">
                <svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal" 
                    data-icon="tags" class="svg-inline--fa fa-tags fa-w-20" role="img" 
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path fill="currentColor" 
                        d="M625.941 293.823L421.823 497.941c-18.746 18.746-49.138 18.745-67.882 0l-1.775-1.775 22.627-22.627 1.775 1.775c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L391.431 36.686A15.895 15.895 0 0 0 380.117 32h-19.549l-32-32h51.549a48 48 0 0 1 33.941 14.059L625.94 225.941c18.746 18.745 18.746 49.137.001 67.882zM252.118 32H48c-8.822 0-16 7.178-16 16v204.118c0 4.274 1.664 8.292 4.686 11.314l211.882 211.882c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L263.431 36.686A15.895 15.895 0 0 0 252.118 32m0-32a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.746 18.746-49.138 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118V48C0 21.49 21.49 0 48 0h204.118zM144 124c-11.028 0-20 8.972-20 20s8.972 20 20 20 20-8.972 20-20-8.972-20-20-20m0-28c26.51 0 48 21.49 48 48s-21.49 48-48 48-48-21.49-48-48 21.49-48 48-48z"></path>
                </svg> <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_STORE_LOCATIONS'); ?>
            </a>            
        </li>

        <li class="uk-parent">

            <?php if (!$templateStyle) : ?>

                <a href="javascript:void(0);" class="no-ytp-tmpl">
                    <span uk-icon="icon: desktop"></span> Page Builder
                </a>

            <?php else : ?>

                <a href="#">
                    <span uk-icon="icon: desktop"></span> Page Builder
                </a>
                <ul class="uk-nav-sub" hidden="">
                    <li>
                        <a href="index.php?option=com_ajax&p=customizer&templateStyle=<?php echo $templateStyle->id ?>&format=html&return=<?php echo urlencode(JUri::getInstance()); ?>">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="index.php?option=com_ajax&p=customizer&templateStyle=<?php echo $templateStyle->id ?>&format=html&site=<?= urlencode(Route::_(str_replace('/administrator', '', Uri::base() . ConfigFactory::getSystemRedirectUrls()->checkout->short))) ?>&return=<?php echo urlencode(JUri::getInstance()); ?>">
                            Checkout
                        </a>
                    </li>

                    <li>
                        <a href="index.php?option=com_ajax&p=customizer&templateStyle=<?php echo $templateStyle->id ?>&format=html&site=<?= urlencode(Route::_(str_replace('/administrator', '', Uri::base() . ConfigFactory::getSystemRedirectUrls()->cart->short))) ?>&return=<?php echo urlencode(JUri::getInstance()); ?>">
                            Cart
                        </a>
                    </li>

                    <li>
                        <a href="index.php?option=com_ajax&p=customizer&templateStyle=<?php echo $templateStyle->id ?>&format=html&site=<?= urlencode(Route::_(str_replace('/administrator', '', Uri::base() . ConfigFactory::getSystemRedirectUrls()->tandcs->short))) ?>&return=<?php echo urlencode(JUri::getInstance()); ?>">
                            Terms and Conditions
                        </a>
                    </li>

                    <li>
                        <?php if ($last_order) : ?>
                        <a href="index.php?option=com_ajax&p=customizer&templateStyle=<?php echo $templateStyle->id ?>&format=html&site=<?= urlencode(Route::_(str_replace('/administrator', '', Uri::base() . ConfigFactory::getSystemRedirectUrls()->confirmation->short . '&cls_order_id=' . $last_order))) ?>&return=<?php echo urlencode(JUri::getInstance()); ?>">
                            Confirmation (Order)
                        </a>
                        <?php else : ?>
                        <a uk-tooltip="No Orders, create some first" class="uk-text-muted" href="javascript:void(0);">
                            Confirmation (Order)
                        </a>
                        <?php endif; ?>
                    </li>

                </ul>

            <?php endif; ?>
            <script type="text/javascript">
                jQuery('a.no-ytp-tmpl').click(function() {
                    UIkit.notification({
                        message: '<?= Text::_('COM_COMMERCELAB_SHOP_OPEN_YTP_BUILDER_NO_YTP_MSG'); ?>',
                        status: 'danger',
                    });
                })
            </script>

         <li class="uk-parent zones-in <?= (in_array($view, $menu_array)) ? "uk-open" : '' ?>">
            <a href="#">
            <svg class="fa-w-16" width="1.125em" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><ellipse fill="none" stroke="#000" cx="6.11" cy="3.55" rx="2.11" ry="2.15"></ellipse><ellipse fill="none" stroke="#000" cx="6.11" cy="15.55" rx="2.11" ry="2.15"></ellipse><circle fill="none" stroke="#000" cx="13.15" cy="9.55" r="2.15"></circle><rect x="1" y="3" width="3" height="1"></rect><rect x="10" y="3" width="8" height="1"></rect><rect x="1" y="9" width="8" height="1"></rect><rect x="15" y="9" width="3" height="1"></rect><rect x="1" y="15" width="3" height="1"></rect><rect x="10" y="15" width="8" height="1"></rect></svg>
                <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_SETTINGS_TOOLTIP'); ?>
            </a>
            <ul class="uk-nav-sub" hidden="">

                <li>
                    <a href="index.php?option=com_config&view=component&component=com_commercelab_shop">
                        Global Config
                    </a>
                </li>

                <li class="<?php if(in_array($view, array("currencies", "currency"))){echo "active";}?>">
                    <a href="index.php?option=com_commercelab_shop&view=currencies">
                        <?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_CURRENCIES'); ?>
                    </a>
                </li>
                <li class="<?php if(in_array($view, array("countries", "country"))){echo "active";}?>">
                    <a href="index.php?option=com_commercelab_shop&view=countries"><?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_COUNTRIES'); ?></a>
                </li>
                <li class="<?php if(in_array($view, array("zones", "zone"))){echo "active";}?>"><a href="index.php?option=com_commercelab_shop&view=zones">&nbsp;&nbsp; -
                        &nbsp;&nbsp;<?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_ZONES'); ?></a>
                </li>
                <li class="<?php if(in_array($view, array("shippingratescountry", "shippingratescountries"))){echo "active";}?>"><a
                            href="index.php?option=com_commercelab_shop&view=shippingratescountries"><?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_COUNTRY_SHIPPING_RATES'); ?></a>
                </li>
                <li class="<?php if(in_array($view, array("shippingrateszone", "shippingrateszones"))){echo "active";}?>"><a href="index.php?option=com_commercelab_shop&view=shippingrateszones">&nbsp;&nbsp; -
                        &nbsp;&nbsp;<?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_ZONE_SHIPPING_RATES'); ?></a>
                </li>
                <li class="<?php if(in_array($view, array("emailmanager", "email"))){echo "active";}?>">
                    <a href="index.php?option=com_commercelab_shop&view=emailmanager"><?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_EMAIL_MANAGER'); ?></a>
                </li>
                <li class="<?php if($view == "emaillogs"){echo "active";}?>">
                    <a href="index.php?option=com_commercelab_shop&view=emaillogs"><?= Text::_('COM_COMMERCELAB_SHOP_SIDEMENU_EMAIL_LOGS'); ?></a>
                </li>
                <?php
                /** @var \CommerceLabShop\Sidebarlink\Sidebarlink $extension */
                foreach ($extensions as $extension) : ?>

                    <li class="<?php if($extension->hasParent){echo 'uk-parent';}else{if($view == $extension->view_name){echo 'active';}}?>">
                        <a href="<?= $extension->view; ?>">                  
                            <?= Text::_($extension->linkText); ?>
                        </a>
                        <?php if ($extension->hasParent) : ?>
                            <ul class="uk-nav-sub" hidden="">
                            <?php foreach ($extension->subLinks as $subLink) : ?>
                                <li class="<?php if($view == $subLink['view']){echo "active";} echo $view."==".$subLink['view'];?>">
                                    <a href="index.php?option=com_commercelab_shop&view=<?= $subLink['view']; ?>"><?= Text::_($subLink['linkText']); ?></a>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>
            </ul>
        </li>     


        <li class="addons-in <?php if(in_array($view, array("addons"))){echo "active";}?>">
            <a href="index.php?option=com_commercelab_shop&view=addons">
                <svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal" 
                    data-icon="tags" class="svg-inline--fa fa-tags fa-w-20" role="img" 
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path fill="currentColor" 
                        d="M625.941 293.823L421.823 497.941c-18.746 18.746-49.138 18.745-67.882 0l-1.775-1.775 22.627-22.627 1.775 1.775c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L391.431 36.686A15.895 15.895 0 0 0 380.117 32h-19.549l-32-32h51.549a48 48 0 0 1 33.941 14.059L625.94 225.941c18.746 18.745 18.746 49.137.001 67.882zM252.118 32H48c-8.822 0-16 7.178-16 16v204.118c0 4.274 1.664 8.292 4.686 11.314l211.882 211.882c6.253 6.253 16.384 6.243 22.627 0l204.118-204.118c6.238-6.239 6.238-16.389 0-22.627L263.431 36.686A15.895 15.895 0 0 0 252.118 32m0-32a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.746 18.746-49.138 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118V48C0 21.49 21.49 0 48 0h204.118zM144 124c-11.028 0-20 8.972-20 20s8.972 20 20 20 20-8.972 20-20-8.972-20-20-20m0-28c26.51 0 48 21.49 48 48s-21.49 48-48 48-48-21.49-48-48 21.49-48 48-48z"></path>
                </svg> <?= Text::_('Addons'); ?>
            </a>            
        </li>

        <li class="exit-in">
            <a class="uk-text-small closebtn" href="index.php">

            <svg class="fa-w-16" version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            width="1.125em" viewBox="0 0 50 50" enable-background="new 0 0 50 50" xml:space="preserve">
                <g>
                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#010101" d="M9.482,23.493c0.264,0,0.433,0,0.601,0
                    c8.955,0,17.91,0.004,26.864-0.01c0.424,0,0.551,0.099,0.528,0.529c-0.038,0.734-0.02,1.474-0.005,2.21
                    c0.004,0.227-0.063,0.314-0.287,0.285c-0.093-0.014-0.189-0.002-0.283-0.002c-8.939,0-17.877,0-26.816,0c-0.168,0-0.336,0-0.505,0
                    c-0.022,0.029-0.044,0.061-0.066,0.092c0.123,0.105,0.254,0.205,0.37,0.318c3.418,3.412,6.831,6.83,10.26,10.23
                    c0.284,0.283,0.277,0.42-0.007,0.678c-0.533,0.484-1.035,1.006-1.532,1.527c-0.198,0.209-0.311,0.246-0.54,0.016
                    c-4.691-4.711-9.391-9.414-14.097-14.112c-0.207-0.208-0.204-0.307,0.002-0.512c4.706-4.698,9.405-9.401,14.097-14.113
                    c0.23-0.23,0.341-0.192,0.539,0.018c0.508,0.534,1.025,1.061,1.566,1.559c0.257,0.236,0.257,0.359,0.004,0.61
                    c-2.574,2.549-5.133,5.113-7.695,7.673C11.504,21.465,10.531,22.443,9.482,23.493z"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M46.499,25.02c0,4.484,0.006,8.97-0.002,13.455
                    c-0.004,2.148-1.333,3.889-3.371,4.438c-0.314,0.084-0.646,0.141-0.971,0.145c-1.459,0.018-2.917,0.006-4.374,0.016
                    c-0.229,0.002-0.33-0.035-0.323-0.301c0.02-0.799,0.021-1.6,0-2.398c-0.009-0.291,0.106-0.322,0.352-0.32
                    c1.332,0.01,2.665,0.006,3.998,0.004c1.082-0.002,1.679-0.602,1.679-1.695c0.002-8.906,0.002-17.813,0-26.72
                    c0-1.108-0.6-1.698-1.721-1.699c-1.317-0.002-2.635-0.011-3.952,0.007c-0.298,0.004-0.363-0.081-0.355-0.365
                    c0.02-0.768,0.022-1.537-0.002-2.305c-0.01-0.3,0.083-0.359,0.366-0.356c1.364,0.015,2.729-0.001,4.092,0.008
                    c2.609,0.018,4.575,1.975,4.582,4.587C46.507,16.019,46.499,20.519,46.499,25.02z"/>
                </g>
            </svg>Exit</a>
        </li> 


    </ul>
</div>