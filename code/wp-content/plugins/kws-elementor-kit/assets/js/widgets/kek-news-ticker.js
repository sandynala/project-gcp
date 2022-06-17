/**
 * Start news ticker widget script
 */

( function( $, elementor ) {

	'use strict';

	var widgetNewsTicker = function( $scope, $ ) {

		var $newsTicker = $scope.find('.kek-news-ticker'),
            $settings = $newsTicker.data('settings');

        if ( ! $newsTicker.length ) {
            return;
        }

        $($newsTicker).kekNewsTicker($settings);

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/kek-news-ticker.default', widgetNewsTicker );
	});

}( jQuery, window.elementorFrontend ) );

/**
 * End news ticker widget script
 */

