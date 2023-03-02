<?php

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

use function YOOtheme\trans;

use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Address\AddressFactory;
use CommerceLabShop\Customer\CustomerFactory;
use CommerceLabShop\Language\LanguageFactory;

LanguageFactory::load();

$customer = CustomerFactory::get();
$config   = ConfigFactory::get();

echo "{emailcloak=off}";

$id = uniqid('yps_address_element');

$form_fields = [
    'shipping' => [
        'address_type' => 'shipping'
    ],
    'billing' => [
        'address_type' => 'billing'
    ]
];

if ($customer) {
    $form_fields['shipping']['customer_id'] = $customer->id;
    $form_fields['billing']['customer_id']  = $customer->id;
}

foreach ($children as $field) {
    if (!$field->props['field_address_type_exclude']) {
        $form_fields['shipping'][$field->props['field_type']] = '';
        $form_fields['billing'][$field->props['field_type']]  = '';
    } else {
        $form_fields[$field->props['field_address_type_exclude']][$field->props['field_type']]  = '';
    }
}

// dd($customer->addresses);

$addresses = [];
if (CartFactory::getTempAddress()) {
    
    $temp_address = CartFactory::getTempAddress();

    foreach ($temp_address as $address) {

        $address                           = AddressFactory::get($address->address_id);
        $addresses[$address->address_type] = $address;

        foreach ($form_fields[$address->address_type] as $field => $value) {
            switch ($field)
            {
                case 'country':
                case 'zone':
                    if ($value == 0) {
                        $value = '';
                    }
                    break;
            }

            $form_fields[$address->address_type][$field] = $addresses[$address->address_type]->$field;
            $form_fields[$address->address_type]['id']   = $addresses[$address->address_type]->id;
        }

    }
}

$assigned_addresses = [];
$cart_addresses     = CartFactory::getAssignedAddresses();

if ($cart_addresses)
{

    if ($cart_addresses->billing_address_id == 0) {
        $cart_addresses->billing_address_id = null;
    }

    if ($cart_addresses->shipping_address_id == 0) {
        $cart_addresses->shipping_address_id = null;
    }
    
    if ($cart_addresses->billing_address_id)
    {
        $address = AddressFactory::get($cart_addresses->billing_address_id);
        if ($address) {
            $assigned_addresses[$address->address_type] = $address;
        }
    }

    if ($cart_addresses->shipping_address_id)
    {
        $address = AddressFactory::get($cart_addresses->shipping_address_id);
        if ($address) {
            $assigned_addresses[$address->address_type] = $address;
        }
    }
    
}
// dd($assigned_addresses);
// dd(CartFactory::getAssignedAddresses());

$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        '{panel_padding}',
        '{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
    ]

]);


if (!$node->props['address_order'] || $node->props['address_order'] == 'billing') {
    $active_forms = [
        'billing',
        'shipping',
    ];
} else {
    $active_forms = [
        'shipping',
        'billing',
    ];
}

// Remove BIlling if Not Required
if (!$node->props['billing_address_required']) {
    $active_forms = [
        'shipping',
    ];
}

?>

