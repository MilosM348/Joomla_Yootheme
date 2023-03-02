////////////////////////////////////////////////////////////////////////////////
// @package   CommerceLab 
// @author    Cloud Chief - CommerceLab.solutions
// @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
// @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
//

const p2s_setup = {
    data() {
        return {
            base_url: '',
            currency: '',
            locale: '',
            shopName: '',
            shopEmail: '',
            currencies: '',
            selectedCurrency: 4,
            countries: '',
            selectedCountry: 223,
            createCheckout: false,
            createConfirmation: false,
            createTandcs: false,
            createCancel: false,
        };
    },
    created() {

    },
    mounted() {

    },
    computed() {
    },
    async beforeMount() {

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

        const currencies = document.getElementById('currencies_data');
        try {
            this.currencies = JSON.parse(currencies.innerText);
            // currencies.remove();
        } catch (err) {
        }

        const countries = document.getElementById('countries_data');
        try {
            this.countries = JSON.parse(countries.innerText);
            // countries.remove();
        } catch (err) {
        }


    },
    methods: {
        async submitSetup() {
            const params = {
                'shopName': this.shopName,
                'shopEmail': this.shopEmail,
                'selectedCurrency': this.selectedCurrency,
                'selectedCountry': this.selectedCountry,
                'createCheckout': this.createCheckout,
                'createConfirmation': this.createConfirmation,
                'createTandcs': this.createTandcs,
                'createCancel': this.createCancel
            };

            const request = await fetch("index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=setup.init&format=raw", {
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
                UIkit.modal('#first-time-intro-video-modal').show();
                var siteBaseUrl = this.base_url;
                document.getElementById('first_time_intro_video').addEventListener('ended',videoEnded,false);
                function videoEnded(e) {
                    window.location.href = siteBaseUrl + 'index.php?option=com_commercelab_shop';
                }

                // UIkit.notification({
                //     message: 'Done',
                //     status: 'success',
                //     pos: 'bottom-right',
                //     timeout: 5000
                // });
            } else {
                UIkit.notification({
                    message: 'There was an error.',
                    status: 'danger',
                    pos: 'top-center',
                    timeout: 5000
                });
            }

        }
    },
    components: {
        'p-inputswitch': primevue.inputswitch
    }
}

Vue.createApp(p2s_setup).mount('#p2s_setup')
