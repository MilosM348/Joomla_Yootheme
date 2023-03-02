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


?>

<div v-show="!form.itemid">
    <h5>Please save the product before adding variants </h5>
</div>
<div v-show="form.itemid">
    <div class="uk-card uk-card-default  uk-margin-bottom">
        <div class="uk-card-header">
            <div class="uk-grid" uk-grid>
                <div class="uk-width-expand"><h5>Variant Types</h5></div>
                <div class="uk-width-auto">
                    <button type="button" class="uk-icon-button" uk-icon="info"></button>

                </div>
            </div>
        </div>

        <div class="uk-card-body variantitems" uk-sortable="cls-custom: uk-box-shadow-small uk-flex uk-flex-middle uk-background">

            <div class="uk-card uk-card-body uk-card-default uk-margin-small-bottom"
                v-for="(variant, index) in form.jform_variants" :id="variant.id"
            >
                <div class="uk-position-absolute uk-position-top-right uk-margin-small-right uk-margin-small-top">

                    Remove
                    <span style="cursor: pointer; color: red;" 
                        uk-icon="icon: minus-circle" @click="removeVariant(index)">        
                    </span>

                </div>
                <div class="uk-grid" uk-grid>
                    <div class="uk-width-1-1 uk-grid-item-match uk-flex-middle">


                        <div class="uk-margin">
                            <span class=" uk-sortable-handle uk-margin-small-right uk-text-center uk-icon" uk-icon="icon: table"></span>
                            <label class="uk-form-label" for="form-stacked-text">Variant Type</label>
                            <div class="uk-form-controls">

                                <input class="uk-input uk-form-large" placeholder="Product Variant e.g. 'Colour' 'Size'"
                                    v-model="form.jform_variants[index].name"
                                >

                            </div>
                        </div>

                    </div>
                    <div class="uk-width-1-1">

                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">Variant Options</label>
                            <div class="uk-form-controls">

                                <p-chips v-model="form.jform_variants[index].labels" @remove="removeLabel($event, index, form.jform_variants[index].id)" @add="onAddNewLabel($event, form.jform_variants[index].id)" :addOnBlur="true" :allowDuplicate="false" >
                                    <template #chip="slotProps">
                                        {{slotProps.value.name}}
                                    </template>
                                </p-chips>

                                <a class="uk-animation-blink uk-margin-small-top uk-display-block uk-text-success uk-text-right" v-if="savingVariant" @click="applyVariants()" href="javascript:void(0);"
                                    :class="{'uk-disabled': saving_variants}"
                                >
                                    <span class="uk-margin-right" v-if="saving_variants" style="width: 15px; height: 15px;" uk-spinner></span>
                                    Apply Variants Options
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="uk-grid" uk-grid>
                <div class="uk-width-expand"></div>
                <div class="uk-width-auto">
                    <button type="button"
                        class="uk-button uk-button-small uk-button-default uk-text-small"
                        :class="{'uk-disabled': saving_variants}"
                        @click="addVariant"
                    >
                        Add Variant Type
                        <span uk-icon="icon: plus-circle"></span>
                    </button>
                    <button type="button"
                        class="uk-button uk-button-small uk-button-default uk-text-small uk-margin-left"
                        :class="{'uk-disabled': saving_variants}"
                        @click="selectOptionTemplate"
                    >
                        Variant Template
                        <span uk-icon="icon: plus-circle"></span>
                    </button>
                </div>
            </div>
        </div>


