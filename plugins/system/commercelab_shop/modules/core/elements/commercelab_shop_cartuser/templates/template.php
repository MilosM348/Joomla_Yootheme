<?php
/**
 * @package   CommerceLab 
 * @author    Cloud Chief - CommerceLab.solutions
 * @copyright Copyright (C) 2022 CommerceLab  - CommerceLab.solutions
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
// use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
// use Joomla\CMS\Component\ComponentHelper;
// use Joomla\Registry\Registry;

// use function YOOtheme\app;

// use CommerceLabShop\Config\ConfigFactory;
// use CommerceLabShop\Cart\CartFactory;
use CommerceLabShop\User\UserFactory;


$el = $this->el('div', [

	'class' => [
		'{panel_background}',
		'{panel_padding}',
		'{panel_color_inverse}',
        'uk-margin-top uk-margin-bottom'
	]

]);

if ($props['panel_title']) {

	$title = $this->el($props['title_element'], [

	    'class' => [
	        'uk-{title_style}',
	        'uk-heading-{title_decoration}',
	        'uk-font-{title_font_family}',
	        'uk-text-{title_color} {@!title_color: background}',
	    ]

	]);

}

if ($props['loggedin_message']) {

	$loggedin = $this->el($props['loggedin_message_element'], [

	    'class' => [
	        'uk-{loggedin_message_style}',
	        'uk-heading-{loggedin_message_decoration}',
	        'uk-font-{loggedin_message_font_family}',
	        'uk-text-{loggedin_message_color} {@!loggedin_message_color: background}',
	    ]

	]);

}

$showguest_message = $guestcheckout_button_message = $guestcheckout_message = '';
if ($props['showguest']) {

	$guestcheckout_button_message = $props['guestcheckout_button_message'];

	$showguest_message = $this->el($props['showguest_message_element'], [

	    'class' => [
	        'uk-{showguest_message_style}',
	        'uk-heading-{showguest_message_decoration}',
	        'uk-font-{showguest_message_font_family}',
	        'uk-text-{showguest_message_color} {@!showguest_message_color: background}',
	    ]

	]);

	$guestcheckout_message = $this->el($props['showguest_message_element'], [

	    'class' => [
	        'uk-{showguest_message_style}',
	        'uk-heading-{showguest_message_decoration}',
	        'uk-font-{showguest_message_font_family}',
	        'uk-text-{showguest_message_color} {@!showguest_message_color: background}',
	    ]

	]);

}

$tabs_button_text      = ($props['tabs_button_text'] != '') ? $props['tabs_button_text'] : 'Proceed';
$tabs_button_alignment = $props['tabs_button_alignment'];
$tabs_button_size      = $props['tabs_button_size'];
$tabs_button_type      = $props['tabs_button_type'];
$isGuestCheckout       = $props['isGuestCheckout'];

$tabs_first  = $props['tabs_first'];
$tabs_second = $props['tabs_second'];
$tabs_third  = $props['tabs_third'];

$tabs = [];
if ($props['show' . $tabs_first]) {
	$tabs[$tabs_first] = count($tabs);
}
if ($props['show' . $tabs_second]) {
	$tabs[$tabs_second] = count($tabs);
}
if ($props['show' . $tabs_third]) {
	$tabs[$tabs_third] = count($tabs);
}

$id         = uniqid('yps_loginreg');
$shownCount = count($props['shown']);

// Load Language Files
$language = Factory::getLanguage();
$language->load('com_commercelab_shop', JPATH_ADMINISTRATOR);
$language->load('mod_user', JPATH_ADMINISTRATOR);

?>

<?= $el($props, $attrs) ?>

	<div id="<?= $id; ?>" class="uk-animation-fade uk-animation-fast cls-element-container" data-validation="<?= $node->props['required_status'] ?>">

		<!-- Panel Title -->
		<?php if ($props['panel_title']) : ?>

			<?= $title($props, $attrs) ?>
				<?= $props['panel_title'] ?>
			<?= $title->end(); ?>

		<?php endif; ?>

		<!-- User Logged In -->
		<?php if (!UserFactory::getActiveUser()->guest & $props['show_loggedin']) : ?>

			<?php if ($props['loggedin_message']) : ?>
				<?= $loggedin($props, $attrs) ?>
					<?= str_replace('[user_name]', UserFactory::getActiveUser()->name, $props['loggedin_message']) ?>
				<?= $loggedin->end(); ?>
			<?php endif; ?>

			<?php if (false) : ?>
				<?php $route = 'index.php?option=com_users&task=user.logout&' . Session::getFormToken() . '=1'; ?>
				<a href="<?= Route::_($route); ?>" class="uk-button uk-button-default">
					<?= Text::_('JLOGOUT'); ?>
				</a>
			<?php endif; ?>

		<?php endif; ?>


		<?php if (UserFactory::getActiveUser()->guest) : ?>
			<div class="uk-animation-fade uk-animation-fast">
				
				<?php if ($shownCount > 1) : ?>
			        <ul id="form_tabs_<?= $id ?>" class="<?= ($props['nav_type'] == 'uk-tab')
			            ? 'uk-tab'
			            : 'uk-subnav uk-subnav-pill'
			        ?>" <?= ($props['nav_type']); ?>="connect: #form_connect_<?= $id ?>; animation: uk-animation-fade">

			        	<!-- First Tab -->
						<?php if ($props['show' . $tabs_first]) : ?>
			            <li
			            	:class="{
			            		'': (isGuestCheckout && '<?= $tabs_first ?>' != 'guest'), 
			            		'': (isGuestCheckout && '<?= $tabs_first ?>' == 'guest')
			            	}"
			            	class="<?= $tabs_first ?> <?= ($isGuestCheckout && $tabs_first == 'guest') ? 'uk-active' : '' ?>"
			            >
			            	<!-- class="<?= $tabs_first ?> <?= ($isGuestCheckout && $tabs_first == 'guest') ? 'uk-active' : (($isGuestCart && $tabs_first != 'guest') ? 'uk-disabled' : '') ?>"> -->
			            	<a
			            		@click="checkIfShouldBeGuest('<?= $tabs_first ?>')"
			            		href="#"><?= ($props['show'.$tabs_first.'_text'] == '') ?  ucfirst($tabs_first) : $props['show'.$tabs_first.'_text']; ?></a>
			           </li>
						<?php endif; ?>

			        	<!-- Second Tab -->
						<?php if ($props['show' . $tabs_second]) : ?>
			            <li 
			            	:class="{
			            		'': (isGuestCheckout && '<?= $tabs_second ?>' != 'guest'), 
			            		'': (isGuestCheckout && '<?= $tabs_second ?>' == 'guest')
			            	}" 
			            	class="<?= $tabs_second ?> <?= ($isGuestCheckout && $tabs_second == 'guest') ? 'uk-active' : '' ?>"
			            >
			            	<a 
				            	@click="checkIfShouldBeGuest('<?= $tabs_second ?>')"
			            		href="#"><?= ($props['show'.$tabs_second.'_text'] == '') ?  ucfirst($tabs_second) : $props['show'.$tabs_second.'_text']; ?></a>
			           </li>
						<?php endif; ?>
						
			        	<!-- Third Tab -->
						<?php if ($props['show' . $tabs_third]) : ?>
			            <li :class="{
			            		'': (isGuestCheckout && '<?= $tabs_third ?>' != 'guest'), 
			            		'': (isGuestCheckout && '<?= $tabs_third ?>' == 'guest')
			            	}"
			            	class="<?= $tabs_third ?> <?= ($isGuestCheckout && $tabs_third == 'guest') ? 'uk-active' : '' ?>"
			            >
			            	<!-- class="<?= $tabs_third ?> <?= ($isGuestCheckout && $tabs_third == 'guest') ? 'uk-active' : (($isGuestCart && $tabs_third != 'guest') ? 'uk-disabled' : '') ?>"> -->
			            	<a
				            	@click="checkIfShouldBeGuest('<?= $tabs_third ?>')"
			            		href="#"><?= ($props['show'.$tabs_third.'_text'] == '') ?  ucfirst($tabs_third) : $props['show'.$tabs_third.'_text']; ?></a>
			           </li>
						<?php endif; ?>

			        </ul>
				<?php endif; ?>

			    <div v-cloak class="uk-alert-danger" uk-alert v-show="formErrors">
			        <a class="uk-alert-close" uk-close></a>
			        <b><?= Text::_('COM_COMMERCELAB_SHOP_ELM_CART_USER_ALERT_ERROR_IN_ADDRESS_FORM'); ?></b>
			        <ul>
			            <li v-for="error in formErrorsList">{{ error }}</li>
			        </ul>
			    </div>

			    <ul id="form_connect_<?= $id ?>" class="<?= ($shownCount > 1) ? 'uk-switcher' : 'uk-list' ?> uk-margin">

			    	<!-- First Tab -->
					<?php if ($props['show' . $tabs_first]) : ?>
			        	<li class="<?= $tabs_first ?>">
	        			<?= $this->render("{$__dir}/forms/".$tabs_first, compact('props', 'showguest_message', 'guestcheckout_button_message', 'guestcheckout_message', 'attrs' , 'tabs_button_size', 'tabs_button_type', 'tabs_button_text', 'tabs_button_alignment', 'isGuestCheckout')) ?>
			        	</li>
					<?php endif; ?>

			    	<!-- Second Tab -->
					<?php if ($props['show' . $tabs_second]) : ?>
			        	<li class="<?= $tabs_second ?>">
	        			<?= $this->render("{$__dir}/forms/".$tabs_second, compact('props', 'showguest_message', 'guestcheckout_button_message', 'guestcheckout_message', 'attrs' , 'tabs_button_size', 'tabs_button_type', 'tabs_button_text', 'tabs_button_alignment', 'isGuestCheckout')) ?>
			        	</li>
					<?php endif; ?>

			    	<!-- Third Tab -->
					<?php if ($props['show' . $tabs_third]) : ?>
			        	<li class="<?= $tabs_third ?>">
	        			<?= $this->render("{$__dir}/forms/".$tabs_third, compact('props', 'showguest_message', 'guestcheckout_button_message', 'guestcheckout_message', 'attrs' , 'tabs_button_size', 'tabs_button_type', 'tabs_button_text', 'tabs_button_alignment', 'isGuestCheckout')) ?>
			        	</li>
					<?php endif; ?>

			    </ul>
			</div>

		<?php endif; ?>

	</div>


	<script>
	    const <?= $id; ?> = {
	        data() {
	            return {
	            	tabsIndexes: <?= json_encode($tabs) ?>,
	                reg_form: {
	                    username: '',
	                    password: '',
	                    password2: '',
	                    name: '',
	                    email: '',
	                },
	                login_form: {
	                    username: '',
	                    password: ''
	                },
	                formErrors: '',
	                formErrorsList: '',
	                loading: false,
                    isGuestCheckout: <?= $props['isGuestCheckout'] ? 'true' : 'false' ?>,
                    isValidStatus: <?= $props['isValidStatus'] ? 'true' : 'false' ?>,
	                globalValidationStatus: <?= $props['globalValidationStatus'] ?>,
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

	        	if (this.tabsIndexes.guest === 0) {
	        		this.setAsGuest();
	        	}
	        	// console.log(UIkit.tab('#form_tabs_<?= $id ?>'));

	        	emitter.on('yps_cart_validation_update', this.setValidationStatus);

	        	emitter.on('yps_cart_set_as_guest', this.setAsGuest);
	        	emitter.on('yps_cart_unset_as_guest', this.unsetAsGuest);
	        },

	        async beforeMount() {},
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
	        	// Validation Methods Accross Checkout Elements
	        	async setValidationStatus(status) {
					this.globalValidationStatus = status;
					this.isValidStatus          = <?= $props['required_status'] ?> <= status;
	        	},

                // Validates it's own Validation Status
                async validateStatus() {

                    const params = {
                        'required_status': <?= $props['required_status'] ?>
                    };

		            const response = await this.makeACall(params , '&type=checkout.validatestatus');

		            if (response)
		            {
                        this.isValidStatus = true;
                    } else {
                        this.isValidStatus = false;
                    }
                },

                // get Updated Global Validation Status
                async getValidationStatus(notify) {

                    const params = {};

		            const response = await this.makeACall(params , '&type=checkout.validationstatus');

                    this.globalValidationStatus = response;
                    if (notify) {
						emitter.emit("yps_cart_validation_update", response);
                    }
                },
	        	// Internal Actions
                async checkIfShouldBeGuest(tab) {

                	if (tab != 'guest' && this.isGuestCheckout) {
                		this.unsetAsGuest();
                	}

                	if (tab == 'guest' && !this.isGuestCheckout) {
                		this.setAsGuest();
                	}
                },
                async setAsGuest() {

                	if (this.isGuestCheckout) {
                		return;
                	}

		            const response = await this.makeACall({} , '&type=cart.setasguest');

		            if (response)
		            {
                        this.isGuestCheckout = true;
                        emitter.emit("yps_cart_guest_update", true);

						UIkit.tab('#form_tabs_<?= $id ?>').show(this.tabsIndexes.guest);
						// UIkit.util.on('#form_tabs_<?= $id ?>', 'show', function(event, area) {
						// 	console.log('event', event);
						// });
						this.getValidationStatus(true);

		        	}
                },

                async unsetAsGuest() {

		            const response = await this.makeACall({} , '&type=cart.unsetasguest');

		            if (response)
		            {
                        this.isGuestCheckout = false;
						this.getValidationStatus(true);

                        emitter.emit("yps_cart_guest_update");

		        	}
                },

	            async submitRegisterForm() {

					this.loading   = true;
					const response = await this.makeACall(this.reg_form , '&type=user.register');
					this.loading   = false;

		            if (response.status === 'ok')
		            {
                        UIkit.notification({
                            message: '<span uk-icon=\'icon: check\'>' + response.message + '</span>',
                            status: 'success',
                            pos: 'top-center'
                        });
                        location.reload();
                    }
                    else
                    {
						this.formErrors     = response.error;
						this.formErrorsList = response.errorsList;
                    }
	            },
	            async submitLoginForm() {

					this.loading   = true;
					const response = await this.makeACall(this.login_form , '&type=user.login');
					this.loading   = false;

		            if (response.status === 'ok')
		            {
                        UIkit.notification({
                            message: '<span uk-icon=\'icon: check\'>' + response.message + '</span>',
                            status: 'success',
                            pos: 'top-center'
                        });
                        location.reload();
                    }
                    else
                    {
						this.formErrors     = response.error;
						this.formErrorsList = response.errorsList;
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

	        }
	    }

	    Vue.createApp(<?= $id; ?>).mount('#<?= $id; ?>')

	</script>

<?= $el->end(); ?>