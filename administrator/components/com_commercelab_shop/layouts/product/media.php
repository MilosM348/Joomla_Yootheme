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

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;

/** @var array $displayData */

$data  = $displayData;
$model = $data['model'];
// $id = $data['id']; // FIeld OR Image Id
$id    = (isset($data['idStringify']) && $data['idStringify'] == true) ? "'" . $data['id'] . "'" : $data['id'];

$thumb_height = $data['thumb_height'];

?>

<div class="uk-grid" uk-grid="" >
    <div class="uk-width-1-1"
        :class="{'uk-animation-fade uk-animation-fast': <?= $model; ?> == null || <?= $model; ?> == ''}" 
    >
        <!-- v-show="<?= $model; ?> == null || <?= $model; ?> == ''" -->

        <div class="uk-grid uk-grid-small" uk-grid="">
            <div class="uk-width-expand">
                <input 
                    :id="<?= $id; ?>" 
                    v-model="<?= $model; ?>"
                    class="uk-input" 
                    placeholder="Add remote URL or Select"
                >
            </div>
            <div class="uk-width-auto uk-grid-item-match uk-flex-middle">

                <button type="button" :uk-toggle="'target: #mediaField' + <?= $id; ?>" @click="defineOpenedManager(<?= $id; ?>)" class="uk-button uk-button-default uk-button-small">
                    <?= Text::_('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_SELECT'); ?>
                </button>
                
            </div>
        </div>

    </div>

    <!-- <div class="uk-width-1-1 uk-position-relative d-block upload-image" @click="removeFile()"> -->
    <div class="uk-width-1-1 uk-position-relative d-block upload-image uk-position-relative">

        <!-- Close Button -->
<!--         <a href="javascript:void(0);" 
            @click="<?= $model;?> = ''" 
            v-show="<?= $model; ?> !== null && <?= $model; ?> !== ''"
            class="uk-icon-button uk-position-absolute" 
            style="right: 10px; top: 10px; z-index: 10;"
            uk-icon="icon: close"
        ></a>
 -->
        <!-- Image Placeholder -->
        <div uk-lightbox v-if="isRemotePath(<?= $model; ?>)">
            <a :href="<?= $model; ?>" data-type="image">
                <div uk-img="loading: eager" 
                    v-show="<?= $model; ?> !== null && <?= $model; ?> !== ''"
                    :class="{'uk-animation-fade uk-animation-fast': <?= $model; ?> !== null && <?= $model; ?> !== ''}" 
                    class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
                    style="background-position: center center; width: 100%"
                    :style="{'background-image':'url(\''+<?= $model; ?>+'\')', 'height': '<?= $thumb_height ?>'}"
                ></div>
            </a>
        </div>
        <div uk-lightbox v-else>
            <a :href="'<?= \Joomla\CMS\Uri\Uri::root(); ?>' + <?= $model; ?>" data-type="image">
                <div uk-img="loading: eager" 
                    v-show="<?= $model; ?> !== null && <?= $model; ?> !== ''"
                    :class="{'uk-animation-fade uk-animation-fast': <?= $model; ?> !== null && <?= $model; ?> !== ''}" 
                    class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
                    :style="{'background-image':'url(\'<?= \Joomla\CMS\Uri\Uri::root(); ?>'+<?= $model; ?>+'\')', 'width': '100%', 'height': '<?= $thumb_height ?>', 'background-position': 'center center'}"
                ></div>
            </a>
        </div>
    </div>
</div>

<?= 
    LayoutHelper::render('product/modals/media_manager_modal', [
        'id'         => $id,
        'model'      => $model,    
    ]); 
?>