<?php

namespace Hostinger\EasyOnboarding\Admin;

use Hostinger\EasyOnboarding\Helper;
use Hostinger\WpHelper\Utils;

defined( 'ABSPATH' ) || exit;

/**
 * Class Hostinger_Admin_Assets
 *
 * Handles the enqueueing of styles and scripts for the Hostinger admin pages.
 */
class Assets {
	/**
	 * @var Helper Instance of the Hostinger_Helper class.
	 */
	private Helper $helper;

	public function __construct() {
		$this->helper = new Helper();
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueues styles for the Hostinger admin pages.
	 */
	public function admin_styles(): void {
		if ( $this->helper->is_hostinger_menu_page() ) {
			wp_enqueue_style( 'hostinger_onboarding_main_styles', HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/css/main.css', array(), HOSTINGER_EASY_ONBOARDING_VERSION );

			$hide_notices = '.notice { display: none !important; }';
			wp_add_inline_style('hostinger_onboarding_main_styles', $hide_notices);

			if ( Helper::show_woocommerce_onboarding() ) {
				wp_enqueue_style( 'hostinger_onboarding_woo_onboarding', HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/css/woo-onboarding.css', array(), HOSTINGER_EASY_ONBOARDING_VERSION );
			}
		}

		wp_enqueue_style( 'hostinger_onboarding_global_styles', HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/css/global.css', array(), HOSTINGER_EASY_ONBOARDING_VERSION );

		if ( $this->helper->is_preview_domain() && is_user_logged_in() ) {
			wp_enqueue_style( 'hostinger-onboarding-preview-styles', HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/css/hts-preview.css', array(), HOSTINGER_EASY_ONBOARDING_VERSION );
		}
		if( Utils::isPluginActive('wpforms')) {
			$hide_wp_forms_counter = '.wp-admin #wpadminbar .wpforms-menu-notification-counter { display: none !important; }';
			wp_add_inline_style( 'hostinger_onboarding_global_styles', $hide_wp_forms_counter );
		}
		if( Utils::isPluginActive('googleanalytics')) {
			$hide_wp_forms_notification = '.wp-admin .monsterinsights-menu-notification-indicator { display: none !important; }';
			wp_add_inline_style( 'hostinger_onboarding_global_styles', $hide_wp_forms_notification );
		}
	}

	/**
	 * Enqueues scripts for the Hostinger admin pages.
	 */
	public function admin_scripts(): void {
		if ( $this->helper->is_hostinger_admin_page() ) {
			wp_enqueue_script(
				'hostinger_onboarding_main_scripts',
				HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/js/main.min.js',
				array(
					'jquery',
					'wp-i18n',
				),
				HOSTINGER_EASY_ONBOARDING_VERSION,
				false
			);
			wp_localize_script(
				'hostinger_onboarding_main_scripts',
				'hostingerEasyOnboarding',
				array(
					'url'   => admin_url( 'admin-ajax.php' ),
					'nonce' => wp_create_nonce( 'hts-ajax-nonce' ),
				)
			);

			if ( Helper::show_woocommerce_onboarding() ) {
				wp_enqueue_script(
					'hostinger_onboarding_woo_onboarding',
					HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/js/woo-onboarding.min.js',
					array(
						'jquery',
						'wp-i18n',
					),
					HOSTINGER_EASY_ONBOARDING_VERSION,
					false
				);
				wp_localize_script(
					'hostinger_onboarding_woo_onboarding',
					'hostingerWoo',
					array(
						'nonce' => wp_create_nonce( 'hts-ajax-nonce' ),
					)
				);
			}
		}

		wp_enqueue_script(
			'hostinger_onboarding_global_scripts',
			HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/js/global-scripts.min.js',
			array(
				'jquery',
				'wp-i18n',
			),
			HOSTINGER_EASY_ONBOARDING_VERSION,
			false
		);

		if ( ! empty( Helper::get_api_token() ) ) {

			wp_enqueue_script(
				'hostinger_onboarding_requests_scripts',
				HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/js/requests.min.js',
				array(
					'jquery',
					'wp-i18n',
				),
				HOSTINGER_EASY_ONBOARDING_VERSION,
				array( 'strategy' => 'defer' )
			);

			wp_localize_script(
				'hostinger_onboarding_requests_scripts',
				'hostingerRequests',
				array(
					'nonce' => wp_create_nonce( 'hts-ajax-nonce' ),
				)
			);
		}
	}
}
