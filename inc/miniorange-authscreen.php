<?php
/**
 * Summary of authorize-dialog
 *
 * @package Authorize Dialog
 */
get_header('blank');
function mo_oauth_server_emit_html( $client_credentials, $scope_message ) {

    $oauth_client_list_json      = file_get_contents( dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'oauth-client-list.json' ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Using file_get_contents to fetch a local file, not a remote file.
    $oauth_client_list_json_data = json_decode( $oauth_client_list_json, true );

    $chosen_client   = get_option( 'mo_oauth_server_client' );
    $client_settings = $oauth_client_list_json_data[ $chosen_client ];
    ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm mt-5">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h2 class="h4 mb-3">Authorize Make Santa Fe Wiki</h2>
                            <hr>
                        </div>
                        <p class="lead text-center mb-3">Make Santa Fe Wiki wants to access the following information:</p>
                        <ul class="list-group mb-4">
                            <?php foreach ( $scope_message as $msg ) { ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <input type="checkbox" checked="checked" name="consent[]" value="<?php echo esc_attr( $msg ); ?>" disabled class="form-check-input me-2">
                                    <span><?php echo esc_html( $msg ); ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                        <p class="text-center fst-italic text-muted mb-4">This application cannot continue if you do not allow this application.</p>
                        <div class="d-flex flex-column gap-2">
                            <form action="" method="post" class="mb-2">
                                <?php wp_nonce_field( 'mo_oauth_server_authorize_dialog_allow_form', 'mo_oauth_server_authorize_dialog_allow_form_field' ); ?>
                                <input type="hidden" name="mo_oauth_server_authorize_dialog" value="1" />
                                <input type="hidden" name="mo_oauth_server_authorize" value="allow" />
                                <button class="btn btn-success w-100" type="submit">Submit Consent</button>
                            </form>
                            <form action="" method="post">
                                <?php wp_nonce_field( 'mo_oauth_server_authorize_dialog_deny_form', 'mo_oauth_server_authorize_dialog_deny_form_field' ); ?>
                                <input type="hidden" name="mo_oauth_server_authorize_dialog" value="1" />
                                <input type="hidden" name="mo_oauth_server_authorize" value="deny" />
                                <button class="btn btn-outline-danger w-100" type="submit">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
get_footer('blank');