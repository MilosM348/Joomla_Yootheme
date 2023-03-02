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

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

/** @var array $displayData */
$data               = $displayData;
$editor_field       = $data['editor_field'];

list(
    $fields, 
    $groups, 
    $types,
    $categoriesPath,
) = $data['custom_fields'];

?>


<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom uk-animation-fade uk-animation-fast" uk-filter="target: .custom-fields-filter-group; animation: fade">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
                    <?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>

            <div class="uk-width-auto uk-text-right">
                <a href="javascript:void(0);" uk-icon="icon: shrink"></a>
                <a hidden href="javascript:void(0);" uk-icon="icon: expand"></a>
            </div>

        </div>
    </div>

    <div class="uk-card-body uk-card-section-body">
        <?php if (isset($data['field_grid_width'])): ?>
        <div class="uk-grid uk-child-width-<?= $data['field_grid_width']; ?>">
            <?php endif; ?>

            <div class="uk-margin-bottom" uk-filter="target: .custom-fields-filter; animation: fade">

                <!-- Group Filter -->
                <?php if (count($groups)) : ?>
                <div uk-grid>
                    <div class="uk-width-1-1">
                        <ul class="uk-float-right uk-text-right uk-subnav uk-subnav-pill">

                            <!-- If more than 1 group present OR not all fields are within the group -->
                            <?php
                                $single_group = '';
                                if (count($groups) > 1 
                                    || (count($groups) == 1 && reset($groups)['countfields'] < count($fields))) : ?>

                                        <li class="uk-float-right uk-text-right uk-active" uk-filter-control="group: group">
                                            <a href="#"><?= Text::_('JALL') ?></a>
                                        </li>

                            <?php else: $single_group = 'uk-active' ?>
                            <?php endif; ?>

                            <?php foreach ($groups as $group_key => $group) : ?>
                                <li v-if="customFieldCatFilter(<?= json_encode($group['categories']) ?>)" class="uk-float-right uk-text-right <?= $single_group ?>" uk-filter-control="filter: [group='<?= $group['id'] ?>']; group: group"><a href="#"><?= $group['title'] ?></a></li>
                            <?php endforeach; ?>


                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Type Filter -->
