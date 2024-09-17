<?php

namespace Hostinger\EasyOnboarding\Admin\Onboarding\Steps;

defined( 'ABSPATH' ) || exit;

class AddPost extends OnboardingStep {
	public function get_title(): string {
		return __( 'Create your first blog post', 'hostinger-easy-onboarding' );
	}

	public function get_body(): array {
		return array(
			array(
				'title'       => __( 'Create a catchy headline', 'hostinger-easy-onboarding' ),
				'description' => __( 'Create a headline that grabs your visitors attention and accurately represents the content of your post.', 'hostinger-easy-onboarding' ),
			),
			array(
				'title'       => __( 'Draft your post', 'hostinger-easy-onboarding' ),
				'description' => __( 'Write your content, making sure to include relevant keywords and images. You can use different blocks to create headings, paragraphs, lists, and other types of content.', 'hostinger-easy-onboarding' ),
			),
			array(
				'title'       => __( 'Proofread and publish', 'hostinger-easy-onboarding' ),
				'description' => __( 'Once you have finished drafting your post, read it over to check for errors, make any necessary revisions, and then publish it to your blog.', 'hostinger-easy-onboarding' ),
			),
		);
	}

	public function step_identifier(): string {
		return 'add_post';
	}

	public function get_redirect_link(): string {
		return admin_url( 'post-new.php' );
	}

	public function button_text(): string {
		return __( 'Take me there', 'hostinger-easy-onboarding' );
	}
}
