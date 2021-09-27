(function($) {
    'use strict';

    var property = {};
    qode.modules.property = property;

    property.qodefShowHideEnquiryForm = qodefShowHideEnquiryForm;
    property.qodefSubmitEnquiryForm = qodefSubmitEnquiryForm;
    property.qodefMortgageCalculator = qodefMortgageCalculator;

    property.qodefOnDocumentReady = qodefOnDocumentReady;
    property.qodefOnWindowLoad = qodefOnWindowLoad;
    property.qodefOnWindowResize = qodefOnWindowResize;
    property.qodefOnWindowScroll = qodefOnWindowScroll;

    $(document).ready(qodefOnDocumentReady);
    $(window).on('load', qodefOnWindowLoad);
    $(window).resize(qodefOnWindowResize);
    $(window).scroll(qodefOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodefOnDocumentReady() {
        qodefShowHideEnquiryForm();
        qodefSubmitEnquiryForm();
        qodefMortgageCalculator();
        qodefDeleteProperty();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodefOnWindowLoad() {

    }

    /*
     All functions to be called on $(window).resize() should be in this function
     */
    function qodefOnWindowResize() {

    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function qodefOnWindowScroll() {

    }

    function qodefShowHideEnquiryForm(){

        var single = $('.qodef-property-single-holder'),
            enquiryHolder = $('.qodef-property-enquiry-holder'),
            button = single.find('.qodef-property-single-action'),
            buttonClose = $('.qodef-property-enquiry-close');

        button.on('click', function(e) {
            e.preventDefault();
            enquiryHolder.fadeIn(300);
            enquiryHolder.addClass('opened');
        });

        enquiryHolder.add(buttonClose).on('click', function() {
            if(enquiryHolder.hasClass('opened')){
                enquiryHolder.fadeOut(300);
                enquiryHolder.removeClass('opened');
            }
        });

        $(".qodef-property-enquiry-inner").on('click', function (e) {
            e.stopPropagation();
        });
        // on esc too
        $(window).on('keyup', function(e){
            if ( enquiryHolder.hasClass( 'opened' ) && e.keyCode == 27 ) {
                enquiryHolder.fadeOut(300);
                enquiryHolder.removeClass('opened');
            }
        });

    }

    function qodefSubmitEnquiryForm(){
        var enquiryHolder = $('.qodef-property-enquiry-holder'),
            enquiryMessageHolder = $('.qodef-property-enquiry-response'),
            enquiryForm = enquiryHolder.find('.qodef-property-enquiry-form');


        enquiryForm.on('submit', function(e){
            e.preventDefault();
            enquiryMessageHolder.empty();
            var enquiryData = {
                name: enquiryForm.find('#enquiry-name').val(),
                email: enquiryForm.find('#enquiry-email').val(),
                message: enquiryForm.find('#enquiry-message').val(),
                itemId: enquiryForm.find('#enquiry-item-id').val(),
                nonce: enquiryForm.find('#qodef_re_nonce_property_item_enquiry').val()
            };

            var requestData = {
                action: 'qodef_re_send_property_enquiry',
                data: enquiryData
            };

            $.ajax({
                type: "POST",
                url: QodeAdminAjax.ajaxurl,
                data: requestData,
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 'error'){
                        enquiryMessageHolder.html(response.message);
                        //error handler
                    }else{
                        enquiryMessageHolder.html(response.message);
                        enquiryForm.fadeOut(300);
                        setTimeout(function(){
                            enquiryHolder.remove();
                        }, 2000);
                    }
                }
            });
        });

    }

    function qodefMortgageCalculator(){
        var calculator = $('.qodef-mortgage-calculator-holder');
        if(calculator.length) {
            calculator.each(function() {
               var thisCalc = $(this);
               var calcForm = thisCalc.find('form');
                var resultHolder = thisCalc.find('.qodef-mc-result-holder');
                calcForm.on('submit', function(e) {
                    e.preventDefault();
                    var price = calcForm.find('#price').val().replace(/,/g, ''),
                        interestRate = parseFloat(calcForm.find('#interest-rate').val()),
                        termYears = parseInt(calcForm.find('#term-years').val(), 10),
                        downPayment = calcForm.find('#down-payment').val().replace(/,/g, '');

                    var amountFinanced = price - downPayment;
                    var term = termYears * 12; //12 is number of months in year
                    var monthInterest = interestRate / (12 * 100);
                    var interval = Math.pow( 1 + monthInterest, -term );
                    var mortgagePay = amountFinanced * (monthInterest / (1 - interval));
                    var annualCost = mortgagePay * 12;

                    resultHolder.find('.qodef-mc-payment-value').html((Math.round(mortgagePay * 100)) / 100 + '$');
                    resultHolder.find('.qodef-mc-amount-financed-value').html((Math.round(amountFinanced * 100)) / 100 + '$');
                    resultHolder.find('.qodef-mc-mortgage-payments-value').html((Math.round(mortgagePay * 100)) / 100 + '$');
                    resultHolder.find('.qodef-mc-annual-costs-value').html((Math.round(annualCost * 100)) / 100 + '$');

                    resultHolder.slideDown();
                });
            });
        }
    }

    function qodefDeleteProperty(){
    	var deleteButtons = $('.qodef-property-item-delete');

    	if (deleteButtons.length){
    		deleteButtons.each(function(){
    			var thisDeleteButton = $(this),
    				propertyId = thisDeleteButton.data('property-id'),
    				confirmText = thisDeleteButton.data('confirm-text'),
    				property = thisDeleteButton.parents('.qodef-re-profile-property-item');

    			thisDeleteButton.on('click', function(e){
    				e.preventDefault();

    				var confirmDelete = confirm(confirmText);

    				if (confirmDelete) {

	    				var dataForm = {
	    					'action' : 'qodef_re_delete_property',
	    					'property_id' : propertyId
	    				}

	    				$.ajax({
		                    type: 'POST',
		                    data: dataForm,
		                    url: QodeAdminAjax.ajaxurl,
		                    success: function (data) {
		                        var response;
		                        response = JSON.parse(data);

		                        if (response.status == 'success') {
		                            property.fadeOut( function(){
				                        property.remove();
				                    });	                            
		                        }
		                    }
	    				});
	    			}
    			});
    		});
    	}
    }

})(jQuery);