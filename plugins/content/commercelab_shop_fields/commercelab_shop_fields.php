<?php
/**
 * @package     CommerceLab Shop - Content Plugin
 * @subpackage  com_commercelab_shop
 *
 * @copyright   Copyright (C) 2022 CommerceLab - https://Commercelab.solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use CommerceLabShop\Utilities\Utilities;

use CommerceLabShop\Product\ProductFactory;


class plgContentCommercelab_shop_fields extends JPlugin
{
    /**
     * Load the language file on instantiation.
     * Note this is only available in Joomla 3.1 and higher.
     * If you want to support 3.0 series you must override the constructor
     *
     * @var boolean
     * @since <your version>
     */
    protected $autoloadLanguage = true;

    /**
     * Prepare form and add my field.
     *
     * @param JForm $form The form to be altered.
     * @param mixed $data The associated data for the form.
     *
     * @return  boolean
     *
     * @since   <your version>
     */

    function onContentBeforeDisplay($context, &$article, &$params) {
        $app = Factory::getApplication();
    }

    function onContentPrepareForm($form, $data)
    {
        $app = Factory::getApplication();
        $option = $app->input->get('option');


        switch ($option) {
            case 'com_content' :
                if ($app->isClient('administrator')) {

                    $articleid      = $app->input->get('id');

                    $value = ($this->checkIfProductExists($articleid) ? 1 : 0);

                    if ($data)
                    {
                        if (is_object($data))
                        {
                            $data->attribs['ispro2storeproduct'] = $value;
                        }
                        else
                        {
                            $data['attribs']['ispro2storeproduct'] = $value;
                        }
                    }

                    // Factory::getApplication()->enqueueMessage(json_encode($data), 'info');
                    $form->load('<form><fields name="attribs"><fieldset name="commercelab_shop" label="CLS On/Off"><field name="ispro2storeproduct" type="radio" default="' . $value . '" label="Set as CommerceLab Shop Product" description="" class="btn-group btn-group-yesno"><option value="1">JYES</option><option value="0">JNO</option></field></fieldset></fields></form>');

                    $customfield_id = $app->input->get('clscustomfield');

                    // Custom Field Edit
                    if ($customfield_id) {
                        $document = JFactory::getDocument();
                        $document->addScriptDeclaration('
                            jQuery(document).ready(function($) {
                                var customfieldEl = $("#fieldset-fields-' . $customfield_id .' .controls").clone(true);
                                $("#fieldset-fields-' . $customfield_id .' .controls").remove();
                                $("form").append(customfieldEl.html());
                            });
                        ');
                        $document->addStyleDeclaration('
                            form > div {
                                display: none !important;
                            }
                            // #fieldset-fields-' . $customfield_id .' .controls {
                            //     display: block !important;
                            // }
                        ');
                    }

                }

                return true;
        }

        return true;
    }

    function onContentAfterSave($context, $article, $isNew)
    {

        // make sure we're in Articles
        if ($context == 'com_content.article' 
            && Factory::getApplication()->input->get('p') != 'customizer' 
            && Factory::getApplication()->input->get('p') != 'page')
        {
       
            $db = Factory::getDbo();

            // check if this article is already a CommerceLab Shop Product
            // $dbProduct is the product object if true or simply false if not.
            $dbProduct = $this->checkIfProductExists($article->id);

            // get the article attribs
            $attribs = json_decode($article->attribs);

            // check if the article attribs are set to 1
            if ($attribs->ispro2storeproduct == 1)
            {

                if ($dbProduct)
                {
                    //if so: update it
                    // Do we need to update the product record from here?
                    $product     = new stdClass();
                    $product->id = $dbProduct->id;
                    $db->updateObject('#__commercelab_shop_product', $product, 'id');

                }
                else
                {
                    //if not: created it
                    $product                 = new stdClass();
                    $product->id             = 0;
                    $product->joomla_item_id = $article->id;
                    $product->base_price     = 0;
                    $product->short_desc     = $article->introtext;
                    $product->long_desc      = $article->fulltext;

                    $insert = $db->insertObject('#__commercelab_shop_product', $product);

                    if ($insert)
                    {
                        Factory::getApplication()->enqueueMessage('PRODUCT ADDED TO CommerceLab Shop', 'info');
                    }

                }


                // if "ispro2storeproduct" is set to 0
            } else {

                // if there was a CommerceLab Shop product associated, delete it.
                if ($dbProduct) {
                    $query = $db->getQuery(true);
                    $conditions = array(
                        $db->quoteName('joomla_item_id') . ' = ' . $db->quote($article->id)
                    );
                    $query->delete($db->quoteName('#__commercelab_shop_product'));
                    $query->where($conditions);
                    $db->setQuery($query);
                    $delete = $db->execute();

                    // if successful raise a message
                    if ($delete) {
                        Factory::getApplication()->enqueueMessage('PRODUCT DELETED FROM CommerceLab Shop', 'info');
                    }
                }

            }

        }


    }



    function onContentAfterDelete($context, $data)
    {

        // Delete CommerceLab Shop item if product is deleted in the content manager.

        $db    = Factory::getDbo();
        $query = $db->getQuery(true);

        $conditions = [
            $db->quoteName('joomla_item_id') . ' = ' . $db->quote($data->id)
        ];

        $query->delete($db->quoteName('#__commercelab_shop_product'))
            ->where($conditions);

        $db->setQuery($query)
            ->execute();


        // Also clear any items that are in carts
        $query = $db->getQuery(true);

        $conditions = [
            $db->quoteName('joomla_item_id') . ' = ' . $db->quote($data->id)
        ];

        $query->delete($db->quoteName('#__commercelab_shop_cart_item'))
            ->where($conditions);

        $db->setQuery($query)
            ->execute();


        return true;
    }

    private function checkIfProductExists($id)
    {
        if (is_null($id))
        {
            return false;
        }

        return ProductFactory::get($id);

        // $db = Factory::getDbo();
        // //check that product exists in CommerceLab Shop
        // $query = $db->getQuery(true);

        // $query->select('*');
        // $query->from($db->quoteName('#__commercelab_shop_product'));
        // $query->where($db->quoteName('joomla_item_id') . ' = ' . $db->quote($id));

        // $db->setQuery($query);

        // return $db->loadObject();
    }


}