<!--        <div class="uk-card-footer">-->
<!--            <div class="uk-grid" uk-grid>-->
<!--                <div class="uk-width-expand"></div>-->
<!--                <div class="uk-width-auto">-->
<!--                    <button type="button"-->
<!--                            class="uk-button uk-button-small uk-button-primary" @click="setVariants">Set Variant Values-->
<!--                        <span uk-icon="icon: check"></span>-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="uk-width-auto">-->
<!--                    <button type="button"-->
<!--                            class="uk-button uk-button-small uk-button-primary" @click="refreshVariants">Refresh Values-->
<!--                        <span uk-icon="icon: check"></span>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>


    <div class="uk-card uk-card-default uk-margin-bottom">
        <div class="uk-card-header">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-expand">
                    <h5>
                      Variant Combination List
                    </h5>
                </div>
                <div class="uk-width-auto">
                    <span v-show="!variants_loading" :class="[setSavedClass ? 'uk-text-meta uk-text-success uk-animation-fade uk-animation-fast' : 'uk-animation-fade uk-animation-fast uk-hidden']">saved!</span>
                    <span v-show="variants_loading" class="uk-text-meta  uk-text-warning"  >
                        Saving
                        <i class="fal fa-spinner-third fa-spin fa-sm"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="uk-card-body uk-overflow-auto">
            <table uk-sortable="cls-custom: uk-box-shadow-small uk-flex uk-flex-middle uk-background" class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-middle variantcombination">
                <thead>
                    <tr>
                        <th class="">Variant</th>
                        <th class="uk-width-2-5">Price</th>
                        <th class="">Stock</th>
                        <th class="uk-width-1-5">SKU</th>
                        <th class="uk-table-shrink">Active</th>
                        <th class="uk-table-shrink">Default</th>
                        <th class="uk-table-shrink"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in form.jform_variantList" :id="item.id">
                        <td>
                            <span class="uk-padding-small uk-sortable-handle uk-margin-small-right uk-text-center uk-icon" uk-icon="icon: table"></span>
                            {{item.namedLabel}}
                        </td>
                        <td class="">
                            <p-inputnumber mode="currency" :currency="p2s_currency.iso" :locale="p2s_locale"
                                v-model="item.price" :placeholder="form.jform_base_price"></p-inputnumber>
                        </td>
                        <td class="">
                            <input style="max-width: 75px !important;" class="uk-input uk-form-small " type="number" v-model="item.stock" placeholder="Stock">
                        </td>
                        <td class="">
                            <input class="uk-input uk-form-small uk-width-3-5" type="text" v-model="item.sku" placeholder="SKU">
                        </td>
                        <td class="">
                            <p-inputswitch v-model="item.active" @change="checkVariantDefault(index);updateVariantValues()" ></p-inputswitch>
                        </td>
                        <td class="">
                            <p-inputswitch v-model="item.default" @change="setVariantDefault(index);updateVariantValues()" ></p-inputswitch>
                        </td>
                        <td class="">
                            <button class="uk-button uk-button-small" @click="saveVariantValues(true)">Apply</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var util = UIkit.util;
	util.ready(function () {
       
		util.on('.variantitems', 'stop', function (e, sortable, el) { 
            const newItemList = [];
			sortable.items.forEach(function(item, index) {
				newItemList.push({
                    "id": item.id,
                    "ordering": index,
                });
			});
            
            const params = {'items': newItemList,};
            let base_urls = '';
			const base_url = document.getElementById('base_url');
            if (base_url != null) {
                try {
                   base_urls = base_url.innerText;
                    base_url.remove();
                } catch (err) {}
            }
			const request = fetch(base_urls + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=product.varianttypeordering&format=raw", {
				method: 'POST',
				mode: 'cors',
				cache: 'no-cache',
				credentials: 'same-origin',
				headers: {
					'Content-Type': 'application/json'
				},
				redirect: 'follow',
				referrerPolicy: 'no-referrer',
				body: JSON.stringify(params)
			});
		});
        util.on('.variantcombination', 'stop', function (e, sortable, el) { 
            const newItemList = [];
			sortable.items.forEach(function(item, index) {
				newItemList.push({
                    "id": item.id,
                    "ordering": index,
                });
			});
            const params   = {
                'items': newItemList
            };
            let base_urls  = '';
            const base_url = document.getElementById('base_url');
            if (base_url != null)
            {
                try {
                   base_urls = base_url.innerText;
                    base_url.remove();
                } catch (err) {}
            }
			const request = fetch(base_urls + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=product.variantcombinationordering&format=raw", {
				method: 'POST',
				mode: 'cors',
				cache: 'no-cache',
				credentials: 'same-origin',
				headers: {
					'Content-Type': 'application/json'
				},
				redirect: 'follow',
				referrerPolicy: 'no-referrer',
				body: JSON.stringify(params)
			});
		});
	});
</script>