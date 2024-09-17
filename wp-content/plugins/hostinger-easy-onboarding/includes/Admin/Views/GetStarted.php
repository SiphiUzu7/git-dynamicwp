<?php

namespace Hostinger\EasyOnboarding\Admin\Views\Onboarding;
use Hostinger\WpMenuManager\Menus;
use Hostinger\EasyOnboarding\Helper;
use Hostinger\EasyOnboarding\Admin\Onboarding\Steps\OnboardingStep;

defined( 'ABSPATH' ) || exit;

$helper = new Helper();
/** @var Onboarding $hostinger_onboarding_steps */
$hostinger_onboarding_steps = $onboarding;
$hostinger_content          = $hostinger_onboarding_steps->get_content();
$hostinger_remaining_tasks  = 0;

/** @var OnboardingStep $hostinger_step */
foreach ( $hostinger_onboarding_steps->get_steps() as $hostinger_step ) {
	$hostinger_remaining_tasks = ! $hostinger_step->completed() ? ++$hostinger_remaining_tasks : $hostinger_remaining_tasks;
}
$hostinger_videos = array(
	array(
		'id'       => 'WkbQr5dSGLs',
		'title'    => __( 'How to Add Your WordPress Website to Google Search Console', 'hostinger-easy-onboarding' ),
		'duration' => '4:24',
	),
	array(
		'id'       => 'PDGdAjmgN3Y',
		'title'    => __( 'How to Create a WordPress Contact Us Page', 'hostinger-easy-onboarding' ),
		'duration' => '2:48',
	),
	array(
		'id'       => '4NxiM_VXFuE',
		'title'    => __( 'How to Clear Cache in WordPress Website', 'hostinger-easy-onboarding' ),
		'duration' => '3:21',
	),
	array(
		'id'       => 'WHXtmEppbn8',
		'title'    => __( 'How to Edit the Footer in WordPress', 'hostinger-easy-onboarding' ),
		'duration' => '6:27',
	),
	array(
		'id'       => 'drC7cgDP3vU',
		'title'    => __( 'LiteSpeed Cache: How to Get 100% WordPress Optimization', 'hostinger-easy-onboarding' ),
		'duration' => '13:29',
	),
	array(
		'id'       => 'WdmfWV11VHU',
		'title'    => __( 'How to Back Up a WordPress Site', 'hostinger-easy-onboarding' ),
		'duration' => '8:26',
	),
	array(
		'id'       => 'YK-XO7iLyGQ',
		'title'    => __( 'How to Import Images Into WordPress Website', 'hostinger-easy-onboarding' ),
		'duration' => '1:44',
	),
	array(
		'id'       => 'suvkDYwTCfg',
		'title'    => __( 'How to Set Up WordPress SMTP', 'hostinger-easy-onboarding' ),
		'duration' => '2:30',
	),
);

$hostinger_additional_tabs = apply_filters( 'hostinger_plugin_additional_tabs', array() );

?>
<div class="hsr-overlay"></div>


<?php echo Menus::renderMenuNavigation(); ?>
<?php


