<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\Cart;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;

use CommerceLabShop\User\UserFactory;
use CommerceLabShop\Utilities\Utilities;

/**
 *
 * Singleton to grab the current cart... it may be "anti-pattern" but it saves a TON of DB queries.
 *
 * @package     CommerceLabShop\Currency
 *
 * @since       2.0
 */
class CurrentCart
{
	// Hold the class instance.
	private static $instance = null;
	private $cart;


	/**
	 * @throws Exception
	 * @since 2.0
	 */

	private function __construct()
	{

		$db         = Factory::getDbo();
		$user       = UserFactory::getActiveUser();
		$cls_config = ComponentHelper::getParams('com_commercelab_shop');

		// now check if there is already a cart for this cookie
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__commercelab_shop_cart'));

		// if (!$cls_config->get('cart_persistence', 1)) {
		// 	$query->where($db->quoteName('created') . ' = ' . $db->quote($user->id));
		// }

		// Cart Not Processed
		$query->where($db->quoteName('state') . ' = ' . $db->quote(0));

		if ($user->guest)
		{
			$query->where($db->quoteName('cookie_id') . ' = ' . $db->quote(Utilities::getCookieID()));
		}
		else
		{
			$query->where($db->quoteName('user_id') . ' = ' . $db->quote($user->id));
		}

		$orderBy  = 'id';
		$orderDir = 'DESC';

		$query->order($orderBy . ' ' . $orderDir);

		$db->setQuery($query);
		// dd('$result', $query);

		$result = $db->loadObject();

		if ($result)
		{
			$this->cart = new Cart($result);
		}

		else
		{
			$this->cart = CartFactory::init();
		}

		return;
	}

	/**
	 *
	 * @return CurrentCart|null
	 *
	 * @since 2.0
	 */

	public static function getInstance(): ?CurrentCart
	{
		if (!self::$instance)
		{
			self::$instance = new CurrentCart();
		}

		return self::$instance;
	}

	/**
	 *
	 * @return Cart|null
	 *
	 * @since 2.0
	 */

	public function getCart(): ?Cart
	{
		$cart = $this->cart;
		return $cart;
	}
}
