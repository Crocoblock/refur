/**
 * Debouncedresize: special jQuery event that happens once after a window resize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 */
(function( $ ) {

	'use strict';

	var $event = $.event,
		$special,
		resizeTimeout;

	$special = $event.special.debouncedresize = {
		setup: function() {
			$( this ).on( 'resize', $special.handler );
		},
		teardown: function() {
			$( this ).off( 'resize', $special.handler );
		},
		handler: function( event, execAsap ) {
			var context = this,
				args = arguments,
				dispatch = function() {

					// Set correct event type
					event.type = 'debouncedresize';
					$event.dispatch.apply( context, args );
				};

			if ( resizeTimeout ) {
				clearTimeout( resizeTimeout );
			}

			execAsap ?
				dispatch() :
				resizeTimeout = setTimeout( dispatch, $special.threshold );
		},
		threshold: 150
	};

})( jQuery );

/**
 * Custom Refur JS inits etc.
 */
( function($) {

	"use strict";

	/**
	 * Calculate header slogan position
	 */
	$(window).load( function() {

		var $headerWrap     = $( '.page-header-wrap' ),
			$siteHeader     = $( '.site-header', $headerWrap ),
			$headerShowcase = $( '.header-showcase', $headerWrap ),
			$headerContent  = $( '.header-showcase_content', $headerShowcase ),
			$headerImg      = $( '.header-showcase_img', $headerShowcase ),
			headerHeight,
			wrapHeight,
			contentHeight,
			imgHeight,
			position;

		function setShowcaseCSS() {

			headerHeight  = parseInt( $siteHeader.outerHeight() );

			if ( $headerContent.length ) {
				contentHeight = parseInt( $headerContent.outerHeight() );
			} else {
				contentHeight = 0;
			}

			imgHeight = parseInt( $headerImg.height() );
			if ( imgHeight < headerHeight + contentHeight ) {
				$headerImg.css({
					visibility: 'hidden',
					height: 0
				});
				$headerWrap.css( 'background-image', 'url(' + $headerImg.attr( 'src' ) + ')' );
				$headerWrap.addClass('mobile-static');
				//Set min height for showcase by header height
				$headerShowcase.css('min-height', contentHeight);
			} else {
				$headerImg.css({
					visibility: 'visible',
					height: 'auto'
				});
				$headerWrap.css( 'background-image', 'none' );
				$headerWrap.removeClass('mobile-static');
				$headerShowcase.css('min-height', headerHeight);
			}

			wrapHeight = parseInt( $headerShowcase.height() );
			position   = ( wrapHeight - headerHeight - contentHeight ) / 2;

			if ( position < 0 ) {
				position = 10;
			}

			if ( $headerContent.length ) {
				$headerContent.css( 'bottom', position );
			}
		}

		if ( $headerContent.length ) {
			$headerContent.addClass( 'show-in' );
		}
		setShowcaseCSS();

		$( window ).on( 'orientationchange debouncedresize', setShowcaseCSS );

	});

	$(function() {

		// Try to init post format gallery slider
		var $gallery = $('.entry-gallery'),
			_gall_args;

		if ( $gallery.length ) {

			_gall_args = $gallery.data( 'init' );
			$gallery.slick( _gall_args );

		}

		// Init single image popup
		$('.image-popup').each(function( index, el ) {
			$(this).magnificPopup({type:'image'});
		});

		// Init gallery images popup
		$('.popup-gallery').each(function(index, el) {

			var _this     = $(this),
				gall_init = _this.data( 'popup-init' );

			_this.magnificPopup( gall_init );

		});

		// to top button
		$('#back-top').on('click', 'a', function(event) {
			event.preventDefault();
			$('body,html').stop(false, false).animate({
				scrollTop: 0
			}, 800);
			return !1;
		});
	});

} )(jQuery);

/**
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function() {
	var container, button, menu, links, subMenus;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}
} )();
