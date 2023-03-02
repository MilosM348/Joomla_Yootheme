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

$data = $displayData;
$form = $data['form'];

?>

<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom uk-animation-fade uk-animation-fast">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-auto@s">
                <h3>
					<?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>
            <div class="uk-width-expand@s">
                <div>
                    <div class="uk-flex uk-flex-right" uk-grid>
                        
                        <div>
                            <button class="uk-button uk-button-small uk-button-success" type="button" @click="addOption()">
                                <span uk-icon="plus-circle"></span>
                                <?= Text::_('COM_COMMERCELAB_SHOP_ADD_PRODUCT_OPTIONS_ADD_BUTTON'); ?>
                            </button>
                        </div>

                        <div>
                            <button class="uk-button uk-button-small uk-button-success" type="button" @click="selectCheckboxOptionTemplate()">
                                <span uk-icon="plus-circle"></span>
                                <?= Text::_('COM_COMMERCELAB_SHOP_OPTIONS_TEMPLATES_SELECT'); ?>
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="uk-card-body" >
	    <?= LayoutHelper::render('product/options', ''); ?>
    </div>
</div>
