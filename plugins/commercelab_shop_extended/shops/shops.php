<?php
/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//require_once(__DIR__ . '/vendor/autoload.php');


use Joomla\CMS\Response\JsonResponse;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Form\Form;
use Joomla\Input\Input;
use Joomla\CMS\Factory;

use CommerceLabShop\Product\ProductFactory;
use CommerceLabShop\Shop\ShopFactory;
use CommerceLabShop\Sidebarlink\Sidebarlink;
// use CommerceLabShop\Bootstrap\AdminViewExtended;
use CommerceLabShop\ProductAddon\ProductAddon;
use CommerceLabShop\Bootstrap\ProductformViewExtended;


class plgCommercelab_shop_extendedShops extends CMSPlugin implements ProductformViewExtended
{


	public function onAfterInitialise()
	{
   		// FormHelper::addFormPath(JPATH_PLUGINS . '/commercelab_shop_extended/shops/forms');
   		// Form::loadFile('profileabc');
	}

	/**
	 *
	 * @return Sidebarlink
	 *
	 * @since 2.0.0
	 */


	public function onGetProductAddons(): ProductAddon
	{

		$shops = new stdClass();

		$shops->id     = 'shops';
		$shops->title  = 'Shops'; // todo - translate
		$shops->fields = [];
		$shops->html   = $this->getHTML();

		return new ProductAddon($shops);

	}

	public function getHTML() {

		$itemid = Factory::getApplication()->input->get('id');

		$shops     = ShopFactory::getShopsFromProductId($itemid);
		$all_shops = ShopFactory::getList();
		$prep_time = ShopFactory::getPrepTime($itemid);

		if (!$all_shops)
		{
			$all_shops = [];
		}

		PluginHelper::importPlugin('system');

		$html = '<div id="cls_shops_inproduct" class="uk-card uk-card-default uk-margin-bottom uk-animation-fade">
				 	<div class="uk-card-header">
				 		<div uk-grid>
							<div class="uk-width-expand">
								<h3>
									Shops
								</h3>
							</div>
						</div>
					</div>
					<div class="uk-card-body uk-card-default">

						<div id="added_shops" class="uk-child-width-1-2 uk-grid-divider" uk-grid>';
							// Render Shops
							foreach ($shops as $key => $shop)
							{
								$html .= '<div id="added_shop_' . $shop->id . '"><div class="uk-card uk-card-hover uk-card-default">';
								$html .= '<a style="top: 0; right: 0;" href="javascript:void(0);" onclick="removeProductFromShop(' . $shop->id . ', ' . $itemid . ')" uk-tooltip="Remove from this Shop" uk-icon="icon: trash" class="uk-position-absolute uk-text-danger uk-margin-small-top uk-margin-small-right" href="javascipt:void(0);"></a>';
								$html .= '<div class="uk-card-header uk-padding-small"><a class="uk-h4" href="index.php?option=com_commercelab_shop&extended=shops&view=shop&id='. $shop->id .'">' . $shop->title . '</a></div>';
								$html .= '<div class="uk-card-body">' . $shop->address . ', ' . $shop->city . ', ' . $shop->postalcode . ', ' . $shop->country . ', ' . '</div>';
								$html .= '</div></div>';
							}

			$html .= 	'</div>

						<div class="uk-margin-top" uk-grid>
							<div class="uk-width-1-3">
								<div class="control-label">
									<label class="uk-card-title">
										Preparation time
										<span class="star uk-text-danger">&nbsp;*</span>
									</label>
								</div>
								<div uk-grid>
									<div class="uk-width-expand">
										<input value="' . $prep_time . '" class="uk-input uk-form-small" type="text" id="preperation_time_' . $itemid . '" placeholder="Preparation Time (h)" name="">
									</div>
									<div class="uk-width-auto">
										<a href="javascript:void(0);" onclick="savePreparationTime(' . $itemid . ')" class="uk-button uk-button-small uk-button-default" uk-tooltip="Save Preparation Time">Save</a>
									</div>
								</div>
							</div>
							<div class="uk-width-2-3 uk-text-right">
								<a uk-tooltip="Add Product to Shops" href="javascript:void(0);" uk-toggle="target: #add_shop_modal">
									<span uk-icon="icon: plus-circle; ratio: 2;"></span>
								</a>
								<div id="add_shop_modal" uk-modal>
								    <div class="uk-modal-dialog uk-modal-body">
								        <button class="uk-modal-close-default" type="button" uk-close></button>
								        <div class="uk-child-width-1-2 uk-grid-divider" uk-grid>';
										foreach ($all_shops as $key => $shop)
										{
											$in_shop = ($shop->products && in_array($itemid, $shop->products));
											$html .= '<div id="all_shop_' . $shop->id . '"><div class="uk-card uk-card-hover uk-card-default">';
											$html .= '<a id="add_all_shop_' . $shop->id . '" style="top: 0; right: 0;" href="javascript:void(0);" onclick="addProductToShop(' . $shop->id . ', ' . $itemid . ')" uk-tooltip="Add to this Shop" uk-icon="icon: plus-circle" class="uk-position-absolute uk-text-success uk-margin-small-top uk-margin-small-right" href="javascipt:void(0);"></a>';
											$html .= '<div class="uk-card-header uk-padding-small"><span class="uk-h4">' . $shop->title . '</span></div>';
											$html .= '<div class="uk-card-body">' . $shop->address . ', ' . $shop->city . ', ' . $shop->postalcode . ', ' . $shop->country . ', ' . '</div>';
											$html .= '</div></div>';
										}
			$html .= 					'</div>
								    </div>
								</div>
							</div>
						</div>
						
					</div>
				</div>';
			
			// $html .= LayoutHelper::render('product/modals/media_manager_modal', [
			// 	'id'      => "'jform_gallery'",
			// 	'model'   => 'jform_galleryimg',
			// 	'single'  => false,
			// 	'gallery' => true
			// ]);


		return $html;
	}

