<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

 use Joomla\CMS\Language\Text;
 
defined('_JEXEC') or die;

$id = uniqid('cls_shop_picker');

$days      = cal_days_in_month(CAL_GREGORIAN, idate("m"), idate("y"));
$a         = 1;
$month_day = idate("d");

$week_days = [
    Text::_('Monday'),
    Text::_('Tuesday'),
    Text::_('Wednesday'),
    Text::_('Thursday'),
    Text::_('Friday'),
    Text::_('Saturday'),
    Text::_('Sunday')
];

?>

<div id="<?= $id; ?>" v-if="item.product.pickupoptions && item.product.pickupoptions.length" class="uk-margin">
        
    <button :uk-toggle="'target: #pickup_options_' + item.id"  class="uk-button uk-button-small uk-button-default">
        <span uk-icon="icon: location"></span>
        <span class="uk-margin-small-left">
            Pickup Options
        </span>
    </button>
    <div :id="'pickup_options_' + item.id" class="uk-modal-full uk-height-full" uk-modal>
        <div class="uk-modal-dialog uk-modal-body0" uk-height-viewport="offset-top: true">

            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>

            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Select available timeslot from existing shops</h2>
            </div>
            <div class="uk-modal-body">
                <div class="uk-grid-divider uk-grid-small" uk-grid>
                    
                    <div class="uk-width-auto@m">
                        <ul class="uk-list uk-list-divider" uk-switcher="connect: #shops-tab; animation: uk-animation-fade">

                            <li v-for="shop in item.product.pickupoptions">
                                <a href="#" class="hover-tab">
                                    <h4 class="uk-width-1-1 uk-h4 uk-margin-remove">{{shop.title}}</h4>
                                    <div class="uk-width-1-1">{{shop.address}}, {{shop.city}}, {{shop.postalcode}}, {{shop.zone}}, {{shop.country}}</div>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="uk-width-expand@m">
                        <ul id="shops-tab" class="uk-switcher">
                            <li v-for="shop in item.product.pickupoptions">

                                <div class="uk-grid-collapse uk-grid-divider" uk-grid>
                                    <?php foreach ($week_days as $day_index => $week_day) : ?>
                                        <div style="
                                            width: 14.285714285714286%; 
                                        " 
                                        class="
                                            uk-text-center uk-text-capitalize
                                        ">
                                            <?= $week_day ?>

                                            <hr class="uk-divider-vertical uk-position-right">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <hr>

                                <div class="uk-grid-collapse uk-grid-divider" uk-grid>

                                    <?php while ($a <= $days) : ?>
                                        <div style="
                                            width: 14.285714285714286%; 
                                        " class="
                                            uk-position-relative uk-height-small
                                            <?= ($month_day > $a) ? 'uk-background-muted' : '' ?>
                                        ">
                                            <div>
                                                <?= $a ?>
                                            </div>
                                            <?php if ($month_day > $a) : ?>
                                                
                                            <?php else : ?>

                                            <?php endif; ?>
                                            
                                        </div>
                                    <?php $a++; endwhile; ?>

                                </div>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
