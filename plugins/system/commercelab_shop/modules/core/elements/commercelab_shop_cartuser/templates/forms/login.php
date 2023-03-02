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

?>

<form @submit.prevent="submitLoginForm" class="uk-form <?= $props['labels_layout'] ?>">

<!-- 		<h4 class="h4">
			<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_LOGIN'); ?>
		</h4>
 -->
	<div class="uk-child-width-1-1 <?= $props['fields_width'] ?>" uk-grid>

		<div class="<?= $props['rows_spacing'] ?>">

			<?php if ($props['show_labels']) : ?>
				<label class="uk-form-label" for="yps_cartlogin_username">
					<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_USERNAME'); ?>
				</label>
			<?php endif; ?>

			<input 
				v-model="login_form.username" 
				id="yps_cartlogin_username" 
				class="uk-input <?= $props['fields_size'] ?>" 
				type="text" 
				placeholder="<?= ($props['show_placeholders']) ? Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_USERNAME') : ''; ?>" 
				required
			>
		</div>

		<div class="<?= $props['rows_spacing'] ?>">

			<?php if ($props['show_labels']) : ?>
				<label class="uk-form-label" for="yps_cartlogin_password">
					<?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_PASSWORD'); ?>
				</label>
			<?php endif; ?>

			<div class="uk-form-controls">
				<input id="yps_cartlogin_password" class="uk-input <?= $props['fields_size'] ?>" type="password"
			       	placeholder="<?= ($props['show_placeholders']) ? Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_PASSWORD') : ''; ?>" 
			       	required
			       	v-model="login_form.password">
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
