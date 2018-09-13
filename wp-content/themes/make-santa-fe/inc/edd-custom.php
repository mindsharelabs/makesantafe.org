<?php




add_filter('edd_download_columns' , 'add_book_columns');

function add_book_columns($download_columns) {
    //unset($download_columns['author']);
    return array_merge($download_columns,
          array('location' => 'Event'));
}



/*
 * Modify the user role that is given to users that register during checkout
 */
function pw_edd_set_customer_user_role( $payment_id ) {

	$downloads = edd_get_payment_meta_downloads( $payment_id );
	$user_id = edd_get_payment_user_id( $payment_id );

	$setMember = $setMemberOther = false;
	  	if ( is_array( $downloads ) ) {
	        // Increase purchase count and earnings
	        foreach ( $downloads as $download ) {
				$edd_cat = wp_list_pluck(get_the_terms($download['id'], 'download_category', array('include'=> array($download['id']),'fields' => 'id=>slug') ), 'slug');

						$allowed = array('membership');
						if( array_intersect ( $edd_cat , $allowed  ) ){
							$setMember = true;
						}

						$allowedshort = array('short-term-memberships');
						if( array_intersect ( $edd_cat , $allowedshort  ) ){
							$setMemberOther = true;
						}
			}
		};

			if($setMember){
					// Set the role to the role you wish customers to have
					$role = 'member';

					$user = new WP_User( $user_id );
					$user->set_role( $role );
			};

			if($setMemberOther){
					// Set the role to the role you wish customers to have
					$role = 'member-other';

					$user = new WP_User( $user_id );
					$user->set_role( $role );
			}



}
add_action( 'edd_complete_purchase', 'pw_edd_set_customer_user_role', 10, 2 );





add_action('manage_posts_custom_column' , 'book_custom_columns', 10, 2 );
function book_custom_columns( $column_name, $post_id ) {
	if ( get_post_type( $post_id ) == 'download' ) {
		switch ( $column_name ) {
			case 'location':
					$pages = '';

		$args = array (
		    'post_type' => 'event',
		   'posts_per_page' => -1,
		    'meta_query' => array(
				array(
			        'key'		=> 'recurring_dates_%_ticket',
			        'compare'	=> '=',
			        'value'		=> $post_id,
			    )
		    ),
		);

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			global $post;
			while( $query->have_posts() ) {
				$query->the_post();
							$recurring_dates = get_field('recurring_dates');
						    foreach($recurring_dates  as $event){
							    if( $event['ticket']== $post_id ){
								    $date = '<div class="sub_field">'.date("M jS, Y", strtotime($event['date'])).'</div>';
							    }
						    }
						$pages .= $date.'<a href="'.get_edit_post_link() .'">'.$post->post_title.'</a>';
			}
		}
		echo $pages;

				break;
		}
	}
}

/*
add_filter( 'manage_edit-download_sortable_columns', 'my_sortable_cake_column' );
function my_sortable_cake_column( $columns ) {
    $columns['location'] = 'location';

    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);

    return $columns;
}
*/



	function anagram_get_related_event_from_download($download_id, $date= false, $link= false){
			$args = array (
		    'post_type' => 'event',
		   'posts_per_page' => 1,
		    'meta_query' => array(
				array(
			        'key'		=> 'recurring_dates_%_ticket',
			        'compare'	=> '=',
			        'value'		=> $download_id,
			    )
		    ),
		);


		$query = new WP_Query( $args );


		if ( !$query->have_posts() ) return false;

		$post_id = wp_list_pluck( $query->posts, 'ID' );

		$recurring_dates = get_field('recurring_dates', $post_id[0]);
						    foreach($recurring_dates  as $event){
							    if( $event['ticket']== $download_id ){
									$date = strtotime($event['date']);
							    }
						    }

			$event_link = get_the_permalink($post_id[0]).'/'.date("Y-m-d", $date ).'/';

			if($link) return $event_link;


			$dateformatted = '<div class="sub_field">'.date("M jS, Y g:i a", $date).'</div>';
			$event = '<a href="'.$event_link .'">'.get_the_title($post_id[0]).'</a>'.$dateformatted;

			return $event;

				//break;
	}



 function edd_redirect_to_cart_on_add( $data ) {
	global $edd_options;

	$redirect_url = get_permalink( $edd_options['purchase_page'] );

	if ( edd_get_current_page_url() != $redirect_url ) {
		wp_redirect( $redirect_url, 303 );
		exit;
	}
}
//add_action( 'edd_add_to_cart', 'edd_redirect_to_cart_on_add', 999 );








