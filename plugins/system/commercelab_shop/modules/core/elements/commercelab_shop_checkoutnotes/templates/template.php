<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$id = uniqid('yps_checkoutnotes');

$el = $this->el('div', [

    'class' => [
        '{panel_background}',
        '{panel_padding}',
        '{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
    ]

]);

?>

<?= $el($props, $attrs) ?>
    <div id="<?= $id; ?>">
        <textarea 
            class="uk-textarea" rows="<?= $props['rows']; ?>"
            placeholder="<?= $props['placeholder_text']; ?>"
            v-model="input"
            id="yps_checkout_note"><?= $props['note']; ?></textarea>
    </div>


    <script>
        const <?= $id; ?> = {
            data() {
                return {
                    message: '<?= $props['note']; ?>'
                }
            },
            created() {
            },
            methods: {

                async doneTyping() {

                    const params = {
                        'note': this.message,
                    };
                    
                    const request = await fetch('<?= Uri::base() ?>index.php?option=com_ajax&plugin=commercelab_shop_ajaxhelper&method=post&task=task&type=checkoutnote.save&format=raw', {
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

                    } else {
                        UIkit.notification({
                            message: 'There was an error.',
                            status: 'danger',
                            pos: 'top-center',
                            timeout: 5000
                        });
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
            computed: {
                input: {
                    get() {
                        return this.message
                    },
                    set(val) {
                        if (this.timeout) clearTimeout(this.timeout)
                        this.timeout = setTimeout(() => {
                            this.message = val
                            this.doneTyping();
                        }, 300);
                    }
                }
            }
        }


        Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

    </script>
<?= $el->end(); ?>
