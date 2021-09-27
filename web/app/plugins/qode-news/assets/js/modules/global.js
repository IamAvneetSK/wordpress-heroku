(function($) {
	"use strict";

    var news = {};
    qode.modules.news = news;

    news.qodeOnDocumentReady = qodeOnDocumentReady;
    news.qodeOnWindowLoad = qodeOnWindowLoad;
    news.qodeOnWindowResize = qodeOnWindowResize;
    news.qodeOnWindowScroll = qodeOnWindowScroll;

    news.qodeInitNewsShortcodesFilter = qodeInitNewsShortcodesFilter;
    news.qodeNewsInitFitVids = qodeNewsInitFitVids;
    news.qodeInitSelfHostedVideoAudioPlayer = qodeInitSelfHostedVideoAudioPlayer;
    news.qodeSelfHostedVideoSize = qodeSelfHostedVideoSize;
    news.qodeInitNewsShortcodesPagination = qodeInitNewsShortcodesPagination;

    $(document).ready(qodeOnDocumentReady);
    $(window).on('load', qodeOnWindowLoad);
    $(window).resize(qodeOnWindowResize);
    $(window).scroll(qodeOnWindowScroll);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function qodeOnDocumentReady() {
    	qodeInitNewsShortcodesFilter();
        qodeNewsInitFitVids();
        qodeInitSelfHostedVideoAudioPlayer();
        qodeSelfHostedVideoSize();
    }

    /* 
        All functions to be called on $(window).load() should be in this function
    */
    function qodeOnWindowLoad() {
	    qodeInitNewsShortcodesPagination().init();
    }

    /* 
        All functions to be called on $(window).resize() should be in this function
    */
    function qodeOnWindowResize() {
        qodeSelfHostedVideoSize();
    }

    /* 
        All functions to be called on $(window).scroll() should be in this function
    */
    function qodeOnWindowScroll() {
	    qodeInitNewsShortcodesPagination().scroll();
    }

	/**
	 * Init news shortcodes pagination functions
	 */
	function qodeInitNewsShortcodesPagination(){
		var holder = $('.qode-news-holder');
		
		var initStandardPagination = function(thisHolder) {
			var standardLink = thisHolder.find('.qode-news-standard-pagination li');

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

						initMainPagFunctionality(thisHolder, pagedLink);
					});
				});
			}
		};
		
		var initLoadMorePagination = function(thisHolder) {
			var loadMoreButton = thisHolder.find('.qode-news-load-more-pagination a');

			loadMoreButton.on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				initMainPagFunctionality(thisHolder);
			});
		};
		
		var initInifiteScrollPagination = function(thisHolder) {
			var newsShortcodeHeight = thisHolder.outerHeight(),
				newsShortcodeTopOffest = thisHolder.offset().top,
				newsShortcodePosition = newsShortcodeHeight + newsShortcodeTopOffest - add_for_admin_bar;
			
			if(!thisHolder.hasClass('qode-news-pag-infinite-scroll-started') && $scroll + $window_height > newsShortcodePosition) {
				initMainPagFunctionality(thisHolder);
			}
		};
		
		var initMainPagFunctionality = function(thisHolder, pagedLink) {
			var thisHolderInner = thisHolder.find('.qode-news-list-inner-holder'),
				nextPage,
				maxNumPages,
				pagRangeLimit;
			
			if (typeof thisHolder.data('max-num-pages') !== 'undefined' && thisHolder.data('max-num-pages') !== false) {
				maxNumPages = thisHolder.data('max-num-pages');
			}
			
			if(thisHolder.hasClass('qode-news-pag-standard')) {
				thisHolder.data('next-page', pagedLink);
				pagRangeLimit = thisHolder.data('pagination-numbers-amount');
			}
			
			if(thisHolder.hasClass('qode-news-pag-infinite-scroll')) {
				thisHolder.addClass('qode-news-pag-infinite-scroll-started');
			}
			
			var loadMoreDatta = qode.modules.common.getLoadMoreData(thisHolder),
				loadingItem = thisHolder.find('.qode-news-pag-loading');
			
			nextPage = loadMoreDatta.nextPage;
			
			if(nextPage <= maxNumPages){
				if(thisHolder.hasClass('qode-news-pag-standard')) {
					loadingItem.addClass('qode-showing qode-news-pag-standard-trigger');
					thisHolder.addClass('qode-news-standard-pag-animate');
				} else {
					loadingItem.addClass('qode-showing');
				}
				var ajaxData = qode.modules.common.setLoadMoreAjaxData(loadMoreDatta, 'qode_news_shortcodes_load_more');
				
				$.ajax({
					type: 'POST',
					data: ajaxData,
					url: QodeAdminAjax.ajaxurl,
					success: function (data) {
						if(!thisHolder.hasClass('qode-news-pag-standard')) {
							nextPage++;
						}
						
						thisHolder.data('next-page', nextPage);
						
						var response = $.parseJSON(data),
							responseHtml =  response.html;
						
						if(thisHolder.hasClass('qode-news-pag-standard')) {
							qodeInitStandardPaginationLinkChanges(thisHolder, maxNumPages, nextPage, pagRangeLimit);
							
							thisHolder.waitForImages(function(){
								qodeInitHtmlGalleryNewContent(thisHolder, thisHolderInner, loadingItem, responseHtml);
							});
						} else {
							thisHolder.waitForImages(function(){
								qodeInitAppendGalleryNewContent(thisHolderInner, loadingItem, responseHtml);
							});
						}
						if(thisHolder.hasClass('qode-news-pag-infinite-scroll-started')) {
							thisHolder.removeClass('qode-news-pag-infinite-scroll-started');
						}
					}
				});
			}
			
			if(nextPage === maxNumPages){
				thisHolder.find('.qode-news-load-more-pagination').hide();
			}
		};
		
		var qodeInitHtmlGalleryNewContent = function(thisHolder, thisHolderInner, loadingItem, responseHtml) {
			loadingItem.removeClass('qode-showing qode-news-pag-standard-trigger');
			thisHolder.removeClass('qode-news-standard-pag-animate');
			thisHolderInner.html(responseHtml);
			thisHolderInner.trigger('qodeNewsAfterPagination', [thisHolderInner, responseHtml]);
		};
		
		var qodeInitAppendGalleryNewContent = function(thisHolderInner, loadingItem, responseHtml) {
			loadingItem.removeClass('qode-showing');
			thisHolderInner.append(responseHtml);
			thisHolderInner.trigger('qodeNewsAfterPagination', [thisHolderInner, responseHtml]);
		};
		
		return {
			init: function() {
				if(holder.length) {
					holder.each(function() {
						var thisHolder = $(this);
						
						if(thisHolder.hasClass('qode-news-pag-standard')) {
							initStandardPagination(thisHolder);
						}
						
						if(thisHolder.hasClass('qode-news-pag-load-more')) {
							initLoadMorePagination(thisHolder);
						}
						
						if(thisHolder.hasClass('qode-news-pag-infinite-scroll')) {
							initInifiteScrollPagination(thisHolder);
						}
					});
				}
			},
			scroll: function() {
				if(holder.length) {
					holder.each(function() {
						var thisHolder = $(this);
						
						if(thisHolder.hasClass('qode-news-pag-infinite-scroll')) {
							initInifiteScrollPagination(thisHolder);
						}
					});
				}
			}
		};
	}

	function qodeInitNewsShortcodesFilter(){
		var holder = $('.qode-news-holder');

		if (holder.length){

			holder.each(function(){
				var thisHolder = $(this),
					filterHolder = thisHolder.find('.qode-news-filter');

				if (filterHolder.length){
					var filters = filterHolder.find('.qode-news-filter-item'),
						filterBy = filterHolder.data('filter-by');

					filters.first().addClass('qode-news-active-filter');

					filters.click(function(e){
						e.preventDefault();
                        e.stopPropagation();

						var thisFilter = $(this),
							filterData = thisFilter.data('filter');

						if (!thisFilter.hasClass('qode-news-active-filter')) {
							thisFilter.siblings().removeClass('qode-news-active-filter');
							thisFilter.addClass('qode-news-active-filter');

							thisHolder.addClass('qode-news-filter-activated');

							initFilterBy(thisHolder, filterBy, filterData);
						}
					});


					var initFilterBy = function(thisHolder, filterBy, filterData) {
						var thisHolderInner = thisHolder.find('.qode-news-list-inner-holder'),
							loader = thisHolder.find('.qode-news-filter-loading');

						loader.addClass('qode-news-activate');

						var loadMoreData = qode.modules.common.getLoadMoreData(thisHolder);

						switch(filterBy) {
							case 'category':
								loadMoreData.categoryName = filterData;
							break;
							case 'tag':
								loadMoreData.tag = filterData;
							break;
						}
						
						var ajaxData = qode.modules.common.setLoadMoreAjaxData(loadMoreData, 'qode_news_shortcodes_filter');
						
						$.ajax({
							type: 'POST',
							data: ajaxData,
							url: QodeAdminAjax.ajaxurl,
							success: function (data) {
								
								var response = $.parseJSON(data),
									responseHtml =  response.html,
									newQueryParams =  response.newQueryParams;

								thisHolder.data('max-num-pages',newQueryParams['max_num_pages']);
								thisHolder.data('next-page',parseInt(newQueryParams['paged']) + 1);

								switch(filterBy) {
									case 'category':
										thisHolder.data('category-name', filterData);
									break;
									case 'tag':
										thisHolder.data('tag', filterData);
									break;
								}

								if(thisHolder.data('max-num-pages') == thisHolder.data('paged')) {
									thisHolder.find('.qode-news-load-more-pagination').hide();
								} else {
									thisHolder.find('.qode-news-load-more-pagination').show();
								}

								if(thisHolder.hasClass('qode-news-pag-infinite-scroll-started')) {
									thisHolder.removeClass('qode-news-pag-infinite-scroll-started');
								}

								if (thisHolder.find('.qode-news-standard-pagination').length){
									var standardPagHolder = thisHolder.find('.qode-news-standard-pagination'),
										standardPagNumericItem = standardPagHolder.find('li.qode-news-pag-number'),
										standardPagLastPage = standardPagHolder.find('li.qode-news-pag-last-page a'),
										maxNumPages = thisHolder.data('max-num-pages'),
										pagRangeLimit = thisHolder.data('pagination-numbers-amount');

									qodeInitStandardPaginationLinkChanges(thisHolder, maxNumPages, 1, pagRangeLimit);

									if (maxNumPages == 1){
										standardPagHolder.hide();
									} else {
										standardPagHolder.show();
									}

									standardPagLastPage.data('paged',maxNumPages);

									if (maxNumPages <= pagRangeLimit){
										standardPagNumericItem.each(function(e){
											var thisItem = $(this);

											if (e >= maxNumPages){
												thisItem.hide();
											} else {
												thisItem.show();
											}
										});
									} else {
										standardPagNumericItem.show();
									}
								}
									
								thisHolder.waitForImages(function(){
									qodeInitHtmlGalleryNewContent(thisHolder, thisHolderInner, responseHtml);
									loader.removeClass('qode-news-activate');
									thisHolder.removeClass('qode-news-filter-activated');
								});
							}
						});
						
					};

					var qodeInitHtmlGalleryNewContent = function(thisHolder, thisHolderInner, responseHtml) {
						thisHolderInner.html(responseHtml);
						thisHolderInner.trigger('qodeNewsAfterPagination', [thisHolderInner, responseHtml]);
					};
				}
			});
		}

	}

	/*
	* Function for Pagination Link Changes for navigation and filter
	*/
	function qodeInitStandardPaginationLinkChanges(thisHolder, maxNumPages, nextPage, pagRangeLimit) {
		var standardPagHolder = thisHolder.find('.qode-news-standard-pagination'),
			standardPagNumericItem = standardPagHolder.find('li.qode-news-pag-number'),
			standardPagPrevItem = standardPagHolder.find('li.qode-news-pag-prev a'),
			standardPagNextItem = standardPagHolder.find('li.qode-news-pag-next a'),
			standardPagFirstItem = standardPagHolder.find('li.qode-news-pag-first-page a'),
			standardPagLastItem = standardPagHolder.find('li.qode-news-pag-last-page a'),
			i = 1,
			j = pagRangeLimit,
			middle = Math.floor(pagRangeLimit/2)+1;

		if (pagRangeLimit > maxNumPages) {
			pagRangeLimit = maxNumPages;
		}
		
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

		if(nextPage > middle) {
			standardPagFirstItem.css({'opacity': '1'});
		} else {
			standardPagFirstItem.css({'opacity': '0'});
		}

		if(nextPage < maxNumPages - middle + 1) {
			standardPagLastItem.css({'opacity': '1'});
		} else {
			standardPagLastItem.css({'opacity': '0'});
		}


		if (nextPage >= middle && nextPage <= maxNumPages - middle + 1) {
			standardPagNumericItem.eq(middle - 1).find('a').data('paged', nextPage);
			standardPagNumericItem.eq(middle - 1).find('a').html(nextPage);
			standardPagNumericItem.removeClass('qode-news-pag-active');
			standardPagNumericItem.eq(middle - 1).addClass('qode-news-pag-active');

			while (i < middle) {
			    standardPagNumericItem.eq(middle - i - 1 ).find('a').data('paged', nextPage - i);
			    standardPagNumericItem.eq(middle - i - 1 ).find('a').html(nextPage - i);
			    standardPagNumericItem.eq(middle + i - 1 ).find('a').data('paged', nextPage + i);
			    standardPagNumericItem.eq(middle + i - 1 ).find('a').html(nextPage + i);
			    i++;
			}

		} else if (nextPage < middle) {
			while (i <= pagRangeLimit) {
			    standardPagNumericItem.eq(i - 1 ).find('a').data('paged', i);
			    standardPagNumericItem.eq(i - 1 ).find('a').html(i);
			    i++;
			}

			standardPagNumericItem.removeClass('qode-news-pag-active');
			standardPagNumericItem.eq(nextPage - 1).addClass('qode-news-pag-active');

		} else {
			while (j > 0) {
			    standardPagNumericItem.eq(pagRangeLimit - j).find('a').data('paged', maxNumPages - j + 1);
			    standardPagNumericItem.eq(pagRangeLimit - j ).find('a').html(maxNumPages - j + 1);
			    j--;
			}

			standardPagNumericItem.removeClass('qode-news-pag-active');
			standardPagNumericItem.eq(pagRangeLimit - (maxNumPages - nextPage) - 1).addClass('qode-news-pag-active');
		}
			
	}

    function qodeInitSelfHostedVideoAudioPlayer() {
        var players = $('.qode-self-hosted-video, .qode-news-audio');

        if(players.length) {
            players.mediaelementplayer({
                audioWidth: '100%'
            });
        }
    }

    function qodeSelfHostedVideoSize(){
        var selfVideoHolder = $('.qode-self-hosted-video-holder .qode-video-wrap');

        if(selfVideoHolder.length) {
            selfVideoHolder.each(function(){
                var thisVideo = $(this),
                    videoWidth = thisVideo.closest('.qode-self-hosted-video-holder').outerWidth(),
                    thisVideoMejsContainer = thisVideo.find('.mejs-container'),
                    thisVideoRatio = thisVideoMejsContainer.width()/thisVideoMejsContainer.height(),
                    videoHeight = videoWidth / thisVideoRatio;

                if(navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/)){
                    thisVideo.parent().width(videoWidth);
                    thisVideo.parent().height(videoHeight);
                }

                thisVideo.addClass('qode-video-ratio-set');

                thisVideo.width(videoWidth);
                thisVideo.height(videoHeight);

                thisVideo.find('video, .mejs-overlay, .mejs-poster').width(videoWidth);
                thisVideo.find('video, .mejs-overlay, .mejs-poster').height(videoHeight);
            });
        }
    }

    function qodeNewsInitFitVids(){

        $('.qode-news-video-holder, .qode-news-video-holder').fitVids();
    }

})(jQuery);