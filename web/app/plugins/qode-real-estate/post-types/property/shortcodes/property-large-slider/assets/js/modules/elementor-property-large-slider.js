(function($) {
	'use strict';

	var elementorPropertyLargeSlider = {};
	qode.modules.elementorPropertyLargeSlider = elementorPropertyLargeSlider;

	elementorPropertyLargeSlider.qodeInitElementorPropertyLargeSlider = qodeInitElementorPropertyLargeSlider;


	elementorPropertyLargeSlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertyLargeSlider();
	}

	function qodeInitElementorPropertyLargeSlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_large_slider.default', function() {
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);
