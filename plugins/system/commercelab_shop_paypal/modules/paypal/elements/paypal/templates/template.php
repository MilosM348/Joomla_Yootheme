<?php
/**
 * @package     CommerceLab Shop - Paypal
 *
 * @copyright   Copyright (C) 2020 Ray Lawlor - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Currency\Currency;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Currency\CurrencyFactory;
use CommerceLabShop\Utilities\Utilities;
use CommerceLabShop\Config\ConfigFactory;

$id = uniqid('yps_paypal_checkout');
$user            = UserFactory::getActiveUser();
$defaultcurrency = CurrencyFactory::getDefault();
$currencyHelper  = new Currency($defaultcurrency);
$configcls       = new ConfigFactory;
$configHelper    = $configcls->getSystemRedirectUrls();
$confrimationUrl = $configHelper->confirmation->short;
$confirmation    = Utilities::getUrlFromMenuItem($configHelper->confirmation->short);
$cancellationUrl = $configHelper->cancellation->short;

$container_class = ($props['buttons_container_width'] != 'custom') 
    ? $props['buttons_container_width']
    : $props['buttons_container_class'];


$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        '{panel_padding}',
        '{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
    ]

]);

?>

<?= $el($props, $attrs) ?>

    <div id="<?= $id; ?>">

        <div id="<?= $id; ?>-paypal-container" class="<?= $container_class; ?>">
            <div id="<?= $id; ?>-paypal-button-container"></div>
        </div>

    </div>

    <?php

        $payPalScriptParams = [
            "client-id=" . $props['publishable_key'],
            "currency=" . $props['currency'],
            "locale=" . $props['localeTag']
        ];

        if (count($props['funding_sources'])) {
            $payPalScriptParams[] = "enable-funding=paypal," . implode(",", $props['funding_sources']);
        } else {
            $payPalScriptParams[] = "enable-funding=paypal";
        }
        if (count($props['exclude_funding_sources'])) {
            $payPalScriptParams[] = "disable-funding=" . implode(",", $props['exclude_funding_sources']);
        }

    ?>

    <!-- PayPal Script -->
    <script src="https://www.paypal.com/sdk/js?<?= implode("&", $payPalScriptParams); ?>"></script>

    <!-- PayPal Function -->
    <script>

        // Internal Checkout Validation
        var globalValidationStatus = <?= $props['globalValidationStatus'] ?>,
            isValidStatus          = <?= ($props['isValidStatus']) ? 'true' : 'false' ?>;

        function scrollAndAlert(element) {
            const fixedOffset = (element.closest('.cls-element-container').getBoundingClientRect().top + window.scrollY - 80).toFixed();
            const onScroll = function () {
                if (window.pageYOffset.toFixed() === fixedOffset
                            || window.pageYOffset.toFixed() < fixedOffset) {
                    window.removeEventListener('scroll', onScroll);
                        setTimeout(function(element_id) {
                            emitter.emit("yps_cart_set_alert", element_id);
                        }, 300, element.id);
                }
            }

            window.addEventListener('scroll', onScroll);
            onScroll();
            window.scrollTo({
                top: fixedOffset,
                behavior: 'smooth'
            });
        };

        // PP Buttons Script
        paypal.Buttons({
                style: {
                    color: '<?= $props['color']; ?>',
                    shape: '<?= $props['shape']; ?>'
                },
                onInit: function (data, actions) {

                    // Disable Button Clicking on Load, if not valid state
                    <?php if (!$props['isValidStatus']) : ?>
                        actions.disable();
                    <?php endif; ?>

                    emitter.on("yps_cart_validation_update", function(status)
                    {
                        globalValidationStatus = status

                        if (<?= $props['required_status'] ?> <= status)
                        {
                            actions.enable();
                            isValidStatus = true;
                        }
                        else
                        {
                            actions.disable();
                            isValidStatus = false;
                        }
                    });

                },
                createOrder: function (data, actions) {
                    return fetch('<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=payment.initpayment&format=raw', {
                        method: 'POST',
                        body: JSON.stringify({
                            paymentType: 'Paypal'
                        }),
                        headers: {
                            'X-CSRF-Token': Joomla_cls.token,
                            'Content-Type': 'application/json'
                        }
                    }).then(function (res) {
                        return res.json();
                    }).then(function (orderData) { 
                        // console.log(orderData);
                        if (orderData.success && orderData.data.result.status == 'CREATED')
                        {
                            return orderData.data.result.id;
                        }
                        else
                        {
                            console.error(JSON.parse(orderData.message).error_description);
                            UIkit.notification({
                                message: 'There was an error creating this order: ' + JSON.parse(orderData.message).error_description,
                                status: 'danger',
                                pos: 'top-center',
                                timeout: 5000
                            });
                        }
                    });
                },

                onApprove: function (PayPalData, actions) {
                    return fetch('<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=payment.completepayment&format=raw', {
                        method: 'POST',
                        body: JSON.stringify({
                            paymentType: 'Paypal',
                            paypalorderid: PayPalData.orderID
                        }),
                        headers: {
                            'X-CSRF-Token': Joomla_cls.token,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(function (res)
                    { 
                        return res.json();
                    })
                    .then(function (response)
                    {
                        if (response.data.result.status == 'COMPLETED')
                        {
                            window.location.replace('<?= Uri::base() . $confrimationUrl; ?>&cls_order_id=' + response.data.clsOrderId);
                        }
                    });

                },
                onClick: function() {
                    if (!isValidStatus) {
                        const element = document.querySelector('[data-validation="' + globalValidationStatus + '"]');
                        if (element) {
                            scrollAndAlert(element);
                        }
                        return;
                    }
                },
                onError: function (err) {
                    console.error(err);
                    UIkit.notification({
                        message: 'There was an error creating this order: ' + JSON.parse(err),
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                },
                onCancel: function (data) {
                    // window.location.replace('<?= Uri::base() . $cancellationUrl; ?>');
                }
            }).render('#<?= $id; ?>-paypal-button-container');
       
    </script>
<?= $el->end() ?>
