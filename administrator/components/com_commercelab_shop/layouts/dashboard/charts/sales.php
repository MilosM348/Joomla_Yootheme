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
				<h4><?= Text::_('COM_COMMERCELAB_SHOP_SALES_CHART'); ?></h4>
			</div>
			<div class="uk-width-expand uk-text-right panel-icons">
			</div>
		</div>
	</div>
	<div class="uk-card-body">
		<div>
			<div class="chartjs-size-monitor">
				<div class="chartjs-size-monitor-expand">
					<div class=""></div>
				</div>
				<div class="chartjs-size-monitor-shrink">
					<div class=""></div>
				</div>
			</div>
			<canvas id="product_sales_chart" style="width: 100%; height: 350px;"></canvas>
		</div>
	</div>
</div>

<script>

    var product_sales_chart = document.getElementById('product_sales_chart').getContext('2d');
    var myProduct_sales_chart = new Chart(product_sales_chart, {
        type: 'line',
        data: {
            labels: <?= json_encode($data['months']); ?>,
            datasets: [
                {
                    label: "<?= Text::sprintf('COM_COMMERCELAB_SHOP_TOTAL_SALES_VALUE', $data['currencysymbol']); ?>",
                    data: <?= json_encode($data['monthsSales']); ?>,
                    borderColor: '#84d182',
                    tension: 0.5
                }
            ]
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return '<?= $data['currencysymbol']; ?>' + Intl.NumberFormat().format((value));
                        }
                    }
                }
            }
        }
    });

</script>
