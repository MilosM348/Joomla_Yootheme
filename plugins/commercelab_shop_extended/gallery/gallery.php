<?php
/**
 * @package   CommerceLab Shop
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2021 Cloud Chief - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Layout\LayoutHelper;

use CommerceLabShop\ProductAddon\ProductAddon;
use CommerceLabShop\Bootstrap\ProductformViewExtended;

class plgCommercelab_shop_extendedGallery extends CMSPlugin implements ProductformViewExtended
{

	public function onAfterInitialise()
	{

	}

	/**
	 *
	 * @return ProductAddon
	 *
	 * @since 2.0.0
	 */


	public function onGetProductAddons(): ProductAddon
	{

		$gallery = new stdClass();

		$gallery->id     = 'productgallery';
		$gallery->title  = 'Gallery View'; // todo - translate
		$gallery->fields = [];
		$gallery->html   = $this->getHTML();

		return new ProductAddon($gallery);

	}

	public function getHTML(){

		$itemid = Factory::getApplication()->input->get('id');
		PluginHelper::importPlugin('system');

		$imgs = Factory::getApplication()->triggerEvent('ongetgallery', [$itemid]);

		$html = '<div class="uk-card uk-card-default uk-margin-bottom uk-animation-fade">
				 	<div class="uk-card-header">
				 		<div uk-grid>
							<div class="uk-width-expand">
								<h3>
									Gallery View
									<span v-if="gallery_loading" style=" width: 20px; height: 20px;" uk-spinner></span>
								</h3>
							</div>
						</div>
					</div>
					<div class="uk-card-body">

						<div class="viewmain drop-zone uk-child-width-1-5@s uk-grid-small" uk-sortable="handle: .preview" uk-grid>

							<div v-if="setdiv" class="preview" v-for="data in urls" :id="data.id">
                                <a href="javascript:void(0);" class="remove-gallery-image uk-icon-button uk-position-absolute uk-icon" 
                                	@click="removeGalleryImg(data.id,'.$itemid.')"
                                	uk-icon="icon: close; ratio: 0.8" style="right: 10px; top: 10px; z-index: 10; width: 25px; height: 25px; display: none;">
                                </a>
                                <div uk-lightbox>
	                                <a :href="\''. JUri::root() .'\' + data.path">
		                                <div class="uk-animation-fade uk-animation-fast uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
		                                	style="border: 1px solid rgba(0, 0, 0, .3);"
		                                    :style="{\'background-image\':\'url(\\\''. JUri::root() .'\' + data.path + \'\\\')\', \'width\': \'100%\', \'height\': \'150px\', \'background-position\': \'center center\'}"
		                                ></div>
		                            </a>
		                        </div>
							</div>';

		if(!empty($imgs)) {
			foreach ($imgs[0] as $img) {
				$html .=	'<div v-if="!setdiv" class="preview" id="'.$img->id.'">
                                <a href="javascript:void(0);" class="remove-gallery-image uk-icon-button uk-position-absolute uk-icon" 
                                	@click="removeGalleryImg('.$img->id.','.$itemid.')"
                                	uk-icon="icon: close; ratio: 0.8" style="right: 10px; top: 10px; z-index: 10; width: 25px; height: 25px; display: none;">
                                </a>
                                <div uk-lightbox>
	                                <a href="' . JUri::root() . $img->path . '">
		                                <div class="uk-animation-fade uk-animation-fast uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" 
		                                    style="background-image: url(\'' . JUri::root() . $img->path . '\'); width: 100%; height: 150px; background-position: center center; border: 1px solid rgba(0, 0, 0, .3);"
		                                ></div>
		                            </a>
		                        </div>
							</div>';
			}
		}

			$html .= 	'</div>
						<div class="uk-width-1-1 uk-margin-top uk-text-right">
							<a href="javascript:void(0);" @click="defineOpenedManager(\'mediaFieldjform_gallery\')" uk-toggle="target: #mediaFieldjform_gallery">
								<span uk-icon="icon: plus-circle; ratio: 2;"></span>
							</a>
						</div>
					</div>
				</div>';
			
			$html .= LayoutHelper::render('product/modals/media_manager_modal', [
				'id'      => "'jform_gallery'",
				'model'   => 'jform_galleryimg',
				'single'  => false,
				'gallery' => true
			]);


		return $html;
	}

}

?>

<script type="text/javascript">

	<?php
		$id = uniqid('gallery');
	?>

	const util_<?= $id ?> = UIkit.util;

	util_<?= $id ?>.ready(function () {

		util_<?= $id ?>.on('.viewmain', 'stop', function (e, sortable, el) { 

			console.log(e.type, sortable, el);

			sortable.items.forEach(function(item, index) { 

				const params = {
					'id': item.id,
					'order_no': index,
				};

				let base_urls = '';
				const base_url = document.getElementById('base_url');
				if (base_url != null) {
					 try {
						 base_urls = base_url.innerText;
						  base_url.remove();
					 } catch (err) {
					 }
				}
				const request = fetch(base_urls + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=product.orderGalleryImgs&format=raw", {
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
				// Grab data attributes if you need to.
				// UIkit.util.data(item, "id");
			});

		});

	});

</script>
