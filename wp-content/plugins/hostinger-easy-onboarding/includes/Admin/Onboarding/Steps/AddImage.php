<?php

namespace Hostinger\EasyOnboarding\Admin\Onboarding\Steps;

defined( 'ABSPATH' ) || exit;

class AddImage extends OnboardingStep {
	public function get_title(): string {
		return __( 'Upload an image', 'hostinger-easy-onboarding' );
	}

	public function get_body(): array {
		return array(
			array(
				'title'       => __( 'Find the Media page', 'hostinger-easy-onboarding' ),
				'description' => __( 'In the left sidebar, find the Media button. The Media Library page allows you to edit, view, and delete media previously uploaded to your website.', 'hostinger-easy-onboarding' ),
			),
			array(
				'title'       => __( 'Upload an image', 'hostinger-easy-onboarding' ),
				'description' => __( 'To upload a new image, click on Add New button on the Media Library page and select files.', 'hostinger-easy-onboarding' ),
			),
			array(
				'title'       => __( 'Edit an image', 'hostinger-easy-onboarding' ),
				'description' => __( 'If you wish to edit the image, click on the chosen image and click the Edit Image button. You can now crop, rotate, flip or scale the selected image.', 'hostinger-easy-onboarding' ),
			),
		);
	}

	public function step_identifier(): string {
		return 'image_upload';
	}

	public function get_redirect_link(): string {
		return admin_url( 'media-new.php' );
	}

	public function button_text(): string {
		return __( 'Take me there', 'hostinger-easy-onboarding' );
	}
}
