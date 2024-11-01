<?php
/**
 * Discord Invite email
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf(
	__( 'Click %1$shere%2$s to join our Discord server.', 'wc-discord-invite' ),
	'<a href="' . esc_url( get_option( 'woocommerce_discord-invite_invite_link' ) ) . '" title="' . __( 'Discord invite URL', 'wc-discord-invite' ) . '">',
	'</a>'
); ?></p>

<?php
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
