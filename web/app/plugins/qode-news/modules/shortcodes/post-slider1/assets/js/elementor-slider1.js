(function($) {
    'use strict';

    var elementorQodeNewsSlider1 = {};
    qode.modules.elementorQodeNewsSlider1 = elementorQodeNewsSlider1;

    elementorQodeNewsSlider1.qodeInitElementorQodeNewsSlider1 = qodeInitElementorQodeNewsSlider1;


    elementorQodeNewsSlider1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsSlider1();
    }

    function qodeInitElementorQodeNewsSlider1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_post_slider1.default', function() {
                qode.modules.slider1.qodeInitslider1();
            } );
        });
    }

})(jQuery);