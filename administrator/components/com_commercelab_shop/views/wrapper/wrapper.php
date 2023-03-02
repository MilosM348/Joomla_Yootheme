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

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Version;
use Joomla\CMS\Uri\Uri;

use CommerceLabShop\User\UserFactory;

?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>

<?php


/** @var $vars array */

$input    = Factory::getApplication()->input;
$view     = $input->get('view', 'dashboard');
$extended = $input->get('extended', false);

$isSetup = \CommerceLabShop\Setup\SetupFactory::isSetup();
if (Version::MAJOR_VERSION === 4)
{
    Factory::getApplication()->input->set('hidemainmenu', true);
}
$session  = Factory::getSession();
$calssadd = $session->get('sidemenu');
				

?>
<div id="p2s_main" <?php echo (!empty($calssadd)?  "class=openmenu" : '') ?> class="theme-transition <?= ($vars['nighTheme']) ? 'night-theme' : '' ?>">
    <?php if ($isSetup) : ?>
        <div id="p2s_leftCol" class="left-bar">
            <a class="sidemenubtn" href="#"><i></i><i></i><i></i></a>

            <div class="brand-logo-block">
                <div style="height: 100%; width: 100%; padding: 0px 0px 32px 0px; position: absolute;">
                    <!-- <a class="uk-text-small closebtn" href="index.php">Close</a> -->
                    <div class="uk-flex-middle brand-logo uk-text-center uk-padding-small">
                        <?php if (Version::MAJOR_VERSION === 4): ?>
                            
                        <?php endif; ?>
                        <a href="index.php?option=com_commercelab_shop">
                            <?= LayoutHelper::render('svglogo'); ?>
                        </a>
                        <?= LayoutHelper::render('version'); ?>
                        <?= LayoutHelper::render('update'); ?>
                    </div>
                    <?= LayoutHelper::render('sidemenu', compact('templateStyle')); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($isSetup) : ?>
        <div id="p2s_content">

            <div class="uk-section-default uk-container uk-section uk-section-xsmall ">
                <div class="uk-grid" uk-grid>
                    <div class="uk-width-expand">
                        <ul class="uk-margin-remove-bottom uk-subnav" uk-margin="">
                            <div class="uk-margin-small">
                            <ul class="uk-breadcrumb uk-margin-remove-bottom uk-margin-remove-left">

                                    <li class="">
                                        <a class="el-link" href="index.php?option=com_commercelab_shop">
                                            <svg width="18px" class="svg-inline--fa fa-house-user fa-w-18 fa-lg"
                                                 uk-tooltip="Dashboard"
                                                 title="" aria-expanded="false" tabindex="0" aria-hidden="true"
                                                 focusable="false" data-prefix="fas" data-icon="house-user" role="img"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                 data-fa-i2svg="">
                                                <path fill="currentColor"
                                                      d="M570.69,236.27,512,184.44V48a16,16,0,0,0-16-16H432a16,16,0,0,0-16,16V99.67L314.78,10.3C308.5,4.61,296.53,0,288,0s-20.46,4.61-26.74,10.3l-256,226A18.27,18.27,0,0,0,0,248.2a18.64,18.64,0,0,0,4.09,10.71L25.5,282.7a21.14,21.14,0,0,0,12,5.3,21.67,21.67,0,0,0,10.69-4.11l15.9-14V480a32,32,0,0,0,32,32H480a32,32,0,0,0,32-32V269.88l15.91,14A21.94,21.94,0,0,0,538.63,288a20.89,20.89,0,0,0,11.87-5.31l21.41-23.81A21.64,21.64,0,0,0,576,248.19,21,21,0,0,0,570.69,236.27ZM288,176a64,64,0,1,1-64,64A64,64,0,0,1,288,176ZM400,448H176a16,16,0,0,1-16-16,96,96,0,0,1,96-96h64a96,96,0,0,1,96,96A16,16,0,0,1,400,448Z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <?php foreach ($vars['breadcrumbs'] as $breadcrumb) : ?>
                                        <li><a href="index.php?option=com_commercelab_shop"><?= $breadcrumb; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        </ul>


                    </div>

                    <div class="uk-width-auto">
                        <div class="uk-text-lowercase uk-visible@s">
                            <ul class="uk-margin-remove-bottom uk-subnav" uk-margin>
                                <li class="el-item uk-first-column">
                                    <a class="el-content"
                                       href="index.php?option=com_users&task=user.edit&id=<?= UserFactory::getActiveUser()->id; ?>"><?= UserFactory::getActiveUser()->name; ?></a>
                                </li>

                                <li class="el-item">
                                    <div id="night-toggle" class="uk-animation-fade">
                                        <input type="checkbox" value="1" id="night-toggle-input" <?= ($vars['nighTheme']) ? 'checked' : '' ?> />
                                        <label for="night-toggle-input">
                                            <i class="fas fa-moon"></i>
                                            <i class="fas fa-sun"></i>
                                        </label>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>


                </div>
                <hr class="uk-margin-remove-vertical">
            </div>



            <div class="uk-section-default uk-section uk-section-xsmall uk-padding-remove-top">
                <div class="uk-container uk-container-xlarge uk-margin-xlarge-bottom">
                    <?php if ($view) : ?>
                        <?php

                            if (
                                    $extended 
                                    && file_exists(JPATH_PLUGINS . '/commercelab_shop_extended/' . $extended . '/views/' . $view . '/bootstrap.php')
                                    && PluginHelper::isEnabled('commercelab_shop_extended', $extended)
                                )
                            {
                                include(JPATH_PLUGINS . '/commercelab_shop_extended/' . $extended . '/views/' . $view . '/bootstrap.php');
                            }
                            else if (
                                    !$extended 
                                    && file_exists(JPATH_PLUGINS . '/commercelab_shop_extended/' . $view . '/views/' . $view . '/bootstrap.php')
                                    && PluginHelper::isEnabled('commercelab_shop_extended', $view)
                                ) 
                            {
                                include(JPATH_PLUGINS . '/commercelab_shop_extended/' . $view . '/views/' . $view . '/bootstrap.php');
                            }
                            else
                            {
                                include(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/' . $view . '/bootstrap.php');   
                            }

                        ?>
                        <?php new bootstrap(); ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    <?php else: ?>
        <div style="width: 100%;">
            <div class="uk-section-default uk-section uk-section-xsmall">
                <div class="uk-container uk-container-xlarge uk-margin-xlarge-bottom">
                    <?php include(JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/views/setup/bootstrap.php'); ?>
                    <?php new bootstrap(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('.sidemenubtn').on('click', function(){
            var sideClass = '';
            if ($("#p2s_main").hasClass("openmenu") == true)
            {
                $('#p2s_main').removeClass('openmenu');
                sideClass = '';
            }
            else
            {
                $('#p2s_main').addClass('openmenu');
                sideClass = 'openmenu';
            }

            $.ajax({
                url: "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&task=task&type=sidemenu.openclose&format=raw", 
                type: 'POST',
                data:JSON.stringify ({
                    'sidemenu': sideClass
                }),
                headers: {
                    'X-CSRF-Token': Joomla_cls.token,
                    'Content-Type': 'application/json'
                },
                success: function(result) {}
            });

       });
    });
</script>
<?php if (Version::MAJOR_VERSION < 4) { ?>

<style>
.sidemenubtn{
    top: 0px;
    }
#p2s_leftCol {
    top: 31px !important;
    }
.editing-save.uk-sticky-fixed{
        top: 30px !important;
}
 @media(max-width: 1003px){
#p2s_content{
    padding-top: 50px;
   }

#p2s_leftCol {
    top: 60px !important;
    }

}

