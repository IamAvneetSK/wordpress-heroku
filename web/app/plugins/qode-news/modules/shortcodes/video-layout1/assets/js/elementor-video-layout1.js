(function($) {
    'use strict';

    var elementorQodeNewsVideoLayout1 = {};
    qode.modules.elementorQodeNewsVideoLayout1 = elementorQodeNewsVideoLayout1;

    elementorQodeNewsVideoLayout1.qodeInitElementorQodeNewsVideoLayout1 = qodeInitElementorQodeNewsVideoLayout1;


    elementorQodeNewsVideoLayout1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsVideoLayout1();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsVideoLayout1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_video_layout1.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);