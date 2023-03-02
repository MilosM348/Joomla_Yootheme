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
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Factory;

/** @var array $displayData */
$data         = $displayData;
$custom_field = $data['custom_field']; 
$field        = $data['field']; 
$key          = $data['key']; 
$mainid       = $data['id']; 
$editor_field = $data['editor_field'];

$vue_subform_rows       = 'custom_fields[' . $key . '].subform_rows';
$vue_subform_ghost_rows = 'custom_fields[' . $key . '].ghost_fields';

?>  
<br>

    <div class="uk-card">
        <div v-if="Object.keys(<?= $vue_subform_ghost_rows ?>).length < 4 && Object.keys(<?= $vue_subform_rows ?>).length > 0" class="uk-card-header">
            <div :class="'uk-child-width-1-1 uk-child-width-1-' + Object.keys(<?= $vue_subform_ghost_rows ?>).length + '@s'" uk-grid>
                <div v-for="(subFields, key) in Object.values(<?= $vue_subform_rows ?>)[0]">
                    <label v-if="Object.values(<?= $vue_subform_rows ?>)[0][key].label && Object.values(<?= $vue_subform_rows ?>)[0][key].titllabel != ''" class="uk-card-title uk-margin-remove">{{ Object.values(<?= $vue_subform_rows ?>)[0][key].label }}</label>
                    <label v-else class="uk-card-title uk-margin-remove">{{ Object.values(<?= $vue_subform_rows ?>)[0][key].title }}</label>
                </div>
            </div>
        </div>

        <div class="uk-card-body sortable_list">

            <!-- No Subform Rows -->
            <div v-if="!Object.values(<?= $vue_subform_rows ?>).length">
                <div class="uk-text-right">
                    <a 
                        @click="<?= $vue_subform_rows ?>.push(deepObjectCopy(<?= $vue_subform_ghost_rows ?>))"
                        class="uk-button uk-button-primary uk-button-small"><?= Text::_('COM_COMMERCELAB_SHOP_ADD_FIRST_SUBFORM') ?></a>
                </div>
            </div>
            
            <!-- Subfrom Row Render -->
            <div id="subform_<?= $mainid ?>" v-for="(subFields, row_index, field_row_index) in <?= $vue_subform_rows ?>" class="uk-position-relative uk-animation-fade uk-animation-fast uk-child-width-1-1"
                :class="[(Object.keys(subFields).length <= 4)  ? 'uk-child-width-1-' + Object.keys(subFields).length + '@s' : 'uk-child-width-1-3@s']" uk-grid uk-height-match="target: > div">
                <!-- {{ subFields }} -->
                <!-- Fields Render -->
                <div v-for="(subField, subField_row, subField_index) in subFields" class="uk-margin-remove">

                    <div v-if="Object.keys(subFields).length > 4" class="uk-margin-top">
                        <label class="uk-card-title uk-margin-remove">{{ subField.title }}</label>
                    </div>

                    <?php 
                        $vue_row_index       = "row_index";
                        $vue_sub_field       = "subField";
                        $vue_sub_field_index = "subField_index";
                        $vue_sub_field_row   = "subField_row";
                        $vue_field_value     = $vue_sub_field . ".value";
                        $vue_cls_params      = $vue_sub_field . ".clsCustomField.fieldparams";
                        $vue_field_params    = $vue_sub_field . ".fieldparams";
                        // reactive Values
                        $vue_field_rawvalue = $vue_sub_field . ".rawvalue";

                        // With Row Index - unique names
                        $vue_field_name = "'custom_fields_" . $key . "' + '_' + row_index + '_' + subField.name";
                        $id             = "'custom_fields_" . $key . "' + '_' + row_index + '_' + subField.id";
                        $container      = $vue_field_name . " + '_' + 'container'";


                        $lightbox_containers[] = $container;

                    ?>

                    <?=
                        // 'Sub Field'
                        LayoutHelper::render(
                            'product/custom_fields_subform', 
                            array(
                                'field'              => $vue_sub_field, 
                                'key'                => $key,
                                'id'                 => $id,
                                'field_type'         => $vue_sub_field . ".type",
                                'field_rawvalue'     => $vue_field_rawvalue,
                                'isSubField'         => $vue_sub_field . ".isSubField",
                                'field_name'         => $vue_sub_field . ".name",
                                'field_required'     => $vue_sub_field . ".required",
                                'model'              => $vue_field_rawvalue,
                                'custom_field'       => $vue_sub_field,

                                'container'          => $container,
                                'vue_row_index'      => $vue_row_index,
                                'vue_field_name'     => $vue_field_name,
                                'vue_field_value'    => $vue_field_value,
                                'vue_field_rawvalue' => $vue_field_rawvalue,
                                'vue_field_params'   => $vue_field_params,
                                'vue_cls_params'     => $vue_cls_params,
                            )
                        ); 
                    ?>

                </div>

                <div v-if="<?= $vue_subform_rows; ?>_locked == false" 
                    class="ghost-cover uk-position-absolute uk-width-1-1 uk-height-1-1 uk-display-block uk-position-top uk-position-left"
                    >
                    <div class="uk-width-1-1 uk-height-1-1 uk-display-block">

                        <!-- Ghost Cover -->
                        <div style="display: none;" class="ghost-cover-controls">

                            <!-- <div v-if="!subformRow.dropbox"> -->
                            <div v-if="true">
                                <div class="uk-width-1-5 uk-height-1-1 uk-float-left uk-text-left">
                                    <span class="h1 uk-text-large uk-text-bolder uk-margin-top uk-margin-left">
                                        <span class="subform_index">{{ row_index + 1 }}</span>
                                    </span>
                                </div>
                                <div class="uk-width-1-5 uk-height-1-1 uk-float-right uk-text-right">
                                    <a 
                                        @click="<?= $vue_subform_rows; ?>_locked = (Object.keys(<?= $vue_subform_rows; ?>).length == 1) ? true : <?= $vue_subform_rows; ?>_locked , <?= $vue_subform_rows; ?>.splice(row_index, 1)" 
                                        class="uk-margin-small-right uk-margin-small-top" 
                                        uk-icon="icon: trash">
                                    </a>
                                </div>
                            </div>
                            <div v-else class="uk-width-1-1"></div>
                        </div>
                    </div>
                </div>

            <!-- End Of Row -->
            </div>

        </div>

        <div
            v-if="Object.values(<?= $vue_subform_rows ?>).length"
            class="uk-card-footer uk-text-right">
            <a 
                :class="[(Object.keys(<?= $vue_subform_rows ?>).length == 0) ? 'uk-disabled' : '']" 
                id="lock_icon<?= $mainid ?>"
                @click="<?= $vue_subform_rows; ?>_locked = !<?= $vue_subform_rows; ?>_locked" 
                :uk-icon="(<?= $vue_subform_rows; ?>_locked && Object.keys(<?= $vue_subform_rows ?>).length != 0) ? 'icon: lock' : ((Object.keys(<?= $vue_subform_rows ?>).length != 0) ? 'icon: unlock' : 'icon: lock')" class="uk-margin-right">
            </a>

            <!-- Add Items -->
            <!-- {{ <?= $vue_subform_ghost_rows ?> }} -->
            <a 
                id="add_fields<?= $mainid ?>"
                :class="[(!<?= $vue_subform_rows; ?>_locked && Object.keys(<?= $vue_subform_rows ?>).length != 0) ? 'uk-disabled' : '']" 
                @click="<?= $vue_subform_rows ?>.push(deepObjectCopy(<?= $vue_subform_ghost_rows ?>))"
                uk-icon="icon: plus-circle"
                onclick="triggerEvents()">
            </a>
        </div>

        <script type="text/javascript">

            jQuery(document).ready(function() {
                if (typeof tinymce !== "undefined") {
                    const editors = document.getElementsByClassName('vue-load-editor');
                    for (var i = 0; i < editors.length; i++) {   
                        tinymce.init({
                            selector: 'textarea#' + editors[i].id
                        });
                    }
                }
            });

            function triggerEvents() {

                // Subforms Wrapper
                const subFormWrapper = document.getElementById('subform_<?= $mainid ?>');

                // Recreate Editors
                if (typeof tinymce !== "undefined") {
                    const editors = document.getElementsByClassName('vue-load-editor');
                    for (var i = 0; i < editors.length; i++) {   
                        tinymce.init({
                            selector: 'textarea#' + editors[i].id
                        });
                    }
                }

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


                //  User Modal
                jQuery(document).find(".user_subform", subFormWrapper).each(function(index, value) {

                    var container_id = jQuery(value).attr('id').replace('_wrapper', '');

                    // Move lightbox to a diferent location
                    var source = document.getElementById(container_id);
                    document.getElementById("user_lghtbx_containers").appendChild(source);

                    UIkit.util.on(document, 'itemshow', "#" + container_id, function (element) {

                        const iframe = document.getElementById(container_id).querySelector('iframe');
                        iframe.addEventListener("load", function() {
                            const userNames   = this.contentWindow.document.getElementsByClassName("pointer");
                            const noUserNames = this.contentWindow.document.getElementsByClassName("btn-primary button-select");
                            noUserNames[0].addEventListener('click', function(eventObj) {

                                document.getElementById(container_id + "_username").value = '<?= Text::_('JLIB_FORM_SELECT_USER') ?>';
                                document.getElementById(container_id + "_userid").value = 0;

                                jQuery("#" + container_id + "_username")[0].dispatchEvent(new Event('input'));
                                jQuery("#" + container_id + "_userid")[0].dispatchEvent(new Event('input'));

                                UIkit.lightbox("#" + container_id + "_trigger").hide();

                            });

                            for (var i = 0; i < userNames.length; i++) {
                                userNames[i].addEventListener('click', function(eventObj) {

                                    const userDataSet = eventObj.target.dataset;

                                    document.getElementById(container_id + "_username").value = userDataSet.userName;
                                    document.getElementById(container_id + "_userid").value = userDataSet.userValue;

                                    jQuery("#" + container_id + "_username")[0].dispatchEvent(new Event('input'));
                                    jQuery("#" + container_id + "_userid")[0].dispatchEvent(new Event('input'));

                                    UIkit.lightbox("#" + container_id + "_trigger").hide();
                                });
                            }
                        });

                    });

                });

                // // Make VueJS Reactive
                // jQuery('.bind-input-subform').each(function(index, value) {
                //     jQuery(value).on('change', function() {
                //         console.log('change');
                //         jQuery(this)[0].dispatchEvent(new Event('input'));
                //     });
                // });
            }

        </script>

    </div>


<!-- Duplicate -->
<!--                                     <a 
    @click="copyCustomSubformRow(<?= $key; ?>, <?= $vue_subform_rows; ?>[rowIndex])" 
    class="uk-margin-right uk-margin-top" 
    uk-icon="icon: copy">
</a> -->
<!-- Drag and Drop -->
<!-- <a 
    @click="moveCustomSubformRow(<?= $vue_subform_rows; ?>[rowIndex])" 
    class="uk-margin-right uk-margin-top" 
    uk-icon="icon: move">
</a> -->
<!-- Delete -->

