(function($) {
	'use strict';

	var elementorPropertyTypeSlider = {};
	qode.modules.elementorPropertyTypeSlider = elementorPropertyTypeSlider;

	elementorPropertyTypeSlider.qodeInitElementorPropertyTypeSlider = qodeInitElementorPropertyTypeSlider;


	elementorPropertyTypeSlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertyTypeSlider();
	}

	function qodeInitElementorPropertyTypeSlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_type_slider.default', function() {
				console.log('slider');
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);
