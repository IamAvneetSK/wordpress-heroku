(function($) {
    'use strict';

    var ihomeFinder = {};
    qode.modules.ihomeFinder = ihomeFinder;

    ihomeFinder.qodefOnWindowLoad = qodefOnWindowLoad;

    $(window).on('load', qodefOnWindowLoad);

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodefOnWindowLoad() {
        qodefInitIHomeFinderSelect2();
    }

    /*
     ** Init select2 script for select html dropdowns
     */
    function qodefInitIHomeFinderSelect2() {
        var iHomeFinderSelect = $('#ihf-main-container select');
        if (iHomeFinderSelect.length) {
            iHomeFinderSelect.each(function() {
                var thisSelect = $(this);

                thisSelect.select2({
                    minimumResultsForSearch: Infinity
                });
            });
        }
    }

})(jQuery);