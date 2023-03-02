////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const cls_orders = {
    data() {
        return {
            base_url: '',
            items: [],
            selectedItems: [],
            callbackLogs: [],
            currentSort: 'o.id',
            currentSortDir: 'DESC',
            currentPage: 0,
            pages: [],
            pagesizes: [5, 10, 15, 20, 25, 30, 50, 100, 200, 500],
            statuses: [],
            show: 25,
            searchText: '',
            selectedStatus: 0,
            dateFrom: '',
            dateTo: '',
            filterLoading: false,
            callbackLoading: false,
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
        this.base_url = base_url.innerText;
        base_url.remove();

        const items_data = document.getElementById('items_data');
        try {
            this.items = JSON.parse(items_data.innerText);
            // items_data.remove();
        } catch (err) {
        }

        const statuses_data = document.getElementById('statuses_data');
        try {
            this.statuses = JSON.parse(statuses_data.innerText);
            statuses_data.remove();
        } catch (err) {
        }

        // Initial Variables with Data
        this.totalItems = this.filteredItems = this.items.length;
        const show = document.getElementById('page_size');
        this.show = show.innerText;
        show.remove();

    },
    mounted: function () {
        var preSelected = document.getElementById('filterSelect').getAttribute('data-preSelectedStatus');

        if (preSelected != '0') {
            this.selectedStatus = preSelected;
            this.filter();
        }
        // this.changeShow();
    },
    computed: {
        dateActive() {
            if (this.dateFrom !== '' && this.dateTo !== '') {
                return true;
            } else {
                return false;
            }
        },
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

        resetFilter() {

            this.filteredItems = this.totalItems;
            this.searchText = '';
            this.show = 25;
            this.pages = 1;
            this.currentPage = 0;

            this.filter();
        },

        async seeCallbackLogs() {

            this.callbackLoading = true;
            const response = await this.makeACall({}, '&type=order.callbacklogs');

            if (response)
            {
                this.callbackLoading = false;
                if (response.length)
                {
                    this.callbackLogs = response;
                    UIkit.modal('#callback_logs').show();
                }
                else
                {
                    UIkit.notification({
                        message: 'There are no stored Callback Logs yet',
                        status: 'danger',
                        pos: 'top-center',
                        timeout: 5000
                    });
                }
            }

        },
        // async updateList() {
        //     const request = await fetch(this.base_url + "index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=orders.updatelist&format=raw&limit=0", {
        //         method: 'post'
        //     });

        //     const response = await request.json();

        //     if (response.success) {


        //     } else {
        //         UIkit.notification({
        //             message: 'There was an error.',
        //             status: 'danger',
        //             pos: 'top-center',
        //             timeout: 5000
        //         });
        //     }
        // },

        async filter() {

            this.filterLoading = true;

            var items = document.querySelectorAll(".el-item");

            items.forEach(item => {
               item.className = 'el-item';
            });

            UIkit.drop('#ordersDateDrop').hide();
            const params = {
                'limit': this.show,
                'offset': (this.currentPage * this.show),
                'searchTerm': (this.searchText ? this.searchText.trim() : ''),
                'status': this.selectedStatus,
                'dateFrom': this.dateFrom,
                'dateTo': this.dateTo,
                'currentSort': this.currentSort,
                'currentSortDir': this.currentSortDir
            };

            const response = await this.makeACall(params , '&type=order.filter');

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
                    this.pages       = 1;
                    this.currentPage = 0;
                }

            }

        },

        async trashSelected() {

            this.filterLoading = true;

            var items = document.querySelectorAll(".el-item");

            items.forEach(item => {
               item.className = 'el-item';
            });

            const params = {
                'items': this.selectedItems
            };

            const response = await this.makeACall(params , '&type=order.trash');

            this.filterLoading = false;
            if (response)
            {
                await this.filter();
                this.selectedItems = [];
            }

        },

        changePage(i) {
            this.currentPage = i;
            this.filter();
        },
        setDateBand(days) {
            const now = this.convertDate(new Date(Date.now()));
            const daysAgo = this.convertDate(new Date(Date.now() - days * 24 * 60 * 60 * 1000));

            this.dateFrom = daysAgo;
            this.dateTo = now;

            this.filter();
        },
        clearSearch() {
            this.clearDates();
            this.cleartext()
            this.selectedStatus = 0;
            this.filter();
        },
        clearDates() {
            this.dateFrom = '';
            this.dateTo = '';
            this.filter();
        },
        cleartext() {
            this.searchText = null;
            this.doTextSearch();
        },
        async doTextSearch(event) {
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
                this.filter();
            }, 600)
        },
        convertDate(date) {
            return date.toLocaleDateString('fr-CA');
        },
        togglePaid(order) {

        },
        sort(s) {
            if (s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'ASC' ? 'DESC' : 'ASC';
            }
            this.currentSort = s;
            this.filter();
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

Vue.createApp(cls_orders).mount('#cls_orders')
