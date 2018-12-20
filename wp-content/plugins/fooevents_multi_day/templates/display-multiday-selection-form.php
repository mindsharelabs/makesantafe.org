<table class="form-table">
	<tbody>
            <?php for($x = 1; $x <= $WooCommerceEventsNumDays; $x++) :?>
            <tr valign="top">  
                <td>
                    <label><?php _e('Day', 'fooevents-multiday-events'); ?>: <?php echo $x; ?></label><Br />
                </td>
                <td>
                    <select name="WooCommerceEventsStatusMultidayEvent[<?php echo $x; ?>]">
                        <option value="Not Checked In" <?php echo ($WooCommerceEventsMultidayStatus[$x] == 'Not Checked In')? 'SELECTED' : ''; ?>>Not Checked In</option>
                        <option value="Checked In" <?php echo ($WooCommerceEventsMultidayStatus[$x] == 'Checked In')? 'SELECTED' : ''; ?>>Checked In</option>
                    </select>
                    <input type="hidden" value="true" name="ticket_status" />
                </td>
            </tr>
            <?php endfor; ?>
	</tbody>
</table>