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
