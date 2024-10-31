<?php
/**
 * @author					Kona Macphee <kona@fidgetylizard.com>
 * @since						1.0.0
 * @package					Restricted_Site_Notifier
 *
 * @wordpress-plugin
 * Plugin Name:			Restricted Site Notifier
 * Plugin URI:			https://wordpress.org/plugins/restricted-site-notifier/
 * Description:			Add-on for Restricted Site Access plugin. Displays site's current restriction status in the admin bar. 
 * Version:					1.1
 * Author:					Fidgety Lizard
 * Author URI:			https://fidgetylizard.com
 * Contributors:		fliz, kona 
 * License:					GPL-2.0+
 * License URI:			http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:			restricted-site-notifier
 * Domain Path:			/languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Restricted_Site_Notifier' ) )
{
	class Restricted_Site_Notifier
	{
		/**
		 * Some useful constants
		 */
		const RSA_PLUGIN = 'restricted-site-access/restricted_site_access.php';
		const RSA_CLASS = 'Restricted_Site_Access';
		const RSA_RESTRICTED = '2';
		const RSN_DOMAIN = 'restricted-site-notifier';

		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// Enqueue stylesheet in front end and admin back end
			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'add_styles' ) );

			//Create notifier in admin bar
			add_action( 'admin_bar_menu', array( $this, 'rsa_notifier' ), 100 );

			// Prepare for i18n translations
			add_action( 'init', array( $this, 'load_my_textdomain' ) );
		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			// Nothing to do here
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			// Nothing to do here
		} // END public static function deactivate

		/**
		 * Set up the necessary CSS 
		 */
		public function add_styles()
		{
				 // Add the CSS that styles the admin icon
			wp_enqueue_style(
				'flizrsn-styles',
				plugin_dir_url( __FILE__ ) . 'css/flizrsn-styles.css',
				false
			);
		} // END public function add_styles

		/**
		 * Set things up for i18n
		 */
		public function load_my_textdomain() 
		{
			load_plugin_textdomain( 
				'restricted-site-notifier', 
				FALSE, 
				basename( dirname( __FILE__ ) ) . '/languages/' 
			);
		}

		/**
			* Check if Restricted Site Access is installed and active.
			* @return bool
			*/
		private function rsa_is_running()
		{
			$active = FALSE;
			$single = FALSE;
			$multi = FALSE;
			if ( class_exists( self::RSA_CLASS ) ) {
				$active = TRUE;
			}
			else {
				// Double check in case bbPress is active but not yet available
				if ( is_multisite() ) {
					$plugins = get_site_option( 'active_sitewide_plugins' );
					if ( isset( $plugins[ self::RSA_PLUGIN ] ) ) {
						$multi = TRUE;
					}
				}
				if ( FALSE === $multi ) {
					$single = in_array(
							self::RSA_PLUGIN, get_option( 'active_plugins' ) );
				}
			}
			return ( $active || $multi || $single ); // True if any is true, otw false
		}
		
		/**
		 *
		 */
		function rsa_notifier( $wp_admin_bar ) {

			// Check if we have a suitably-qualified user to see notifications
			// This should catch single-site admins, plus multisite superadmins
			// and admins
			if ( current_user_can( 'activate_plugins' ) ) {

				// Check if Restricted Site Access plugin is active
				if ( TRUE === $this->rsa_is_running() ) {

					// OK, we have admin user and RSA is active: we can proceed

					// Set default notification message and icon to UNLOCKED
					$iconclass = "flizrsn-unlocked";
					$message = __( 'Site access: UNRESTRICTED', self::RSN_DOMAIN );

					// Get current site restriction settings
					$restriction_status = get_option( 'blog_public' );

					// If site is restricted, set notification message and icon to LOCKED
					if ( self::RSA_RESTRICTED === $restriction_status ) {
						$iconclass = "flizrsn-locked";
						$message = __( 'Site access: RESTRICTED', self::RSN_DOMAIN );
					} 

					// Create the admin-bar notifier
					$notifier = array(
							'id' => 'flizrsn-notifier',
							'title' => $message,
							'parent' => false,
							'href' => get_admin_url( null, 'options-reading.php' ),
							'meta' => array( 'class' => $iconclass )
					);
					$wp_admin_bar->add_node($notifier);
				}
			}
		}
	} // END class Restricted_Site_Notifier
} // END if ( ! class_exists( 'Restricted_Site_Notifier' ) )


if ( class_exists( 'Restricted_Site_Notifier' ) )
{
	// Installation and uninstallation hooks
	register_activation_hook(
		__FILE__, 
		array( 'Restricted_Site_Notifier', 'activate' )
	);
	register_deactivation_hook(
		__FILE__, 
		array( 'Restricted_Site_Notifier', 'deactivate' )
	);
	// instantiate the plugin class
	$wp_plugin_template = new Restricted_Site_Notifier();
}
?>
