<?php

namespace Hostinger\EasyOnboarding\Admin;

use Hostinger\EasyOnboarding\Admin\Actions as Admin_Actions;
use Hostinger\EasyOnboarding\Helper;
use Hostinger\WpHelper\Utils as CoreHelper;
use Hostinger\EasyOnboarding\Amplitude\Amplitude;

defined( 'ABSPATH' ) || exit;

class Ajax {
	private const PROMOTIONAL_BANNER_TRANSIENT = 'hts_hide_promotional_banner_transient';
	private const HIDE_OMNISEND_NOTICE = 'hts_omnisend_notice_hidden';
	private const TWO_DAYS = 86400 * 2;
	private const SIX_MONTHS = 15780000;

	private CoreHelper $helper;
	private Amplitude $amplitude;

	public function __construct(
		$helper,
		$amplitude
	) {
		$this->helper    = $helper;
		$this->amplitude = $amplitude;
		add_action( 'init', array( $this, 'define_ajax_events' ), 0 );
	}

	public function define_ajax_events(): void {
		$events = array(
			'complete_onboarding_step',
			'woocommerce_setup_store',
			'hide_promotional_banner',
			'dismiss_omnisend_notice',
			'identify_action',
		);

		foreach ( $events as $event ) {
			add_action( 'wp_ajax_hostinger_' . $event, array( $this, $event ) );
		}

		if ( Helper::is_woocommerce_site() ) {
			add_action( 'wp_ajax_hostinger_woo_onboarding_choice', array( $this, 'woo_onboarding_choice' ) );
		}
	}

	public function identify_action(): void {
		$action = sanitize_text_field( $_POST['action_name'] ) ?? '';

		if ( in_array( $action, Admin_Actions::ACTIONS_LIST, true ) ) {
			setcookie( $action, $action, time() + ( 86400 ), '/' );
			wp_send_json_success( $action );
		} else {
			wp_send_json_error( 'Invalid action' );
		}
	}

	public function hide_promotional_banner(): void {
		$nonce          = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		$transient_key  = self::PROMOTIONAL_BANNER_TRANSIENT;
		$security_check = $this->request_security_check( $nonce );

		if ( ! empty( $security_check ) ) {
			wp_send_json_error( $security_check );
		}

		if ( false === get_transient( $transient_key ) ) {
			set_transient( $transient_key, time(), self::TWO_DAYS );
		}

		wp_send_json_success( array() );
	}

	public function complete_onboarding_step(): void {
		$step  = isset( $_POST['step'] ) ? sanitize_text_field( $_POST['step'] ) : '';
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';

		$security_check = $this->request_security_check( $nonce );

		if ( ! empty( $security_check ) ) {
			wp_send_json_error( $security_check );
		}

		$completed_steps = get_option( 'hostinger_onboarding_steps', array() );

		if ( ! in_array( $step, array_column( $completed_steps, 'action' ), true ) ) {
			$completed_steps[] = array(
				'action' => $step,
				'date'   => gmdate( 'Y-m-d H:i:s' ),
			);
		}
		$this->helper::updateSetting( 'onboarding_steps', $completed_steps );

		wp_send_json_success( array() );
	}

	public function woocommerce_setup_store(): void {
		$nonce        = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		$event_action = isset( $_POST['event_action'] ) ? sanitize_text_field( $_POST['event_action'] ) : '';

		$security_check = $this->request_security_check( $nonce );

		if ( ! empty( $security_check ) ) {
			wp_send_json_error( $security_check );
		}

		$this->amplitude->setup_store( $event_action );

		wp_send_json_success( array() );
	}

	public function request_security_check( $nonce ) {
		if ( ! wp_verify_nonce( $nonce, 'hts-ajax-nonce' ) ) {
			return 'Invalid nonce';
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return 'Lack of permissions';
		}

		return false;
	}

	public function woo_onboarding_choice(): void {
		$nonce          = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		$choice         = isset( $_POST['choice'] ) ? sanitize_text_field( $_POST['choice'] ) : '';
		$security_check = $this->request_security_check( $nonce );

		if ( ! empty( $security_check ) ) {
			wp_send_json_error( $security_check );
		}

		$allowed_choices = array(
			'woocommerce',
			'hostinger',
		);

		if ( ! in_array( $choice, $allowed_choices, true ) || empty( $choice ) ) {
			wp_send_json_error( __( 'Something went wrong. Try again.', 'hostinger-easy-onboarding' ) );
		}

		$base_url = 'https://' . $this->helper->getHostInfo() . '/';

		$redirect_url = '';

		switch ( $choice ) {
			case 'woocommerce':
				$redirect_url = $base_url . 'wp-admin/admin.php?page=wc-admin&path=' . rawurlencode( '/setup-wizard' );

				add_option( 'hostinger_woo_ready_message_shown', 0 );

				break;
			case 'hostinger':
				$redirect_url = $base_url . 'wp-admin/admin.php?page=hostinger';
				break;
		}

		update_option( 'hostinger_woo_onboarding_choice_value', $choice, false );
		update_option( 'hostinger_woo_onboarding_choice', true, false );

		if ( has_action( 'litespeed_purge_all' ) ) {
			do_action( 'litespeed_purge_all' );
		}

		$response = array(
			'redirect_url' => $redirect_url,
		);

		wp_send_json_success( $response );
	}

	public function dismiss_omnisend_notice(): void {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'hts_close_omnisend' ) ) {
			wp_send_json_error( 'Invalid nonce' );
		}

		set_transient( self::HIDE_OMNISEND_NOTICE, true, self::SIX_MONTHS );

	}

}
