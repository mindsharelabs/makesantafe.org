<?php
add_theme_support('woocommerce');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');




//Removed Actions
remove_action(' woocommerce_sidebar', 'woocommerce_get_sidebar');
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'template_redirect', 'wc_disable_author_archives_for_customers', 10 );


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );


add_action('woocommerce_single_product_summary', 'make_display_content', 25);
function make_display_content() {
      the_content();
};

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action('make_shop_before_container', 'woocommerce_breadcrumb');




//Add filter for expired products to make them not purchasable. This removes the add to cart buttons.
add_filter('woocommerce_is_purchasable', 'make_is_purchasable', 10, 2);
function make_is_purchasable($is_purchasable, $product) {
  $id = get_the_ID();
  $status = get_post_status( $product->get_ID() );
  if($status == 'expired') {
    return false;
  } else {
    return $is_purchasable;
  }
}



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


add_action('woocommerce_single_product_summary', 'make_display_fees');
function make_display_fees() {
  $id = get_the_ID();
  $fees = get_field('additional_fees', $id);
  if($fees) :
    echo '<div class="fee-container border-bottom pb-2 mb-2">';
      foreach ($fees as $key => $fee) :
        echo '<span class="fee-name"><strong>' . $fee['fee_name'] . ' </strong></span>';
        echo '<span class="fee-amount"><strong>$' . $fee['fee_amount'] . '</strong></span>';
      endforeach;
    echo '</div>';
  endif;
}





add_action('make_class_daily', 'make_expire_events');
function make_expire_events() {
  $args = array(
    'post_type' => 'product',
    'post_status' => array( 'publish' ),
    'posts_per_page' => -1,
    'meta_query' => array(
      'relation' => 'AND',
        array(
          'key' => 'make_event_date_timestamp',
          'value' => date('U',time()),
          'compare' => '<',
          'type' => 'NUMERIC'
        ),
        array(
    			'key'     => 'WooCommerceEventsEvent',
    			'value'   => 'Event',
    			'compare' => '='
    		)
    )
  );
  $events = new WP_Query($args);
  if($events->have_posts()) :
    while($events->have_posts()) : $events->the_post();
      $now = date('U', time());
      $event_date = get_post_meta(get_the_ID(), 'make_event_date_timestamp', true);
      if($now > $event_date){
          wp_update_post(array(
            'ID'    =>  get_the_ID(),
            'post_status'   =>  'expired',
            )
          );
          update_post_meta(get_the_ID(), 'WooCommerceEventsBackgroundColor', '#d8d8d8');
      }
    endwhile;
  endif;
}







add_action('woocommerce_after_single_product_summary', 'make_add_customer_list', 5);
function make_add_customer_list() {
  if(current_user_can('instructor') || current_user_can('administrator')):
    echo do_shortcode('[customer_list
      export_csv="true"
      limit="30"
      show_titles="true"
      print="true"
      paging="true"
      order_status="wc-processing,wc-completed"
      order_qty="true"
      customer_message="true"
      billing_email="true"
      order_variations="false"
      order_number="true"
      order_status_column="true"
    ]');
    echo '<hr>';
  endif;
}



add_action('make_shop_before_container', 'make_add_expired_notice');
function make_add_expired_notice() {
  if(is_single()) :
    $status = get_post_status(get_the_ID());
    if($status == 'expired') :
      echo '<div class="container">';
        echo '<div class="row">';
          echo '<div class="col">';
            echo '<div class="alert alert-primary" role="alert">This event is expired.</div>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    endif;
  endif;
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
  include get_template_directory() . '/layout/top-footer.php';
}






remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
add_action('woocommerce_before_shop_loop_item_title', 'make_loop_product_thumbnail');
function make_loop_product_thumbnail() {
  $id = get_the_ID();
  $thumb = get_the_post_thumbnail_url($id, 'full');
  if($thumb):
    $src_320 = aq_resize($thumb, 320, 200);
    $src_480 = aq_resize($thumb, 480, 300);
    $src_800 = aq_resize($thumb, 800, 500);
    $src = $src_800;
    echo '<img src=" ' . $src . '" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt=""
        srcset="' . $src_320 . ' 320w,
                ' . $src_480 . ' 480w,
                ' . $src_800 . ' 800w"
        sizes=" (max-width: 320px) 280px,
                (max-width: 480px) 440px,
                800px"
       src="elva-fairy-800w.jpg">';
  else :
    echo '<img src="' . get_template_directory_uri() . '/img/makeheader.svg"/>';
  endif;

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
            $fee_name = get_the_title($item->get_ID()) . ' ' . $fee['fee_name'];

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

add_action('woocommerce_after_shop_loop_item_title', 'make_add_event_date', 1);

function make_add_event_date() {
  $is_event = get_post_meta(get_the_id(), 'WooCommerceEventsEvent', true);
  if($is_event === 'Event') :
    $date = get_post_meta(get_the_ID(), 'make_event_date', true);
    if($date):
      echo '<span class="event-date text-center d-block w-100">' . $date->format('D, M j') . '</span>';
    endif;
  endif;
}



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
 * Save post metadata when a post is saved.
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function save_event_date_meta( $id, $post, $update ) {
    $post_type = get_post_type($id);

    // If this isn't a 'product' post, don't update it.
    if ( "product" != $post_type )
      return;


      $date = get_post_meta($id, 'WooCommerceEventsDate', true);

      $color = make_get_event_color($id);


      $event_date_unformated = get_post_meta($id, 'WooCommerceEventsDate', true);
      if($event_date_unformated) :

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
        update_post_meta( $id, 'WooCommerceEventsBackgroundColor', $color);
      else :
        $event_date = new DateTime();
        update_post_meta( $id, 'make_event_date_timestamp', $event_date->format('U'));
      endif;

}
add_action( 'save_post', 'save_event_date_meta', 10, 3 );




function make_get_event_color($id) {
  $status = get_post_status( $ID );
  if($status == 'expired') :
    return '#d8d8d8';
  else :
    return '#BE202E';
  endif;
}


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




function wc_subscriptions_custom_price_string( $pricestring ) {
  $pricestring = str_replace( 'sign-up fee', 'introductory price', $pricestring );
  return $pricestring;
}
add_filter( 'woocommerce_subscriptions_product_price_string', 'wc_subscriptions_custom_price_string' );
add_filter( 'woocommerce_subscription_price_string', 'wc_subscriptions_custom_price_string' );




add_filter( 'woocommerce_email_recipient_backorder', 'change_stock_email_recipient', 10, 2 ); // For Backorders notification
add_filter( 'woocommerce_email_recipient_low_stock', 'change_stock_email_recipient', 10, 2 ); // For Low stock notification
add_filter( 'woocommerce_email_recipient_no_stock', 'change_stock_email_recipient', 10, 2 ); // For No stock notification
function change_stock_email_recipient( $recipient, $product ) {
    // HERE set your replacement email
    $recipient = 'build@makesantafe.org';

    return $recipient;
}
