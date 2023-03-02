////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_currency_form = {
    data() {
        return {
            form: {
                jform_id: '',
                jform_name: '',
                jform_iso: '',
                jform_currencysymbol: '',
                jform_rate: 1,
                jform_default: '',
                jform_published: true
            },
            andClose: false,
            base_url: '',
            p2s_currency: [],
            p2s_locale: false
        };
    },
    created() {

    },
    mounted() {

    },
    computed() {
    },
    async beforeMount() {

        await this.setData();

        const base_url = document.getElementById('base_url');
        this.base_url = base_url.innerText;
        base_url.remove();

        const currency = document.getElementById('currency');
        if (currency) {
            this.p2s_currency = JSON.parse(currency.innerText);
        }
        currency.remove();

        const locale = document.getElementById('locale');
        if (locale) {
            this.p2s_locale = locale.innerText;
        }
        locale.remove();
        const jform_rate = document.getElementById('jform_rate_data');
        if (jform_rate) {
            this.form.jform_rate = jform_rate.innerText;
        } else {
            this.form.jform_rate = 1;
        }
        // jform_rate.remove();

    },
    methods: {

        toggle() {
            this.hasErroraccess = !this.hasErroraccess;
        },

        async saveItem() {

            const params = {
                currency_id: this.form.jform_id,
                name: this.form.jform_name,
                currencysymbol: this.form.jform_currencysymbol,
                iso: this.form.jform_iso,
                rate: this.form.jform_rate,
                default: (this.form.jform_default ? 1 : 0),
                published: (this.form.jform_published ? 1 : 0)
            };

            const request = await fetch("index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=currencies.save&format=raw", {
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
                    window.location.href = 'index.php?option=com_commercelab_shop&view=currencies';
                } else {
                    // if 'andClose' is still false, the user wants to stay on the page.
                    // this line makes sure that a new item gets the ID appended to the URL
                    const url = window.location.href;
                    if (url.indexOf('&id=') == -1) {
                        history.replaceState('', '', url + '&id=' + response.data.id);
                    }

                    // we also need to make sure that the next save action doesn't trigger a create... we do this by adding the id to the form array
                    this.form.jform_id = response.data.id;
                    this.form.jform_name = response.data.name;
                    this.form.jform_iso = response.data.iso;
                    this.form.jform_currencysymbol = response.data.currencysymbol;
                    this.form.jform_rate = response.data.rate;

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
       async setData() {
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

    },
    components: {
        'p-inputswitch': primevue.inputswitch
    }
}

Vue.createApp(p2s_currency_form).mount('#p2s_currency_form')
