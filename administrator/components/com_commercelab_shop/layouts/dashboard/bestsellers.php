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

$data = $displayData;


?>


<div class="uk-card uk-card-default uk-card-small uk-card-hover">
	<div class="uk-card-header">
		<div class="uk-grid uk-grid-small">
			<div class="uk-width-auto">
				<h4> <?= Text::_('COM_COMMERCELAB_SHOP_BESTS_SELLERS'); ?></h4>
			</div>
			<div class="uk-width-expand uk-text-right panel-icons">

			</div>
		</div>
	</div>
	<div class="uk-card-body">
		<table class="uk-table uk-table-striped">
			<thead>
			<tr>
				<th><?= Text::_('COM_COMMERCELAB_SHOP_PRODUCT'); ?></th>
				<th><?= Text::_('COM_COMMERCELAB_SHOP_SOLD'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($data['bestSellers'] as $bestseller) :?>
				<tr>
					<td><a href="index.php?option=com_commercelab_shop&view=product&id=<?= $bestseller->id; ?>"><?= $bestseller->title; ?></a> </td>
					<td><?= $bestseller->salestotal; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
