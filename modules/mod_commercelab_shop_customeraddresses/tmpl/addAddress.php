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


/** @var $params */
/** @var $config */
/** @var $countries array */

\CommerceLabShop\Language\LanguageFactory::load();


echo "{emailcloak=off}";


?>


<div id="yps-addAddressModal" class="uk-modal-container" uk-modal="stack: true">
	<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADD_NEW_ADDRESS'); ?></h2>
		<form class="uk-margin-bottom" @submit.prevent="submitAddAddress">

			<legend class="uk-legend"><?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ADDRESS_LEGEND'); ?></legend>

			<div class="uk-margin">
				<label class="uk-form-label"
				       for="yps_cart_name"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_NAME'); ?></label>
				<div class="uk-form-controls">
					<input class="uk-input" id="yps_cart_name" type="text"
					       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_NAME_PLACEHOLDER'); ?>"
					       required name="name" v-model="newAddress.name">
				</div>
			</div>

			<?php if ($config->get('address_show', 1)): ?>

				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_cart_address1"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE1'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" id="yps_cart_address1" type="text" required name="address1"
						       :class="{ 'uk-form-danger' : formErrorsList['address1'] !== undefined ? true : false}"
						       :style="formErrorsList['address1'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE1_PLACEHOLDER'); ?>"
						       v-model="newAddress.address1">
					</div>
				</div>

				<?php if ($config->get('addressline2_show', 1)): ?>

					<div class="uk-margin">
						<label class="uk-form-label"
						       for="yps_cart_address2"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE2'); ?></label>
						<div class="uk-form-controls">
							<input class="uk-input" id="yps_cart_address2" type="text" name="address2"
							       :class="{ 'uk-form-danger' : formErrorsList['address2'] !== undefined ? true : false}"
							       :style="formErrorsList['address2'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
							       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE2_PLACEHOLDER'); ?>" <?= ($config->get('addressline2_required') ? 'required' : ''); ?>
							       v-model="newAddress.address2">
						</div>
					</div>
				<?php endif; ?>


				<?php if ($config->get('addressline3_show', 1)): ?>
					<div class="uk-margin">
						<label class="uk-form-label"
						       for="yps_cart_address3"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE3'); ?></label>
						<div class="uk-form-controls">
							<input class="uk-input" id="yps_cart_address3" type="text" name="address3"
							       :class="{ 'uk-form-danger' : formErrorsList['address3'] !== undefined ? true : false}"
							       :style="formErrorsList['address3'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
							       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_ADDRESS_LINE3_PLACEHOLDER'); ?>" <?= ($config->get('addressline3_required') ? 'required' : ''); ?>
							       v-model="newAddress.address3">
						</div>
					</div>

				<?php endif; ?>
				<?php if ($config->get('town_show', 1)): ?>
					<div class="uk-margin">
						<label class="uk-form-label"
						       for="yps_cart_town"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_CITY'); ?></label>
						<div class="uk-form-controls">
							<input class="uk-input" id="yps_cart_town"
							       :class="{ 'uk-form-danger' : formErrorsList['town'] !== undefined ? true : false}"
							       :style="formErrorsList['town'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
							       type="text" name="town"
							       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_CITY_PLACEHOLDER'); ?>" <?= ($config->get('town_required') ? 'required' : ''); ?>
							       v-model="newAddress.town">
						</div>
					</div>
				<?php endif; ?>
				<?php if ($config->get('postcode_show', 1)): ?>
					<div class="uk-margin">
						<label class="uk-form-label"
						       for="yps_cart_postcode"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_POSTCODE'); ?></label>
						<div class="uk-form-controls">
							<input class="uk-input" id="yps_cart_postcode" type="text" name="postcode"
							       :class="{ 'uk-form-danger' : formErrorsList['postcode'] !== undefined ? true : false}"
							       :style="formErrorsList['postcode'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
							       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_POSTCODE_PLACEHOLDER'); ?>" <?= ($config->get('postcode_required') ? 'required' : ''); ?>
							       v-model="newAddress.postcode">
						</div>
					</div>
				<?php endif; ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_cart_country"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_COUNTRY'); ?></label>
					<div class="uk-form-controls">
						<select @change="updateZones(newAddress.country)" class="uk-select" id="yps_cart_country"
						        name="country"
						        v-model="newAddress.country"
						        :class="{ 'uk-form-danger' : formErrorsList['country'] !== undefined ? true : false}"
						        :style="formErrorsList['country'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
						>
							<option value=""><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_COUNTRY_SELECT_DEFAULT'); ?></option>
							<?php foreach ($countries as $country) : ?>
                                <option value="<?= $country->id; ?>"><?= $country->country_name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_cart_zone"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_STATE'); ?></label>
					<div class="uk-form-controls">
						<select class="uk-select" id="yps_cart_zone" name="zone" v-model="newAddress.zone"
						        :class="{ 'uk-form-danger' : formErrorsList['zone'] !== undefined ? true : false}"
						        :style="formErrorsList['zone'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
						>
							<option value=""
							        disabled><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_STATE_SELECT_DEFAULT'); ?></option>
							<option v-for="zone in zones" :value="zone.id">{{ zone.zone_name }}</option>
						</select>
					</div>
				</div>

			<?php endif; // ends 'address_show' ?>
			<?php if ($config->get('mtelephone_show', 1)): ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_cart_mobile"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_MOBILE'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" id="yps_cart_mobile" type="text" name="mobile_phone"
						       :class="{ 'uk-form-danger' : formErrorsList['mobile_phone'] !== undefined ? true : false}"
						       :style="formErrorsList['mobile_phone'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_MOBILE_PLACEHOLDER'); ?>" <?= ($config->get('mtelephone_required') ? 'required' : ''); ?>
						       v-model="newAddress.mobile_phone">
					</div>
				</div>
			<?php endif; ?>
			<?php if ($config->get('telephone_show', 1)): ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_cart_phone"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_TEL'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" id="yps_cart_phone" type="text" name="phone"
						       :class="{ 'uk-form-danger' : formErrorsList['phone'] !== undefined ? true : false}"
						       :style="formErrorsList['phone'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_TEL_PLACEHOLDER'); ?>" <?= ($config->get('telephone_required') ? 'required' : ''); ?>
						       v-model="newAddress.phone">
					</div>
				</div>
			<?php endif; ?>

			<?php if ($config->get('email_show', 1)): ?>
				<div class="uk-margin">
					<label class="uk-form-label"
					       for="yps_cartsignup_email"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_EMAIL'); ?></label>
					<div class="uk-form-controls">
						<input class="uk-input" id="yps_cart_email" type="email" name="email"
						       :class="{ 'uk-form-danger' : formErrorsList['email'] !== undefined ? true : false}"
						       :style="formErrorsList['email'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
						       placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_EMAIL_PLACEHOLDER'); ?>" <?= ($config->get('email_required') ? 'required' : ''); ?>
						       v-model="newAddress.email">
					</div>
				</div>
			<?php endif; ?>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close"
                        type="button"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_CANCEL'); ?></button>
                <button class="uk-button uk-button-primary uk-margin-small-left"
                        type="submit"><?= Text::_('COM_COMMERCELAB_SHOP_MOD_CUSTOMERADDRESSES_ADDRESS_SAVE'); ?></button>
            </p>

		</form>


	</div>
</div>
