<?php

add_action( 'gform_after_submission_27', 'make_map_user_to_entry', 10, 2 );
function make_map_user_to_entry( $entry, $form ) {
    $user_id = $entry['created_by'];
    // set the arguments for the add_user_meta() function
    $meta_key = 'liability_entry';
    $meta_value = array( 'entry_id' => $entry['id'], 'form_id' => $form['id'] );
    mapi_write_log($meta_value);
    $return = add_user_meta( $user_id, $meta_key, $meta_value);
    mapi_write_log($return);
}
