(function($) {
    'use strict';

    var property = {};
    qode.modules.property = property;

    property.qodefShowHideEnquiryForm = qodefShowHideEnquiryForm;
    property.qodefSubmitEnquiryForm = qodefSubmitEnquiryForm;
    property.qodefMortgageCalculator = qodefMortgageCalculator;

    property.qodefOnDocumentReady = qodefOnDocumentReady;
    property.qodefOnWindowLoad = qodefOnWindowLoad;
    property.qodefOnWindowResize = qodefOnWindowResize;
    property.qodefOnWindowScroll = qodefOnWindowScroll;

    $(document).ready(qodefOnDocumentReady);
    $(window).on('load', qodefOnWindowLoad);
    $(window).resize(qodefOnWindowResize);
    $(window).scroll(qodefOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefShowHideEnquiryForm();
        qodefSubmitEnquiryForm();
        qodefMortgageCalculator();
        qodefDeleteProperty();
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

    function qodefShowHideEnquiryForm(){

        var single = $('.qodef-property-single-holder'),
            enquiryHolder = $('.qodef-property-enquiry-holder'),
            button = single.find('.qodef-property-single-action'),
            buttonClose = $('.qodef-property-enquiry-close');

        button.on('click', function(e) {
            e.preventDefault();
            enquiryHolder.fadeIn(300);
            enquiryHolder.addClass('opened');
        });

        enquiryHolder.add(buttonClose).on('click', function() {
            if(enquiryHolder.hasClass('opened')){
                enquiryHolder.fadeOut(300);
                enquiryHolder.removeClass('opened');
            }
        });

        $(".qodef-property-enquiry-inner").on('click', function (e) {
            e.stopPropagation();
        });
        // on esc too
        $(window).on('keyup', function(e){
            if ( enquiryHolder.hasClass( 'opened' ) && e.keyCode == 27 ) {
                enquiryHolder.fadeOut(300);
                enquiryHolder.removeClass('opened');
            }
        });

    }

    function qodefSubmitEnquiryForm(){
        var enquiryHolder = $('.qodef-property-enquiry-holder'),
            enquiryMessageHolder = $('.qodef-property-enquiry-response'),
            enquiryForm = enquiryHolder.find('.qodef-property-enquiry-form');


        enquiryForm.on('submit', function(e){
            e.preventDefault();
            enquiryMessageHolder.empty();
            var enquiryData = {
                name: enquiryForm.find('#enquiry-name').val(),
                email: enquiryForm.find('#enquiry-email').val(),
                message: enquiryForm.find('#enquiry-message').val(),
                itemId: enquiryForm.find('#enquiry-item-id').val(),
                nonce: enquiryForm.find('#qodef_re_nonce_property_item_enquiry').val()
            };

            var requestData = {
                action: 'qodef_re_send_property_enquiry',
                data: enquiryData
            };

            $.ajax({
                type: "POST",
                url: QodeAdminAjax.ajaxurl,
                data: requestData,
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 'error'){
                        enquiryMessageHolder.html(response.message);
                        //error handler
                    }else{
                        enquiryMessageHolder.html(response.message);
                        enquiryForm.fadeOut(300);
                        setTimeout(function(){
                            enquiryHolder.remove();
                        }, 2000);
                    }
                }
            });
        });

    }

    function qodefMortgageCalculator(){
        var calculator = $('.qodef-mortgage-calculator-holder');
        if(calculator.length) {
            calculator.each(function() {
               var thisCalc = $(this);
               var calcForm = thisCalc.find('form');
                var resultHolder = thisCalc.find('.qodef-mc-result-holder');
                calcForm.on('submit', function(e) {
                    e.preventDefault();
                    var price = calcForm.find('#price').val().replace(/,/g, ''),
                        interestRate = parseFloat(calcForm.find('#interest-rate').val()),
                        termYears = parseInt(calcForm.find('#term-years').val(), 10),
                        downPayment = calcForm.find('#down-payment').val().replace(/,/g, '');

                    var amountFinanced = price - downPayment;
                    var term = termYears * 12; //12 is number of months in year
                    var monthInterest = interestRate / (12 * 100);
                    var interval = Math.pow( 1 + monthInterest, -term );
                    var mortgagePay = amountFinanced * (monthInterest / (1 - interval));
                    var annualCost = mortgagePay * 12;

                    resultHolder.find('.qodef-mc-payment-value').html((Math.round(mortgagePay * 100)) / 100 + '$');
                    resultHolder.find('.qodef-mc-amount-financed-value').html((Math.round(amountFinanced * 100)) / 100 + '$');
                    resultHolder.find('.qodef-mc-mortgage-payments-value').html((Math.round(mortgagePay * 100)) / 100 + '$');
                    resultHolder.find('.qodef-mc-annual-costs-value').html((Math.round(annualCost * 100)) / 100 + '$');

                    resultHolder.slideDown();
                });
            });
        }
    }

    function qodefDeleteProperty(){
    	var deleteButtons = $('.qodef-property-item-delete');

    	if (deleteButtons.length){
    		deleteButtons.each(function(){
    			var thisDeleteButton = $(this),
    				propertyId = thisDeleteButton.data('property-id'),
    				confirmText = thisDeleteButton.data('confirm-text'),
    				property = thisDeleteButton.parents('.qodef-re-profile-property-item');

    			thisDeleteButton.on('click', function(e){
    				e.preventDefault();

    				var confirmDelete = confirm(confirmText);

    				if (confirmDelete) {

	    				var dataForm = {
	    					'action' : 'qodef_re_delete_property',
	    					'property_id' : propertyId
	    				}

	    				$.ajax({
		                    type: 'POST',
		                    data: dataForm,
		                    url: QodeAdminAjax.ajaxurl,
		                    success: function (data) {
		                        var response;
		                        response = JSON.parse(data);

		                        if (response.status == 'success') {
		                            property.fadeOut( function(){
				                        property.remove();
				                    });	                            
		                        }
		                    }
	    				});
	    			}
    			});
    		});
    	}
    }

})(jQuery);
(function($) {
    "use strict";

    var compareProperties = {};
    qode.modules.compareProperties = compareProperties;
    compareProperties.qodefHandleAddToCompare = qodefHandleAddToCompare;

    compareProperties.qodefOnDocumentReady = qodefOnDocumentReady;

    $(document).ready(qodefOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefCompareHolder();
        qodefCompareHolderScroll();
        qodefHandleAddToCompare();
    }

    /**
     * Show/hide side area
     */
    function qodefCompareHolder() {
        var compareHolder = $('.qodef-re-compare-holder');

        if(compareHolder.length) {
            var wrapper                 = $('.qodef-wrapper'),
                compareHolderButtonOpen = $('a.qodef-re-compare-holder-opener'),
                closePopupButton        = $('.qodef-re-compare-popup-close'),
                doCompareButton         = $('.qodef-re-compare-do-compare'),
                doResetButton           = $('.qodef-re-compare-do-reset'),
                cssClass                = 'qodef-re-ch-opened';

            var cover = $('.qodef-cover');
            if (!cover.length) {
                wrapper.prepend('<div class="qodef-cover"/>');
            }

            compareHolderButtonOpen.on('click', function (e) {
                e.preventDefault();

                if (!compareHolderButtonOpen.hasClass('opened')) {
                    compareHolderButtonOpen.addClass('opened');
                    qodef.body.addClass(cssClass);

                    $('.qodef-wrapper .qodef-cover').on('click', function () {
                        qodef.body.removeClass(cssClass);
                        compareHolderButtonOpen.removeClass('opened');
                    });
                } else {
                    compareHolderButtonOpen.removeClass('opened');
                    qodef.body.removeClass(cssClass);
                }
            });

            doCompareButton.on('click', function (e) {
                e.preventDefault();
                qodefInitItemsComparingPopup();
                compareHolderButtonOpen.trigger("click");
            });

            closePopupButton.on('click', function (e) {
                e.preventDefault();
                qodefInitComparePopupClose();
            });

            doResetButton.on('click', function (e) {
                e.preventDefault();
                qodefInitItemsReset();
                closePopupButton.trigger("click");
            });
        }
    }

    /*
     **  Smooth scroll functionality for Compare Holder area
     */
    function qodefCompareHolderScroll(){
        var compareHolderScroll = $('.qodef-re-compare-holder .qodef-re-compare-holder-scroll');
        if(compareHolderScroll.length){
            var itemsHolder = compareHolderScroll.find('.qodef-re-compare-items-holder');
            var actionsHolder = compareHolderScroll.find('.qodef-re-compare-actions');
            var completeHeight = itemsHolder.outerHeight() + actionsHolder.outerHeight();
            compareHolderScroll.height(completeHeight + 30);
            compareHolderScroll.perfectScrollbar({
                wheelSpeed: 0.6,
                suppressScrollX: true
            });
        }
    }

    function qodefHandleAddToCompare() {
        var addToCompare = $('.qodef-re-add-to-compare');
        if(addToCompare.length) {
            addToCompare.each(function() {
               var thisCompare = $(this);
               if(!thisCompare.hasClass('qodef-init-compare')) {
                   thisCompare.on('click', function () {
                       var id = $(this).data('item-id');
                       qodefInitAddToCompareClick(id);
                   });
                   thisCompare.addClass('qodef-init-compare');
               }
            });
        }
    }

    function qodefInitAddToCompareClick(id) {
        var ajaxData = {
            action: 'qodef_re_handle_add_to_compare',
            item_id: id
        };

        $.ajax({
            type: 'POST',
            data: ajaxData,
            url: QodeAdminAjax.ajaxurl,
            success: function (data) {
                var responseObject = JSON.parse(data);
                var dataReceived = responseObject.data;
                var action = dataReceived.action;
                var buttonText = dataReceived.button_text;
                if(action == 'removed') {
                    qodefRemoveCompareFromList(id);
                    qodefRefreshComparePopup();
                    qodefRefreshOpenIcon(dataReceived.items_no);
                    qodefCompareHolderScroll();
	                qodefRefreshCompareButtonText(id, buttonText);
                }
                else if(action == 'error') {
                    alert(dataReceived.message)
                }
                else if(action == 'added') {
                    qodefAddCompareToList(dataReceived.item);
                    qodefRefreshComparePopup();
                    qodefRefreshOpenIcon(dataReceived.items_no);
                    qodefCompareHolderScroll();
	                qodefRefreshCompareButtonText(id, buttonText);
                }
            }
        });
    }

    function qodefRemoveCompareFromList(id) {
        var compareItemsHolder = $('.qodef-re-compare-items-holder');
        if(compareItemsHolder.length) {
            var itemToRemove = compareItemsHolder.find(".qodef-ci-item[data-item-id='" + id + "']");
            itemToRemove.addClass('qodef-with-opacity');
            itemToRemove.remove();
        }
    }

    function qodefAddCompareToList(item) {
        var compareItemsHolder = $('.qodef-re-compare-items-holder');
        if(compareItemsHolder.length) {
            compareItemsHolder.append(item);
            qodefHandleAddToCompare();
        }
    }

    function qodefInitItemsComparingPopup() {
        var comparePopupHolder = $('.qodef-re-compare-popup');
        if(comparePopupHolder.length) {
            if(!comparePopupHolder.hasClass('qodef-re-popup-opened')){
                comparePopupHolder.addClass('qodef-re-popup-opened');
                qode.modules.common.qodefDisableScroll();
	            qodefInitComparePopupScroll();
            }
        }
    }

    function qodefInitComparePopupScroll(){
        var comparePopupHolder = $('.qodef-re-compare-popup'),
            itemsHolder = comparePopupHolder.find('#qodef-re-popup-items');
	    itemsHolder.perfectScrollbar({
            wheelSpeed: 0.6,
            suppressScrollX: true
        });
    }

    function qodefInitComparePopupClose(){
        var comparePopupHolder = $('.qodef-re-compare-popup');
        comparePopupHolder.removeClass('qodef-re-popup-opened');
	    qode.modules.common.qodefEnableScroll();
    }

    function qodefInitItemsReset() {
        var compareItemsHolder = $('.qodef-re-compare-items-holder');
        if(compareItemsHolder.length) {
            var ajaxData = {
                action: 'qodef_re_handle_clear_compare_list'
            };

            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var responseObject = JSON.parse(data);
                    var status = responseObject.status;
                    if(status == 'success') {
                        var returnData = responseObject.data;
                        var buttonText = returnData.button_text;
                        compareItemsHolder.empty();
                        qodefRefreshComparePopup();
                        qodefRefreshOpenIcon(0);
	                    qodefRefreshCompareButtonText(0,buttonText);
                    }
                }
            });
        }
    }

    function qodefRefreshComparePopup() {
        var itemsHolder = $('.qodef-re-popup-items-holder');
        itemsHolder.find('ul').addClass('qodef-with-opacity');
        if (itemsHolder.length) {
            var ajaxData = {
                action: 'qodef_re_refresh_compare_popup'
            };
            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var responseObject = JSON.parse(data);
                    var status = responseObject.status;
                    if(status == 'success') {
                        itemsHolder.html(responseObject.data);
                        qodefHandleAddToCompare();
                    }
                }
            });
        }
    }

    function qodefRefreshOpenIcon(items_no) {
        var itemsHolder = $('.qodef-re-compare-holder');
        var compareHolderButtonOpen = $('a.qodef-re-compare-holder-opener');
        if (itemsHolder.length) {
            if(items_no == 0) {
                if(!itemsHolder.hasClass('qodef-compare-empty')) {
                    itemsHolder.addClass('qodef-compare-empty');
                }
                if (compareHolderButtonOpen.hasClass('opened')) {
                    compareHolderButtonOpen.trigger('click');
                }
                qodefInitComparePopupClose();
            } else if(items_no > 0) {
                if(itemsHolder.hasClass('qodef-compare-empty')) {
                    itemsHolder.removeClass('qodef-compare-empty');
                }
            }
        }
    }
	
	function qodefRefreshCompareButtonText(id, text) {
        if(id == 0) {
	        var addToCompareAll = $('.qodef-re-add-to-compare');
	        if(addToCompareAll.length) {
		        addToCompareAll.each(function() {
			        $(this).find('.qodef-re-add-to-compare-text').text(text);
		        });
	        }
        } else {
	        var addToCompareID = $('.qodef-re-add-to-compare[data-item-id="' + id + '"]');
	        if (addToCompareID.length) {
		        addToCompareID.each(function () {
			        $(this).find('.qodef-re-add-to-compare-text').text(text);
		        });
	        }
        }
    }

})(jQuery);

