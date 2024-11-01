<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Email_Discord_Invite', false ) ) :

/**
 * Discord Invite Email.
 *
 * An email sent to the customer when a new order is marked as Completed.
 *
 * @class   WC_Email_Discord_Invite
 * @extends WC_Email
 */
class WC_Email_Discord_Invite extends WC_Email {

	/**
	 * Sets the default data of the email and adds the trigger action.
	 */
	public function __construct() {
		$this->id               = 'discord_invite';
		$this->customer_email   = true;

		$this->title            = __( 'Discord invite', 'wc-discord-invite' );
		$this->description      = __( 'This is a Discord invite sent to the customer when the order status changes.', 'wc-discord-invite' );
		$this->template_html    = 'emails/discord-invite.php';
		$this->template_plain   = 'emails/plain/discord-invite.php';
		$this->placeholders = array(
			'{site_title}'   => $this->get_blogname(),
			'{order_date}'   => '',
			'{order_number}' => '',
		);

		$status_trigger = str_replace( 'wc-', '', get_option( 'woocommerce_discord-invite_order_status', 'wc-completed' ) );

		// Triggers for this email
		add_action( 'woocommerce_order_status_' . $status_trigger . '_notification', array( $this, 'trigger' ), 10, 2 );

		// Call parent constructor
		parent::__construct();
	}

	/**
	 * Get email subject.
	 *
	 * @return string
	 */
	public function get_default_subject() {
		return __( 'Your invite to Discord from {site_title}', 'wc-discord-invite' );
	}

	/**
	 * Get email heading.
	 *
	 * @return string
	 */
	public function get_default_heading() {
		return __( 'You are invited to join our Discord server', 'wc-discord-invite' );
	}

	/**
	 * Trigger the sending of this email.
	 *
	 * @param int      $order_id The order ID.
	 * @param WC_Order $order Order object.
	 * @param bool     $resend
	 */
	public function trigger( $order_id, $order = false, $resend = false ) {
		$this->setup_locale();

		if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
			$order = wc_get_order( $order_id );
		}

		if ( $this->is_invite_sent( $order ) && ! $resend ) {
			return;
		}

		if ( is_a( $order, 'WC_Order' ) ) {
			$this->object                         = $order;
			$this->recipient                      = $this->object->get_billing_email();
			$this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
			$this->placeholders['{order_number}'] = $this->object->get_order_number();
		}

		if ( $this->is_enabled() && $this->get_recipient() ) {
			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );

			$order->add_order_note( __( 'Discord invite sent to the customer.', 'wc-discord-invite' ) );
			$order->update_meta_data( __( 'Discord Invite Sent', 'wc-discord-invite' ), 'yes' );
			$order->save();
		}

		$this->restore_locale();
	}

	/**
	 * Get content html.
	 *
	 * @return string
	 */
	public function get_content_html() {
		return wc_get_template_html( $this->template_html, array(
			'order'         => $this->object,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => false,
			'plain_text'    => false,
			'email'			=> $this,
		), '', plugin_dir_path( __FILE__ ) . 'templates/' );
	}

	/**
	 * Get content plain.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		return wc_get_template_html( $this->template_plain, array(
			'order'         => $this->object,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => false,
			'plain_text'    => true,
			'email'			=> $this,
		), '', plugin_dir_path( __FILE__ ) . 'templates/' );
	}

	/**
	 * Checks if the invite has been already sent for this order.
	 *
	 * @param  WC_Order $order
	 * @return bool
	 */
	public function is_invite_sent( $order ) {
		$invite_sent = $order->get_meta( __( 'Discord Invite Sent', 'wc-discord-invite' ) );
		return 'yes' === $invite_sent;
	}
}

endif;

return new WC_Email_Discord_Invite();
