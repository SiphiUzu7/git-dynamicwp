( function ( $ ) {
	$( document ).on( 'ready', function () {
		let completedClass = 'completed';
		let gotItBtn = $( '.hsr-got-it-btn' );

		gotItBtn.on( 'click', function ( e ) {
			e.preventDefault();
			const element = $( this );
			const step = $( this ).data( 'step' );
			let remaining_tasks = $( '.hsr-onboarding-steps' ).data( 'remaining-tasks' );

			$.ajax( {
				type: 'post',
				dataType: 'json',
				url: hostingerEasyOnboarding.url,
				data: {
					action: 'hostinger_complete_onboarding_step',
					step: step,
					nonce: hostingerEasyOnboarding.nonce,
				},
				success: function () {
					element.closest( '.hsr-onboarding-step--content' ).slideUp()
					element.parents( '.hsr-onboarding-step' )
						.find( '.hsr-onboarding-step--status' )
						.addClass( completedClass )

					if ( remaining_tasks > 0 ) {
						remaining_tasks = remaining_tasks - 1;
						$( '.hsr-onboarding-steps' ).data( 'remaining-tasks', remaining_tasks )

						if ( remaining_tasks === 0 ) {
							$( '.hsr-publish-btn' ).addClass( completedClass );
						}

					}
				},
				error: function ( xhr, status, error ) {
					console.log( 'AJAX request failed: ' + error );
				}
			} )
		} )

		$( ".hsr-promotional-banner .hsr-buttons .close-btn" ).click( function () {
			$.ajax( {
				type: 'post',
				url: hostingerEasyOnboarding.url,
				data: {
					action: 'hostinger_hide_promotional_banner',
					nonce: hostingerEasyOnboarding.nonce,
				},
				success: function () {
					$('.hsr-banner-container').hide();
				},
				error: function ( xhr, status, error ) {
					console.log( 'AJAX request failed: ' + error );
				}
			} )
		} );
	} );
} )( jQuery );
