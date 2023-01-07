<?php
add_theme_support('woocommerce');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');




/*
* Description: By default, WooCommerce reduces stock for any order containing a product. This means stock will be reduced for both the initial purchase of a subscription product and all renewal orders. This extension stops stock being reduced for renewal order payments so that stock is only reduced on the initial purchase. Requires WooCommerce 2.4 or newer and Subscriptiosn 2.0 or newer.
*/

function make_do_not_reduce_renewal_stock( $reduce_stock, $order ) {

	if ( function_exists( 'wcs_order_contains_renewal' ) && wcs_order_contains_renewal( $order ) ) { // Subscriptions v2.0+
		$reduce_stock = false;
	} elseif ( class_exists( 'WC_Subscriptions_Renewal_Order' ) && WC_Subscriptions_Renewal_Order::is_renewal( $order ) ) {
		$reduce_stock = false;
	}

	return $reduce_stock;
}
add_filter( 'woocommerce_can_reduce_order_stock', 'make_do_not_reduce_renewal_stock', 10, 2 );


//Force email to be used as customer username
add_filter( 'woocommerce_new_customer_data', function( $data ) {
	$data['user_login'] = $data['user_email'];

	return $data;
} );

add_action( 'woocommerce_before_checkout_registration_form', function($checkout) {
	echo '<div class="alert alert-info"><h4>Create your account or login above</h4><p>An account will be created with this email address. This will also be your username. You will be required to use an email address to login.</p>';
}, 10, 1 );

add_action ('woocommerce_after_checkout_registration_form', function ($checkout) {
	echo '</div>';
}, 10,1);




add_filter('woocommerce_checkout_fields', function ($fields){
	$fields['account']['account_username']['label'] = 'Email Address';
	$fields['account']['account_username']['placeholder'] = 'Email Address';
	$fields['account']['account_username']['type'] = 'email';
 return $fields;
});




//Removed Actions
remove_action(' woocommerce_sidebar', 'woocommerce_get_sidebar');
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'template_redirect', 'wc_disable_author_archives_for_customers', 10 );


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );


add_action('woocommerce_single_product_summary', 'make_display_content', 25);
function make_display_content() {
    the_content();
};

// remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
// add_action('make_shop_before_container', 'woocommerce_breadcrumb');






add_filter( 'woocommerce_account_menu_items', 'make_remove_address_my_account', 999 );

function make_remove_address_my_account( $items ) {
  // mapi_var_dump($items);
  $items['subscriptions'] = 'Membership';
  unset($items['edit-address']);
  unset($items['edit-account']);
  return $items;
}


if( !wp_next_scheduled( 'make_class_daily' ) ) {
	// Schedule the event
	wp_schedule_event( time(), 'daily', 'make_class_daily' );
}






//remove function attached to woocommerce_before_main_content hook
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action('woocommerce_before_main_content', 'make_woo_before_content_wrapper', 10);

function make_woo_before_content_wrapper() {
  include get_template_directory() . '/layout/page-header.php';
  include get_template_directory() . '/layout/notice.php';
  do_action('make_shop_before_container');
  echo '<div class="container">';
  if(!is_single()){
    include 'shop-header.php';
  }
    echo '<div class="row">';
      echo '<div class="col-12 facetwp-template">';

}

//remove function attached to woocommerce_after_main_content hook
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action('woocommerce_after_main_content', 'make_woo_after_content_wrapper', 10);

function make_woo_after_content_wrapper() {
      echo '</div>';
    echo '</div>';
  echo '</div>';
  do_action('make_shop_after_container');
}






remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
add_action('woocommerce_before_shop_loop_item_title', 'make_loop_product_thumbnail');
function make_loop_product_thumbnail() {
  $id = get_the_ID();
  if(has_post_thumbnail( $id )):
    the_post_thumbnail( $id , 'horz-thumbnail');
  else :
    echo '<img src="' . get_template_directory_uri() . '/img/makeheader.svg"/>';
  endif;

}

add_filter('woocommerce_form_field_args',  'wc_form_field_args',10,3);
  function wc_form_field_args($args, $key, $value) {
  $args['input_class'] = array( 'form-control' );
  return $args;
}




