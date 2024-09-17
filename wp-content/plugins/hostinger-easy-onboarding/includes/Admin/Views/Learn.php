<?php

use Hostinger\WpMenuManager\Menus;

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

echo Menus::renderMenuNavigation();

?>

<div class="hsr-learn-more hsr-tab-content" data-name="learn">
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