<!--                 <div uk-grid>
                    <div class="uk-width-1-1">
                        <ul class="uk-subnav uk-subnav-pill">
                            <li class="uk-active" uk-filter-control="group: type"><a href="#"><?= Text::_('JALL') ?></a></li>
                            <?php foreach ($types as $type_key => $type) : ?>
                                <li uk-filter-control="filter: [type='<?= $type_key ?>']; group: type"><a href="#"><?= $type ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
 -->
                <ul class="custom-fields-filter custom-fields-filter-group" uk-grid uk-height-match="target: > li > .uk-card">
                    <?php 
                        // dd($fields);
                        $lightbox_containers = [];

                        $field_count = 0; foreach ($fields as $key => $field) :

                            // Gloabal Custom Field Vars
                            $custom_field       = "custom_fields[$field->key]";
                            $id                 = 'custom_fields_' . $field->key . '_' . $field->id;
                            $vue_field_name     = "'custom_fields_" . $field->key . "_' + $custom_field.name";
                            $vue_field_value    = $custom_field . ".value";
                            $vue_field_rawvalue = $custom_field . ".rawvalue";
                            $vue_field_params   = $custom_field . ".fieldparams";
                            $vue_cls_params     = $custom_field . ".clsCustomField.fieldparams";

                            $container             = "custom_fields_" . $field->key . "_usercontainer";
                            $lightbox_containers[] = $container;
                        ?>

                        <li v-if="customFieldCatFilter(<?= json_encode($field->assigned_category_ids) ?>)"
                            group="<?= $field->group_id ?? ''; ?>" type="<?= $field->type; ?>" 
                            class="type-<?= $field->type; ?> 
                            <?= ($field->type == 'subform' || $field->type == 'imagelist') 
                                ? 'uk-width-1-1' 
                                : 'uk-width-1-1 uk-width-1-2@m'; ?>"
                        >
                            <div class="uk-card uk-card-small uk-card-default uk-card-border">

                                <div class="uk-card-header">

                                    <label for="<?= $field->id; ?>" class="uk-card-title uk-margin-remove">
                                        <?= (isset($field->label) && $field->label != '') ? $field->label : $field->title; ?>
                                        <?php if ($field->required) : ?>
                                            <span class="star uk-text-danger" aria-hidden="true">&nbsp;*</span>
                                        <?php endif; ?>
                                    </label>

                                </div>

                                <div class="uk-card-body" id="field-card-body-<?= $field->id; ?>">

                                    <div id="field-card-edit-<?= $field->id; ?>" class="field-card-toggle-<?= $field->id; ?> field-edit uk-position-relative">

                                        <?= 
                                            LayoutHelper::render(
                                                'product/custom_fields', 
                                                array(
                                                    'field' => $field, 
                                                    'key'   => $field->key,
                                                    'id'    => $id,
                                                    'model' => "custom_fields[$field->key].rawvalue",

                                                    'editor_field' => $editor_field,

                                                    'field_type'     => $field->type,
                                                    'field_rawvalue' => $field->rawvalue,
                                                    'isSubField'     => $field->isSubField,
                                                    'field_name'     => $field->name,
                                                    'field_required' => $field->required,
                                                    'placeholder'    => $field->params->get('hint', ''),

                                                    'custom_field'       => $custom_field,
                                                    'vue_field_name'     => $vue_field_name,
                                                    'vue_field_value'    => $vue_field_value,
                                                    'vue_field_rawvalue' => $vue_field_rawvalue,
                                                    'vue_field_params'   => $vue_field_params,
                                                    'vue_cls_params'     => $vue_cls_params,

                                                    'container' => $container,

                                                )
                                            ); 
                                        ?>
                                    </div>

                                </div>

                                <!-- <div class="uk-card-footer uk-text-right uk-padding-remove"> -->
                                <?php if ($field->description != '') : ?>
                                    <div class="uk-card-footer uk-text-muted">

                                        <!-- DO NOT REMOVE -->
                                        <?= $field->description; ?>

                                        <!-- Edit Button -->
                                        <div class="field-card-toggle-<?= $field->id; ?>" hidden>

                                            <a uk-toggle="target: .field-card-toggle-<?= $field->id; ?>; animation: uk-animation-fade uk-animation-fast" 
                                                class="uk-button uk-button-default uk-button-small uk-margin-small-right uk-margin-small-top uk-margin-small-bottom" href="javascript:void(0);">
                                                <?= Text::_('JACTION_EDIT') ?>
                                            </a>

                                        </div>

                                        <!-- Save and Cancel -->
                                        <div class="field-card-toggle-<?= $field->id; ?>" hidden>

                                            <a uk-toggle="target: .field-card-toggle-<?= $field->id; ?>; animation: uk-animation-fade uk-animation-fast" 
                                                class="uk-button uk-button-default uk-button-small uk-margin-small-right uk-margin-small-top uk-margin-small-bottom" href="javascript:void(0);">
                                                <?= Text::_('JTOOLBAR_CANCEL') ?>
                                            </a>

                                            <a class="switch disabled uk-button uk-button-primary uk-button-small uk-margin-small-right uk-margin-small-top uk-margin-small-bottom" href="javascript:void(0);">
                                                <?= Text::_('JTOOLBAR_APPLY') ?>
                                            </a>

                                        </div>

                                    </div>
                                <?php endif; ?>

                            </div>

                        </li>
                    <?php 
                        // if ($field_count == 5)
                        //     dd($field);
                        $field_count++;  
                        endforeach; ?>
                </ul>

            </div>

            <script type="text/javascript">
                jQuery(document).ready(function() {
                    // Starts Color Picker for Subform
                    jQuery(document).find(".minicolors").each(function(index, value) {

                        // To avoid duplication of existing elements
                        if (!jQuery(value).is('input')) {
                            return;
                        }
                        jQuery(this).minicolors({
                            control: jQuery(this).attr("data-control") || "hue",
                            format: "color" === jQuery(this).attr("data-validate") ? "hex" : ("rgba" === jQuery(this).attr("data-format") ? "rgb" : jQuery(this).attr("data-format")) || "hex",
                            keywords: jQuery(this).attr("data-keywords") || "",
                            opacity: "rgba" === jQuery(this).attr("data-format"),
                            position: jQuery(this).attr("data-position") || "default",
                            swatches: jQuery(this).attr("data-colors") ? jQuery(this).attr("data-colors").split(",") : [],
                            theme: "bootstrap"
                        }).change(function() {
                            // For VueJS to capture it in v-model
                            jQuery(this)[0].dispatchEvent(new Event('input'));
                        });
                    });

                    // Make VueJS Reactive
                    jQuery('.bind-input').each(function(index, value) {
                        jQuery(value).on('change', function() {
                            jQuery(this)[0].dispatchEvent(new Event('input'));
                        });
                    });
                });
            </script>

            <?php if (isset($data['field_grid_width'])): ?>
        </div>
       <?php endif; ?>
    </div>
    <!-- <div class="uk-card-footer"></div> -->
</div>


<div id="user_lghtbx_containers">
    <?php foreach($lightbox_containers  as $container_id) : ?>
        <div id="<?= $container_id ?>"></div>
    <?php endforeach; ?>
</div>

<script>
// self executing function here
(function() {
   // your page initialization code here
   // the DOM will be available here

})();
</script>