function makesantafe_eddmp_create_payment( $data ) {
	if ( wp_verify_nonce( $data['edd_create_payment_nonce'], 'edd_create_payment_nonce' ) ) {
		// email address of user
		$email_address = $data['user'];
		// check to see if a user account doesn't already exist with email address
		$user_id = username_exists( $email_address );
		// user doesn't exist, let's create it
		if ( ! $user_id && email_exists( $user_id ) == false ) {
			// Generate the password and create the user
			$password = wp_generate_password( 12, false );
			$user_id = wp_create_user( $email_address, $password, $email_address );
			// return if user_id already exists
			if ( is_wp_error( $user_id ) ) {
				return;
			}

			$first_name = isset( $data['first'] ) ? $data['first'] : '';
			$last_name = isset( $data['last'] ) ? $data['last'] : '';
			// create user with information entered at checkout
			wp_update_user(
				array(
					'ID'			=> $user_id,
					'first_name'	=> $first_name,
					'last_name'		=> $last_name,
					'nickname'		=> $first_name, // set nick name to be the same as first name
					'display_name'	=> $first_name, // set display name to be the same as first name
				)
			);
			// Set role
			$user = new WP_User( $user_id );
			$user->set_role( 'subscriber' );
			// User details
			$user_details = get_user_by( 'email', $email_address );
			$username = $user_details->user_login;
			// Subject line
			$subject = 'Your login details';
			// Build message
			$message = edd_get_email_body_header();
			$message .= makesantafe_eddmp_build_email( $first_name, $username, $password );
			$message .= edd_get_email_body_footer();
			// get from name and email from EDD options
			$from_name = isset( $edd_options['from_name'] ) ? $edd_options['from_name'] : get_bloginfo( 'name' );
			$from_email = isset( $edd_options['from_email'] ) ? $edd_options['from_email'] : get_option( 'admin_email' );
			// headers
			$headers = "From: " . stripslashes_deep( html_entity_decode( $from_name, ENT_COMPAT, 'UTF-8' ) ) . " <$from_email>\r\n";
			$headers .= "Reply-To: ". $from_email . "\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";

			// send email
			wp_mail( $email_address, $subject, $message, $headers );
		}

	}
}
//add_action( 'edd_create_payment', 'makesantafe_eddmp_create_payment', 20 );
/**
 * Email Template Body
 */
function makesantafe_eddmp_build_email( $first_name, $username, $password ) {
	// Email body
	$default_email_body = '';
	if ( $first_name ) {
		$default_email_body .= "Dear" . ' ' . $first_name . ",\n\n";
	}
	else {
		$default_email_body .= "Hi" . ",\n\n";
	}

	$default_email_body .= "Below are your login details:" . "\n\n";
	$default_email_body .= "Your Username:" . ' ' . $username . "\n\n";
	$default_email_body .= "Your Password:" . ' ' . $password . "\n\n";
	$default_email_body .= get_bloginfo( 'name' ) . "\n\n";
	$default_email_body .= site_url();
	return apply_filters( 'edd_purchase_receipt', $default_email_body, null, null );
}




//remove_filter('edd_metabox_save__edd_download_terms', 'sanitize_terms_save', 20);


function my_child_theme_edd_download_supports( $supports ) {
	// add page-attributes
	$add_support = array( 'page-attributes' );
	// merge it back with the original array
	return array_merge( $add_support, $supports );
}
add_filter( 'edd_download_supports', 'my_child_theme_edd_download_supports' );



