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

/**
 * Removes coupon form, order notes, and several billing fields if the checkout doesn't require payment.
 *
 */
function make_remove_free_checkout_fields() {
	// first, bail if the cart needs payment, we don't want to do anything
	if ( WC()->cart && WC()->cart->needs_payment() ) {
		return;
	}
	// now continue only if we're at checkout
	// is_checkout() was broken as of WC 3.2 in ajax context, double-check for is_ajax
	// I would check WOOCOMMERCE_CHECKOUT but testing shows it's not set reliably
	if ( function_exists( 'is_checkout' ) && ( is_checkout() || is_ajax() ) ) {
		// remove coupon forms since why would you want a coupon for a free cart??
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		// Remove the "Additional Info" order notes
		add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
		// Unset the fields we don't want in a free checkout
		function unset_unwanted_checkout_fields( $fields ) {
			// add or remove billing fields you do not want
			// fields: http://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/#section-2
			$billing_keys = array(
				'billing_company',
				'billing_phone',
				'billing_address_1',
				'billing_address_2',
				'billing_city',
				'billing_postcode',
				'billing_country',
				'billing_state',
			);
			// unset each of those unwanted fields
			foreach( $billing_keys as $key ) {
				unset( $fields['billing'][ $key ] );
			}
			return $fields;
		}
		add_filter( 'woocommerce_checkout_fields', 'unset_unwanted_checkout_fields' );
	}
}
add_action( 'wp', 'make_remove_free_checkout_fields' );



/**
 * Save post metadata when a post is saved.
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function save_event_date_meta( $id, $post, $update ) {
    $post_type = get_post_type($id);

    // If this isn't a 'book' post, don't update it.
    if ( "product" != $post_type )
      return;


      $date = get_post_meta($id, 'WooCommerceEventsDate', true);
      $event_date_unformated = get_post_meta($id, 'WooCommerceEventsDate', true);
      $event_hour = get_post_meta($id, 'WooCommerceEventsHour', true);
      $event_minutes = get_post_meta($id, 'WooCommerceEventsMinutes', true);
      $event_period = get_post_meta($id, 'WooCommerceEventsPeriod', true);

      $event_date = $event_date_unformated.' '.$event_hour.':'.$event_minutes.$event_period;

      $event_date = str_replace('/', '-', $event_date);
      $event_date = str_replace(',', '', $event_date);
      $event_date = date('Y-m-d H:i:s', strtotime($event_date));
      $event_date = str_replace(' ', 'T', $event_date);
      $event_date = new DateTime($event_date);
      update_post_meta( $id, 'make_event_date', $event_date);
      update_post_meta( $id, 'make_event_date_timestamp', $event_date->format('U'));

}
add_action( 'save_post', 'save_event_date_meta', 10, 3 );