	// public function onGetSidebarLink(): Sidebarlink
	// {
	// 	$menuItem = new \stdClass();

	// 	$menuItem->view      = 'shops';
	// 	$menuItem->linkText  = 'Shops';
	// 	$menuItem->icon      = '<svg width="16px" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="file-import" class="svg-inline--fa fa-file-import fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 97.98L414.02 14.1c-9-9-21.2-14.1-33.89-14.1H175.99C149.5.1 128 21.6 128 48.09V288H8c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h248v52.67c0 10.98 6.38 20.55 16.69 24.97 14.93 6.45 26.88-1.61 30.88-5.39l71.72-68.12c5.62-5.33 8.72-12.48 8.72-20.12s-3.09-14.8-8.69-20.11l-71.78-68.16c-8.28-7.8-20.41-9.88-30.84-5.38-10.31 4.42-16.69 13.98-16.69 24.97V288H160V48.09c0-8.8 7.2-16.09 16-16.09h176.04v104.07c0 13.3 10.7 23.93 24 23.93h103.98v304.01c0 8.8-7.2 16-16 16H175.99c-8.8 0-16-7.2-16-16V352H128v112.01c0 26.49 21.5 47.99 47.99 47.99h288.02c26.49 0 47.99-21.5 47.99-47.99V131.97c0-12.69-5.1-24.99-14.1-33.99zM288 245.12L350 304l-62 58.88V245.12zm96.03-117.05V32.59c2.8.7 5.3 2.1 7.4 4.2l83.88 83.88c2.1 2.1 3.5 4.6 4.2 7.4h-95.48z"></path></svg>';

	// 	return new Sidebarlink($menuItem);


	// }

	/**
	 *
	 * @return JsonResponse
	 *
	 * @throws Exception
	 * @since 1.0
	 */


