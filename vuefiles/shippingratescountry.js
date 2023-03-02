////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_shippingratescountries_form = {
    data() {
        return {
            base_url: '',
            form: {
                jform_id: '',
                jform_country_id: '',
                jform_weight_from: '',
                jform_weight_to: '',
                jform_cost: '',
                jform_handling_cost: '',
                jform_published: '',
            },
            andClose: false,
            p2s_currency: [],
            p2s_local: false          

        }

    },
    mounted() {},
    computed: {},
    async beforeMount() {

        await this.setData();

        const base_url = document.getElementById('base_url');
        this.base_url = base_url.innerText;
        base_url.remove(); 

        const p2s_currency = document.getElementById('currency');
        if (p2s_currency != null) {
            try {
                this.p2s_currency = JSON.parse(p2s_currency.innerText);
                // p2s_currency.remove();
            } catch (err) {
            }
        }


        const p2s_locale = document.getElementById('locale');
        if (p2s_locale != null) {
            try {
                this.p2s_local = p2s_locale.innerText;
                // p2s_locale.remove();
            } catch (err) {
            }
        }

    },
    methods: {

        async saveItem() {


            const params = {
                itemid: this.form.jform_id,
                country_id: this.form.jform_country_id,
                weight_from: this.form.jform_weight_from,
                weight_to: this.form.jform_weight_to,
                cost: this.form.jform_cost,
                handling_cost: this.form.jform_handling_cost,
                published: (this.form.jform_published ? 1 : 0)
            };


            const request = await fetch("index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=shippingratescountry.save&format=raw", {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-Token': Joomla_cls.token,
                    'Content-Type': 'application/json'
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(params)
            });

            const response = await request.json();


            if (response.success) {

                UIkit.notification({
                    message: 'Saved!',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 5000
                });

                if (this.andClose) {
                    // if 'andClose' is true, redirect back to the discounts list page
                    window.location.href = this.base_url + 'index.php?option=com_commercelab_shop&view=shippingratescountries';
                } else {
                    // if 'andClose' is still false, the user wants to stay on the page.
                    // this line makes sure that a new item gets the ID appended to the URL
                    const url = window.location.href;
                    if (url.indexOf('&id=') == -1) {
                        history.replaceState('', '', url + '&id=' + response.data.id);
                    }

                    // we also need to make sure that the next save action doesn't trigger a create... we do this by adding the id to the form array
                    this.form.jform_id = response.data.id;


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
        setData() {
            const keys = Object.keys(this.form);
            keys.forEach((jfrom) => {
                let theInput = document.getElementById(jfrom + '_data');
                if (theInput) {

                    if (this.hasJsonStructure(theInput.innerText)) {
                        this.form[jfrom] = JSON.parse(theInput.innerText);
                    } else {

                        this.form[jfrom] = theInput.innerText;

                        if (theInput.innerText === "1") {
                            this.form[jfrom] = true;
                        }
                        if (theInput.innerText === "0") {
                            this.form[jfrom] = false;
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
        }
    },
    components: {
        'p-inputswitch': primevue.inputswitch,
        'p-inputnumber': primevue.inputnumber,
        'p-inputtext': primevue.inputtext,
        "p-calendar": primevue.calendar,
        "p-config": primevue.config
    }
}
Vue.createApp(p2s_shippingratescountries_form).mount('#p2s_shippingratescountry_form');