// Removes currency symbol from the shop price display
function sww_remove_edd_usd_currency_symbol( $output, $currency, $price ) {
    $output = $price;
    return $output;
}
// This will apply to USD, but the usd in this filter can be replaced with your currency symbol
//add_filter( 'edd_usd_currency_filter_before', 'sww_remove_edd_usd_currency_symbol', 10, 3 );




		function check_cart_donation() {
				$thecart = edd_get_cart_contents();
			//mapi_var_dump($thecart);
			if( $thecart ) :
				$donation = false;
				foreach( $thecart as $item ) :
					if($item['id']==1979) $donation = true;
				endforeach;
			endif;


			if($donation){
				mapi_var_dump($donation);
				remove_action( 'edd_register_fields_before', array('CFM_Render_Form', 'add_fields'), 20);
				remove_action('edd_purchase_form_after_user_info', array('CFM_Render_Form', 'add_fields'), 20);
			}
		}

//add_action('edd_purchase_form_after_user_info', 'check_cart_donation');

function anagram_edd_recovery_verify_logged_in( $verified_data, $post_data ) {

	edd_set_error( 'recovery_requires_login', __( 'To complete this payment, please login to your account.', 'easy-digital-downloads' ) );
}
//add_action( 'edd_checkout_error_checks', 'anagram_edd_recovery_verify_logged_in', 10, 2 );



//Fix order of loading for custom amount plugin and purchase limit.
//remove_filter( 'edd_purchase_link_top', 'edd_cp_purchase_link_top' );
//add_filter( 'edd_purchase_link_top', 'edd_cp_purchase_link_top', 20 );

/**
 * EDD functions
 *
 * @access public
 * @param mixed $imgargs
 * @return void
 */

	add_filter( 'edd_email_receipt_download_title','anagram_email_receipt' , 10, 3 );

		/**
		 * Modify email template to remove dash if the item is a service
		 *
		 * @since 1.0
		*/
		function anagram_email_receipt( $title, $item, $price_id, $payment_id ) {
			//if ( $this->is_service( $item_id ) ) {
				$title = get_the_title( $item['id'] );

				if( $price_id !== false ) {
					$title .= "&nbsp;" . edd_get_price_option_name( $item['id'], $price_id );
				}
			//}
				if( anagram_get_related_event_from_download($item['id']) ) {
					return anagram_get_related_event_from_download($item['id']);
				}

			return $title;
		}

		add_filter( 'edd_receipt_no_files_found_text',  'anagram_download_text', 10, 1 );

		function anagram_download_text( $item_id ) {

			return '';
		}


		add_filter( 'edd_receipt_show_download_files', 'anagram_payment_receipt', 10, 2 );
			/**
		 * Is service
		 * @param  int  $item_id ID of download
		 * @return boolean true if service, false otherwise
		 * @return boolean
		 */
		function anagram_payment_receipt( $item_id ) {
			global $edd_receipt_args;


			// get payment
			$payment   = get_post( $edd_receipt_args['id'] );
			$meta      = isset( $payment ) ? edd_get_payment_meta( $payment->ID ) : '';
			$cart      = isset( $payment ) ? edd_get_payment_meta_cart_details( $payment->ID, true ) : '';

			if ( $cart ) {
				foreach ( $cart as $key => $item ) {
					$price_id = edd_get_cart_item_price_id( $item );

					$download_files = edd_get_download_files( $item_id, $price_id );

					// if the service has a file attached, we still want to show it
					if ( $download_files )
						return;
				}
			}

			return false;
		}


//Update password form
function custom_password_form($content) {
	$before = array('This post is password protected. To view it please enter your password below:','Password:','Submit');
	$after = array('Enter your password to view this content:','Password:','Login');
	$content = str_replace($before,$after,$content);

	//$content = str_replace('type=\"submit\"', 'type=\'submit\'  class=\'btn btn-default\' ', $content);
		//$content = str_replace('name=\'post_password\'', 'name=\'post_password\' class=\'form-control\' ', $content);

		//$content = str_replace('<input ', '<input class=\'form-control\' ', $content);

	//$content = str_replace( 'submit\'', 'submit\" class="btn btn-default"', $content );


	return $content;
}
add_filter('the_password_form', 'custom_password_form');


//Change name
function pw_edd_product_labels( $labels ) {
	$labels = array(
	   'singular' => __('Commerce', 'your-domain'),
	   'plural' => __('Commerce', 'your-domain')
	);
	return $labels;
}
add_filter('edd_default_downloads_name', 'pw_edd_product_labels');


 //Hide classes/downloads from search
 function pw_edd_hide_from_search( $args ) {
	$args['exclude_from_search'] = true;
	return $args;
}
add_filter( 'edd_download_post_type_args', 'pw_edd_hide_from_search' );



