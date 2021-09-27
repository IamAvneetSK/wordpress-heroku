(function($) {
    'use strict';

    var elementorListingSimpleSearch = {};
    qode.modules.elementorListingSimpleSearch = elementorListingSimpleSearch;

    elementorListingSimpleSearch.qodeInitelementorListingSimpleSearch = qodeInitelementorListingSimpleSearch;


    elementorListingSimpleSearch.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).load(qodeOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitelementorListingSimpleSearch();
    }

    function qodeInitelementorListingSimpleSearch(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_listing_simple_search.default', function() {
                qode.modules.listings.qodeInitListingSimpleSearch();
            } );
        });
    }

})(jQuery);