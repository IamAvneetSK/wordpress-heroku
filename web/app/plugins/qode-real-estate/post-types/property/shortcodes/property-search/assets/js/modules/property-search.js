(function($) {
    'use strict';

    var propertySearch = {};
    qode.modules.propertySearch = propertySearch;

    propertySearch.initSearchParams = initSearchParams;
    propertySearch.qodefOnDocumentReady = qodefOnDocumentReady;
    propertySearch.qodefOnWindowLoad = qodefOnWindowLoad;
    propertySearch.qodefOnWindowResize = qodefOnWindowResize;
    propertySearch.qodefOnWindowScroll = qodefOnWindowScroll;

    $(document).ready(qodefOnDocumentReady);
    $(window).on('load', qodefOnWindowLoad);
    $(window).resize(qodefOnWindowResize);
    $(window).scroll(qodefOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        initSearchParams();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodefOnWindowLoad() {

    }

    /*
     All functions to be called on $(window).resize() should be in this function
     */
    function qodefOnWindowResize() {

    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function qodefOnWindowScroll() {

    }

    function initSearchParams() {
        var searchHolder = $('.qodef-property-search-holder');
        if(searchHolder.length) {
            searchHolder.each(function() {
               var thisSearch = $(this);

                //INIT STATUS FIELD
                var status = thisSearch.find('.qodef-search-status-section');
                if(status.length) {
                    status.each(function() {
                        var selectStatus = status.find('select');
                        if(selectStatus.length) {
                            selectStatus.select2({
                                minimumResultsForSearch: -1
                            }).on('select2:select', function (e) {

                            });
                        }
                    });
                }

                //INIT TYPE FIELD
                var type = thisSearch.find('.qodef-search-type-section');
                if(type.length) {
                    type.each(function() {
                        var thisTypeSection = $(this),
                            thisTypeInput = thisTypeSection.find('input[name=qodef-search-type]'),
                            typeItems = thisTypeSection.find('.qodef-ptl-item');
                        typeItems.on('click', function (e) {
                            e.preventDefault();
                            var selectedItem = $(this);
                            if(selectedItem.hasClass('active')) {
                                thisTypeInput.val('');
                                selectedItem.removeClass('active');
                            } else {
                                typeItems.removeClass('active');
                                selectedItem.addClass('active');
                                thisTypeInput.val(selectedItem.data('id'));
                            }
                        })
                    });
                }

                //INIT CITY FIELD
                var city = thisSearch.find('.qodef-search-city-section');
                if(city.length) {
                    city.each(function() {
                        var selectCity = city.find('select');
                        if (selectCity.length) {
                            selectCity.select2({
                                minimumResultsForSearch: -1
                            }).on('select2:select', function (e) {

                            });
                        }
                    });
                }
            });
        }
    }

})(jQuery);
