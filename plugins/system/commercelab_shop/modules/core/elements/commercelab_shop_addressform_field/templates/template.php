<?php


use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Config\ConfigFactory;
use CommerceLabShop\Country\CountryFactory;
use CommerceLabShop\Customer\CustomerFactory;
use CommerceLabShop\Language\LanguageFactory;

$field_names = [
    ""             => "Choose a Field First",
    "first_name"   => "First Name",
    "last_name"    => "Last Name",
    "email"        => "Email",
    "phone"        => "Phone Number",
    "mobile_phone" => "Mobile Phone",
    "address1"     => "Address",
    "address2"     => "Address 2",
    "address3"     => "Address 3",
    "city"         => "City",
    "postcode"     => "Postal Code",
    "country"      => "Country",
    "zone"         => "State",
    "city"         => "City",
    "vat"          => "VAT Number",
    "company_name" => "Company Name",
];


// Set Label
if ($props['field_label_show_use_global']) {
    $label = $element['show_labels'];
} else {
    $label = $props['field_label_show'];
}

if ($label) {

    $label = ($props['field_label'] != '')
        ? $props['field_label']
        : $field_names[$props['field_type']];

}

// Set Placeholder
if ($props['field_placeholder_show_use_global']) {
    $placeholder = $element['show_placeholders'];
} else {
    $placeholder = $props['field_placeholder_show'];
}

if ($placeholder) {

    $placeholder = ($props['field_placeholder'] != '')
        ? $props['field_placeholder']
        : $field_names[$props['field_type']];

} else {
    $placeholder = '';
}

// Set Width
if ($props['field_width_use_global']) {

    $field_width = ($element['fields_width'] == 'custom') 
            ? ($element['fields_width_custom'] != '' 
                ? $element['fields_width_custom']
                : 'uk-width-1-1')
            : $element['fields_width'];

} else {

    $field_width = ($props['field_width'] == 'custom' 
        ? ($props['field_width_custom'] != '' 
            ? $props['field_width_custom']
            : 'uk-width-1-1')
        : $props['field_width']);

}


// Fieldset COntainer
$container = $this->el('div', [

    'class' => [
        'uk-width-1-1 ' . $field_width,
        $element['rows_spacing']
    ]

]);

$default_icons_set = [
    "first_name"   => "user",
    "last_name"    => "user",
    "email"        => "mail",
    "phone"        => "receiver",
    "mobile_phone" => "receiver",
    "address1"     => "location",
    "address2"     => "location",
    "address3"     => "location",
    "city"         => "location",
    "postcode"     => "location",
    "country"      => "",
    "zone"         => "",
    "vat"          => "hashtag",
    "company_name" => "bag",
];


$empty_field_icon = $valid_field_icon = $invalid_field_icon = '';

if ($element['show_icons']) {

    $empty_field_icon   = (isset($default_icons_set[$props['field_type']])) ? $default_icons_set[$props['field_type']] : '';
    $valid_field_icon   = 'check';
    $invalid_field_icon = 'warning';

    $empty_field_icon_color   = 'uk-text-muted';
    $valid_field_icon_color   = 'uk-text-success';
    $invalid_field_icon_color = 'uk-text-danger';

    if (!$element['show_icons_default']) {

        // Empty Field
        $empty_field_icon = ($element['empty_field_icon'] == '')
            ? ''
            : (($element['empty_field_icon_custom'] != '') 
                ? $element['empty_field_icon_custom']
                : $default_icons_set[$props['field_type']]
            )
        ;
        $empty_field_icon_color = ($element['empty_field_color'] != '') 
            ? $element['empty_field_color']
            : 'uk-text-mutted';


        // Valid Field
        $valid_field_icon = ($element['valid_field_icon'] == '')
            ? ''
            : (($element['valid_field_icon_custom'] != '') 
                ? $element['valid_field_icon_custom']
                : $default_icons_set[$props['field_type']]
            )
        ;
        $valid_field_icon_color = ($element['valid_field_color'] != '') 
            ? $element['valid_field_color'] 
            : 'uk-text-success';


        // Invalid Field
        $invalid_field_icon = ($element['invalid_field_icon'] == '')
            ? 'warning'
            : (($element['invalid_field_icon_custom'] != '') 
                ? $element['invalid_field_icon_custom']
                : $default_icons_set[$props['field_type']]
            )
        ;
        $invalid_field_icon_color = ($element['invalid_field_color'] != '') 
            ? $element['invalid_field_color'] 
            : 'uk-text-danger';
    }

}


$field_name = $props['field_type'];
$field_id   = $address_type . "_" . $props['field_type'];
$required   = ($props['field_required'] 
    || $props['field_type'] == 'email' 
    || $props['field_type'] == 'first_name' 
    || $props['field_type'] == 'last_name');
?>

<?php if (!$props['field_address_type_exclude'] 
    || ($props['field_address_type_exclude'] && $address_type == $props['field_address_type_exclude'])) : ?>

