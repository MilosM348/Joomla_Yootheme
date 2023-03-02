////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_country_form = {
    data() {
        return {
            base_url: '',
            currency: '',
            locale: '',
            form: {
                jform_id: '',
                jform_country_name: '',
                jform_country_isocode_2: '',
                jform_country_isocode_3: '',
                jform_taxrate: '',
                jform_taxrate_reduced: '',
                jform_taxrate_extra: '',
                jform_requires_vat: false,
                jform_published: true
            },
            andClose: false,
            successMessage: false
        };
    },
    created() {

    },
    mounted() {

    },
    computed() {
    },
    async beforeMount() {

        this.setData();


        const base_url = document.getElementById('base_url');
        try {
            this.base_url = base_url.innerText;
            base_url.remove();
        } catch (err) {
        }

        const currency = document.getElementById('currency');
        try {
            this.currency = JSON.parse(currency.innerText);
            currency.remove();
        } catch (err) {
        }


        const locale = document.getElementById('locale');
        try {
            this.locale = locale.innerText;
            locale.remove();
        } catch (err) {
        }

        const successMessage = document.getElementById('successMessage');
        try {
            this.successMessage = successMessage.innerText;
            successMessage.remove();
        } catch (err) {
        }


    },
    methods: {

        async saveItem() {

            const request = await fetch("index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=country.save&format=raw", {
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
                body: JSON.stringify(this.form)
            });


            const response = await request.json();

            if (response.success) {

                UIkit.notification({
                    message: this.successMessage,
                    status: 'success',
                    pos: 'top-center',
                    timeout: 5000
                });

                if (this.andClose) {
                    // if 'andClose' is true, redirect back to the list page
                    window.location.href = 'index.php?option=com_commercelab_shop&view=countries';
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

    },
    components: {
        'p-inputswitch': primevue.inputswitch
    }
}

Vue.createApp(p2s_country_form).mount('#p2s_country_form')