(function ($) {
    'use strict';

    var propertyProfile = {};
    qode.modules.propertyProfile = propertyProfile;

    propertyProfile.qodefOnDocumentReady = qodefOnDocumentReady;

    $(document).ready(qodefOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefInitSavedSearchesRemove();
	    qodefInitSelect2();
    }

    function qodefInitSavedSearchesRemove() {
        var searchesTab = $('.qodef-re-profile-searches-holder');
        if(searchesTab.length) {
            var removeQueryButton = searchesTab.find('.qodef-undo-query-save');
            removeQueryButton.on('click', function () {
                if(!confirm('Are you sure you want to remove this search?')) {
                    return;
                }

                var thisButton = $(this);
                thisButton.html('<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>');

                var ajaxData = {
                    action: 'qodef_re_property_ajax_remove_query',
                    query_id: thisButton.data('query-id')
                };

                $.ajax({
                    type: 'POST',
                    data: ajaxData,
                    url: QodeAdminAjax.ajaxurl,
                    success: function (data) {
                        var response;
                        response = JSON.parse(data);
                        if(response.status == 'success') {
                            thisButton.closest('tr').remove();
                        } else if(response.status == 'error') {
                            thisButton.html('<i class="fa fa-times" aria-hidden="true"></i>');
                        }
                    }
                });
            });
        }
    }
    
    /*
     ** Init select2 script for select html dropdowns
     */
	function qodefInitSelect2() {
		var selectDropdown = $('.qodef-add-property-page .qodef-dashboard-item select, .qodef-edit-property-page .qodef-dashboard-item select');
		if (selectDropdown.length) {
		    selectDropdown.each(function() {
		       var thisDropdown = $(this);
			    thisDropdown.select2({
				    minimumResultsForSearch: Infinity
			    });
            });
		}
	}

})(jQuery);
(function($) {
	'use strict';

	var elementorPropertyCityListSlider = {};
	qode.modules.elementorPropertyCityListSlider = elementorPropertyCityListSlider;

	elementorPropertyCityListSlider.qodeInitElementorPropertyCityListSlider = qodeInitElementorPropertyCityListSlider;


	elementorPropertyCityListSlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertyCityListSlider();
	}

	function qodeInitElementorPropertyCityListSlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_city_list_slider.default', function() {
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);

(function($) {
	'use strict';

	var elementorPropertyLargeSlider = {};
	qode.modules.elementorPropertyLargeSlider = elementorPropertyLargeSlider;

	elementorPropertyLargeSlider.qodeInitElementorPropertyLargeSlider = qodeInitElementorPropertyLargeSlider;


	elementorPropertyLargeSlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertyLargeSlider();
	}

	function qodeInitElementorPropertyLargeSlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_large_slider.default', function() {
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);

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
(function($) {
	'use strict';

	var elementorPropertySearch = {};
	qode.modules.elementorPropertySearch = elementorPropertySearch;

	elementorPropertySearch.qodeInitElementorPropertySearch = qodeInitElementorPropertySearch;


	elementorPropertySearch.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertySearch();
	}

	function qodeInitElementorPropertySearch(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_search.default', function() {
				qode.modules.propertySearch.initSearchParams();
			} );
		});
	}

})(jQuery);

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

(function($) {
	'use strict';

	var elementorPropertySlider = {};
	qode.modules.elementorPropertySlider = elementorPropertySlider;

	elementorPropertySlider.qodeInitElementorPropertySlider = qodeInitElementorPropertySlider;


	elementorPropertySlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertySlider();
	}

	function qodeInitElementorPropertySlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_slider.default', function() {
				console.log('krga');
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);

