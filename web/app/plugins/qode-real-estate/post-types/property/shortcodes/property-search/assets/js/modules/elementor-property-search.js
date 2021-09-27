(function($) {
	'use strict';

	var elementorPropertySearch = {};
	qode.modules.elementorPropertySearch = elementorPropertySearch;

	elementorPropertySearch.qodeInitElementorPropertySearch = qodeInitElementorPropertySearch;


	elementorPropertySearch.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertySearch();
	}

	function qodeInitElementorPropertySearch(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_search.default', function() {
				qode.modules.propertySearch.initSearchParams();
			} );
		});
	}

})(jQuery);
