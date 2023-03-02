////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_order_form = {
    data() {
        return {
            base_url: '',
            order: [],
            andClose: false,
            newNoteText: '',
            emailActive: false,
            emailTrackingActive: false,
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

        const base_url = document.getElementById('base_url');
        this.base_url = base_url.innerText;
        base_url.remove();

        const currency = document.getElementById('currency');
        if (currency) {
            this.currency = JSON.parse(currency.innerText);
        }
        currency.remove();

        const locale = document.getElementById('locale');
        if (locale) {
            this.locale = locale.innerText;
        }
        locale.remove();
        const order = document.getElementById('p2s_order');
        try {
            this.order = JSON.parse(order.innerText);
            order.remove();
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

        async getOrder() {

            const params = {
                order_id: this.order.id
            };

            const response = await this.makeACall(params , '&type=order.get');

            if (response)
            {
                this.order = response;
            }
        },

        async saveItem() {

            const params = {
                itemid: this.form.jform_id
            };

            const response = await this.makeACall(params , '&type=order.save');

            if (response)
            {
                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });
            }

        },
        copyOrderToClipboard() {

            let str = '';
            for (const [key, value] of Object.entries(this.order)) {
                str += ` ${key}: ${value} `;
            }
            this.copyToClipboard(str);
        },
        copyToClipboard(str) {

            const el = document.createElement('textarea');
            el.value = str;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        },
        async sendEmail(type) {

            const params = {
                orderid: this.order.id,
                emailtype: type
            };

            const response = await this.makeACall(params , '&type=order.sendemail');

            if (response)
            {
                this.getOrder();
            }

        },
        clearNote() {
            this.newNoteText = '';
        },
        async saveNote() {
            const params = {
                orderid: this.order.id,
                text: this.newNoteText,

            };

            const response = await this.makeACall(params , '&type=order.newnote');

            if (response)
            {

                this.getOrder();
                await UIkit.modal('#addnotemodal').hide();
                this.clearNote();

                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });

            }

        },
        async changeStatus(status) {

            await UIkit.modal.confirm('Are you sure?');

            const params = {
                order_id: this.order.id,
                status: status,
                sendEmail: (this.emailActive) ? 1 : 0
            };

            const response = await this.makeACall(params , '&type=order.updatestatus');

            if (response)
            {
                this.getOrder();
            }
        },
        async saveTracking() {

            await UIkit.modal.confirm('Are you sure?');

            const params = {
                order_id: this.order.id,
                tracking_code: this.order.tracking_code,
                tracking_link: this.order.tracking_link,
                tracking_provider: this.order.tracking_provider,
                sendEmail: this.emailTrackingActive
            };

            const response = await this.makeACall(params , '&type=order.updatetracking');

            if (response)
            {
                this.getOrder();
            }

        },
        async togglePaid() {

            const params = {
                order_id: this.order.id
            };

            const response = await this.makeACall(params , '&type=order.togglepaid');

            if (response)
            {
                this.getOrder();
            }
        },
        setData() {
            const keys = Object.keys(this.form);
            keys.forEach((jfrom) => {
                let theInput = document.getElementById(jfrom + '_data');
                if (theInput) {
                    this.form[jfrom] = theInput.innerText;
                    theInput.remove();
                }

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
        'p-timeline': primevue.timeline,
        'p-avatar': primevue.avatar
    }
}
Vue.createApp(p2s_order_form).mount('#p2s_order_form');