(function($) {
	'use strict';

	var elementorPropertyTypeSlider = {};
	qode.modules.elementorPropertyTypeSlider = elementorPropertyTypeSlider;

	elementorPropertyTypeSlider.qodeInitElementorPropertyTypeSlider = qodeInitElementorPropertyTypeSlider;


	elementorPropertyTypeSlider.qodeOnWindowLoad = qodeOnWindowLoad;

	$(window).on('load', qodeOnWindowLoad);

	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorPropertyTypeSlider();
	}

	function qodeInitElementorPropertyTypeSlider(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_property_type_slider.default', function() {
				console.log('slider');
				qodeOwlSlider();
			} );
		});
	}

})(jQuery);

(function($) {
    'use strict';

    var idxpress = {};
    qode.modules.idxpress = idxpress;

    idxpress.qodefOnWindowLoad = qodefOnWindowLoad;

    $(window).on('load', qodefOnWindowLoad);

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodefOnWindowLoad() {
        qodefInitIDXSelect2();
    }

    /*
     ** Init select2 script for select html dropdowns
     */
    function qodefInitIDXSelect2() {
        var idxSelect = $('.dsidx-resp-search-form select');
        if (idxSelect.length) {
            idxSelect.each(function() {
               var thisSelect = $(this);

                thisSelect.select2({
                    minimumResultsForSearch: Infinity
                });
            });
        }

        var idxSort = $('.dsidx-sorting-control select');
        if(idxSort.length) {
            idxSort.each(function() {
               var thisSort = $(this);

                thisSort.select2({
                    minimumResultsForSearch: Infinity
                });
            });
        }

        var idxSchedule = $('.dsidx-contact-form-schedule-date-row select');
        if(idxSchedule.length) {
            idxSchedule.each(function() {
                var thisSchedule = $(this);

                thisSchedule.select2({
                    minimumResultsForSearch: Infinity
                });
            });
        }
    }

})(jQuery);
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
var j = jQuery.noConflict();
function CustomMarker( options ) {
    this.latlng = new google.maps.LatLng({lat: options.position.lat, lng: options.position.lng});
    this.setMap(options.map);
    this.templateData = options.templateData;
    this.markerData = {
        pin : options.markerPin
    };
}

if (typeof google === 'object') {
    CustomMarker.prototype = new google.maps.OverlayView();
}

CustomMarker.prototype.draw = function() {

    var self = this;

    var div = this.div;

    if (!div) {

        div = this.div = document.createElement('div');
        var id = this.templateData.itemId;
        div.className = 'qodef-map-marker-holder';
        div.setAttribute("id", id);

        var markerInfoTemplate = _.template( j('.qodef-info-window-template').html() );
        markerInfoTemplate = markerInfoTemplate( self.templateData );

        var markerTemplate = _.template( j('.qodef-marker-template').html() );
        markerTemplate = markerTemplate( self.markerData );

        j(div).append(markerInfoTemplate);
        j(div).append(markerTemplate);

        div.style.position = 'absolute';
        div.style.cursor = 'pointer';

        var panes = this.getPanes();
        panes.overlayImage.appendChild(div);
    }

    var point = this.getProjection().fromLatLngToDivPixel(this.latlng);

    if (point) {
        div.style.left = (point.x) + 'px';
        div.style.top = (point.y) + 'px';
    }
};

CustomMarker.prototype.remove = function() {
    if (this.div) {
        this.div.parentNode.removeChild(this.div);
        this.div = null;
    }
};

