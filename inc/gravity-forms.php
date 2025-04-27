<?php

add_action( 'gform_after_submission_27', 'make_map_user_to_entry', 10, 2 );
function make_map_user_to_entry( $entry, $form ) {
    $user_id = $entry['created_by'];
    // set the arguments for the add_user_meta() function
    $meta_key = 'liability_entry';
    $meta_value = array( 'entry_id' => $entry['id'], 'form_id' => $form['id'] );
    $return = add_user_meta( $user_id, $meta_key, $meta_value);
}

mapi_write_log( 'make_allowable_tags' );
add_filter( 'gform_allowable_tags', 'make_allowable_tags' );
function make_allowable_tags( $allowed_tags ) {
    mapi_write_log( 'make_allowable_tags' );
    mapi_write_log( $allowed_tags );
    $allowed_tags['br'] = true;
    return $allowed_tags;
}



add_filter( 'gform_field_content', 'make_allow_html_in_consent_description', 10, 5 );
function make_allow_html_in_consent_description( $field_content, $field, $value, $lead_id, $form_id ) {
    // Check if the field is a consent field
    if ( $field->type === 'consent' ) {
        // Allow HTML tags in the field description
        $field->description = wp_kses_post( $field->description );
    }
    mapi_write_log( 'make_allow_html_in_consent_description' );
    mapi_write_log( $field->description );
    mapi_write_log( $field_content );
    return $field_content;
}