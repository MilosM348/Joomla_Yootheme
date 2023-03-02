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

    <div class="uk-card-body uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover uk-table-large">
            <thead>
            <tr>
                <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_EMAIL_TYPE'); ?></th>
                <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_EMAIL_DATE'); ?></th>
                <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_EMAIL_SENT_BY'); ?></th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="log in order.emailLogs">
                <td>{{log.emailtype}}</td>
                <td>{{log.sentdate}}</td>
                <td>{{log.created_by_name}}</td>
            </tr>

            </tbody>
        </table>

    </div>


    <!-- <div class="uk-card-footer"></div> -->
</div>
