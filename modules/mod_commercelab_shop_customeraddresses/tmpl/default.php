<?php
/**
 * @package     CommerceLab Shop - Customer Addresses
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;



/** @var $params */
/** @var $config */
/** @var $addresses array */

\CommerceLabShop\Language\LanguageFactory::load();

$id = uniqid('yps_customer_addresses');

echo "{emailcloak=off}";


?>
<div id="<?= $id; ?>">
    <div class="uk-text-right uk-margin">
    <span uk-tooltip="<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ADD_NEW_ADDRESS'); ?>">
        <a class="uk-button uk-button-primary" href="#yps-addAddressModal" uk-toggle>
            <?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADD_NEW_ADDRESS'); ?>
            <span uk-icon="icon: plus-circle"></span>
        </a>
    </span>
    </div>
    <div class="uk-grid uk-child-width-1-<?= $params->get('grid_cols'); ?>@m uuk-grid-match" uk-grid>
        <div v-for="address in addresses">
            <div>
                <div class="uk-card uk-card-body uk-card-default uk-margin">
                    <ul class="uk-iconnav uk-flex-right">
                        <li uk-tooltip="<?= Text::_('COM_COMMERCELAB_SHOP_CUSTOMER_TOOLTIP_EDIT_ADDRESS'); ?>">
                            <a @click="openEditModal(address)"
                               uk-icon="icon: file-edit">
                            </a>
                        </li>

                        <li uk-tooltip="Delete Address">
                            <a @click="deleteAddress(address.id)" uk-icon="icon: trash"></a>
                        </li>
                    </ul>
                    <span><h5>{{address.name}}</h5>{{address.address_as_csv}}</span>
                </div>
            </div>

        </div>
    </div>

	<?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_customeraddresses', 'editAddress'); ?>
	<?php require ModuleHelper::getLayoutPath('mod_commercelab_shop_customeraddresses', 'addAddress'); ?>

</div>
<script>
    const <?= $id; ?> = {
        data() {
            return {
                addresses: <?= json_encode($addresses); ?>,
                zones: [],
                newAddress: {
                    name: '',
                    address1: '',
                    address2: '',
                    address3: '',
                    town: '',
                    country: '',
                    zone: '',
                    postcode: '',
                    mobile_phone: '',
                    phone: '',
                    email: '',
                },
                addressForEdit: {
                    name: '',
                    address1: '',
                    address2: '',
                    address3: '',
                    town: '',
                    country: '',
                    zone: '',
                    postcode: '',
                    mobile_phone: '',
                    phone: '',
                    email: '',
                },
                formErrors: '',
                formErrorsList: '',
            }

        },
        async beforeMount() {


        },
        mounted() {


        },
        methods: {
            openEditModal(address) {
                this.addressForEdit = address;
                this.updateZones(address.country)
                UIkit.modal('#yps-editAddressModal').show()
            },
            async submitAddAddress() {
                               this.loading = true;

                const request = await fetch("<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=address.addaddress&format=raw", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer',
                    body: JSON.stringify(this.newAddress)
                });

                const response = await request.json();

                if (response.success) {
                    await UIkit.modal("#yps-addAddressModal").hide();
                    this.newAddress = {
                        name: '',
                        address1: '',
                        address2: '',
                        address3: '',
                        town: '',
                        country: '',
                        zone: '',
                        postcode: '',
                        mobile_phone: '',
                        phone: '',
                        email: '',
                    };
                    this.loading = false;
                    UIkit.notification({
                        message: '<span uk-icon=\'icon: check\'></span> <?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ADDRESS_ADDED'); ?>',
                        status: 'success',
                        pos: 'top-center'
                    });
                    this.updateCustomerAddresses();


                } else {
                    UIkit.notification({
                        message: 'ERROR',
                        status: 'danger',
                        pos: 'top-center'
                    });
                }


            },
            async updateCustomerAddresses() {


                const request = await fetch("<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=address.getCustomerAddresses&format=raw", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer',
                    body: JSON.stringify('')
                });

                const response = await request.json();

                if (response.success) {
                    this.addresses = response.data;

                } else {
                    UIkit.notification({
                        message: 'ERROR',
                        status: 'danger',
                        pos: 'top-center'
                    });
                }

            },
            async submitUpdateAddress() {
                await UIkit.modal("#yps-editAddressModal").hide();
                this.loading = true;

                const request = await fetch("<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=address.save&format=raw", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer',
                    body: JSON.stringify(this.addressForEdit)
                });

                const response = await request.json();

                if (response.success) {
                    this.addressForEdit = [];

                    this.loading = false;
                    UIkit.notification({
                        message: '<span uk-icon=\'icon: check\'></span> <?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ADDRESS_SAVED'); ?>',
                        status: 'success',
                        pos: 'top-center'
                    });
                    this.updateCustomerAddresses();


                } else {
                    UIkit.notification({
                        message: 'ERROR',
                        status: 'danger',
                        pos: 'top-center'
                    });
                }
            },
            async updateZones(country_id) {
                const params = {
                    country_id: country_id
                };

                const URLparams = this.serialize(params);

                const request = await fetch("<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=address.getZones&format=raw&" + URLparams);

                const response = await request.json();

                if (response.success) {
                    this.zones = response.data;
                }
            },
            async deleteAddress(uid) {
                await UIkit.modal.confirm('<?= Text::_('COM_COMMERCELAB_SHOP_ADDRESS_REMOVE_CONFIRM'); ?>', {stack: true});
                const params = {
                    address_id: uid
                };

                const URLparams = this.serialize(params);

                const request = await fetch("<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=address.remove&format=raw&" + URLparams);

                const response = await request.json();

                if (response.success) {
                    this.updateCustomerAddresses();
                }
            },
            serialize(obj) {
                var str = [];
                for (var p in obj)
                    if (obj.hasOwnProperty(p)) {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                return str.join("&");
            }
        }
    }
    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

</script>
