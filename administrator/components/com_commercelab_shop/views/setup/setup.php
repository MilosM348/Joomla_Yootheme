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

/** @var array $vars */

?>


<div id="p2s_setup">
    <form @submit.prevent="submitSetup">
        <div class="uk-margin-left">
            <div class="uk-grid" uk-grid="">

                <div class="uk-width-1-1 uk-animation-fade">

                    <div class="uk-card uk-card-default">

                        <div class="uk-card-body">

                            <div class="uk-margin">
                                <div class="uk-alert-primary" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
									<span class="uk-text-large"><?= Text::_('COM_COMMERCELAB_SHOP_SETUP_INFO'); ?></span>
                                </div>

                            </div>


							<?= LayoutHelper::render('setup/shop'); ?>
							<?= LayoutHelper::render('setup/currency'); ?>
							<?= LayoutHelper::render('setup/country'); ?>

                        </div>
                        <div class="uk-card-footer">
                            <div class="uk-text-center">
                                <button class="uk-button uk-button-large uk-button-primary confirm-setup"
                                        type="submit"><?= Text::_('COM_COMMERCELAB_SHOP_SETUP_DONE_GET_STARTED'); ?></button>
                            </div>
                        </div>
                    </div>

                    <div id="first-time-intro-video-modal" class="uk-flex-top uk-modal uk-modal-container" uk-modal="bg-close: false">
                        <div class="uk-modal-dialog uk-width-auto uk-height-full uk-margin-auto-vertical" style="width: 550px; max-width:550px;">

                            <video id="first_time_intro_video" src="components/com_commercelab_shop/firsttimeintro/cls_welcome.mp4" width="1920" height="1080" automute uk-video playsinline autoplay></video>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </form>
</div>