CustomMarker.prototype.getPosition = function() {
    return this.latlng;
};
(function($) {
    "use strict";

    var realEstateMaps = {};
    qode.modules.realEstateMaps = realEstateMaps;
    realEstateMaps.qodefInitMultipleRealEstateMap = qodefInitMultipleRealEstateMap;
    realEstateMaps.qodefInitSingleRealEstateMap = qodefInitSingleRealEstateMap;
    realEstateMaps.qodefInitMobileMap = qodefInitMobileMap;
    realEstateMaps.qodefReinitMultipleGoogleMaps = qodefReinitMultipleGoogleMaps;
    realEstateMaps.qodefGoogleMaps = {};

    $(document).ready(qodefOnDocumentReady);
    $(window).on('load', qodefOnWindowLoad);
    $(window).resize(qodefOnWindowResize);
    $(window).scroll(qodefOnWindowScroll);

    function qodefOnDocumentReady() {}

    function qodefOnWindowLoad() {
        qodefInitSingleRealEstateMap();
        qodefInitMultipleRealEstateMap();
        qodefInitMobileMap();
        qodefBindListTitlesAndMap();
    }

    function qodefOnWindowResize() {}

    function qodefOnWindowScroll() {}

    function qodefInitSingleRealEstateMap() {
        var mapHolder = $('#qodef-re-single-map-holder');
        if ( mapHolder.length ) {
            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemAddress({
                mapHolder: 'qodef-re-single-map-holder'
            });
        }
    }

    function qodefInitMultipleRealEstateMap() {
        var mapHolder = $('#qodef-re-multiple-map-holder');
        if ( mapHolder.length ) {
            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses({
                mapHolder: 'qodef-re-multiple-map-holder',
                hasFilter: true
            });
        }
    }

    realEstateMaps.qodefGoogleMaps = {

        //Object varibles
        mapHolder : {},
        map : {},
        markers : {},
        radius : {},

        /**
         * Returns map with single address
         *
         * @param options
         */
        getDirectoryItemAddress : function( options ) {
            /**
             * use qodefMapsVars to get variables for address, latitude, longitude by default
             */
            var defaults = {
                location : qodefSingleMapVars.single['currentRealEstate'].location,
                zoom : 16,
                mapHolder : '',
                draggable : qodefMapsVars.global.draggable,
                mapTypeControl : qodefMapsVars.global.mapTypeControl,
                scrollwheel : qodefMapsVars.global.scrollable,
                streetViewControl : qodefMapsVars.global.streetViewControl,
                zoomControl : qodefMapsVars.global.zoomControl,
                title : qodefSingleMapVars.single['currentRealEstate'].title,
                itemId : qodefSingleMapVars.single['currentRealEstate'].itemId,
                content : '',
                styles: qodefMapsVars.global.mapStyle,
                markerPin : qodefSingleMapVars.single['currentRealEstate'].markerPin,
                featuredImage : qodefSingleMapVars.single['currentRealEstate'].featuredImage,
                itemUrl : qodefSingleMapVars.single['currentRealEstate'].itemUrl
            };
            var settings = $.extend( {}, defaults, options );

            //Save variables for later usage
            this.mapHolder = settings.mapHolder;

            //Get map holder
            var mapHolder = document.getElementById( settings.mapHolder );

            //Initialize map
            var map = new google.maps.Map( mapHolder, {
                zoom : settings.zoom,
                draggable : settings.draggable,
                mapTypeControl : settings.mapTypeControl,
                scrollwheel : settings.scrollwheel,
                streetViewControl : settings.streetViewControl,
                zoomControl : settings.zoomControl
            });

            //Set map style
            map.setOptions({
                styles: settings.styles
            });

            //Try to locate by latitude and longitude
            if ( typeof settings.location !== 'undefined' && settings.location !== null) {
                var latLong = {
                    lat : parseFloat(settings.location.latitude),
                    lng : parseFloat(settings.location.longitude)
                };
                //Set map center to location
                map.setCenter(latLong);
                //Add marker to map

                var templateData = {
                    title : settings.title,
                    itemId : settings.itemId,
                    address : settings.location.address,
                    featuredImage : settings.featuredImage,
                    itemUrl : settings.itemUrl
                };

                var customMarker = new CustomMarker({
                    map : map,
                    position : latLong,
                    templateData : templateData,
                    markerPin : settings.markerPin
                });

                this.initMarkerInfo();

            }

        },

        /**
         * Returns map with multiple addresses
         *
         * @param options
         */
        getDirectoryItemsAddresses : function( options ) {
            var defaults = {
                geolocation : false,
                mapHolder : 'qodef-re-multiple-map-holder',
                addresses : qodefMultipleMapVars.multiple.addresses,
                draggable : qodefMapsVars.global.draggable,
                mapTypeControl : qodefMapsVars.global.mapTypeControl,
                scrollwheel : qodefMapsVars.global.scrollable,
                streetViewControl : qodefMapsVars.global.streetViewControl,
                zoomControl : qodefMapsVars.global.zoomControl,
                zoom : 16,
                styles: qodefMapsVars.global.mapStyle,
                radius : 50, //radius for marker visibility, in km
                hasFilter : false
            };
            var settings = $.extend({}, defaults, options );

            //Get map holder
            var mapHolder = document.getElementById( settings.mapHolder );

            //Initialize map
            var map = new google.maps.Map( mapHolder, {
                zoom : settings.zoom,
                draggable : settings.draggable,
                mapTypeControl : settings.mapTypeControl,
                scrollwheel : settings.scrollwheel,
                streetViewControl : settings.streetViewControl,
                zoomControl : settings.zoomControl
            });

            //Save variables for later usage
            this.mapHolder = settings.mapHolder;
            this.map = map;
            this.radius = settings.radius;

            //Set map style
            map.setOptions({
                styles: settings.styles
            });

            //If geolocation enabled set map center to user location
            if ( navigator.geolocation && settings.geolocation ) {
                this.centerOnCurrentLocation();
            }

            //Filter addresses, remove items without latitude and longitude
            var addresses = [],
                addressesLength = settings.addresses.length;
            if(settings.addresses.length !== null){
                for ( var i = 0; i < addressesLength; i++ ) {
                    var location = settings.addresses[i].location;
                    if ( typeof location !== 'undefined' && location !== null ) {

                        if ( location.latitude !== '' && location.longitude !== '' ) {
                            addresses.push(settings.addresses[i]);
                        }
                    }
                }
            }


            //Center map and set borders of map
            this.setMapBounds( addresses );

            //Add markers to the map
            this.addMultipleMarkers( addresses );

        },

        /**
         * Add multiple markers to map
         */
        addMultipleMarkers : function( markersData ) {

            var map = this.map;

            var markers = [];
            //Loop through markers
            var len = markersData.length;
            for ( var i = 0; i < len; i++ ) {

                var latLng = {
                    lat: parseFloat(markersData[i].location.latitude),
                    lng: parseFloat(markersData[i].location.longitude)
                };

                //Custom html markers
                //Insert marker data into info window template
                var templateData = {
                    title : markersData[i].title,
                    itemId : markersData[i].itemId,
                    address : markersData[i].location.address,
                    featuredImage : markersData[i].featuredImage,
                    itemUrl : markersData[i].itemUrl
                };

                var customMarker = new CustomMarker({
                    position : latLng,
                    map : map,
                    templateData : templateData,
                    markerPin : markersData[i].markerPin
                });

                markers.push(customMarker);

            }

            this.markers = markers;

            //Init map clusters ( Grouping map markers at small zoom values )
            this.initMapClusters();

            //Init marker info
            this.initMarkerInfo();

            //Init visible circle area around center of map
            var that = this;
            google.maps.event.addListener(map, 'idle', function(){
                var visibleRadius = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0,
                    strokeWeight: 0,
                    fillColor: '#FF0000',
                    fillOpacity: 0,
                    map: map,
                    center: map.getCenter(),
                    radius: that.radius * 1000 //in meters
                });
                //Display only markers in circle
                //that.refreshCircleAreaMarkers( visibleRadius.getBounds() );
            });

        },

        /**
         * Set map bounds for Map with multiple markers
         *
         * @param addressesArray
         */
        setMapBounds : function( addressesArray ) {

            var bounds = new google.maps.LatLngBounds();
            for ( var i = 0; i < addressesArray.length; i++ ) {
                bounds.extend( new google.maps.LatLng( parseFloat(addressesArray[i].location.latitude), parseFloat(addressesArray[i].location.longitude) ) );
            }

            this.map.fitBounds( bounds );

        },

        /**
         * Init map clusters for grouping markers on small zoom values
         */
        initMapClusters : function() {

            //Activate clustering on multiple markers
            var markerClusteringOptions = {
                minimumClusterSize: 2,
                maxZoom: 12,
                styles : [{
                    width: 50,
                    height: 60,
                    url: '',
                    textSize: 12
                }]
            };
            var markerClusterer = new MarkerClusterer(this.map, this.markers, markerClusteringOptions);

        },

        initMarkerInfo : function() {

            $(document).off('click', '.qodef-map-marker');
            $(document).on('click', '.qodef-map-marker', function() {
                var self = $(this),
                    markerHolders = $('.qodef-map-marker-holder'),
                    infoWindows = $('.qodef-info-window'),
                    markerHolder = self.parent('.qodef-map-marker-holder'),
                    infoWindow = self.siblings('.qodef-info-window');

                if ( markerHolder.hasClass('active mapActive') ) {
                    markerHolder.removeClass( 'active mapActive' );
                    infoWindow.fadeOut(0);
                } else {
                    markerHolders.removeClass('active mapActive');
                    infoWindows.fadeOut(0);
                    markerHolder.addClass('active mapActive');
                    infoWindow.fadeIn(300);
                }

            });

        },
        /**
         * Info Window for displaying data on map markers
         *
         * @returns {google.maps.InfoWindow}
         */
        addInfoWindow : function() {

            var contentString = '';
            var infoWindow = new google.maps.InfoWindow({
                content: contentString
            });
            return infoWindow;

        },

        /**
         * If geolocation enabled center map on users current position
         */
        centerOnCurrentLocation : function() {
            var map = this.map;
            navigator.geolocation.getCurrentPosition(
                function(position){
                    var center = {
                        lat : position.coords.latitude,
                        lng : position.coords.longitude
                    };
                    map.setCenter(center);
                }
            );
        },

        /**
         * Refresh area for visible markers
         *
         * @param circleArea
         */
        refreshCircleAreaMarkers : function( circleArea ) {

            var length = this.markers.length;
            for ( var i = 0; i < length; i++ ) {
                if ( circleArea.contains( this.markers[i].getPosition() ) ) {
                    this.markers[i].setVisible(true);
                } else {
                    this.markers[i].setVisible(false);
                }
            }

        },

    };

    function qodefInitMobileMap() {

        var mapOpener = $('.qodef-re-view-larger-map a'),
            mapOpenerIcon = mapOpener.children('i'),
            mapHolder = $('.qodef-map-holder');
        if (mapOpener.length) {
            mapOpener.on('click', function (e) {
                e.preventDefault();
                if (mapHolder.hasClass('qodef-fullscreen-map')) {
                    mapHolder.removeClass('qodef-fullscreen-map');
                    mapOpenerIcon.removeClass('icon-basic-magnifier-minus');
                    mapOpenerIcon.addClass('icon-basic-magnifier-plus');
                } else {
                    mapHolder.addClass('qodef-fullscreen-map');
                    mapOpenerIcon.removeClass('icon-basic-magnifier-plus');
                    mapOpenerIcon.addClass('icon-basic-magnifier-minus');
                }
                qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses();
            });
        }
    }

    function qodefReinitMultipleGoogleMaps(addresses, action){

        if(action === 'append'){

            var mapObjs = qodefMultipleMapVars.multiple.addresses;
            mapObjs = qodefMultipleMapVars.multiple.addresses.concat(addresses);
            qodefMultipleMapVars.multiple.addresses = mapObjs;

            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses({
                addresses: mapObjs
            });
        }
        else if(action === 'replace'){

            qodefMultipleMapVars.multiple.addresses = addresses;
            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses({
                addresses: addresses
            });

        }

        qodefBindListTitlesAndMap();
    }

    function qodefBindListTitlesAndMap() {
        var itemsList = $('.qodef-map-list-holder');
        if(itemsList.length){
            itemsList.each(function(){
                var thisItemsList = $(this),
                    itemsHolder = thisItemsList.find('.qodef-ml-inner'),
                    listItems = thisItemsList.find('article'),
                    map = thisItemsList.find('.qodef-map-list-map-part');

                if(map.length) {
                    listItems.each(function() {
                        //Init hover
                        var listItem = $(this);
                        if(!listItem.hasClass("qodef-init")) {
                            listItem.mouseenter(function () {
                                var itemId = listItem.attr('id');
                                var markersHolder = $('.qodef-map-marker-holder:not(.mapActive)');
                                if (markersHolder.length) {
                                    markersHolder.removeClass('active');
                                    $('#' + itemId + '.qodef-map-marker-holder').addClass('active');
                                }
                            });
                            listItem.addClass("qodef-init")
                        }
                    });
                    itemsHolder.mouseleave(function () {
                        $('.qodef-map-marker-holder').each(function() {
                            if(!$(this).hasClass('mapActive')) {
                                $(this).removeClass('active');
                            }
                        });
                    });
                }
            });
        }
    }

})(jQuery);
/**
 * @name MarkerClusterer for Google Maps v3
 * @version version 1.0
 * @author Luke Mahe
 * @fileoverview
 * The library creates and manages per-zoom-level clusters for large amounts of
 * markers.
 * <br/>
 * This is a v3 implementation of the
 * <a href="http://gmaps-utility-library-dev.googlecode.com/svn/tags/markerclusterer/"
 * >v2 MarkerClusterer</a>.
 */

/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


/**
 * A Marker Clusterer that clusters markers.
 *
 * @param {google.maps.Map} map The Google map to attach to.
 * @param {Array.<google.maps.Marker>=} opt_markers Optional markers to add to
 *   the cluster.
 * @param {Object=} opt_options support the following options:
 *     'gridSize': (number) The grid size of a cluster in pixels.
 *     'maxZoom': (number) The maximum zoom level that a marker can be part of a
 *                cluster.
 *     'zoomOnClick': (boolean) Whether the default behaviour of clicking on a
 *                    cluster is to zoom into it.
 *     'averageCenter': (boolean) Wether the center of each cluster should be
 *                      the average of all markers in the cluster.
 *     'minimumClusterSize': (number) The minimum number of markers to be in a
 *                           cluster before the markers are hidden and a count
 *                           is shown.
 *     'styles': (object) An object that has style properties:
 *       'url': (string) The image url.
 *       'height': (number) The image height.
 *       'width': (number) The image width.
 *       'anchor': (Array) The anchor position of the label text.
 *       'textColor': (string) The text color.
 *       'textSize': (number) The text size.
 *       'backgroundPosition': (string) The position of the backgound x, y.
 *       'iconAnchor': (Array) The anchor position of the icon x, y.
 * @constructor
 * @extends google.maps.OverlayView
 */
