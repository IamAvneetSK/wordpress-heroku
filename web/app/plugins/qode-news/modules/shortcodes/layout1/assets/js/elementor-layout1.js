(function($) {
    'use strict';

    var elementorQodeNewsLayout1 = {};
    qode.modules.elementorQodeNewsLayout1 = elementorQodeNewsLayout1;

    elementorQodeNewsLayout1.qodeInitElementorQodeNewsLayout1 = qodeInitElementorQodeNewsLayout1;


    elementorQodeNewsLayout1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsLayout1();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsLayout1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_layout1.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);