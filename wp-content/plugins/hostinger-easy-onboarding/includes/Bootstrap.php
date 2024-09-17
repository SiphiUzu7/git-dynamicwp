<?php

namespace Hostinger\EasyOnboarding;
use Hostinger\EasyOnboarding\Amplitude\Amplitude;
use Hostinger\WpHelper\Requests\Client;
use Hostinger\WpHelper\Constants;
use Hostinger\WpHelper\Utils as Helper;
use Hostinger\WpHelper\Config;
use \Hostinger\Surveys\Rest as SurveysRest;
use Hostinger\EasyOnboarding\Loader;
use Hostinger\EasyOnboarding\Settings;
use Hostinger\EasyOnboarding\I18n;
use Hostinger\EasyOnboarding\Updates;
use Hostinger\EasyOnboarding\Admin\Surveys;
use Hostinger\EasyOnboarding\Admin\Assets as AdminAssets;
use Hostinger\EasyOnboarding\Admin\Hooks as AdminHooks;
use Hostinger\EasyOnboarding\Admin\Menu as AdminMenu;
use Hostinger\EasyOnboarding\Admin\Ajax as AdminAjax;
use Hostinger\EasyOnboarding\Admin\Redirects as AdminRedirects;
use Hostinger\EasyOnboarding\Preview\Assets as PreviewAssets;
use Hostinger\EasyOnboarding\Admin\Onboarding\Settings as OnboardingSettings;
use Hostinger\EasyOnboarding\Admin\Onboarding\AutocompleteSteps;
use Hostinger\Surveys\SurveyManager;
use Hostinger\Amplitude\AmplitudeManager;

defined( 'ABSPATH' ) || exit;

class Bootstrap {
	protected Loader $loader;

	public function __construct() {
		$this->loader = new Loader();
	}

	public function run(): void {
		$this->load_dependencies();
		$this->set_locale();
		$this->loader->run();
	}

	private function load_dependencies(): void {
		$this->load_onboarding_dependencies();
		$this->load_public_dependencies();


		if ( is_admin() ) {
			$this->load_admin_dependencies();
		}
	}

	private function set_locale() {
		$plugin_i18n = new I18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	private function load_admin_dependencies(): void {
		new Updates();
		new AdminAssets();
		new AdminHooks();
		new AdminMenu();
		new AdminRedirects();
		$helper = new Helper();
		$config = new Config();
		$client = new Client(
			$config->getConfigValue( 'base_rest_uri', Constants::HOSTINGER_REST_URI ),
			[
				Config::TOKEN_HEADER  => $helper->getApiToken(),
				Config::DOMAIN_HEADER => $helper->getHostInfo(),
			]
		);

		if ( class_exists( SurveyManager::class ) ) {
			$surveysRest = new SurveysRest($client);
			$surveyManager = new SurveyManager( $helper, $config, $surveysRest );
			$surveys = new Surveys( $surveyManager );
			$surveys->init();
		}

		$amplitudeManager = new AmplitudeManager( $helper, $config, $client );
		$amplitudeEvents = new Amplitude( $helper, $amplitudeManager );
		new AdminAjax( $helper, $amplitudeEvents );

	}

	private function load_public_dependencies(): void {
		new PreviewAssets();
		new Hooks();
	}

	private function load_onboarding_dependencies(): void {
		if ( ! OnboardingSettings::all_steps_completed() ) {
			new AutocompleteSteps();
		}
	}
}
