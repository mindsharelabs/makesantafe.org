(function($) {
    
    if ( $( "#WooCommerceEventsMetaEvent" ).length ) {

        checkEventForm();
		
        $('#WooCommerceEventsMetaEvent').change(function() {

                checkEventForm();

        })
    
        if( (typeof localObj === "object") && (localObj !== null) )
        {

            jQuery('#WooCommerceEventsMetaBoxDate').datepicker({

                showButtonPanel: true,
                closeText: localObj.closeText,
                currentText: localObj.currentText,
                monthNames: localObj.monthNames,
                monthNamesShort: localObj.monthNamesShort,
                dayNames: localObj.dayNames,
                dayNamesShort: localObj.dayNamesShort,
                dayNamesMin: localObj.dayNamesMin,
                dateFormat: localObj.dateFormat,
                firstDay: localObj.firstDay,
                isRTL: localObj.isRTL,

            });

        } else {

            jQuery('#WooCommerceEventsMetaBoxDate').datepicker();

        }
    
    }
    
    function checkEventForm() {

        var WooCommerceEventsEvent = $('#WooCommerceEventsMetaEvent').val();

        if(WooCommerceEventsEvent == 'Event') {

                jQuery('#WooCommerceEventsMetaForm').show();

        } else {

                jQuery('#WooCommerceEventsMetaForm').hide();

        }

    } 
    
})(jQuery);