@media(max-width: 979px){
 #p2s_leftCol {
    top: 31px !important;
    }
 }

@media(max-width:848px){
 #p2s_leftCol {
    top: 61px !important;
}

#p2s_content{
    padding-top: 70px;
}

}

@media(max-width: 767px){
#p2s_leftCol{
    top: 35px !important;
}
#p2s_content{
    padding-top: 50px;
}
.openmenu #p2s_leftCol {
    top: 35px !important;
}
.editing-save.uk-sticky-fixed{
    top: 0px !important;
}

</style>

<script>

// ==============Joomla 3 ================

// $(document).ready(function(){
//     $('.brand-logo-block').css('top', '30px');
// });



// $(window).scroll(function(){
//     if ($(this).scrollTop() > 50) {
//        $('.sidemenubtn').css('top', '32px');
//     } else {
//        $('.sidemenubtn').css('top' , '32px');
//     }
// });


// ==============Joomla 3 ================
</script>
<?php }else{ ?>
<script>

// ==============Joomla 4 ================

$(window).scroll(function(){
    if ($(this).scrollTop() > 5) {
       $('#p2s_leftCol').css('top', '0px');
    } else {
       $('#p2s_leftCol').css('top' , '66px');
    }
});



$(window).scroll(function(){
    if ($(this).scrollTop() > 5) {
       $('.sidemenubtn').css('top', '0px');
    } else {
       $('.sidemenubtn').css('top' , '0px');
    }
});

// ==============Joomla 4 ================
</script>
<?php } ?>

<script>
jQuery(document).ready(function($) {

    // Night Theme
    $('#night-toggle-input').on('change', function() {

        var theme = '';
        if ($(this).is(':checked')) {
            var theme = 'nighTheme';
            $('#p2s_main').addClass('night-theme');
        } else {
            $('#p2s_main').removeClass('night-theme');
            var theme = 'dayTheme';
        }

        Cookies.set('cls_backend_theme', theme);

    });


    if ($('#left_menu_ul li.active').length)
    {    
        var offSetActive= $('#left_menu_ul li.active').offset().top;
        $('.heightsidemenu').scrollTop(offSetActive);

        if ((window.location.href).split('?')[1] === 'option=com_commercelab_shop') {
            if (localStorage.getItem('loadedfirst')) {
                //$('#left_menu_ul').removeClass('apply_animation');
            } else {
                $('#left_menu_ul').addClass('apply_animation');
            }
        } else {
            if (localStorage.getItem('loadedfirst')) {
                $('#left_menu_ul').removeClass('apply_animation');
            } 
        }

        if (localStorage.getItem('loadedfirst') == null || localStorage.getItem('loadedfirst') == undefined) {
            localStorage.setItem('loadedfirst', true);
        } 

        $('#left_menu_ul a').on('click', function() {
            if ($(this).attr('href') == 'index.php') {
                if (localStorage.getItem('loadedfirst')) {
                    localStorage.removeItem('loadedfirst');
                }
            }
        })

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
    }
})
</script>





