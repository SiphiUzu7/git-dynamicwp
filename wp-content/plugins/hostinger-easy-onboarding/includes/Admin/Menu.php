<?php

namespace Hostinger\EasyOnboarding\Admin;

use Hostinger\EasyOnboarding\Admin\Onboarding\Onboarding;

defined( 'ABSPATH' ) || exit;

class Menu {

	public const WEBSITE_LIST_URL = 'https://hpanel.hostinger.com/websites';
	public const WEBSITE_BILLINGS_URL = 'https://hpanel.hostinger.com/billing/subscriptions';
	public const AI_ASSISTANT_URL = '/wp-admin/admin.php?page=hostinger#ai-assistant';

	public function __construct() {
		add_filter( 'hostinger_menu_subpages', array( $this, 'add_menu_sub_pages' ) );
	}

	public function add_menu_sub_pages( $submenus ) {

		$submenus[] = array(
			'page_title' => __( 'Get started', 'hostinger-easy-onboarding' ),
			'menu_title' => __( 'Get started', 'hostinger-easy-onboarding' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'hostinger-get-started',
			'callback'   => array( $this, 'renderGetStarted' ),
			'menu_identifier' => 'home',
			'menu_order' => 11,
		);

		$submenus[] = array(
			'page_title' => __( 'Learn', 'hostinger-easy-onboarding' ),
			'menu_title' => __( 'Learn', 'hostinger-easy-onboarding' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'hostinger-get-learn',
			'callback'   => array( $this, 'renderLearn' ),
			'menu_identifier' => 'learn',
			'menu_order' => 12,
		);

		return $submenus;
	}

	public function renderLearn(): void {
		$onboarding = new Onboarding();
		include_once __DIR__ . '/Views/Learn.php';
	}

	public function renderGetStarted(): void {
		$onboarding = new Onboarding();
		include_once __DIR__ . '/Views/GetStarted.php';
	}
}
