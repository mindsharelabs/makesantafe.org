<?php
add_theme_support('woocommerce');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');


//Removed Actions
remove_action(' woocommerce_sidebar', 'woocommerce_get_sidebar');



remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action('woocommerce_single_product_summary', 'make_display_content', 25);
function make_display_content() {
      the_content();
};

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('make_shop_before_container', 'woocommerce_breadcrumb');


//remove function attached to woocommerce_before_main_content hook
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action('woocommerce_before_main_content', 'make_woo_before_content_wrapper', 10);

function make_woo_before_content_wrapper() {
  include get_template_directory() . '/layout/page-header.php';
  include get_template_directory() . '/layout/notice.php';
  do_action('make_shop_before_container');
  echo '<div class="container">';
    echo '<div class="row">';
      echo '<div class="col-12">';

}

//remove function attached to woocommerce_after_main_content hook
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action('woocommerce_after_main_content', 'make_woo_after_content_wrapper', 10);

function make_woo_after_content_wrapper() {
      echo '</div>';
    echo '</div>';
  echo '</div>';
  do_action('make_shop_after_container');
  include get_template_directory() . '/layout/top-footer.php';
}



add_action( 'woocommerce_after_cart_item_quantity_update', 'make_add_custom_fees' );
add_action( 'woocommerce_cart_calculate_fees','make_add_custom_fees' );
function make_add_custom_fees($cart) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // going through each cart items
    foreach( WC()->cart->get_cart() as $values ) :
        $item = $values['data'];
        if ( empty( $item ) )
            break;

        $quantity = $values[ 'quantity' ];
        $fees = get_field('additional_fees', $item->get_ID());

        if($fees) :
          foreach ($fees as $key => $fee) {
            $fee_amount = $fee['fee_amount'] * $quantity;
            $fee_name = $fee['fee_name'];

            // add_fee method (TAX will NOT be applied here)
            WC()->cart->add_fee( $fee_name . ': ', $fee_amount, false );
          }
        endif;
    endforeach;

}

add_filter('woocommerce_form_field_args',  'wc_form_field_args',10,3);
  function wc_form_field_args($args, $key, $value) {
  $args['input_class'] = array( 'form-control' );
  return $args;
}

add_action('woocommerce_account_dashboard', 'make_add_acf_form');
function make_add_acf_form() {
  include get_template_directory() . '/inc/user-edit-form.php';
}
