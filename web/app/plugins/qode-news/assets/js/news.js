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
(function($) {
	"use strict";

    var reactions = {};
    qode.modules.reactions = reactions;

    reactions.qodeOnDocumentReady = qodeOnDocumentReady;

    $(document).ready(qodeOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function qodeOnDocumentReady() {
    	qodeReactions();
    }

    function qodeReactions() {
    	var reactions = $('.qode-news-reactions'),
    		postID = reactions.data('post-id');

    	if (reactions.length){
    		var reactionTerm = reactions.find('.qode-reaction');

    		reactionTerm.each(function () {
    			var thisReaction = $(this),
    				thisReactionValue = thisReaction.find('.qode-rt-value');

    			thisReaction.on('click', function (e) {
    				e.preventDefault();
    				e.stopPropagation();

    				var reactionSlug = thisReaction.data('reaction');

    				if (thisReaction.hasClass('reacted')){
    					return false;
    				}

    				var dataToPass = {
		                action: 'qode_news_reaction_update',
		                reaction_slug: reactionSlug,
		                post_ID: postID,
		            };

					$.ajax({
						type: 'POST',
						data: dataToPass,
						url: QodeAdminAjax.ajaxurl,
						success: function (data) {
							thisReaction.addClass('reacted');
							var newValue = parseInt(thisReactionValue.text()) + 1;
							thisReactionValue.text(newValue);
						}
					});
    			});
    			
    		});
	    }
    }


})(jQuery);
(function($) {
    'use strict';

    var elementorQodeNewsLayout1 = {};
    qode.modules.elementorQodeNewsLayout1 = elementorQodeNewsLayout1;

    elementorQodeNewsLayout1.qodeInitElementorQodeNewsLayout1 = qodeInitElementorQodeNewsLayout1;


    elementorQodeNewsLayout1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsLayout1();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsLayout1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_layout1.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);
(function($) {
    'use strict';

    var elementorQodeNewsLayout2 = {};
    qode.modules.elementorQodeNewsLayout2 = elementorQodeNewsLayout2;

    elementorQodeNewsLayout2.qodeInitElementorQodeNewsLayout2 = qodeInitElementorQodeNewsLayout2;


    elementorQodeNewsLayout2.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsLayout2();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsLayout2(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_layout2.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);
(function($) {
    'use strict';

    var elementorQodeNewsLayout3 = {};
    qode.modules.elementorQodeNewsLayout3 = elementorQodeNewsLayout3;

    elementorQodeNewsLayout3.qodeInitElementorQodeNewsLayout3 = qodeInitElementorQodeNewsLayout3;


    elementorQodeNewsLayout3.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsLayout3();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsLayout3(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_layout3.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);
(function($) {
    'use strict';

    var elementorQodeNewsPostCarousel1 = {};
    qode.modules.elementorQodeNewsPostCarousel1 = elementorQodeNewsPostCarousel1;

    elementorQodeNewsPostCarousel1.qodeInitElementorQodeNewsPostCarousel1 = qodeInitElementorQodeNewsPostCarousel1;


    elementorQodeNewsPostCarousel1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsPostCarousel1();
    }

    function qodeInitElementorQodeNewsPostCarousel1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_post_carousel1.default', function() {
                qodeOwlSlider();
            } );
        });
    }

})(jQuery);
(function($) {
    'use strict';

    var elementorQodeNewsSlider1 = {};
    qode.modules.elementorQodeNewsSlider1 = elementorQodeNewsSlider1;

    elementorQodeNewsSlider1.qodeInitElementorQodeNewsSlider1 = qodeInitElementorQodeNewsSlider1;


    elementorQodeNewsSlider1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsSlider1();
    }

    function qodeInitElementorQodeNewsSlider1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_post_slider1.default', function() {
                qode.modules.slider1.qodeInitslider1();
            } );
        });
    }

})(jQuery);
(function($) {
	"use strict";

    var slider1 = {};
    qode.modules.slider1 = slider1;

    slider1.qodeInitslider1 = qodeInitslider1;

    slider1.qodeOnDocumentReady = qodeOnDocumentReady;
    slider1.qodeOnWindowLoad = qodeOnWindowLoad;
    slider1.qodeOnWindowResize = qodeOnWindowResize;

    $(document).ready(qodeOnDocumentReady);
	$(window).on('load', qodeOnWindowLoad);
    $(window).resize(qodeOnWindowResize);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function qodeOnDocumentReady() {
	    qodeInitslider1();
    }

    /*
        All functions to be called on $(window).load() should be in this function
    */
    function qodeOnWindowLoad() {
    }

    /* 
        All functions to be called on $(window).resize() should be in this function
    */
    function qodeOnWindowResize() {
    }

    /**
     * Init Owl Carousel
     */
    function qodeInitslider1() {
        var sliders = $('.qode-slider1-owl');

        if (sliders.length) {
            sliders.each(function(){
                var slider = $(this),
	                slideItemsNumber = slider.children().length,
	                numberOfItems = 1,
	                loop = false,
	                autoplay = true,
	                autoplayHoverPause = false,
	                sliderSpeed = 4000,
	                sliderSpeedAnimation = 600,
	                margin = 0,
	                responsiveMargin = 0,
	                stagePadding = 0,
	                stagePaddingEnabled = false,
	                center = false,
	                autoWidth = false,
	                navigation = false,
	                pagination = true;
	            
	
	            if (slideItemsNumber <= 1) {
		            loop       = false;
		            autoplay   = false;
		            navigation = false;
		            pagination = false;
	            }
	
	            slider.owlCarousel({
		            items: numberOfItems,
		            loop: loop,
		            autoplay: autoplay,
		            autoplayHoverPause: autoplayHoverPause,
		            autoplaySpeed: sliderSpeedAnimation,
		            autoplayTimeout: sliderSpeed,
		            margin: margin,
		            stagePadding: stagePadding,
		            center: center,
		            autoWidth: autoWidth,
		            dots: pagination,
		            nav: navigation,
		            animateIn: 'fadeIn',
		            animateOut: 'fadeOut',
		            navText: [
			            '<span class="qode-prev-icon ion-ios-arrow-left"></span>',
			            '<span class="qode-next-icon ion-ios-arrow-right"></span>'
		            ],
		            onInitialize: function () {
			            slider.css('visibility', 'visible');
		            },
		            onInitialized: function (e) {
			            var paginationHolder = slider.find('.owl-dots'),
			            	pagination = paginationHolder.find('.owl-dot'),
			            	paginationPadding = slider.parents('.qode-slider1').data('content-padding');

			           	if (slider.parent().data('content-in-grid') == 'yes'){
				            paginationHolder.wrapAll('<div class="qode-slider1-nav-holder"><div class="container_inner"><div class="qode-slider-nav-holder-inner"><div class="qode-slider-nav-holder-inner2"></div></div></div></div>');
				        } else {
				            paginationHolder.wrapAll('<div class="qode-slider1-nav-holder"><div class="qode-slider-nav-holder-inner"><div class="qode-slider-nav-holder-inner2"></div></div></div>');
				        }

				        if (typeof paginationPadding !== 'undefined'){
				        	paginationHolder.parents('.qode-slider-nav-table').css({padding: paginationPadding.replace(/,/g,' ')});
				        }

			            pagination.each(function (e) {
			            	var thisPag = $(this),
			            		thisElement = slider.find('.owl-item').eq(e),
			            		thisElementDate = thisElement.find('.qode-news-item').data('date'),
			            		thisElementTitle = thisElement.find('.qode-post-title a').html(),
			            		thisElementThumb = thisElement.find('.qode-news-item').data('thumb-url');

			            	thisPag.html('<div class="qode-slider1-pag-thumb"><img alt="thumb" src="'+thisElementThumb+'" /></div><div class="qode-slider1-pag-info-holder"><h5 class="qode-slider1-pag-title">' + thisElementTitle + '</h5><div class="qode-slider1-pag-date"><i class="dripicons-alarm"></i>' + thisElementDate + '</div></div>');
			            });

			            qodeSlider1NavigationScroll(paginationHolder);
		            }
                });
            });
        }
    }

	function qodeSlider1NavigationScroll(paginationHolder){

		if(paginationHolder.length){
			paginationHolder.niceScroll({
				scrollspeed: 60,
				mousescrollstep: 40,
				cursorwidth: '2px',
				cursorborder: '0',
				cursorborderradius: 0,
				cursorcolor: "#fff",
				background: "rgba(255,255,255,0.5)",
				autohidemode: false,
				horizrailenabled: false,
				zindex: 5
			});
		}
	}

})(jQuery);
(function($) {
    'use strict';

    var elementorQodeNewsVideoLayout1 = {};
    qode.modules.elementorQodeNewsVideoLayout1 = elementorQodeNewsVideoLayout1;

    elementorQodeNewsVideoLayout1.qodeInitElementorQodeNewsVideoLayout1 = qodeInitElementorQodeNewsVideoLayout1;


    elementorQodeNewsVideoLayout1.qodeOnWindowLoad = qodeOnWindowLoad;

    $(window).on('load', qodeOnWindowLoad);
    $(window).scroll(qodeOnWindowScroll);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitElementorQodeNewsVideoLayout1();
    }

    function qodeOnWindowScroll() {
        qode.modules.news.qodeInitNewsShortcodesPagination().scroll();
    }

    function qodeInitElementorQodeNewsVideoLayout1(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_video_layout1.default', function() {
                qode.modules.news.qodeInitNewsShortcodesFilter();
                qode.modules.news.qodeNewsInitFitVids();
                qode.modules.news.qodeInitSelfHostedVideoAudioPlayer();
                qode.modules.news.qodeSelfHostedVideoSize();
                qode.modules.news.qodeInitNewsShortcodesPagination().init();
            } );
        });
    }

})(jQuery);
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
(function($) {
    'use strict';
	
	var blogCategoriesReactionsWidget = {};
	qode.modules.blogCategoriesReactionsWidget = blogCategoriesReactionsWidget;
	
	blogCategoriesReactionsWidget.qodeInitBlogCatReact = qodeInitBlogCatReact;
	
	
	blogCategoriesReactionsWidget.qodeOnDocumentReady = qodeOnDocumentReady;
	
	$(document).ready(qodeOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function qodeOnDocumentReady() {
		qodeInitBlogCatReact();
	}
	
	/**
	 * Init blog categories reactions widget shortcode
	 */
	function qodeInitBlogCatReact(){
		var blogCatReact = $('.qode-news-blog-cr-widget');
		
		if(blogCatReact.length){
			blogCatReact.each(function(){
				var thisBlogCatReact = $(this),
					thisOpener = thisBlogCatReact.find('.qode-news-bcr-opener-holder'),
					thisDropdown = thisBlogCatReact.find('.qode-news-bcr-dropdown');

				thisBlogCatReact.on('touchstart mouseenter', function () {
					thisDropdown.addClass('opened');
				});

				thisBlogCatReact.on('mouseleave', function () {
					thisDropdown.removeClass('opened');
				})
			});
		}
	}

})(jQuery);