( function( $ ) {

	'use strict';

	var KwsElementorKitEditor = {

		init: function() {
			elementor.channels.editor.on( 'section:activated', KwsElementorKitEditor.onAnimatedBoxSectionActivated );

			window.elementor.on( 'preview:loaded', function() {
				elementor.$preview[0].contentWindow.KwsElementorKitEditor = KwsElementorKitEditor;
				KwsElementorKitEditor.onPreviewLoaded();
			});
		},



		onPreviewLoaded: function() {
			var elementorFrontend = $('#elementor-preview-iframe')[0].contentWindow.elementorFrontend;

			elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
				$scope.find( '.kek-elementor-template-edit-link' ).on( 'click', function( event ) {
					window.open( $( this ).attr( 'href' ) );
				});
			});
		}
	};

	$( window ).on( 'elementor:init', KwsElementorKitEditor.init );

	window.KwsElementorKitEditor = KwsElementorKitEditor;

}( jQuery ) );
