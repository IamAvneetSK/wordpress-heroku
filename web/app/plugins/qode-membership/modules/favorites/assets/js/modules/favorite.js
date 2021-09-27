(function($) {
    'use strict';

    var membershipFavorites = {};
    qodef.modules.membershipFavorites = membershipFavorites;

    membershipFavorites.qodefOnDocumentReady = qodefOnDocumentReady;

    $(document).ready(qodefOnDocumentReady);
    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefMembershipAddToWishlist();
        qodefMembershipAddToWishlistTriggerEvent();
    }

    function qodefMembershipAddToWishlist(){

        $('.qodef-membership-item-favorites').on('click',function(e) {
            e.preventDefault();
            var item = $(this),
                itemID;

            if(typeof item.data('item-id') !== 'undefined') {
                itemID = item.data('item-id');
            }

            qodefMembershipWhishlistAdding(item, itemID);

        });

    }

    function qodefMembershipWhishlistAdding(item, itemID){

        var ajaxData = {
            action: 'qode_membership_add_item_to_favorites',
            item_id : itemID
        };

        $.ajax({
            type: 'POST',
            data: ajaxData,
            url: qodefGlobalVars.vars.qodefAjaxUrl,
            success: function (data) {
                var response = JSON.parse(data);
                if(response.status === 'success'){
                    if(!item.hasClass('qodef-icon-only')) {
                        item.find('span').text(response.data.message);
                    }
                    item.find('.qodef-favorites-icon').removeClass('fa-heart fa-heart-o').addClass(response.data.icon);
                }
            }
        });

        return false;

    }

    function qodefMembershipAddToWishlistTriggerEvent() {
        $( document.body ).on( 'qode_membership_favorites_trigger', function() {
            qodefMembershipAddToWishlist();
        });
    }


})(jQuery);