<div class="options_group" id ="WooCommerceEventsMultiDayTypeHolder">
    <p class="form-field">
        <label><?php _e('Multi-day type:', 'fooevents-multiday-events'); ?></label>
        <input type="radio" name="WooCommerceEventsMultiDayType" value="sequential" <?php echo ($WooCommerceEventsMultiDayType !== 'select')? 'CHECKED' : '' ?>> Sequential days<br>
        <input type="radio" name="WooCommerceEventsMultiDayType" value="select" <?php echo ($WooCommerceEventsMultiDayType == 'select')? 'CHECKED' : '' ?>> Select days<br>
    </p>
</div>
<div class="options_group" id ="WooCommerceEventsSelectDateContainer">
    <?php if(!empty($WooCommerceEventsSelectDate)) :?>
    <?php $x = 1; ?>
    <?php foreach($WooCommerceEventsSelectDate as $eventDate) :?>
    <p class="form-field">
        <label><?php echo $dayTerm; ?> <?php echo $x; ?></label>
        <input type="text" class="WooCommerceEventsSelectDate" name="WooCommerceEventsSelectDate[]" value="<?php echo $eventDate; ?>"/>
    </p>
    <?php $x++; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
