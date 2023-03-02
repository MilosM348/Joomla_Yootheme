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
use CommerceLabShop\Order\Order;

$data = $displayData;


?>

<div class="uk-card uk-card-default uk-card-small uk-card-hover">
	<div class="uk-card-header">
		<div class="uk-grid uk-grid-small">
			<div class="uk-width-auto">
				<h4> <?= Text::_('COM_COMMERCELAB_SHOP_ORDER_STATS'); ?> <i class="fas fa-shopping-cart"></i></h4>
			</div>
			<div class="uk-width-expand uk-text-right panel-icons">
			</div>
		</div>
	</div>
	<div class="uk-card-body">
		<div class="uk-grid uk-child-width-1-3@s uk-child-width-1-2@m uk-child-width-1-4@l uk-grid-small" uk-grid>
			<?php foreach ($data['orderStats'] as $orderStat): ?>
				<div>
					<?php if ($orderStat['status'] != 't') : ?>
					<a class="color-panel-link" href="index.php?option=com_commercelab_shop&view=orders&preFilter=<?= strtoupper($orderStat['status']); ?>">
					<?php endif; ?>
						<div class="uk-text-center colour-panel colour-panel-<?= $orderStat['status']; ?>">
							<h5><?= $orderStat['title']; ?></h5>
							<h2><?= $orderStat['count']; ?></h2>
						</div>
					<?php if ($orderStat['status'] != 't') : ?>
					</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
