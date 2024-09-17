<?php

namespace Hostinger\EasyOnboarding\Admin\Onboarding\Steps;

defined( 'ABSPATH' ) || exit;

class AddHeading extends OnboardingStep {
	public function get_title(): string {
		return __( 'Edit site title', 'hostinger-easy-onboarding' );
	}

	public function get_body(): array {
		return array(
			array(
				'title'       => __( 'Go to the Customize page', 'hostinger-easy-onboarding' ),
				'description' => __( 'In the left sidebar, click Appearance to expand the menu. In the Appearance section, click Customize. The Customize page will open.', 'hostinger-easy-onboarding' ),
			),
			array(
				'title'       => __( 'Access the Site identity and edit title', 'hostinger-easy-onboarding' ),
				'description' => __( 'In the left sidebar, click Site Identity and edit your site title.', 'hostinger-easy-onboarding' ),
			),
		);
	}

	public function step_identifier(): string {
		return 'edit_site_title';
	}

	public function get_redirect_link(): string {
		return admin_url( 'customize.php' );
	}

	public function button_text(): string {
		return __( 'Take me there', 'hostinger-easy-onboarding' );
	}
}
