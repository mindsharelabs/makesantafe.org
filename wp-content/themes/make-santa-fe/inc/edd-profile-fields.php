<?php

/**
 * Display phone number field at checkout
 * Add more here if you need to
 */
function sumobi_edd_display_checkout_fields() {

	// get user's phone number if they already have one stored
	if ( is_user_logged_in() ) {

		$user_id = get_current_user_id();
		$phone = get_the_author_meta( 'billing_phone', $user_id );
		$address = get_the_author_meta( 'billing_address_1', $user_id );
		$country = get_the_author_meta( 'billing_country', $user_id);
	}

	$phone = isset( $phone ) ? esc_attr( $phone ) : '';
	$address = isset( $address ) ? esc_attr( $address ) : '';
	$country = isset ( $country ) ? esc_attr ( $country ) : '';

?>
    <p id="edd-phone-wrap">
        <label class="edd-label" for="edd-phone">
        	<?php echo 'Phone Number (optional)'; ?>
        </label>
        <span class="edd-description">
        	<?php echo 'Enter your phone number so we can get in touch with you.'; ?>
        </span>
        <input class="edd-input" type="text" name="edd_phone" id="edd-phone" placeholder="<?php echo 'Phone Number'; ?>" value="<?php echo $phone; ?>" />
    </p>

    <p id="edd-address-wrap">
    	<label class="edd-label" for="edd-address">
    		<?php echo 'Address (optional)'; ?>
    	</label>
    	<span class="edd-description">
    		<?php echo 'Enter your address.'; ?>
    	</span>
    	<input class="edd-input" type="text" name="edd_address" id="edd-address" placeholder="<?php echo 'Street and number'; ?>" value="<?php echo $address; ?>" />
    </p>

    <p id="edd-country-wrap">
    	<label class="edd-label" for="edd-phone">
    		<?php echo 'Country (optional)'; ?>
    	</label>
    	<span class="edd-description">
    		<?php echo 'Enter your country.'; ?>
    	</span>
    	<input class="edd-input" type="text" name="edd_country" id="edd-country" placeholder="<?php echo 'Country'; ?>" value="<?php echo $country; ?>" />
    </p>
    <?php
}
if( is_user_logged_in() ) {
    add_action( 'edd_purchase_form_after_user_info', 'sumobi_edd_display_checkout_fields' );
} else {
   add_action( 'edd_purchase_form_user_info', 'sumobi_edd_display_checkout_fields' );
}

/**
 * Make phone number required
 * Add more required fields here if you need to

function sumobi_edd_required_checkout_fields( $required_fields ) {
	$required_fields = array(
		'edd_phone' => array(
			'error_id' => 'invalid_phone',
			'error_message' => 'Please enter a valid Phone number'
		),
	);

	return $required_fields;
}

*/

add_filter( 'edd_purchase_form_required_fields', 'sumobi_edd_required_checkout_fields' );

/**
 * Set error if phone number field is empty
 * You can do additional error checking here if required

function sumobi_edd_validate_checkout_fields( $valid_data, $data ) {
    if ( empty( $data['edd_phone'] ) ) {
        edd_set_error( 'invalid_phone', 'Please enter your phone number.' );
    }
}
add_action( 'edd_checkout_error_checks', 'sumobi_edd_validate_checkout_fields', 10, 2 );
 */


/**
 * Store the custom field data into EDD's payment meta
 */
function sumobi_edd_store_custom_fields( $payment_meta ) {
    $payment_meta['phone'] = isset( $_POST['edd_phone'] ) ? sanitize_text_field( $_POST['edd_phone'] ) : '';
    $payment_meta['address'] = isset($_POST['edd_address'] ) ? sanitize_text_field( $_POST['edd_address'] ) : '';
    $payment_meta['country'] = isset( $_POST['edd_country'] ) ? sanitize_text_field( $_POST['edd_country'] ) : '';

    return $payment_meta;
}
add_filter( 'edd_payment_meta', 'sumobi_edd_store_custom_fields');

/**
 * Add the phone number to the "View Order Details" page
 */
