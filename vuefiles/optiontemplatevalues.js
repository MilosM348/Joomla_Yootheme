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
            categories: [],
            selected: [],
            currentSort: 'title',
            currentSortDir: 'asc',
            currentPage: 0,
            pages: [],
            pagesizes: [5, 10, 15, 20, 25, 30, 50, 100, 200, 500],
            show: 25,
            isShow: '',
            option_value:'',
            confirm_LangString: '',
            option_id:'',
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
        const option_id = document.getElementById('option_id');
        if (option_id != null) {
            try {
                this.option_id = option_id.innerText;
                option_id.remove();
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
            return !this.option_value;
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
        async editTemplateOptionValues(item){
            this.option_value  =   item.name;
            //this.isShow         =   item.option_type;
            this.itemId         =   item.id;
            UIkit.modal('#modal-option-template-values').toggle();
        },
        
        async updateOptionTemplateValue(){
            const params = {
                option_type: this.isShow,
                id:this.itemId,
                name: this.option_value,
            };

            const response = await this.makeACall(params , '&type=optiontemplates.updateoptiontemplatevalue');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                UIkit.modal('#modal-option-template-values').toggle();
                this.updateList();

            }

            this.option_value = '';
        },
        async addOptionTemplateValues(){
            UIkit.modal('#modal-option-template-values').toggle();
        },
        async saveOptionTemplateValue(){

            const params = {
                option_id: this.option_id,
                name: this.option_value,
            };

            const response = await this.makeACall(params , '&type=optiontemplates.saveoptiontemplatevalues');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                UIkit.modal('#modal-option-template-values').toggle();
                this.updateList();

            }

            this.option_value = '';
        },
        async updateList() {
            // const request = await fetch(this.base_url + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=optiontemplates.optionvalueslist&format=raw&limit=0&option_id="+this.option_id,  {
            //     method: 'post'
            // });

            const response = await this.makeACall({}, '&type=optiontemplates.optionvalueslist');

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

            const response = await this.makeACall(params , '&type=optiontemplates.trashoptiontemplatesvalues');

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

            this.loading = false;
            if (response)
            {
                this.items = response.items;

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

    }
}

Vue.createApp(p2s_productoptions).mount('#p2s_productoptions')
