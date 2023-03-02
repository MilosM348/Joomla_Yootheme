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



/** @var array $displayData */
$data  = $displayData;
$model = $data['model']; // Index of field, depends of order set in Joomla Custom Fields
$name  = $data['name'];

// date('Y-m-d\TH:i') - TODO Default Value NOW

?>

    <input type="datetime-local" :name="<?= $name ?>" :id="<?= $name ?>" v-model="<?= $model ?>" value="" min="2020-01-01">
