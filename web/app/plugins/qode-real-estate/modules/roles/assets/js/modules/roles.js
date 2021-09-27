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