function pw_edd_checkout_text( $translated, $original, $domain ) {
   if( $translated == 'Checkout' && $domain == 'easy-digital-downloads' ) {
       //$translated = __( 'Continue', 'easy-digital-downloads' );
   }
   	if(  $translated == 'Added to cart'  && $domain == 'easy-digital-downloads'  ) {
		// $translated = __( 'Some new text here', 'easy-digital-downloads' );
	}

	 if(  $translated == 'Your cart is empty.'  && $domain == 'easy-digital-downloads'  ) {
		 //$translated = __( 'You have not added any classes for registration', 'edd' );
	}
    if( $translated == 'Download Name' && $domain == 'easy-digital-downloads' ) {
       $translated = __( 'Product Name', 'easy-digital-downloads' );
   }
      if( $translated == 'Files' && $domain == 'easy-digital-downloads' ) {
       $translated = __( 'Files', 'easy-digital-downloads' );

   }

   if( $translated == 'Free Download' && $domain == 'easy-digital-downloads' ) {
       $translated = __( 'Reserve Spot', 'easy-digital-downloads' );

   }

   if( $translated == 'With %s signup fee' && $domain == 'edd-recurring' ) {
       //$translated = __( 'With %s orientation fee', 'edd-recurring' );

   }


   if( $translated == 'Signup Fee' && $domain == 'edd-recurring' ) {
       //$translated = __( 'Orientation Fee', 'edd-recurring' );

   }

   if( $translated == 'Name your price' && $domain == 'edd_cp' ) {
       $translated = __( 'Custom Amount', 'edd_cp' );

   }



      if( $translated == 'Download Now' && $domain == 'edd-free-downloads' ) {
       $translated = __( 'Register Now', 'edd-free-downloads' );
   }


    if(  $translated == 'Easy Digital Downloads Sales Summary'  && $domain == 'easy-digital-downloads'  ) {
		 $translated = __( 'Sales Summary', 'easy-digital-downloads' );
	}


	if( $translated == 'Disable product when any item sells out' && $domain == 'edd-purchase-limit' ) {
       $translated = __( 'Disable product when any item sells out, if Checked ALL Purchase Limits must be the same.', 'edd-purchase-limit' );

   }

   return $translated;
}
add_filter( 'gettext', 'pw_edd_checkout_text', 10, 3 );




 // output our custom field HTML
function anagram_edd_custom_checkout_fields() {
global $user_ID;
	?>
	<p>
		<input class="edd-input" type="text" name="edd_student_id" id="edd_student_id" disabled value="<?php echo get_user_meta( $user_ID, 'student_id', true ); ?>"/>
		<label class="edd-label" for="edd_student_id">Student ID</label>
	</p>
	<?php
}
//add_action('edd_purchase_form_user_info', 'anagram_edd_custom_checkout_fields');


// create the HTML for the custom template
function anagram_add_login_note() {

	echo '<h5>Please login here if you already have an account.</h5>';


}
add_action('edd_purchase_form_top', 'anagram_add_login_note');

// create the HTML for the custom template
function anagram_edd_custom_email_template() {

	echo '<div style="width: 550px; border: 1px solid #1e79c0; background: #ddd; padding: 8px 10px; margin: 0 auto;">';
		echo '<div id="edd-email-content" style="background: #f0f0f0; border: 1px solid #9ac7e1; padding: 10px;">';
			echo '{email}'; // this tag is required in order for the contents of the email to be shown
		echo '</div>';
	echo '</div>';


}
//add_action('edd_email_template_my_custom_template', 'anagram_edd_custom_email_template');

// register the custom email template
function anagram_edd_get_email_templates( $templates ) {

	$templates['my_custom_template'] = 'User Receipt';

	return $templates;
}
//add_filter('edd_email_templates', 'anagram_edd_get_email_templates');



 /*
 * Get ticket Limit custom function
 */
