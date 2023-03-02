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
use Joomla\CMS\Factory;



/** @var array $displayData */
$data  = $displayData;
$model = $data['model']; // Index of field, depends of order set in Joomla Custom Fields
$name  = $data['name'];
$value = $data['value'];
$key   = $data['key'];

$isSubField = $data['isSubField'];

$unique_id = uniqid('minicolors');

?>

    <?php
        if (JVERSION >= "4.0.0") {
            $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
            $wa->usePreset('minicolors')->useScript('field.color-adv');
        } else {
            JHtml::_('jquery.framework');
            JHtml::_('script', 'system/html5fallback.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));
            JHtml::_('script', 'jui/jquery.minicolors.min.js', array('version' => 'auto', 'relative' => true));
            JHtml::_('stylesheet', 'jui/jquery.minicolors.css', array('version' => 'auto', 'relative' => true));
            JHtml::_('script', 'system/color-field-adv-init.min.js', array('version' => 'auto', 'relative' => true));
        }

    ?>

    <input 
        class="uk-input minicolors" 
        style="text-indent: 40px;" 
        :value="<?= $value ?>"
        type="text" 
        id="<?= $unique_id ?>_original"
        :name="<?= $name ?>"
        v-model="<?= $model ?>"
    >
