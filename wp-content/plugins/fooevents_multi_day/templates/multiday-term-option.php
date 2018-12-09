<p class="form-field">
    <label><?php _e('Day:', 'fooevents-multiday-events'); ?></label>
    <input type="text" id="WooCommerceEventsDayOverride" name="WooCommerceEventsDayOverride" value="<?php echo $WooCommerceEventsDayOverride; ?>"/>
    <img class="help_tip" data-tip="<?php _e("Subject of ticket emails sent out. Insert {OrderNumber} to dispay order number.", 'woocommerce-events'); ?>" src="<?php echo plugins_url(); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
</p>