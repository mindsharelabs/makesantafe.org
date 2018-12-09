(function($) {
    
    if ( $('input[name=WooCommerceEventsMultiDayType]').length ) {
        
        if( (typeof localObj === "object") && (localObj !== null) )
        {
        
            $('.WooCommerceEventsSelectDate').datepicker({
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
        
        }else {

            jQuery('.WooCommerceEventsSelectDate').datepicker();

        }
    
        var multiDayType = $('input[name=WooCommerceEventsMultiDayType]:checked').val();
        
        if(multiDayType == 'select') {
  
            hide_start_end_date();
            display_select_date_inputs_np();
            
        }

        if(multiDayType == 'sequential') {

            show_start_end_date();
            hide_select_date_inputs();

        }

        $('input[name=WooCommerceEventsMultiDayType]').change(function(){
            
            var multiDayType = this.value;

            if(multiDayType == 'select') {

                hide_start_end_date();
                display_select_date_inputs(localObj.dayTerm);
            }
            
            if(multiDayType == 'sequential') {
                
                show_start_end_date();
                hide_select_date_inputs();
            }
            
        });
        
        $('#WooCommerceEventsNumDays').change(function(){
            
            var multiDayType = $('input[name=WooCommerceEventsMultiDayType]:checked').val();

            if(multiDayType == 'select') {

                hide_start_end_date();
                display_select_date_inputs(localObj.dayTerm);

            }

        });
        
        
    }
    
    function hide_start_end_date() {

        $('#WooCommerceEventsEndDateContainer').hide();
        $('#WooCommerceEventsDateContainer').hide();
        
    }
    
    function show_start_end_date() {
        
        $('#WooCommerceEventsEndDateContainer').show();
        $('#WooCommerceEventsDateContainer').show();
        
    }
    
    function show_select_date_inputs() {
        
        $('#WooCommerceEventsDateContainer').hide();
        
    }
    
    function hide_select_date_inputs() {
        
        $('#WooCommerceEventsSelectDateContainer').hide();
        
    }
    
    function display_select_date_inputs_np() {
    
        $('#WooCommerceEventsSelectDateContainer').show();
        
    }
    
    function display_select_date_inputs(dayTerm) {
        
        $('#WooCommerceEventsSelectDateContainer').show();
        
        var numDays = $('#WooCommerceEventsNumDays').val();
        //alert(numDays);
        //$('#WooCommerceEventsMultiDayTypeHolder').after('<div id="space">Test</div>');
        
        var dateFields = '';
        for (var i = 1; i <= numDays; i++) {
            
            dateFields += '<p class="form-field">';
            dateFields += '<label>'+dayTerm+' '+i+'</label>';
            dateFields += '<input type="text" class="WooCommerceEventsSelectDate" name="WooCommerceEventsSelectDate[]" value=""/>';
            dateFields += '</p>';
            
        }
        
        $('#WooCommerceEventsSelectDateContainer').html(dateFields);
        
        if( (typeof localObj === "object") && (localObj !== null) )
        {
        
            $('.WooCommerceEventsSelectDate').datepicker({
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
        
        }else {

            jQuery('.WooCommerceEventsSelectDate').datepicker();

        }
        
    }
    
})(jQuery);