(function($) {
    'use strict';

    var elementorQodeNewsLayout2 = {};
    qode.modules.elementorQodeNewsLayout2 = elementorQodeNewsLayout2;

    elementorQodeNewsLayout2.qodeInitElementorQodeNewsLayout2 = qodeInitElementorQodeNewsLayout2;


    elementorQodeNewsLayout2.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsLayout2();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsLayout2(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_layout2.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);