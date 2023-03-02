
const {copySync, moveSync, mkdir, readFile, writeFile, outputFile, outputFileSync, ensureDirSync} = require('fs-extra');
const {
    readdirSync, 
    readFileSync, 
    rmdirSync, 
    rmSync, 
    mkdirSync, 
    existsSync,
    writeFileSync,
    unlinkSync
} = require('fs')

const {addons}        = require('./addons/manifest.json');

const base_path       = './build/addons/';
const build_path      = './dist/addons/';

(async function exec() {

    // Empty Dist Addons
    if (existsSync(build_path)) {
        rmSync(build_path, { 
            recursive: true }
        );
    }

    mkdirSync(build_path, {
        recursive: true 
    });

    Object.values(addons).forEach((addon) => {

        const version = addon.version;

        // ======== Build Packages ========== //

        if (addon.type == 'package') {
            Object.values(addon.packages).forEach(package => {

                // Prepare Directories for Build
                if (existsSync(build_path + addon.name + '/' + package.name)) {
                    rmSync(build_path + addon.name + '/' + package.name, { 
                        recursive: true }
                    );
                }

                mkdirSync(build_path + addon.name + '/' + package.name, {
                    recursive: true 
                });

                // Copy Original Data
                copySync(
                    package.path, 
                    build_path + addon.name + '/' + package.name
                );

                // Update packages versioins
                let xml = readFileSync(base_path + addon.name + '/' + package.manifest +'.xml', 'utf8');
                xml     = xml.replace(/{{version}}/g, version);

                writeFileSync(
                    build_path + addon.name + '/' + package.name +  '/' + package.manifest + '.xml', 
                    xml
                );

                // Zip packages
                zip = new (require('adm-zip'));
                zip.addLocalFolder(build_path +   addon.name + '/' + package.name, false);
                zip.writeZip(build_path +   addon.name + '/' + package.name + '.zip');

                // Remove Temporary directories
                rmSync(build_path + addon.name + '/' + package.name, { 
                    recursive: true }
                );

                // Crate Direcotry for packages within main package
                mkdirSync(build_path + addon.name + '/packages', {
                    recursive: true 
                });

                // Move Zipped packages
                moveSync(
                    build_path + addon.name + '/' + package.name + '.zip', 
                    build_path + addon.name + '/packages/' + package.name + '.zip'
                );

            });

            // ======= Creating Main Package =========== // 

            // Copy Main Package Manifest
            copySync(
                base_path + addon.name + '/script.php', 
                build_path + addon.name + '/script.php'
            );

            // Update Main Version
            let xml = readFileSync(base_path + addon.name + '/' + addon.name +'.xml', 'utf8');
            xml     = xml.replace(/{{version}}/g, version);

            writeFileSync(
                build_path + addon.name + '/' + addon.name +'.xml', 
                xml
            );


            // Build Main Package Zip
            zip = new (require('adm-zip'));
            zip.addLocalFolder(build_path +   addon.name, false);
            zip.writeZip(build_path +   addon.name + '_' + version + '.zip');

            // Remove Temp Main Package Directory
            rmSync(build_path +   addon.name, { 
                recursive: true }
            );

            console.log('Created', addon.name);
        }


        // ======== Build Stsyem Plugin ========== //
        if (addon.type == 'plg_system') {

            // Prepare Directories for Build
            if (existsSync(build_path + addon.name)) {
                rmSync(build_path + addon.name, { 
                    recursive: true }
                );
            }

            mkdirSync(build_path + addon.name, {
                recursive: true 
            });

            // Copy Original Data
            copySync(
                addon.path, 
                build_path + addon.name
            );

            // Copy Main Package Manifest
            copySync(
                base_path + addon.name + '/script.php', 
                build_path + addon.name + '/script.php'
            );

            // Update Main Version
            let xml = readFileSync(base_path + addon.name + '/' + addon.manifest +'.xml', 'utf8');
            xml     = xml.replace(/{{version}}/g, version);

            writeFileSync(
                build_path + addon.name + '/' + addon.manifest +'.xml', 
                xml
            );


            // Build Main Package Zip
            zip = new (require('adm-zip'));
            zip.addLocalFolder(build_path +   addon.name, false);
            zip.writeZip(build_path +   addon.name + '_' + version + '.zip');

            // Remove Temp Main Package Directory
            rmSync(build_path +   addon.name, { 
                recursive: true }
            );
            
            console.log('Created', addon.name);

        }


    });


})();
