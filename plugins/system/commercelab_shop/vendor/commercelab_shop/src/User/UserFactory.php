<?php

/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

// no direct access

namespace CommerceLabShop\User;

defined('_JEXEC') or die('Restricted access');


use Joomla\CMS\Uri\Uri;
use Joomla\Input\Input;
use Joomla\CMS\Factory;
use Joomla\CMS\Version;
use Joomla\CMS\Date\Date;
use Joomla\CMS\User\User;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\User\UserHelper;
use Joomla\CMS\String\PunycodeHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Application\ApplicationHelper;

use CommerceLabShop\Language\LanguageFactory;

use Exception;
use RuntimeException;
use stdClass;


class UserFactory
{


	/**
	 * @param   Input  $data
	 *
	 * @return array
	 *
	 * @throws Exception
	 * @since 2.0
	 */
	public static function login(Input $data)
	{

		LanguageFactory::load();


		// init var
		$response = [];
		$app      = Factory::getApplication();

		// get Session id in local variable
		$oldSession = Factory::getSession()->getId();

		if (Factory::getUser()->get('guest') != 1)
		{

			$string                 = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALREADY_LOGGED_IN');
			$response['message']    = $string;
			$response['error']      = $string;
			$response['status']     = 'ko';
			$response['errorsList'] = [$string];

			return $response;

		}

		//  validate username and password - both are required

		$enteredUsername = $data->json->getString('username');

		if ($enteredUsername == '')
		{
			return false;
		}

		$enteredPassword = $data->json->getString('password');

		if ($enteredPassword == '')
		{
			return false;
		}


		$credentials             = [];
		$credentials['username'] = $data->json->getString('username');
		$credentials['password'] = $data->json->getString('password');

		$options           = [];
		$options['silent'] = true;

		if ($app->login($credentials, $options) === true)
		{
			$user   = Factory::getUser();
			$userid = $user->get('id');
			if ($userid == 0)
			{
				$string                 = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_NOT_ENABLED');
				$response['message']    = $string;
				$response['error']      = $string;
				$response['status']     = 'ko';
				$response['errorsList'] = [$string];


				return $response;
			}
			else
			{
				// Success
				$response['status']     = 'ok';
				$response['userid']     = $userid;
				$response['username']   = $user->get('username');
				$response['session_id'] = Factory::getSession()->getId();
				$response['message']    = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_SUCCESSFULLY_LOGGED_IN');

				return $response;
			}
		}
		else
		{
			$string = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_LOGIN_FAILED');
			// Login failed
			$response['message']    = $string;
			$response['error']      = $string;
			$response['status']     = 'ko';
			$response['errorsList'] = [$string];

			return $response;
		}

	}

	/**
	 * @param   Input  $data
	 *
	 * @return array
	 *
	 * @throws Exception
	 * @since 2.0
	 */


