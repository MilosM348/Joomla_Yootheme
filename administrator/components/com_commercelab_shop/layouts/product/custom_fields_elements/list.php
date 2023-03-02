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



/** @var array $displayData */
$data     = $displayData;
$model    = $data['model']; // Index of field, depends of order set in Joomla Custom Fields
$name     = $data['name'];
$multiple = $data['multiple'];
$options  = $data['options'];

?>

    <div class="uk-form-controls">
        <div class="uk-margin">
            <select class="uk-select" 
                v-model="<?= $model ?>" 
                :multiple="<?= $multiple ?>"
                :id="<?= $name ?>" 
                :name="<?= $name ?>">
                    <option 
                        v-for="(option, optionindex) in <?= $options ?>"
                        :key="option.value"
                        :value="option.value"
                    >
                        {{option.name}}
                </option>
            </select>
        </div>
    </div>
