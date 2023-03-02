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
use Joomla\CMS\Uri\Uri;


/** @var array $displayData */
$data         = $displayData;
$name         = $data['name'];
$id           = $data['id'];
$model        = $data['model'];
$custom_field = $data['custom_field'];

?>

    <?php HTMLHelper::_('script', Uri::root() . 'administrator/components/com_commercelab_shop/layouts/product/custom_fields_elements/location.js'); ?>
    <yootheme-field-location>
        <input
            type="hidden" 
            class="bind-input" 
            :id="<?= $id; ?>" 
            :name="<?= $name; ?>" 
            :value="<?= $model; ?>"
        />
    </yootheme-field-location>