<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */
// no direct access


defined('_JEXEC') or die('Restricted access');

use CommerceLabShop\Coupon\CouponFactory;


class commercelab_shopTask_apply
{

	/**
	 * @throws Exception
	 * @since 2.0
	 */
	public function getResponse($data)
	{

		// init
		$response = array();

		$couponCode = $data->json->get('couponCode');

		if ($couponCode)
		{
			$applied = CouponFactory::apply($couponCode);
			if ($applied)
			{
				$response['applied'] = $applied;
			}
			else
			{
				throw new Exception('Error Applying Coupon');
			}

		}
		else
		{
			throw new Exception('no coupon code');
		}


		return $response;
	}

}