	public function onAjaxShops(): JsonResponse
	{


		$input = Factory::getApplication()->input;


		return new JsonResponse($this->processUpload($input));


	}

}


?>

<script>

	window.addedShops = <?= json_encode(ShopFactory::getShopsFromProductId(Factory::getApplication()->input->get('id'))) ?>;
	window.allShops   = <?= json_encode(ShopFactory::getList()) ?>;

	UIkit.util.on(document, 'show', "#add_shop_modal", function (element) {

		window.allShops.forEach(shop => {
			var existing_shop = document.getElementById('added_shop_' + shop.id);

			if (existing_shop)
			{
				document.getElementById('all_shop_' + shop.id).style.opacity = '0.5';
				document.getElementById('add_all_shop_' + shop.id).classList.add('uk-hidden');
			}
			else
			{
				document.getElementById('all_shop_' + shop.id).style.opacity = '1';
				document.getElementById('add_all_shop_' + shop.id).classList.remove('uk-hidden');
			}
		});	
	});

	async function savePreparationTime(product_id)
	{
		var params = {
			product_id,
			time: document.getElementById('preperation_time_' + product_id).value
		};
		var response = await sendRequest('savepreptime', params);

		if (response.ok)
		{
            UIkit.notification({
                message: 'Time saved',
                status: 'success',
                pos: 'top-center',
                timeout: 5000
            });
		}

	}

	async function removeProductFromShop(shop_id, product_id)
	{
		var params = {
			shop_id,
			product_id
		};
		var response = await sendRequest('removeproduct', params);
		if (response.success)
		{
			[...window.addedShops].forEach((shop, index) => {
				if (shop.id == shop_id)
				{
					window.addedShops.splice(index, 1);
				}
			});
			document.getElementById('added_shop_' + shop_id).remove();
		}

	}

	async function addProductToShop(shop_id, product_id)
	{
		var params = {
			shop_id,
			product_id
		};

		var response = await sendRequest('addproduct', params);

		if (response.success)
		{
			document.getElementById('all_shop_' + shop_id).style.opacity = '0.5';
			document.getElementById('add_all_shop_' + shop_id).classList.add('uk-hidden');

			[...window.allShops].forEach((shop, index) => {
				if (shop.id == shop_id)
				{
					window.addedShops.push(shop);
					document.getElementById('added_shops').insertAdjacentHTML('beforeend', '<div id="added_shop_' + shop.id + '"><div class="uk-card uk-card-hover uk-card-default"><a href="javascript:void(0);" onclick="removeProductFromShop(' + shop.id + ', ' + product_id + ')" uk-tooltip="Remove from this Shop" uk-icon="icon: trash" class="uk-position-absolute uk-text-danger uk-margin-small-top uk-margin-small-right uk-icon" title="" aria-expanded="false" style="top: 0px; right: 0px;"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" points="6.5 3 6.5 1.5 13.5 1.5 13.5 3"></polyline><polyline fill="none" stroke="#000" points="4.5 4 4.5 18.5 15.5 18.5 15.5 4"></polyline><rect x="8" y="7" width="1" height="9"></rect><rect x="11" y="7" width="1" height="9"></rect><rect x="2" y="3" width="16" height="1"></rect></svg></a><div class="uk-card-header uk-padding-small"><span class="uk-h4">' + shop.title + '</span></div><div class="uk-card-body">' + shop.address + ', ' + shop.city + ', ' + shop.postalcode + ', ' + shop.country + ', </div></div></div>');

					return;
				}
			});
		}

	}

	async function sendRequest(taskPath, params)
	{

		if (!params)
		{
			params = {};
		}
		
        const request = await fetch(Joomla_cls.uri_base + 'index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&format=raw&type=shop.' + taskPath , {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-Token': Joomla_cls.token,
                'Content-Type': 'application/json'
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(params)
        });
		const response = await request.json();
        return response;
	}
</script>