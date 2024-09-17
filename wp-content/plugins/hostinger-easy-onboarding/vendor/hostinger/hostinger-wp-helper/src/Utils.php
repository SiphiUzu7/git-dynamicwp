<?php

namespace Hostinger\WpHelper;

class Utils {
  
	private static string $apiTokenFile;

	private const HPANEL_DOMAIN_URL = 'https://hpanel.hostinger.com/websites/';

	private static function getApiTokenPath(): void {
		$hostingerDirParts = explode( '/', __DIR__ );
		if ( count( $hostingerDirParts ) >= 3 ) {
			$hostingerServerRootPath = '/' . $hostingerDirParts[1] . '/' . $hostingerDirParts[2];
			self::$apiTokenFile      = $hostingerServerRootPath . '/.api_token';
		}
	}

	// Check if a specific plugin is active by its slug
	public static function isPluginActive( $pluginSlug ): bool {
		$activePlugins = get_option( 'active_plugins', [] );
		foreach ( $activePlugins as $activePlugin ) {
			if ( strpos( $activePlugin, $pluginSlug . '.php' ) !== false ) {
				return true;
			}
		}

		return false;
	}

	// Get the content of the API token file
	public static function getApiToken(): string {
		self::getApiTokenPath();

		if ( file_exists( self::$apiTokenFile ) ) {
			$apiToken = file_get_contents( self::$apiTokenFile );
			if ( ! empty( $apiToken ) ) {
				return $apiToken;
			}
		}

		return '';
	}

	// Get the host info (domain, subdomain, subdirectory)
	public function getHostInfo(): string {
		$host     = $_SERVER['HTTP_HOST'] ?? '';
		$site_url = get_site_url();
		$site_url = preg_replace( '#^https?://#', '', $site_url );

		if ( ! empty( $site_url ) && ! empty( $host ) && strpos( $site_url, $host ) === 0 ) {
			if ( $site_url === $host ) {
				return $host;
			} else {
				return substr( $site_url, strlen( $host ) + 1 );
			}
		}

		return $host;
	}

	// Check if the current domain is a preview domain
	public function isPreviewDomain(): bool {
		if ( function_exists( 'getallheaders' ) ) {
			$headers = getallheaders();
		}

		if ( isset( $headers['X-Preview-Indicator'] ) && $headers['X-Preview-Indicator'] ) {
			return true;
		}

		return false;
	}

	// Check if the current page is the specified page
	public function isThisPage( string $page ): bool {

		if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
			return false;
		}

		$current_uri = sanitize_text_field( $_SERVER['REQUEST_URI'] );

		if ( defined( 'DOING_AJAX' ) && \DOING_AJAX ) {
			return false;
		}

		if ( isset( $current_uri ) && strpos( $current_uri, '/wp-json/' ) !== false ) {
			return false;
		}

		if ( strpos( $current_uri, $page ) !== false ) {
			return true;
		}

		return false;
	}

	// Get Hpanel domain URL
	public function getHpanelDomainUrl(): string {
		$parsed_url = parse_url( get_site_url() );
		$host       = $parsed_url['host'];
		$host_parts = explode( '.', $host );
		$subdomain  = ( count( $host_parts ) > 2 ) ? array_shift( $host_parts ) . '.' : '';
		$domain     = implode( '.', $host_parts );

		return self::HPANEL_DOMAIN_URL . $domain . ( $subdomain ? "/wordpress/dashboard/$subdomain$domain" : '' );
	}
	// Check transient eligibility
	public function checkTransientEligibility( $transient_request_key, $cache_time = 3600 ): bool {
		try {
			// Set transient
			set_transient( $transient_request_key, true, $cache_time );

			// Check if transient was set successfully
			if ( false === get_transient( $transient_request_key ) ) {
				throw new \Exception( 'Unable to create transient in WordPress.' );
			}

			// If everything is fine, return true
			return true;
		} catch ( \Exception $exception ) {
			// If there's an exception, log the error and return false
			$this->errorLog( 'Error checking eligibility: ' . $exception->getMessage() );

			return false;
		}
	}

	public function errorLog( string $message ): void {
		if ( defined( 'WP_DEBUG' ) && \WP_DEBUG === true ) {
			error_log( print_r( $message, true ) );
		}
	}

	public static function getSetting( string $setting ): string {

		if ( $setting ) {
			return get_option( 'hostinger_' . $setting, '' );
		}

		return '';
	}

	public static function updateSetting( string $setting, $value, $autoload = null ): void {

		if ( $setting ) {
			update_option( 'hostinger_' . $setting, $value, $autoload );
		}
	}


}
