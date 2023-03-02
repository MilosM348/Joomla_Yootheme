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

use CommerceLabShop\Product\ProductFactory;

$data  = $displayData;
$order = $data['item'];

?>

<div class="uk-card uk-card-<?= $data['cardStyle']; ?> uk-margin-bottom">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-expand">
                <h3>
					<?= Text::_($data['cardTitle']); ?>
                </h3>
            </div>
            <div class="uk-width-auto">

            </div>

        </div>
    </div>

    <div class="uk-card-body uk-overflow-auto">
        <table class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_PRODUCTS_ORDERED_TABLE_NAME'); ?></th>
                    <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_PRODUCTS_ORDERED_TABLE_OPTIONS'); ?></th>
                    <th><?= Text::_('Variant'); ?></th>
                    <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_PRODUCTS_ORDERED_TABLE_PRICEATSALE'); ?></th>
                    <th><?= Text::_('Amount'); ?></th>
                    <th><?= Text::_('COM_COMMERCELAB_SHOP_ORDER_PRODUCTS_ORDERED_TABLE_SUBTOTAL'); ?></th>
                </tr>
            </thead>
            <tbody>
			<?php foreach ($order->ordered_products as $product) : 

                $productObject   = ProductFactory::get($product->j_item);
                $selectedVariant = null;
                foreach ($productObject->variantList as $variantList) if ($variantList->id == $product->variant_id)
                {
                    $selectedVariant = $variantList;
                }
            ?>
                <tr>
                    <td>
                        <a href="index.php?option=com_commercelab_shop&view=product&id=<?= $product->j_item; ?>"><?= $product->j_item_name; ?></a>
                    </td>
                    <td>
						<?php if ($product->item_options_array) : ?>
							<?php foreach ($product->item_options_array as $option) : ?>
                                <div>
									<?= $option->option_name; ?>
                                </div>
							<?php endforeach; ?>
						<?php endif; ?>
                    </td>
                    <td>
                        <?php if ($selectedVariant) : ?>
                            <ul class="uk-list uk-list-collapse uk-padding-remove uk-margin-remove">
                                <?php foreach ($productObject->variants as $variant) : ?>
                                    <?php foreach ($variant->labels as $label) : ?>
                                        <?php if (in_array($label->id, explode(',', $selectedVariant->label_ids))) : ?>
                                            <li>
                                                <?= $variant->name ?>: <span class="uk-text-bold"><?= $label->name ?></span>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </td>
                    <td class="uk-font-primary"><?= $product->price_at_sale_formatted; ?></td>
                    <td class="uk-font-primary"><?= $product->amount; ?></td>
                    <td class="uk-font-primary"><?= $product->subtotal_formatted; ?></td>

                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>

    </div>


    <!-- <div class="uk-card-footer"></div> -->
</div>
