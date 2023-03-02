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
use Joomla\CMS\Editor\Editor;



/** @var array $displayData */
$data  = $displayData;
$model = $data['model'];
$id    = $data['id'];

?>

<textarea class="vue-load-editor" v-model="<?= $model ?>" :id="<?= $id ?>">{{ <?= $model ?> }}</textarea>

