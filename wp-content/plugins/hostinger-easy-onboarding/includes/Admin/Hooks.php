<?php

namespace Hostinger\EasyOnboarding\Admin;

use Hostinger\EasyOnboarding\Helper;
use Hostinger\WpHelper\Utils;

defined( 'ABSPATH' ) || exit;

class Hooks {

	private Helper $helper;
	private const DAY_IN_SECONDS = 86400;

	public function __construct() {
		$this->helper = new Helper();
		add_action( 'admin_footer', array( $this, 'rate_plugin' ) );
		add_action( 'admin_init', array( $this, 'hide_astra_builder_selection_screen' ) );
		add_action( 'admin_init', array( $this, 'enable_woo_onboarding' ) );
		add_action( 'admin_init', array( $this, 'hide_monsterinsight_metabox' ) );
		add_action( 'admin_init', array( $this, 'hide_monsterinsight_notice' ) );
		add_action( 'admin_notices', array( $this, 'omnisend_discount_notice' ) );
		add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

		if ( ! Helper::show_woocommerce_onboarding() ) {
			add_filter( 'admin_body_class', array( $this, 'add_woocommerce_onboarding_class' ) );
		}

		add_action( 'admin_init', array( $this, 'store_ready_message_logic' ), 0 );
		add_action( 'admin_notices', array( $this, 'show_store_ready_message' ), 0 );
		add_action( 'admin_head', array( $this, 'force_woo_notices' ) );
	}

	public function enable_woo_onboarding(): bool {

		if ( defined( 'DOING_AJAX' ) && \DOING_AJAX ) {
			return false;
		}

		if ( ! $this->helper->is_hostinger_admin_page() || ! $this->helper->is_woocommerce_site() ) {
			return false;
		}

		$woocommerce_onboarding_profile = get_option( 'woocommerce_onboarding_profile', null );

		// WooCommerce onboarding already done (skipped).
		if ( ! empty( $woocommerce_onboarding_profile['skipped'] ) ) {
			return false;
		}

		// WooCommerce onboarding already done (completed).
		if ( ! empty( $woocommerce_onboarding_profile['completed'] ) ) {
			return false;
		}

		$woo_onboarding_enabled = get_option( 'hostinger_woo_onboarding_enabled', null );

		if ( $woo_onboarding_enabled === null && get_option( 'hts_new_installation', false ) === 'new' ) {
			update_option( 'hostinger_woo_onboarding_enabled', true, false );
			update_option( 'hts_new_installation', 'old' );
		}

		return true;
	}

	public function rate_plugin(): void {
		$promotional_banner_hidden = get_transient( 'hts_hide_promotional_banner_transient' );
		$two_hours_in_seconds      = 7200;

		if ( $promotional_banner_hidden && time() > $promotional_banner_hidden + $two_hours_in_seconds ) {
			require_once HOSTINGER_EASY_ONBOARDING_ABSPATH . 'includes/Admin/Views/Partials/RateUs.php';
		}
	}

	public function omnisend_discount_notice(): void {
		$omnisend_notice_hidden = get_transient( 'hts_omnisend_notice_hidden' );

		if ( $omnisend_notice_hidden === false && ( $this->helper->is_this_page( '/wp-admin/admin.php?page=omnisend' ) ) && ( Helper::is_plugin_active( 'class-omnisend-core-bootstrap' ) || Helper::is_plugin_active( 'omnisend-woocommerce' ) ) ) : ?>
			<div class="notice notice-info hts-admin-notice hts-omnisend">
				<p><?php echo wp_kses( __( 'Use the special discount code <b>ONLYHOSTINGER30</b> to get 30% off on Omnisend for 6 months when you upgrade.', 'hostinger-easy-onboarding' ), array( 'b' => array() ) ); ?></p>
				<div>
					<a class="button button-primary"
					   href="https://your.omnisend.com/LXqyZ0"
					   target="_blank"><?= esc_html__( 'Get Discount', 'hostinger-easy-onboarding' ); ?></a>
					<button type="button" class="notice-dismiss"></button>
				</div>
			</div>
		<?php endif;
		wp_nonce_field( 'hts_close_omnisend', 'hts_close_omnisend_nonce', true );
	}

	public function hide_astra_builder_selection_screen(): void {
		add_filter( 'st_enable_block_page_builder', '__return_true' );
	}

	/**
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	public function add_woocommerce_onboarding_class( string $classes ): string {

		$classes .= ' hostinger-woocommerce-onboarding-page';

		return $classes;
	}

	/**
	 * @return bool
	 */
	public function store_ready_message_logic(): bool {
		if ( ! Helper::is_woocommerce_site() || ! Helper::woocommerce_onboarding_choice() ) {
			return false;
		}

		if ( isset( $_GET['hide-store-notice'] ) ) {
			update_option( 'hostinger_woo_ready_message_shown', 1 );

			return false;
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function show_store_ready_message(): string {
		if ( ! $this->helper->can_show_store_ready_message() ) {
			return '';
		}

		?>
		<div class="notice notice-hst">
			<h3>
				<?php echo esc_html__( 'Your store is ready!', 'hostinger-easy-onboarding' ); ?>
			</h3>
			<p><?php echo esc_html__( 'One more step to reach your online success. Finalize the visual and technical aspects of your website using our recommendations checklist.', 'hostinger-easy-onboarding' ); ?></p>
			<p>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=hostinger&hide-store-notice' ) ); ?>"
				   class="components-button is-primary"><?php echo esc_html__( 'Visit Hostinger plugin', 'hostinger-easy-onboarding' ); ?></a>
				<a href="<?php echo esc_url( home_url() ); ?>"
				   target="_blank"
				   class="components-button is-secondary"><?php echo esc_html__( 'Preview store', 'hostinger-easy-onboarding' ); ?></a>
			</p>
		</div>
		<?php

		return '';
	}

	/**
	 * @return string
	 */
	public function force_woo_notices(): string {
		if ( ! $this->helper->can_show_store_ready_message() ) {
			return '';
		}
		?>
		<style type="text/css">
            .woocommerce-layout__notice-list-hide {
                display: block !important;
            }

            .notice-hst {
                border-left-color: #673DE6;
            }
		</style>
		<?php

		return '';
	}


	public function hide_monsterinsight_metabox(): void {
		$helper = new Utils();
		$user_id      = get_current_user_id();

		$transient_key = 'metaboxhidden_product_' . $user_id;
		$hide_metabox = get_transient( $transient_key );

		if ( $hide_metabox ) {
			return;
		}

		$hide_metabox = get_user_meta($user_id, 'metaboxhidden_product', true);

		if ( ! $helper->isPluginActive( 'googleanalytics' ) ) {
			return;
		}

		if ( ! is_array( $hide_metabox ) ) {
			$hide_metabox = array();
		}

		if ( $helper->isThisPage( 'post-new.php?post_type=product' ) ) {
			if ( ! in_array( 'monsterinsights-metabox', $hide_metabox ) ) {
				array_push( $hide_metabox, 'monsterinsights-metabox' );
			}

			update_user_meta( $user_id, 'metaboxhidden_product', $hide_metabox );
			set_transient( $transient_key, 'hidden', self::DAY_IN_SECONDS );
		}
	}

	public function hide_monsterinsight_notice(): void {
		if ( Utils::isPluginActive( 'googleanalytics' ) ) {
			define( 'MONSTERINSIGHTS_DISABLE_TRACKING', true );
		}
	}
}
