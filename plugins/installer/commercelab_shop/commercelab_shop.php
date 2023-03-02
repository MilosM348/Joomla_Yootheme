<?php

defined('_JEXEC') || die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

use CommerceLabShop\Config\ConfigFactory;

// UrpUzvQrF3OzAC50KGM1clFULCJnUzepihee3IMM

class plgInstallerCommercelab_Shop extends CMSPlugin
{
    public function onInstallerBeforePackageDownload(&$url, &$headers)
    {
        $uri    = Uri::getInstance($url);
        $host   = $uri->getHost();
        $config = ConfigFactory::get();

        // it's not us
        if (in_array($host, [
            'app.commercelab.shop', 
            'install.commercelab.shop', 
            'update.commercelab.shop', 
            'validate.commercelab.shop', 
            'commercelab.solutions', 
            'stage.commercelab.solutions'
        ])) {

            // we already have a dlid
            if (!is_null($uri->getVar('dlid')) && trim($uri->getVar('dlid'))) {
                return;
            }

            $dlid = trim($config->get('subscription_key'));

            if (empty($dlid)) {

                // warn about missing api key
                JFactory::getApplication()->enqueueMessage(JText::_('You are missing a subscription Key'), 'notice');

            } else {

                $uri->delVar('dummy', '.zip');
                $uri->setVar('key', $dlid);

                // joomla enforces a check, the url must end in .zip
                $uri->setVar('dummy', '.zip');

                $url = $uri->toString();

            }

        }
        return true;
    }
}
























        // if (parse_url($url, PHP_URL_HOST) == 'yootheme.com' && !strpos($url, 'key=')) {

        //     // if ($key = $this->params->get('apikey')) {
        //     $clsubscription = ConfigFactory::getClSubscription(18);

        //     if ($clsubscription['status_show'] && $clsubscription['ytp_status']) {

        //         $key = $clsubscription['ytp_status'];

        //         $pos = strpos($url, '?');

        //         if ($pos === false) {
        //             $url .= "?key=$key";
        //         } else {
        //             $url = substr_replace($url, "?key=$key&", $pos, 1);
        //         }
        //     } else {

        //         // load default and current language
        //         $jlang = JFactory::getLanguage();
        //         $jlang->load('plg_installer_yootheme', JPATH_ADMINISTRATOR, 'en-GB', true);
        //         $jlang->load('plg_installer_yootheme', JPATH_ADMINISTRATOR, null, true);

        //         // warn about missing api key
        //         JFactory::getApplication()->enqueueMessage(JText::_('PLG_INSTALLER_YOOTHEME_API_KEY_WARNING'), 'notice');
        //     }

        // }