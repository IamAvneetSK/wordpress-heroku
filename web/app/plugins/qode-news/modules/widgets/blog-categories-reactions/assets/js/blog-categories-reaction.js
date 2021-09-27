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