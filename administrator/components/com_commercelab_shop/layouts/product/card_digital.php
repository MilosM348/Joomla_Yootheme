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
use Joomla\CMS\Uri\Uri;



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

            <div class="uk-width-auto">
                <button type="button" class="uk-button uk-button-small uk-button-default button-success"
                        @click="openAddFile">Add File
                    <span uk-icon="icon: cloud-upload"></span>
                </button>
            </div>

        </div>
    </div>

    <div class="uk-card-body uk-overflow-auto">

        <table class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-middle">
            <thead>
            <tr>
                <th class="">File</th>
                <th class="uk-table-shrink">Is Joomla</th>
                <th class="uk-width-1-5">Version</th>
                <th class="uk-width-1-5">Type</th>
                <th class="uk-width-1-5">PHP</th>
                <th class="uk-width-1-5">Stability</th>
                <th class="uk-table-1-5">Controls</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="file in form.files">
                <td>
                    {{file.filename}}
                </td>
                <td class="">
                   <span v-if="file.isjoomla == '1'"
                         style="font-size: 18px; color: green; ">
                      <i class="fas fa-check-circle"></i>
                    </span>
                    <span v-if="file.isjoomla == '0'"
                          style="font-size: 18px; color: red;">
                     <i class="fas fa-times-circle"></i>
                    </span>
                </td>
                <td class="">
                    {{file.version}}
                </td>
                <td class="">
                    {{file.type}}
                </td>
                <td class="">
                    {{file.php_min}}
                </td>
                <td class="">
                    {{file.stability_level_string}}
                </td>
                <td class="">
                    <span uk-icon="icon: file-edit" @click="openFileEdit(file)" style="cursor: pointer"></span>
                    <span uk-icon="icon: trash"></span>
                </td>
            </tr>

            </tbody>
        </table>


    </div>
    <!-- <div class="uk-card-footer"></div> -->
</div>


<div id="fileEditModal" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Edit File</h2>
        </div>
        <div class="uk-modal-body">
            <form>
                <fieldset class="uk-fieldset">

                    <div class="p2s_file_upload uk-placeholder uk-text-center" v-show="!file_for_edit.filename_obscured"
                         id="p2s_file_upload">
                        <span uk-icon="icon: cloud-upload"></span>
                        <span class="uk-text-middle">Attach an image by dropping here or</span>
                        <div uk-form-custom>
                            <input type="file" multiple>
                            <span class="uk-link">selecting one</span>
                        </div>
                    </div>

                    <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

                    <div v-show="file_for_edit.filename_obscured">
                        <div class="uk-card uk-card-body uk-card-default">
                            <span @click="removeFile" uk-tooltip="Remove File" class="uk-position-absolute uk-position-top-right uk-margin-top uk-margin-right" style="cursor: pointer">
                                <i class="fas fa-times-circle fa-lg"></i>
                            </span>
                            <i class="fal fa-file-archive fa-5x"></i>
                            <p>{{file_for_edit.filename}}</p>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="fversion">Version</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="version" type="text" v-model="file_for_edit.version">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <div uk-grid>
                                <div class="uk-width-auto">
                                    <p-inputswitch v-model="file_for_edit.isjoomla" @change="logIt"></p-inputswitch>
                                </div>
                                <div class="uk-width-expand uk-grid-item-match uk-flex-middle">Is Joomla?</div>

                            </div>
                        </div>
                    </div>


                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Type</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" v-model="file_for_edit.type">
                                <option value="plugin">Plugin</option>
                                <option value="module">Module</option>
                                <option value="component">Component</option>
                                <option value="package">Package</option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Stability Level</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" v-model="file_for_edit.stability_level">
                                <option value="1"><?= Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_ALPHA'); ?></option>
                                <option value="2"><?= Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_BETA'); ?></option>
                                <option value="3"><?= Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_RELEASE_CANDIDATE'); ?></option>
                                <option value="4"><?= Text::_('COM_COMMERCELAB_SHOP_FILE_STABILITY_TYPE_RELEASE_STABLE'); ?></option>
                            </select>
                        </div>
                    </div>


                    <div class="uk-margin">
                        <label class="uk-form-label" for="php_min">Minimum PHP</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="php_min" type="text" v-model="file_for_edit.php_min">
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button" @click="cancelFile()">Cancel
            </button>
            <button class="uk-button uk-button-primary uk-margin-left" type="button" @click="saveFile()">Save</button>
        </div>
    </div>
</div>