if ( ! Helper::show_woocommerce_onboarding() ) { ?>
	<div class="hostinger hsr-onboarding hsr-tab-content" data-name="home">
		<h2 class="hsr-onboarding__title"><?php echo esc_html( $hostinger_content['title'] ); ?></h2>
		<p class="hsr-onboarding__description"><?php echo esc_html( $hostinger_content['description'] ); ?></p>
		<div data-remaining-tasks="<?php echo esc_attr( $hostinger_remaining_tasks ); ?>" class="hsr-onboarding-steps">
			<?php
			$can_open_accordion = true;
			/** @var OnboardingStep $hostinger_step */
			foreach ( $hostinger_onboarding_steps->get_steps() as $hostinger_step ) :
				?>
				<div class="hsr-onboarding-step <?php echo esc_html( $hostinger_step->step_identifier() ); ?>">
					<div class="hsr-onboarding-step--title">
						<?php $completed_class = $hostinger_step->completed() ? 'completed' : ''; ?>
						<span class="hsr-onboarding-step--status <?php echo esc_html( $completed_class ); ?>"></span>
						<h4><?php echo esc_html( $hostinger_step->get_title() ); ?></h4>
						<?php
						$class_name = '';
						if ( $can_open_accordion && ! $hostinger_step->completed() ) {
							$class_name         = 'open';
							$can_open_accordion = false;
						}
						?>
						<div class="hsr-onboarding-step--expand <?php echo esc_html( $class_name ); ?>"></div>
					</div>
					<div class="hsr-onboarding-step--content <?php echo esc_html( $class_name ); ?>">
						<?php foreach ( $hostinger_step->get_body() as $key => $item ) : ?>
							<?php $counter = $key + 1; ?>
							<div class="hsr-onboarding-step--body">
								<?php
								if ( ! empty( $item['title'] ) ) {
									?>
									<span class='hsr-onboarding-step--body__counter'><?php echo esc_html( $counter ); ?></span>
									<?php
								}
								?>
								<div class="hsr-onboarding-step--body__content">
									<?php
									if ( ! empty( $item['title'] ) ) {
										?>
										<div class="hsr-onboarding-step--body__title">
											<h4><?php echo esc_html( $item['title'] ); ?></h4>
										</div>
										<?php
									}
									?>
									<p>
										<?php echo $item['description']; ?>
									</p>
								</div>
							</div>
						<?php endforeach; ?>
						<div class="hsr-onboarding-step--footer">
							<a data-step="<?php echo esc_attr( $hostinger_step->step_identifier() ); ?>"
							   class="hsr-btn hsr-secondary-btn hsr-got-it-btn"
							   href="#"><?php echo esc_html__( 'Got it!', 'hostinger-easy-onboarding' ); ?></a>
							<a class="hsr-btn hsr-primary-btn"
							   id="hst-<?php echo esc_html( $hostinger_step->step_identifier() ); ?>"
							   rel="noopener noreferrer"
							   href="<?php echo esc_url( $hostinger_step->get_redirect_link() ); ?>">
								<?php echo esc_html( $hostinger_step->button_text() ); ?>
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<?php
			$preview_btn = 'hsr-preview';
			$completed   = $hostinger_remaining_tasks === 0 ? 'completed' : '';
			?>
			<a class="hsr-btn hsr-primary-btn hsr-no-bg-btn hsr-publish-btn <?php echo esc_html( $completed ); ?> <?php echo esc_html( $preview_btn ); ?>"
			   href="<?php echo esc_url( $hostinger_content['btn']['url'] ); ?>"><?php echo esc_html( $hostinger_content['btn']['text'] ); ?></a>
			<a target="_blank" class="hsr-btn hsr-primary-btn hsr-no-bg-btn hsr-preview-btn <?php echo esc_html( $preview_btn ); ?>"
			   href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_html( $hostinger_content['btn']['text'] ); ?></a>
		</div>
		<div class="hsr-modal hsr-publish-modal">
			<div class="hsr-publish-overlay"></div>
			<div class="hsr-publish-modal--body">
				<div class="hsr-circular">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd"
						      d="M48 24C48 37.2548 37.2548 48 24 48C10.7452 48 0 37.2548 0 24C0 10.7452 10.7452 0 24 0C37.2548 0 48 10.7452 48 24ZM45.3333 24C45.3333 35.7821 35.7821 45.3333 24 45.3333C12.2179 45.3333 2.66667 35.7821 2.66667 24C2.66667 12.2179 12.2179 2.66667 24 2.66667C35.7821 2.66667 45.3333 12.2179 45.3333 24Z"
						      fill="#EBE4FF"/>
						<mask id="mask0_7023_11690" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
						      width="48" height="48">
							<path fill-rule="evenodd" clip-rule="evenodd"
							      d="M48 24C48 37.2548 37.2548 48 24 48C10.7452 48 0 37.2548 0 24C0 10.7452 10.7452 0 24 0C37.2548 0 48 10.7452 48 24ZM45.3333 24C45.3333 35.7821 35.7821 45.3333 24 45.3333C12.2179 45.3333 2.66667 35.7821 2.66667 24C2.66667 12.2179 12.2179 2.66667 24 2.66667C35.7821 2.66667 45.3333 12.2179 45.3333 24Z"
							      fill="white"/>
						</mask>
						<g mask="url(#mask0_7023_11690)">
							<path d="M24 0H48V48H0.333333L0 24H24V0Z" fill="#673DE6"/>
						</g>
					</svg>
				</div>

				<div class="hsr-success-circular">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd"
						      clip-rule="evenodd"
						      d="M48 24C48 37.2548 37.2548 48 24 48C10.7452 48 0 37.2548 0 24C0 10.7452 10.7452 0 24 0C37.2548 0 48 10.7452 48 24ZM45.3333 24C45.3333 35.7821 35.7821 45.3333 24 45.3333C12.2179 45.3333 2.66667 35.7821 2.66667 24C2.66667 12.2179 12.2179 2.66667 24 2.66667C35.7821 2.66667 45.3333 12.2179 45.3333 24Z"
						      fill="#EBE4FF"/>
						<mask id="mask0_7023_11585" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
						      width="48" height="48">
							<path fill-rule="evenodd" clip-rule="evenodd"
							      d="M48 24C48 37.2548 37.2548 48 24 48C10.7452 48 0 37.2548 0 24C0 10.7452 10.7452 0 24 0C37.2548 0 48 10.7452 48 24ZM45.3333 24C45.3333 35.7821 35.7821 45.3333 24 45.3333C12.2179 45.3333 2.66667 35.7821 2.66667 24C2.66667 12.2179 12.2179 2.66667 24 2.66667C35.7821 2.66667 45.3333 12.2179 45.3333 24Z"
							      fill="white"/>
						</mask>
						<g mask="url(#mask0_7023_11585)">
							<circle cx="24" cy="24" r="24" fill="#00B090"/>
						</g>
						<mask id="mask1_7023_11585" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="15" y="17"
						      width="19" height="15">
							<path fill-rule="evenodd" clip-rule="evenodd"
							      d="M33.4438 19.0002L20.9992 31.4448L15.0547 25.5002L16.9992 23.5557L20.9992 27.5557L31.4992 17.0557L33.4438 19.0002Z"
							      fill="#00B090"/>
						</mask>
						<g mask="url(#mask1_7023_11585)">
							<path d="M17 22.5L14 25.5L21 32.5L34.5 19L31.5 16L21 26.5L17 22.5Z" fill="#00B090"/>
						</g>
					</svg>
				</div>

				<h3><?php echo esc_html__( 'Publishing website', 'hostinger-easy-onboarding' ); ?></h3>
				<p class="hsr-publish-modal--body__description"><?php echo esc_html__( 'This can take some time', 'hostinger-easy-onboarding' ); ?></p>
				<div class="hsr-publish-modal--footer">
					<a class="hsr-btn hsr-outline-btn hsr-close-btn" href="#"><?php echo esc_html__( 'Close', 'hostinger-easy-onboarding' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="hsr-learn-more hsr-tab-content" data-name="learn" style="display: none;">
		<div class="hsr-learn-page-container">
			<div class="hsr-tutorial-wrapper">
				<div class="hsr-wrapper-header">
					<div class="hsr-header-title"><?php echo esc_html__( 'WordPress tutorials', 'hostinger-easy-onboarding' ); ?></div>
					<div class="hsr-header-youtube">
						<a href="https://www.youtube.com/@HostingerAcademy?sub_confirmation=1"
						   class="hsr-hostinger-youtube-link" target="_blank" rel="noopener noreferrer">
							<img class="hsr-youtube-logo"
							     src="<?php echo esc_url( HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/images/youtube-icon.svg' ); ?>"
							     alt="youtube logo">
							<div class="hsr-youtube-title"><?php echo esc_html__( 'Hostinger Academy', 'hostinger-easy-onboarding' ); ?></div>
						</a>
					</div>
				</div>
				<div class="hsr-video-wrapper">
					<div class="hsr-video-content">
						<div class="hsr-main-video">
							<video
								id="hts-video-player"
								class="video-js vjs-big-play-centered vjs-default-skin"
								controls
								preload="auto"
								fluid="true"
								poster="//img.youtube.com/vi/WkbQr5dSGLs/maxresdefault.jpg"
								data-setup='{"techOrder": ["youtube"], "sources": [{
		"type": "video/youtube", "src":
		"https://www.youtube.com/watch?v=WkbQr5dSGLs"}] }'
							>
						</div>
						<div class="hsr-main-video-info">
							<div class="hsr-main-video-title">
								<?php echo esc_html__( 'How to Add Your WordPress Website to Google Search Console', 'hostinger-easy-onboarding' ); ?>
							</div>
						</div>
					</div>
					<div class="hsr-hsr-playlist-wrapper">
						<div class="hsr-playlist">
							<?php
							foreach ( $hostinger_videos as $item ) {
								?>
								<div class="hsr-playlist-item" id="hsr-playlist-item"
								     data-title="<?php echo esc_attr( $item['title'] ); ?>" data-id="<?php echo esc_attr( $item['id'] ); ?>" data-video-src="https://www.youtube.com/watch?v=<?php echo esc_html( $item['id'] ); ?>">
									<div class="hsr-playlist-item-arrow">
										<img class="hsr-arrow-icon"
										     src="<?php echo esc_url( HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/images/play-icon.svg' ); ?>"
										     alt="play arrow">
									</div>
									<div class="hsr-playlist-item-thumbnail">
										<img class="hsr-thumbnail-image"
										     src="https://img.youtube.com/vi/<?php echo esc_html( $item['id'] ); ?>/default.jpg"
										     alt="video thumbnail">
									</div>
									<div class="hsr-playlist-item-info">
										<div class="hsr-playlist-item-title"><?php echo esc_html( $item['title'] ); ?></div>
										<div class="hsr-playlist-item-time"><?php echo esc_html( $item['duration'] ); ?></div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="hsr-help-wrapper">
				<div class="hsr-help-card" id="card-knowledge">
					<div class="hsr-card-logo">
						<img class="hsr-logo-image"
						     src="<?php echo esc_url( HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/images/knowledge-icon.svg' ); ?>"
						     alt="knowledge image">
					</div>
					<div class="hsr-card-info">
						<div class="hsr-card-title"><?php echo esc_html__( 'Knowledge Base', 'hostinger-easy-onboarding' ); ?></div>
						<div class="hsr-card-description"><?php echo esc_html__( 'Find the answers you need in our Knowledge Base', 'hostinger-easy-onboarding' ); ?></div>
					</div>
				</div>
				<div class="hsr-help-card" id="card-help">
					<div class="hsr-card-logo">
						<img class="hsr-logo-image"
						     src="<?php echo esc_url( HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/images/help-icon.svg' ); ?>"
						     alt="help image">
					</div>
					<div class="hsr-card-info">
						<div class="hsr-card-title"><?php echo esc_html__( 'Help Center', 'hostinger-easy-onboarding' ); ?></div>
						<div class="hsr-card-description"><?php echo esc_html__( 'Get in touch with our live specialists', 'hostinger-easy-onboarding' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if ( has_action( 'hostinger_ai_assistant_tab_view' ) && current_user_can( 'edit_posts' ) ) : ?>
		<!--AI ASSISTANT-->
		<div class="hostinger hsr-tab-content hsr-ai-assistant-tab" data-name="ai-assistant" style="display: none;">
			<?php do_action( 'hostinger_ai_assistant_tab_view' ); ?>
		</div>
	<?php endif; ?>

	<?php

	if ( ! empty( $hostinger_additional_tabs ) ) :
		foreach ( $hostinger_additional_tabs as $key => $value ) :
			$tab_key = sanitize_title( $key );
			?>

			<div class="hostinger hsr-tab-content" data-name="<?php echo esc_attr( $tab_key ); ?>" style="display: none;">
				<?php do_action( 'hostinger_plugin_additional_tab_content_' . sanitize_title( $key ) ); ?>
			</div>

		<?php
		endforeach;
	endif;

	?>

	<?php
	$promotional_banner_hidden = get_transient( 'hts_hide_promotional_banner_transient' );

	if ( ! $promotional_banner_hidden ) {
		require_once HOSTINGER_EASY_ONBOARDING_ABSPATH . 'includes/Admin/Views/Partials/PromotionalBanner.php';
	}
} else {
	?>
	<div class="hostinger hostinger-woo-onboarding">

		<div class="hostinger-woo-onboarding__wrap">

			<div class="hostinger-woo-onboarding__column hostinger-woo-onboarding__column--is-first">

				<div class="hostinger-woo-onboarding__welcome-heading">
					<h2><?php echo esc_html__( 'Welcome to WordPress!', 'hostinger-easy-onboarding' ); ?> 👋</h2>
					<h2><?php echo esc_html__( 'What do you want to do next?', 'hostinger-easy-onboarding' ); ?></h2>
				</div>

				<div class="hostinger-woo-onboarding__welcome-paragraph">
					<p>
						<?php echo esc_html__( 'Congratulations for finishing your hosting set-up and make your website online! Here are the steps that you can do after setting up your hosting plan.', 'hostinger-easy-onboarding' ); ?>
					</p>
				</div>

				<div class="hostinger-woo-onboarding__radio-wrap">
					<input type="radio" id="hostinger_onboarding_setup" name="chosen_onboarding" value="woocommerce"
					       data-button-label="<?php echo esc_attr( __( 'Setup store', 'hostinger-easy-onboarding' ) ); ?>"
					       data-image-path="<?php echo esc_url( HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/images/woo-onboarding.png' ); ?>"
					       checked />
					<label
						for="hostinger_onboarding_setup"
						class="hostinger-woo-onboarding__radio-label"
					>
						<div class="hostinger-woo-onboarding__radio-label-title">
							<?php echo esc_html__( 'Set up my online store', 'hostinger-easy-onboarding' ); ?> <span class="hostinger-woo-onboarding__info-label hostinger-woo-onboarding__info-label--is-green"><?php echo esc_html__( 'Recommended for you', 'hostinger-easy-onboarding' ); ?></span>
						</div>
						<div class="hostinger-woo-onboarding__radio-label-description">
							<?php
							echo wp_kses(
								__(
									'Prepare your online store for success by entering store details, adding products, and configuring payment methods with the intuitive assistance of <b>WooCommerce</b>.',
									'hostinger-easy-onboarding'
								),
								array(
									'b' => array(),
								)
							);
							?>
						</div>
					</label>
				</div>

				<div class="hostinger-woo-onboarding__radio-wrap">
					<input type="radio" id="hostinger_onboarding_woo" name="chosen_onboarding" value="hostinger"
					       data-button-label="<?php echo esc_attr( __( 'Start customization', 'hostinger-easy-onboarding' ) ); ?>"
					       data-image-path="<?php echo esc_url( HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/images/hostinger-onboarding.png' ); ?>"
					/>
					<label for="hostinger_onboarding_woo" class="hostinger-woo-onboarding__radio-label">
						<div class="hostinger-woo-onboarding__radio-label-title">
							<?php echo esc_html__( 'Customize my website', 'hostinger-easy-onboarding' ); ?>
						</div>
						<div class="hostinger-woo-onboarding__radio-label-description">
							<?php echo esc_html__( 'Customize the visual and technical aspects of your website – personalize themes, explore plugins, or preview your website. Don’t worry, we will help you by giving the step-by-step tutorial to do it.', 'hostinger-easy-onboarding' ); ?>
						</div>
					</label>
				</div>

				<div class="hostinger-woo-onboarding__button-wrap">
					<a class="hsr-btn hsr-primary-btn js-complete-woo-onboarding" href="/wp-admin/admin.php?page=hostinger">
						<?php echo esc_html__( 'Setup store', 'hostinger-easy-onboarding' ); ?>
					</a>
					<a class="hsr-btn hsr-secondary-btn" href="<?php echo esc_url( home_url() ); ?>" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
							<path d="M5.5 21.5C4.95 21.5 4.47917 21.3042 4.0875 20.9125C3.69583 20.5208 3.5 20.05 3.5 19.5V5.5C3.5 4.95 3.69583 4.47917 4.0875 4.0875C4.47917 3.69583 4.95 3.5 5.5 3.5H11.5C11.7833 3.5 12.0208 3.59583 12.2125 3.7875C12.4042 3.97917 12.5 4.21667 12.5 4.5C12.5 4.78333 12.4042 5.02083 12.2125 5.2125C12.0208 5.40417 11.7833 5.5 11.5 5.5H5.5V19.5H19.5V13.5C19.5 13.2167 19.5958 12.9792 19.7875 12.7875C19.9792 12.5958 20.2167 12.5 20.5 12.5C20.7833 12.5 21.0208 12.5958 21.2125 12.7875C21.4042 12.9792 21.5 13.2167 21.5 13.5V19.5C21.5 20.05 21.3042 20.5208 20.9125 20.9125C20.5208 21.3042 20.05 21.5 19.5 21.5H5.5ZM19.5 6.9L10.9 15.5C10.7167 15.6833 10.4833 15.775 10.2 15.775C9.91667 15.775 9.68333 15.6833 9.5 15.5C9.31667 15.3167 9.225 15.0833 9.225 14.8C9.225 14.5167 9.31667 14.2833 9.5 14.1L18.1 5.5H15.5C15.2167 5.5 14.9792 5.40417 14.7875 5.2125C14.5958 5.02083 14.5 4.78333 14.5 4.5C14.5 4.21667 14.5958 3.97917 14.7875 3.7875C14.9792 3.59583 15.2167 3.5 15.5 3.5H21.5V9.5C21.5 9.78333 21.4042 10.0208 21.2125 10.2125C21.0208 10.4042 20.7833 10.5 20.5 10.5C20.2167 10.5 19.9792 10.4042 19.7875 10.2125C19.5958 10.0208 19.5 9.78333 19.5 9.5V6.9Z" fill="#673DE6"/>
						</svg>
						<?php echo esc_html__( 'Preview my website', 'hostinger-easy-onboarding' ); ?>
					</a>
				</div>
			</div>
			<div class="hostinger-woo-onboarding__column hostinger-woo-onboarding__column--is-second">
				<img
					src="<?php echo esc_url( HOSTINGER_EASY_ONBOARDING_ASSETS_URL . '/images/woo-onboarding.png' ); ?>"
					title="<?php echo esc_attr( __( 'Hostinger easy onboarding', 'hostinger-easy-onboarding' ) ); ?>"
					class="hostinger-woo-onboarding__image"
				>
			</div>
		</div>

	</div>
	<?php
}
?>
