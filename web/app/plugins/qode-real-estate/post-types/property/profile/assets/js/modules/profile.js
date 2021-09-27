(function ($) {
    'use strict';

    var propertyProfile = {};
    qode.modules.propertyProfile = propertyProfile;

    propertyProfile.qodefOnDocumentReady = qodefOnDocumentReady;

    $(document).ready(qodefOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefInitSavedSearchesRemove();
	    qodefInitSelect2();
    }

    function qodefInitSavedSearchesRemove() {
        var searchesTab = $('.qodef-re-profile-searches-holder');
        if(searchesTab.length) {
            var removeQueryButton = searchesTab.find('.qodef-undo-query-save');
            removeQueryButton.on('click', function () {
                if(!confirm('Are you sure you want to remove this search?')) {
                    return;
                }

                var thisButton = $(this);
                thisButton.html('<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>');

                var ajaxData = {
                    action: 'qodef_re_property_ajax_remove_query',
                    query_id: thisButton.data('query-id')
                };

                $.ajax({
                    type: 'POST',
                    data: ajaxData,
                    url: QodeAdminAjax.ajaxurl,
                    success: function (data) {
                        var response;
                        response = JSON.parse(data);
                        if(response.status == 'success') {
                            thisButton.closest('tr').remove();
                        } else if(response.status == 'error') {
                            thisButton.html('<i class="fa fa-times" aria-hidden="true"></i>');
                        }
                    }
                });
            });
        }
    }
    
    /*
     ** Init select2 script for select html dropdowns
     */
	function qodefInitSelect2() {
		var selectDropdown = $('.qodef-add-property-page .qodef-dashboard-item select, .qodef-edit-property-page .qodef-dashboard-item select');
		if (selectDropdown.length) {
		    selectDropdown.each(function() {
		       var thisDropdown = $(this);
			    thisDropdown.select2({
				    minimumResultsForSearch: Infinity
			    });
            });
		}
	}

})(jQuery);