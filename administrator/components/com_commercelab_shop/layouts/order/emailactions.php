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
$order = $data['item'];

?>


<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
					<?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>
            <div class="uk-width-auto">

            </div>

        </div>
    </div>

    <div class="uk-card-body">
        <button @click="sendEmail('thankyou')" type="button" class="uk-button uk-button-small uk-button-primary">
			<?= Text::_('COM_COMMERCELAB_SHOP_ORDER_SEND_THANK_YOU_EMAIL'); ?>
             <i class="fal fa-thumbs-up"></i>
        </button>
    </div>


    <!-- <div class="uk-card-footer"></div> -->
</div>
