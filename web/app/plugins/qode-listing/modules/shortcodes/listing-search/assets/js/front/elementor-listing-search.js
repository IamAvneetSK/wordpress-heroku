(function($) {
    'use strict';

    var elementorListingSearch = {};
    qode.modules.elementorListingSearch = elementorListingSearch;

    elementorListingSearch.qodeInitElementorListingSearch = qodeInitElementorListingSearch;


    elementorListingSearch.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).load(qodeOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorListingSearch();
    }

    function qodeInitElementorListingSearch(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_listing_search.default', function() {
                qode.modules.listingsSelect.qodeSelect2Fields();
                qode.modules.listings.qodeInitListingMainSearch();
            } );
        });
    }

})(jQuery);