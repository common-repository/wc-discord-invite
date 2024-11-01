<?php
/**
 * WC Discord Invite
 *
 * @author      Nicola Mustone
 * @license     GPL-2.0+
 *
 * Plugin Name: WC Discord Invite
 * Plugin URI:  https://wordpress.org/plugins/wc-discord-invite/
 * Description: A WooCommerce integration that sends an email with a Discord invite link to the customer when the order status changes from one status to another.
 * Version:     1.0.0
 * Author:      Nicola Mustone
 * Author URI:  https://nicola.blog/
 * Text Domain: wc-discord-invite
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Discord_Invite' ) ) :

/**
 * Main class of the plugin WC Discord Invite. Handles the bot and the admin settings.
 */
class WC_Discord_Invite {
	/**
	* Construct the plugin.
	*/
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		$this->load_textdomain();
	}

	/**
	* Initialize the plugin.
	*/
	public function init() {
		if ( class_exists( 'WC_Integration' ) ) {
			require_once 'class-wc-integration-discord-invite.php';

			add_filter( 'woocommerce_integrations', array( $this, 'add_integration' ) );
		}
	}

	/**
	 * Add a new integration to WooCommerce.
	 */
	public function add_integration( $integrations ) {
		$integrations[] = 'WC_Integration_Discord_invite';
		return $integrations;
	}

	/**
	 * Loads the plugin localization files.
	 */
	public function load_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'wc-discord-invite' );
		load_textdomain( 'wc-discord-invite', WP_LANG_DIR . '/wc-discord-invite/wp-discord-invite-' . $locale . '.mo' );
		load_plugin_textdomain( 'wc-discord-invite', false, plugin_basename( __DIR__ ) . '/languages' );
	}
}

endif;

new WC_Discord_Invite();
