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

$data = $displayData;

?>

<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom uk-animation-fade uk-animation-fast">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
					<?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>
        </div>
    </div>


    <div class="uk-card-body">

        <table class="uk-table uk-table-hover uk-table-divider">
            <thead>
            <tr>
                <th>Number</th>
                <th>Total</th>
                <th>Payment Type</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="order in form.jform_orders">
                <td><a :href="'index.php?option=com_commercelab_shop&view=order&id=' + order.id">{{order.order_number}}</a></td>
                <td>{{order.order_total_formatted}}</td>
                <td>{{order.payment_method}}</td>
                <td>
                    <div :class="'uk-label uk-label-'+ order.order_status.toLowerCase()">
                        {{order.order_status_formatted}}
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
    </div>

    <!-- <div class="uk-card-footer"></div> -->
</div>
