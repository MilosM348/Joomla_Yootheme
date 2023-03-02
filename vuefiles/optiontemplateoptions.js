////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_productoptions = {
    data() {
        return {
            base_url: '',
            template_id:'',
            items: [],
            itemsChunked: [],
            selected: [],
            categories: [],
            selectedCategory: 0,
            currentSort: 'title',
            currentSortDir: 'asc',
            currentPage: 0,
            pages: [],
            pagesizes: [5, 10, 15, 20, 25, 30, 50, 100, 200, 500],
            show: 25,
            isShow: '',
            itemId:'',
            option_name:'',
            confirm_LangString: '',
            variants:[],
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

        };
    },
    async beforeMount() {

        const base_url = document.getElementById('base_url');
        this.base_url = base_url.innerText;
        base_url.remove();

        const items_data = document.getElementById('items_data');
        this.items = JSON.parse(items_data.innerText);
        try {
                this.items = JSON.parse(items_data.innerText);
                // items_data.remove();
            }catch (err) {

        }
        const template_id = document.getElementById('template_id');
        if (template_id != null) {
            try {
                this.template_id = template_id.innerText;
                template_id.remove();
            } catch (err) {
            }
        }
        const confirmLangString = document.getElementById('confirmLangString');
        try {
            this.confirm_LangString = confirmLangString.innerText;
            confirmLangString.remove();
        } catch (err) {
        }
      

        const show = document.getElementById('page_size');
        this.show = show.innerText;
        show.remove();

    },
    mounted: function () {
        this.changeShow();
    },
    computed: {
        isDisabled: function(){
            return !this.variants;
        }
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
        async saveTemplateOptions(){

            const params = {
                template_id: this.template_id,
                name: this.option_name,
                variants:this.variants
            };

            const response = await this.makeACall(params , '&type=optiontemplates.saveoptiontemplateoptions');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                UIkit.modal('#edit-modal-option-template-options').toggle();
                this.updateList();


            }

            this.option_name = '';
        },
        async addOptionTemplateOptions() {

            console.log('addOptionTemplateOptions');

            this.itemId   = '';
            this.variants = [];

            const newVariant = {
                option_name: '',
                labels: []
            }

            this.variants.push(newVariant);
            UIkit.modal('#edit-modal-option-template-options').toggle();
        },
        async editTemplateOptions(item){
           // this.option_name = item.name;
            this.variants =  [];
            let newVariant = {
                option_name:item.name,
                labels: item.values
            }
            this.variants.push(newVariant);
            this.itemId         =   item.id,
            UIkit.modal('#edit-modal-option-template-options').toggle();
        },
        async updateTemplateOptions(){
           
            const params = {
                id:this.itemId,
                name: this.option_name,
                variants:this.variants
            };

            const response = await this.makeACall(params , '&type=optiontemplates.updateoptiontemplateoptions');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                UIkit.modal('#edit-modal-option-template-options').toggle();
                this.updateList();

            }
            
            this.option_name = '';
        },
        async updateList() {


            const params = {
                'template_id': this.template_id
            };

            const response = await this.makeACall(params, '&type=optiontemplates.optionlist');

            if (response)
            {
                this.items = response;
                this.loading = false;

                if (this.items) {
                    this.changeShow();
                } else {
                    this.itemsChunked = [];
                    this.pages = 1;
                    this.currentPage = 0;
                }

            }
        },
        async trashSelected() {

            await UIkit.modal.confirm(this.confirm_LangString);
            const params = {
                'items': this.selected
            };

            const response = await this.makeACall(params , '&type=optiontemplates.trashoptiontemplateOptions');

            if (response)
            {
                this.selected = [];
                await this.updateList();
            }
        },
        selectAll(e) {
            if (e.target.checked) {
                this.selected = this.itemsChunked[this.currentPage];
            } else {
                this.selected = [];
            }

        },
        async filter() {

            this.loading = true;

            const params = {
                'limit': this.show,
                'offset': (this.currentPage * this.show),
                'category': this.selectedCategory,
                'template_id':this.template_id,
                'searchTerm': (this.enteredText ? this.enteredText.trim() : ''),
            };

            const response = await this.makeACall(params , '&type=optiontemplates.filteroptions');

            if (response)
            {
                this.items = response.items;
                this.loading = false;

                if (this.items) {
                    this.changeShow();
                } else {
                    this.itemsChunked = [];
                    this.pages = 1;
                    this.currentPage = 0;
                }
            }

        },

        onAddNewLabel(e,index) {
            this.addLabel(e,index);
            
        },
        
        async onUpdateNewLabel(e) {

            let loc_array = e.value;
            let enteredValue = loc_array[loc_array.length - 1];
            let sameCounter = 0;
            for(var k =0; k<=loc_array.length; k++){
                if (typeof loc_array[k] !== "undefined") {
                    if(loc_array[k].toLowerCase()===enteredValue.toLowerCase()){
                        sameCounter++;
                    }
                  
                }    
            }
         
            if(sameCounter>1){
                UIkit.notification({
                    message: 'Duplicate value not allowed',
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 5000
                });
                this.variants[0].labels.splice(-1);
                return;
            }
            const params = {
                option_id: this.itemId,
                name: enteredValue,
            };

            const response = await this.makeACall(params , '&type=optiontemplates.saveoptiontemplatevalues');

            if (response)
            {
                UIkit.notification.closeAll();
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                await this.updateList();
            }
            
        },

        async addLabel(e) {

            console.log(this.variants);

            // this.variants.labels.push(e.value);

        },

        async removeLabel(event,index,itemId) {

            this.variants[index].labels.push(event.value[0]);

            const  modalPop = await  UIkit.modal.confirm(this.confirm_LangString, { labels: { ok: 'Ok', cancel: 'Cancel' }, stack: true }).then(function() {
                return true;
            }, function () {
               
               return false;
            });

            if (modalPop){

                this.variants[index].labels.splice(-1);
                const params = {
                    option_id: itemId,
                    label_name: event.value[0]
                };

                const response = await this.makeACall(params , '&type=optiontemplates.trashoptiontemplatesvalues');

                if (response)
                {
                    UIkit.notification({
                        message: 'Saved!',
                        status: 'success',
                        pos: 'top-right',
                        timeout: 5000
                    });
                    await this.updateList();
                }
           }
        },
        changeShow() {
            setTimeout(() => {
                UIkit.notification.closeAll();
            }, 2000)
            
            this.itemsChunked = this.items.reduce((resultArray, item, index) => {
                const chunkIndex = Math.floor(index / this.show)
                if (!resultArray[chunkIndex]) {
                    resultArray[chunkIndex] = []
                }
                resultArray[chunkIndex].push(item)
                return resultArray
            }, []);
            this.pages = this.itemsChunked.length;
            this.currentPage = 0;
        },
        changePage(i) {
            this.currentPage = i;
        },
        async doTextSearch(event) {
            this.enteredText = null
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
                this.enteredText = event.target.value
                this.filter();
            }, 600)
        },
        sort(s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
            }
            this.currentSort = s;
            return this.itemsChunked[this.currentPage].sort((a, b) => {
                let modifier = 1;
                if (this.currentSortDir === 'desc') modifier = -1;
                if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                return 0;
            });
        },

        serialize(obj) {
            var str = [];
            for (var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        }

    },
    components: {
        'p-inputswitch':primevue.inputswitch,
        'p-chips':primevue.chips,
        'p-chip':primevue.chip,
        'p-inputnumber': primevue.inputnumber,
        'p-multiselect':primevue.multiselect,
        'p-button':primevue.button
    }
}

Vue.createApp(p2s_productoptions).mount('#p2s_productoptions')