function MarkerClusterer(map, opt_markers, opt_options) {
    // MarkerClusterer implements google.maps.OverlayView interface. We use the
    // extend function to extend MarkerClusterer with google.maps.OverlayView
    // because it might not always be available when the code is defined so we
    // look for it at the last possible moment. If it doesn't exist now then
    // there is no point going ahead :)
    this.extend(MarkerClusterer, google.maps.OverlayView);
    this.map_ = map;

    /**
     * @type {Array.<google.maps.Marker>}
     * @private
     */
    this.markers_ = [];

    /**
     *  @type {Array.<Cluster>}
     */
    this.clusters_ = [];

    this.sizes = [53, 56, 66, 78, 90];

    /**
     * @private
     */
    this.styles_ = [];

    /**
     * @type {boolean}
     * @private
     */
    this.ready_ = false;

    var options = opt_options || {};

    /**
     * @type {number}
     * @private
     */
    this.gridSize_ = options['gridSize'] || 60;

    /**
     * @private
     */
    this.minClusterSize_ = options['minimumClusterSize'] || 2;


    /**
     * @type {?number}
     * @private
     */
    this.maxZoom_ = options['maxZoom'] || null;

    this.styles_ = options['styles'] || [];

    /**
     * @type {string}
     * @private
     */
    this.imagePath_ = options['imagePath'] ||
        this.MARKER_CLUSTER_IMAGE_PATH_;

    /**
     * @type {string}
     * @private
     */
    this.imageExtension_ = options['imageExtension'] ||
        this.MARKER_CLUSTER_IMAGE_EXTENSION_;

    /**
     * @type {boolean}
     * @private
     */
    this.zoomOnClick_ = true;

    if (options['zoomOnClick'] != undefined) {
        this.zoomOnClick_ = options['zoomOnClick'];
    }

    /**
     * @type {boolean}
     * @private
     */
    this.averageCenter_ = false;

    if (options['averageCenter'] != undefined) {
        this.averageCenter_ = options['averageCenter'];
    }

    this.setupStyles_();

    this.setMap(map);

    /**
     * @type {number}
     * @private
     */
    this.prevZoom_ = this.map_.getZoom();

    // Add the map event listeners
    var that = this;
    google.maps.event.addListener(this.map_, 'zoom_changed', function() {
        var zoom = that.map_.getZoom();

        if (that.prevZoom_ != zoom) {
            that.prevZoom_ = zoom;
            that.resetViewport();
        }
    });

    google.maps.event.addListener(this.map_, 'idle', function() {
        that.redraw();
    });

    // Finally, add the markers
    if (opt_markers && opt_markers.length) {
        this.addMarkers(opt_markers, false);
    }
}


/**
 * The marker cluster image path.
 *
 * @type {string}
 * @private
 */
MarkerClusterer.prototype.MARKER_CLUSTER_IMAGE_PATH_ =
    'https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/' +
    'images/m';


/**
 * The marker cluster image path.
 *
 * @type {string}
 * @private
 */
MarkerClusterer.prototype.MARKER_CLUSTER_IMAGE_EXTENSION_ = 'png';


/**
 * Extends a objects prototype by anothers.
 *
 * @param {Object} obj1 The object to be extended.
 * @param {Object} obj2 The object to extend with.
 * @return {Object} The new extended object.
 * @ignore
 */
MarkerClusterer.prototype.extend = function(obj1, obj2) {
    return (function(object) {
        for (var property in object.prototype) {
            this.prototype[property] = object.prototype[property];
        }
        return this;
    }).apply(obj1, [obj2]);
};


/**
 * Implementaion of the interface method.
 * @ignore
 */
MarkerClusterer.prototype.onAdd = function() {
    this.setReady_(true);
};

/**
 * Implementaion of the interface method.
 * @ignore
 */
MarkerClusterer.prototype.draw = function() {};

/**
 * Sets up the styles object.
 *
 * @private
 */
MarkerClusterer.prototype.setupStyles_ = function() {
    if (this.styles_.length) {
        return;
    }

    for (var i = 0, size; size = this.sizes[i]; i++) {
        this.styles_.push({
            url: this.imagePath_ + (i + 1) + '.' + this.imageExtension_,
            height: size,
            width: size
        });
    }
};

/**
 *  Fit the map to the bounds of the markers in the clusterer.
 */
MarkerClusterer.prototype.fitMapToMarkers = function() {
    var markers = this.getMarkers();
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, marker; marker = markers[i]; i++) {
        bounds.extend(marker.getPosition());
    }

    this.map_.fitBounds(bounds);
};


/**
 *  Sets the styles.
 *
 *  @param {Object} styles The style to set.
 */
MarkerClusterer.prototype.setStyles = function(styles) {
    this.styles_ = styles;
};


/**
 *  Gets the styles.
 *
 *  @return {Object} The styles object.
 */
MarkerClusterer.prototype.getStyles = function() {
    return this.styles_;
};


/**
 * Whether zoom on click is set.
 *
 * @return {boolean} True if zoomOnClick_ is set.
 */
MarkerClusterer.prototype.isZoomOnClick = function() {
    return this.zoomOnClick_;
};

/**
 * Whether average center is set.
 *
 * @return {boolean} True if averageCenter_ is set.
 */
MarkerClusterer.prototype.isAverageCenter = function() {
    return this.averageCenter_;
};


/**
 *  Returns the array of markers in the clusterer.
 *
 *  @return {Array.<google.maps.Marker>} The markers.
 */
MarkerClusterer.prototype.getMarkers = function() {
    return this.markers_;
};


/**
 *  Returns the number of markers in the clusterer
 *
 *  @return {Number} The number of markers.
 */
MarkerClusterer.prototype.getTotalMarkers = function() {
    return this.markers_.length;
};


/**
 *  Sets the max zoom for the clusterer.
 *
 *  @param {number} maxZoom The max zoom level.
 */
MarkerClusterer.prototype.setMaxZoom = function(maxZoom) {
    this.maxZoom_ = maxZoom;
};


/**
 *  Gets the max zoom for the clusterer.
 *
 *  @return {number} The max zoom level.
 */
MarkerClusterer.prototype.getMaxZoom = function() {
    return this.maxZoom_;
};


/**
 *  The function for calculating the cluster icon image.
 *
 *  @param {Array.<google.maps.Marker>} markers The markers in the clusterer.
 *  @param {number} numStyles The number of styles available.
 *  @return {Object} A object properties: 'text' (string) and 'index' (number).
 *  @private
 */
MarkerClusterer.prototype.calculator_ = function(markers, numStyles) {
    var index = 0;
    var count = markers.length;
    var dv = count;
    while (dv !== 0) {
        dv = parseInt(dv / 10, 10);
        index++;
    }

    index = Math.min(index, numStyles);
    return {
        text: count,
        index: index
    };
};


/**
 * Set the calculator function.
 *
 * @param {function(Array, number)} calculator The function to set as the
 *     calculator. The function should return a object properties:
 *     'text' (string) and 'index' (number).
 *
 */
MarkerClusterer.prototype.setCalculator = function(calculator) {
    this.calculator_ = calculator;
};


/**
 * Get the calculator function.
 *
 * @return {function(Array, number)} the calculator function.
 */
MarkerClusterer.prototype.getCalculator = function() {
    return this.calculator_;
};


/**
 * Add an array of markers to the clusterer.
 *
 * @param {Array.<google.maps.Marker>} markers The markers to add.
 * @param {boolean=} opt_nodraw Whether to redraw the clusters.
 */
MarkerClusterer.prototype.addMarkers = function(markers, opt_nodraw) {
    for (var i = 0, marker; marker = markers[i]; i++) {
        this.pushMarkerTo_(marker);
    }
    if (!opt_nodraw) {
        this.redraw();
    }
};


/**
 * Pushes a marker to the clusterer.
 *
 * @param {google.maps.Marker} marker The marker to add.
 * @private
 */
MarkerClusterer.prototype.pushMarkerTo_ = function(marker) {
    marker.isAdded = false;
    if (marker['draggable']) {
        // If the marker is draggable add a listener so we update the clusters on
        // the drag end.
        var that = this;
        google.maps.event.addListener(marker, 'dragend', function() {
            marker.isAdded = false;
            that.repaint();
        });
    }
    this.markers_.push(marker);
};


/**
 * Adds a marker to the clusterer and redraws if needed.
 *
 * @param {google.maps.Marker} marker The marker to add.
 * @param {boolean=} opt_nodraw Whether to redraw the clusters.
 */
MarkerClusterer.prototype.addMarker = function(marker, opt_nodraw) {
    this.pushMarkerTo_(marker);
    if (!opt_nodraw) {
        this.redraw();
    }
};


/**
 * Removes a marker and returns true if removed, false if not
 *
 * @param {google.maps.Marker} marker The marker to remove
 * @return {boolean} Whether the marker was removed or not
 * @private
 */
