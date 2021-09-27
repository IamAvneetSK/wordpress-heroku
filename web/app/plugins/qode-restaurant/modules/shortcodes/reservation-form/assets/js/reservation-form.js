(function($) {
    'use strict';

    $(document).ready(function() {
        qodeRestaurantDatePicker();
    });

    $(document).on( "qodeAjaxPageLoad",function(){
        qodeRestaurantDatePicker();
    });

    function qodeRestaurantDatePicker() {
        var datepicker = $('.qode-ot-date');

        if(datepicker.length) {
            datepicker.each(function() {
                $(this).datepicker({
                    prevText: '<span class="arrow_carrot-left"></span>',
                    nextText: '<span class="arrow_carrot-right"></span>'
                });
            });
        }
    };

})(jQuery)