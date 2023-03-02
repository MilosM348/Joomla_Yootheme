////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_discounts = {
    data() {
        return {
            base_url: '',
            items: [],
            itemsChunked: [],
            currentSort: 'name',
            currentSortDir: 'asc',
            currentPage: 0,
            pages: [],
            pagesizes: [5, 10, 15, 20, 25, 30, 50, 100, 200, 500],
            show: 25,
            enteredText: '',
            publishedOnly: false,
            selected: [],
            confirm_LangString: '',
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
        try {
            this.base_url = base_url.innerText;
            base_url.remove();
        } catch (err) {
        }

        const items_data = document.getElementById('items_data');
        try {
            this.items = JSON.parse(items_data.innerText);
            // items_data.remove();
        } catch (err) {
        }


        const show = document.getElementById('page_size');
        try {
            this.show = show.innerText;
            show.remove();
        } catch (err) {
        }

        const confirmLangString = document.getElementById('confirmLangString');
        try {
            this.confirm_LangString = confirmLangString.innerText;
            confirmLangString.remove();
        } catch (err) {
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
        async trashSelected() {

            await UIkit.modal.confirm(this.confirm_LangString);

            const params = {
                'items': this.selected
            };

            const response = await this.makeACall(params , '&type=discount.trash');

            if (response)
            {
                UIkit.notification({
                    message: 'Item trashed',
                    status: 'success',
                    pos: 'top-center',
                    timeout: 5000
                });
                this.selected = [];
                await this.filter();

            } else {
                UIkit.notification({
                    message: 'There was an error.',
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            }


        },
        async toggleSelected() {

            const params = {
                'items': this.selected
            };

            const response = await this.makeACall(params , '&type=discount.togglePublished');

            if (response)
            {
                UIkit.notification({
                    message: 'Status changed',
                    status: 'success',
                    pos: 'top-center',
                    timeout: 5000
                });
                this.selected = [];
                await this.filter();

            } else {
                UIkit.notification({
                    message: 'There was an error.',
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            }

        },
        async togglePublished(item) {

            this.selected = [];

            this.selected.push(item);

            this.toggleSelected();

        },
        async updateList() {

            const response = await this.makeACall({} , '&type=discounts.updatelist');

            if (response)
            {

            } else {
                UIkit.notification({
                    message: 'There was an error.',
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            }
        },
        async filter() {

            this.loading = true;

            const params = {
                'limit': this.show,
                'offset': (this.currentPage * this.show),
                'searchTerm': (this.enteredText ? this.enteredText.trim() : ''),
                'publishedOnly': this.publishedOnly,
            };

            const response = await this.makeACall(params, '&type=discount.filter');

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
        cleartext(){
            this.enteredText = null;
            this.doTextSearch();
        },
        async doTextSearch(event) {
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
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
        'p-inputswitch': primevue.inputswitch,
    }
}

Vue.createApp(p2s_discounts).mount('#p2s_discounts')
