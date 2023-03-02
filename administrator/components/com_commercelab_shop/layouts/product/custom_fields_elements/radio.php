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
$options  = $data['options'];

?>

    <div class="uk-margin uk-margin-small-top uk-grid-small uk-child-width-auto uk-grid">

        <label v-for="(option, optionindex) in <?= $options ?>" class="uk-margin-right">
            <input 
                class="uk-radio" 
                type="radio" 
                :value="option.value" 
                v-model="<?= $model ?>">
                    <span class="uk-margin-small-left">{{ option.name }}</span>
        </label>

    </div>