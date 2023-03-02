////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const {copy, remove, exists, mkdir, readFile, emptyDir, writeFile, outputFile} = require('fs-extra');
const util = require('util');
// const path = require('path');
// const fs = require('fs');
const stringreplace = require('replace-in-file');
const rimRaf = util.promisify(require('rimraf'));
const find = require('find');
const {version} = require('../package.json');

(async function exec() {
    await rimRaf('./dist/componentlite');
    await rimRaf('./build/output/');

    //set up the output folders
    if (!(await exists('./build/output'))) {
        await mkdir('./build/output');
    }

    if (!(await exists('./build/output/package'))) {
        await mkdir('./build/output/package');
    }
    if (!(await exists('./build/output/package/packages'))) {
        await mkdir('./build/output/package/packages');
    }


    // component
    if (!(await exists('./build/output/the_component_folder'))) {
        await mkdir('./build/output/the_component_folder');
    }
    // create the directories for the component
    if (!(await exists('./build/output/the_component_folder/admin'))) {
        await mkdir('./build/output/the_component_folder/admin');
    }
    if (!(await exists('./build/output/the_component_folder/site'))) {
        await mkdir('./build/output/the_component_folder/site');
    }
    if (!(await exists('./build/output/the_component_folder/media'))) {
        await mkdir('./build/output/the_component_folder/media');
    }
    // insert the version number in the component XML
    let xmla = await readFile('./build/packagefiles/component/commercelab_shop.xml', {encoding: 'utf8'});
    xmla = xmla.replace(/{{version}}/g, version);

    // write the XML for the component
    await writeFile('./build/output/the_component_folder/commercelab_shop.xml', xmla, {encoding: 'utf8'});


    // copy over the code from the administrator folder, media folder and site folder.
    await copy('./administrator/components/com_commercelab_shop', './build/output/the_component_folder/admin');
    await copy('./components/com_commercelab_shop', './build/output/the_component_folder/site');
    await copy('./media/com_commercelab_shop', './build/output/the_component_folder/media');


    // clean out Materio
    await rimRaf('./build/output/the_component_folder/admin/materio/theme_main');

    // clean out GIT
    await remove('./build/output/the_component_folder/admin/.git');


 
    // copy over language files
    if (!(await exists('./build/output/the_component_folder/admin/language'))) {
        await mkdir('./build/output/the_component_folder/admin/language');
    }

    if (!(await exists('./build/output/the_component_folder/admin/language/en-GB'))) {
        await mkdir('./build/output/the_component_folder/admin/language/en-GB');
    }

    if (!(await exists('./build/output/the_component_folder/admin/language/de-DE'))) {
        await mkdir('./build/output/the_component_folder/admin/language/de-DE');
    }

    if (!(await exists('./build/output/the_component_folder/admin/language/it-IT'))) {
        await mkdir('./build/output/the_component_folder/admin/language/it-IT');
    }

    if (!(await exists('./build/output/the_component_folder/admin/language/nl-NL'))) {
        await mkdir('./build/output/the_component_folder/admin/language/nl-NL');
    }

    if (!(await exists('./build/output/the_component_folder/admin/language/pt-PT'))) {
        await mkdir('./build/output/the_component_folder/admin/language/pt-PT');
    }

    await copy('./administrator/language/en-GB/com_commercelab_shop.ini', './build/output/the_component_folder/admin/language/en-GB/com_commercelab_shop.ini');
    await copy('./administrator/language/en-GB/com_commercelab_shop.sys.ini', './build/output/the_component_folder/admin/language/en-GB/com_commercelab_shop.sys.ini');

    await copy('./administrator/language/en-GB/com_commercelab_shop.ini', './build/output/the_component_folder/admin/language/en-GB/com_commercelab_shop.ini');
    await copy('./administrator/language/en-GB/com_commercelab_shop.ini', './build/output/the_component_folder/admin/language/de-DE/com_commercelab_shop.ini');
    await copy('./administrator/language/en-GB/com_commercelab_shop.ini', './build/output/the_component_folder/admin/language/it-IT/com_commercelab_shop.ini');
    await copy('./administrator/language/en-GB/com_commercelab_shop.ini', './build/output/the_component_folder/admin/language/nl-NL/com_commercelab_shop.ini');
    await copy('./administrator/language/en-GB/com_commercelab_shop.ini', './build/output/the_component_folder/admin/language/pt-PT/com_commercelab_shop.ini');

    let zip = new (require('adm-zip'));
    zip.addLocalFolder('./build/output/the_component_folder', false);
    zip.writeZip(`./build/output/package/packages/com_commercelab_shop.zip`);
    zip.deleteFile(`./build/output/the_component_folder`);

    await rimRaf('./build/output/the_component_folder');

    /** COMPONENT DONE **/


    // // installer plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/installer/commercelab_shop', false);
    zip.writeZip(`./build/output/package/packages/plg_installer_commercelab_shop.zip`);

    /** INSTALLER PLUGIN DONE **/

    // // system plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/system/commercelab_shop', false);
    zip.writeZip(`./build/output/package/packages/plg_system_commercelab_shop.zip`);

    /** SYSTEM PLUGIN DONE **/


    // system emailer plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/commercelab_shop_system/emailer', false);
    zip.writeZip(`./build/output/package/packages/plg_commercelab_shop_system_emailer.zip`);

    /** SYSTEM EMAILER PLUGIN DONE **/


    // system shipping plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/commercelab_shop_shipping/defaultshipping', false);
    zip.writeZip(`./build/output/package/packages/plg_commercelab_shop_shipping_defaultshipping.zip`);


    // system taxes plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/commercelab_shop_taxes/coresystemtaxes', false);
    zip.writeZip(`./build/output/package/packages/plg_commercelab_shop_taxes_coresystemtaxes.zip`);

    // Animation plugin for menu

    /*zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/system/commercelab_shop_animation', false);
    zip.writeZip(`./build/output/package/packages/plg_system_commercelab_shop_animation.zip`);   */

    /** SYSTEM SHIPPING PLUGIN DONE **/
    // Paypal Payment Plugin

    // zip = new (require('adm-zip'));
    // zip.addLocalFolder('./plugins/commercelab_shop_payment/paypal', false);
    // zip.writeZip(`./build/output/package/packages/plg_commercelab_shop_payment_paypal.zip`); 
    
    // zip = new (require('adm-zip'));
    // zip.addLocalFolder('./plugins/system/commercelab_shop_paypal', false);
    // zip.writeZip(`./build/output/package/packages/plg_system_commercelab_shop_paypal.zip`);   

    // Stripe Payment

    // zip = new (require('adm-zip'));
    // zip.addLocalFolder('./plugins/commercelab_shop_payment/stripepayment', false);
    // zip.writeZip(`./build/output/package/packages/plg_commercelab_shop_payment_stripepayment.zip`);

    // zip = new (require('adm-zip'));
    // zip.addLocalFolder('./plugins/system/commercelab_shop_stripepayment', false);
    // zip.writeZip(`./build/output/package/packages/plg_system_commercelab_shop_stripepayment.zip`);   
    

    // offlinepay plugins
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/commercelab_shop_payment/offlinepay', false);
    zip.writeZip(`./build/output/package/packages/plg_commercelab_shop_payment_offlinepay.zip`);


    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/system/commercelab_shop_offlinepay', false);
    zip.writeZip(`./build/output/package/packages/plg_system_commercelab_shop_offlinepay.zip`);

    /** OFFLINE PAY PLUGINS DONE **/


    // Content plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/content/commercelab_shop_fields', false);
    zip.writeZip(`./build/output/package/packages/plg_content_commercelab_shop_fields.zip`);


    //
    // Content plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/content/commercelab_shop_shortcodes', false);
    zip.writeZip(`./build/output/package/packages/plg_content_commercelab_shop_shortcodes.zip`);
    /** CONTENT PLUGINS DONE **/

    // User plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/user/commercelab_shop', false);
    zip.writeZip(`./build/output/package/packages/plg_user_commercelab_shop.zip`);

    /** USER PLUGIN DONE **/

    // IO plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/commercelab_shop_extended/io', false);
    zip.writeZip(`./build/output/package/packages/plg_commercelab_shop_extended_io.zip`);

    // Quickicon plugin
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/quickicon/commercelab_shop', false);
    zip.writeZip(`./build/output/package/packages/plg_quickicon_commercelab_shop.zip`);

    /** USER PLUGIN DONE **/


        // sort out AJAX plugin
    const replaceErrorReporting = {
            files: './plugins/ajax/commercelab_shop_ajaxhelper/commercelab_shop_ajaxhelper.php',
            from: /\/\/ error_reporting\(0\);/g,
            to: 'error_reporting(0);',
        };

    try {
        const results = await stringreplace(replaceErrorReporting)
        console.log('Replacement results:', results);
    } catch (error) {
        console.error('Error occurred:', error);
    }

    // ajax helper
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./plugins/ajax/commercelab_shop_ajaxhelper', false);
    zip.writeZip(`./build/output/package/packages/plg_ajax_commercelab_shop_ajaxhelper.zip`);


    const replaceErrorReportingBackToDev = {
        files: 'plugins/ajax/commercelab_shop_ajaxhelper/commercelab_shop_ajaxhelper.php',
        from: /error_reporting\(0\);/g,
        to: '// error_reporting(0);',
    };

    try {
        const results = await stringreplace(replaceErrorReportingBackToDev)
        console.log('Replacement results:', results);
    } catch (error) {
        console.error('Error occurred in replacing error reporting replacement:', error);
    }

    /** AJAX PLUGIN DONE **/


    /** MODULES **/


    // cart module
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./modules/mod_commercelab_shop_cart', false);
    zip.writeZip(`./build/output/package/packages/mod_commercelab_shop_cart.zip`);

    // cart Fab module
   /* Comment on 05March2022 const zip6fab = new (require('adm-zip'));
    zip6fab.addLocalFolder('modules/mod_commercelab_shop_cartfab', false);
    zip6fab.writeZip(`./build/output/package/packages/mod_commercelab_shop_cartfab.zip`);*/


    // currency switcher module
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./modules/mod_commercelab_shop_currencyswitcher', false);
    zip.writeZip(`./build/output/package/packages/mod_commercelab_shop_currencyswitcher.zip`);


    // Customer Addresses module
    const zip8e = new (require('adm-zip'));
    zip8e.addLocalFolder('modules/mod_commercelab_shop_customeraddresses', false);
    zip8e.writeZip(`./build/output/package/packages/mod_commercelab_shop_customeraddresses.zip`);

    // Customer Orders module
    const zip8f = new (require('adm-zip'));
    zip8f.addLocalFolder('modules/mod_commercelab_shop_customerorders', false);
    zip8f.writeZip(`./build/output/package/packages/mod_commercelab_shop_customerorders.zip`);


    await rimRaf('./build/output/package/commercelab_shop.xml');

    await copy('./build/packagefiles/pkg_commercelab_shop_lite.xml', './build/output/package/pkg_commercelab_shop.xml');
    await copy('./build/packagefiles/script.php', './build/output/package/script.php');

    if (!(await exists('./dist/componentlite'))) {
        await mkdir('./dist/componentlite');
    }

    let xml = await readFile('./build/output/package/pkg_commercelab_shop.xml', {encoding: 'utf8'});
    xml = xml.replace(/{{version}}/g, version);

    await writeFile('./build/output/package/pkg_commercelab_shop.xml', xml, {encoding: 'utf8'});


    // Package it
    zip = new (require('adm-zip'));
    zip.addLocalFolder('./build/output/package', false);
    zip.writeZip(`dist/componentlite/pkg_commercelab_shop_Lite_${version}.zip`);

    await rimRaf('./build/output');


})();
