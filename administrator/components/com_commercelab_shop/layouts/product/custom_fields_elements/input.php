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


/** @var array $displayData */
$data        = $displayData;
$model       = $data['model']; // Index of field, depends of order set in Joomla Custom Fields
$name        = $data['name'];
$id          = $data['id'];
$type        = $data['type'];
$required    = $data['required'];
$step        = $data['step'];
$maxlength   = $data['maxlength'];
$placeholder = $data['placeholder'];
$isSubField  = $data['isSubField'];

?>
    <input
        <?php if ($isSubField) : ?>
            :placeholder="<?= $placeholder ?>"
        <?php else : ?>
            placeholder="<?= $placeholder ?>"
        <?php endif; ?>
        class="uk-input"
        :id="<?= $id ?>" 
        :required="(<?= $required; ?> == 1) ? true : false" 
        :name="<?= $name ?>"
        :type="<?= $type ?>"
        v-model="<?= $model ?>"
        :step="<?= $step ?>"
        :maxlength="<?= $maxlength ?>"
    />