MarkerClusterer.prototype.removeMarker_ = function(marker) {
    var index = -1;
    if (this.markers_.indexOf) {
        index = this.markers_.indexOf(marker);
    } else {
        for (var i = 0, m; m = this.markers_[i]; i++) {
            if (m == marker) {
                index = i;
                break;
            }
        }
    }

    if (index == -1) {
        // Marker is not in our list of markers.
        return false;
    }

    marker.setMap(null);

    this.markers_.splice(index, 1);

    return true;
};


/**
 * Remove a marker from the cluster.
 *
 * @param {google.maps.Marker} marker The marker to remove.
 * @param {boolean=} opt_nodraw Optional boolean to force no redraw.
 * @return {boolean} True if the marker was removed.
 */
MarkerClusterer.prototype.removeMarker = function(marker, opt_nodraw) {
    var removed = this.removeMarker_(marker);

    if (!opt_nodraw && removed) {
        this.resetViewport();
        this.redraw();
        return true;
    } else {
        return false;
    }
};


/**
 * Removes an array of markers from the cluster.
 *
 * @param {Array.<google.maps.Marker>} markers The markers to remove.
 * @param {boolean=} opt_nodraw Optional boolean to force no redraw.
 */
MarkerClusterer.prototype.removeMarkers = function(markers, opt_nodraw) {
    var removed = false;

    for (var i = 0, marker; marker = markers[i]; i++) {
        var r = this.removeMarker_(marker);
        removed = removed || r;
    }

    if (!opt_nodraw && removed) {
        this.resetViewport();
        this.redraw();
        return true;
    }
};


/**
 * Sets the clusterer's ready state.
 *
 * @param {boolean} ready The state.
 * @private
 */
MarkerClusterer.prototype.setReady_ = function(ready) {
    if (!this.ready_) {
        this.ready_ = ready;
        this.createClusters_();
    }
};


/**
 * Returns the number of clusters in the clusterer.
 *
 * @return {number} The number of clusters.
 */
MarkerClusterer.prototype.getTotalClusters = function() {
    return this.clusters_.length;
};


/**
 * Returns the google map that the clusterer is associated with.
 *
 * @return {google.maps.Map} The map.
 */
MarkerClusterer.prototype.getMap = function() {
    return this.map_;
};


/**
 * Sets the google map that the clusterer is associated with.
 *
 * @param {google.maps.Map} map The map.
 */
MarkerClusterer.prototype.setMap = function(map) {
    this.map_ = map;
};


/**
 * Returns the size of the grid.
 *
 * @return {number} The grid size.
 */
MarkerClusterer.prototype.getGridSize = function() {
    return this.gridSize_;
};


/**
 * Sets the size of the grid.
 *
 * @param {number} size The grid size.
 */
MarkerClusterer.prototype.setGridSize = function(size) {
    this.gridSize_ = size;
};


/**
 * Returns the min cluster size.
 *
 * @return {number} The grid size.
 */
MarkerClusterer.prototype.getMinClusterSize = function() {
    return this.minClusterSize_;
};

/**
 * Sets the min cluster size.
 *
 * @param {number} size The grid size.
 */
MarkerClusterer.prototype.setMinClusterSize = function(size) {
    this.minClusterSize_ = size;
};


/**
 * Extends a bounds object by the grid size.
 *
 * @param {google.maps.LatLngBounds} bounds The bounds to extend.
 * @return {google.maps.LatLngBounds} The extended bounds.
 */
MarkerClusterer.prototype.getExtendedBounds = function(bounds) {
    var projection = this.getProjection();

    // Turn the bounds into latlng.
    var tr = new google.maps.LatLng(bounds.getNorthEast().lat(),
        bounds.getNorthEast().lng());
    var bl = new google.maps.LatLng(bounds.getSouthWest().lat(),
        bounds.getSouthWest().lng());

    // Convert the points to pixels and the extend out by the grid size.
    var trPix = projection.fromLatLngToDivPixel(tr);
    trPix.x += this.gridSize_;
    trPix.y -= this.gridSize_;

    var blPix = projection.fromLatLngToDivPixel(bl);
    blPix.x -= this.gridSize_;
    blPix.y += this.gridSize_;

    // Convert the pixel points back to LatLng
    var ne = projection.fromDivPixelToLatLng(trPix);
    var sw = projection.fromDivPixelToLatLng(blPix);

    // Extend the bounds to contain the new bounds.
    bounds.extend(ne);
    bounds.extend(sw);

    return bounds;
};


/**
 * Determins if a marker is contained in a bounds.
 *
 * @param {google.maps.Marker} marker The marker to check.
 * @param {google.maps.LatLngBounds} bounds The bounds to check against.
 * @return {boolean} True if the marker is in the bounds.
 * @private
 */
MarkerClusterer.prototype.isMarkerInBounds_ = function(marker, bounds) {
    return bounds.contains(marker.getPosition());
};


/**
 * Clears all clusters and markers from the clusterer.
 */
MarkerClusterer.prototype.clearMarkers = function() {
    this.resetViewport(true);

    // Set the markers a empty array.
    this.markers_ = [];
};


/**
 * Clears all existing clusters and recreates them.
 * @param {boolean} opt_hide To also hide the marker.
 */
MarkerClusterer.prototype.resetViewport = function(opt_hide) {
    // Remove all the clusters
    for (var i = 0, cluster; cluster = this.clusters_[i]; i++) {
        cluster.remove();
    }

    // Reset the markers to not be added and to be invisible.
    for (var i = 0, marker; marker = this.markers_[i]; i++) {
        marker.isAdded = false;
        if (opt_hide) {
            marker.setMap(null);
        }
    }

    this.clusters_ = [];
};

/**
 *
 */
MarkerClusterer.prototype.repaint = function() {
    var oldClusters = this.clusters_.slice();
    this.clusters_.length = 0;
    this.resetViewport();
    this.redraw();

    // Remove the old clusters.
    // Do it in a timeout so the other clusters have been drawn first.
    window.setTimeout(function() {
        for (var i = 0, cluster; cluster = oldClusters[i]; i++) {
            cluster.remove();
        }
    }, 0);
};


/**
 * Redraws the clusters.
 */
MarkerClusterer.prototype.redraw = function() {
    this.createClusters_();
};


/**
 * Calculates the distance between two latlng locations in km.
 * @see http://www.movable-type.co.uk/scripts/latlong.html
 *
 * @param {google.maps.LatLng} p1 The first lat lng point.
 * @param {google.maps.LatLng} p2 The second lat lng point.
 * @return {number} The distance between the two points in km.
 * @private
 */
