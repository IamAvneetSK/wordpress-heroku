(function($) {
    'use strict';

    var course = {};
    qode.modules.course = course;

	course.qodeOnDocumentReady = qodeOnDocumentReady;
	course.qodeOnWindowLoad = qodeOnWindowLoad;
	course.qodeOnWindowResize = qodeOnWindowResize;
	course.qodeOnWindowScroll = qodeOnWindowScroll;

    $(document).ready(qodeOnDocumentReady);
    $(window).on('load', qodeOnWindowLoad);
    $(window).resize(qodeOnWindowResize);
    $(window).scroll(qodeOnWindowScroll);
    
    /* 
     All functions to be called on $(document).ready() should be in this function
     */
    function qodeOnDocumentReady() {
	    qodeInitCoursePopup();
	    qodeInitCoursePopupClose();
	    qodeCompleteItem();
	    qodeCourseAddToWishlist();
	    qodeRetakeCourse();
	    qodeSearchCourses();
	    qodeInitCourseList();
	    qodeInitAdvancedCourseSearch();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {
        qodeInitCourseListAnimation();
        qodeInitCoursePagination().init();
        qodeInitElementorCourseList();
        qodeInitElementorCourseSearch();
        qodeInitElementorCourseSlider();
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
        qodeInitCoursePagination().scroll();
    }


    function qodeInitCoursePopup(){
	    var elements = $('.qode-element-link-open');
	    var popup = $('.qode-course-popup');
	    var popupContent = $('.qode-popup-content');

        if(elements.length){
	        elements.each(function(){
				var element = $(this);
		        element.on('click', function(e){
			        e.preventDefault();
			        e.stopImmediatePropagation();
			        if(!popup.hasClass('qode-course-popup-opened')){
				        popup.addClass('qode-course-popup-opened');
				        //qode.modules.common.qodeDisableScroll();

			        }
			        var courseId = 0;
			        if(typeof element.data('course-id') !== 'undefined' && element.data('course-id') !== false) {
				        courseId = element.data('course-id');
			        }
                    qodePopupScroll();
			        qodeLoadElementItem(element.data('item-id'),courseId, popupContent);
		        });
	        });
        }
    }
	function qodeInitCourseItemsNavigation(){
		var elements = $('.qode-course-popup-navigation .qode-element-link-open');
		var popupContent = $('.qode-popup-content');

		if(elements.length){
			elements.each(function(){
				var element = $(this);
				element.on('click', function(e){
					e.preventDefault();
					var courseId = 0;
					if(typeof element.data('course-id') !== 'undefined' && element.data('course-id') !== false) {
						courseId = element.data('course-id');
					}
					qodeLoadElementItem(element.data('item-id'),courseId, popupContent);
				});
			});
		}
	}

	function qodeInitCoursePopupClose(){
		var closeButton = $('.qode-course-popup-close');
		var popup = $('.qode-course-popup');
		if(closeButton.length){
			closeButton.on('click', function(e){
				e.preventDefault();
				popup.removeClass('qode-course-popup-opened');
				location.reload();
			});
		}
	}

	function qodeLoadElementItem(id ,courseId, container){
        var preloader = container.prevAll('.qode-course-item-preloader');
        preloader.removeClass('qode-hide');
		var ajaxData = {
			action: 'qode_lms_load_element_item',
			item_id : id,
			course_id : courseId
		};
		$.ajax({
			type: 'POST',
			data: ajaxData,
			url: QodeAdminAjax.ajaxurl,
			success: function (data) {
				var response = JSON.parse(data);
				if(response.status == 'success'){
					container.html(response.data.html);
					qodeInitCourseItemsNavigation();
					qodeCompleteItem();
					qodeSearchCourses();
                    qodeLessonFluidVideo();
                    qode.modules.quiz.qodeStartQuiz();
                    preloader.addClass('qode-hide');
				} else {
                    alert("An error occurred");
                    preloader.addClass('qode-hide');
                }

			}
		});

	}

	function qodeCompleteItem(){

		$('.qode-lms-complete-item-form').on('submit',function(e) {

			e.preventDefault();
			var form = $(this);
			var itemID = $(this).find( "input[name$='qode_lms_item_id']").val();
			var formData = form.serialize();
			var ajaxData = {
				action: 'qode_lms_complete_item',
				post: formData
			};

			$.ajax({
				type: 'POST',
				data: ajaxData,
				url: QodeAdminAjax.ajaxurl,
				success: function (data) {
					var response = JSON.parse(data);
					if(response.status == 'success'){

						form.replaceWith(response.data['content_message']);
						var elements =  $('.qode-section-element.qode-section-lesson');
						elements.each(function () {
							if($(this).data('section-element-id') == itemID){
								$(this).addClass('qode-item-completed')
							}
						})
					}
				}
			});
		});

	}

	function qodeRetakeCourse(){

		$('.qode-lms-retake-course-form').on('submit',function(e) {

			e.preventDefault();
			var form = $(this);
			var formData = form.serialize();
			var ajaxData = {
				action: 'qode_lms_retake_course',
				post: formData
			};

			$.ajax({
				type: 'POST',
				data: ajaxData,
				url: QodeAdminAjax.ajaxurl,
				success: function (data) {
					var response = JSON.parse(data);
					if(response.status == 'success'){
						alert(response.message);
                        location.reload();
					}
				}
			});
		});

	}

	function qodePopupScroll(){

        var mainHolder = $('.qode-course-popup');

        /* Content items */
        var content = $('.qode-popup-content');
        var contentHolder = $('.qode-course-popup-inner');
        var contentHeading = $('.qode-popup-heading');

        /* Navigation items */
        var navigationHolder = $('.qode-course-popup-items');
        var navigationWrapper = $('.qode-popup-info-wrapper');
        var searchHolder = $('.qode-lms-search-holder');

        if(qode.windowWidth > 1024) {
            if (content.length) {
                content.height(mainHolder.height() - contentHeading.outerHeight());
                content.niceScroll({
                    scrollspeed: 60,
                    mousescrollstep: 40,
                    cursorwidth: 0,
                    cursorborder: 0,
                    cursorborderradius: 0,
                    cursorcolor: 'transparent',
                    autohidemode: false,
                    horizrailenabled: false
                });
            }

            if (navigationHolder.length) {
                navigationHolder.height(mainHolder.height() - parseInt(navigationWrapper.css('padding-top')) - parseInt(navigationWrapper.css('padding-bottom')) - searchHolder.outerHeight(true));
                navigationHolder.niceScroll({
                    scrollspeed: 60,
                    mousescrollstep: 40,
                    cursorwidth: 0,
                    cursorborder: 0,
                    cursorborderradius: 0,
                    cursorcolor: 'transparent',
                    autohidemode: false,
                    horizrailenabled: false
                });
            }
        } else {
            contentHolder.find('.qode-grid-row').height(mainHolder.height());
            contentHolder.find('.qode-grid-row').niceScroll({
                scrollspeed: 60,
                mousescrollstep: 40,
                cursorwidth: 0,
                cursorborder: 0,
                cursorborderradius: 0,
                cursorcolor: 'transparent',
                autohidemode: false,
                horizrailenabled: false
            });
        }

		return true

	}

	function qodeCourseAddToWishlist(){

		$('.qode-course-whishlist').on('click',function(e) {
			e.preventDefault();
			var course = $(this),
				courseId;

			if(typeof course.data('course-id') !== 'undefined') {
				courseId = course.data('course-id');
			}

            qodeCourseWhishlistAdding(course, courseId);

		});

	}

	function qodeCourseWhishlistAdding(course, courseId){

		var ajaxData = {
			action: 'qode_lms_add_course_to_wishlist',
			course_id : courseId
		};

		$.ajax({
			type: 'POST',
			data: ajaxData,
			url: QodeAdminAjax.ajaxurl,
			success: function (data) {
				var response = JSON.parse(data);
				if(response.status == 'success'){
                    if(!course.hasClass('qode-icon-only')) {
                        course.find('span').text(response.data.message);
                    }
                    course.find('i').removeClass('fa-heart fa-heart-o').addClass(response.data.icon);
				}
			}
		});

		return false;

	}

	function qodeSearchCourses(){

	    var courseSearchHolder = $('.qode-lms-search-holder');

        if (courseSearchHolder.length) {
            courseSearchHolder.each(function () {
                var thisSearch = $(this),
                    searchField = thisSearch.find('.qode-lms-search-field'),
                    resultsHolder = thisSearch.find('.qode-lms-search-results'),
                    searchLoading = thisSearch.find('.qode-search-loading'),
                    searchIcon = thisSearch.find('.qode-search-icon');

                searchLoading.addClass('qode-hidden');

                var keyPressTimeout;

                searchField.on('keyup paste', function(e) {
                    var field = $(this);
                    field.attr('autocomplete','off');
                    searchLoading.removeClass('qode-hidden');
                    searchIcon.addClass('qode-hidden');
                    clearTimeout(keyPressTimeout);

                    keyPressTimeout = setTimeout( function() {
                        var searchTerm = field.val();
                        if(searchTerm.length < 3) {
                            resultsHolder.html('');
                            resultsHolder.fadeOut();
                            searchLoading.addClass('qode-hidden');
                            searchIcon.removeClass('qode-hidden');
                        } else {
                            var ajaxData = {
                                action: 'qode_lms_search_courses',
                                term: searchTerm
                            };

                            $.ajax({
                                type: 'POST',
                                data: ajaxData,
                                url: QodeAdminAjax.ajaxurl,
                                success: function (data) {
                                    var response = JSON.parse(data);
                                    if (response.status == 'success') {
                                        searchLoading.addClass('qode-hidden');
                                        searchIcon.removeClass('qode-hidden');
                                        resultsHolder.html(response.data.html);
                                        resultsHolder.fadeIn();
                                    }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    console.log("Status: " + textStatus);
                                    console.log("Error: " + errorThrown);
                                    searchLoading.addClass('qode-hidden');
                                    searchIcon.removeClass('qode-hidden');
                                    resultsHolder.fadeOut();
                                }
                            });
                        }
                    }, 500);
                });

                searchField.on('focusout', function () {
                    searchLoading.addClass('qode-hidden');
                    searchIcon.removeClass('qode-hidden');
                    resultsHolder.fadeOut();
                });
            });
        }

	}

    /**
     * Initializes course pagination functions
     */
    function qodeInitCoursePagination(){
        var courseList = $('.qode-course-list-holder');

        var initStandardPagination = function(thisCourseList) {
            var standardLink = thisCourseList.find('.qode-cl-standard-pagination li');

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

                        initMainPagFunctionality(thisCourseList, pagedLink);
                    });
                });
            }
        };

        var initLoadMorePagination = function(thisCourseList) {
            var loadMoreButton = thisCourseList.find('.qode-cl-load-more a');

            loadMoreButton.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                initMainPagFunctionality(thisCourseList);
            });
        };

        var initInifiteScrollPagination = function(thisCourseList) {
            var courseListHeight = thisCourseList.outerHeight(),
                courseListTopOffest = thisCourseList.offset().top,
                courseListPosition = courseListHeight + courseListTopOffest - add_for_admin_bar;

            if(!thisCourseList.hasClass('qode-cl-infinite-scroll-started') && $scroll + $window_height > courseListPosition) {
                initMainPagFunctionality(thisCourseList);
            }
        };

        var initMainPagFunctionality = function(thisCourseList, pagedLink) {
            var thisCourseListInner = thisCourseList.find('.qode-cl-inner'),
                nextPage,
                maxNumPages;

            if (typeof thisCourseList.data('max-num-pages') !== 'undefined' && thisCourseList.data('max-num-pages') !== false) {
                maxNumPages = thisCourseList.data('max-num-pages');
            }

            if(thisCourseList.hasClass('qode-cl-pag-standard')) {
                thisCourseList.data('next-page', pagedLink);
            }

            if(thisCourseList.hasClass('qode-cl-pag-infinite-scroll')) {
                thisCourseList.addClass('qode-cl-infinite-scroll-started');
            }

            var loadMoreData = qode.modules.common.getLoadMoreData(thisCourseList),
                loadingItem = thisCourseList.find('.qode-cl-loading');

            nextPage = loadMoreData.nextPage;

            if(nextPage <= maxNumPages || maxNumPages == 0){
                if(thisCourseList.hasClass('qode-cl-pag-standard')) {
                    loadingItem.addClass('qode-showing qode-standard-pag-trigger');
                    thisCourseList.addClass('qode-cl-pag-standard-animate');
                } else {
                    loadingItem.addClass('qode-showing');
                }

                var ajaxData = qode.modules.common.setLoadMoreAjaxData(loadMoreData, 'qode_lms_course_ajax_load_more');

                $.ajax({
                    type: 'POST',
                    data: ajaxData,
                    url: QodeAdminAjax.ajaxurl,
                    success: function (data) {
                        if(!thisCourseList.hasClass('qode-cl-pag-standard')) {
                            nextPage++;
                        }

                        thisCourseList.data('next-page', nextPage);

                        var response = $.parseJSON(data),
                            responseHtml =  response.html,
                            minValue = response.minValue,
                            maxValue = response.maxValue;

                        if(thisCourseList.hasClass('qode-cl-pag-standard') || pagedLink == 1) {
                            qodeInitStandardPaginationLinkChanges(thisCourseList, maxNumPages, nextPage);
                            qodeInitHtmlGalleryNewContent(thisCourseList, thisCourseListInner, loadingItem, responseHtml);
                            qodeInitPostsCounterChanges(thisCourseList, minValue, maxValue);
                        } else {
                            qodeInitAppendGalleryNewContent(thisCourseListInner, loadingItem, responseHtml);
                            qodeInitPostsCounterChanges(thisCourseList, 1, maxValue);
                        }

                        if(thisCourseList.hasClass('qode-cl-infinite-scroll-started')) {
                            thisCourseList.removeClass('qode-cl-infinite-scroll-started');
                        }
                    }
                });
            }

            if(pagedLink == 1) {
                thisCourseList.find('.qode-cl-load-more-holder').show();
            }

            if(nextPage === maxNumPages){
                thisCourseList.find('.qode-cl-load-more-holder').hide();
            }
        };

        var qodeInitStandardPaginationLinkChanges = function(thisCourseList, maxNumPages, nextPage) {
            var standardPagHolder = thisCourseList.find('.qode-cl-standard-pagination'),
                standardPagNumericItem = standardPagHolder.find('li.qode-cl-pag-number'),
                standardPagPrevItem = standardPagHolder.find('li.qode-cl-pag-prev a'),
                standardPagNextItem = standardPagHolder.find('li.qode-cl-pag-next a');

            standardPagNumericItem.removeClass('qode-cl-pag-active');
            standardPagNumericItem.eq(nextPage-1).addClass('qode-cl-pag-active');

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

        var qodeInitPostsCounterChanges = function(thisCourseList, minValue, maxValue) {
            var postsCounterHolder = thisCourseList.find('.qode-course-items-counter');
            var minValueHolder = postsCounterHolder.find('.counter-min-value');
            var maxValueHolder = postsCounterHolder.find('.counter-max-value');
            minValueHolder.text(minValue);
            maxValueHolder.text(maxValue);
        };

        var qodeInitHtmlGalleryNewContent = function(thisCourseList, thisCourseListInner, loadingItem, responseHtml) {
            loadingItem.removeClass('qode-showing qode-standard-pag-trigger');
            thisCourseListInner.waitForImages(function() {
                thisCourseList.removeClass('qode-cl-pag-standard-animate');
                thisCourseListInner.html(responseHtml);
                qodeInitCourseListAnimation();
                //qode.modules.common.qodeInitParallax();
            });
        };

        var qodeInitAppendGalleryNewContent = function(thisCourseListInner, loadingItem, responseHtml) {
            loadingItem.removeClass('qode-showing');
            thisCourseListInner.waitForImages(function() {
                thisCourseListInner.append(responseHtml);
                qodeInitCourseListAnimation();
                //qode.modules.common.qodeInitParallax();
            });
        };

        return {
            init: function() {
                if(courseList.length) {
                    courseList.each(function() {
                        var thisCourseList = $(this);

                        if(thisCourseList.hasClass('qode-cl-pag-standard')) {
                            initStandardPagination(thisCourseList);
                        }

                        if(thisCourseList.hasClass('qode-cl-pag-load-more')) {
                            initLoadMorePagination(thisCourseList);
                        }

                        if(thisCourseList.hasClass('qode-cl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisCourseList);
                        }
                    });
                }
            },
            scroll: function() {
                if(courseList.length) {
                    courseList.each(function() {
                        var thisCourseList = $(this);

                        if(thisCourseList.hasClass('qode-cl-pag-infinite-scroll')) {
                            initInifiteScrollPagination(thisCourseList);
                        }
                    });
                }
            },
            getMainPagFunction: function(thisCourseList, paged) {
                initMainPagFunctionality(thisCourseList, paged);
            }
        };
    }

    /**
     * Initializes portfolio list article animation
     */
    function qodeInitCourseListAnimation(){
        var courseList = $('.qode-course-list-holder.qode-cl-has-animation');

        if(courseList.length){
            courseList.each(function(){
                var thisCourseList = $(this).children('.qode-cl-inner');

                thisCourseList.children('article').each(function(l) {
                    var thisArticle = $(this);

                    thisArticle.appear(function() {
                        thisArticle.addClass('qode-item-show');

                        setTimeout(function(){
                            thisArticle.addClass('qode-item-shown');
                        }, 1000);
                    },{accX: 0, accY: 0});
                });
            });
        }
    }

    function qodeInitCourseList() {
        var courseLists = $('.qode-course-list-holder');
        if (courseLists.length) {
            courseLists.each(function () {
                var thisList = $(this);
                if (thisList.hasClass('qode-cl-has-filter')) {
                    qodeInitCourseLayoutChange(thisList);
                    qodeInitCourseLayoutOrdering(thisList);
                }
            })
        }
    }

    function qodeInitCourseLayoutOrdering(thisList) {
        var filter = thisList.find('.qode-cl-filter-holder .qode-course-order-filter');
        filter.select2({
            minimumResultsForSearch: -1
        }).on('select2:select', function (evt) {
            var dataAtts = evt.params.data.element.dataset;
            var type = dataAtts.type;
            var order = dataAtts.order;
            thisList.data('orderby', type);
            thisList.data('order', order);
            thisList.data('next-page', 1);
            qodeInitCoursePagination().getMainPagFunction(thisList, 1);
        });
    }

    function qodeInitCourseLayoutChange(thisList) {
        var filter = thisList.find('.qode-cl-filter-holder .qode-course-layout-filter');
        var filterElements = filter.find('span');
        if (filter.length > 0) {
            filterElements.click(function() {
                filterElements.removeClass('qode-active');
                var thisFilter = $(this);
                thisFilter.addClass('qode-active');
                var type = thisFilter.data('type');
                thisList.removeClass('qode-cl-gallery qode-cl-simple');
                thisList.addClass('qode-cl-' + type);
            });
        }
    }

    function qodeInitAdvancedCourseSearch() {
        var advancedCoursSearches = $('.qode-advanced-course-search');
        if (advancedCoursSearches.length) {
            advancedCoursSearches.each(function () {
                var thisSearch = $(this);
                var select = thisSearch.find('select');
                if(select.length) {
                    select.select2({
                        minimumResultsForSearch: -1
                    });
                }
            })
        }
    }

    function qodeLessonFluidVideo() {
        fluidvids.init({
            selector: ['.qode-course-popup .qode-lms-lesson-media iframe'],
            players: ['www.youtube.com', 'player.vimeo.com']
        });
    }

    //Elementor reinitialization
    function qodeInitElementorCourseList(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_course_list.default', function() {
                qodeInitCourseList();
                qodeInitCourseListAnimation();
            } );
        });
    }

    function qodeInitElementorCourseSearch(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_course_search.default', function() {
                qodeInitAdvancedCourseSearch();
            } );
        });
    }

    function qodeInitElementorCourseSlider(){
        $j(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/bridge_course_slider.default', function() {
                qodeOwlSlider();
            } );
        });
    }

})(jQuery);