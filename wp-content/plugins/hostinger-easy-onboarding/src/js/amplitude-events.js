( function ( $ ) {
	$( document ).on( 'ready', function () {
		$('.woocommerce-layout__main').on('click', '.woocommerce-profiler-setup-store__button', function () {
			$.ajax( {
				url: ajaxurl,
				method: 'POST',
				data: {
					action: 'hostinger_woocommerce_setup_store',
					nonce: hostingerRequests.nonce,
					event_action: 'wp_admin.woocommerce_onboarding.setup_store'
				},
				success: function ( data ) {
				},
				error: function ( xhr, status, error ) {
					console.log( 'AJAX request failed: ' + error );
				}
			} );
		});
	} );

} )( jQuery );
