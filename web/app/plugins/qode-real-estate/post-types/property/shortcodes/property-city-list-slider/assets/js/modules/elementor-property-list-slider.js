(function($) {
	'use strict';

	var elementorPropertyCityListSlider = {};
	qode.modules.elementorPropertyCityListSlider = elementorPropertyCityListSlider;

	elementorPropertyCityListSlider.qodeInitElementorPropertyCityListSlider = qodeInitElementorPropertyCityListSlider;


	elementorPropertyCityListSlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertyCityListSlider();
	}

	function qodeInitElementorPropertyCityListSlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_city_list_slider.default', function() {
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);
