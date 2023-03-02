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

$data         = $displayData;
$item         = $data['item'];
$form         = $data['form'];
$editor_field = $data['editor_field'];

?>

<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom uk-animation-fade uk-animation-fast">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
					<?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>

            <div class="uk-width-auto">
<!--                <div class="uk-margin">-->
<!--                    <div uk-form-custom="target: > * > span:first-child">-->
<!--                        <select v-model="form.jform_product_type">-->
<!--                            <option value="1">Physical Product</option>-->
<!--                            <option value="2">Digital Product</option>-->
<!--                        </select>-->
<!--                        <button class="uk-button uk-button-default" type="button" tabindex="-1">-->
<!--                            <span></span>-->
<!--                            <span uk-icon="icon: chevron-down"></span>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->

            </div>

        </div>
    </div>

    <div class="uk-card-body" <?php if (isset($data['showVariantsBody'])): ?>  v-show="showVariantsBody" <?php endif; ?> >

		<?php if (isset($data['field_grid_width'])): ?>
        <div class="uk-grid uk-child-width-<?= $data['field_grid_width']; ?>" uk-grid>
		<?php endif; ?>

            <div class="uk-child-width-1-1 uk-child-width-1-2@m" uk-grid>
    			<?php foreach ($data['fields'] as $field) : ?>
                    <div class="uk-margin-bottom">
    					<?php $form->setFieldAttribute($field, 'autofocus', 'p2s_product_form.' . $field, null); ?>
    					<?php echo str_replace('control-group', '', $form->renderField($field)); ?>
                    </div>
    			<?php endforeach; ?>
            </div>

            <div class="uk-child-width-1-1 uk-child-width-1-2@m" uk-grid>
                
                <div>
                    <div class="control-label">
                        <label class="uk-card-title">
                            <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_SHORT_DESCRIPTION_LABEL') ?>
                        </label>
                    </div>      
                    <div class="controls">
                        <?= $editor_field->display("jform_short_desc", $item->short_desc ?? '', '100%', '300px', 50, 10, false);?>
                    </div>
                </div>

                <div>
                    <div class="control-label">
                        <label class="uk-card-title">
                            <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_LONG_DESCRIPTION_LABEL') ?>
                        </label>
                    </div>      
                    <div class="controls">
                        <?= $editor_field->display("jform_long_desc", $item->long_desc ?? '', '100%', '300px', 50, 10, false);?>
                    </div>
                </div>

            </div>

		<?php if (isset($data['field_grid_width'])): ?>
        </div>
	    <?php endif; ?>

    </div>
    <!-- <div class="uk-card-footer"></div> -->
</div>
