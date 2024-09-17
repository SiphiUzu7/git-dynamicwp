import './actions'
import './videos'

( function ( $ ) {
	$( document ).on( 'ready', function () {
		const openClass = 'open';
		let selectedTab = 'Home';
		const stepsTitle = $( '.hsr-onboarding-step--title' )
		const closeBtn = $( '.hsr-close-btn' );
		const navigationItem = $( '.hsr-list__item' );
		const knowledgeCard = $( '#card-knowledge' );
		const helpCard = $( '#card-help' );
		const adminBarGenerateContent = $( '#wp-admin-bar-create_content_with_ai' );

		stepsTitle.on( 'click', function () {
			$( this ).find( '.hsr-onboarding-step--expand' ).toggleClass( openClass );
			$( this ).parent().find( '.hsr-onboarding-step--content' ).slideToggle( 200 );
		} )

		closeBtn.on( 'click', function () {
			$( '.hsr-modal' ).removeClass( 'open' );
			$( 'body' ).removeClass( 'modal-open' );
		} )

		adminBarGenerateContent.click( function () {
			$( '.hsr-list__item' ).removeClass( 'hsr-active' );
			$('.hts-ai-assistant-tab').addClass( 'hsr-active' );
			$( '.hsr-tab-content' ).hide();
			$( ".hsr-tab-content[data-name='ai-assistant']" ).show();
		} );


		helpCard.click( function () {
			window.open( 'https://hostinger.com/cpanel-login?r=jump-to/new-panel/section/help', '_blank' );
		} );
		knowledgeCard.click( function () {
			window.open( 'https://support.hostinger.com/en/?q=WordPress', '_blank' );
		} );

        $('body').on('click', '.hst-open-affiliate-tab', function(e) {
            e.preventDefault();

            window.location = $( 'li.hsr-list__item a.hostinger-amazon-affiliate' ).attr( 'href' );
        } );

        $('body').on('click', '#hst-connect_affiliate_settings', function(e) {
            e.preventDefault();

            window.location = $( 'li.hsr-list__item a.hostinger-amazon-affiliate' ).attr( 'href' );
        } );

		document.querySelectorAll( '.hsr-playlist-item' ).forEach( function ( item ) {
			const firstItem = document.querySelector( '.hsr-playlist-item:first-child' );
			firstItem.classList.add( 'hsr-active-video' );
			firstItem.querySelector( '.hsr-playlist-item-arrow' ).style.visibility = 'visible';
			item.addEventListener( 'click', function () {
				document.querySelectorAll( '.hsr-playlist-item.hsr-active-video' ).forEach( function ( selectedItem ) {
					selectedItem.classList.remove( 'hsr-active-video' );
					selectedItem.querySelector( '.hsr-playlist-item-arrow' ).style.visibility = 'hidden';
				} );
				this.classList.add( 'hsr-active-video' );
				this.querySelector( '.hsr-playlist-item-arrow' ).style.visibility = 'visible';
			} );
		} );

		// Copy nameservers to clipboard
		$(document).ready(function() {
			$('.hts-nameservers svg').click(function() {
				let textToCopy = $(this).closest('div').find('b').text();
				copyTextToClipboard(textToCopy);
			});
		});

		function copyTextToClipboard(text) {
			let textArea = document.createElement('textarea');
			textArea.value = text;
			document.body.appendChild(textArea);
			textArea.select();
			document.execCommand('copy');
			document.body.removeChild(textArea);
		}

		} );

} )( jQuery );
