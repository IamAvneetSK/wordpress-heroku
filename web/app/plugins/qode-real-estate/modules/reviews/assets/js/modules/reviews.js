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