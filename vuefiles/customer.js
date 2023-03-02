////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_customer_form = {
    data() {
        return {
            base_url: '',
            form: {
                jform_id: '',
                jform_name: '',
                jform_email: '',
                jform_j_user_id: '',
                jform_published: '',
                jform_j_user: [],
                jform_orders: [],
                jform_total_orders: '',
                jform_order_total_integer: 0,
                jform_addresses: [],
            },
            countries: [],
            andClose: false,
            deleteConfirmMessage: '',
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
    mounted() {

    },
    computed: {},
    async beforeMount() {

        this.setData();

        const jform = document.getElementById('jform_data');
        try {
            this.jform = JSON.parse(jform.innerText);
            // jform.remove();
        } catch (err) {
        }
        const base_url = document.getElementById('base_url');
        try {
            this.base_url = base_url.innerText;
            // base_url.remove();
        } catch (err) {
        }


        const currency = document.getElementById('currency');
        try {
            this.currency = currency.innerText;
            // currency.remove();
        } catch (err) {
        }


        const locale = document.getElementById('locale');
        try {
            this.locale = locale.innerText;
            // locale.remove();
        } catch (err) {
        }
        const deleteConfirmMessage = document.getElementById('deleteConfirmMessage');
        try {
            this.deleteConfirmMessage = deleteConfirmMessage.innerText;
            deleteConfirmMessage.remove();
        } catch (err) {
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

        async saveItem() {

            let customerSave = new Object();

            customerSave.id        = this.form.jform_id;
            customerSave.name      = this.form.jform_name;
            customerSave.email     = this.form.jform_email;
            customerSave.j_user_id = this.form.jform_j_user_id;
            customerSave.published = (this.form.jform_published ? 1 : 0);

            const params = {
                customer: JSON.stringify(customerSave)
            };

            const response = await this.makeACall(params , '&type=customer.save');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });

                if (this.andClose) {
                    // if 'andClose' is true, redirect back to the discounts list page
                    window.location.href = 'index.php?option=com_commercelab_shop&view=customers';
                } else {
                    // if 'andClose' is still false, the user wants to stay on the page.
                    // this line makes sure that a new item gets the ID appended to the URL

                }

            } else {
                UIkit.notification({
                    message: 'There was an error.',
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            }


        },
        editAddress(address) {
            address.edit = true;
            this.getZones(address)
        },
        async saveAddress(address) {
            address.edit = false;

            delete address.zones;

            const params = {
                address: JSON.stringify(address)
            };

            const response = await this.makeACall(params , '&type=address.save');

            if (response)
            {
                this.updateAddresses();
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });

            }
        },
        async updateAddresses() {
            const params = {
                customer_id: this.form.jform_id,
            };

            const response = await this.makeACall(params , '&type=address.getCustomerAddressList');

            if (response)
            {
                this.form.jform_addresses = response;
            }

        },
        async getZones(address) {
            const params = {
                country_id: address.country
            };

            const response = await this.makeACall(params , '&type=address.getZones');

            if (response)
            {
                address.zones = response;
            }
        },

        async launchDeleteDialog() {
            await UIkit.modal.confirm('<h3>' + this.deleteConfirmMessage + '</h3>');


            const params = {
                'user_id': this.form.jform_j_user_id,
                'customer_id': this.form.jform_id
            };

            const response = await this.makeACall(params , '&type=customer.delete');

            if (response)
            {
                UIkit.notification({
                    message: 'done',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });

                window.location.href = 'index.php?option=com_commercelab_shop&view=customers';

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


                    }
                    theInput.remove();
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
        }
    },
    components: {
        'p-inputswitch': primevue.inputswitch
    }
}
Vue.createApp(p2s_customer_form).mount('#p2s_customer_form');


