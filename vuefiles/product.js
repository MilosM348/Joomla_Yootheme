////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_product_form = {
    data() {
        return {
            base_url: '',
            root_path:'',
            form: {
                itemid: 0,
                jform_title: '',
                jform_subtitle: '',
                jform_catid: '',
                jform_short_desc: '',
                jform_long_desc: '',
                jform_access: '',
                jform_base_price: 0,
                jform_sku: '',
                jform_manage_stock: 0,
                jform_stock: '',
                jform_featured: false,
                jform_state: true,
                jform_taxclass: 'taxrate',
                jform_apply_discount: 0,
                jform_discount: 0,
                jform_discount_type: "amount",
                jform_teaserimage: '',
                jform_fullimage: '',
                jform_shipping_mode: 0,
                jform_flatfee: 0,
                jform_weight: 0,
                jform_weight_unit: 0,
                jform_publish_up_date: '',
                jform_product_type: '',
                jform_tags: [],
                jform_options: [],
                jform_variants: [],
                jform_variantList: [],
                jform_options: [],
                files: []
            },
            main_loading: false,
            statePending: false,
            category_before_save: 0,
            product_id: 0,
            product_type: 1,
            custom_fields: [],
            custom_image_with: '',
            custom_image_height: '',
            available_tags: [],
            option_for_edit: [],
            p2s_currency: [],
            p2s_local: '',
            discount_type: 1,
            andClose: false,
            openBuilder: false,
            savingVariant: false,
            saving_variants: false,
            variantsSet: false,
            file_for_edit: {},
            newOptionTypeName: '',
            newOptionTypeType: 'Dropdown',
            showNewOptionTypeNameWarning: false,
            // sellPrice: 0,
            variants_loading: false,
            setSavedClass: false,
            //media manager
            opened_manager: null,
            media_view: 'table',
            selected_images: [],
            selected_folders: [],
            selected: [],
            folderTree: [],
            category_parents_tree: [],
            breadcrumbs: [],
            currentParent: 0,
            currentFolderId: 0,
            mediaLoading: false,
            editor: 'tinymce',
            urls:[],
            setdiv:false,
            galleryimg:[],
            gallery_loading: false,
            productCategoryName:'',
            // strings
            COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED: '',
            COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT: '',
            COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE: '',
            COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT: '',
            COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL: '',
            COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY: '',
            option_templates:[],
            checkbox_option: '',
            optionCheckboxtemplates:[],
            ghost_fields:[],
            droppable:{},
            ajax_headers: {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-Token': Joomla_cls.token,
                    'Content-Type': 'application/json'
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer'
            },
            task_url: Joomla_cls.uri_base + 'index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&format=raw'

        }

    },
    created() {
        emitter.on('p2s_product_file_upload', this.fileUploaded);
    },
    computed: {

        selectedImagePath() {
            const keys          = Object.keys(this.form);
            const selectedImage = this.selected_images[0];
            return selectedImage.relname.replace(/\\/g, '/').replace(/^\//g, '');
        },
        currentDirectory() {
            return this.folderTree.find(o => o.id === this.currentParent);
        },
        // currentDirectoryImages() {
        //     return this.folderTree.find(o => o.id === this.currentParent);
        // },
        modifierValueInputType() {
            if (this.option_for_edit.modifiertype === "perc") {
                return "[0-9]*";
            } else if (this.option_for_edit.modifiertype === "amount") {
                return "^[0-9]+(\.[0-9]{1,2})?$"
            }
        },
        singleSelection() {
            if (this.selected_images.length === 1 && this.selected_folders.length === 0) {
                return false;
            } else {
                return true;
            }
        },
        singleFolderSelection() {
            if (this.selected_folders.length === 1 && this.selected_images.length === 0) {
                return false;
            } else {
                return true;
            }
        },
        somethingIsSelected() {
            if (this.selected_folders.length > 0 || this.selected_images.length > 0) {
                return true;
            } else {
                return false;
            }
        },
        checkDeleteDisabled() {

            if (this.selected_images.length === 0 && this.selected_folders.length === 0) {
                return true;
            }


            return false;
        },
        checkEditDisabled() {

            if ((this.selected_images.length === 0 && this.selected_folders.length === 0) || (this.selected_images.length > 1 && this.selected_folders.length > 1)) {
                return true;
            }


            return false;
        },
        sellPrice(){
            const options = {
                maximumFractionDigits: 2,
                currency: this.p2s_currency.iso,
                style: "currency",
                currencyDisplay: "symbol"
            }


            if (this.form.jform_discount_type === "amount") {
                return this.localStringToNumber(this.form.jform_base_price - this.form.jform_discount).toLocaleString(this.p2s_local, options);
            } else {
                // work out the percentage
                const discount = (this.form.jform_base_price / 100) * this.form.jform_discount;
                return this.localStringToNumber(this.form.jform_base_price - discount).toLocaleString(this.p2s_local, options);
            }
        }
		
    },
    async beforeMount() {
        // TODO - I think we do not need ALL this, or at least it can be minified
        const base_url = document.getElementById('base_url');
        if (base_url != null) {
            try {
                this.base_url = base_url.innerText;
                base_url.remove();
            } catch (err) {
            }
        }
        const root_path = document.getElementById('root_path');
        if (root_path != null) {
            try {
                this.root_path = root_path.innerText;
                root_path.remove();
            } catch (err) {
            }
        }
        const p2s_currency = document.getElementById('currency');
        if (p2s_currency != null) {
            try {
                this.p2s_currency = JSON.parse(p2s_currency.innerText);
                p2s_currency.remove();
            } catch (err) {
            }
        }


        const p2s_locale = document.getElementById('locale');
        if (p2s_locale != null) {
            try {
                this.p2s_local = p2s_locale.innerText;
                p2s_locale.remove();
            } catch (err) {
            }
        }

        const folderTree = document.getElementById('folderTree_data');
        if (folderTree != null) {
            try {
                this.folderTree = JSON.parse(folderTree.innerText);
                // folderTree.remove();
            } catch (err) {
            }
        }


        const default_category = document.getElementById('default_category');
        const default_category_name = document.getElementById('default_category_name');
        if (default_category != null) {
            this.form.jform_category = default_category.innerHTML;
            this.category_before_save = default_category.innerHTML;
            this.productCategoryName = default_category_name.innerHTML;
        }

        const category_parents_tree = document.getElementById('category_parents_tree_data');
        if (category_parents_tree != null) {
            this.category_parents_tree = JSON.parse(category_parents_tree.innerHTML);
        }

        const custom_fields = document.getElementById('custom_fields_data');
        if (custom_fields != null) {
            try {
                custom_fields_list = JSON.parse(custom_fields.innerText);
                if (custom_fields_list.length) {
                    this.custom_fields = custom_fields_list[0];
                } else {
                    this.custom_fields = [];
                }
            } catch (err) {
                console.log('custom_fields err', err);
            }
        }

        const itemid = document.getElementById('jform_joomla_item_id_data');
        if (itemid != null) {
            // for product edit... do everything inside this if block since we have an item id
            try {
                this.form.itemid = itemid.innerText;
                // itemid.remove();
            } catch (err) {
            }


            // set images
            const images = document.getElementById('jform_images_data');
            if (images != null) {
                try {
                    const imageArray = JSON.parse(images.innerText);

                    this.form.jform_teaserimage = imageArray.image_intro;
                    this.form.jform_fullimage = imageArray.image_fulltext;
                    // images.remove();
                } catch (err) {
                }
            }
            this.setData();
        }

        const available_tags = document.getElementById('available_tags_data');
        if (available_tags != null) {
            try {
                this.available_tags = JSON.parse(available_tags.innerText);
                // available_tags.remove();
            } catch (err) {
            }
        }

        this.form.jform_options = [];
        const options = document.getElementById('available_options_data');
        if (options != null) {
            try {
                this.form.jform_options = JSON.parse(options.innerText);
                options.remove();
            } catch (err) {
                this.form.jform_options = [];
            }
        } else{
            this.form.jform_options = [];
        }

        const editor = document.getElementById('editor');
        if (editor != null) {
            try {
                this.editor = editor.innerText;
                editor.remove();
            } catch (err) {
                this.editor = 'tinymce';
            }
        } else{
            this.editor = 'tinymce';
        }
        //Option template data
        const option_templates = document.getElementById('optionTemplates_data');
        if (option_templates != null) {
            try {
                this.option_templates = JSON.parse(option_templates.innerText);
            } catch (err) {
            }
        }
        //Option template for checkbox
        const optionCheckboxtemplates = document.getElementById('optionCheckboxtemplates_data');
        if (option_templates != null) {
            try {
                this.optionCheckboxtemplates = JSON.parse(optionCheckboxtemplates.innerText);
            } catch (err) {
            }
        }
        // LANGUANGE STRINGS
        const COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED = document.getElementById('COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED');
        if (COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED != null) {
            try {
                this.COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED = COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED.innerText;
                COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED.remove();
            } catch (err) {
            }
        }
        const COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT = document.getElementById('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT');
        if (COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT != null) {
            try {
                this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT = COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT.innerText;
                COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT.remove();
            } catch (err) {
            }
        }
        const COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE = document.getElementById('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE');
        if (COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE != null) {
            try {
                this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE = COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE.innerText;
                COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE.remove();
            } catch (err) {
            }
        }
        const COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT = document.getElementById('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT');
        if (COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT != null) {
            try {
                this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT = COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT.innerText;
                COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT.remove();
            } catch (err) {
            }
        }
        const COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL = document.getElementById('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL');
        if (COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL != null) {
            try {
                this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL = COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL.innerText;
                COM_COMMERCELAB_SHOP_MEDIA_MANAGER_UPLOADED_MODAL.remove();
            } catch (err) {
            }
        }
        const COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL = document.getElementById('COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL');
        if (COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL != null) {
            try {
                this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL = COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL.innerText;
                COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DROPZONE_LABEL.remove();
            } catch (err) {
            }
        }
        const COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY = document.getElementById('COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY');
        if (COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY != null) {
            try {
                this.COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY = COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY.innerText;
                COM_COMMERCELAB_SHOP_OPEN_BUILDER_BUTTON_ALERT_MSG_BODY.remove();
            } catch (err) {
            }
        }
    },
    mounted: function () {

        window.addUserCustomField = this.addUserCustomField;
        window.changedColorPicker = this.changedColorPicker;


        // Set Empty/default values if no value is present // TODO setData method is causing this
        // this is a¿only a workaround to avoid making major changes
        if (!this.form.jform_subtitle) {
            this.form.jform_subtitle = "";
        }

        if (!this.form.jform_stock) {
            this.form.jform_stock = 0;
        }

        if (this.form.jform_stock === true) {
            this.form.jform_stock = 1;
        }

        if (!this.form.jform_manage_stock || Array.isArray(this.form.jform_manage_stock)) {
            this.form.jform_manage_stock = 0;
        }

        if (!this.form.jform_apply_discount || Array.isArray(this.form.jform_apply_discount)) {
            this.form.jform_apply_discount = 0;
        }
        if (!this.form.jform_sku) {
            this.form.jform_sku = "";
        }
        if (!this.form.jform_shipping_mode.length) {
            this.form.jform_shipping_mode = "none";
        }
        if (!this.form.jform_flatfee) {
            this.form.jform_flatfee = 0;
        }
        if (!this.form.jform_discount_type) {
            this.form.jform_discount_type = "amount";
        }

        if (this.form.jform_taxclass === undefined) {
            this.form.jform_taxclass = "taxrate";
        }

        if (!this.form.jform_taxclass) {
            this.form.jform_taxclass = 0;
        }
        
        if (!this.form.jform_weight_unit.length) {
            this.form.jform_weight_unit = "";
        }
        if (!this.form.jform_discount) {
            this.form.jform_discount = 0;
        }

        window.productCategory = this.productCategory;

    },
    methods: {
        async makeACall(params, url) {

            const send = JSON.parse(JSON.stringify(this.ajax_headers));
            send.body  = JSON.stringify(params);

            const request  = await fetch(this.task_url + url, send);
            const response = await request.json();

            if (response.success)
            {
                return response.data;
            }
            else
            {
                UIkit.notification({
                    message: response.message,
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });

                return false;
            }
        },

        deepObjectCopy(object) {
            const copy = JSON.stringify(object);
            return JSON.parse(copy);
        },
        importimg(e){
            let files = e.target.files;            
            [...files].forEach((file) => {
                urls = (window.URL || window.webkitURL).createObjectURL(file);
                this.urls.push(this.root_path+'/images/'+file.name);
            })
            this.setdiv = true;
        },
        async productCategory(id, title) {
            this.form.jform_category = id;
            this.productCategoryName = title;

            this.category_parents_tree = await this.getCategoryParentsTree(id);
            UIkit.lightbox('#edit-category-selector').hide();
            // UIkit.notification({
            //     message: 'If the category changed, you may need to save and refresh the page in order to see some changes to appear, like custom fields limitted by category.',
            //     status: 'danger',
            //     pos: 'top-center',
            //     timeout: 6000
            // });
            // await this.saveItem();
        },
        async removeGalleryImg(imgId, itemId){

            this.gallery_loading = true;

            const params = {
                'img_id': imgId,
                'item_id': itemId,
            };

            const response = await this.makeACall(params , '&type=product.removeGalleryImgs');

            this.gallery_loading = false;

            if (response)
            {
                return await this.refreshGalleryImg(response);
            }
        },

        async refreshGalleryImg(itemid){

            const params = {
                'item_id': itemid,
            };

            const response = await this.makeACall(params , '&type=product.refreshGalleryImgs');

            if (response)
            {
                this.urls = [];
                this.urls = response;
            }

            this.setdiv = true;
        },

        logIt() {
            console.log(this.custom_fields);
        },


        /**
         * TAGS
         */

        addTagFromChip(tag, i) {
            this.form.jform_tags.push(tag);
            this.available_tags.splice(i, 1);
        },
        addBackToAvailable(e) {
            this.available_tags.push(e.value[0]);
        },

        /**
         * VARIANTS
         */
        addVariant() {
            let newVariant = {
                id: 0,
                product_id: this.form.itemid,
                name: '',
                labels: []
            }

            this.form.jform_variants.push(newVariant);
        },
        async removeVariant(i) {
            await UIkit.modal.confirm(this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE);
            this.form.jform_variants[i].labels = [];
            this.form.jform_variants.splice(i, 1);
            await this.setVariants();
            await this.saveItem();
        },
        
        async updateVariantValues(value) {
            console.log(value);
            // this.variants_loading = true;

            // this.saveVariantValues(true);
        },

        async applyChangesVariantRow(value) {
            console.log(value);
            // this.variants_loading = true;

            // this.saveVariantValues(true);
        },

        async setVariants() {

            // const setVariants = this.setVariants();
            // if (this.setSavedClass)
            // {
            //     setTimeout(function() {setVariants}, 300, setVariants);
            // }

            this.variants_loading = true;

            const params = {
                'variants': this.form.jform_variants,
                'variantList': this.form.jform_variantList,
                'itemid': this.form.itemid,
                'base_price': this.form.jform_base_price,
            };

            const response = await this.makeACall(params , '&type=product.savevariants');

            this.variants_loading = false;
            if (response)
            {
                this.setSavedClass    = true;
                const refreshVariants = await this.refreshVariants();

                if (refreshVariants)
                {
                    this.setSavedClass = false;
                    return true
                }
            }


        },
        async saveVariantValues(not_refresh) {

            this.variants_loading = true;

            const variantList = this.deepObjectCopy(this.form.jform_variantList);

            const params = {
                'variantList': variantList
            };

            const response = await this.makeACall(params , '&type=product.updatevariantvalues');

            this.variants_loading = false;
            if (response)
            {
                this.setSavedClass    = true;
                if (!not_refresh)
                {
                    const refreshVariants = await this.refreshVariants();
                }
                
                this.setSavedClass = false;
                return true
            }
        },

        async refreshVariants() {

            const params = {
                'j_item_id': this.form.itemid
            };

            const response = await this.makeACall(params , '&type=product.refreshvariants');

            if (response)
            {
                this.form.jform_variantList = response.variantList;
                this.form.jform_variants    = response.variants;
                return true;
            }

            return false;
        },

        setVariantDefault(itemIndex) {

            this.form.jform_variantList.forEach((variant, index) => {
                variant.default = false;
                if (itemIndex === index) {
                    variant.default = true;
                    if (!variant.active) {
                        variant.active = true;
                    }
                }
            });
        },
        checkVariantDefault(itemIndex) {
            this.form.jform_variantList.forEach((variant, index) => {
                if (itemIndex === index) {
                    if (variant.default) {
                        variant.active = true;
                        return false;
                    }
                }
            });
        },
        formatToCurrency(itemPrice) {

            const value = itemPrice;
            const options = {
                maximumFractionDigits: 2,
                currency: this.p2s_currency.iso,
                style: "currency",
                currencyDisplay: "symbol"
            }

            itemPrice = this.localStringToNumber(value).toLocaleString(undefined, options);


        },
        localStringToNumber(s) {
            return Number(String(s).replace(/[^0-9.-]+/g, ""))
        },
        async addLabel(e, variant_id) {


            // get the array of current labels
            const loc_array = e.value;

            // get the last entered label
            const enteredValue = loc_array[loc_array.length - 1];

            // chop off the last label, since it only contains the entered text
            loc_array.splice(-1);

            // now push a new object into the array with the id as zero etc.
            loc_array.push({
                id: 0,
                name: enteredValue,
                product_id: this.form.itemid,
                variant_id: variant_id
            });

            return true;

        },

        async onAddNewLabel(e, variant_id) {
            const addLabel = await this.addLabel(e, variant_id);
            if (addLabel)
            {
                this.savingVariant = true;
            }
        },
        
        async applyVariants() {

            this.saving_variants = true;
            const setVariants = await this.setVariants();

            if (setVariants)
            {
                const saveItem = await this.saveItem();
                if (saveItem)
                {
                    this.savingVariant   = false;
                    this.saving_variants = false;
                    return true;
                }
            }
        },

        async removeLabel(event, index, variant_id) {

            this.form.jform_variants[index].labels.push(event.value[0]);
            await UIkit.modal.confirm(this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE);
            this.form.jform_variants[index].labels.splice(-1);
            await this.setVariants();
            await this.saveItem();
        },


        /**
         * CHECKBOX OPTIONS
         */

        addOption() {

            this.form.jform_options.push({
                id: 0,
                option_name: '',
                modifier_type: 'amount',
                modifier_value: 0,
                delete: false
            })
        },
        removeOption(option) {
            option.delete = true;
        },

        /**
         * FILE EDIT
         */

        openFileEdit(file) {
            this.file_for_edit = file;
            this.openAddFile();
        },
        openAddFile() {
            UIkit.modal("#fileEditModal").show();
        },
        removeFile() {
            this.file_for_edit.filename_obscured = false;
        },
        fileUploaded(data) {
            this.file_for_edit.filename_obscured = data.path;
            this.file_for_edit.filename = data.filename;
        },
        async saveFile() {

            const params = {
                'fileid': this.file_for_edit.id,
                'created': this.file_for_edit.created,
                'download_access': this.file_for_edit.download_access,
                'filename': this.file_for_edit.filename,
                'filename_obscured': this.file_for_edit.filename_obscured,
                'isjoomla': (this.file_for_edit.isjoomla ? 1 : 0),
                'php_min': this.file_for_edit.php_min,
                'published': (this.file_for_edit.published ? 1 : 0),
                'stability_level': this.file_for_edit.stability_level,
                'type': this.file_for_edit.type,
                'version': this.file_for_edit.version,
                'product_id': this.product_id
            };

            const response = await this.makeACall(params , '&type=file.save');

            if (response)
            {

                UIkit.notification({
                    message: this.COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED,
                    status: 'success',
                    pos: 'top-center',
                    timeout: 5000
                });

            } else {
                UIkit.notification({
                    message: 'There was an error.',
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            }

        },
        cancelFile() {
            this.file_for_edit = {};
        },


        /**
         * SAVE AND UTILITIES
         */

        async saveItem() {

            this.form.jform_long_desc       = this.getFrameContents("jform_long_desc");
            this.form.jform_short_desc      = this.getFrameContents("jform_short_desc");
            this.form.jform_publish_up_date = document.getElementById("jform_publish_up_date").value;
            this.form.jform_access          = document.getElementById("jform_access").value;

            const filterCustomFields = this.filterCustomFields();

            for (var key = 0; key < filterCustomFields.length; key++) {

                const field      = filterCustomFields[key];
                const fieldDOMId = 'custom_fields_' + [field.key] + '_' + field.id; // custom_fields_{index}_{field.id}

                // Custom Fields
                if (field.type == 'editor') {
                    const editor_content = this.getFrameContents(fieldDOMId)
                    field.rawvalue       = editor_content;
                }

                if (field.type == 'location') {
                    const location_data = document.getElementById(fieldDOMId);
                    field.rawvalue      = location_data.value;
                }

                // SubForms
                if (field.type == 'subform' || field.type == 'repeateable') {

                    const subform_rows = field['subform_rows'];
                    for (var row_index = 0; row_index < subform_rows.length; row_index++) {

                        const subfields = Object.values(subform_rows[row_index]);
                        for (var subfield_index = 0; subfield_index < subfields.length; subfield_index++) {

                            const subfield      = subfields[subfield_index];
                            const subFieldDOMid = 'custom_fields_' + [field.key] + '_' + [row_index] + '_' + subfield.id;

                            // Editor
                            if (subfield.type == 'editor')
                            {
                                const editor_content = this.getFrameContents(subFieldDOMid)
                                subfield.rawvalue    = editor_content;
                            }

                            // Location
                            if (subfield.type == 'location')
                            {
                                const location_data = document.getElementById(subFieldDOMid);
                                subfield.rawvalue   = location_data.value;
                            }

                        }
                    }
                }

            }

            // return;
            const params = {
                'itemid': this.form.itemid,
                'title': this.form.jform_title,
                'subtitle': this.form.jform_subtitle,
                'short_desc': this.form.jform_short_desc,
                'long_desc': this.form.jform_long_desc,
                'category': this.form.jform_category,
                'access': this.form.jform_access,
                'base_price': this.form.jform_base_price,
                'discount': this.form.jform_discount,
                'apply_discount': (this.form.jform_apply_discount && !Array.isArray(this.form.jform_apply_discount)) ? 1 : 0,
                'manage_stock': (this.form.jform_manage_stock && !Array.isArray(this.form.jform_manage_stock)) ? 1 : 0,
                'discount_type': this.form.jform_discount_type,
                'tags': this.form.jform_tags,
                'sku': this.form.jform_sku,
                'stock': this.form.jform_stock,
                'featured': (this.form.jform_featured ? 1 : 0),
                'state': (this.form.jform_state ? 1 : 0),
                'taxclass': this.form.jform_taxclass,
                'teaserimage': this.form.jform_teaserimage,
                'fullimage': this.form.jform_fullimage,
                'shipping_mode': this.form.jform_shipping_mode,
                'flatfee': this.form.jform_flatfee,
                'weight': this.form.jform_weight,
                'weight_unit': this.form.jform_weight_unit,
                'publish_up_date': this.form.jform_publish_up_date,
                'product_type': this.form.jform_product_type,
                'options': this.form.jform_options,
                'variants': this.form.jform_variants,
                'variantList': this.form.jform_variantList,
                'custom_fields': filterCustomFields
            };

            const response = await this.makeACall(params , '&type=product.save');

            if (response)
            {
                this.form.jform_options = (response.options) ? response.options : [];

                UIkit.notification({
                    message: this.COM_COMMERCELAB_SHOP_ADD_PRODUCT_ALERT_SAVED,
                    status: 'success',
                    pos: 'bottom-right',
                    timeout: 5000
                });


                // Set Date State Button - If Publish up set in Future
                this.statePending  = response.isPendingState;

                if (this.andClose) {
                    // if 'andClose' is true, redirect back to the list page
                    window.location.href = this.base_url + 'index.php?option=com_commercelab_shop&view=products';
                } else {

                    // if 'andClose' is still false, the user wants to stay on the page.
                    // this line makes sure that a new item gets the ID appended to the URL
                    const url = window.location.href;
                    if (url.indexOf('&id=') == -1) {
                        history.replaceState('', '', url + '&id=' + response.joomlaItem.id);
                    }

                    // we also need to make sure that the next save action doesn't trigger a create... we do this by adding the id to the form array
                    this.form.itemid = response.joomlaItem.id;

                }

                if (this.openBuilder) {
                    const joomlaItem        = response.joomlaItem;
                    const builderRooute     = document.getElementById("openBuilderButton").dataset.url;
                    const joomla_live_link  = this.base_url + 'index.php?view=article&id=' + joomlaItem.id + '&catid=' + joomlaItem.catid;
                    const encodedJoomlaLink = encodeURIComponent(joomla_live_link.replace('administrator/', ''));
                    const url               = this.base_url + builderRooute.replace('PRODUCT_ID', joomlaItem.id).replace('JOOMLA_LINK', encodedJoomlaLink);

                    window.location.href = url;

                }

                // If category has changed, let's reload the page to apply any dependent data
                // if (response.data.joomlaItem.catid != this.category_before_save) {

                //     this.main_loading = true;
                //     document.getElementsByTagName('body')[0].className = 'uk-position-fixed';
                //     document.getElementById('header').className        = 'uk-hidden';

                //     const refresh_url = this.base_url + 'index.php?option=com_commercelab_shop&view=product&id=' + response.data.joomlaItem.id;
                //     window.location.href = refresh_url;

                // }

            } else {
                UIkit.notification({
                    message: 'There was an error.',
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            }

            return response;

        },

        filterCustomFields(fields) {

            const customFieldCatFilter = this.customFieldCatFilter;
            return [...this.custom_fields].filter(function (field){
                return customFieldCatFilter(field.assigned_category_ids);
            });
        },
        customFieldCatFilter(cat_ids) {

            if (!cat_ids.length)
            {
                return true;
            }

            const category_parents_tree = this.category_parents_tree;
            let field_in_category       = false;

            for (var i = 0; i < cat_ids.length; i++) {
                if (Object.values(category_parents_tree).includes(cat_ids[i]))
                {
                    field_in_category = true;
                    break;
                }
            }

            return field_in_category;

        },

        async getCategoryParentsTree(cat_id) {

            // return;
            const params = {
                'cat_id': cat_id
            };

            const response = await this.makeACall(params , '&type=product.getcategoryparentstree');

            if (response)
            {
                return response;

            } else {
                return [];
            }

        },
        
        getSellPrice() {

            // const options = {
            //     maximumFractionDigits: 2,
            //     currency: this.p2s_currency.iso,
            //     style: "currency",
            //     currencyDisplay: "symbol"
            // }
            //
            //
            // if (this.discount_type == 1) {
            //
            //     this.sellPrice = this.localStringToNumber(this.form.jform_base_price - this.form.jform_discount).toLocaleString(undefined, options);
            // } else {
            //
            //     // work out the percentage
            //     const discount = (this.form.jform_base_price / 100) * this.form.jform_discount;
            //
            //     this.sellPrice = this.localStringToNumber(this.form.jform_base_price - discount).toLocaleString(undefined, options);
            // }
        },
        getFrameContents(elementId) {

            const iFrame = document.getElementById(elementId + '_ifr');

            // Standard Textarea
            if (!iFrame) {
                return document.getElementById(elementId).value;;
            }

            // Enriched Textarea

            let iFrameBody;
            if (iFrame.contentDocument)
            { // FF
                iFrameBody = iFrame.contentDocument.getElementById(this.editor);
            }
            else if (iFrame.contentWindow)
            { // IE
                iFrameBody = iFrame.contentWindow.document.getElementById(this.editor);
            }

            if (iFrameBody)
            {
                return iFrameBody.innerHTML;
            }
            else
            {
                return '';
            }
        },
        setData() {
            const keys = Object.keys(this.form);
            keys.forEach((jfrom) => {
                let theInput = document.getElementById(jfrom + '_data');
                if (theInput) {

                    if (this.hasJsonStructure(theInput.innerText)) {
                        this.form[jfrom] = JSON.parse(theInput.innerText);
                    } else {


                        this.form[jfrom] = theInput.innerText;

                        if (theInput.innerText == 1) {
                            this.form[jfrom] = true;
                        }
                        if (theInput.innerText == 0) {
                            this.form[jfrom] = false;
                        }
                        if (theInput.innerText == 'null') {
                            this.form[jfrom] = [];
                        }
                        if (theInput.id === 'jform_base_price_data' || theInput.id === 'jform_discount_data' || theInput.id === 'jform_flatfee_data') {
                            this.form[jfrom] = (Number(theInput.innerText) / 100);
                        }


                    }
                    // theInput.remove();
                }

            });
        },
        hasJsonStructure(str) {
            if (typeof str !== 'string') return false;
            try {
                const result = JSON.parse(str);
                const type = Object.prototype.toString.call(result);
                return type === '[object Object]'
                    || type === '[object Array]';
            } catch (err) {
                return false;
            }
        },
        serialize(obj) {
            var str = [];
            for (var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        },

        /**
         * MEDIA MANAGER
         */
        defineOpenedManager(id) {
            this.selected_images  = [];
            this.selected_folders = [];
            this.opened_manager   = id;
        },
        closeManager(id) {
            this.selected_images  = [];
            this.selected_folders = [];

            this.opened_manager   = null;

            UIkit.modal('#mediaField' + id).hide();
        },
        async getFolderTree() {

            this.mediaLoading = true;
            this.selected_images = [];
            this.selected_folders = [];

            const response = await this.makeACall({}, '&type=mediaManager.getFolderTree');

            this.mediaLoading = false;
            if (response)
            {
                this.selected_images  = [];
                this.selected_folders = [];
                this.folderTree       = response;
            }

        },
        async openBreadcrumb(folder, index) {
            this.selected_images  = [];    
            this.selected_folders = [];    
            this.breadcrumbs.splice((index + 1), this.breadcrumbs.length);
            this.currentParent = folder.id;
        },
        async openFolder(folder) {
            this.selected_images  = [];
            this.selected_folders = [];
            this.breadcrumbs.push(folder);
            this.currentParent = folder.id;
        },
        async setToHome() {
            this.selected_images  = [];
            this.selected_folders = [];
            this.breadcrumbs      = [];
            this.currentParent    = 0;
        },
        unselectImages() {
            this.selected_images = [];
        },
        toggleSelectImage(image, unique) {

            if (unique) {
                this.selected_images = [];
            }

            const index = this.selected_images.indexOf(image);

            if (index > -1) {
                this.selected_images.splice(index, 1);

            } else {
                this.selected_images.push(image);
            }


        },
        selectFile(image) {
            this.selected_images.push(image);
        },
        selectImage(id) {
            // console.log(id);
            // const keys              = Object.keys(this.form);
            // const selectedImage     = this.selected_images[0];
            // const selectedImagePath = selectedImage.relname.replace(/\\/g, '/').replace(/^\//g, '');

            // const imageObject = this[id];
            // imageObject          = selectedImagePath;
            // imageObject.rawvalue = selectedImagePath;
            // imageObject.width    = selectedImage.width;
            // imageObject.height   = selectedImage.height;

            // // Standard Media
            // keys.forEach((jfrom) => {
            //     if (jfrom == id) {
            //     }
            // });

            // // Custom Field Media
            // const custom_field = this.custom_fields.find(custom_field => custom_field.id == id);

            // if (custom_field_id) {
            //     custom_field.value  = selectedImagePath;
            //     custom_field.width  = selectedImage.width;
            //     custom_field.height = selectedImage.height;
            // } else if (subformRow) {

            //     // Custom Subfield
            //     const subFormPattern = id.split('_');
            //     const custom_sub_field = this.custom_fields
            //         .find(custom_field => custom_field.id == subFormPattern[0])['subform_rows'][subFormPattern[1]][[subFormPattern[2]]];

            //     if (custom_sub_field) {
            //         custom_sub_field.value  = selectedImagePath;
            //         custom_sub_field.width  = selectedImage.width;
            //         custom_sub_field.height = selectedImage.height;
            //     }
            // }
        },

        removeImage(id) {

            // console.log('removeImage id', id);
            // console.log(computed);
            // const splitNames = id.split('.');
            // console.log(splitNames);
            // const rootObj = this;
            // splitNames.forEach(name => {
            //     rootObj = rootObj[name];
            // });
            // console.log(rootObj);
            // rootObj = '';

            // if (parseInt(customKey)) {
            //     if (subField && parseInt(subField) != 0) {
            //         this.custom_fields[parseInt(customKey)]['subform_rows'][parseInt(rowIndex)][subField].value = '';
            //     } else {
            //         this.custom_fields[parseInt(customKey)].value = '';
            //     }
            // } else {
            // }
                        
        },

        async selectgalleryImage(id) {

            this.gallery_loading = true;

            const path   = (this.selected_folders.length) ? this.selected_folders[0].relname : this.currentDirectory.relname;
            const images = (this.selected_folders.length) ? this.selected_folders[0].images : this.selected_images;

            if (!images) {
                return;
            }

            let paths = [];
            path.replace(/\\/g, '/').replace('//', '/').split('/').forEach(folder => {
                if (folder != '') {
                    paths.push(folder);
                }
            });

            let imgs = [];
            images.forEach(image => {
                imgs.push(image.name);
            });

            const params = {
                paths: paths,
                images: imgs,
                itemid: this.form.itemid
            }    

            const response = await this.makeACall(params , '&type=mediaManager.addgalleryImg');

            this.gallery_loading = false;

            if (response)
            {
                await this.getFolderTree();

                this.urls = response[0];
                this.setdiv = true;

            }


            this.selected_images = [];
            this.opened_manager = null;

            UIkit.modal('#mediaField' + id).hide();
        },

        async editFileName() {

            const name = await UIkit.modal.prompt(this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT, this.selected_images[0].name, {stack: true})

            if (name)
            {

                const params = {
                    image: this.selected_images[0],
                    new_name: name
                }

                const response = await this.makeACall(params , '&type=mediaManager.editName');

                if (response)
                {
                    await this.getFolderTree();

                }

            }

        },
        async editFolderName() {

            const name = await UIkit.modal.prompt(this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_EDIT_NAME_PROMPT, this.selected_folders[0].name, {stack: true})

            if (name)
            {

                const params = {
                    folder: this.selected_folders[0],
                    new_name: name
                }

                const response = await this.makeACall(params , '&type=mediaManager.editFolderName');

                if (response)
                {
                    this.selected_images = [];
                    this.selected_folders = [];
                    await this.getFolderTree();

                }

            }

        },
        async trashSelected() {

            await UIkit.modal.confirm(this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_DELETE_ARE_YOU_SURE, {stack: true})

            const params = {
                folders: this.selected_folders,
                images: this.selected_images
            }

            const response = await this.makeACall(params , '&type=mediaManager.trashSelected');

            if (response)
            {
                await this.getFolderTree();

            }

        },
        async addFolder() {

            const name = await UIkit.modal.prompt(this.COM_COMMERCELAB_SHOP_MEDIA_MANAGER_FOLDER_ADD_FOLDER_PROMPT, '', {stack: true})

            if (name)
            {
                const params = {
                    name, 
                    currentDirectory: this.currentDirectory
                }

                const response = await this.makeACall(params , '&type=mediaManager.addFolder');

                if (response)
                {
                    await this.getFolderTree();

                }
            }

        },
        async uploadImages(e) {
            this.mediaLoading = true;
        
            let files    = e.target.files; 
            let formData = new FormData();
            let lastAddedFileName = '';

            [...files].forEach((file) => {            
                formData.append("image[]", file, file.name);
                lastAddedFileName = file.name;
            });
            
            formData.append("itemid", this.form.itemid);


            // redirect: 'follow',
            // referrerPolicy: 'no-referrer',
            // reportProgress: true,
            // observe: 'events',
            const request = await fetch(this.base_url + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=mediaManager.uploadImage&format=raw&directory=" + this.currentDirectory.fullname, {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                reportProgress: true,
                observe: 'events',
                body: formData
            });

            const response = await request.json();

            // const params = {
            //     formData,
            //     directory: this.currentDirectory.fullname
            // };
            // const response = await this.makeACall(params , '&type=mediaManager.uploadImage');

            if (response.success)
            {
                await this.getFolderTree();
                if (response.data)
                {
                    await this.findUploadedFile(this.currentParent, response.data[response.data.length - 1]);
                }
            }
        
        },
        isRemotePath(model) {

            let url;

            try {

                url = new URL(model);

            } catch (_) {

                return false;  
            }

            return url.protocol === "http:" || url.protocol === "https:";
        
        },
        async findUploadedFile(currentFolderId, fileName) {

            const lastImage = [[...this.folderTree].filter(function (folder)
                {
                  return folder.id == currentFolderId;
                }
            )[0].images][0].filter(function (file)
                {
                    return file.name == fileName;
                }
            )[0];

            // Select Image
            this.selected_images = [lastImage];

            // Find in DOM and scroll to it
            const image_row_id = this.opened_manager + lastImage.modified + lastImage.name.replace(/[^a-z0-9]/gi, '_').toLowerCase();
            UIkit.scroll('',{offset:50}).scrollTo('#' + image_row_id);

        },
        async selectOptionTemplate() {
            UIkit.modal('#modal-option-template-list').toggle();
        },
        async selectCheckboxOptionTemplate() {
            UIkit.modal('#modal-option-template-checkbox-list').toggle();
        },
        selectAll(e) {

            if (e.target.checked) this.selected = this.itemsChunked[this.currentPage];
            else this.selected = [];

        },
        async setSelectedOptionTemplateCheckbox() {
            const params = {
                'items': this.selected,
                product_id: this.form.itemid,
            };
           
            if (this.selected.length!=0)
            {
                for (let i=0; i<this.selected.length; i++)
                {
                    this.form.jform_options.push({
                        id: 0,
                        option_name: this.selected[i].name,
                        modifier_type: this.selected[i].modifier_type,
                        modifier_value: this.selected[i].modifier_valueFloat,
                        modifier_valueFloat: this.selected[i].modifier_valueFloat/100,
                        delete: false
                    })
                }
            }

            UIkit.modal('#modal-option-template-checkbox-list').toggle();
            this.selected = [];
        },
        async setSelectedOptionTemplates() {

            const params = {
                'items': this.selected,
                product_id: this.form.itemid,
            };

            const response = await this.makeACall(params , '&type=optiontemplates.setselectedoptiontemplates');

            if (response)
            {
                const refreshed = await this.refreshVariants();

                if (refreshed)
                {
                    await this.setVariants();
                    UIkit.modal('#modal-option-template-list').toggle();
                }

            }
        }

    },
    components: {
        'p-inputswitch': primevue.inputswitch,
        'p-chips': primevue.chips,
        'p-chip': primevue.chip,
        'p-inputnumber': primevue.inputnumber,
        'p-multiselect': primevue.multiselect
    }
}
Vue.createApp(p2s_product_form).mount('#p2s_product_form');
