<?php
echo '<div class="class-information">';
    echo '<h2>Class Information</h3>';
    echo '<div class="row">';
        echo '<div class="col-12">';
            $woocommerce_account_page_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
            mapi_write_log($woocommerce_account_page_url);
            echo '<p>You can view your class information on your <a href="' . $woocommerce_account_page_url . '">account page</a>. If you have any questions, please contact us at <a href="mailto:build@makesantafe.org">build@makesantafe.org</a></p>';
        echo '</div>';
    echo '</div>';
echo '</div>';
//Intentionally left blank