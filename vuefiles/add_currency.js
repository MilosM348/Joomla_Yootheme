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
                jform_title: '',
                jform_short_description: '',
                jform_long_description: '',
                jform_base_price: '',
                jform_category: '',
                jform_manage_stock: true,
                jform_featured: false,
                jform_taxclass: 'taxrate',
                jform_discount: false,
                jform_teaserimage: '',
                jform_fullimage: '',
                jform_shipping_mode: '',
                jform_publish_up_date: '',
                jform_tags: [],
            }

        };
    },
    created() {

    },
    mounted() {

    },
    computed() {
    },
    async beforeMount() {


    },
    methods: {
        submitForm() {
            this.form.jform_long_description = this.getFrameContents('jform_long_description');
            this.form.jform_short_description = this.getFrameContents('jform_short_description');
            this.form.jform_teaserimage = document.getElementById("jform_teaserimage").value;
            this.form.jform_fullimage = document.getElementById("jform_fullimage").value;
            this.form.jform_publish_up_date = document.getElementById("jform_publish_up_date").value;

            // this.form.jform_tags = [];
            // for (var option of document.getElementById("jform_tags").options) {
            //     this.form.jform_tags.push(option.value);
            // }
            //
            // console.log(this.form);


        },
        getFrameContents(elementId) {
            const iFrame = document.getElementById(elementId + '_ifr');
            let iFrameBody;
            if (iFrame.contentDocument) { // FF
                iFrameBody = iFrame.contentDocument.getElementById('tinymce');
            } else if (iFrame.contentWindow) { // IE
                iFrameBody = iFrame.contentWindow.document.getElementById('tinymce');
            }
            return iFrameBody.innerHTML;
        }
    },
    components: {
        'p-inputswitch': primevue.inputswitch,
        'p-inputnumber': primevue.inputnumber
    }
}

Vue.createApp(p2s_currency_form).mount('#p2s_currency_form')
