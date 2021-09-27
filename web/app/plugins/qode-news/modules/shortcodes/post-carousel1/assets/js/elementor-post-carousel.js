(function($) {
    'use strict';

    var elementorQodeNewsPostCarousel1 = {};
    qode.modules.elementorQodeNewsPostCarousel1 = elementorQodeNewsPostCarousel1;

    elementorQodeNewsPostCarousel1.qodeInitElementorQodeNewsPostCarousel1 = qodeInitElementorQodeNewsPostCarousel1;


    elementorQodeNewsPostCarousel1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsPostCarousel1();
    }

    function qodeInitElementorQodeNewsPostCarousel1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_post_carousel1.default', function() {
                qodeOwlSlider();
            } );
        });
    }

})(jQuery);