function anagram_get_total_ticket_limit( $download_id ) {
	$remaining = 0;
	$variable_pricing = edd_has_variable_prices( $download_id );
	if (  $variable_pricing ){
		$prices = apply_filters( 'edd_purchase_variable_prices', edd_get_variable_prices( $download_id ), $download_id );
		if ( $prices ) {

			foreach ( $prices as $key => $price ) {
				$purchased = edd_pl_get_file_purchases( $download_id, $key );
				$limit[] = edd_pl_get_file_purchase_limit( $download_id, 'variable', $key )-$purchased;
			}



			$grouped_limit  = get_post_meta( $download_id, '_edd_purchase_limit_variable_disable', true );
			$var_count = count($prices);
			if($grouped_limit && !get_post_meta( $download_id, '_edd_price_options_mode', true ) ){
				$remaining = min( $limit );
			}else{
				$remaining = array_sum ( $limit );
			};


		}

	}else{
		//if NOT varieble product
		$purchased = edd_get_download_sales_stats($download_id);
		$limit = edd_pl_get_file_purchase_limit( $download_id );
		//if($limit===0) return 'Unlimited';
		$remaining = $limit-$purchased;

	};

	return $remaining;
}



/**
 * Variable price output
 *
 *   Attempting to bring input outside of label.
 *
 * @since 1.2.3
 * @param int $download_id Download ID
 * @return void
 */
function anagram_edd_purchase_variable_pricing( $download_id = 0, $args = array() ) {
	$variable_pricing = edd_has_variable_prices( $download_id );

	if ( ! $variable_pricing ) {
		return;
	}

	$prices = apply_filters( 'edd_purchase_variable_prices', edd_get_variable_prices( $download_id ), $download_id );

	// If the price_id passed is found in the variable prices, do not display all variable prices.
	if ( false !== $args['price_id'] && isset( $prices[ $args['price_id'] ] ) ) {
		return;
	}

	$type   = edd_single_price_option_mode( $download_id ) ? 'checkbox' : 'radio';
	$mode   = edd_single_price_option_mode( $download_id ) ? 'multi' : 'single';
	$schema = edd_add_schema_microdata() ? ' itemprop="offers" itemscope itemtype="http://schema.org/Offer"' : '';

	if ( edd_item_in_cart( $download_id ) && ! edd_single_price_option_mode( $download_id ) ) {
		return;
	}

	do_action( 'edd_before_price_options', $download_id ); ?>
	<div class="edd_price_options radio edd_<?php echo esc_attr( $mode ); ?>_mode">
		<ul>
			<?php
			if ( $prices ) :
				$checked_key = isset( $_GET['price_option'] ) ? absint( $_GET['price_option'] ) : edd_get_default_variable_price( $download_id );
				foreach ( $prices as $key => $price ) :
					echo '<li id="edd_price_option_' . $download_id . '_' . sanitize_key( $price['name'] ) . '"' . $schema . '>';

					echo '<input type="' . $type . '" ' . checked( apply_filters( 'edd_price_option_checked', $checked_key, $download_id, $key ), $key, false ) . ' name="edd_options[price_id][]" id="' . esc_attr( 'edd_price_option_' . $download_id . '_' . $key ) . '" class="' . esc_attr( 'edd_price_option_' . $download_id ) . '" value="' . esc_attr( $key ) . '" data-price="' . edd_get_price_option_amount( $download_id, $key ) .'"/>&nbsp;';
						echo '<label for="'	. esc_attr( 'edd_price_option_' . $download_id . '_' . $key ) . '">';

							echo '<span class="edd_price_option_name" itemprop="description">' . esc_html( $price['name'] ) . '</span><span class="edd_price_option_sep">&nbsp;&ndash;&nbsp;</span><span class="edd_price_option_price" itemprop="price">' . edd_currency_filter( edd_format_amount( $price['amount'] ) ) . '</span>';
						echo '</label>';
						do_action( 'edd_after_price_option', $key, $price, $download_id );
					echo '</li>';
				endforeach;
			endif;
			do_action( 'edd_after_price_options_list', $download_id, $prices, $type );
			?>
		</ul>
	</div><!--end .edd_price_options-->
<?php
	do_action( 'edd_after_price_options', $download_id );
}
//add_action( 'edd_purchase_link_top', 'anagram_edd_purchase_variable_pricing', 10, 1 );
//remove_action( 'edd_purchase_link_top', 'edd_purchase_variable_pricing', 10, 1 );



 /*
 * Convert variable prices from radio buttons to a dropdown
 */