function get_active_members_for_membership($memberships){
    global $wpdb;
    // Getting all User IDs and data for a membership plan
    return $wpdb->get_results( "
        SELECT DISTINCT um.user_id
        FROM {$wpdb->prefix}posts AS p
        LEFT JOIN {$wpdb->prefix}posts AS p2 ON p2.ID = p.post_parent
        LEFT JOIN {$wpdb->prefix}users AS u ON u.id = p.post_author
        LEFT JOIN {$wpdb->prefix}usermeta AS um ON u.id = um.user_id
        WHERE p.post_type = 'wc_user_membership'
        AND p.post_status IN ('wcm-active')
        AND p2.post_type = 'wc_membership_plan'
        AND p2.post_title LIKE '$memberships'
        LIMIT 999
    ");
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
		function make_unset_unwanted_checkout_fields( $fields ) {
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
		add_filter( 'woocommerce_checkout_fields', 'make_unset_unwanted_checkout_fields' );
	}
}
add_action( 'wp', 'make_remove_free_checkout_fields' );




add_filter( 'woocommerce_product_add_to_cart_text', 'make_change_button_text', 100, 2);
function make_change_button_text( $text, $obj ) {
  $tool_reservation = has_term('tool-reservation','product_cat', $obj->get_ID());
  $workshop = has_term('certification', 'product_cat', $obj->get_ID());
  if ( $tool_reservation) {
      $text = __( 'Reserve This Tool', 'woocommerce' );
  } elseif($workshop) {
    $text = __( 'Attend this Workshop', 'woocommerce' );
  }
  return $text;
}
/*
 * Change the entry title of the endpoints that appear in My Account Page - WooCommerce 2.6
 * Using the_title filter
 */
function make_woo_endpoint_title( $items, $endpoints ) {
  $items['bookings'] = 'Tool Reservations';

  return $items;
}
add_filter( 'woocommerce_account_menu_items', 'make_woo_endpoint_title', 10, 2 );




/**
 * @snippet       WooCommerce Add New Tab @ My Account
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=21253
 * @credits       https://github.com/woothemes/woocommerce/wiki/2.6-Tabbed-My-Account-page
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.4.5
 */
// ------------------
// 1. Register new endpoint to use for My Account page
// Note: Resave Permalinks or it will give 404 error

function make_add_make_profile_endpoint() {
    add_rewrite_endpoint( 'make-profile', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'make_add_make_profile_endpoint' );


// ------------------
// 2. Add new query var

function make_profile_query_vars( $vars ) {
    $vars[] = 'make-profile';
    return $vars;
}

add_filter( 'query_vars', 'make_profile_query_vars', 0 );


// ------------------
// 3. Insert the new endpoint into the My Account menu

function make_add_make_profile_link_my_account( $items ) {
    $items['make-profile'] = 'Edit My Public Profile';
    return $items;
}

add_filter( 'woocommerce_account_menu_items', 'make_add_make_profile_link_my_account' );


// ------------------
// 4. Add content to the new endpoint

function make_premium_support_content() {
// echo '<h3></h3>';
include get_template_directory() . '/inc/user-edit-form.php';
}

add_action( 'woocommerce_account_make-profile_endpoint', 'make_premium_support_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format





/**
 * Removes coupon form, order notes, and several billing fields if the checkout doesn't require payment.
 *
 * Tutorial: http://skyver.ge/c
 */
function make_free_checkout_fields() {
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
add_action( 'wp', 'make_free_checkout_fields' );



/*
* Add "Billing Company" value to Stripe metadata
*/
function make_filter_wc_stripe_payment_metadata( $metadata, $order, $source ) {

  $count = 1;
  foreach( $order->get_items() as $item_id => $line_item ){
    $item_data = $line_item->get_data();
    $product = $line_item->get_product();
    $product_name = $product->get_name();
    $item_quantity = $line_item->get_quantity();
    $item_total = $line_item->get_total();
    $metadata['Line Item '.$count] = 'Product name: '.$product_name.' | Quantity: '.$item_quantity.' | Item total: '. number_format( $item_total, 2 );
    $count += 1;
  }

  return $metadata;


}
add_filter( 'wc_stripe_payment_metadata', 'make_filter_wc_stripe_payment_metadata', 10, 3 );