MarkerClusterer.prototype.distanceBetweenPoints_ = function(p1, p2) {
    if (!p1 || !p2) {
        return 0;
    }

    var R = 6371; // Radius of the Earth in km
    var dLat = (p2.lat() - p1.lat()) * Math.PI / 180;
    var dLon = (p2.lng() - p1.lng()) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(p1.lat() * Math.PI / 180) * Math.cos(p2.lat() * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d;
};


/**
 * Add a marker to a cluster, or creates a new cluster.
 *
 * @param {google.maps.Marker} marker The marker to add.
 * @private
 */
MarkerClusterer.prototype.addToClosestCluster_ = function(marker) {
    var distance = 40000; // Some large number
    var clusterToAddTo = null;
    var pos = marker.getPosition();
    for (var i = 0, cluster; cluster = this.clusters_[i]; i++) {
        var center = cluster.getCenter();
        if (center) {
            var d = this.distanceBetweenPoints_(center, marker.getPosition());
            if (d < distance) {
                distance = d;
                clusterToAddTo = cluster;
            }
        }
    }

    if (clusterToAddTo && clusterToAddTo.isMarkerInClusterBounds(marker)) {
        clusterToAddTo.addMarker(marker);
    } else {
        var cluster = new Cluster(this);
        cluster.addMarker(marker);
        this.clusters_.push(cluster);
    }
};


/**
 * Creates the clusters.
 *
 * @private
 */
MarkerClusterer.prototype.createClusters_ = function() {
    if (!this.ready_) {
        return;
    }

    // Get our current map view bounds.
    // Create a new bounds object so we don't affect the map.
    var mapBounds = new google.maps.LatLngBounds(this.map_.getBounds().getSouthWest(),
        this.map_.getBounds().getNorthEast());
    var bounds = this.getExtendedBounds(mapBounds);

    for (var i = 0, marker; marker = this.markers_[i]; i++) {
        if (!marker.isAdded && this.isMarkerInBounds_(marker, bounds)) {
            this.addToClosestCluster_(marker);
        }
    }
};


/**
 * A cluster that contains markers.
 *
 * @param {MarkerClusterer} markerClusterer The markerclusterer that this
 *     cluster is associated with.
 * @constructor
 * @ignore
 */
function Cluster(markerClusterer) {
    this.markerClusterer_ = markerClusterer;
    this.map_ = markerClusterer.getMap();
    this.gridSize_ = markerClusterer.getGridSize();
    this.minClusterSize_ = markerClusterer.getMinClusterSize();
    this.averageCenter_ = markerClusterer.isAverageCenter();
    this.center_ = null;
    this.markers_ = [];
    this.bounds_ = null;
    this.clusterIcon_ = new ClusterIcon(this, markerClusterer.getStyles(),
        markerClusterer.getGridSize());
}

/**
 * Determins if a marker is already added to the cluster.
 *
 * @param {google.maps.Marker} marker The marker to check.
 * @return {boolean} True if the marker is already added.
 */
Cluster.prototype.isMarkerAlreadyAdded = function(marker) {
    if (this.markers_.indexOf) {
        return this.markers_.indexOf(marker) != -1;
    } else {
        for (var i = 0, m; m = this.markers_[i]; i++) {
            if (m == marker) {
                return true;
            }
        }
    }
    return false;
};


/**
 * Add a marker the cluster.
 *
 * @param {google.maps.Marker} marker The marker to add.
 * @return {boolean} True if the marker was added.
 */
Cluster.prototype.addMarker = function(marker) {
    if (this.isMarkerAlreadyAdded(marker)) {
        return false;
    }

    if (!this.center_) {
        this.center_ = marker.getPosition();
        this.calculateBounds_();
    } else {
        if (this.averageCenter_) {
            var l = this.markers_.length + 1;
            var lat = (this.center_.lat() * (l-1) + marker.getPosition().lat()) / l;
            var lng = (this.center_.lng() * (l-1) + marker.getPosition().lng()) / l;
            this.center_ = new google.maps.LatLng(lat, lng);
            this.calculateBounds_();
        }
    }

    marker.isAdded = true;
    this.markers_.push(marker);

    var len = this.markers_.length;
    if (len < this.minClusterSize_ && marker.getMap() != this.map_) {
        // Min cluster size not reached so show the marker.
        marker.setMap(this.map_);
    }

    if (len == this.minClusterSize_) {
        // Hide the markers that were showing.
        for (var i = 0; i < len; i++) {
            this.markers_[i].setMap(null);
        }
    }

    if (len >= this.minClusterSize_) {
        marker.setMap(null);
    }

    this.updateIcon();
    return true;
};


/**
 * Returns the marker clusterer that the cluster is associated with.
 *
 * @return {MarkerClusterer} The associated marker clusterer.
 */
Cluster.prototype.getMarkerClusterer = function() {
    return this.markerClusterer_;
};


/**
 * Returns the bounds of the cluster.
 *
 * @return {google.maps.LatLngBounds} the cluster bounds.
 */
Cluster.prototype.getBounds = function() {
    var bounds = new google.maps.LatLngBounds(this.center_, this.center_);
    var markers = this.getMarkers();
    for (var i = 0, marker; marker = markers[i]; i++) {
        bounds.extend(marker.getPosition());
    }
    return bounds;
};


/**
 * Removes the cluster
 */
Cluster.prototype.remove = function() {
    this.clusterIcon_.remove();
    this.markers_.length = 0;
    delete this.markers_;
};


/**
 * Returns the center of the cluster.
 *
 * @return {number} The cluster center.
 */
Cluster.prototype.getSize = function() {
    return this.markers_.length;
};


/**
 * Returns the center of the cluster.
 *
 * @return {Array.<google.maps.Marker>} The cluster center.
 */
Cluster.prototype.getMarkers = function() {
    return this.markers_;
};


/**
 * Returns the center of the cluster.
 *
 * @return {google.maps.LatLng} The cluster center.
 */
Cluster.prototype.getCenter = function() {
    return this.center_;
};


/**
 * Calculated the extended bounds of the cluster with the grid.
 *
 * @private
 */
Cluster.prototype.calculateBounds_ = function() {
    var bounds = new google.maps.LatLngBounds(this.center_, this.center_);
    this.bounds_ = this.markerClusterer_.getExtendedBounds(bounds);
};


/**
 * Determines if a marker lies in the clusters bounds.
 *
 * @param {google.maps.Marker} marker The marker to check.
 * @return {boolean} True if the marker lies in the bounds.
 */
Cluster.prototype.isMarkerInClusterBounds = function(marker) {
    return this.bounds_.contains(marker.getPosition());
};


/**
 * Returns the map that the cluster is associated with.
 *
 * @return {google.maps.Map} The map.
 */
Cluster.prototype.getMap = function() {
    return this.map_;
};


/**
 * Updates the cluster icon
 */
Cluster.prototype.updateIcon = function() {
    var zoom = this.map_.getZoom();
    var mz = this.markerClusterer_.getMaxZoom();

    if (mz && zoom > mz) {
        // The zoom is greater than our max zoom so show all the markers in cluster.
        for (var i = 0, marker; marker = this.markers_[i]; i++) {
            marker.setMap(this.map_);
        }
        return;
    }

    if (this.markers_.length < this.minClusterSize_) {
        // Min cluster size not yet reached.
        this.clusterIcon_.hide();
        return;
    }

    var numStyles = this.markerClusterer_.getStyles().length;
    var sums = this.markerClusterer_.getCalculator()(this.markers_, numStyles);
    this.clusterIcon_.setCenter(this.center_);
    this.clusterIcon_.setSums(sums);
    this.clusterIcon_.show();
};


/**
 * A cluster icon
 *
 * @param {Cluster} cluster The cluster to be associated with.
 * @param {Object} styles An object that has style properties:
 *     'url': (string) The image url.
 *     'height': (number) The image height.
 *     'width': (number) The image width.
 *     'anchor': (Array) The anchor position of the label text.
 *     'textColor': (string) The text color.
 *     'textSize': (number) The text size.
 *     'backgroundPosition: (string) The background postition x, y.
 * @param {number=} opt_padding Optional padding to apply to the cluster icon.
 * @constructor
 * @extends google.maps.OverlayView
 * @ignore
 */
function ClusterIcon(cluster, styles, opt_padding) {
    cluster.getMarkerClusterer().extend(ClusterIcon, google.maps.OverlayView);

    this.styles_ = styles;
    this.padding_ = opt_padding || 0;
    this.cluster_ = cluster;
    this.center_ = null;
    this.map_ = cluster.getMap();
    this.div_ = null;
    this.sums_ = null;
    this.visible_ = false;

    this.setMap(this.map_);
}


/**
 * Triggers the clusterclick event and zoom's if the option is set.
 *
 * @param {google.maps.MouseEvent} event The event to propagate
 */
ClusterIcon.prototype.triggerClusterClick = function(event) {
    var markerClusterer = this.cluster_.getMarkerClusterer();

    // Trigger the clusterclick event.
    google.maps.event.trigger(markerClusterer, 'clusterclick', this.cluster_, event);

    if (markerClusterer.isZoomOnClick()) {
        // Zoom into the cluster.
        this.map_.fitBounds(this.cluster_.getBounds());
    }
};


/**
 * Adding the cluster icon to the dom.
 * @ignore
 */
ClusterIcon.prototype.onAdd = function() {
    this.div_ = document.createElement('DIV');
    this.div_.className = 'qodef-cluster-marker';
    if (this.visible_) {
        var pos = this.getPosFromLatLng_(this.center_);
        this.div_.style.cssText = this.createCss(pos);
        this.div_.innerHTML = '<div class="qodef-cluster-marker-inner">' +
            '<span class="qodef-cluster-marker-number">' + this.sums_.text + '</span>' +
            '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"' +
            'width="594.657px" height="832.35px" viewBox="0 0 594.657 832.35" enable-background="new 0 0 594.657 832.35" xml:space="preserve">' +
            '<path fill="" d="M507.572,87.086C451.414,30.928,376.748,0,297.329,0S143.244,30.928,87.086,87.086S0,217.91,0,297.33' +
            'c0,37.328,8.104,75.127,24.773,115.561c13.006,31.545,31.131,64.504,57.041,103.725l82.887,125.467l113.352,180.572' +
            'c4.189,6.676,11.396,10.66,19.276,10.66c7.881,0,15.087-3.984,19.276-10.66l113.319-180.521l82.919-125.518' +
            'c25.911-39.221,44.035-72.18,57.041-103.725c16.67-40.434,24.772-78.232,24.772-115.561' +
            'C594.657,217.91,563.729,143.244,507.572,87.086z" class="pin-color"/>' +
            '</svg></div>';
    }

    var panes = this.getPanes();
    panes.overlayMouseTarget.appendChild(this.div_);

    var that = this;
    google.maps.event.addDomListener(this.div_, 'click', function(event) {
        that.triggerClusterClick(event);
    });
};


/**
 * Returns the position to place the div dending on the latlng.
 *
 * @param {google.maps.LatLng} latlng The position in latlng.
 * @return {google.maps.Point} The position in pixels.
 * @private
 */
ClusterIcon.prototype.getPosFromLatLng_ = function(latlng) {
    var pos = this.getProjection().fromLatLngToDivPixel(latlng);

    if (typeof this.iconAnchor_ === 'object' && this.iconAnchor_.length === 2) {
        pos.x -= this.iconAnchor_[0];
        pos.y -= this.iconAnchor_[1];
    } else {
        pos.x -= parseInt(this.width_ / 2, 10);
        pos.y -= parseInt(this.height_ / 2, 10);
    }
    return pos;
};


/**
 * Draw the icon.
 * @ignore
 */
ClusterIcon.prototype.draw = function() {
    if (this.visible_) {
        var pos = this.getPosFromLatLng_(this.center_);
        this.div_.style.top = pos.y + 'px';
        this.div_.style.left = pos.x + 'px';
    }
};


/**
 * Hide the icon.
 */
ClusterIcon.prototype.hide = function() {
    if (this.div_) {
        this.div_.style.display = 'none';
    }
    this.visible_ = false;
};


/**
 * Position and show the icon.
 */
ClusterIcon.prototype.show = function() {
    if (this.div_) {
        var pos = this.getPosFromLatLng_(this.center_);
        this.div_.style.cssText = this.createCss(pos);
        this.div_.style.display = '';
    }
    this.visible_ = true;
};


/**
 * Remove the icon from the map
 */
ClusterIcon.prototype.remove = function() {
    this.setMap(null);
};


/**
 * Implementation of the onRemove interface.
 * @ignore
 */
ClusterIcon.prototype.onRemove = function() {
    if (this.div_ && this.div_.parentNode) {
        this.hide();
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
    }
};


/**
 * Set the sums of the icon.
 *
 * @param {Object} sums The sums containing:
 *   'text': (string) The text to display in the icon.
 *   'index': (number) The style index of the icon.
 */
ClusterIcon.prototype.setSums = function(sums) {
    this.sums_ = sums;
    this.text_ = sums.text;
    this.index_ = sums.index;
    if (this.div_) {
        this.div_.innerHTML = sums.text;
    }

    this.useStyle();
};


/**
 * Sets the icon to the the styles.
 */
ClusterIcon.prototype.useStyle = function() {
    var index = Math.max(0, this.sums_.index - 1);
    index = Math.min(this.styles_.length - 1, index);
    var style = this.styles_[index];
    this.url_ = style['url'];
    this.height_ = style['height'];
    this.width_ = style['width'];
    this.textColor_ = style['textColor'];
    this.anchor_ = style['anchor'];
    this.textSize_ = style['textSize'];
    this.backgroundPosition_ = style['backgroundPosition'];
    this.iconAnchor_ = style['iconAnchor'];
};


/**
 * Sets the center of the icon.
 *
 * @param {google.maps.LatLng} center The latlng to set as the center.
 */
ClusterIcon.prototype.setCenter = function(center) {
    this.center_ = center;
};


/**
 * Create the css text based on the position of the icon.
 *
 * @param {google.maps.Point} pos The position.
 * @return {string} The css style text.
 */
ClusterIcon.prototype.createCss = function(pos) {
    var style = [];
    style.push('background-image:url(' + this.url_ + ');');
    var backgroundPosition = this.backgroundPosition_ ? this.backgroundPosition_ : '0 0';
    style.push('background-position:' + backgroundPosition + ';');

    if (typeof this.anchor_ === 'object') {
        if (typeof this.anchor_[0] === 'number' && this.anchor_[0] > 0 &&
            this.anchor_[0] < this.height_) {
            style.push('height:' + (this.height_ - this.anchor_[0]) +
                'px; padding-top:' + this.anchor_[0] + 'px;');
        } else if (typeof this.anchor_[0] === 'number' && this.anchor_[0] < 0 &&
            -this.anchor_[0] < this.height_) {
            style.push('height:' + this.height_ + 'px; line-height:' + (this.height_ + this.anchor_[0]) +
                'px;');
        } else {
            style.push('height:' + this.height_ + 'px; line-height:' + this.height_ +
                'px;');
        }
        if (typeof this.anchor_[1] === 'number' && this.anchor_[1] > 0 &&
            this.anchor_[1] < this.width_) {
            style.push('width:' + (this.width_ - this.anchor_[1]) +
                'px; padding-left:' + this.anchor_[1] + 'px;');
        } else {
            style.push('width:' + this.width_ + 'px; text-align:center;');
        }
    } else {
        style.push('height:' + this.height_ + 'px; line-height:' +
            this.height_ + 'px; width:' + this.width_ + 'px; text-align:center;');
    }

    var txtColor = this.textColor_ ? this.textColor_ : 'black';
    var txtSize = this.textSize_ ? this.textSize_ : 11;

    style.push('cursor:pointer; top:' + pos.y + 'px; left:' +
        pos.x + 'px; color:' + txtColor + '; position:absolute; font-size:' +
        txtSize + 'px; font-family:Arial,sans-serif; font-weight:bold');
    return style.join('');
};


// Export Symbols for Closure
// If you are not going to compile with closure then you can remove the
// code below.
window['MarkerClusterer'] = MarkerClusterer;
MarkerClusterer.prototype['addMarker'] = MarkerClusterer.prototype.addMarker;
MarkerClusterer.prototype['addMarkers'] = MarkerClusterer.prototype.addMarkers;
MarkerClusterer.prototype['clearMarkers'] =
    MarkerClusterer.prototype.clearMarkers;
MarkerClusterer.prototype['fitMapToMarkers'] =
    MarkerClusterer.prototype.fitMapToMarkers;
MarkerClusterer.prototype['getCalculator'] =
    MarkerClusterer.prototype.getCalculator;
MarkerClusterer.prototype['getGridSize'] =
    MarkerClusterer.prototype.getGridSize;
MarkerClusterer.prototype['getExtendedBounds'] =
    MarkerClusterer.prototype.getExtendedBounds;
MarkerClusterer.prototype['getMap'] = MarkerClusterer.prototype.getMap;
MarkerClusterer.prototype['getMarkers'] = MarkerClusterer.prototype.getMarkers;
MarkerClusterer.prototype['getMaxZoom'] = MarkerClusterer.prototype.getMaxZoom;
MarkerClusterer.prototype['getStyles'] = MarkerClusterer.prototype.getStyles;
MarkerClusterer.prototype['getTotalClusters'] =
    MarkerClusterer.prototype.getTotalClusters;
MarkerClusterer.prototype['getTotalMarkers'] =
    MarkerClusterer.prototype.getTotalMarkers;
MarkerClusterer.prototype['redraw'] = MarkerClusterer.prototype.redraw;
MarkerClusterer.prototype['removeMarker'] =
    MarkerClusterer.prototype.removeMarker;
MarkerClusterer.prototype['removeMarkers'] =
    MarkerClusterer.prototype.removeMarkers;
MarkerClusterer.prototype['resetViewport'] =
    MarkerClusterer.prototype.resetViewport;
MarkerClusterer.prototype['repaint'] =
    MarkerClusterer.prototype.repaint;
MarkerClusterer.prototype['setCalculator'] =
    MarkerClusterer.prototype.setCalculator;
MarkerClusterer.prototype['setGridSize'] =
    MarkerClusterer.prototype.setGridSize;
MarkerClusterer.prototype['setMaxZoom'] =
    MarkerClusterer.prototype.setMaxZoom;
MarkerClusterer.prototype['onAdd'] = MarkerClusterer.prototype.onAdd;
MarkerClusterer.prototype['draw'] = MarkerClusterer.prototype.draw;

Cluster.prototype['getCenter'] = Cluster.prototype.getCenter;
Cluster.prototype['getSize'] = Cluster.prototype.getSize;
Cluster.prototype['getMarkers'] = Cluster.prototype.getMarkers;

ClusterIcon.prototype['onAdd'] = ClusterIcon.prototype.onAdd;
ClusterIcon.prototype['draw'] = ClusterIcon.prototype.draw;
ClusterIcon.prototype['onRemove'] = ClusterIcon.prototype.onRemove;
(function($) {
    "use strict";

    var realEstateReviews = {};
    qode.modules.realEstateReviews = realEstateReviews;
    realEstateReviews.qodeInitCommentRating = qodeInitCommentRating;

    $(document).ready(qodefOnDocumentReady);
    $(window).on('load', qodefOnWindowLoad);
    $(window).resize(qodefOnWindowResize);
    $(window).scroll(qodefOnWindowScroll);

    function qodefOnDocumentReady() {
        qodeInitCommentRating();
    }

    function qodefOnWindowLoad() {}

    function qodefOnWindowResize() {}

    function qodefOnWindowScroll() {}


    function qodeInitCommentRating() {
        var article = $('.qodef-property-single-holder'),
            ratingInput = article.find('#qode-rating'),
            ratingValue = ratingInput.val(),
            stars = article.find('.qode-star-rating');

        var addActive = function () {
            for (var i = 0; i < stars.length; i++) {
                var star = stars[i];
                if (i < ratingValue) {
                    $(star).addClass('active');
                } else {
                    $(star).removeClass('active');
                }
            }
        };

        addActive();

        stars.click(function () {
            ratingInput.val($(this).data('value')).trigger('change');
        });

        ratingInput.change(function () {
            ratingValue = ratingInput.val();
            addActive();
        });

    }

})(jQuery);
(function($) {
    'use strict';

    var roles = {};
    qode.modules.roles = roles;

    roles.qodefOnDocumentReady = qodefOnDocumentReady;

    $(document).ready(qodefOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefInitRegisterSelect();
    }

    function qodefInitRegisterSelect() {
        var registerForm = $('.qodef-register-content-inner');
        var select = registerForm.find('select');
        if (select.length) {
            select.each(function() {
                var thisSelect = $(this);

                thisSelect.select2({
                    minimumResultsForSearch: Infinity
                });
            });
        }
    }

})(jQuery);