jQuery(document).bind('gform_post_render', function(){
	  jQuery('.card-wrapper').before('<input id="expiry-date" type="hidden">');
			jQuery('select.card_month, select.card_year').on('change', function () {
			    // Set the value of a hidden input field for Card
			    jQuery('#expiry-date').val(jQuery('select.card_month').val() + '/' + jQuery('select.card_year').val());
			    // Trigger the "change" event manually
			    var evt = document.createEvent('HTMLEvents');
			    evt.initEvent('change', false, true);
			    document.getElementById('expiry-date').dispatchEvent(evt);
			});


 new Card({
            form: document.querySelector('form'),
            formSelectors: {
		        numberInput: 'input.card-number',
		        //expiryInput: ['input[name="expiry[month]"]', 'input[name="expiry[year]"]'],
		       //expiryInput: ['select.card_month', 'select.card_year'],
		        expiryInput: '#expiry-date',
		        cvcInput: 'input.security-code',
		        nameInput: 'input.cardholder-name'
		    },
			formatting: false,
            container: '.card-wrapper'
        });
})