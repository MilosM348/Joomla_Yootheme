<?php
/**
 * @package     CommerceLab Shop - Customer Addresses
 *
 * @copyright   Copyright (C) 2022 CommerceLab. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var $params */
/** @var $config */
/** @var $countries array */


\CommerceLabShop\Language\LanguageFactory::load();


echo "{emailcloak=off}";


?>
<div id="yps-editAddressModal" class="uk-modal-container" uk-modal="">

	<div class="uk-modal-dialog uk-modal-body">

		<h2 class="uk-modal-title">
			<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_EDIT_ADDRESS'); ?>: {{addressForEdit.name}}
		</h2>

		<form @submit.prevent="submitUpdateAddress()">
			<input type="hidden" name="address_id" v-model="addressForEdit.id">

			<div class="uk-margin">
				<label class="uk-form-label"
				       for="yps_editaddress_title">
					<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_NAME'); ?>
				</label>
				<div class="uk-form-controls">
					<input class="uk-input" type="text" v-model="addressForEdit.name"
					       name="name" id="yps_editaddress_title"
					       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_NAME_PLACEHOLDER'); ?>"
					       required>
				</div>
			</div>

			<?php if ($config->get('address_show') == 1): ?>

				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_editaddress_address1"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE1'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" type="text" v-model="addressForEdit.address1"
						       name="address1"
						       id="yps_editaddress_address1"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE1_PLACEHOLDER'); ?>">
					</div>
				</div>

				<?php if ($config->get('addressline2_show')): ?>
					<div class="uk-margin">
						<label class="uk-form-label"
						       for="yps_editaddress_address2"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE2'); ?></label>
						<div class="uk-form-controls">
							<input class="uk-input" v-model="addressForEdit.address2"
							       type="text"
							       name="address2"
							       id="yps_editaddress_address2"
							       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE2_PLACEHOLDER'); ?>"
								<?= ($config->get('addressline2_required') ? 'required' : ''); ?>>
						</div>
					</div>
				<?php endif; ?>


				<?php if ($config->get('addressline3_show')): ?>
					<div class="uk-margin">
						<label class="uk-form-label"
						       for="yps_editaddress_address3"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE3'); ?></label>
						<div class="uk-form-controls">
							<input class="uk-input"
							       type="text"
							       id="yps_editaddress_address3"
							       name="address3" v-model="addressForEdit.address23"
							       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE3_PLACEHOLDER'); ?>"
								<?= ($config->get('addressline3_required') ? 'required' : ''); ?>>
						</div>
					</div>
				<?php endif; ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_editaddress_town"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_CITY'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" type="text" v-model="addressForEdit.town"
						       name="town"
						       id="yps_editaddress_town"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_CITY_PLACEHOLDER'); ?>"
						>
					</div>
				</div>

				<?php if ($config->get('postcode_show')): ?>
					<div class="uk-margin">
						<label class="uk-form-label"
						       for="yps_editaddress_postcode"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_POSTCODE'); ?></label>
						<div class="uk-form-controls">
							<input class="uk-input" v-model="addressForEdit.postcode"
							       type="text"
							       name="postcode"
							       id="yps_editaddress_postcode"
							       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_POSTCODE_PLACEHOLDER'); ?>"
								<?= ($config->get('postcode_required') ? 'required' : ''); ?>>
						</div>
					</div>
				<?php endif; ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_editaddress_zone"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_STATE'); ?></label>
					<div class="uk-form-controls">
						<select class="uk-select" id="yps_editaddress_zone" name="zone"
						        v-model="addressForEdit.zone">
							<option value=""
							        disabled><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_STATE_SELECT_DEFAULT'); ?></option>

							<option v-for="zone in zones" :value="zone.id" :selected="addressForEdit.zone == zone.id">{{zone.zone_name}}
							</option>

						</select>
					</div>
				</div>

				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_editaddress_country">
						<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_COUNTRY'); ?>
					</label>
					<div class="uk-form-controls">
						<select @change="updateZones(addressForEdit.country)" class="uk-select"
						        id="yps_editaddress_country"
						        name="country"
						        v-model="addressForEdit.country">
							<option value=""
							        disabled><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_COUNTRY_SELECT_DEFAULT'); ?></option>
							<?php foreach ($countries as $country) : ?>
								<option value="<?= $country->id; ?>"
								        :selected="addressForEdit.country === <?= $country->id; ?>"><?= $country->country_name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

				</div>

			<?php endif; // ends 'address_show' ?>
			<?php if ($config->get('mtelephone_show')): ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_editaddress_mobile"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_MOBILE'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" id="yps_editaddress_mobile" type="text"
						       v-model="addressForEdit.mobile_phone"
						       name="mobile_phone"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_MOBILE_PLACEHOLDER'); ?>"
							<?= ($config->get('mtelephone_required') ? 'required' : ''); ?>>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($config->get('telephone_show')): ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_editaddress_phone"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_TEL'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" id="yps_editaddress_phone" type="text"
						       v-model="addressForEdit.phone"
						       name="phone"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_TEL_PLACEHOLDER'); ?>"
							<?= ($config->get('telephone_required') ? 'required' : ''); ?>>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($config->get('email_show')): ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_editaddress_email"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_EMAIL'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" id="yps_editaddress_email" type="email"
						       v-model="addressForEdit.email"
						       name="email"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_EMAIL_PLACEHOLDER'); ?>"
							<?= ($config->get('email_required') ? 'required' : ''); ?>>
					</div>
				</div>
			<?php endif; ?>
			<p class="uk-text-right">
				<button class="uk-button uk-button-default uk-modal-close"
				        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_CANCEL'); ?></button>
				<button class="uk-button uk-button-primary" type="submit"
				><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_SAVE'); ?>
				</button>
			</p>
		</form>


	</div>
</div>
