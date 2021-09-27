(function ($) {
	'use strict';

	var course = {};
	qode.modules.course = course;

	course.qodeOnDocumentReady = qodeOnDocumentReady;

	$(document).ready(qodeOnDocumentReady);

	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function qodeOnDocumentReady() {
		qodeInitCommentRating();
        qodeInitNewCommentShowHide();
	}

	function qodeInitCommentRating() {
		var ratingInput = $('#qode-rating'),
			ratingValue = ratingInput.val(),
			stars = $('.qode-star-rating');

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

    function qodeInitNewCommentShowHide() {
        var articles = $('.qode-course-single-holder');

        if (articles.length) {
            articles.each(function () {
                var article = $(this),
                    panelHolderTrigger = article.find('.qode-rating-form-trigger'),
                    panelHolder = article.find('.qode-comment-form .comment-respond');

                panelHolderTrigger.on('click', function () {
                    panelHolder.slideToggle('slow');
                });
            });
        }
    }

})(jQuery);