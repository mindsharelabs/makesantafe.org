<div class="options_group">
    <p class="form-field">
           <label><?php _e('Number of days:', 'fooevents-multiday-events'); ?></label>
           <select name="WooCommerceEventsNumDays" id="WooCommerceEventsNumDays">
                <?php for($x=1; $x<=30; $x++) :?>
                <option value="<?php echo $x; ?>" <?php echo ($WooCommerceEventsNumDays == $x)? 'SELECTED' : '' ?>><?php echo $x; ?></option>
                <?php endfor; ?>
           </select>
           <img class="help_tip" data-tip="<?php _e('The number of days the event spans. This is uses by the FooEvents Check-ins app to manage daily check-ins.', 'fooevents-multiday-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
    </p>
</div>