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

$data      = $displayData;

?>

<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
                    <?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="uk-card-body">
        <div class="uk-grid uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-1@l uk-child-width-1-2@xl uk-grid-match uk-grid-small" uk-grid>

            <div v-if="false" v-for="address in form.jform_addresses">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <div class="uk-grid" uk-grid="">
                            <div class="uk-width-expand">{{address.name}}</div>
                            <div class="uk-width-auto">
                                <div class="uk-text-right">
                                    <button @click="editAddress(address)" v-show="!address.edit"
                                            class="uk-button uk-button-link"><span uk-icon="icon:pencil"></span>
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="uk-card-body" v-show="!address.edit">
                        {{address.address_as_csv}}
                    </div>
                    <div class="uk-card-body" v-show="address.edit">

                        <label for="address_name"
                               class="uk-form-label">Name</label>
                        <div class="uk-form-controls">
                            <input
                                    id="address_name"
                                    v-model="address.name"
                                    type="text" required=""
                                    name="name"
                                    class="uk-input"
                                    placeholder="Name">
                        </div>

                        <label for="address_address1" class="uk-form-label">Address Line 1</label>
                        <div class="uk-form-controls">
                            <input
                                    id="address_address1"
                                    v-model="address.address1"
                                    required="" type="text"
                                    name="address1"
                                    class="uk-input"
                                    placeholder="Address Line 1">
                        </div>

                        <label
                                for="address_address2"
                                class="uk-form-label">Address Line
                            2</label>
                        <div class="uk-form-controls"><input
                                    id="address_address2"
                                    v-model="address.address2"
                                    type="text"
                                    name="address2"
                                    class="uk-input"
                                    placeholder="Address Line 2">
                        </div>


                        <label for="address_address3" class="uk-form-label">Address Line 3</label>
                        <div class="uk-form-controls">
                            <input
                                    id="address_address3"
                                    v-model="address.address3"
                                    type="text"
                                    name="address3"
                                    class="uk-input"
                                    placeholder="Address Line 3">
                        </div>


                        <label for="address_town" class="uk-form-label">City</label>
                        <div class="uk-form-controls">
                            <input id="address_town"
                                   v-model="address.town"
                                   type="text" name="town"
                                   class="uk-input"
                                   placeholder="City">
                        </div>


                        <label for="address_country"
                               class="uk-form-label">Country</label>
                        <div class="uk-form-controls">
                            <select @change="getZones(address)"
                                    v-model="address.country"
                                    id="address_country"
                                    name="country_id"
                                    class="uk-select">
                                <option value="" disabled="">--select--</option>
                                <option v-for="country in countries" :value="country.id">{{country.country_name}}
                                </option>

                            </select>
                        </div>

                        <label for="zone_id"
                               class="uk-form-label">State</label>
                        <div class="uk-form-controls">
                            <select v-model="address.zone"
                                    id="address_state"
                                    name="zone_id"
                                    class="uk-select">
                                <option value="" disabled="">--select--</option>
                                <option v-for="zone in address.zones" :value="zone.id">{{zone.zone_name}}
                                </option>

                            </select>
                        </div>

                        <label for="address_postcode" class="uk-form-label">Postcode</label>
                        <div class="uk-form-controls">
                            <input
                                    id="address_postcode"
                                    v-model="address.postcode"
                                    type="text"
                                    name="postcode"
                                    class="uk-input "
                                    placeholder="Postcode">
                        </div>

                        <label for="address_mobile"
                               class="uk-form-label">Mobile
                            Phone</label>
                        <div class="uk-form-controls">
                            <input
                                    id="address_mobile"
                                    v-model="address.mobile_phone"
                                    type="text"
                                    name="mobile_phone"
                                    class="uk-input ng-untouched ng-pristine ng-valid"
                                    placeholder="Mobile Phone">
                        </div>


                        <label for="address_phone" class="uk-form-label">Phone</label>
                        <div class="uk-form-controls">
                            <input
                                    id="address_phone"
                                    type="text" name="phone"
                                    v-model="address.phone"
                                    class="uk-input "
                                    placeholder="Phone">
                        </div>
                        <label
                                for="address_email"
                                class="uk-form-label">Email</label>
                        <div class="uk-form-controls">
                            <input
                                    id="address_email"
                                    v-model="address.email"
                                    type="email" name="email"
                                    class="uk-input "
                                    placeholder="Email">
                        </div>
                    </div>


                    <div class="uk-card-footer" v-show="address.edit">

                        <div class="uk-grid" uk-grid="">
                            <div class="uk-width-expand"></div>
                            <div class="uk-width-auto">
                                <button type="button" @click="saveAddress(address)"
                                        class="uk-button uk-button-primary uk-button-small">
                                    Save
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>


        </div>

    </div>
    <!-- <div class="uk-card-footer"></div> -->
</div>
