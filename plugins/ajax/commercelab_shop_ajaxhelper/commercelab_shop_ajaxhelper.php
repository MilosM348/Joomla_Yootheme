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


// error_reporting(0);

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Response\JsonResponse;


class plgAjaxCommercelab_shop_ajaxhelper extends JPlugin
{

	private $db;
	private $app;
	private $input;


	/**
	 * @throws Exception
	 * @since 2.0
	 */
	public function onAjaxCommercelab_shop_ajaxhelper()
	{

		// init vars
		$this->app   = Factory::getApplication();
		$this->db    = Factory::getDbo();
		$this->input = $this->app->input;

		// Get the task type and validate if required
		$taskType        = $this->input->getString('type');
		$taskType        = explode('.', $taskType);

		// Tasks within this array will require a valid Token - Only Order is active for now as it has a major risk of changing the orders to valid => payed
		// TODO We need to test all possible tasks, as if we enable them right now there is a chance some ajax calls will stop working
		$tokenized_tasks = [
			// 'orders', 
			'order', 
			// 'product', 
			// 'products', 
			// 'shop',
			// 'shops',
		];

		// Check if user token is valid.
		if (in_array($taskType[0], $tokenized_tasks) && !Session::checkToken())
		{
			return new JsonResponse('ko', Text::_('JINVALID_TOKEN'), true);
			Factory::getApplication()->close();
		}


		// get task
		$task = $this->input->getString('task');

		// call function based on specified task.
		// all functions must return new JsonResponse.

		switch ($task)
		{
			case 'task':
				return $this->_initTask();
			case 'upload':
				return $this->_upload();

		}

		return new JsonResponse('ko', Text::_('Task was not Performed'), true);
	}

	/**
	 *
	 * function _initTask()
	 *
	 * Ajax handler for running the specified task
	 *
	 *
	 * @return JsonResponse
	 * @throws Exception
	 * @since 1.0
	 */


	private function _initTask(): JsonResponse
	{

		//get the task and process it
		$taskType = $this->input->getString('type');
		$taskType = explode('.', $taskType);

		// check if there's a P2S plugin type specified to allow overrides
		$pluginType = $this->input->getString('pluginType');
		$pluginName = $this->input->getString('pluginName');

		// if there's an override specified... run it...
		if ($pluginType && $pluginName)
		{
			require_once JPATH_BASE . '/plugins/' . $pluginType . '/' . $pluginName . '/tasks/' . $taskType[0] . '/' . $taskType[1] . '.php';
		}
		else
		{

			//otherwise... just run the admin task

			require_once JPATH_ADMINISTRATOR . '/components/com_commercelab_shop/tasks/' . $taskType[0] . '/' . $taskType[1] . '.php';

		}
		$class = 'commercelab_shopTask_' . $taskType[1];


		$taskWorker = new $class();

		try
		{	
			$response = $taskWorker->getResponse($this->input);

			return new JsonResponse($response);
		}
		catch (Exception $e)
		{
			return new JsonResponse('ko', $e->getMessage(), true);
		}
	}

	private function _upload()
	{


		$md5_1 = md5(uniqid());
		$md5_2 = md5(uniqid());
		$md5_3 = md5(uniqid());
		$md5_4 = md5(uniqid());

		$path = $md5_1 . '/' . $md5_2 . '/' . $md5_3 . '/' . $md5_4;

		$file = $this->input->files->get('files');
		$file = $file[0];

		jimport('joomla.filesystem.file');
		$filename = File::makeSafe($file['name']);
		$src      = $file['tmp_name'];

		$dest = JPATH_SITE . '/images/' . $path . '/' . $filename;
		if (File::upload($src, $dest))
		{

			$response['uploaded']     = true;
			$response['path']         = $path;
			$response['relativepath'] = $path . '/' . $filename;
			$response['dest']         = $dest;

			// now update the database for this item

//			$object = new stdClass();
//			$object->id = 0;
//			$object->product_id = $this->input->getInt('productid');
//			$object->filename = $filename;
//			$object->filename_obscured = $response['path'];
//			$object->isjoomla = $this->input->get('isjoomla');
//			$object->version = $this->input->get('version');
//			$object->type = $this->input->get('type');
//			$object->stability_level = $this->input->get('stability_level');
//			$object->php_min = $this->input->get('php_min');
//			$object->download_access = $this->input->get('download_access');
//			$object->published = $this->input->get('published');
//			$object->created = \CommerceLabShop\Utilities\Utilities::getDate();
//
//			$result = Factory::getDbo()->updateObject('#__commercelab_shop_product_file', $object, 'id');
//
//			if($result) {
//				$response['dbupdated'] = true;
//			}

			return new JsonResponse($response, 'Uploaded');
		}
		else
		{
			return new JsonResponse('', '', 'Unable to upload file');
		}


	}


}


