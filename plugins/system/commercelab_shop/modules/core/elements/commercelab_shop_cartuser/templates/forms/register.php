<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$language = Factory::getLanguage();
$language->load('com_commercelab_shop', JPATH_ADMINISTRATOR);

echo "{emailcloak=off}";

?>

<form @submit.prevent="submitRegisterForm" class="uk-form <?= $props['labels_layout'] ?>">
<!-- 		<h4 class="uk-h4">
			<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CREATE_AN_ACCOUNT'); ?>
			<span v-show="loading" uk-spinner class="uk-hidden"></span>
		</h4>
 -->
	<div class="uk-child-width-1-1 <?= $props['fields_width'] ?>" uk-grid>

		<div class="<?= $props['rows_spacing'] ?>">

			<?php if ($props['show_labels']) : ?>
				<label class="uk-form-label" for="yps_cartsignup_username">
					<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_USERNAME'); ?>
				</label>
			<?php endif; ?>

			<div class="uk-form-controls">
				<input 
					class="uk-input <?= $props['fields_size'] ?>" id="yps_cartsignup_username" type="text"
				   	:class="{ 'uk-form-danger' : formErrorsList['username'] !== undefined ? true : false}"
				   	:style="
				   		(formErrorsList['username'] !== undefined) 
				   			? 'border-color: red; border-style: solid; border-width: 1px;' 
				   			: ''
				   	"
				   	placeholder="<?= ($props['show_placeholders']) ? Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_USERNAME_PLACEHOLDER') : ''; ?>"
				   	v-model="reg_form.username"
				   	required
				>
			</div>
		</div>

		<div class="<?= $props['rows_spacing'] ?>">

			<?php if ($props['show_labels']) : ?>
				<label class="uk-form-label" for="yps_cartsignup_password">
					<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_PASSWORD'); ?>
				</label>
			<?php endif; ?>

			<div class="uk-form-controls">
				<input class="uk-input <?= $props['fields_size'] ?>" id="yps_cartsignup_password" type="password"
				    :class="{ 'uk-form-danger' : formErrorsList['password'] !== undefined ? true : false}"
				    :style="formErrorsList['password'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
				    placeholder="<?= ($props['show_placeholders']) ? Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_PASSWORD_PLACEHOLDER') : ''; ?>"
				    required v-model="reg_form.password">
			</div>
		</div>

		<div class="<?= $props['rows_spacing'] ?>">

			<?php if ($props['show_labels']) : ?>
				<label class="uk-form-label" for="yps_cartsignup_name">
					<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_YOUR_NAME'); ?>
				</label>
			<?php endif; ?>

			<div class="uk-form-controls">
				<input class="uk-input <?= $props['fields_size'] ?>" type="text"
				    :class="{ 'uk-form-danger' : formErrorsList['name'] !== undefined ? true : false}"
				    :style="formErrorsList['name'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
				    placeholder="<?= ($props['show_placeholders']) ? Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_YOUR_NAME_PLACEHOLDER') : ''; ?>"
				    required v-model="reg_form.name">
			</div>
		</div>

		<div class="<?= $props['rows_spacing'] ?>">

			<?php if ($props['show_labels']) : ?>
				<label class="uk-form-label" for="yps_cartsignup_email">
					<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_YOUR_EMAIL'); ?>
				</label>
			<?php endif; ?>

			<div class="uk-form-controls">
				<input class="uk-input <?= $props['fields_size'] ?>" id="yps_cartsignup_email" type="email"
					:class="{ 'uk-form-danger' : formErrorsList['email'] !== undefined ? true : false}"
					:style="formErrorsList['email'] !== undefined ? 'border-colour: red; border-style: solid; border-width: 1px;' : ''"
					placeholder="<?= ($props['show_placeholders']) ? Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_YOUR_EMAIL_PLACEHOLDER') : ''; ?>"
					required v-model="reg_form.email">
			</div>
		</div>

	</div>

	<div class="uk-child-width-1-1 <?= $tabs_button_alignment ?>" uk-grid>
		<div>
			<span class="uk-margin-right" v-if="loading" style="width: 20px; height: 20px;" uk-spinner></span>
			<button class="uk-button <?= $tabs_button_size ?> <?= $tabs_button_type ?>" type="submit"><?= $tabs_button_text ?></button>
		</div>
	</div>
	
</form>
