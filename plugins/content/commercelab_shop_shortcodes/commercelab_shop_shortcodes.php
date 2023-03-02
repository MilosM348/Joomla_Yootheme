<?php
/**
 * @package     CommerceLab Shop - Shortcodes
 *
 * @copyright   Copyright (C) 2021 Cloud Chief - CommerceLab Shop. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

use CommerceLabShop\Order\Order;
use CommerceLabShop\Order\OrderedProduct;
use CommerceLabShop\Order\OrderFactory;

class PlgContentCommercelab_shop_shortcodes extends JPlugin
{


	/**
	 * @var $order Order
	 * @since 2.0
	 */
	private $order;


	/**
	 * Plugin that loads CommerceLab Shop snippets within content
	 *
	 * @param   string    $context  The context of the content being passed to the plugin.
	 * @param   object   &$article  The article object.  Note $article->text is also available
	 * @param   mixed    &$params   The article params
	 * @param   integer   $page     The 'page' number
	 *
	 * @return  mixed   true if there is an error. Void otherwise.
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// Don't run this plugin when the content is being indexed
		if ($context === 'com_finder.indexer')
		{
			return true;
		}


		// Simple performance check to determine whether bot should process further
		if (strpos($article->text, 'commercelab_shop_') === false)
		{
			return true;
		}


		// Expression to search for (positions)
		$regex = '/{commercelab_shop_(.*?)}/i';


		// Find all instances of plugin and put in $matches for loadposition
		// $matches[0] is full pattern match, $matches[1] is the position
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);

		// No matches, skip this
		if ($matches)
		{

			//ok there are matches... let's access the cookie.
			if ($this->order = $this->getOrder())
			{
				foreach ($matches as $match)
				{

					$output = $this->render($match[0]);

					// We should replace only first occurrence in order to allow positions with the same name to regenerate their content:
					if (($start = strpos($article->text, $match[0])) !== false)
					{
						$article->text = substr_replace($article->text, $output, $start, strlen($match[0]));
					}

				}
			}


		}

	}


	/**
	 * @throws Exception
	 * @since 2.0
	 */
	private function getOrder(): ?Order
	{
		$hash = Factory::getApplication()->input->get('confirmation');

		if (is_null($hash))
		{
			return null;
		}

		return OrderFactory::getOrderByHash($hash);

	}
	

	private function render($shortcode)
	{

		if (isset($this->order))
		{


			switch ($shortcode)
			{
				case '{cls_order_number}':
					return $this->order->order_number;
				case '{cls_order_total}':
					return $this->order->order_total;
				case '{cls_order_discount_total}':
					return $this->order->discount_total_formatted;
				case '{cls_customer_name}':
					return $this->order->customer_name;
				case '{cls_customer_address}':
					return $this->order->billing_address;
				case '{cls_customer_email}':
					return $this->order->customer_email;
				case '{cls_product_list_table}':
					return $this->getProductTable();
				case '{cls_payment_type}':
					return $this->order->payment_method;
				default:
					return '';
			}

		}


	}


	private function getProductTable()
	{

		$html = array();

		$html[] = '<table class="uk-table uk-table-striped"><tbody>';

		/** @var $product OrderedProduct $product */
		foreach ($this->order->ordered_products as $product)
		{
			$html[] = '<tr>';
			$html[] = '<td>' . $product->j_item_name . '</td>';
			$html[] = '<td> x' . $product->amount . '</td>';
			$html[] = '<td>' . $product->price_at_sale_formatted . '</td>';
			$html[] = '</tr>';
		}

		$html[] = '</tbody></table>';

		return implode('', $html);

	}


}