	public static function register(Input $data)
	{

		LanguageFactory::load();

		$app = Factory::getApplication();

		$username = $data->json->getString('username');
		if (is_null($username))
		{
			$response['error']      = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_USERNAME_REQUIRED'); // Username required
			$response['status']     = 'ko';
			$response['statuscode'] = 0;
			$response['errorsList'] = [Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_USERNAME_REQUIRED')];

			return $response;
		}
		$password = $data->json->getString('password');
		if (is_null($password))
		{
			$response['error']      = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_PASSWORD_REQUIRED'); // Password required
			$response['status']     = 'ko';
			$response['statuscode'] = 1;
			$response['errorsList'] = [Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_CHOOSE_A_PASSWORD_REQUIRED')];

			return $response;
		}
		$email = $data->json->getString('email');
		if (is_null($email))
		{
			$response['error']      = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_YOUR_EMAIL_REQUIRED'); // Email required
			$response['status']     = 'ko';
			$response['statuscode'] = 2;
			$response['errorsList'] = [Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_YOUR_EMAIL_REQUIRED')];

			return $response;
		}

		$email_puny = PunycodeHelper::emailToPunycode($email);
		$name       = $data->json->getString('name');
		if ($name == '')
		{
			$response['error']      = 'Name required'; // Name required
			$response['status']     = 'ko';
			$response['statuscode'] = 3;
			$response['errorsList'] = ['Name required'];

			return $response;
		}

		$usersParams = ComponentHelper::getParams('com_users');
		if ($usersParams->get('allowUserRegistration'))
		{

			// Get the user data
			$userData              = [];
			$userData['name']      = $name;
			$userData['username']  = $username;
			$userData['email1']    = $email_puny;
			$userData['email2']    = $email_puny;
			$userData['password1'] = $password;
			$userData['password2'] = $password;


			// Fill email and password fields
			$userData['email']          = $email_puny;
			$userData['password']       = $userData['password1'];
			$userData['password_clear'] = $password;

			// Get the groups the user should be added to after registration.
			$userData['groups'] = array();

			// Get the default new user group, Registered if not specified.
			$usertype = $usersParams->get('new_usertype', 2);

			$userData['groups'][] = $usertype;

			// Get global user params
			$useractivation = $usersParams->get('useractivation');
			$sendpassword   = $usersParams->get('sendpassword');
			$mailtoadmin    = $usersParams->get('mail_to_admin');

			// Check user activation
			if ($useractivation === 0)
			{
				// No need activation
				$userData['block'] = 0;
			}
			else
			{
				if (($useractivation == 1) || ($useractivation == 2))
				{
					// Need activation
					$userData['block']      = 1;
					$userData['activation'] = ApplicationHelper::getHash(UserHelper::genRandomPassword());
				}
				else
				{
					// No need activation
					$userData['block'] = 0;
				}
			}


			$user = new User();
			if (!$user->bind($userData))
			{
				$response['error']      = 'Error during registration'; // Error during registration
				$response['status']     = 'ko';
				$response['statuscode'] = 4;
				$response['errorsList'] = ['Error during registration'];

				return $response;
			}

			if (!$user->save())
			{
				$error = $user->getError();
				if ($error == Text::_('JLIB_DATABASE_ERROR_USERNAME_INUSE'))
				{
					$response['error']      = 'Username already exists'; // Username already exists
					$response['statuscode'] = 5;
					$response['errorsList'] = ['Username already exists'];
				}
				elseif ($error == Text::_('JLIB_DATABASE_ERROR_EMAIL_INUSE'))
				{
					$response['error']      = 'Email already exists'; // Email already exists
					$response['statuscode'] = 6;
					$response['errorsList'] = ['Email already exists'];
				}
				else
				{
					$response['error']      = $error; // Error during registration
					$response['statuscode'] = 4;
					$response['errorsList'] = ['General Error'];
				}
				$response['status'] = 'ko';

				return $response;
			}


			// Handle account activation/confirmation emails
			if ($useractivation !== 0)
			{
				self::sendNotifications($userData, $useractivation, $sendpassword, $mailtoadmin);
				Factory::getApplication()->enqueueMessage(Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ACCOUNT_SUCCESSFULLY_CREATED'), 'message');
			}
			else
			{
				self::login($data);

			}

			$response['status']  = 'ok';
			$response['message'] = Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ACCOUNT_SUCCESSFULLY_CREATED');

			return $response;
		}
		else
		{
			$response['error']      = 'Registration not allowed'; // Registration not allowed
			$response['status']     = 'ko';
			$response['statuscode'] = 8;
			$response['errorsList'] = ['Registration not allowed'];

			return $response;
		}


	}

	/**
	 * @param $data
	 * @param $useractivation
	 * @param $sendpassword
	 * @param $mailtoadmin
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	private static function sendNotifications($data, $useractivation, $sendpassword, $mailtoadmin): bool
	{
		$sendresult = true;
		
		$language = Factory::getLanguage();
		$language->load('com_users', JPATH_SITE);
		
		$config = Factory::getConfig();
		$db     = Factory::getDbo();
		$query  = $db->getQuery(true);

		// Compile the notification mail values
		$data['fromname'] = $config->get('fromname');
		$data['mailfrom'] = $config->get('mailfrom');
		$data['sitename'] = $config->get('sitename');
		$data['siteurl']  = Uri::root();

		if ($useractivation > 0)
		{
			// Set the link to confirm the user email
			$uri              = Uri::getInstance();
			$base             = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
			$data['activate'] = $base . Route::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);
		}

		$emailSubject = str_replace(
			[
				'{NAME}',
				'{SITENAME}'
			],
			[
				$data['name'],
				$data['sitename']
			],
			Text::_('COM_USERS_EMAIL_ACCOUNT_DETAILS')
		);
		if ($sendpassword)
		{
			switch ($useractivation)
			{
				case 2:
					$emailBodyLABEL = 'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY';
					break;
				case 1:
					$emailBodyLABEL = 'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY';
					break;
				default:
					$emailBodyLABEL = 'COM_USERS_EMAIL_REGISTERED_BODY';
			}
			$emailBody = str_replace(
				[
					'{NAME}',
					'{SITENAME}',
					'{ACTIVATE}',
					'{SITEURL}',
					'{USERNAME}',
					'{PASSWORD_CLEAR}'
				],
				[
					$data['name'],
					$data['sitename'],
					$data['activate'],
					$data['siteurl'],
					$data['username'],
					$data['password_clear']
				],
				Text::_($emailBodyLABEL)
			);
		}
		else
		{
			switch ($useractivation)
			{
				case 2:
					$emailBodyLABEL = 'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY_NOPW';
					break;
				case 1:
					$emailBodyLABEL = 'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW';
					break;
				default:
					$emailBodyLABEL = 'COM_USERS_EMAIL_REGISTERED_BODY_NOPW';
			}
			$emailBody = str_replace(
				[
					'{NAME}',
					'{SITENAME}',
					'{ACTIVATE}',
					'{SITEURL}',
					'{USERNAME}'
				],
				[
					$data['name'],
					$data['sitename'],
					$data['activate'],
					$data['siteurl'],
					$data['username']
				],
				Text::_($emailBodyLABEL)
			);
		}

		// Send the registration email
		try
		{
			$return = Factory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);
			if ($return !== true) $sendresult = false;
		}
		catch (Exception $e)
		{
			$sendresult = false;
		}

		// Send Notification mail to administrators
		if (($useractivation < 2) && ($mailtoadmin == 1))
		{

			$emailSubject = str_replace(
				[
					'{NAME}',
					'{SITENAME}'
				],
				[
					$data['name'],
					$data['sitename']
				],
				Text::_('COM_USERS_EMAIL_ACCOUNT_DETAILS')
			);

			$emailSubject = str_replace(
				[
					'{NAME}',
					'{USERNAME}',
					'{SITEURL}'
				],
				[
					$data['name'],
					$data['username'],
					$data['siteurl']
				],
				Text::_('COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY')
			);

			// Get all admin users
			$query->clear()
				->select($db->quoteName(array('name', 'email', 'sendEmail')))
				->from($db->quoteName('#__users'))
				->where($db->quoteName('sendEmail') . ' = ' . 1);

			$db->setQuery($query);

			$status = true;
			try
			{
				$rows = $db->loadObjectList();
				if ($rows === null) $status = false;
			}
			catch (RuntimeException $e)
			{
				$status = false;
			}

			if ($status)
			{
				// Send mail to all superadministrators id
				foreach ($rows as $row)
				{
					$return = Factory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);
					if ($return !== true) $status = false;
				}
			}

			$sendresult = $sendresult && $status;
		}

		// Check for an error
		if (!$sendresult)
		{
			// Send a system message to administrators receiving system mails
			$db = Factory::getDbo();
			$query->clear()
				->select($db->quoteName(array('name', 'email', 'sendEmail', 'id')))
				->from($db->quoteName('#__users'))
				->where($db->quoteName('block') . ' = ' .  0)
				->where($db->quoteName('sendEmail') . ' = ' . 1);
			$db->setQuery($query);

			$status    = true;
			$sendEmail = 0;
			try
			{
				$sendEmail = $db->loadObjectList();
				if ($sendEmail === null) $status = false;
			}
			catch (RuntimeException $e)
			{
				$status = false;
			}

			if ($status)
			{
				if (count($sendEmail) > 0)
				{
					$jdate = new Date;

					Factory::getLanguage()->load('com_users', JPATH_SITE);

					// Build the query to add the messages
					foreach ($sendEmail as $user)
					{
						$values = array($db->quote($user->id), $db->quote($user->id), $db->quote($jdate->toSql()), $db->quote(Text::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')), $db->quote(Text::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', Text::_('PLG_JBACKEND_USER_MAIL_SEND_FAILURE_BODY_MSG'), $data['username'])));
						$query->clear()
							->insert($db->quoteName('#__messages'))
							->columns($db->quoteName(array('user_id_from', 'user_id_to', 'date_time', 'subject', 'message')))
							->values(implode(',', $values));
						$db->setQuery($query);

						try
						{
							$db->execute();
						}
						catch (RuntimeException $e)
						{
							break;
						}
					}
				}
			}

		}

		return $sendresult;
	}

	public static function getActiveUser()
	{


		// use YOOtheme;
		// use YOOtheme\Config;
		// use function YOOtheme\app;

		// $config = app(Config::class);

		// if ($config) {
		// 	$user = $config->get('user');
		// } else {
		// }

		if (Version::MAJOR_VERSION === 4) {
			$user = Factory::getApplication()->getIdentity();
		}

		if (Version::MAJOR_VERSION === 3) {
			$user = Factory::getUser();
		}

		return $user;
		
	}

}
