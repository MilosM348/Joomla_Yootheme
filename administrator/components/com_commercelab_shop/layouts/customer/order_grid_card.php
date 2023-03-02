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


        <table
                class="uk-table uk-table-striped uk-table-hover uk-table-responsive">
            <thead></thead>
            <thead>
            <tr>
                <th> Order Number</th>

                <th> Customer</th>
                <th> Status</th>
                <th> Date</th>
                <th> Total</th>
            </tr>
            </thead>

            <tbody class="uk-animation-fade uk-animation-fast">

                <tr v-for="order in form.jform_orders.items">
                    <td>
                        <div class="name">
                            <a :href="'index.php?option=com_commercelab_shop&view=order&id=' + order.id">
                                {{order.order_number}}
                            </a>
                        </div>
                    </td>

                    <td v-if="order.customer_name && order.customer_name != ''">
                        {{ order.customer_name }}
                    </td>

                    <td v-else-if="order.billing_address.first_name && order.billing_address.first_name != ''">
                        {{ order.billing_address.first_name }} {{ order.billing_address.last_name }} (Guest)
                    </td>

                    <td v-else-if="order.shipping_address.first_name && order.shipping_address.first_name != ''">
                        {{ order.shipping_address.first_name }} {{ order.shipping_address.last_name }} (Guest)
                    </td>

                    <td v-else>
                        Guest
                    </td>


                    <td>
                        <span :class="'uk-label uk-label-'+ order.order_status.toLowerCase()"> 
                            {{order.order_status_formatted}}
                        </span></td>
                    <td> {{order.order_date}}</td>
                    <td> {{order.order_total_formatted}}</td>
                </tr>
            </tbody>
        </table>


    </div>
    <!-- <div class="uk-card-footer"></div> -->
</div>