<?= $container($element) ?>

    <?php if ($label) : ?>
        <label class="uk-form-label" for="<?= $field_id ?>"
            :class="{'uk-text-danger': isAlerted && '<?= $required ?>' && address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] == ''}"
        >
            <?= $label ?>
            <?php if ($required) : ?>
                <span class="uk-text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <div class="uk-form-controls uk-form-controls-text">
        <?php if ( in_array($props['field_type'], ['country', 'zone'])) : ?>

            <?php if ($props['field_type'] == 'country') : ?>
                <select 
                    id="<?= $field_id ?>" 
                    @change="updateZones(address['<?= $address_type ?>']['country'], '<?= $address_type ?>'), fieldChanged('<?= $address_type ?>')"
                    <?= ($required) ? 'required="required"' : '' ?>
                    v-model="address['<?= $address_type ?>']['country']"
                    :class="{'uk-text-danger uk-form-danger': isAlerted && '<?= $required ?>' && address['<?= $address_type ?>']['country'] == ''}"
                    class="uk-select <?= $element['fields_size'] ?>">

                        <option value="">
                            <?= ($required && !$label) ? '*' : '' ?>
                            <?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_COUNTRY_SELECT_DEFAULT'); ?>    
                        </option>

                        <?php foreach (CountryFactory::getList(0, 0, true) as $country) : ?>
                            <option value="<?= $country->id ?>"><?= $country->country_name ?></option>
                        <?php endforeach; ?>

                </select>
            <?php endif; ?>

            <?php if ($props['field_type'] == 'zone') : ?>

                <select
                    id="<?= $field_id ?>" 
                    @change="fieldChanged('<?= $address_type ?>')"
                    v-model="address['<?= $address_type ?>']['zone']"
                    <?= ($required) ? 'required="required"' : '' ?>
                    class="uk-select <?= $element['fields_size'] ?>"
                    :class="{'uk-text-danger uk-form-danger': isAlerted && '<?= $required ?>' && address['<?= $address_type ?>']['zone'] == ''}"
                    :disabled="(zones['<?= $address_type ?>'].length ? false : true)">

                        <option
                            :selected="address['<?= $address_type ?>']['zone'] == ''"
                            value="">
                                <?= ($required && !$label) ? '*' : '' ?>
                                <?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_STATE_SELECT_DEFAULT'); ?>
                        </option>

                        <option v-for="zone in zones['<?= $address_type ?>']" :value="zone.id" :selected="address.zone == zone.id">
                            {{zone.zone_name}}
                        </option>

                </select>
            <?php endif; ?>

        <?php else : ?>
            <div class="uk-inline uk-width-1-1">

                <!-- Field is Alerted / Invalid -->
                <span v-if="isAlerted && '<?= $required ?>' && address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] == ''" 
                    class="<?= $invalid_field_icon_color?> uk-form-icon uk-form-icon-flip uk-animation-fade uk-animation-fast" 
                    uk-icon="icon: <?= $invalid_field_icon ?>">
                </span>

                <!-- Field is Empty -->
                <span v-else-if="address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] == ''" 
                    class="<?= $empty_field_icon_color?> uk-form-icon uk-form-icon-flip uk-animation-fade uk-animation-fast" 
                    uk-icon="icon: <?= $empty_field_icon ?>"
                ></span>

                <!-- Field has Data and is Valid -->
                <span v-else-if="address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] != ''" 
                    class="<?= $valid_field_icon_color?> uk-form-icon uk-form-icon-flip uk-animation-fade uk-animation-fast" 
                    uk-icon="icon: <?= $valid_field_icon ?>">        
                </span>

                <!-- Field Has Data ? -->
                <span
                    v-else-if="false" 
                    class="uk-form-icon uk-form-icon-flip" 
                    :class="(address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] != '') ? 'uk-text-success' : uk-text-muted" 
                    uk-icon="icon: <?= $icon ?>">        
                </span>
                
                <!-- $empty_field_icon = $valid_field_icon = $invalid_field_icon = ''; -->


                <!-- <span v-if="address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] == ''" class="uk-form-icon uk-form-icon-flip" uk-icon=""></span> -->
                <!-- <span class="uk-form-icon" uk-icon="icon: cross"></span> -->
                <input 
                    id="<?= $field_id ?>" 
                    @input="fieldChanged('<?= $address_type ?>')"
                    placeholder="<?= ($required && !$label) ? '* ' . $placeholder : $placeholder ?>" 
                    v-model="address['<?= $address_type ?>']['<?= $props['field_type'] ?>']"
                    class="uk-input <?= $element['fields_size'] ?>" 
                    <?php if (false) : ?>
                        :class="{'uk-form-success': address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] != ''}"
                    <?php endif; ?>
                    <?= ($required) ? 'required="required"' : '' ?> 
                    :class="{'uk-text-danger uk-form-danger': isAlerted && '<?= $required ?>' && address['<?= $address_type ?>']['<?= $props['field_type'] ?>'] == ''}"
                    name="<?= $props['field_type'] ?>">

            </div>

        <?php endif; ?>
        
    </div>
<?= $container->end() ?>

<?php endif; ?>