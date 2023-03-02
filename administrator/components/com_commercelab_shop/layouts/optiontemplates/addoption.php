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

$data  = $displayData;
$order = $data['items'];

?>

<form>

    <div class="el-content uk-panel">
        <div class="uk-margin" >
            <label for="option-template-variant-name"><?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_OPTION_NAME'); ?><span>*</span></label>
            <input type="text" id="option-template-option-name" name="option_template_option_name" class="uk-input" v-model="option_name"
                placeholder="<?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_OPTION_PLACEHOLDER'); ?>">
        </div>
    </div>

    <div class="uk-margin-top uk-text-right">
        <button @click="saveTemplateOptions" :disabled='isDisabled' class="uk-button uk-button-primary uk-margin-small-left" type="button">
            <?= Text::_('COM_COMMERCELAB_SHOP_BUTTON_SAVE'); ?>        
        </button>
    </div>
</form>
  