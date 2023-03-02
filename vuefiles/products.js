////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_products = {
    data() {
        return {
            base_url: '',
            p2s_currency: '',
            p2s_local: '',
            items: [],
            // itemsChunked: [],
            categories: [],
            select_all: false,
            selectedCategory: 0,
            currentSort: 'p.id',
            currentSortDir: 'DESC',
            currentPage: 0,
            pages: 1,
            pagesizes: [5, 10, 15, 20, 25, 30, 50, 100, 200, 500],
            show: 20,
            selected: [],
            confirm_LangString: '',
            changeCategory: 0,
            showChangeCat: false,
            showChangeStock: false,
            changeStock: 0,
            editStock: false,
            filteredByCat: 0,
            showActiveOnly: 0,
            selectedChangeCategoryName: '',
            searchText: '',
            filterLoading: false,
            totalItems: 0,
            filteredItems: 0,
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
        if (base_url != null) {
            try {
                this.base_url = base_url.innerText;
                base_url.remove();
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


        const items_data = document.getElementById('items_data');
        this.items = JSON.parse(items_data.innerText);
        items_data.remove();

        this.totalItems = this.filteredItems = this.items.length;
        const show = document.getElementById('page_size');
        this.show = show.innerText;
        show.remove();

        const pages_data = document.getElementById('pages_data');
        this.pages = parseInt(pages_data.innerText);
        pages_data.remove();

        const confirmLangString = document.getElementById('confirmLangString');
        try {
            this.confirm_LangString = confirmLangString.innerText;
            confirmLangString.remove();
        } catch (err) {
        }

    },
    mounted: function () {
        // this.changeShow();
        window.filterByCategory    = this.filterByCategory;
        window.batchChangeCategory = this.batchChangeCategory;
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
        resetFilter() {

            this.filteredItems        = this.totalItems;
            this.searchText           = '';
            this.show                 = 25;
            this.showActiveOnly       = 0;
            this.selectedCategory     = 0;
            this.selectedCategoryName = '';

            this.pages       = 1;
            this.currentPage = 0;

            this.filter();
        },
        filterByActiveOnly(state) {

            this.showActiveOnly = (this.showActiveOnly) ? 0 : 1;

            this.filter();
        },
        batchChangeCategory(id, title) {

            this.changeCategory = id;
            this.selectedChangeCategoryName = title;

            UIkit.lightbox('#chamge-category-selector').hide();
        },
        filterByCategory(id, title) {

            this.selectedCategory = id;
            this.selectedCategoryName = title;

            this.currentPage = 0;

            this.filter();

            UIkit.lightbox('#category-selector').hide();
        },
        async filter() {

            this.filterLoading = true;

            var items = document.querySelectorAll(".el-item");

            items.forEach(item => {
               item.className = 'el-item';
            });

            const params = {
                'limit': this.show,
                'offset': (this.currentPage * this.show),
                'category': this.selectedCategory,
                'active_only': this.showActiveOnly,
                'searchTerm': (this.searchText != '') ? this.searchText.trim() : '',
                'currentSort': this.currentSort,
                'currentSortDir': this.currentSortDir

            };

            const response = await this.makeACall(params , '&type=product.filter');

            this.filterLoading = false;
            if (response)
            {
                this.items         = response.items;
                this.filteredItems = response.totalfiltered;

                // Add Fade In effect
                const items = document.querySelectorAll(".el-item");
                items.forEach(item => {
                   item.className = 'el-item uk-animation-fade';
                });

                if (this.items) {
                    this.pages = Math.ceil(this.filteredItems/this.show);
                } else {
                    // this.itemsChunked = [];
                    this.pages       = 1;
                    this.currentPage = 0;
                }
            }

        },
        changePage(i) {
            this.currentPage = i;
            this.filter();
        },
        async doTextSearch(event) {
            this.searchText = ''
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
                this.searchText  = event.target.value
                this.currentPage = 0;
                this.filter();
            }, 1000)
        },
        sort(s) {
            if (s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'ASC' ? 'DESC' : 'ASC';
            }
            this.currentSort = s;
            this.filter();
        },
        async toggleSelected() {

            const params = {
                'items': this.selected
            };

            const response = await this.makeACall(params , '&type=product.togglePublished');
            
            if (response)
            {
                this.selected   = [];
                this.select_all = false;
                await this.filter();

            }

        },
        async togglePublished(product) {
            this.selected   = [];
            this.select_all = false;
            this.selected.push(product);
            await this.toggleSelected();
        },
        async trashSelected() {

            await UIkit.modal.confirm(this.confirm_LangString);

            const params = {
                'items': this.selected
            };

            const response = await this.makeACall(params , '&type=product.trash');
            
            if (response)
            {
                await this.filter();
                this.selected   = [];
                this.select_all = false;
            }

        },
        async duplicateSelected() {

            const params = {
                'items': this.selected
            };

            const response = await this.makeACall(params , '&type=product.duplicate');
            
            if (response)
            {
                await this.filter();
                this.selected   = [];
                this.select_all = false;
            }

        },
        openChangeCategory() {
            this.showChangeCat = !this.showChangeCat;
        },
        openChangeStock() {
            this.showChangeStock = !this.showChangeStock;
        },
        async runChangeCategory() {

            if (this.selected.length > 0) {
                const params = {
                    'items': this.selected,
                    'category_id': this.changeCategory
                };

                const response = await this.makeACall(params , '&type=product.changeCategory');
                
                if (response)
                {
                    this.showChangeCat = false;
                    UIkit.notification({
                        message: 'Done',
                        status: 'success',
                        pos: 'top-right',
                        timeout: 5000
                    });
                    await this.filter();
                    this.selected                   = [];
                    this.select_all                 = false;
                    this.selectedChangeCategoryName = '';
                }
            }

        },
        async runChangeStock() {

            if (this.selected.length > 0) {


                const params = {
                    'items': this.selected,
                    'stock': this.changeStock
                };

                const response = await this.makeACall(params , '&type=product.changeStock');
                
                if (response)
                {
                    this.showChangeStock = false;
                    UIkit.notification({
                        message: 'Done',
                        status: 'success',
                        pos: 'top-right',
                        timeout: 5000
                    });
                    this.selected   = [];
                    this.select_all = false;
                    await this.filter();
                }

            }
        },
        openEditStock(product) {
            product.editStock = true;
        },
        openEditPrice(product) {
            product.editPrice = true;
        },
        async saveProductStock(product) {

            delete product.editStock;

            const params = {
                'itemid': product.joomla_item_id,
                'stock': product.stock,
            };

            const response = await this.makeACall(params , '&type=product.saveStock');
            
            if (response)
            {
                UIkit.notification({
                    message: 'Done',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                await this.filter();

            }

        },
        updateBasePriceFloat(event, product) {
            product.basepriceFloat = event.value;
        },
        async saveProductPrice(product) {
            delete product.editPrice;

            const params = {
                'itemid': product.joomla_item_id,
                'base_priceFloat': product.basepriceFloat,
            };

            const response = await this.makeACall(params , '&type=product.savePrice');
            
            if (response)
            {
                UIkit.notification({
                    message: 'Done',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
                await this.filter();

            }

        },
        selectAll(e) {
            if (e.target.checked) {
                this.selected = this.items;
                // this.selected = this.itemsChunked[this.currentPage];
            } else {
                this.selected   = [];
                this.select_all = false;
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

        async exportSelected() {

            // this.selected;
            const ShowLabel = true;
            const ReportTitle = 'Pro2Store_products';
            //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
            var arrData = typeof this.selected != 'object' ? JSON.parse(this.selected) : this.selected;
            var CSV = '';
            //This condition will generate the Label/Header
            if (ShowLabel) {
                var row = "";

                //This loop will extract the label from 1st index of on array
                for (var index in arrData[0]) {
                    //Now convert each value to string and comma-seprated
                    row += index + ',';
                }
                row = row.slice(0, -1);
                //append Label row with line break
                CSV += row + '\r\n';
            }

            //1st loop is to extract each row
            for (var i = 0; i < arrData.length; i++) {
                var row = "";
                //2nd loop will extract each column and convert it in string comma-seprated
                for (var index in arrData[i]) {
                    row += '"' + arrData[i][index] + '",';
                }
                row.slice(0, row.length - 1);
                //add a line break after each row
                CSV += row + '\r\n';
            }

            if (CSV == '') {
                alert("Invalid data");
                return;
            }

            //this trick will generate a temp "a" tag
            var link = document.createElement("a");
            link.id = "lnkDwnldLnk";

            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);

            var csv = CSV;
            blob = new Blob([csv], {type: 'text/csv'});
            var csvUrl = window.webkitURL.createObjectURL(blob);
            var filename = (ReportTitle || 'UserExport') + '.csv';

            link.setAttribute('download', filename);
            link.href = csvUrl;
            link.click();
            document.body.removeChild(link);

        }


    },
    components: {
        'p-inputnumber': primevue.inputnumber,
    }
}

Vue.createApp(p2s_products).mount('#p2s_products')
