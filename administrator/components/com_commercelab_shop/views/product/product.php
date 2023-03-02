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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;

if (Version::MAJOR_VERSION === 3)
{
	HTMLHelper::_('behavior.keepalive');
	HTMLHelper::_('behavior.formvalidator');
}

/** @var array $vars */
/** @var CommerceLabShop\Product\Product $item */

$item         = $vars['item'];
$builderLink  = $vars['builderLink'];
$editor_field = $vars['editor_field'];

$state_pending = $item ? ($item->joomlaItem->state && (strtotime($item->joomlaItem->publish_up) > time())) : false ;

?>

<div id="p2s_product_form">

	<!-- Overlay FOr Forced Saving and Reloading -->
	<div v-cloak v-if="main_loading" class="uk-text-center uk-overlay uk-width-1-1 uk-height-1-1 uk-position-absolute uk-position-top uk-position-left" style="background: rgb(255 255 255 / 90%); z-index: 100000000;">
		<span class="uk-display-block" style="margin-top: 200px;"  uk-icon="icon: server; ratio: 3"></span>
		<span class="uk-spinner uk-margin-rigth"  uk-icon="icon: refresh; ratio: 0.9"></span> <span class="h1"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_SAVING') ?></span></h1>
	</div>

	<!-- Item Form -->
    <form @submit.prevent="saveItem" v-cloak>

        <div uk-grid>
            <div class="uk-width-1-1">
                <div>
					<nav class="uk-navbar-container uk-flex-wrap uk-padding-small editing-save" 
						uk-navbar 
						uk-sticky="show-on-up: true; animation: uk-animation-slide-top; bottom: #bottom"
						style="border-radius: 8px; z-index: 980;" 
					>
						<div uk-grid>
							
	                        <div class="uk-width-expand@m">
	                            <span class="uk-navbar-item uk-logo" v-cloak>
	                                <span v-show="form.itemid">
	                                	<span class="uk-display-block uk-text-small uk-text-muted">
	                                		<?= Text::_('COM_COMMERCELAB_SHOP_ADD_DISCOUNTS_MODAL_EDITING'); ?>
	                                	</span>
	                                	{{form.jform_title}}
	                                </span>
	                                <span v-show="!form.itemid">
	                                	<span class="uk-display-block uk-text-small uk-text-muted">
	                                		<?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_TITLE'); ?>
	                                	</span>
	                                	{{form.jform_title}}
	                                </span>
	                            </span>
	                        </div>

	                        <div class="uk-width-auto@m uk-text-right uk-flex uk-flex-middle">
								<button type="submit" @click="andClose = false" class="uk-button uk-button-default button-success uk-button-small uk-margin-right">
									<?= Text::_('JTOOLBAR_APPLY'); ?>
	                            </button>
	                            <button type="submit" @click="andClose = true" class="uk-button uk-button-default button-success uk-button-small uk-margin-right">
									<?= Text::_('JTOOLBAR_SAVE'); ?>
	                            </button>
	                            <a class="uk-button uk-button-default uk-button-small uk-margin-right"
	                               href="index.php?option=com_commercelab_shop&view=products"><?= Text::_('JTOOLBAR_CANCEL'); ?></a>

	                            <button type="submit" @click="openBuilder = true" @click="openBuilder" id="openBuilderButton" data-url="<?= $builderLink; ?>" 
	                            	class="uk-button uk-button-default button-primary uk-button-small">
									<span uk-icon="icon: desktop"></span> <?= Text::_('COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON'); ?>
	                            </button>
	                        </div>

						</div>

                    </nav>

                </div>
            </div>
		</div>

		<div class="main-section uk-grid-margin" uk-grid> 

			<div class="center-section uk-width-expand@l">
                <div class="uk-width-1-1@m uk-width-1-1@l uk-width-1-1@xl ">

					<?= LayoutHelper::render('product/card_details', [
						'form'         => $vars['form'],
						'item'         => $item,
						'editor_field' => $editor_field,
						'cardStyle'    => 'default',
						'cardTitle'    => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_DETAILS',
						'cardId'       => 'details',
						// 'fields'       => array('title', 'short_desc', 'long_desc')
						'fields'       => ['title', 'subtitle']
					]); ?>

					<?= str_replace('control-group', '', LayoutHelper::render('card', [
						'form'             => $vars['form'],
						'cardTitle'        => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_IMAGES',
						'cardStyle'        => 'default',
						'cardId'           => 'images',
						'fields'           => ['teaserimage', 'fullimage'],
						'field_grid_width' => 'uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-2@l uk-child-width-1-2@xl',
					])); ?>

					<?php foreach ($vars['extensions'] as $extension) : ?>
						<?= $extension->html; ?>
					<?php endforeach; ?>

                    <span v-show="form.jform_product_type == 2">
						<?= LayoutHelper::render('product/card_digital', [
							'form'      => $vars['form'],
							'cardTitle' => 'Digital Details',
							'cardStyle' => 'default',
							'cardId'    => 'digital',
						]); ?>
					</span>
					<?= LayoutHelper::render('product/card_variant', [
						'form'             => $vars['form'],
						'cardTitle'        => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_VARIANTS',
						'cardStyle'        => 'default',
						'cardId'           => 'variants',
						'fields'           => ['variants'],
						'field_grid_width' => '1-1',
					]); ?>

					<?= LayoutHelper::render('product/card_options', [
						'form'             => $vars['form'],
						'cardTitle'        => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_OPTIONS',
						'cardStyle'        => 'default',
						'cardId'           => 'options',
						'fields'           => ['options'],
						'field_grid_width' => '1-1',
					]); ?>

					<?php if (JVERSION >= "4.0.0" && count($vars['custom_fields'][0])) : ?>
						<?= LayoutHelper::render('product/custom_fields_card', [
							'form'             => $vars['form'],
							'editor_field'     => $editor_field,
							'custom_fields'    => $vars['custom_fields'],
							'cardTitle'        => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_JOOMLA_CUSTOM_FIELDS',
							'cardStyle'        => 'default',
							'cardId'           => 'custom_fields',
							'field_grid_width' => '1-1',
						]); ?>
					<?php endif; ?>
                </div>
			</div>

			<div class="right-bar uk-width-auto@l">
	        	<div 
	        		:class="statePending ? 'state-pending' : ''"
	        		class="<?= ($state_pending) ? 'state-pending' : '' ?> uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-1@l" uk-grid uk-height-match="target: > div > .uk-card">

					<?= LayoutHelper::render('card', [
						'form'      => $vars['form'],
						'cardTitle' => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_ACCESS',
						'cardStyle' => 'default',
						'cardId'    => 'access',
						'fields'    => ['state', 'access', 'publish_up_date']
					]); ?>
					<?= LayoutHelper::render('card', [
						'form'      => $vars['form'],
						'cardTitle' => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_ORGANISATION',
						'cardStyle' => 'default',
						'cardId'    => 'organisation',
						'fields'    => ['category', 'featured', 'tags']
					]); ?>
					<?= LayoutHelper::render('card', [
						'form'      => $vars['form'],
						'cardTitle' => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_PRODUCT_PRICING',
						'cardStyle' => 'default',
						'cardId'    => 'pricing',
						'fields'    => ['base_price', 'taxclass', 'apply_discount', 'discount']
					]); ?>

					<?= LayoutHelper::render('card', [
						'form'      => $vars['form'],
						'cardTitle' => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_INVENTORY',
						'cardStyle' => 'default',
						'cardId'    => 'inventory',
						'fields'    => ['sku', 'manage_stock', 'stock']
					]); ?>



					<?= LayoutHelper::render('card', [
						'form'      => $vars['form'],
						'cardTitle' => 'COM_COMMERCELAB_SHOP_ADD_PRODUCT_SHIPPING',
						'cardStyle' => 'default',
						'cardId'    => 'shipping',
						'fields'    => ['shipping_mode', 'flatfee', 'weight']
					]); ?>
					<?= LayoutHelper::render('optiontemplates.optiontemplatelistmodal', []); ?>
					<?= LayoutHelper::render('optiontemplates.optiontemplatecheckboxlistmodal', []); ?>
				</div>
			</div>
        
		</div>

    </form>

	<?= LayoutHelper::render('product/modals/advancedOptions'); ?>

</div>

<!--REMOVE ALL EMPTY LABELS-->
<script>Array.from(document.getElementsByClassName("control-label")).forEach(function(e){""===e.innerHTML&&e.remove()});</script>

<script>
    var bar = document.getElementById('js-progressbar');

    UIkit.upload('.p2s_file_upload', {

        url: '',
        multiple: false,
        beforeAll: function () {
            this.url = '<?= Uri::base(); ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=file.upload&format=raw';
        },

        loadStart: function (e) {

            bar.removeAttribute('hidden');
            bar.max = e.total;
            bar.value = e.loaded;
        },

        progress: function (e) {

            bar.max = e.total;
            bar.value = e.loaded;
        },

        loadEnd: function (e) {

            bar.max = e.total;
            bar.value = e.loaded;
        },

        completeAll: function () {


            const response = JSON.parse(arguments[0].response);

            if (response.success) {
                setTimeout(function () {
                    bar.setAttribute('hidden', 'hidden');
                }, 1000);
                emitter.emit('p2s_product_file_upload', response.data);
                UIkit.notification({
                    message: 'Uploaded',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
            } else {
                UIkit.notification({
                    message: 'There was an error',
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 5000
                });
            }
        }


    });

</script>