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

        <p-timeline :value="order.logs">

            <template #opposite="slotProps" class="uk-margin-medium-bottom">
                <small class="p-text-secondary">{{slotProps.item.created}}</small>
            </template>
            <template #content="slotProps">
              {{slotProps.item.note}}
            </template>

        </p-timeline>
    </div>


    <!-- <div class="uk-card-footer"></div> -->
</div>
