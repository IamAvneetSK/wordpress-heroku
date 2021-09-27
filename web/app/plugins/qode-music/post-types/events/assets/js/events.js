(function($) {
	"use strict";

	var events = {};
	qode.modules.events = events;


	events.qodeOnDocumentReady = qodeOnDocumentReady;
	events.qodeOnWindowLoad = qodeOnWindowLoad;
	events.qodeOnWindowResize = qodeOnWindowResize;
	events.qodeOnWindowScroll = qodeOnWindowScroll;

	$(document).ready(qodeOnDocumentReady);
	$(window).on('load', qodeOnWindowLoad);
	$(window).resize(qodeOnWindowResize);
	$(window).scroll(qodeOnWindowScroll);

	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function qodeOnDocumentReady() {
		qodeInitEventsLoadMore();
	}

	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function qodeOnWindowLoad() {
		qodeInitElementorEventsList();
	}

	/*
	 All functions to be called on $(window).resize() should be in this function
	 */
	function qodeOnWindowResize() {

	}

	/*
	 All functions to be called on $(window).scroll() should be in this function
	 */
	function qodeOnWindowScroll() {

	}


	/**
	 * Initializes events load more function
	 */
	function qodeInitEventsLoadMore(){
		var eventsList = $('.qode-events-list-holder-outer.qode-events-load-more');

		if(eventsList.length){
			eventsList.each(function(){

				var thisEventList = $(this);
				var thisEventListInner = thisEventList.find('.qode-events-list-holder');
				var nextPage;
				var maxNumPages;
				var loadMoreButton = thisEventList.find('.qode-events-list-load-more a');
				var loadMoreButtonHolder = thisEventList.find('.qode-events-list-paging');

				if (typeof thisEventList.data('max-num-pages') !== 'undefined' && thisEventList.data('max-num-pages') !== false) {
					maxNumPages = thisEventList.data('max-num-pages');
				}

				loadMoreButton.on('click', function (e) {
					var loadMoreDatta = qodeGetEventsAjaxData(thisEventList);
					nextPage = loadMoreDatta.nextPage;
					e.preventDefault();
					e.stopPropagation();
					if(nextPage <= maxNumPages){
						loadMoreButtonHolder.find('.qode-events-list-load-more').stop().animate({opacity:0}, 200, 'easeInOutQuint',
							function(){
								loadMoreButtonHolder.find('.qode-stripes').stop().animate({opacity:1},200, 'easeInOutQuint');
							});
						var ajaxData = qodeSetEventsAjaxData(loadMoreDatta);
						$.ajax({
							type: 'POST',
							data: ajaxData,
							url: QodeAdminAjax.ajaxurl,
							success: function (data) {
								nextPage++;
								thisEventList.data('next-page', nextPage);
								var response = $.parseJSON(data);
								var responseHtml = response.html;
								thisEventList.waitForImages(function(){
									thisEventListInner.append(responseHtml);
									loadMoreButtonHolder.find('.qode-stripes').stop().animate({opacity:0}, 200, 'easeInOutQuint',
										function(){
											loadMoreButtonHolder.find('.qode-events-list-load-more').stop().animate({opacity:1},200, 'easeInOutQuint');
											if(nextPage > maxNumPages){
												loadMoreButtonHolder.find('.qode-stripes').remove();
												loadMoreButtonHolder.fadeOut(200, 'easeInOutQuint').remove();
											}
										});
								});
							}
						});
					} else {
						loadMoreButtonHolder.hide();
					}
				});

			});
		}
	}

	/**
	 * Initializes events load more data params
	 * @param events list container with defined data params
	 * return array
	 */
	function qodeGetEventsAjaxData(container){
		var returnValue = {};

		returnValue.orderBy = '';
		returnValue.order = '';
		returnValue.number = '';
		returnValue.showLoadMore = '';
		returnValue.nextPage = '';
		returnValue.maxNumPages = '';
		returnValue.titleTag = '';
		returnValue.buttonShape = '';
		returnValue.textColor = '';
		returnValue.buttonSkin = '';
		returnValue.borderColor = '';

		if (typeof container.data('order-by') !== 'undefined' && container.data('order-by') !== false) {
			returnValue.orderBy = container.data('order-by');
		}
		if (typeof container.data('order') !== 'undefined' && container.data('order') !== false) {
			returnValue.order = container.data('order');
		}
		if (typeof container.data('number') !== 'undefined' && container.data('number') !== false) {
			returnValue.number = container.data('number');
		}
		if (typeof container.data('show-load-more') !== 'undefined' && container.data('show-load-more') !== false) {
			returnValue.showLoadMore = container.data('show-load-more');
		}
		if (typeof container.data('next-page') !== 'undefined' && container.data('next-page') !== false) {
			returnValue.nextPage = container.data('next-page');
		}
		if (typeof container.data('max-num-pages') !== 'undefined' && container.data('max-num-pages') !== false) {
			returnValue.maxNumPages = container.data('max-num-pages');
		}
		if (typeof container.data('title-tag') !== 'undefined' && container.data('title-tag') !== false) {
			returnValue.titleTag = container.data('title-tag');
		}
		if (typeof container.data('button-shape') !== 'undefined' && container.data('button-shape') !== false) {
			returnValue.buttonShape = container.data('button-shape');
		}
		if (typeof container.data('button-skin') !== 'undefined' && container.data('button-skin') !== false) {
			returnValue.buttonSkin = container.data('button-skin');
		}
		if (typeof container.data('text-color') !== 'undefined' && container.data('text-color') !== false) {
			returnValue.textColor = container.data('text-color');
		}
		if (typeof container.data('border-color') !== 'undefined' && container.data('border-color') !== false) {
			returnValue.borderColor = container.data('border-color');
		}

		return returnValue;
	}


	/**
	 * Sets events load more data params for ajax function
	 * @param events list container with defined data params
	 * return array
	 */
	function qodeSetEventsAjaxData(container){
		var returnValue = {
			action: 'qode_core_events_ajax_load_more',
			orderBy: container.orderBy,
			order: container.order,
			number: container.number,
			showLoadMore: container.showLoadMore,
			nextPage: container.nextPage,
			titleTag: container.titleTag,
			buttonShape: container.buttonShape,
			buttonSkin: container.buttonSkin,
			textColor: container.textColor,
			borderColor: container.borderColor
		};

		return returnValue;

	}
	
	function qodeInitElementorEventsList(){
		$j(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_events_list.default', function() {
				qodeInitEventsLoadMore();
			} );
		});
	}
	
})(jQuery);