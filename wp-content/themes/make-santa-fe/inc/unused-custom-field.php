<?php

/**
 * Display phone number field at checkout
 * Add more here if you need to
 */
function makesantafe_edd_display_checkout_fields() {

	// get user's phone number if they already have one stored
	if ( is_user_logged_in() ) {
		$user_id = get_current_user_id();
		$phone = get_the_author_meta( '_edd_user_phone', $user_id );
	}

	$phone = isset( $phone ) ? esc_attr( $phone ) : '';
?>
    <p id="edd-phone-wrap">
        <label class="edd-label" for="edd-phone">
        	<?php echo 'Contact Number'; ?>
        </label>
        <span class="edd-description">
        	<?php echo 'We will use this to let you know if there are any complications'; ?>
        </span>
        <input class="edd-input" type="text" name="edd_phone" id="edd-phone" placeholder="<?php echo 'Contact Number'; ?>" value="<?php echo $phone; ?>" />
    </p>
    <?php
}
add_action( 'edd_purchase_form_user_info', 'makesantafe_edd_display_checkout_fields' );

/**
 * Make phone number required
 * Add more required fields here if you need to
 */
function makesantafe_edd_required_checkout_fields( $required_fields ) {
	$required_fields = array(
		'edd_phone' => array(
			'error_id' => 'invalid_phone',
			'error_message' => 'Please enter a valid Phone number'
		),
	);

	return $required_fields;
}
add_filter( 'edd_purchase_form_required_fields', 'makesantafe_edd_required_checkout_fields' );

/**
 * Set error if phone number field is empty
 * You can do additional error checking here if required
 */
function makesantafe_edd_validate_checkout_fields( $valid_data, $data ) {
    if ( empty( $data['edd_phone'] ) ) {
        edd_set_error( 'invalid_phone', 'Please enter your phone number.' );
    }
}
add_action( 'edd_checkout_error_checks', 'makesantafe_edd_validate_checkout_fields', 10, 2 );

/**
 * Store the custom field data into EDD's payment meta
 */
function makesantafe_edd_store_custom_fields( $payment_meta ) {
    $payment_meta['phone'] = isset( $_POST['edd_phone'] ) ? sanitize_text_field( $_POST['edd_phone'] ) : '';

    return $payment_meta;
}
add_filter( 'edd_payment_meta', 'makesantafe_edd_store_custom_fields');

/**
 * Add the phone number to the "View Order Details" page
 */
function makesantafe_edd_view_order_details( $payment_meta, $user_info ) {
	$phone = isset( $user_info['id'] ) ? get_user_meta( $user_info['id'] , '_edd_user_phone', true )  : 'none';
?>
    <div class="column-container">
    	<div class="column">
    		<strong><?php echo 'Phone: '; ?></strong>
            <input type="text" name="edd_phone" value="<?php esc_attr_e( $phone ); ?>" class="medium-text" />
            <p class="description"><?php _e( 'Customer phone number', 'edd' ); ?></p>
    	</div>
    </div>
<?php
}
add_action( 'edd_payment_personal_details_list', 'makesantafe_edd_view_order_details', 10, 2 );

/**
 * Save the phone field when it's modified via view order details
 */
function makesantafe_edd_updated_edited_purchase( $payment_id ) {

    // get the payment meta
    $payment_meta = edd_get_payment_meta( $payment_id );

    // update our phone number
    $payment_meta['phone'] = isset( $_POST['edd_phone'] ) ? $_POST['edd_phone'] : false;

    // update the payment meta with the new array
    update_post_meta( $payment_id, '_edd_payment_meta', $payment_meta );
}
add_action( 'edd_updated_edited_purchase', 'makesantafe_edd_updated_edited_purchase' );

/**
 * Add a {phone} tag for use in either the purchase receipt email or admin notification emails
 */
if ( function_exists( 'edd_add_email_tag' ) ) {
	edd_add_email_tag( 'phone', 'Customer\'s phone number', 'makesantafe_edd_email_tag_phone' );
}


/**
 * The {phone} email tag
 */
function makesantafe_edd_email_tag_phone( $payment_id ) {
	$payment_data = edd_get_payment_meta( $payment_id );
	return $payment_data['phone'];
}


/**
 * Update user's phone number in the wp_usermeta table
 * This phone number will be shown on the user's edit profile screen in the admin
 */
function makesantafe_edd_store_usermeta( $payment_id ) {
	// return if user is not logged in
	if ( ! is_user_logged_in() )
		return;

	// get the user's ID
	$user_id = get_current_user_id();

	// update phone number
	update_user_meta( $user_id, '_edd_user_phone', $_POST['edd_phone'] );
}
add_action( 'edd_complete_purchase', 'makesantafe_edd_store_usermeta' );


/**
 * Save the field when the values are changed on the user's WP profile page
*/
function makesantafe_edd_save_extra_profile_fields( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) )
		return false;

	update_user_meta( $user_id, '_edd_user_phone', $_POST['phone'] );

}
add_action( 'personal_options_update', 'makesantafe_edd_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'makesantafe_edd_save_extra_profile_fields' );


/**
 * Save the field when the value is changed on the EDD profile editor
*/
function makesantafe_edd_pre_update_user_profile( $user_id, $userdata ) {

	$phone = isset( $_POST['edd_phone'] ) ? $_POST['edd_phone'] : '';

	// Make sure user enters a phone number
	if ( ! $phone ) {
		edd_set_error( 'phone_required', __( 'Please enter a phone number', 'edd' ) );
	}

	// update phone number
	update_user_meta( $user_id, '_edd_user_phone', $phone );
}
add_action( 'edd_pre_update_user_profile', 'makesantafe_edd_pre_update_user_profile', 10, 2 );

/**
 * Add the Phone to the "Contact Info" section on the user's WP profile page
 */
function makesantafe_user_contactmethods( $methods, $user ) {
	$methods['_edd_user_phone'] = 'Phone';

	return $methods;
}
add_filter( 'user_contactmethods', 'makesantafe_user_contactmethods', 10, 2 );