<?= $el($props, $attrs) ?>

    <div v-cloak id="<?= $id; ?>" class="uk-animation-fade uk-animation-fast cls-element-container" data-validation="<?= $node->props['required_status'] ?>">

        <!-- Existing Address -->
        <ul class="uk-list uk-list-divider">
            <?php foreach ($active_forms as $index => $form_name) : ?>
                <li v-cloak v-if="this.assigned_addresses['<?= $form_name ?>'] 
                    && (!sameAs || sameAs && '<?= $index == 0 ?>')
                    && (!sameAsChanging || (sameAsChanging && '<?= $index == 0 ?>'))" class="uk-animation-fade uk-animation-fast">

                    <div class="uk-card uk-card-default uk-border-rounded">
                        
                        <div class="uk-card-header">
                            <div uk-grid>

                                <div class="uk-width-expand">
                                    <h5 class="uk-h5 uk-margin-remove">
                                        <?= $node->props[$form_name . '_form_title'] ?>
                                    </h5>
                                    <?php if ($index === 0) : ?>
                                        <label class="uk-text-muted">
                                            <input type="checkbox" class="uk-checkbox" name="sameAs" v-model="sameAs" @change="sameAsChanging = true, changeSameAs($event)">
                                            <?= $node->props[$active_forms[0] . '_form_title'] ?> <?= trans('and') ?> <?= $node->props[$active_forms[1] . '_form_title'] ?> <?= trans('are the same') ?>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="uk-width-auto uk-text-right">
                                    <!-- <a href="javascript:void(0);" @click="deletAddress(this.assigned_addresses['<?= $form_name ?>'].id, '<?= $form_name ?>')" class="uk-margin-small-right" uk-icon="icon: trash"></a> -->
                                    <a href="javascript:void(0);" @click="editAddress(this.assigned_addresses['<?= $form_name ?>'])" uk-icon="icon: file-edit"></a>
                                </div>

                            </div>
                        </div>

                        <div class="uk-card-body uk-card-small uk-width-1-1">

                            <div class="uk-grid-divider" uk-grid>

                                <div class="uk-width-1-1 uk-width-auto@s">
                                    <div class="uk-grid-small uk-margin-remove-top" uk-grid>
                                        <div class="uk-width-auto">
                                            <span class="uk-text-muted" uk-icon="icon: user"></span> 
                                        </div>
                                        <div class="uk-width-expand">
                                            {{this.assigned_addresses['<?= $form_name ?>'].first_name}} {{this.assigned_addresses['<?= $form_name ?>'].last_name}}
                                        </div>
                                    </div>
                                    <div class="uk-grid-small uk-margin-remove-top" uk-grid>
                                        <div class="uk-width-auto">
                                            <span class="uk-text-muted" uk-icon="icon: mail"></span> 
                                        </div>
                                        <div class="uk-width-expand">
                                            {{this.assigned_addresses['<?= $form_name ?>'].email}}
                                        </div>
                                    </div>

                                    <div class="uk-grid-small uk-margin-remove-top" v-if="this.assigned_addresses['<?= $form_name ?>'].phone" uk-grid>
                                        <div class="uk-width-auto">
                                            <span class="uk-text-muted" uk-icon="icon: receiver"></span> 
                                        </div>
                                        <div class="uk-width-expand">
                                            <span>
                                                {{this.assigned_addresses['<?= $form_name ?>'].phone}}
                                                <span v-if="this.assigned_addresses['<?= $form_name ?>'].mobile_phone">
                                                    / {{this.assigned_addresses['<?= $form_name ?>'].mobile_phone}}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-width-1-1 uk-width-expand@s">

                                    <div class="uk-grid-small uk-margin-remove-top" uk-grid>

                                        <div class="uk-width-auto">
                                            <span class="uk-text-muted" uk-icon="icon: location"></span> 
                                        </div>

                                        <div class="uk-width-expand">
                                            <span>
                                                {{ this.assigned_addresses['<?= $form_name ?>'].address1 }}
                                            </span>
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].address2">
                                                - {{this.assigned_addresses['<?= $form_name ?>'].address2}}
                                            </span>
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].address3">
                                                - {{this.assigned_addresses['<?= $form_name ?>'].address3}}
                                            </span>
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].postcode">
                                                - {{this.assigned_addresses['<?= $form_name ?>'].postcode}}
                                            </span>
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].city">
                                                - {{this.assigned_addresses['<?= $form_name ?>'].city}}
                                            </span>
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].zone_name">
                                                - {{this.assigned_addresses['<?= $form_name ?>'].zone_name}}
                                            </span>
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].country_name">
                                                - {{this.assigned_addresses['<?= $form_name ?>'].country_name}}
                                            </span>
                                        </div>

                                    </div>

                                    <?php if ($form_name == 'billing') : ?>
                                    <div v-if="this.assigned_addresses['<?= $form_name ?>'].vat || this.assigned_addresses['<?= $form_name ?>'].company_name"  class="uk-grid-small uk-margin-remove-top" uk-grid>
                                        
                                        <div class="uk-width-auto">
                                            <span class="uk-text-muted" uk-icon="icon: bag"></span> 
                                        </div>

                                        <div class="uk-width-expand">
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].vat">
                                                {{ this.assigned_addresses['<?= $form_name ?>'].vat }}
                                            </span>
                                            <span v-if="this.assigned_addresses['<?= $form_name ?>'].company_name">
                                                <span v-if="this.assigned_addresses['<?= $form_name ?>'].vat">
                                                    - 
                                                </span>
                                                {{ this.assigned_addresses['<?= $form_name ?>'].company_name }}
                                            </span>
                                        </div>

                                    </div>
                                    <?php endif; ?>  

                                </div>
                                
                            </div>
                        </div>

                    </div>

                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Addresses Forms -->
        <ul class="uk-list">
            <?php foreach ($active_forms as $index => $form_name) : ?>
            <li v-if="!this.assigned_addresses['<?= $form_name ?>'] 
                && (!sameAs || sameAs && '<?= $index == 0 ?>')
                && (!sameAsChanging || (sameAsChanging && '<?= $index == 0 ?>'))"
            >

                <h5 class="uk-h5 uk-margin-remove">
                    <?= $node->props[$form_name . '_form_title'] ?>
                </h5>

                <div class="uk-animation-fade uk-animation-fast">

                    <form class="uk-form <?= $node->props['labels_layout'] ?>" id="<?= $form_name ?>_address_form_<?= $id ?>" @submit.prevent="submitAddressForm('<?= $form_name ?>', <?= $index ?>, true)" data-validation="<?= $index + 3 ?>">

                        <!-- Fields -->
                        <div uk-grid uk-height-match="target: .uk-form-label">
                            <?php foreach ($children as $i => $child) : ?>
                                <?= $builder->render($child, ['element' => $props, 'address_type' => $form_name]) ?>
                            <?php endforeach ?>
                        </div>

                        <!-- Submit -->
                        <div uk-grid class="<?= $node->props['rows_spacing'] ?>">
                            <div class="uk-width-1-1 <?= $node->props[$form_name . '_submit_button_alignment'] ?>">

                                <!-- Copy From -->
                                <?php if ($node->props['billing_address_required'] 
                                    && $node->props['show_copy_from'] 
                                    && $node->props['show_copy_from_' . $form_name]) : ?>

                                        <a href="javascript:void(0);" 
                                            class="uk-text-mutted uk-text-small uk-margin-small-<?= ($node->props[$form_name . '_submit_button_alignment'] == 'right' ? 'left' : 'right') ?>" 
                                            @click="copyDataTo<?= ucfirst($form_name) ?>()" 
                                            uk-icon="icon: <?= ($node->props['show_copy_from_icon'] == 'custom') ? $node->props['show_copy_from_custom_icon'] : $node->props['show_copy_from_icon'] ?>"
                                        >
                                            <?= str_replace('[form_title]', $node->props[($form_name == 'billing' ? 'shipping' : 'billing') . '_form_title'], $node->props['show_copy_from_text']); ?>
                                        </a>

                                <?php endif; ?>

                                <button type="submit" 
                                    class="uk-position-relative uk-button <?= $node->props[$form_name . '_submit_button_size'] ?> <?= $node->props[$form_name . '_submit_button_type'] ?>"
                                    :class="[(loading) ? 'uk-disabled' : '']"
                                >
                                    <span v-if="loading" class="uk-position-absolute" style="left:  0; top:  50%; margin: -10px 0 0 5px; width: 20px; height: 20px;" uk-spinner></span>
                                    <?= $node->props[$form_name . '_submit_button_text'] ?>
                                </button>

                            </div>
                        </div>

                    </form>
                </div>

            </li>
            <?php endforeach; ?>
        </ul>

    </div>

    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    isAlerted: false,
                    globalValidationStatus: <?= $props['globalValidationStatus'] ?>,
                    isValidStatus: <?= $props['isValidStatus'] ? 'true' : 'false' ?>,
                    isGuestCheckout: <?= (CartFactory::get()->guest) ? 'true' : 'false' ?>,
                    isGuest: <?= UserFactory::getActiveUser()->guest ?>,
                    customer: <?= json_encode($customer) ?>,
                    address: <?= json_encode($form_fields) ?>,
                    addresses: <?= json_encode($addresses) ?>,
                    assigned_addresses: <?= json_encode($assigned_addresses) ?>,
                    zones: {
                        shipping: '',
                        billing: ''
                    },
                    empty_fields: [],
                    formErrors: '',
                    formErrorsList: '',
                    loading: false,
                    sameAsChanging: false,
                    openAddAddressForm: false,
                    sameAs: <?= (CartFactory::get()->address_same_as) ? 'true' : 'false' ?>,
                    //language strings
                    COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ADDRESS_ADDED: '<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ADDRESS_ADDED'); ?>',
                    COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ERROR_IN_ADDRESS_FORM: '<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ERROR_IN_ADDRESS_FORM'); ?>',
                    COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ADDRESS_ASSIGNED: '<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ADDRESS_ASSIGNED'); ?>',
                    ajax_headers: {
                        method: 'POST',
                        mode: 'cors',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-Token': Joomla_cls.token,
                            'Content-Type': 'application/json'
                        },
                        redirect: 'follow',
                        referrerPolicy: 'no-referrer'
                    },
                    task_url: Joomla_cls.uri_base + 'index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&format=raw'

                }
            },
            created() {

                if (this.address.shipping.country 
                    && this.address.shipping.country != '')
                {
                    this.updateZones(this.address.shipping.country, 'shipping')
                }
                else
                {
                    this.address.shipping.country = '';
                    if (!this.address.shipping.zone) this.address.shipping.zone = '';
                }

                if (this.address.billing.country 
                    && this.address.billing.country != '')
                {
                    this.updateZones(this.address.billing.country, 'billing')
                }
                else
                {
                    this.address.billing.country = '';
                    if (!this.address.billing.zone) this.address.billing.zone = '';
                }

            },
            mounted() {
                emitter.on('yps_cart_validation_update', this.setValidationStatus);
                emitter.on('yps_cart_set_alert', this.setAlert);
                emitter.on('yps_cart_guest_update', this.setIfGuestCheckout);
            },
            computed: {

                storedShippingAddreses()
                {
                    let addresses = false;
                    if (Object.values(this.assigned_addresses)) {
                        [...Object.values(this.assigned_addresses)].forEach(address => {
                            if (address && address.address_type == 'shipping') {
                                addresses = [address];
                            }
                        })
                    }
                    return addresses;
                },
                storedBillingAddreses()
                {
                    let addresses = false;
                    if (Object.values(this.assigned_addresses)) {
                        [...Object.values(this.assigned_addresses)].forEach(address => {
                            if (address && address.address_type == 'billing') {
                                addresses = [address];
                            }
                        })
                    }
                    return addresses;
                }
            },
            methods: {
                async makeACall(params, url) {

                    const send = JSON.parse(JSON.stringify(this.ajax_headers));
                    send.body  = JSON.stringify(params);

                    const request  = await fetch(this.task_url + url, send);
                    const response = await request.json();

                    if (response.success)
                    {
                        return response.data;
                    }
                    else
                    {
                        UIkit.notification({
                            message: response.message,
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });

                        return false;
                    }
                },

                setAlert(element_id) {
                    console.log('setAlert element_id', element_id);

                    if (element_id == 'billing_address_form_<?= $id ?>' 
                        || element_id == 'shipping_address_form_<?= $id ?>') this.isAlerted = true;
                },

                // Validation Methods Accross Checkout Elements
                async setValidationStatus(status) {
                    console.log(status, 'setValidationStatus Address');
                    this.globalValidationStatus = status;
                    this.isValidStatus          = <?= $props['required_status'] ?> <= status;
                },

                // Validates it's own Validation Status
                async validateStatus() {

                    const params = {
                        'required_status': <?= $props['required_status'] ?>
                    };

                    const response = await this.makeACall(params , '&type=checkout.validatestatus');

                    if (response) this.isValidStatus = true;
                    else this.isValidStatus          = false;
                },
                // get Updated Global Validation Status
                async getValidationStatus(notify) {

                    const response = await this.makeACall({}, '&type=checkout.validationstatus');

                    this.globalValidationStatus = response;

                    if (notify) emitter.emit("yps_cart_validation_update", response);
                },
               
                // Internal Methods
                async emptyFields(address_type) {
                    Object.keys(this.address[address_type]).forEach(field => {
                        if (field != 'customer_id' && field != 'address_type') {
                            this.address[address_type][field] = '';
                        }
                    })
                },
                async setIfGuestCheckout(guest) {
                    if (guest) this.isGuestCheckout = true;
                    else this.isGuestCheckout       = false;
                },
                async fieldChanged(address_type) {
                    this.partialAddressAdd(this.address[address_type]);

                    // Check if Guest should be enabled
                    this.enableGuest();
                },
                async enableGuest() {
                    if (this.isGuest 
                        && !this.isGuestCheckout 
                        && this.globalValidationStatus < 3)
                    {
                        this.isGuestCheckout = true;
                        emitter.emit('yps_cart_set_as_guest', true);
                    }
                },

                copyDataToShipping() {

                    const billing_address_data = (this.storedBillingAddreses) 
                        ? this.storedBillingAddreses[0] 
                        : this.address.billing;

                    Object.keys(this.address.shipping).forEach(field => {

                        if (billing_address_data[field] 
                            && (field != 'address_type' 
                            && field != 'id' ))
                        {

                            switch(field)
                            {
                                case 'country':
                                    this.updateZones(
                                        billing_address_data[field], 
                                        'shipping', 
                                        billing_address_data['zone']
                                    );
                                    break;

                                default:
                                    this.address.shipping[field] = billing_address_data[field];
                                    break;
                            }
                        }

                    });

                },
                copyDataToBilling() {

                    const shipping_address_data = (this.storedShippingAddreses) 
                        ? this.storedShippingAddreses[0] 
                        : this.address.shipping;

                    Object.keys(this.address.billing).forEach(field => {

                        if (shipping_address_data[field] 
                            && field != 'address_type' 
                            && field != 'id')
                        {

                            switch(field)
                            {
                                case 'country':
                                    this.updateZones(
                                        shipping_address_data[field], 
                                        'billing', 
                                        shipping_address_data['zone']
                                    );
                                    break;

                                default:
                                    this.address.billing[field] = shipping_address_data[field];
                                    break;
                            }
                        }

                    });

                },

                copyDataFromToAddress(from, to) {

                    Object.keys(to).forEach(field => {
                        if (from[field]) {
                            to[field] = from[field];
                        }
                    });

                },

                async changeSameAs(event) {

                    const sameAs       = event.target.checked;
                    const address_type = '<?= $active_forms[1] ?>'; // The Second Address Form

                    // Updte cart table
                    const response = await this.makeACall({
                        state: (sameAs) ? 1 : 0,
                        address_type
                    }, '&type=cart.setsameas');

                    if (response)
                    {
                        // Delete Variables
                        if (!sameAs)
                        {
                            delete this.assigned_addresses[address_type];
                            delete this.addresses[address_type];
                            this.emptyFields(address_type);
                        }
                        // Duplicate Data and Save
                        else
                        {
                            if (address_type == 'shipping')
                            {
                                this.submitAddressForm('billing', false, true);
                            }
                            else
                            {
                                this.submitAddressForm('shipping', false, true);
                            }

                        }

                        this.sameAsChanging = false;

                        // this.sameAs = sameAs;

                    }
                },

                async partialAddressAdd(address) {

                    this.loading = true;

                    const response = await this.makeACall(address , '&type=address.addtempaddress');

                    this.loading = false;
                    if (response)
                    {
                        address.id = response.address_id;
                        return true;
                    } else {
                        return false;
                    }
                },

                async submitAddressForm(address_type, tab_index, save_all) {

                    // If addresses are set as same, we save them both programatically
                    if (save_all) {

                        switch(address_type)
                        {
                            case 'billing':
                                this.copyDataToShipping();
                                this.submitAddressForm('shipping');
                                break;

                            case 'shipping':
                                this.copyDataToBilling();
                                this.submitAddressForm('billing');
                                break;
                        }

                    }

                    this.loading = true;

                    const response = await this.makeACall(this.address[address_type] , '&type=address.addaddress');

                    this.loading = false;
                    if (response)
                    {
                        this.assigned_addresses[address_type] = response;
                        this.getValidationStatus(true);
                        
                        emitter.emit("address_saved", response);

                    }
                },

                async deletAddress(uid, address_type){

                    const params = {
                        address_id: uid,
                        remove_from_cart: 1,
                        address_type: address_type
                    };

                    const response = await this.makeACall(params , '&type=address.remove');

                    if (response)
                    {
                        delete this.assigned_addresses[address_type];
                        Object.keys(this.address[address_type]).forEach(field_name => {
                            if (field_name != 'address_type' && field_name != 'address_id') {
                                this.address[address_type][field_name] = '';
                            }
                        })
                        
                        this.getValidationStatus(true);
                    }
                },
                editAddress(address){
                    delete this.assigned_addresses[address.address_type];                    
                },
                
                async updateZones(country_id, address_type, assign_zone) {

                    // Empty Country
                    if (country_id == '') {
                        this.zones[address_type] = '';
                        this.address[address_type].zone = '';
                        return;
                    }

                    const params = {
                        country_id: country_id
                    };

                    const response = await this.makeACall(params , '&type=address.getzones');

                    if (response)
                    {
                        // Applying Zones to a Subfield
                        this.zones[address_type] = response;

                        // Set dropdown to initial value
                        this.address[address_type].zone = '';

                        // Mapping Zones in case of Copy
                        if (!this.address[address_type].zone && (!assign_zone || assign_zone == '')) {
                            this.address[address_type].zone = '';
                        }
                        if (assign_zone && assign_zone != '') {
                            this.address[address_type].zone = assign_zone;
                        }
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

<?= $el->end(); ?>