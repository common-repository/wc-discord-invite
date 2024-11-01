<?php
/**
 * The main integartion class.
 *
 * @class   WC_Integration_Discord_Invite
 * @extends WC_Integration
 */
class WC_Integration_Discord_Invite extends WC_Integration {
	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		$this->id                 = 'discord-invite';
		$this->method_title       = __( 'Discord Invite', 'wc-discord-invite' );
		$this->method_description = __( 'Configure WC Discord Invite to email your customers when their order status changes.', 'wc-discord-invite' );

		$this->init_form_fields();
		$this->init_settings();

		add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_order_actions', array( $this, 'add_order_meta_box_action' ) );
		add_action( 'woocommerce_order_action_wc_discord_invite_resend', array( $this, 'resend_invite' ) );
		add_filter( 'woocommerce_email_classes', array( $this, 'add_email_class' ) );
	}

	/**
	 * Initialize integration settings form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'invite_link' => array(
				'title'       => __( 'Invite Link', 'wc-discord-invite' ),
				'type'        => 'text',
				'description' => __( 'The invite link of your Discord server. This link will be emailed to your customers.', 'wc-discord-invite' ),
				'desc_tip'    => true,
				'default'     => ''
			),
			'order_status' => array(
				'title'       => __( 'Order Status', 'wc-discord-invite' ),
				'type'        => 'select',
				'options'     => wc_get_order_statuses(),
				'desc_tip'    => true,
				'default'     => 'wc-completed',
				'description' => __( 'The order status when to send the invite email to the customer.', 'wc-discord-invite' ),
			),
		);
	}

	/**
	 * Queues the Discord Invite email in WooCommerce.
	 *
	 * @param  array $emails
	 * @return array
	 */
	public function add_email_class( $emails ) {
		$emails['WC_Email_Discord_Invite'] = include( 'class-wc-email-discord-invite.php' );

		return $emails;
	}

	/**
	 * Add a custom action to order actions select box on edit order page
	 *
	 * @param  array $actions Order actions array to display
	 * @return array
	 */
	public function add_order_meta_box_action( $actions ) {
	    global $theorder;

	    if ( 'yes' !== $theorder->get_meta( __( 'Discord Invite Sent', 'wc-discord-invite' ) ) ) {
	        return $actions;
	    }

	    $actions['wc_discord_invite_resend'] = __( 'Resend Discord invite', 'wc-discord-invite' );

	    return $actions;
	}

	/**
	 * Resend the Discord invite email.
	 *
	 * @param WC_Order $order
	 */
	public function resend_invite( $order ) {
		WC()->mailer()->emails['WC_Email_Discord_Invite']->trigger( $order->get_id(), $order, true );
	}
}
