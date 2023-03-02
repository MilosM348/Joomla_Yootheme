////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const {remove, mkdir, emptyDir} = require('fs-extra');
const fs = require('fs');
const minify = require('@node-minify/core');
const terser = require('@node-minify/terser');

(async function exec() {

    console.clear()
    const timeElapsed = Date.now();
    const today = new Date(timeElapsed);
    const theTime = today.toUTCString();

    fs.readdir('vuefiles', (err, files) => {
        files.forEach(file => {
            let filename = file.replace(".js", "")
            emptyDir('./media/com_commercelab_shop/js/vue/' + filename).then(() => {
                remove('./media/com_commercelab_shop/js/vue/' + filename).then(() => {
                    mkdir('./media/com_commercelab_shop/js/vue/' + filename).then(() => {
                        console.log(file + ' done on: ' + theTime);
                        
                        fs.copyFile('./vuefiles/' + file, './media/com_commercelab_shop/js/vue/' + filename + '/' + filename + '.min.js', (err) => {
                            if (err) throw err;
                            // console.log('File was copied to destination');
                        });
                        // minify({
                        //     compressor: terser,
                        //     input: './vuefiles/' + file,
                        //     output: './media/com_commercelab_shop/js/vue/' + filename + '/' + filename + '.min.js'
                        // }).then(function () {
                        // });

                    });
                });
            });


        });
    });


})();
