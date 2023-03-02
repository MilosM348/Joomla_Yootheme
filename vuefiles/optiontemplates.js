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
            itemId:'',
            items: [],
            itemsChunked: [],
            selected: [],
            optionscheckbox:[],
            p2s_currency:[],
            currentSort: 'title',
            currentSortDir: 'asc',
            currentPage: 0,
            pages: [],
            pagesizes: [5, 10, 15, 20, 25, 30, 50, 100, 200, 500],
            show: 25,
            isShow: '',
            confirm_LangString: '',
            template_name:'',
            option_variant_price:'',
            option_variant_stock:'',
            p2s_local: '',
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

        const confirmLangString = document.getElementById('confirmLangString');
        try {
            this.confirm_LangString = confirmLangString.innerText;
            confirmLangString.remove();
        } catch (err) {
        }

        const show = document.getElementById('page_size');
        this.show = show.innerText;
        show.remove();

        // this.optionscheckbox.push({
        //     modifier_type: 'amount',
        //     modifier_value: 0,
        // })
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

    },
    mounted: function () {
        this.changeShow();
    },
    computed: {},
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
        async editOptionTemplate(item){

            this.template_name        = item.name;
            this.isShow               = item.option_type;
            this.itemId               = item.id;
            this.option_variant_price = item.option_variant_price;
            this.option_variant_stock = item.option_variant_stock;

            this.optionscheckbox.modifier_type       = item.modifier_type;
            this.optionscheckbox.modifier_valueFloat = item.modifier_valueFloat / 100;

            UIkit.modal('#modal-option-template').toggle();
        },
        async updateVariantTemplate(){

            const params = {
                option_type: this.isShow,
                id:this.itemId,
                name: this.template_name,
                option_variant_price:this.option_variant_price,
                option_variant_stock:this.option_variant_stock,
                modifier_type:(this.optionscheckbox.modifier_type ? this.optionscheckbox.modifier_type : ''),
                modifier_valueFloat:(this.optionscheckbox.modifier_valueFloat ? this.optionscheckbox.modifier_valueFloat : '0')
            };

            console.log('updateVariantTemplate', params);

            const response = await this.makeACall(params , '&type=optiontemplates.updateoptiontemplate');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                UIkit.modal('#modal-option-template').toggle();
                this.updateList();

            }

            this.template_name = '';
        },
        async addProductOptionTemplate(type){
            if (type=='variant_option')
            {
                this.isShow = 'variant_option';
            }
            else
            {
                this.isShow                              = 'checkbox_option';
                this.template_name                       = '';
                this.itemId                              = 0;
                this.optionscheckbox.modifier_type       = '';
                this.optionscheckbox.modifier_valueFloat = 0;
           }
            UIkit.modal('#modal-option-template').toggle();
        },
        async saveVariantTemplate(){          
            const params = {
                option_type: this.isShow,
                name: this.template_name,
                option_variant_price:this.option_variant_price,
                option_variant_stock:this.option_variant_stock,
                modifier_type:(this.optionscheckbox.modifier_type ? this.optionscheckbox.modifier_type : ''),
                modifier_valueFloat:(this.optionscheckbox.modifier_valueFloat ? this.optionscheckbox.modifier_valueFloat : '0')
            };

            const response = await this.makeACall(params , '&type=optiontemplates.saveoptiontemplate');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                UIkit.modal('#modal-option-template').toggle();
                this.updateList();

            }

            this.template_name = '';
            this.option_variant_price = '';
            this.option_variant_stock='';
            this.optionscheckbox= [];
        },
        async updateList() {

            const response = await this.makeACall({}, '&type=optiontemplates.list');

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

            const response = await this.makeACall(params , '&type=optiontemplates.trashoptiontemplates');

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
               'searchTerm': (this.enteredText ? this.enteredText.trim() : ''),

            };

            const response = await this.makeACall(params , '&type=optiontemplates.filter');

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
        changeShow() {

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
        'p-inputswitch':
        primevue.inputswitch,
        'p-inputnumber':
        primevue.inputnumber,
      
    }
}

Vue.createApp(p2s_productoptions).mount('#p2s_productoptions')
