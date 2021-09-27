(function($) {
    'use strict';

    var elementorQodeNewsLayout3 = {};
    qode.modules.elementorQodeNewsLayout3 = elementorQodeNewsLayout3;

    elementorQodeNewsLayout3.qodeInitElementorQodeNewsLayout3 = qodeInitElementorQodeNewsLayout3;


    elementorQodeNewsLayout3.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsLayout3();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsLayout3(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_layout3.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);