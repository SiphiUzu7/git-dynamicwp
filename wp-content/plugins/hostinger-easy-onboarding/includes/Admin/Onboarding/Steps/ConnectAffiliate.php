<?php

namespace Hostinger\EasyOnboarding\Admin\Onboarding\Steps;

defined( 'ABSPATH' ) || exit;

class ConnectAffiliate extends OnboardingStep {

	private string $amazon_dashboard_url = 'https://advertising.amazon.com/sign-in';

	public function get_title(): string {
		return __( 'Connect Amazon partnership account', 'hostinger-easy-onboarding' );
	}

	public function get_body(): array {
		return array(
			array(
				'title'       => __( 'Login to the Amazon Product Advertising dashboard', 'hostinger-easy-onboarding' ),
				/* translators: %s: link to dashboard */
				'description' => sprintf( __( 'To gather the necessary information, log in to your <a href="%s" target="_blank" rel="noopener">Amazon Product Advertising dashboard</a> using your personal Amazon partnership account.', 'hostinger-easy-onboarding' ), $this->amazon_dashboard_url ),
			),
			array(
				'title'       => __( 'Open the Amazon Affiliate plugin configuration', 'hostinger-easy-onboarding' ),
				/* translators: %s: link to plugin page */
				'description' => sprintf( __( 'Fill in the required details on the <a href="%s" class="hst-open-affiliate-tab">Amazon Affiliate plugin page</a>, where you\'ll find all the necessary information about the plugin.', 'hostinger-easy-onboarding' ), $this->get_redirect_link() ),
			),
			array(
				'title'       => __( 'Copy-Paste the necessary information:', 'hostinger-easy-onboarding' ),
				/* translators: %s: link to dashboard */
				'description' => sprintf( __( 'Complete the form with required information related to Amazon\'s partnership API. Retrieve all this information from the <a href="%s" target="_blank" rel="noopener">Amazon Product Advertising dashboard</a> and paste it into the form.', 'hostinger-easy-onboarding' ), $this->amazon_dashboard_url ),
			),
		);
	}

	public function step_identifier(): string {
		return 'connect_affiliate_settings';
	}

	public function get_redirect_link(): string {
		return admin_url( 'admin.php?page=hostinger' );
	}

	public function button_text(): string {
		return __( 'Connect Amazon Account', 'hostinger-easy-onboarding' );
	}
}