function sumobi_edd_view_order_details( $payment_meta, $user_info ) {
	$phone = isset( $payment_meta['phone'] ) ? $payment_meta['phone'] : 'none';
	$address = isset( $payment_meta['address'] ) ? $payment_meta['address'] : 'none';
	$country = isset ( $payment_meta['country'] ) ? $payment_meta['country'] : 'none';
?>
    <div class="column-container">
    	<div class="column">
    		<strong><?php echo 'Phone: '; ?></strong>
            <input type="text" name="edd_phone" value="<?php esc_attr_e( $phone ); ?>" class="medium-text" />
            <p class="description"><?php _e( 'Customer phone number', 'edd' ); ?></p>
    	</div>

		<div class="column">
    		<strong><?php echo 'Address: '; ?></strong>
            <input type="text" name="edd_address" value="<?php esc_attr_e( $address ); ?>" class="medium-text" />
            <p class="description"><?php _e( 'Customer address', 'edd' ); ?></p>
    	</div>

    	<div class="column">
    		<strong><?php echo 'Country: '; ?></strong>
            <input type="text" name="edd_country" value="<?php esc_attr_e( $country ); ?>" class="medium-text" />
            <p class="description"><?php _e( 'Customer country', 'edd' ); ?></p>
    	</div>
    </div>
<?php
}
add_action( 'edd_payment_personal_details_list', 'sumobi_edd_view_order_details', 10, 2 );

/**
 * Save the phone field when it's modified via view order details
 */
function sumobi_edd_updated_edited_purchase( $payment_id ) {

    // get the payment meta
    $payment_meta = edd_get_payment_meta( $payment_id );

    // update our phone number
    $payment_meta['phone'] = isset( $_POST['edd_phone'] ) ? $_POST['edd_phone'] : false;
    $payment_meta['address'] = isset( $_POST['edd_address'] ) ? $_POST['edd_address'] : false;
    $payment_meta['country'] = isset( $_POST['edd_country'] ) ? $_POSTp['edd_country'] : false;

    // update the payment meta with the new array
    update_post_meta( $payment_id, '_edd_payment_meta', $payment_meta );
}
add_action( 'edd_updated_edited_purchase', 'sumobi_edd_updated_edited_purchase' );

/**
 * Add a {phone} tag for use in either the purchase receipt email or admin notification emails
 */
if ( function_exists( 'edd_add_email_tag' ) ) {
	edd_add_email_tag( 'phone', 'Customer\'s phone number', 'sumobi_edd_email_tag_phone' );
}

/**
 * The {phone} email tag
 */
function sumobi_edd_email_tag_phone( $payment_id ) {
	$payment_data = edd_get_payment_meta( $payment_id );
	return $payment_data['phone'];
}


/**
 * Update user's phone number in the wp_usermeta table
 * This phone number will be shown on the user's edit profile screen in the admin
 */
function sumobi_edd_store_usermeta( $payment_id ) {
	// return if user is not logged in
	if ( ! is_user_logged_in() )
		return;

	// get the user's ID
	$user_id = get_current_user_id();

	// update phone number
	update_user_meta( $user_id, 'billing_phone', $_POST['edd_phone'] );

	// update address
	update_user_meta( $user_id, 'billing_address_1', $_POST['edd_address'] );

	// update country
	update_user_meta( $user_id, 'billing_country', $_POST['edd_country'] );

	// update billing first name
	update_user_meta( $user_id, 'billing_first_name', $_POST['edd_first'] );

	// update billing last name
	update_user_meta( $user_id, 'billing_last_name', $_POST['edd_last'] );

	// update billing last name
	update_user_meta( $user_id, 'billing_email', $_POST['edd_email'] );
}

add_action( 'edd_complete_purchase', 'sumobi_edd_store_usermeta' );


/**
 * Save the field when the values are changed on the user's WP profile page
*/
function sumobi_edd_save_extra_profile_fields( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) )
		return false;

	update_user_meta( $user_id, 'billing_phone', $_POST['phone'] );
	update_user_meta( $user_id, 'billing_address_1', $_POST['address'] );
	update_user_meta( $user_id, 'billing_country', $_POST['country'] );

}
add_action( 'personal_options_update', 'sumobi_edd_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'sumobi_edd_save_extra_profile_fields' );


/**
 * Save the field when the value is changed on the EDD profile editor
*/
function sumobi_edd_pre_update_user_profile( $user_id, $userdata ) {

	$phone = isset( $_POST['edd_phone'] ) ? $_POST['edd_phone'] : '';

	// Make sure user enters a phone number
	if ( ! $phone ) {
		edd_set_error( 'phone_required', __( 'Please enter a phone number', 'edd' ) );
	}

	// update phone number
	update_user_meta( $user_id, 'billing_phone', $phone );

	// update address
	update_user_meta( $user_id, 'billing_address_1', $address );

	// update country
	update_user_meta( $user_id, 'billing_country', $country );
}
add_action( 'edd_pre_update_user_profile', 'sumobi_edd_pre_update_user_profile', 10, 2 );