function shoestrap_edd_purchase_variable_pricing( $download_id ) {
	$variable_pricing = edd_has_variable_prices( $download_id );
	if ( ! $variable_pricing )
		return;
	$prices = apply_filters( 'edd_purchase_variable_prices', edd_get_variable_prices( $download_id ), $download_id );
	$type   = edd_single_price_option_mode( $download_id ) ? 'checkbox' : 'radio';
	do_action( 'edd_before_price_options', $download_id );
	echo '<div class="edd_price_options">';
		if ( $prices ) {
			echo '<select name="edd_options[price_id][]">';
			foreach ( $prices as $key => $price ) {
				printf(
					'<option for="%3$s" name="edd_options[price_id][]" id="%3$s" class="%4$s" value="%5$s" %7$s> %6$s</option>',
					checked( 0, $key, false ),
					$type,
					esc_attr( 'edd_price_option_' . $download_id . '_' . $key ),
					esc_attr( 'edd_price_option_' . $download_id ),
					esc_attr( $key ),
					esc_html( $price['name'] . ' - ' . edd_currency_filter( edd_format_amount( $price[ 'amount' ] ) ) ),
					selected( isset( $_GET['price_option'] ), $key, false )
				);
				do_action( 'edd_after_price_option', $key, $price, $download_id );
			}
			echo '</select>';
		}
		do_action( 'edd_after_price_options_list', $download_id, $prices, $type );
	echo '</div><!--end .edd_price_options-->';
	do_action( 'edd_after_price_options', $download_id );
}
//add_action( 'edd_purchase_link_top', 'shoestrap_edd_purchase_variable_pricing', 10, 1 );
//remove_action( 'edd_purchase_link_top', 'edd_purchase_variable_pricing', 10, 1 );




add_action('plugins_loaded', 'edd_loaded');
function edd_loaded() {

  add_filter('gettext', 'remove_admin_stuff', 20, 3);

  if (!defined('EDD_DISABLE_ARCHIVE')) {
    define('EDD_DISABLE_ARCHIVE', false);
  }
  if (!defined('EDD_DISABLE_REWRITE')) {
    define('EDD_DISABLE_REWRITE', false);
  }
  if (!defined('EDD_SLUG')) {
    define('EDD_SLUG', 'store');
  }
}
add_filter('edd_download_post_type_args', 'disable_archives');
add_action('template_redirect', 'download_redirect_post');
function disable_archives($download_args) {
  $download_args['has_archive'] = false;
  $download_args['rewrite'] = false;
  return $download_args;
}
function download_redirect_post() {
  $queried_post_type = get_query_var('post_type');
  if (is_single() && 'download' == $queried_post_type) {
    $redirectto = home_url();

    $event_link = anagram_get_related_event_from_download(get_the_ID(), false, true);
    if($event_link)$redirectto = $event_link;

    wp_redirect($redirectto , 301);
    exit;
  }
}


function remove_admin_stuff($translated_text, $untranslated_text, $domain) {
  if (get_current_post_type() !== 'download') {
    return $untranslated_text;
  }
  switch ($untranslated_text) {

	/*
		  case 'Download Name':
      $translated_text = __('Product Name', 'custom_edd_alol');
      break;

      case 'Files':
      $translated_text = __('Files', 'custom_edd_alol');
      break;

      case 'Easy Digital Downloads Sales Summary':
      $translated_text = __('Sales Summary', 'custom_edd_alol');
      break;

      case 'Disable product when any item sells out':
      $translated_text = __('Disable product when any item sells out, if Checked ALL Purchase Limits must be the same.', 'custom_edd_alol');
      break;


    case 'Show all tags':
      $translated_text = __('Show all Arrangement Types', 'custom_edd_alol');
      break;
    case 'Show all categories':
      $translated_text = __('Show all Band & Instrument(s)', 'custom_edd_alol');
      break;
    case 'Arrangement Tags':
      $translated_text = __('Arrangement Types', 'custom_edd_alol');
      break;
    case 'Search Categories':
      $translated_text = __('Search Band & Instrument(s)', 'custom_edd_alol');
      break;
    case 'Search Tags':
      $translated_text = __('Search Arrangement Types', 'custom_edd_alol');
      break;
    case 'Popular Tags':
      $translated_text = __('Popular Arrangement Types', 'custom_edd_alol');
      break;
    case 'Add New Category':
      $translated_text = __('Add New Band & Instrument(s)', 'custom_edd_alol');
      break;
    case 'Add New Tag':
      $translated_text = __('Add New Arrangement Type', 'custom_edd_alol');
      break;
    case 'Tags':
      $translated_text = __('Arrangement Type', 'custom_edd_alol');
      break;
    case 'Category':
    case 'Categories':
      $translated_text = __('Band & Instrument(s)', 'custom_edd_alol');
      break;
    case 'Download Tags':
      $translated_text = __('Arrangement Type', 'custom_edd_alol');
      break;
    case 'Arrangement Categories':
      $translated_text = __('Band & Instrument(s)', 'custom_edd_alol');
      break;
    case 'File Downloads:':
      $translated_text = "";
      break;
      //add more items
*/


  }

  return $translated_text;
}


