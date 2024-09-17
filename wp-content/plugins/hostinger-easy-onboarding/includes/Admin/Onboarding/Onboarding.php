<?php

namespace Hostinger\EasyOnboarding\Admin\Onboarding;

use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\AddDescription;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\AddHeading;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\AddImage;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\ConnectAffiliate;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\SetupStore;
use Hostinger\EasyOnboarding\Settings;
use Hostinger\EasyOnboarding\Helper;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\AddLogo;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\AddPost;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\AddPage;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\ConnectDomain;

defined( 'ABSPATH' ) || exit;

class Onboarding {
	private function load_steps(): array {
		$steps        = array();
		$website_type = Settings::get_setting( 'survey.website.type' );

		if ( get_theme_support( 'custom-logo' ) ) {
			$steps[] = new AddLogo();
		}

		if ( $website_type === Settings::WEBSITE_TYPE_BLOG ) {
			$steps[] = new AddPost();
		} else {
			$steps[] = new AddDescription();
		}

		$steps[] = new AddImage();
		$steps[] = new AddHeading();
		$steps[] = new AddPage();

		if ( Helper::is_plugin_active( 'hostinger-affiliate-plugin' ) ) {
			$steps[] = new ConnectAffiliate();
		}

		if ( class_exists( 'WooCommerce' ) ) {
			$steps[] = new SetupStore();
		}

		$steps[] = new ConnectDomain();

		return $steps;
	}

	public function get_steps(): array {
		return $this->load_steps();
	}

	public function get_content(): array {

		return array(
			'title'       => __( 'Website is published', 'hostinger-easy-onboarding' ),
			'description' => __( 'You can access this guide material any time when updating your website', 'hostinger-easy-onboarding' ),
			'btn'         => array(
				'text'  => __( 'Preview website', 'hostinger-easy-onboarding' ),
				'class' => 'hsr-btn hsr-primary-btn hsr-publish-btn',
				'url'   => home_url(),
			),
		);

	}
}
