<?php
/*
 * Plugin Name: Bernskiold Media Support Widget
 * Plugin URI:  https://www.bernskioldmedia.com
 * Description: A drop-in plugin to enable the support widget that let's you easily contact us at Bernskiold Media with your site question.
 * Version:     1.0.0
 * Author:      Bernskiold Media
 * Author URI:  http://www.bernskioldmedia.com
 *
 * **************************************************************************
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * **************************************************************************
 *
 * @package BernskioldMedia\SupportWidget
 */

namespace BernskioldMedia\SupportWidget;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Class Plugin
 *
 * @package BernskioldMedia\SupportWidget
 */
class Plugin {

	/**
	 * Plugin URL
	 *
	 * @var string
	 */
	public $plugin_url = '';

	/**
	 * Plugin Directory Path
	 *
	 * @var string
	 */
	public $plugin_dir = '';

	/**
	 * Plugin Version Number
	 *
	 * @var string
	 */
	public $plugin_version = '';


	/**
	 * Plugin Class Instance Variable
	 *
	 * @var object
	 */
	protected static $_instance = null;

	/**
	 * Plugin Instantiator
	 *
	 * @return object
	 */
	public static function instance() {

	    if ( is_null( self::$_instance ) ) {
	    	self::$_instance = new self();
	    }

		return self::$_instance;

	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.2
	 */
	private function __clone() {}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.2
	 */
	private function __wakeup() {}

	/**
	 * Constructor
	 */
	public function __construct() {

		// Set Plugin Version.
		$this->plugin_version = '1.0.0';

		// Set plugin Directory.
		$this->plugin_dir = untrailingslashit( plugin_dir_path( __FILE__ ) );

		// Set Plugin URL.
		$this->plugin_url = untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) );

		// Include beacon code.
		add_action( 'admin_print_scripts', array( $this, 'beacon_code' ) );

	}

	public function beacon_code() {

		// Get current user object.
		$current_user = wp_get_current_user();

		// User data.
		$first_name = $current_user->user_firstname;
		$last_name = $current_user->user_lastname;
		$full_name = $first_name . ' ' . $last_name;
		$email = $current_user->user_email;

		// Get current admin screen.
		$screen = get_current_screen();

		// Get current URL
		$url = $this->get_current_url();

		// Get User Locale.
		$locale = get_user_locale( $current_user->ID );

		ob_start(); ?>

		<script type="text/javascript" async defer>
			// HS Beacon
			!function(e,o,n){window.HSCW=o,window.HS=n,n.beacon=n.beacon||{};var t=n.beacon;t.userConfig={},t.readyQueue=[],t.config=function(e){this.userConfig=e},t.ready=function(e){this.readyQueue.push(e)},o.config={docs:{enabled:!1,baseUrl:""},contact:{enabled:!0,formId:"fed36db3-2036-11e7-9841-0ab63ef01522"}};var r=e.getElementsByTagName("script")[0],c=e.createElement("script");c.type="text/javascript",c.async=!0,c.src="https://djtflbt20bdde.cloudfront.net/",r.parentNode.insertBefore(c,r)}(document,window.HSCW||{},window.HS||{});

			// Customization
			HS.beacon.config({
				color: '#e74b3b',
				icon: 'question',
				<?php if ( $locale === 'sv_SE' ) : ?>
				translation: {
					searchLabel: 'Vad kan vi hjälpa dig med?',
					searchErrorLabel: 'Din sökning stängdes. Dubbelkolla gärna din internetanslutning och försök igen.',
					noResultsLabel: 'Inga resultat hittades för',
					contactLabel: 'Skicka ett meddelande',
					attachFileLabel: 'Bifoga en fil',
					attachFileError: 'Den maximala filstorleken är 10mb.',
					fileExtensionError: 'Filformatet du laddade upp är inte tillåtet.',
					nameLabel: 'Ditt namn',
					nameError: 'Vänligen fyll i ditt namn',
					emailLabel: 'Din e-postadress',
					emailError: 'Vänligen fyll i en giltig e-postadress.',
					topicLabel: 'Välj ett område',
					topicError: 'Vänligen välj ett område från listan',
					subjectLabel: 'Ämne',
					subjectError: 'Vänligen ange ett ämne',
					messageLabel: 'Hur kan vi hjälpa dig?',
					messageError: 'Vänligen fyll i ett meddelande',
					sendLabel: 'Skicka',
					contactSuccessLabel: 'Meddelandet skickat!',
					contactSuccessDescription: 'Tack för din supportfråga. Vi kommer återkoppla till dig snarast.'
				},
				instructions: 'Bernskiold Media Helpdesk är här för att hjälpa dig med dina frågor under vårt supportavtal. Har ni inget? Vi har support per timma med!',
				topics: [
					{
						val: 'emergency',
						label: 'Akut'
					},
					{
						val: 'tech-issue',
						label: 'Tekniskt Problem'
					},
					{
						val: 'support-assistance',
						label: 'Supporthjälp'
					},
					{
						val: 'new-features',
						label: 'Ändring/Ny funktion'
					}
				],
				<?php else : ?>
				instructions: 'The Bernskiold Media Helpdesk is here to help you with your questions under the terms of your support agreement. Don\'t have one? We have by-the-hour support too.',
				topics: [
					{
						val: 'emergency',
						label: 'Emergency'
					},
					{
						val: 'tech-issue',
						label: 'Technical Issue'
					},
					{
						val: 'support-assistance',
						label: 'Support Assistance'
					},
					{
						val: 'new-features',
						label: 'Features Request/Change'
					}
				],
				<?php endif; ?>
				poweredBy: false,
				showContactFields: true,
				attachment: true
			});

			HS.beacon.ready(function() {
			  HS.beacon.identify({
			    name: '<?php echo esc_js( $full_name ); ?>',
			    email: '<?php echo esc_js( $email ); ?>',
			    'Current Admin Screen': '<?php echo esc_js( $screen->id ); ?>',
			    'Current URL': '<?php echo esc_js( $url ); ?>'
			  });
			});

		</script>

		<?php
		echo ob_get_clean();

	}

	function get_current_url() {
		$currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		$currentURL .= $_SERVER["SERVER_NAME"];

		if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
		    $currentURL .= ":".$_SERVER["SERVER_PORT"];
		}

		$currentURL .= $_SERVER["REQUEST_URI"];

		return $currentURL;
	}


	/**
	 * Get the Plugin's Directory Path
	 *
	 * @return string
	 */
	public function get_plugin_dir() {
		return $this->plugin_dir;
	}

	/**
	 * Get the Plugin's Directory URL
	 *
	 * @return string
	 */
	public function get_plugin_url() {
		return $this->plugin_url;
	}

	/**
	 * Get the Plugin's Version
	 *
	 * @return string
	 */
	public function get_plugin_version() {
		return $this->plugin_version;
	}

}

function plugin() {
    return Plugin::instance();
}

// Initialize the class instance only once
plugin();
