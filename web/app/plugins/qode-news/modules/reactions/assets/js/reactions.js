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