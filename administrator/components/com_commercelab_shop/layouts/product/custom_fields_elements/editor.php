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
$data           = $displayData;
$field_rawvalue = $data['field_rawvalue'];
$model          = $data['model'];
$field_rawvalue = $data['field_rawvalue'];
$editor_field   = $data['editor_field'];
$id             = $data['id'];

?>

<?= $editor_field->display($id, $field_rawvalue, '100%', '300px', 50, 10, false); ?>

