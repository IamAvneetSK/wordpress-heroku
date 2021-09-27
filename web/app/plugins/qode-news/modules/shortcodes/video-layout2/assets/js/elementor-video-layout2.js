(function($) {
    'use strict';

    var elementorQodeNewsVideoLayout2 = {};
    qode.modules.elementorQodeNewsVideoLayout2 = elementorQodeNewsVideoLayout2;

    elementorQodeNewsVideoLayout2.qodeInitElementorQodeNewsVideoLayout2 = qodeInitElementorQodeNewsVideoLayout2;


    elementorQodeNewsVideoLayout2.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsVideoLayout2();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsVideoLayout2(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_video_layout2.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
                prettyPhoto();
            } );
        });
    }

})(jQuery);