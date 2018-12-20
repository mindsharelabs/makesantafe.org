<div id="woocommerce_events_data" class="panel woocommerce_options_panel">
    
    <div class="options_group">
            <p class="form-field">
                   <label><?php _e('Is this product an event?:', 'woocommerce-events'); ?></label>
                   <select name="WooCommerceEventsEvent" id="WooCommerceEventsEvent">
                        <option value="NotEvent" <?php echo ($WooCommerceEventsEvent == 'NotEvent')? 'SELECTED' : '' ?>><?php _e('No', 'woocommerce-events'); ?></option>
                        <option value="Event" <?php echo ($WooCommerceEventsEvent == 'Event')? 'SELECTED' : '' ?>><?php _e('Yes', 'woocommerce-events'); ?></option>
                   </select>
                   <img class="help_tip" data-tip="<?php _e('Enable this option to add event and ticketing features.', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
            </p>
    </div>
    <div id="WooCommerceEventsForm" style="display:none;">
        <?php echo $numDays; ?>
        <?php echo $multiDayType; ?>
        <div class="options_group" id="WooCommerceEventsDateContainer">
                <p class="form-field">
                       <label><?php _e('Start Date:', 'woocommerce-events'); ?></label>
                       <input type="text" id="WooCommerceEventsDate" name="WooCommerceEventsDate" value="<?php echo $WooCommerceEventsDate; ?>"/>
                       <img class="help_tip" data-tip="<?php _e('The date that the event is scheduled to take place. This is used as a label on the frontend of the website. FooEvents Calendar uses this to display the event.', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <?php echo $endDate; ?>
        <div class="options_group">
                <p class="form-field">
                        <label><?php _e('Start time:', 'woocommerce-events'); ?></label>
                        <select name="WooCommerceEventsHour" id="WooCommerceEventsHour">
                            <?php for($x=0; $x<=23; $x++) :?>
                            <?php $x = sprintf("%02d", $x); ?>
                            <option value="<?php echo $x; ?>" <?php echo ($WooCommerceEventsHour == $x) ? 'SELECTED' : ''; ?>><?php echo $x; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsMinutes" id="WooCommerceEventsMinutes">
                            <?php for($x=0; $x<=59; $x++) :?>
                            <?php $x = sprintf("%02d", $x); ?>
                            <option value="<?php echo $x; ?>" <?php echo ($WooCommerceEventsMinutes == $x) ? 'SELECTED' : ''; ?>><?php echo $x; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsPeriod" id="WooCommerceEventsPeriod">
                            <option value="">-</option>
                            <option value="a.m." <?php echo ($WooCommerceEventsPeriod == 'a.m.') ? 'SELECTED' : ''; ?>>a.m.</option>
                            <option value="p.m." <?php echo ($WooCommerceEventsPeriod == 'p.m.') ? 'SELECTED' : ''; ?>>p.m.</option>
                        </select>
                        <img class="help_tip" data-tip="<?php _e('The time that the event is scheduled to start', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                        <label><?php _e('End time:', 'woocommerce-events'); ?></label>
                        <select name="WooCommerceEventsHourEnd" id="WooCommerceEventsHourEnd">
                            <?php for($x=0; $x<=23; $x++) :?>
                            <?php $x = sprintf("%02d", $x); ?>
                            <option value="<?php echo $x; ?>" <?php echo ($WooCommerceEventsHourEnd == $x) ? 'SELECTED' : ''; ?>><?php echo $x; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsMinutesEnd" id="WooCommerceEventsMinutesEnd">
                            <?php for($x=0; $x<=59; $x++) :?>
                            <?php $x = sprintf("%02d", $x); ?>
                            <option value="<?php echo $x; ?>" <?php echo ($WooCommerceEventsMinutesEnd == $x) ? 'SELECTED' : ''; ?>><?php echo $x; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsEndPeriod" id="WooCommerceEventsEndPeriod">
                            <option value="">-</option>
                            <option value="a.m." <?php echo ($WooCommerceEventsEndPeriod == 'a.m.') ? 'SELECTED' : ''; ?>>a.m.</option>
                            <option value="p.m." <?php echo ($WooCommerceEventsEndPeriod == 'p.m.') ? 'SELECTED' : ''; ?>>p.m.</option>
                        </select>
                        <img class="help_tip" data-tip="<?php _e('The time that the event is scheduled to end', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <?php echo $eventbrite_option; ?>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Venue:', 'woocommerce-events'); ?></label>
                       <input type="text" id="WooCommerceEventsLocation" name="WooCommerceEventsLocation" value="<?php echo $WooCommerceEventsLocation; ?>"/>
                       <img class="help_tip" data-tip="<?php _e('The venue where the event will be held', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('GPS Coordinates:', 'woocommerce-events'); ?></label>
                       <input type="text" id="WooCommerceEventsGPS" name="WooCommerceEventsGPS" value="<?php echo $WooCommerceEventsGPS; ?>"/>
                       <img class="help_tip" data-tip="<?php _e("The venue's GPS coordinates ", 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Google Map Coordinates:', 'woocommerce-events'); ?></label>
                       <input type="text" id="WooCommerceEventsGoogleMaps" name="WooCommerceEventsGoogleMaps" value="<?php echo $WooCommerceEventsGoogleMaps; ?>"/>
                       <img class="help_tip" data-tip="<?php _e('The GPS coordinates used to determine the pin position on the Google map that is displayed on the event page. A valid Google Maps API key is required under WooCommerce -> Settigns -> Events.', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                       <?php if(empty($globalWooCommerceEventsGoogleMapsAPIKey)) :?>
                       <br /><br />
                       <?php _e('Google Maps API key not set.','woocommerce-events'); ?> <a href="admin.php?page=wc-settings&tab=settings_woocommerce_events"><?php _e('Please set one in your global event options.', 'woocommerce-events'); ?></a>
                       <?php endif; ?>
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Directions:', 'woocommerce-events'); ?></label>
                       <textarea name="WooCommerceEventsDirections" id="WooCommerceEventsDirections"><?php echo $WooCommerceEventsDirections ?></textarea>
                       
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Phone:', 'woocommerce-events'); ?></label>
                       <input type="text" id="WooCommerceEventsSupportContact" name="WooCommerceEventsSupportContact" value="<?php echo $WooCommerceEventsSupportContact; ?>"/>
                       <img class="help_tip" data-tip="<?php _e("Event organizer's landline or mobile phone number", 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Email:', 'woocommerce-events'); ?></label>
                       <input type="text" id="WooCommerceEventsEmail" name="WooCommerceEventsEmail" value="<?php echo $WooCommerceEventsEmail; ?>"/>
                       <img class="help_tip" data-tip="<?php _e("Event organizer's email address", 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
            <p class="form-field">
            <label><?php _e('Ticket Theme:', 'woocommerce-events'); ?></label>
            <select name="WooCommerceEventsTicketTheme" id="WooCommerceEventsTicketTheme">
            <?php foreach($themes as $theme_name => $path) :?>
                <option value="<?php echo $path; ?>" <?php echo ($WooCommerceEventsTicketTheme == $path)? 'SELECTED' : '' ?>><?php echo $theme_name; ?></option>
            <?php endforeach; ?>
            </select>
            </p> 
        </div>
        <div class="options_group">
                <?php $WooCommerceEventsTicketLogo = (empty($WooCommerceEventsTicketLogo))? $globalWooCommerceEventsTicketLogo : $WooCommerceEventsTicketLogo; ?>
                <p class="form-field">
                        <label><?php _e('Ticket logo:', 'woocommerce-events'); ?></label>
                        <input id="WooCommerceEventsTicketLogo" class="text uploadfield" type="text" size="40" name="WooCommerceEventsTicketLogo" value="<?php echo $WooCommerceEventsTicketLogo; ?>" />				
                        <span class="uploadbox">
                                <input class="upload_image_button_woocommerce_events  button  " type="button" value="Upload file" />
                                <a href="#" class="upload_reset"><?php _e('Clear', 'woocommerce-events'); ?></a>
                        </span>
                        <img class="help_tip" data-tip="<?php _e('The logo which will be displayed on the ticket in JPG or PNG format', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
	<div class="options_group">
                <?php $WooCommerceEventsTicketHeaderImage = (empty($WooCommerceEventsTicketHeaderImage))? $globalWooCommerceEventsTicketHeaderImage : $WooCommerceEventsTicketHeaderImage; ?>
                <p class="form-field">
                        <label><?php _e('Ticket header image:', 'woocommerce-events'); ?></label>
                        <input id="WooCommerceEventsTicketHeaderImage" class="text uploadfield" type="text" size="40" name="WooCommerceEventsTicketHeaderImage" value="<?php echo $WooCommerceEventsTicketHeaderImage; ?>" />				
                        <span class="uploadbox">
                                <input class="upload_image_button_woocommerce_events  button  " type="button" value="Upload file" />
                                <a href="#" class="upload_reset"><?php _e('Clear', 'woocommerce-events'); ?></a>
                        </span>
                        <img class="help_tip" data-tip="<?php _e('The main image which will be displayed on the ticket in JPG or PNG format', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Ticket subject:', 'woocommerce-events'); ?></label>
                       <input type="text" id="WooCommerceEventsEmailSubjectSingle" name="WooCommerceEventsEmailSubjectSingle" value="<?php echo $WooCommerceEventsEmailSubjectSingle; ?>"/>
                       <img class="help_tip" data-tip="<?php _e("Subject of ticket emails sent out. Insert {OrderNumber} to dispay order number.", 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
            <div style="padding-left: 30px; padding-right: 30px;">
                <p class="form-field">
                    <label><?php _e('Ticket text:', 'woocommerce-events'); ?></label>
                    <?php wp_editor( $WooCommerceEventsTicketText, 'WooCommerceEventsTicketText' ); ?>
                </p>
            </div>
        </div>
        <div class="options_group">
            <div style="padding-left: 30px; padding-right: 30px;">
                <p class="form-field">
                    <label><?php _e('Thank you page text:', 'woocommerce-events'); ?></label>
                    <?php wp_editor( $WooCommerceEventsThankYouText, 'WooCommerceEventsThankYouText' ); ?>
                </p>
            </div>
        </div>
        <div class="options_group">
            <div style="padding-left: 30px; padding-right: 30px;">
                <p class="form-field">
                    <label><?php _e('Event details tab text:', 'woocommerce-events'); ?></label>
                    <?php wp_editor( $WooCommerceEventsEventDetailsText, 'WooCommerceEventsEventDetailsText' ); ?>
                </p>
            </div>
        </div>
        <div class="options_group">
                <?php $globalWooCommerceEventsTicketBackgroundColor = (empty($globalWooCommerceEventsTicketBackgroundColor))? '' : $globalWooCommerceEventsTicketBackgroundColor; ?>
                <?php $WooCommerceEventsTicketBackgroundColor = (empty($WooCommerceEventsTicketBackgroundColor))? $globalWooCommerceEventsTicketBackgroundColor : $WooCommerceEventsTicketBackgroundColor; ?>
                <p class="form-field">
                       <label><?php _e('Ticket border:', 'woocommerce-events'); ?></label>
                       <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsTicketBackgroundColor" value="<?php echo ''.$WooCommerceEventsTicketBackgroundColor; ?>"/>
                       <img class="help_tip" data-tip="<?php _e('The color of the ticket border', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <?php $globalWooCommerceEventsTicketButtonColor = (empty($globalWooCommerceEventsTicketButtonColor))? '' : $globalWooCommerceEventsTicketButtonColor; ?>
                <?php $WooCommerceEventsTicketButtonColor = (empty($WooCommerceEventsTicketButtonColor))? $globalWooCommerceEventsTicketButtonColor : $WooCommerceEventsTicketButtonColor; ?>
                <p class="form-field">
                       <label><?php _e('Ticket buttons:', 'woocommerce-events'); ?></label>
                       <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsTicketButtonColor" value="<?php echo ''.$WooCommerceEventsTicketButtonColor; ?>"/>
                       <img class="help_tip" data-tip="<?php _e('The color of the ticket button', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <?php $globalWooCommerceEventsTicketTextColor = (empty($globalWooCommerceEventsTicketTextColor))? '' : $globalWooCommerceEventsTicketTextColor; ?>
                <?php $WooCommerceEventsTicketTextColor = (empty($WooCommerceEventsTicketTextColor))? $globalWooCommerceEventsTicketTextColor : $WooCommerceEventsTicketTextColor; ?>
                <p class="form-field">
                       <label><?php _e('Ticket button text:', 'woocommerce-events'); ?></label>
                       <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsTicketTextColor" value="<?php echo ''.$WooCommerceEventsTicketTextColor; ?>"/>
                       <img class="help_tip" data-tip="<?php _e('The color of the ticket buttons text', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <?php echo $eventBackgroundColour; ?>
        <?php echo $eventTextColour; ?>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Include purchaser or attendee details on ticket?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsTicketPurchaserDetails" value="on" <?php echo (empty($WooCommerceEventsTicketPurchaserDetails) || $WooCommerceEventsTicketPurchaserDetails == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will display the purchaser or attendee details on the ticket', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Display "Add to calendar" on ticket?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsTicketAddCalendar" value="on" <?php echo (empty($WooCommerceEventsTicketAddCalendar) || $WooCommerceEventsTicketAddCalendar == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will display an - Add to calendar - button on the ticket. Clicking this will generate a .ics file', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Display date and time on ticket?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsTicketDisplayDateTime" value="on" <?php echo (empty($WooCommerceEventsTicketDisplayDateTime) || $WooCommerceEventsTicketDisplayDateTime == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will display the time and date of the event, on the ticket', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Display barcode on ticket?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsTicketDisplayBarcode" value="on" <?php echo (empty($WooCommerceEventsTicketDisplayBarcode) || $WooCommerceEventsTicketDisplayBarcode == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will display the barcode on the ticket', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Display price on ticket?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsTicketDisplayPrice" value="on" <?php echo ($WooCommerceEventsTicketDisplayPrice == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will display the ticket price, on the ticket', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Capture individual attendee details?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsCaptureAttendeeDetails" value="on" <?php echo ($WooCommerceEventsCaptureAttendeeDetails == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will add attendee capture fields on the checkout screen', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <?php echo $eventsIncludeCustomAttendeeFields; ?>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Email attendee rather than purchaser?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsEmailAttendee" value="on" <?php echo ($WooCommerceEventsEmailAttendee == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will email the ticket to the attendee', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Capture attendee telephone?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsCaptureAttendeeTelephone" value="on" <?php echo ($WooCommerceEventsCaptureAttendeeTelephone == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will add a telephone number field to the attendee capture fields on the checkout screen', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Capture attendee company?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsCaptureAttendeeCompany" value="on" <?php echo ($WooCommerceEventsCaptureAttendeeCompany == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will add a company field to the attendee capture fields on the checkout screen', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Capture attendee designation?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsCaptureAttendeeDesignation" value="on" <?php echo ($WooCommerceEventsCaptureAttendeeDesignation == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will add a designation field to the attendee capture fields on the checkout screen', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
                <p class="form-field">
                       <label><?php _e('Email tickets?:', 'woocommerce-events'); ?></label>
                       <input type="checkbox" name="WooCommerceEventsSendEmailTickets" value="on" <?php echo (empty($WooCommerceEventsSendEmailTickets) || $WooCommerceEventsSendEmailTickets == 'on')? 'CHECKED' : ''; ?>>
                       <img class="help_tip" data-tip="<?php _e('Selecting this will email out tickets once the order has been completed', 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                </p>
        </div>
        <div class="options_group">
            <p><b><?php _e('Override terminology', 'woocommerce-events'); ?></b></p>
            <p class="form-field">
                <label><?php _e('Attendee:', 'woocommerce-events'); ?></label>
                <input type="text" id="WooCommerceEventsAttendeeOverride" name="WooCommerceEventsAttendeeOverride" value="<?php echo $WooCommerceEventsAttendeeOverride; ?>"/>
                <img class="help_tip" data-tip="<?php _e("Subject of ticket emails sent out. Insert {OrderNumber} to dispay order number.", 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
            </p>
            <p class="form-field">
                <label><?php _e('Book ticket:', 'woocommerce-events'); ?></label>
                <input type="text" id="WooCommerceEventsTicketOverride" name="WooCommerceEventsTicketOverride" value="<?php echo $WooCommerceEventsTicketOverride; ?>"/>
                <img class="help_tip" data-tip="<?php _e("Subject of ticket emails sent out. Insert {OrderNumber} to dispay order number.", 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
            </p>
            <?php echo $multidayTerm; ?>
        </div>
        <?php if(!empty($post->ID)) :?>
        <div class="options_group">
            <p><b><?php _e('Export attendees', 'woocommerce-events'); ?></b></p>
            <div id="WooCommerceEventsExportMessage"></div>
            <p class="form-field">
                <label><?php _e('Include unpaid tickets:', 'woocommerce-events'); ?></label><input type="checkbox" id="WooCommerceEventsExportUnpaidTickets" name="WooCommerceEventsExportUnpaidTickets" value="on" <?php echo ($WooCommerceEventsExportUnpaidTickets == 'on')? 'CHECKED' : ''; ?>><br />
                <label><?php _e('Include billing details:', 'woocommerce-events'); ?></label><input type="checkbox" id="WooCommerceEventsExportBillingDetails" name="WooCommerceEventsExportBillingDetails" value="on" <?php echo ($WooCommerceEventsExportBillingDetails == 'on')? 'CHECKED' : ''; ?>><br /><br />
                <a href="<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=woocommerce_events_csv&event=<?php echo $post->ID; ?><?php echo ($WooCommerceEventsExportUnpaidTickets == 'on')? '&exportunpaidtickets=true' : ''; ?><?php echo ($WooCommerceEventsExportBillingDetails == 'on')? '&exportbillingdetails=true' : ''; ?>" class="button" target="_BLANK"><?php _e('Download CSV of attendees', 'woocommerce-events'); ?></a>
            </p>
        </div>


        <div class="options_group">
            <p><b><?php _e('Attendee badge options', 'woocommerce-events'); ?></b></p>
            <div id="WooCommerceBadgeMessage"></div>
            <p class="form-field">
                <label><?php _e('Choose a badge size:', 'woocommerce-events'); ?></label>
                <select name="WooCommerceBadgeSize" id="WooCommerceBadgeSize">
                        <option value="letter_10"<?php echo ($WooCommerceBadgeSize == 'letter_10')? 'SELECTED' : ''; ?>><?php echo "10 badges per sheet 4.025in x 2in (Avery 5163/8163 Letter size)"; ?></option>
                        <option value="a4_12" <?php echo ($WooCommerceBadgeSize == 'a4_12')? 'SELECTED' : ''; ?>><?php echo "12 badges per sheet 63.5mm x 72mm (Microsoft W233 A4 size)"; ?></option>
                        <option value="a4_16" <?php echo ($WooCommerceBadgeSize == 'a4_16')? 'SELECTED' : ''; ?>><?php echo "16 badges per sheet 99mm x 33.9mm (Microsoft W121 A4 size)"; ?></option>
                        <option value="a4_24" <?php echo ($WooCommerceBadgeSize == 'a4_24')? 'SELECTED' : ''; ?>><?php echo "24 badges per sheet 35mm x 70mm (Microsoft W110 A4 size)"; ?></option>
                        <option value="letter_30" <?php echo ($WooCommerceBadgeSize == 'letter_30')? 'SELECTED' : ''; ?>><?php echo "30 badges per sheet 2.625in x 1in (Avery 5160/8160 Letter size)"; ?></option>
                        <option value="a4_39" <?php echo ($WooCommerceBadgeSize == 'a4_39')? 'SELECTED' : ''; ?>><?php echo "39 badges per sheet 66mm x 20.60mm (Microsoft W239 A4 size)"; ?></option>
                        <option value="a4_45" <?php echo ($WooCommerceBadgeSize == 'a4_45')? 'SELECTED' : ''; ?>><?php echo "45 badges per sheet 38.5mm x 29.9mm (Microsoft W115 A4 size)"; ?></option>
                </select>
                <br /><br />
                <label><?php _e('Choose field 1:', 'woocommerce-events'); ?></label>
                <select name="WooCommerceBadgeField1" id="WooCommerceBadgeField1">
                        <option value="nothing" <?php echo ($WooCommerceBadgeField1 == 'nothing')? 'SELECTED' : ''; ?>><?php echo "(Nothing)"; ?></option>
                        <option value="barcode" <?php echo ($WooCommerceBadgeField1 == 'barcode')? 'SELECTED' : ''; ?>><?php echo "Bar code"; ?></option>
                        <option value="event" <?php echo ($WooCommerceBadgeField1 == 'event')? 'SELECTED' : ''; ?>><?php echo "Event Name Only"; ?></option>
                        <option value="event_var" <?php echo ($WooCommerceBadgeField1 == 'event_var')? 'SELECTED' : ''; ?>><?php echo "Event Name and Variations"; ?></option>
                        <option value="var_only" <?php echo ($WooCommerceBadgeField1 == 'var_only')? 'SELECTED' : ''; ?>><?php echo "Variations Only"; ?></option>
                        <option value="ticketnr" <?php echo ($WooCommerceBadgeField1 == 'ticketnr')? 'SELECTED' : ''; ?>><?php echo "Ticket Number"; ?></option>
                        <option value="name" <?php echo ($WooCommerceBadgeField1 == 'name')? 'SELECTED' : ''; ?>><?php echo "Attendee Name"; ?></option>
                        <option value="email" <?php echo ($WooCommerceBadgeField1 == 'email')? 'SELECTED' : ''; ?>><?php echo "Attendee Email"; ?></option>
                        <option value="telephone" <?php echo ($WooCommerceBadgeField1 == 'telephone')? 'SELECTED' : ''; ?>><?php echo "Attendee Telephone"; ?></option>
                        <option value="company" <?php echo ($WooCommerceBadgeField1 == 'company')? 'SELECTED' : ''; ?>><?php echo "Attendee Company"; ?></option>
                        <option value="designation" <?php echo ($WooCommerceBadgeField1 == 'designation')? 'SELECTED' : ''; ?>><?php echo "Attendee Designation"; ?></option>
                        <?php foreach( $cf_array as $key => $value) {
                            echo '<option value="' . $key . '"';
                            echo ($WooCommerceBadgeField1 == $key)? 'SELECTED' : '';
                            echo '>' . $value . '</option>';

                        } ?>

                </select>
                <br /><br />
                <label><?php _e('Choose field 2:', 'woocommerce-events'); ?></label>
                <select name="WooCommerceBadgeField2" id="WooCommerceBadgeField2">
                        <option value="nothing" <?php echo ($WooCommerceBadgeField2 == 'nothing')? 'SELECTED' : ''; ?>><?php echo "(Nothing)"; ?></option>
                        <option value="barcode" <?php echo ($WooCommerceBadgeField2 == 'barcode')? 'SELECTED' : ''; ?>><?php echo "Bar code"; ?></option>
                        <option value="event" <?php echo ($WooCommerceBadgeField2 == 'event')? 'SELECTED' : ''; ?>><?php echo "Event Name Only"; ?></option>
                        <option value="event_var" <?php echo ($WooCommerceBadgeField2 == 'event_var')? 'SELECTED' : ''; ?>><?php echo "Event Name and Variations"; ?></option>
                        <option value="var_only" <?php echo ($WooCommerceBadgeField2 == 'var_only')? 'SELECTED' : ''; ?>><?php echo "Variations Only"; ?></option>
                        <option value="ticketnr" <?php echo ($WooCommerceBadgeField2 == 'ticketnr')? 'SELECTED' : ''; ?>><?php echo "Ticket Number"; ?></option>
                        <option value="name" <?php echo ($WooCommerceBadgeField2 == 'name')? 'SELECTED' : ''; ?>><?php echo "Attendee Name"; ?></option>
                        <option value="email" <?php echo ($WooCommerceBadgeField2 == 'email')? 'SELECTED' : ''; ?>><?php echo "Attendee Email"; ?></option>
                        <option value="telephone" <?php echo ($WooCommerceBadgeField2 == 'telephone')? 'SELECTED' : ''; ?>><?php echo "Attendee Telephone"; ?></option>
                        <option value="company" <?php echo ($WooCommerceBadgeField2 == 'company')? 'SELECTED' : ''; ?>><?php echo "Attendee Company"; ?></option>
                        <option value="designation" <?php echo ($WooCommerceBadgeField2 == 'designation')? 'SELECTED' : ''; ?>><?php echo "Attendee Designation"; ?></option>
                        <?php foreach( $cf_array as $key => $value) {
                            echo '<option value="' . $key . '"';
                            echo ($WooCommerceBadgeField2 == $key)? 'SELECTED' : '';
                            echo '>' . $value . '</option>';

                        } ?>
                </select>
                <br /><br />
                <label><?php _e('Choose field 3:', 'woocommerce-events'); ?></label>
                <select name="WooCommerceBadgeField3" id="WooCommerceBadgeField3">
                        <option value="nothing" <?php echo ($WooCommerceBadgeField3 == 'nothing')? 'SELECTED' : ''; ?>><?php echo "(Nothing)"; ?></option>
                        <option value="barcode" <?php echo ($WooCommerceBadgeField3 == 'barcode')? 'SELECTED' : ''; ?>><?php echo "Bar code"; ?></option>
                        <option value="event" <?php echo ($WooCommerceBadgeField3 == 'event')? 'SELECTED' : ''; ?>><?php echo "Event Name Only"; ?></option>
                        <option value="event_var" <?php echo ($WooCommerceBadgeField3 == 'event_var')? 'SELECTED' : ''; ?>><?php echo "Event Name and Variations"; ?></option>
                        <option value="var_only" <?php echo ($WooCommerceBadgeField3 == 'var_only')? 'SELECTED' : ''; ?>><?php echo "Variations Only"; ?></option>
                        <option value="ticketnr" <?php echo ($WooCommerceBadgeField3 == 'ticketnr')? 'SELECTED' : ''; ?>><?php echo "Ticket Number"; ?></option>
                        <option value="name" <?php echo ($WooCommerceBadgeField3 == 'name')? 'SELECTED' : ''; ?>><?php echo "Attendee Name"; ?></option>
                        <option value="email" <?php echo ($WooCommerceBadgeField3 == 'email')? 'SELECTED' : ''; ?>><?php echo "Attendee Email"; ?></option>
                        <option value="telephone" <?php echo ($WooCommerceBadgeField3 == 'telephone')? 'SELECTED' : ''; ?>><?php echo "Attendee Telephone"; ?></option>
                        <option value="company" <?php echo ($WooCommerceBadgeField3 == 'company')? 'SELECTED' : ''; ?>><?php echo "Attendee Company"; ?></option>
                        <option value="designation" <?php echo ($WooCommerceBadgeField3 == 'designation')? 'SELECTED' : ''; ?>><?php echo "Attendee Designation"; ?></option>
                        <?php foreach( $cf_array as $key => $value) {
                            echo '<option value="' . $key . '"';
                            echo ($WooCommerceBadgeField3 == $key)? 'SELECTED' : '';
                            echo '>' . $value . '</option>';
                        } ?>
                </select>
                <br /><br />
                <label><?php _e('Include cut lines?:', 'woocommerce-events'); ?></label>
                <input type="checkbox" name="WooCommerceEventsCutLines" value="on" <?php echo (empty($WooCommerceEventsCutLines) || $WooCommerceEventsCutLines == 'on')? 'CHECKED' : ''; ?>>
                <br /><br />
                <?php 
                if(empty($WooCommerceBadgeSize)) $WooCommerceBadgeSize = "10";
                if(empty($WooCommerceBadgeField1)) $WooCommerceBadgeField1 = "nothing";
                if(empty($WooCommerceBadgeField2)) $WooCommerceBadgeField2 = "nothing";
                if(empty($WooCommerceBadgeField3)) $WooCommerceBadgeField3 = "nothing";
                ?>
                 <a href="<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=woocommerce_events_attendee_badges&event=<?php echo $post->ID; ?><?php echo '&badgesize=' . $WooCommerceBadgeSize; ?><?php echo '&badgefield1=' . $WooCommerceBadgeField1; ?><?php echo '&badgefield2=' . $WooCommerceBadgeField2; ?><?php echo '&badgefield3=' . $WooCommerceBadgeField3 . '&cutlines=' . $WooCommerceEventsCutLines; ?>" class="button" target="_BLANK"><?php _e('Print attendee badges', 'woocommerce-events'); ?></a>
            </p>
        </div>
        <?php endif; ?>
    </div>
</div>