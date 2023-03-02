<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace CommerceLabShop\MediaManager;

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Uri\Uri;
use Joomla\Input\Input;
use Joomla\CMS\Plugin\PluginHelper;
use stdClass;

class MediaManagerFactory
{


	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getFolderTree(): array
	{

		// workaround ... create the base images folder
		$imagesFolder = array();

		$imagesFolder['id']       = 0;
		$imagesFolder['name']     = 'images';
		$imagesFolder['relname']  = '/images';
		$imagesFolder['parent']   = -1;
		$imagesFolder['fullname'] = JPATH_SITE . '/images';
		$imagesFolder['images']   = self::addImagesToFolder($imagesFolder);

		$folders = Folder::listFolderTree(JPATH_SITE . '/images/', '.', 100);

		foreach ($folders as &$folder)
		{
			$folder['images'] = self::addImagesToFolder($folder);
		}

		// add the base images folder
		$folders[] = $imagesFolder;

		return $folders;
	}

	/**
	 * @param   string  $folderName
	 *
	 *
	 * @return mixed
	 * @since 2.0
	 */

	public static function getFolderByName(string $folderName): array
	{


		$response = array();

		$folderTreeList = Folder::listFolderTree(JPATH_SITE . '/images/', '.', 100);

		foreach ($folderTreeList as $folder)
		{
			if ($folder['name'] === $folderName)
			{
//				$response = self::addImagesToFolder($folder);
			}
		}

		return $response;

	}

	/**
	 *
	 * @return array
	 *
	 * @since 2.0
	 */


	public static function getHomePath(): array
	{
		$response = array();

		$folderTreeList = Folder::listFolderTree(JPATH_SITE, '.', 1, 0);

		foreach ($folderTreeList as $folder)
		{
			if ($folder['name'] === 'images')
			{
				$folder['id'] = 0;
//				$response     = self::addImagesToFolder($folder);
			}
		}

		return $response;


	}

	/**
	 * @param   array  $folder
	 *
	 * @return array
	 *
	 * @since 2.0
	 */

	private static function addImagesToFolder(array $folder): ?array
	{

		$path = JPATH_SITE . $folder['relname'];

		$theImages = array();

		if (file_exists($path == false))
		{
			return null;
		}
		else
		{

			$exclude       = array('.svn', 'CVS', '.DS_Store', '__MACOSX', '.txt');
			$excludeFilter = array('^\..*');

			$files = Folder::files($path, '.', false, false, $exclude, $excludeFilter);

			foreach ($files as $file)
			{
				$theFile              = [];

				$full_image_path = $folder['fullname'] . '/' . $file;

				list($width, $height, $type, $attributes) 
									  = getimagesize($full_image_path);

				$theFile['name']      = $file;
				$theFile['relname']   = $folder['relname'] . '/' . $file;
				$theFile['fullname']  = $full_image_path;
				$theFile['link']      = str_replace('\\', '/', Uri::root() . $folder['relname'] . '/' . $file);
				$theFile['folder_id'] = $folder['id'];
				$theFile['width']     = $width;
				$theFile['height']    = $height;
				$theFile['modified']  = filemtime($full_image_path);

				$theImages[] = $theFile;

			}

			if ($theImages)
			{
				return $theImages;
			}
			else
			{
				return null;
			}


		}


	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function editName(Input $data): bool
	{

		$image    = $data->json->get('image', '', 'ARRAY');
		$new_name = $data->json->getString('new_name');
		$new_name = File::makeSafe($new_name);
		$path     = self::removeFilename($image['fullname']);

		$dst = $path . '/' . $new_name;

		if (File::exists($dst))
		{
			return false;
		}

		if (File::copy($image['fullname'], $dst))
		{
			if (File::delete($image['fullname']))
			{
				return true;
			}
		}

		return false;


	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function editFolderName(Input $data): bool
	{

		$folder   = $data->json->get('folder', '', 'ARRAY');
		$new_name = $data->json->getString('new_name');
		$new_name = Folder::makeSafe($new_name);
		$path     = dirname($folder['fullname'], 1);
		$dst      = $path . '/' . $new_name;


		if (Folder::exists($dst))
		{
			return false;
		}

		if (Folder::copy($folder['fullname'], $dst))
		{
			if (Folder::delete($folder['fullname']))
			{
				return true;
			}
		}

		return false;


	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function trashSelected(Input $data): bool
	{

		$folders = $data->json->get('folders', '', 'ARRAY');
		$images  = $data->json->get('images', '', 'ARRAY');

		foreach ($folders as $folder)
		{
			if (Folder::exists($folder['fullname']))
			{
				Folder::delete($folder['fullname']);
			}
		}
		foreach ($images as $image)
		{
			if (File::exists($image['fullname']))
			{
				File::delete($image['fullname']);
			}
		}

		return true;

	}

	/**
	 * @param   Input  $data
	 *
	 *
	 * @return bool
	 * @since 2.0
	 */

	public static function addFolder(Input $data): bool
	{

		$name             = $data->json->getString('name');
		$name             = Folder::makeSafe($name);
		$currentDirectory = $data->json->get('currentDirectory', '', 'ARRAY');


		if (Folder::create($currentDirectory['fullname'] . '/' . $name))
		{
			return true;
		}

		return false;

	}

	/**
	 * @param   Input  $data
	 *
	 * @return bool
	 *
	 * @since 2.0
	 */


	public static function uploadImage(Input $data)
    {
		$folder         = $data->getString('directory');
		$images         = $data->json->files->get('image');
		$add_to_gallery = $data->json->files->get('addToGallery', false);
		
        if (!empty($images))
        {

            $i = 0;
            $path = [];

            foreach ($images as $image)
            {
                $filename = File::makeSafe($image['name']);
                $filename = str_replace(' ', '_', $filename);
                $src      = $image['tmp_name'];
                $dest     = $folder . '/' . $filename;

                if (!File::upload($src, $dest))
                {
                    return false;
                }

                $path[$i]= $filename;
                $i++;
            }

            if (!$add_to_gallery)
            {
            	return $path;
            }

            // $itemid = $data->get('itemid');
            // PluginHelper::importPlugin('system');
			// $payload         = new stdClass();
			// $payload->itemid = $itemid;
			// $payload->images = $path;
			// $data            = Factory::getApplication()->triggerEvent('onsavegallery', array($payload));

			if (!empty($data))
			{
				return $data;	
			}
			else
			{
				return true;
			}
        }
	}

	/**
	 * @param   string  $path
	 *
	 * @return array|string|string[]
	 *
	 * @since 2.0
	 */

	private static function removeFilename(string $path)
	{
		$file_info = pathinfo($path);

		return isset($file_info['extension'])
			? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $path)
			: $path;
	}

	public static function addgalleryImg(Input $data)
	{
		$images = $data->json->getString('images');
		$paths  = $data->json->get('paths', [], 'ARRAY');

        if (!empty($images)){
            // $i = 0;
            // $path = array();
            // foreach ($images as $image)
            // {
            //     $path[$i]= $image;
            //     $i++;
            // }
            $itemid = $data->json->get('itemid');
            PluginHelper::importPlugin('system');
			$payload         = new stdClass();
			$payload->itemid = $itemid;
			$payload->images = $images;
			$payload->paths  = $paths;

            $data = Factory::getApplication()->triggerEvent('onsavegallery', [$payload]);

			if (!empty($data))
			{
				return $data;	
			}
			else
			{
				return true;
			}
		}
	}


}
