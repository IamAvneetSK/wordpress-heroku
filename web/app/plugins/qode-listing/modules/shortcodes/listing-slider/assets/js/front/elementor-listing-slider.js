(function($) {
    'use strict';

    var elementorListingSlider = {};
    qode.modules.elementorListingSlider = elementorListingSlider;

    elementorListingSlider.qodeInitelementorListingSlider = qodeInitelementorListingSlider;


    elementorListingSlider.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).load(qodeOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitelementorListingSlider();
    }

    function qodeInitelementorListingSlider(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_listing_slider.default', function() {
                qodeOwlSlider()
            } );
        });
    }

})(jQuery);