(function($) {
    'use strict';

    var propertyList = {};
    qode.modules.propertyList = propertyList;

    propertyList.qodefOnDocumentReady = qodefOnDocumentReady;
    propertyList.qodefOnWindowLoad = qodefOnWindowLoad;
    propertyList.qodefOnWindowResize = qodefOnWindowResize;
    propertyList.qodefOnWindowScroll = qodefOnWindowScroll;

    $(document).ready(qodefOnDocumentReady);
    $(window).on('load', qodefOnWindowLoad);
    $(window).resize(qodefOnWindowResize);
    $(window).scroll(qodefOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefInitRangeSlider();
        qodefInitQuantityButtons();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodefOnWindowLoad() {
        qodefInitPropertyListMasonry();
        qodefInitPropertyListFilter();
        qodefInitPropertyListPagination().init();
    }

    /*
     All functions to be called on $(window).resize() should be in this function
     */
    function qodefOnWindowResize() {
        qodefInitPropertyListMasonry();
    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function qodefOnWindowScroll() {
        qodefInitPropertyListPagination().scroll();
    }

    /**
     * Initializes property masonry list
     */
    function qodefInitPropertyListMasonry(){
        var propertyList = $('.qodef-property-list-holder.qodef-pl-masonry');
        if(propertyList.length){
            propertyList.each(function(){
                var thisPropertyList = $(this),
                    masonry = thisPropertyList.find('.qodef-pl-inner'),
                    size = thisPropertyList.find('.qodef-pl-grid-sizer').width();

                qodefResizePropertyItems(size, thisPropertyList);

                masonry.isotope({
                    layoutMode: 'packery',
                    itemSelector: 'article',
                    percentPosition: true,
                    packery: {
                        gutter: '.qodef-pl-grid-gutter',
                        columnWidth: '.qodef-pl-grid-sizer'
                    }
                });

                setTimeout(function () {
                    initParallax();
                }, 600);

                masonry.css('opacity', '1');
            });
        }
    }

    /**
     * Init Resize Property List Items
     */
    function qodefResizePropertyItems(size,container){
        if(container.hasClass('qodef-pl-images-fixed')) {
            var padding = parseInt(container.find('article').css('padding-left')),
                defaultMasonryItem = container.find('.qodef-pl-masonry-default'),
                largeWidthMasonryItem = container.find('.qodef-pl-masonry-large-width'),
                largeHeightMasonryItem = container.find('.qodef-pl-masonry-large-height'),
                largeWidthHeightMasonryItem = container.find('.qodef-pl-masonry-large-width-height');

            if (qodef.windowWidth > 680) {
                defaultMasonryItem.css('height', size - 2 * padding);
                largeHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthHeightMasonryItem.css('height', Math.round(2 * size) - 2 * padding);
                largeWidthMasonryItem.css('height', size - 2 * padding);
            } else {
                defaultMasonryItem.css('height', size);
                largeHeightMasonryItem.css('height', size);
                largeWidthHeightMasonryItem.css('height', size);
                largeWidthMasonryItem.css('height', Math.round(size / 2));
            }
        }
    }

    function qodefInitRangeSlider(){

        var selectorHolder =  $('.qodef-property-list-filter-part .qodef-filter-price-holder');
        var slider = selectorHolder.find('.qodef-range-slider');
        var outputMin = selectorHolder.find('#qodef-min-price-value');
        var valueMin = outputMin.data('min-price');
        var outputMax = selectorHolder.find('#qodef-max-price-value');
        var valueMax = outputMax.data('max-price');

        var priceLabelSetting = selectorHolder.data('price-label-setting');
        var maxPriceSetting = selectorHolder.data('max-price-setting');
        // Basic rangeslider initialization
        slider.slider({
            range: true,
            animate: true,
            min: 0,
            max: maxPriceSetting,
            step: 25,
            values: [ valueMin, valueMax],
            create: function() {

            },
            slide: function( event, ui ) {
                outputMin.html(priceLabelSetting + ui.values[0] );
                outputMax.html(priceLabelSetting + ui.values[1] );
            },
            change: function( event, ui ) {
                outputMin.data('min-price', ui.values[0] );
                outputMax.data('max-price', ui.values[1] );
            }
        });

        $(document).on('property_list_filter_reset', slider, function (e) {
            slider.slider("values", 0, 0);
            slider.slider("values", 1, maxPriceSetting);
            outputMin.html(priceLabelSetting + 0 );
            outputMax.html(priceLabelSetting + maxPriceSetting );
            outputMin.data('min-price', 0 );
            outputMax.data('max-price', maxPriceSetting );
        });
    }

    /*
     ** Init quantity buttons to increase/decrease specification values
     */
    function qodefInitQuantityButtons() {
        $(document).on('click', '.qodef-spec-quantity-minus, .qodef-spec-quantity-plus', function (e) {
            e.stopPropagation();

            var button = $(this),
                inputField = button.siblings('.qodef-spec-quantity-input'),
                step = parseFloat(inputField.data('step')),
                max = parseFloat(inputField.data('max')),
                minus = false,
                inputValue = parseFloat(inputField.val()),
                newInputValue;

            if (button.hasClass('qodef-spec-quantity-minus')) {
                minus = true;
            }

            if (minus) {
                newInputValue = inputValue - step;
                if (newInputValue >= 1) {
                    inputField.val(newInputValue);
                } else {
                    inputField.val(0);
                }
            } else {
                newInputValue = inputValue + step;
                if (max === undefined) {
                    inputField.val(newInputValue);
                } else {
                    if (newInputValue >= max) {
                        inputField.val(max);
                    } else {
                        inputField.val(newInputValue);
                    }
                }
            }
        });
    }

    /**
     * Initializes property list pagination functions
     */
    function qodefInitPropertyListPagination(){
        var propertyList = $('.qodef-property-list-holder');

        var initStandardPagination = function(thisPropertyList) {
            var standardLink = thisPropertyList.find('.qodef-pl-standard-pagination li');

            if(standardLink.length) {
                standardLink.each(function(){
                    var thisLink = $(this).children('a'),
                        pagedLink = 1;

                    thisLink.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (typeof thisLink.data('paged') !== 'undefined' && thisLink.data('paged') !== false) {
                            pagedLink = thisLink.data('paged');
                        }

                        initMainPagFunctionality(thisPropertyList, pagedLink);
                    });
                });
            }
        };

        var initLoadMorePagination = function(thisPropertyList) {
            var loadMoreButton = thisPropertyList.find('.qodef-pl-load-more a');

            loadMoreButton.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                initMainPagFunctionality(thisPropertyList);
            });
        };

        var initInifiteScrollPagination = function(thisPropertyList) {
            var propertyListHeight = thisPropertyList.outerHeight(),
                propertytListTopOffest = thisPropertyList.offset().top,
                propertyListPosition = propertyListHeight + propertytListTopOffest - qodefGlobalVars.vars.qodefAddForAdminBar;

            if(!thisPropertyList.hasClass('qodef-pl-infinite-scroll-started') && qodef.scroll + qodef.windowHeight > propertyListPosition) {
                initMainPagFunctionality(thisPropertyList);
            }
        };

        var initMainPagFunctionality = function(thisPropertyList, pagedLink) {
            var thisPropertyListInner = thisPropertyList.find('.qodef-pl-inner'),
                nextPage,
                maxNumPages;
            if (typeof thisPropertyList.data('max-num-pages') !== 'undefined' && thisPropertyList.data('max-num-pages') !== false) {
                maxNumPages = thisPropertyList.data('max-num-pages');
            }

            if(thisPropertyList.hasClass('qodef-pl-pag-standard')) {
                thisPropertyList.data('next-page', pagedLink);
            }

            if(thisPropertyList.hasClass('qodef-pl-pag-infinite-scroll')) {
                thisPropertyList.addClass('qodef-pl-infinite-scroll-started');
            }

            if(pagedLink == 1) {
                thisPropertyList.data('next-page', pagedLink);
            }

            var loadMoreData = qode.modules.common.getLoadMoreData(thisPropertyList),
                loadingItem = thisPropertyList.find('.qodef-pl-loading'),
                filterLoadingItem = thisPropertyList.find('.qodef-pl-filter-loading');

            nextPage = loadMoreData.nextPage;
            if(nextPage <= maxNumPages || maxNumPages == 0){
                if(nextPage == 1) {
                    filterLoadingItem.addClass('qodef-showing');
                } else {
                    if (thisPropertyList.hasClass('qodef-pl-pag-standard')) {
                        loadingItem.addClass('qodef-showing qodef-standard-pag-trigger');
                        thisPropertyList.addClass('qodef-pl-pag-standard-animate');
                    } else {
                        loadingItem.addClass('qodef-showing');
                    }
                }

                var ajaxData = qode.modules.common.setLoadMoreAjaxData(loadMoreData, 'qodef_re_property_ajax_load_more');

                $.ajax({
                    type: 'POST',
                    data: ajaxData,
                    url: QodeAdminAjax.ajaxurl,
                    success: function (data) {
                        if(!thisPropertyList.hasClass('qodef-pl-pag-standard')) {
                            nextPage++;
                        }

                        thisPropertyList.data('next-page', nextPage);

                        var response = $.parseJSON(data),
                            responseHtml =  response.html;

                        //get map items
                        var mapObjs = response.mapAddresses;
                        var mapAddresses = '';
                        if(mapObjs !== null && mapObjs["addresses"] != undefined){
                            mapAddresses = mapObjs['addresses'];
                        }

                        if(thisPropertyList.hasClass('qodef-pl-pag-standard')  || pagedLink == 1) {
                            qodefInitStandardPaginationLinkChanges(thisPropertyList, maxNumPages, nextPage);

                            thisPropertyList.waitForImages(function(){
                                if(thisPropertyList.hasClass('qodef-pl-masonry')){
                                    qodefInitHtmlIsotopeNewContent(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses);
                                } else if (thisPropertyList.hasClass('qodef-pl-gallery') && thisPropertyList.hasClass('qodef-pl-has-filter')) {
                                    qodefInitHtmlIsotopeNewContent(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses);
                                } else {
                                    qodefInitHtmlGalleryNewContent(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses);
                                }
                            });
                        } else {
                            thisPropertyList.waitForImages(function(){
                                if(thisPropertyList.hasClass('qodef-pl-masonry')){
                                    if(pagedLink == 1) {
                                        qodefInitHtmlIsotopeNewContent(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses);
                                    } else {
                                        qodefInitAppendIsotopeNewContent(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses);
                                    }
                                } else if (thisPropertyList.hasClass('qodef-pl-gallery') && thisPropertyList.hasClass('qodef-pl-has-filter') && pagedLink != 1) {
                                    qodefInitAppendIsotopeNewContent(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses);
                                } else {
                                    qodefInitAppendGalleryNewContent(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses);
                                }
                            });
                        }

                        if(thisPropertyList.hasClass('qodef-pl-infinite-scroll-started')) {
                            thisPropertyList.removeClass('qodef-pl-infinite-scroll-started');
                        }
                    }
                });
            }

            if(pagedLink == 1) {
                thisPropertyList.find('.qodef-pl-load-more-holder').show();
            }

            if(nextPage === maxNumPages){
                thisPropertyList.find('.qodef-pl-load-more-holder').hide();
            }
        };

        var qodefInitStandardPaginationLinkChanges = function(thisPropertyList, maxNumPages, nextPage) {
            var standardPagHolder = thisPropertyList.find('.qodef-pl-standard-pagination'),
                standardPagNumericItem = standardPagHolder.find('li.qodef-pl-pag-number'),
                standardPagPrevItem = standardPagHolder.find('li.qodef-pl-pag-prev a'),
                standardPagNextItem = standardPagHolder.find('li.qodef-pl-pag-next a');

            standardPagNumericItem.removeClass('qodef-pl-pag-active');
            standardPagNumericItem.eq(nextPage-1).addClass('qodef-pl-pag-active');

            standardPagPrevItem.data('paged', nextPage-1);
            standardPagNextItem.data('paged', nextPage+1);

            if(nextPage > 1) {
                standardPagPrevItem.css({'opacity': '1'});
            } else {
                standardPagPrevItem.css({'opacity': '0'});
            }

            if(nextPage === maxNumPages) {
                standardPagNextItem.css({'opacity': '0'});
            } else {
                standardPagNextItem.css({'opacity': '1'});
            }
        };

        var qodefInitHtmlIsotopeNewContent = function(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses) {
            thisPropertyListInner.find('article').remove();
            thisPropertyListInner.append(responseHtml);
            if(thisPropertyList.hasClass('qodef-pl-with-map')) {
                if(mapAddresses !== ''){
                    qode.modules.realEstateMaps.qodefReinitMultipleGoogleMaps(mapAddresses, 'append');
                    qode.modules.compareProperties.qodefHandleAddToCompare();
                }
            }
            qodefResizePropertyItems(thisPropertyListInner.find('.qodef-pl-grid-sizer').width(), thisPropertyList);
            thisPropertyListInner.isotope('reloadItems').isotope({sortBy: 'original-order'});
            loadingItem.removeClass('qodef-showing qodef-standard-pag-trigger');
            filterLoadingItem.removeClass('qodef-showing');
            thisPropertyList.removeClass('qodef-pl-pag-standard-animate');

            setTimeout(function() {
                thisPropertyListInner.isotope('layout');
                //qodefInitPropertyListAnimation();
                initParallax();
            }, 600);
        };

        var qodefInitHtmlGalleryNewContent = function(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses) {
            loadingItem.removeClass('qodef-showing qodef-standard-pag-trigger');
            filterLoadingItem.removeClass('qodef-showing');
            thisPropertyList.removeClass('qodef-pl-pag-standard-animate');
            thisPropertyListInner.html(responseHtml);
            if(thisPropertyList.hasClass('qodef-pl-with-map')) {
                if(mapAddresses !== ''){
                    qode.modules.realEstateMaps.qodefReinitMultipleGoogleMaps(mapAddresses, 'replace');
                    qode.modules.compareProperties.qodefHandleAddToCompare();
                }
            }
            //qodefInitPropertyListAnimation();
            initParallax();
        };

        var qodefInitAppendIsotopeNewContent = function(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses) {
            thisPropertyListInner.append(responseHtml);
            qodefResizePropertyItems(thisPropertyListInner.find('.qodef-pl-grid-sizer').width(), thisPropertyList);
            thisPropertyListInner.isotope('reloadItems').isotope({sortBy: 'original-order'});
            if(thisPropertyList.hasClass('qodef-pl-with-map')) {
                if(mapAddresses !== ''){
                    qode.modules.realEstateMaps.qodefReinitMultipleGoogleMaps(mapAddresses, 'append');
                    qode.modules.compareProperties.qodefHandleAddToCompare();
                }
            }
            loadingItem.removeClass('qodef-showing');
            filterLoadingItem.removeClass('qodef-showing');

            setTimeout(function() {
                thisPropertyListInner.isotope('layout');
                //qodefInitPropertyListAnimation();
                initParallax();
            }, 600);
        };

        var qodefInitAppendGalleryNewContent = function(thisPropertyList, thisPropertyListInner, loadingItem, filterLoadingItem, responseHtml, mapAddresses) {
            loadingItem.removeClass('qodef-showing');
            filterLoadingItem.removeClass('qodef-showing');
            thisPropertyListInner.append(responseHtml);
            if(thisPropertyList.hasClass('qodef-pl-with-map')) {
                if(mapAddresses !== ''){
                    qode.modules.realEstateMaps.qodefReinitMultipleGoogleMaps(mapAddresses, 'append');
                    qode.modules.compareProperties.qodefHandleAddToCompare();
                }
            }
            //qodefInitPropertyListAnimation();
            initParallax();
        };

        return {
            init: function() {
                if(propertyList.length) {
                    propertyList.each(function() {
                        var thisPortList = $(this);

                        if(thisPortList.hasClass('qodef-pl-pag-standard')) {
                            initStandardPagination(thisPortList);
                        }

                        if(thisPortList.hasClass('qodef-pl-pag-load-more')) {
                            initLoadMorePagination(thisPortList);
                        }

                        if(thisPortList.hasClass('qodef-pl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisPortList);
                        }
                    });
                }
            },
            scroll: function() {
                if(propertyList.length) {
                    propertyList.each(function() {
                        var thisPropertyList = $(this);

                        if(thisPropertyList.hasClass('qodef-pl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisPropertyList);
                        }
                    });
                }
            },
            getMainPagFunction: function(thisPropertyList, paged) {
                initMainPagFunctionality(thisPropertyList, paged);
            }
        };
    }

    function qodefInitPropertyListFilter() {
        var filters = $('.qodef-property-list-filter-part');
        if(filters.length) {
            filters.each(function() {
                var thisFilter = $(this),
                    thisPropertyList    = thisFilter.parents('.qodef-property-list-holder'),
                    button              = thisFilter.find('.qodef-property-filter-button'),
                    status              = thisFilter.find('.qodef-filter-status-holder'),
                    type                = thisFilter.find('.qodef-filter-type-holder'),
                    city                = thisFilter.find('.qodef-filter-city-holder'),
                    minPrice            = thisFilter.find('#qodef-min-price-value'),
                    maxPrice            = thisFilter.find('#qodef-max-price-value'),
                    minSize             = thisFilter.find('.qodef-min-size'),
                    maxSize             = thisFilter.find('.qodef-max-size'),
                    bedrooms            = thisFilter.find('#qodef-specification-bedrooms'),
                    bathrooms           = thisFilter.find('#qodef-specification-bathrooms');


                //INIT STATUS FIELD
                if(status.length > 0) {
                    initSelect2Field(status, 'status');
                }
                if(city.length > 0) {
                    initSelect2Field(city, 'city');
                }

                if(type.length > 0) {
                    initTypesField(type, 'type');
                }

                button.on('click', function () {
                   var statusValue      = status.data('status'),
                       typeValue        = type.data('type'),
                       cityValue        = city.data('city'),
                       minPriceValue    = minPrice.data('min-price'),
                       maxPriceValue    = maxPrice.data('max-price'),
                       minSizeValue     = minSize.val(),
                       maxSizeValue     = maxSize.val(),
                       bedroomsValue    = bedrooms.val(),
                       bathroomsValue   = bathrooms.val();
                    var features = [];
                    $("input[name='qodef-features[]']:checked").each(function (){
                        features.push(parseInt($(this).data('id')));
                    });
                    features = features.join(',');

                    thisPropertyList.data('property-status', statusValue);
                    thisPropertyList.data('property-type', typeValue);
                    thisPropertyList.data('property-city', cityValue);
                    thisPropertyList.data('property-min-price', minPriceValue);
                    thisPropertyList.data('property-max-price', maxPriceValue);
                    thisPropertyList.data('property-min-size', minSizeValue);
                    thisPropertyList.data('property-max-size', maxSizeValue);
                    thisPropertyList.data('property-bedrooms', bedroomsValue);
                    thisPropertyList.data('property-bathrooms', bathroomsValue);
                    thisPropertyList.data('property-features', features);

                    qodefInitPropertyListPagination().getMainPagFunction(thisPropertyList, 1);
                });

                //INIT SAVE QUERY
                var queryHolder = thisPropertyList.find('.qodef-property-query-section');
                if(queryHolder.length) {
                    var saveQueryButton = queryHolder.find('.qodef-property-save-search-button');
                    var resultHolder = queryHolder.find('.qodef-query-result');

                    saveQueryButton.on('click', function () {
                        if(qodef.body.hasClass('logged-in')) {
                            resultHolder.html('<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>');

                            var statusValue = status.data('status'),
                                typeValue = type.data('type'),
                                cityValue = city.data('city'),
                                minPriceValue = minPrice.data('min-price'),
                                maxPriceValue = maxPrice.data('max-price'),
                                minSizeValue = minSize.val(),
                                maxSizeValue = maxSize.val(),
                                bedroomsValue = bedrooms.val(),
                                bathroomsValue = bathrooms.val();
                            var features = [];
                            $("input[name='qodef-features[]']:checked").each(function () {
                                features.push(parseInt($(this).data('id')));
                            });
                            features = features.join(',');

                            var ajaxData = {
                                action: 'qodef_re_property_ajax_save_query',
                                status: statusValue,
                                type: typeValue,
                                city: cityValue,
                                minPrice: minPriceValue,
                                maxPrice: maxPriceValue,
                                minSize: minSizeValue,
                                maxSize: maxSizeValue,
                                bedrooms: bedroomsValue,
                                bathrooms: bathroomsValue,
                                features: features
                            };

                            $.ajax({
                                type: 'POST',
                                data: ajaxData,
                                url: QodeAdminAjax.ajaxurl,
                                success: function (data) {
                                    var response;
                                    response = JSON.parse(data);
                                    resultHolder.html('<span class="qodef-result-message">' + response.message + '</span>');
                                    resultHolder.append(response.data);
                                    qodefInitUndoQueryButton(queryHolder);
                                }
                            });
                        } else {
                            // Trigger event.
                            $( document.body ).trigger( 'open_user_login_trigger' );
                        }
                    });
                }

                //INIT RESET FILTER
                var resetButton = thisPropertyList.find('.qodef-property-filter-reset-button');
                if (resetButton.length) {
                    resetButton.on('click', function (e) {
                        e.preventDefault();
                        var featuresList = thisPropertyList.find('.qodef-feature-cb');
                        $( document.body ).trigger( 'property_list_filter_reset' );
                        minSize.val('');
                        maxSize.val('');
                        bedrooms.val(0);
                        bathrooms.val(0);
                        featuresList.each(function() {
                            $(this).prop('checked', false);
                        });
                        resetSelect2Field(status, 'status', status.data('default-status'));
                        resetSelect2Field(city, 'city', city.data('default-city'));
                        setTypesValue(type, 'type', type.data('default-type'));
                        button.trigger('click');
                    });
                }
            })
        }

        function initSelect2Field(selectElement, paramName) {
            var select2Field = selectElement.find('select');
            if(select2Field.length) {
                select2Field.select2({
                    minimumResultsForSearch: -1
                }).on('select2:select', function (e) {
                    var selectedElement = $(e.currentTarget);
                    var selectVal = selectedElement.val();
                    selectElement.data(paramName, selectVal);
                });
            }
        }

        function resetSelect2Field(selectElement, selectParam, selectValue) {
            var select2Field = selectElement.find('select');
            select2Field.val(selectValue).trigger('change');
            selectElement.data(selectParam, selectValue);
        }

        function initTypesField(typeElement, paramName) {
            var typeItems = typeElement.find('.qodef-ptl-item');
            typeItems.on('click', function (e) {
                e.preventDefault();
                var selectedItem = $(this);
                setTypesValue(typeElement, paramName, selectedItem.data('id'));
            })
        }

        function setTypesValue(typeElement, typeParam, typeValue) {
            var typeItems = typeElement.find('.qodef-ptl-item');
            if(typeValue == '') {
                typeItems.removeClass('active');
                typeElement.data(typeParam, '');
            }
            else {
                var item = typeElement.find('.qodef-ptl-item[data-id=' + typeValue +']');
                if(item.hasClass('active')) {
                    item.removeClass('active');
                    typeElement.data(typeParam, '');
                } else {
                    typeItems.removeClass('active');
                    item.addClass('active');
                    typeElement.data(typeParam, typeValue);
                }
            }
        }
    }

    function qodefInitUndoQueryButton(queryHolder) {
        var undoQueryButton = queryHolder.find('.qodef-undo-query-save');
        var resultHolder = queryHolder.find('.qodef-query-result');
        undoQueryButton.on('click', function () {
            resultHolder.html('<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>');

            var ajaxData = {
                action: 'qodef_re_property_ajax_remove_query',
                query_id: undoQueryButton.data('query-id')
            };

            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var response;
                    response = JSON.parse(data);
                    resultHolder.html('<span class="qodef-result-message">' + response.message + '</span>');
                    resultHolder.append(response.data);
                }
            });
        });
    }

})(jQuery);