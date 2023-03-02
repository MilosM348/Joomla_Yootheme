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
$data  = $displayData;
$name  = $data['id']; // Joomla Custom Field ID
$id    = $data['id']; // Joomla Custom Field ID
$model = $data['model']; // Index of field, depends of order set in Joomla Custom Fields
$rows  = $data['rows'];

?>

    <textarea 
        :name="<?= $name; ?>" 
        :id="<?= $id; ?>" 
        v-model="<?= $model; ?>"
        class="uk-textarea"
        :rows="<?= $rows ?>"
    >
    </textarea>
