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
$data         = $displayData;
$key          = $data['key']; // Index of field, depends of order set in Joomla Custom Fields
$id           = $data['id']; // Index of field, depends of order set in Joomla Custom Fields
$model        = $data['model']; // Index of field, depends of order set in Joomla Custom Fields
$idStringify  = $data['idStringify']; // Index of field, depends of order set in Joomla Custom Fields
$thumb_height = '300px';

?>

<?= 
    LayoutHelper::render('product/media', array(
        'id'           => $id, 
        'model'        => $model,
        'thumb_height' => $thumb_height,
        'idStringify'  => $idStringify,

    )); 
?>
