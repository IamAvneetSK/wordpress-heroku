(function($) {
    'use strict';

    var instructor = {};
    qode.modules.instructor = instructor;

    instructor.qodeOnDocumentReady = qodeOnDocumentReady;
    instructor.qodeOnWindowLoad = qodeOnWindowLoad;
    instructor.qodeOnWindowResize = qodeOnWindowResize;
    instructor.qodeOnWindowScroll = qodeOnWindowScroll;

    $(document).ready(qodeOnDocumentReady);
    $(window).on('load', qodeOnWindowLoad);
    $(window).resize(qodeOnWindowResize);
    $(window).scroll(qodeOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodeOnDocumentReady() {

    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorInstructorSlider();
    }

    /*
     All functions to be called on $(window).resize() should be in this function
     */
    function qodeOnWindowResize() {

    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function qodeOnWindowScroll() {

    }

    //Elementor reinitialization
    function qodeInitElementorInstructorSlider(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_instructor_slider.default', function() {
                qodeOwlSlider();
            } );
        });
    }

})(jQuery);