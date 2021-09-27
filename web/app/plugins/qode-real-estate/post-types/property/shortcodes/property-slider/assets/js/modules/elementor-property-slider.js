(function($) {
	'use strict';

	var elementorPropertySlider = {};
	qode.modules.elementorPropertySlider = elementorPropertySlider;

	elementorPropertySlider.qodeInitElementorPropertySlider = qodeInitElementorPropertySlider;


	elementorPropertySlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertySlider();
	}

	function qodeInitElementorPropertySlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_slider.default', function() {
				console.log('krga');
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);
