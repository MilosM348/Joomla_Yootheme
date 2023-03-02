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
use Joomla\CMS\Editor\Editor;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

/** @var array $displayData */
$data               = $displayData;
// $field        = $data['field'];

$field          = $data['field'];
$field_type     = $data['field_type'];
$isSubField     = $data['isSubField'];
$field_name     = $data['field_name'];
$field_required = $data['field_required'];

$key            = $data['key'];
$id             = $data['id'];
$placeholder    = $data['placeholder'];
$model          = $data['model'];
$editor_field   = JEditor::getInstance(Factory::getApplication()->get('editor'));
$field_rawvalue = $data['field_rawvalue'];

$custom_field       = $data['custom_field'];
$vue_field_name     = $data['vue_field_name'];
$vue_field_value    = $data['vue_field_value'];
$vue_field_rawvalue = $data['vue_field_rawvalue'];
$vue_field_params   = $data['vue_field_params'];
$vue_cls_params     = $data['vue_cls_params'];

$container = $data['container'];

?>

    <?php if ($field_type === 'imagelist') : ?>
        <!-- Image List -->
        <div class="uk-panel-scrollable" style="height: 250px">
            <?= 
                LayoutHelper::render(
                    'product/custom_fields_elements/' . $field_type, 
                    array(
                        'isSubField' => $isSubField,
                        'key'        => $key,
                        'model'      => $model,
                        'name'       => $vue_field_name,
                        'options'    => $vue_cls_params . '.options',
                        'directory'  => $vue_cls_params . '.directory',
                        'multiple'   => $vue_cls_params . '.multiple == 1',
                    )
                ); 
            ?>
        </div>
    <?php endif; ?>

    <?php if ($field_type === 'media') : ?>
        <!-- Media -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'         => $key,
                    'model'       => $model,
                    'id'          => $id,
                    'idStringify' => true,
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'location') : ?>
        <!-- Location -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'          => $key,
                    'name'         => $vue_field_name,
                    'id'           => "'$id'",
                    'model'        => $model,
                    'custom_field' => $custom_field,
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'editor') : ?>
        <!-- editor -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'field_rawvalue' => $field_rawvalue,
                    'model'          => $model,
                    'key'            => $key,
                    'id'             => $id,
                    'editor_field'   => $editor_field,
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'textarea') : ?>
        <!--Textarea -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'   => $key,
                    'id'    => $id,
                    'model' => $model,
                    'rows'  => $vue_field_params . '.rows',
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'list') : ?>
        <!-- List -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'      => $key,
                    'model'    => $model,
                    'name'     => $vue_field_name,
                    'multiple' => $vue_cls_params . '.multiple == 1',
                    'options'  => $vue_field_params . '.options',
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'color') : ?>
        <!-- Color Picker -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'        => $key,
                    'model'      => $model,
                    'value'      => $vue_field_rawvalue,
                    'name'       => $vue_field_name,
                    'isSubField' => $isSubField,

                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'user') : ?>
        <!-- User -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'required'  => $field_required, 
                    'name'      => $vue_field_name,
                    'value'     => $vue_field_value,
                    'rawvalue'  => $model,
                    'container' => $container,
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'radio') : ?>
        <!-- Radio -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'     => $key,
                    'name'    => $vue_field_name,
                    'model'   => $model,
                    'options' => $vue_field_params . '.options',
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'checkboxes') : ?>
        <!-- Checkboxes -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'     => $key,
                    'name'    => $vue_field_name,
                    'model'   => $model,
                    'options' => $vue_field_params . '.options',
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'calendar') : ?>
        <!-- Calendar -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/' . $field_type, 
                array(
                    'key'     => $key,
                    'name'    => $vue_field_name,
                    'model'   => $model,
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if ($field_type === 'text' || $field_type === 'number' || $field_type === 'tel' || $field_type === 'float' || $field_type === 'url') : ?>
        <!-- TEXT OR NUMBER -->
        <?= 
            LayoutHelper::render(
                'product/custom_fields_elements/input', 
                array(
                    'required'    => $field_required, 
                    'type'        => $field_type, 
                    'placeholder' => $placeholder, 
                    'key'         => $key,
                    'id'          => "'$id'",
                    'name'        => $vue_field_name,
                    'model'       => $model,
                    'isSubField'  => false,
                    'step'        => $vue_field_params . ".filter == 'float' ? '0.01' : false",
                    'maxlength'   => $vue_field_params . '.maxlength',
                    'options'     => $vue_field_params . '.options',
                )
            ); 
        ?>
    <?php endif; ?>

    <?php if (!$isSubField) : ?>
        <?php if ($field->type === 'repeatable' || $field->type === 'subform') : ?>
            <!-- Repeatable -->
            <?= 
                LayoutHelper::render('product/custom_fields_elements/subform', array(
                    'custom_field' => $custom_field, 
                    'field'        => $field, 
                    'model'        => $model, 
                    'key'          => $key,
                    'id'           => $id,
                    'editor_field' => $editor_field,
                )); 
            ?>
        <?php endif; ?>
    <?php endif; ?>