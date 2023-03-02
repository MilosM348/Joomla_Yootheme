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
use Joomla\CMS\HTML\HTMLHelper;

// JFactory::getDocument()->addStyleDeclaration('.admin.com_commercelab_shop.introactive { opacity: 0; }');

HTMLHelper::_('jquery.framework');

$domain         = $_SERVER['HTTP_HOST'];
$domainhostname = gethostbyname($_SERVER['HTTP_HOST']);
$ip             = file_get_contents('https://api.ipify.org');
$localhost      = (str_starts_with($domainhostname, '127.0.0.1') || str_starts_with($domainhostname, 'localhost')) ? '1' : '0';

?>

<div class="intro-cover uk-position-fixed"></div>

<div id="first-time-intro" class="uk-flex-top uk-modal uk-modal-container" uk-modal="bg-close: false">
    <div class="uk-modal-dialog uk-width-auto uk-height-full uk-margin-auto-vertical">

        <a href="index.php" class="uk-position-absolute" uk-icon="icon: sign-out; ratio 1.3" style="top: 10px; right: 10px;">
            Exit
        </a>

        <div class="uk-modal-body uk-text-center uk-animation-slide-bottom uk-margin-auto">            

            <img src="components/com_commercelab_shop/firsttimeintro/header-logo.png" />

            <div class="uk-margin-small">
                <?= base64_decode(json_decode(file_get_contents('https://app.commercelab.shop/index.php?option=com_ajax&plugin=getsetupmessage&format=json'), true)['data'][0]); ?>
            </div>


            <!-- <p><?= Text::_('COM_COMMERCELAB_SHOP_FIRSTTIMEINTRO_MSG'); ?></p> -->

            <!-- 
            <p class="social uk-flex uk-flex-center">
                <a href="https://twitter.com/CommerceLab_" target="_blank" uk-icon="icon:twitter; ratio: 2" class="uk-icon uk-margin-left uk-margin-right"></a>
                <a href="https://www.facebook.com/ThisisCommerceLab/" target="_blank" uk-icon="icon:facebook; ratio: 2" class="uk-icon uk-margin-left uk-margin-right"></a>
                <a href="https://discord.gg/dVGMu9rtAV" target="_blank" uk-icon="icon:discord; ratio: 2" class="uk-icon uk-margin-left uk-margin-right"></a>
            </p> 
            -->

            <!-- Validation Detaiñls -->
            <div>
                <a class="see-validation-details" href="javascript:void(0);">See validation details</a>
                <div class="validation-details" style="display: none;">
                    Domain: <?= $domain; ?> <br />
                    Host: <?=  $domainhostname; ?> <br />
                    IP: <?=  $ip; ?> <br />    
                </div>
            </div>

            <div class="uk-grid-collapse" uk-grid>

                <div class="uk-width-expand">
                    <input placeholder="Watchful Key" type="text" name="watchful_key" id="watchful_key" class="uk-input" style="background: #cbcbcb; border-radius: 10px 0 0 10px;">
                </div>

                <div class="uk-width-auto">
                    <button class="Validate_button uk-button uk-button-small uk-button-danger" style="height: 40px; border-radius: 0 10px 10px 0;">
                        <span class="watchful_validating_spinner" style="width: 20px; height: 20px;" uk-spinner></span>
                        <span class="watchful_validating_check" uk-icon="icon: check" style="display: none;"></span>
                        <span class="watchful_validating_locked" style="display: none;">
                            Validate
                        </span>
                    </button>
                </div>
                <div class="watchful_key_alert uk-width-1-1"></div>

            </div>

            <!--             
            <p class="uk-margin-top">
                <button class="uk-button uk-button-primary uk-button-large" type="button">
                    <?= Text::_('COM_COMMERCELAB_SHOP_FIRSTTIMEINTRO_BUTTON'); ?>
                </button>
            </p> 
            -->

        </div>
    </div>
</div>


<style>
    body.inmove {
        width: 100%;
        height: 100%;
        overflow: hidden;
        position: relative;
    }
    .intro-cover {
        background: #ffffff;
        z-index: 10000000;
        display: block;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    #first-time-intro {
        background: #ffffff;
        z-index: 100000000;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: -17px;
        overflow-y: scroll;
    }
    #first-time-intro .social a:before {
        content:  "";
    }
    .uk-modal-body {
        max-width: 650px;
    }
</style>

<script type="text/javascript">
    jQuery( window ).ready(function($) {

        $('.watchful_validating_spinner').hide();
        $('.watchful_validating_locked').show();
        
        $('.see-validation-details').click(function() {
            $('.validation-details').toggle();
        });
    });

    jQuery( document ).ready(function($) {
        UIkit.modal('#first-time-intro').show();

        // $('#first-time-intro .uk-close').click(function() {
        //     UIkit.modal('#first-time-intro').hide();
        //     $('body').removeClass('inmove');
        //     $('.intro-cover').addClass('uk-hidden');
        // });

        $('.Validate_button').click(function() {

            var watchful_key = $('#watchful_key').val();

            if (watchful_key == '')
            {
                $('.watchful_key_alert').text('Watchful key can\'t be empty').show();
            }
            else
            {
                $('.watchful_key_alert').text('').hide();
                // $('.error_response-watchfull').html('');

                $('.watchful_validating_spinner').show();
                $('.watchful_validating_locked').hide();

                $.ajax({
                    type: 'POST',
                    url: "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=watchful.validate&format=raw",
                    data: {
                        'watchful_key': watchful_key,
                        'action': 'status_install',
                        'extension_id': '18',
                        'save_key': 1
                        // 'debug': 1
                    },
                    success: function(data, textStatus, request){

                        var response = JSON.parse(data).data;

                        $('.watchful_validating_spinner').hide();

                        if (response.status_install)
                        {
                            location.reload(true);
                            
                            $('.watchful_validating_unlocked').show();
                            $('.watchful_validating_locked').hide();
                            $('.watchful_validating_uncheck').hide();
                            $('.watchful_validating_check').show();
                            $('.Validate_button').attr('disabled', true).addClass('uk-disabled');
                            $('#watchful_key').attr('disabled', true).addClass('uk-disabled uk-button-success');

                        }
                        else
                        {
                            $('.watchful_validating_locked').show();
                            $('.watchful_key_alert').html(response.message_html).show();
                            // UIkit.modal('#error_response-watchfull-modal').show();
                        }
                    }
                });

            }

            // if (false)
            // {
            //     UIkit.modal('#first-time-intro').hide();
            //     $('body').removeClass('inmove');
            //     $('.intro-cover').addClass('uk-hidden');
            // }

        });
        
    });
</script>