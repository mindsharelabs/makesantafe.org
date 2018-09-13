jQuery(function($) {
	 jQuery('#edd_cc_fields').append('<div class="card-wrapper" style="padding-top: 20px;clear: both;"></div>');

	  jQuery('#edd_cc_fields').before('<input id="expiry-date" type="hidden">');
			jQuery('select#card_exp_month, select#card_exp_year').on('change', function () {
			    // Set the value of a hidden input field for Card
			    jQuery('#expiry-date').val(jQuery('select#card_exp_month').val() + '/' + jQuery('select#card_exp_year').val());
			    // Trigger the "change" event manually
			    var evt = document.createEvent('HTMLEvents');
			    evt.initEvent('change', false, true);
			    document.getElementById('expiry-date').dispatchEvent(evt);
			});

				$('#edd_purchase_form').card({
				   formSelectors: {
						        numberInput: '#card_number',
						        //expiryInput: ['input[name="expiry[month]"]', 'input[name="expiry[year]"]'],
						       //expiryInput: ['select.card_month', 'select.card_year'],
						        expiryInput: '#expiry-date',
						        cvcInput: '#card_cvc',
						        nameInput: '#card_name'
						    },
							formatting: false,
				            container: '.card-wrapper',

				    // all of the other options from above
				});

      })