//add_action('edd_download_file_table_row', 'output_nounce');
function output_nounce() {
  echo wp_nonce_field('metabox.php', 'edd_download_meta_box_nonce');
}





add_filter('edd_download_supports', 'edd_supports');
function edd_supports($supports) {
  return array(
    'title',
    'revisions'
  );
}

//Removes the download type, single or download
remove_action('edd_meta_box_files_fields', 'edd_render_product_type_field', 10);

add_action('do_meta_boxes', 'remove_download_meta_box');
function remove_download_meta_box() {
  	remove_meta_box( 'tagsdiv-download_tag', 'download', 'side' );
  	//remove_meta_box( 'edd_product_settings', 'download', 'side' );
  	remove_meta_box( 'edd_product_files', 'download', 'normal' );
  	//global $wp_meta_boxes;
  	//$wp_meta_boxes['download']['side']['core']['download_categorydiv']['title'] = 'Band & Instrument(s)';
  	//$wp_meta_boxes['download']['side']['core']['tagsdiv-download_tag']['title'] = 'Arrangement Type';
}



/*
add_action('admin_menu', 'edd_menu_items', 10);
function edd_menu_items() {
  global $edd_upgrades_screen;
  $edd_upgrades_screen = add_submenu_page(null, __('EDD Upgrades', 'edd') , __('EDD Upgrades', 'edd') , 'install_plugins', 'edd-upgrades', 'edd_upgrades_screen');
}
*/
/*
add_filter('edd_download_columns', 'remove_columns');
function remove_columns($columns) {
  //unset($columns['price']);
  //unset($columns['sales']);
  unset($columns['earnings']);
  unset($columns['shortcode']);
  return $columns;
}
*/
//remove_action('admin_menu', 'edd_add_options_link', 10);

/*
function edd_add_download_meta_boxes() {

  $post_types = apply_filters('edd_download_metabox_post_types', array(
    'download'
  ));

  foreach ($post_types as $post_type) {
    // Product Files (and bundled products)
    add_meta_box('edd_product_files', sprintf(__('%1$s Files', 'edd') , edd_get_label_singular() , edd_get_label_plural()) , 'edd_render_files_meta_box', $post_type, 'normal', 'high');
  }
}
*/
//remove_action('add_meta_boxes', 'edd_add_download_meta_box');
//add_action('add_meta_boxes', 'edd_add_download_meta_boxes');



/*
function get_current_post_type() {
  global $post, $typenow, $current_screen;
  //we have a post so we can just get the post type from that
  if ($post && $post->post_type) return $post->post_type;
  //check the global $typenow - set in admin.php
  elseif ($typenow) return $typenow;
  //check the global $current_screen object - set in sceen.php
  elseif ($current_screen && $current_screen->post_type) return $current_screen->post_type;
  //lastly check the post_type querystring
  elseif (isset($_REQUEST['post_type'])) return sanitize_key($_REQUEST['post_type']);
  //we do not know the post type!
  return null;
}

add_action('admin_head', 'edd_css');
function edd_css() {
  if (get_current_post_type() !== 'download') {
    return;
  }
  echo "<style>.nosubsub h2{ display: none !important; } .wrap { margin: 0 0 0 20 !important; } </style>";
}
*/
