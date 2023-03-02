<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

?>

    <div v-if="!isGuestCheckout">
        <span style=" width: 20px; height: 20px;" uk-spinner></span>
    </div>

    <div v-if="isGuestCheckout">
        <?= $guestcheckout_message($props, $attrs) ?>
            <?= $props['guestcheckout_message']; ?>
        <?= $guestcheckout_message->end(); ?>
    </div>
