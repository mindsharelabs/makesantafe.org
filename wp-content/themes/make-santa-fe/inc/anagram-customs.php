<?php

/**
 * Custom functions for Theme
 */


function anagramLoadFile($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}



add_action( 'rest_api_init', 'prefix_register_product_routes' );

function prefix_register_product_routes() {
	register_rest_route( 'makesantafe', '/info', array(
         'methods'  => WP_REST_Server::READABLE,
         'callback' => 'prefix_get_makerspace_info',
    ));
}

function prefix_get_makerspace_info( $request_data ) {

    $makeinfo = array(
	"api"=> "1.1",
    "space"=> "MAKE Santa Fe",
    "logo"=> "https://makesantafe.org/wp-content/uploads/2016/04/MAKE-santa-fe-black.png",
    "url"=> "https://makesantafe.org",
    "location" => array(
        "address"=> "2879 All Trades Rd. Santa Fe, NM 87507",
        "lon"=> -105.993281,
        "lat"=> 35.662149
    ),
    "contact"=> array (
	     "email"=> "build@makesantafe.org",
        "twitter"=> "@makesantafe"
    ),
    "issue_report_channels"=> array (
        "email"
    ),
    "state"=> array (
        "open"=> true,

    ),
    "open"=> true,
     "icon"=> array(
	        "open" =>"https: //upload.wikimedia.org/wikipedia/commons/f/fb/Yes_check.svg",
	        "closed" => "https: //upload.wikimedia.org/wikipedia/commons/a/a2/X_mark.svg"
	    )


    );

    return rest_ensure_response( $makeinfo );

}



//http://www.kvcodes.com/2015/04/wordpress-clone-user-role-to-create-new-role/
//http://nazmulahsan.me/clone-or-add-new-user-roles/
add_action('init', 'cloneUserRole');
function cloneUserRole()
{
 global $wp_roles;
 if (!isset($wp_roles))
 $wp_roles = new WP_Roles();
 $adm = $wp_roles->get_role('subscriber');
 // Adding a new role with all admin caps.
 $wp_roles->add_role('member', 'Member', $adm->capabilities);
 $wp_roles->add_role('volunteer', 'Volunteer', $adm->capabilities);
  $wp_roles->add_role('member-other', 'Member - Other', $adm->capabilities);
  //remove_role( 'member-free' );
}


function anagram_is_member() {
    global $current_user;
	$allowed = array('volunteer','member','administrator','editor','shop_manager','member-other');
		$user_roles = $current_user->roles;
	if( array_intersect ( $user_roles , $allowed  ) ){
	    return true;
    }else{
	    return false;
    }

}

function auth_redirect_login() {
			global $post;
			$user = wp_get_current_user();
			if ( !( $post->post_name=='login' || $post->post_name=='lost-password' || $post->post_name=='reset-password' ) && !current_user_can('edit_posts') ) {
					nocache_headers();
					wp_redirect(wp_login_url());
					exit();
			}
}





/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
    function post_is_in_descendant_category( $cats, $_post = null ) {
        foreach ( (array) $cats as $cat ) {
            // get_term_children() accepts integer ID only
            $descendants = get_term_children( (int) $cat, 'download_category' );
            if ( $descendants &&  has_term( $descendants, 'download_category', $_post  ) )
                return true;
        }
        return false;
    }
}

/* Add image to gallery from gforms*/


//* the the default upload path to work in normal WP structure
add_filter("gform_upload_path", "change_upload_path", 20, 2);
function change_upload_path($path_info, $form_id){
	$wp_upload_path = wp_upload_dir();
    $path_info["path"] = $wp_upload_path['path'] . '/';
    $path_info["url"] = $wp_upload_path['url'] . '/';
    return $path_info;
}
/**
 * Create the image attachment and return the new media upload id.
 * @based on: http://codex.wordpress.org/Function_Reference/wp_insert_attachment#Example
 * @since 2.0.0
 * 		now includes thumbnail processing and better path logic
 */
function jdn_create_image_id( $image_url, $parent_post_id = null ) {
	if( !isset( $image_url ) )
		return false;
	global $_wp_additional_image_sizes;
	// Cache info on the wp uploads dir
	$wp_upload_dir = wp_upload_dir();
	// get the file path
	$path = parse_url( $image_url, PHP_URL_PATH );
	// File base name
	$file_base_name = basename( $image_url );
	$uploaded_file_path = ABSPATH . $path;
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( $file_base_name, null );
	// error check
	if( !empty( $filetype ) && is_array( $filetype ) ) {
		// Create attachment title
		$post_title = preg_replace( '/\.[^.]+$/', '', $file_base_name );

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $uploaded_file_path ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => esc_attr( $post_title ),
			'post_content'   => '',
			//'post_parent'   => $parent_post_id,
			'post_status'    => 'inherit'
		);

		// Set the post parent id if there is one
		if( !is_null( $parent_post_id ) )
			$attachment['post_parent'] = $parent_post_id;
		foreach( get_intermediate_image_sizes() as $s ) {
			$sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => true );
			if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ) {
    	  		$sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
    	  		$sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
    	  		$sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options

    	  	}
    	  	if( isset( $_wp_additional_image_sizes[ $s ] ) ) {
                $sizes[ $s ] = array(
                	'width' => $_wp_additional_image_sizes[ $s ]['width'],
                    'height' => $_wp_additional_image_sizes[ $s ]['height'],
                    'crop' =>  $_wp_additional_image_sizes[ $s ]['crop'],
                    );
            }

    	}
    	$sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );
    	foreach( $sizes as $size => $size_data ) {
    	  	$resized = image_make_intermediate_size( $uploaded_file_path, $size_data['width'], $size_data['height'], $size_data['crop'] );
    	 	if ( $resized )
    	    	$attachment['sizes'][$size] = $resized;
    	}
		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $uploaded_file_path );
		//Error check
		if( !is_wp_error( $attach_id ) ) {
			//Generate wp attachment meta data
			if( file_exists( ABSPATH . 'wp-admin/includes/image.php') && file_exists( ABSPATH . 'wp-admin/includes/media.php') ) {
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file_path );
				wp_update_attachment_metadata( $attach_id, $attach_data );
			} // end if file exists check
		} // end if error check
		return $attach_id;
	} else {
		return false;
	} // end if $$filetype
} // end function get_image_id

 /**
  * Attach images uploaded through Gravity Form to ACF Gallery Field
  *
  * @author Joshua David Nelson, josh@joshuadnelson.com
  * @return void
  */
//$gravity_form_id = 1; // gravity form id, or replace {$gravity_form_id} below with this number

 /**
  * Attach images uploaded through Gravity Form to ACF Gallery Field
  *
  * @author Joshua David Nelson, josh@joshuadnelson.com
  * @return void
  */
add_filter( "gform_after_submission_18", 'jdn_set_post_acf_gallery_field', 10, 2 );
function jdn_set_post_acf_gallery_field( $entry, $form ) {

	$gf_images_field_id = 2; // the upload field id
	$acf_field_id = 'field_58aa4405b0eec'; // the acf gallery field id
	$post_id = 4894;
	$gallery = wp_list_pluck( get_field('member_gallery'), 'ID' );

	// Clean up images upload and create array for gallery field
	if( isset( $entry[ $gf_images_field_id ] ) ) {
		$images = stripslashes( $entry[ $gf_images_field_id ] );
		$images = json_decode( $images, true );
		if( !empty( $images ) && is_array( $images ) ) {
			foreach( $images as $key => $value ) {
				// NOTE: this is the other function you need: https://gist.github.com/joshuadavidnelson/164a0a0744f0693d5746
				if( function_exists( 'jdn_create_image_id' ) )
					$image_id = jdn_create_image_id( $value, $post_id );

				if( $image_id ) {
					$gallery[] = $image_id;
				}
			}
		}
	}

	// Update gallery field with array
	if( ! empty( $gallery ) ) {
		update_field( $acf_field_id, $gallery, $post_id );

	}
}



 /*

	 Theme my login functions
 */
 function tml_registration_errors( $errors ) {
	if ( empty( $_POST['first_name'] ) )
		$errors->add( 'empty_first_name', '<br/><strong>ERROR</strong>: Please enter your first name.' );
	if ( empty( $_POST['last_name'] ) )
		$errors->add( 'empty_last_name', '<br/><strong>ERROR</strong>: Please enter your last name.' );
	return $errors;
}
add_filter( 'registration_errors', 'tml_registration_errors' );

 function tml_user_register( $user_id ) {
	if ( !empty( $_POST['first_name'] ) )
		update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
	if ( !empty( $_POST['last_name'] ) )
		update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
}
add_action( 'user_register', 'tml_user_register' );




function shadeColor ($color, $percent) {

  $color = str_replace("#",Null,$color);

  $r = Hexdec(Substr($color,0,2));
  $g = Hexdec(Substr($color,2,2));
  $b = Hexdec(Substr($color,4,2));

  $r = (Int)($r*(100+$percent)/100);
  $g = (Int)($g*(100+$percent)/100);
  $b = (Int)($b*(100+$percent)/100);

  $r = Trim(Dechex(($r<255)?$r:255));
  $g = Trim(Dechex(($g<255)?$g:255));
  $b = Trim(Dechex(($b<255)?$b:255));

  $r = ((Strlen($r)==1)?"0{$r}":$r);
  $g = ((Strlen($g)==1)?"0{$g}":$g);
  $b = ((Strlen($b)==1)?"0{$b}":$b);

  return (String)("#{$r}{$g}{$b}");
}



function filter_search($query) {
    if ($query->is_search) {
	$query->set('post_type', array('post','page', 'event','downloads'));
    };
    return $query;
};
//add_filter('pre_get_posts', 'filter_search');



add_filter('wp_nav_menu_items','add_search_box_to_menu', 10, 2);
function add_search_box_to_menu( $items, $args ) {
    if( $args->theme_location == 'primary' )
        return $items.'<li class="hidden-xs">'.get_search_form(false).'</li>';

    return $items;
}


function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function custom_admin_head() {
  $css = '';

  $css = 'td.media-icon img[src$=".svg"] { width: 100% !important; height: auto !important; }';

  echo '<style type="text/css">'.$css.'</style>';
}
add_action('admin_head', 'custom_admin_head');

//http://codex.wordpress.org/Function_Reference/get_allowed_mime_types
function anagram_allowed_myme_types($mime_types){
    //Creating a new array will reset the allowed filetypes
    $mime_types = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'pdf' => 'application/pdf',
        'mp3|m4a|m4b' => 'audio/mpeg',
        'zip' => 'application/zip',
		'gz|gzip' => 'application/x-gzip',
		'rar' => 'application/rar',
        //'bmp' => 'image/bmp',
        //'tif|tiff' => 'image/tiff'
    );
    return $mime_types;
}
add_filter('upload_mimes', 'anagram_allowed_myme_types', 1, 1);

function anagram_remove_myme_types($mime_types){
    $mime_types['avi'] = 'video/avi'; //Adding avi extension
    unset($mime_types['pdf']); //Removing the pdf extension
    return $mime_types;
}
//add_filter('upload_mimes', 'anagram_remove_myme_types', 1, 1);


//add_action( 'admin_init', 'anagram_block_users_from_uploading_small_images' );

function anagram_block_users_from_uploading_small_images()
{
    //if( !current_user_can( 'administrator') )
        add_filter( 'wp_handle_upload_prefilter', 'anagram_block_small_images_upload' );
}



/**
 * Attach a class to linked to large iamge and adding rel attr
 * e.g. a img => a.img img
 */
function give_linked_images_class($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){

  // check if there are already classes assigned to the anchor
  if ( preg_match('/<a.*?>/', $html) ) {
	  $image = wp_get_attachment_image_src( $id, 'large' );
	  $html = preg_replace('/<a(.*?)>/', '<a href=\'' . $image[0] . '\' rel="lightbox">', $html);
  }
  return $html;
}
add_filter('image_send_to_editor','give_linked_images_class',10,8);




function anagram_get_event_dates($ID){

		 $today = strtotime(date('Ymd'));
			$dateclean ='';

			$recurring_dates = get_field('recurring_dates');

	    foreach($recurring_dates  as $event){
		    $start_date = strtotime($event['date']);
		    if( !($start_date>=$today ))continue;

		    $dateclean .= '<div class="sub_field">'.date("M jS, Y @ g:ia", $start_date ).'</div>';
	    }


			$value = $dateclean;

			if(empty($value)){
				//$last_date = end($originalvalue);
				//$value = '<div class="sub_field">'.date("M jS, Y @ g:ia", $last_date["field_55a00a0df52d2"]).'</div>';
				$value = 'Past Event';
				};

				return $value;

}



function my_acf_load_value( $value, $post_id, $field ) {

	// vars
	$order = array();


	// bail early if no value
	if( empty($value) ) {

		return $value;

	}


	// populate order
	foreach( $value as $i => $row ) {

		$order[ $i ] = $row['field_55a00a0df52d2'];

	}


	// multisort
	array_multisort( $order, SORT_DESC, $value );


	// return
	return $value;

}

add_filter('acf/load_value/name=recurring_dates', 'my_acf_load_value', 10, 3);




/**
 * Display text notifying the user that no image is available
 *
 */
function display_subscription_status( $value, $object_id, $column, $storage_key ) {

    if ( 'active_member' == $column->options->field ) {

	$subscriber = new EDD_Recurring_Subscriber( $object_id, true );
	$has_access = $subscriber->has_active_subscription();
	$this_user = get_user_by('id', $object_id);
	if($has_access){
			if(in_array("subscriber", $this_user->roles)){
				wp_update_user(array('ID' => $object_id,'role' => 'member'));
			};
			update_user_meta($object_id, 'active_member', 1);
			//update_field('field_57a294b20da0d', '1', $id);

		}else{
			if(in_array("member", $this_user->roles)){
				wp_update_user(array('ID' => $object_id,'role' => 'subscriber'));
			};
			update_user_meta($object_id, 'active_member', 0);
		}

    }


	return $value;
}
//add_filter( 'cac/column/value/user', 'display_subscription_status', 10, 4 ); // Columns on the user overview page



/**
 * Filter the display value for a column
 *
 * @param mixed $value Custom field value
 * @param int $id Object ID
 * @param AC_Column $column Column instance
 */

function anagram_custom_date_display_columns( $value, $id, $column ) {
	if ( 'column-acf_field' == $column->get_type() ) {
		$acf_key = $column->get_setting( 'field' )->get_value(); // Gets the stored ACF key for the stored column
		$acf_field = get_field_object( $acf_key ); // Gets an ACF object based on the ACF Key

		if ( 'repeater' == $acf_field['type'] ) {

			$today = strtotime(date('Ymd'));
			$dateclean ='';
		    foreach($acf_field['value'] as $date){
			    $start_date = strtotime($date['date']);
			    if( !($start_date>=$today ))continue;
			    $dateclean .= '<div class="sub_field">'.date("M jS, Y @ g:ia", $start_date).'</div>';
		    }
			$value = $dateclean;
			if(empty($value)){
				$value = 'Past Event';
			};

			// Alter the value to your likings
		}
	}

	return $value;
}

add_filter( 'ac/column/value', 'anagram_custom_date_display_columns', 10, 3 );





//custom status Artwork Edition
function edition_custom_post_status(){
     register_post_status( 'past', array(
          'label'                     => _x( 'Past', 'download' ),
          'public'                    => true,
          'show_in_admin_all_list' 	  => true,
          'exclude_from_search'       => false,
          'show_in_admin_status_list' => true,
          'label_count'               => _n_noop( 'Past <span class="count">(%s)</span>', 'Past <span class="count">(%s)</span>' )
     ) );
}
//add_action( 'init', 'edition_custom_post_status' );

//add_action('admin_footer-post.php', 'edition_append_post_status_list');
function edition_append_post_status_list(){
     global $post;
     $complete = '';
     $label = '';
     if(in_array($post->post_type, array('download')) == true){
          if($post->post_status == 'past'){
               $complete = ' selected=\"selected\"';
               $label = '<span id=\"post-status-display\"> Past</span>';
          }
          echo '
          <script>
          jQuery(document).ready(function($){
               $("select#post_status").append("<option value=\"past\" '.$complete.'>Past</option>");
               $(".misc-pub-section label").append("'.$label.'");
          });
          </script>
          ';
     }
}
function edition_display_archive_state( $states ) {
     global $post;
     $arg = get_query_var( 'post_status' );
     if($arg != 'past'){
          if($post->post_status == 'past'){
               return array('Past');
          }
     }
    return $states;
}
//add_filter( 'display_post_states', 'edition_display_archive_state' );

function edition_append_post_status_bulk_edit() {

echo '<script>
jQuery(document).ready(function($){
	$(".inline-edit-status select ").append("<option value=\"past\">Past</option>");
});
</script>';

}
//add_action( 'admin_footer-edit.php', 'edition_append_post_status_bulk_edit' );


/**
 * anagram_do_map function.
 *
 * @access public
 * @param mixed $imgargs
 * @return void
 */
 add_shortcode('anagram_map', 'anagram_do_map');
function anagram_do_map($atts){

	   extract(shortcode_atts(array(
	      'name' => '',
	      'address' => '',
	      'lat' => '',
	      'lng' => '',
	      'icon' => '',
	      'geo' => false,
	      'zoom' => 16,
	      'multiple' => false,
	      'directions' => false,
	      'showpopup' => false
	   ), $atts));


	  // $instance = 'mapbox_'.rand();


		wp_enqueue_style( 'anagram-mapbox-css', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css' );
		wp_enqueue_script('anagram-mapbox', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js', array('jquery'), '1.0', true);


		wp_enqueue_script('anagram-mapbox-directions', 'https://api.tiles.mapbox.com/mapbox.js/plugins/mapbox-directions.js/v0.3.0/mapbox.directions.js', array('jquery'), '1.0', true);
		wp_enqueue_style( 'anagram-mapbox-directions-css', 'https://api.tiles.mapbox.com/mapbox.js/plugins/mapbox-directions.js/v0.3.0/mapbox.directions.css' );


		wp_enqueue_script('anagram-mapcode', (get_template_directory_uri()."/js/anagram-mapcode.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/anagram-mapcode.js'), true);

		wp_localize_script('anagram-mapcode', 'mapvars' . $instance, array(
		  		  'name' => $name,
			      'address' => $address,
			      'lat' => $lat,
			      'lng' => $lng,
			      'icon' => $icon,
			      'geo' => $geo,
			      'zoom' => $zoom,
			      'multiple' => $multiple,
			      'directions' => $directions,
			      'showpopup' => $showpopup
		)
);
$content = '<div id="mapbox"></div>';
/*
$content .= "<div id='inputs'></div>
<div id='errors'></div>
<div id='directions'>
  <div id='routes'></div>
  <div id='instructions'></div>
</div>
<style>
#inputs,
#errors,
#directions {
    position: absolute;
    width: 33.3333%;
    max-width: 300px;
    min-width: 200px;
}

#inputs {
    z-index: 10;
    top: 10px;
    left: 10px;
}

#directions {
    z-index: 99;
    background: rgba(0,0,0,.8);
    top: 0;
    right: 0;
    bottom: 0;
    overflow: auto;
}

#errors {
    z-index: 8;
    opacity: 0;
    padding: 10px;
    border-radius: 0 0 3px 3px;
    background: rgba(0,0,0,.25);
    top: 90px;
    left: 10px;
}

</style>

";
*/

  return $content;
}



add_filter( 'get_the_archive_title', function ( $title ) {

    if( is_category() ) {

        $title = sprintf( single_cat_title( '', false ) );

	 } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $tax = get_taxonomy( get_queried_object()->taxonomy );
        /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
        $title = single_term_title( '', false );
    }else{
        $title = get_the_title( get_option( 'page_for_posts' ) );
    }

    return $title;

});


/**
 * anagram_block_small_images_upload function.
 *
 * @access public
 * @param mixed $file
 * @return void
 */
function anagram_block_small_images_upload( $file )
{
    // Mime type with dimensions, check to exit earlier
    $mimes = array( 'image/jpeg', 'image/png', 'image/gif' );

    if( !in_array( $file['type'], $mimes ) )
        return $file;

    $img = getimagesize( $file['tmp_name'] );
    $minimum = array( 'width' => 1200 );
    //$minimum = array( 'width' => 1200, 'height' => 480 );

    if ( $img[0] < $minimum['width'] )
        $file['error'] =
            'Image too small. Minimum width is '
            . $minimum['width']
            . 'px. Uploaded image width is '
            . $img[0] . 'px';

/*
    elseif ( $img[1] < $minimum['height'] )
        $file['error'] =
            'Image too small. Minimum height is '
            . $minimum['height']
            . 'px. Uploaded image height is '
            . $img[1] . 'px';
*/

    return $file;
}


add_filter( 'user_contactmethods', 'tgm_io_custom_contact_info' );
/**
 * Removes legacy contact fields and adds support for LinkedIn.
 *
 * @param array $fields  Array of default contact fields.
 * @return array $fields Amended array of contact fields.
 */
function tgm_io_custom_contact_info( $fields ) {

    // Remove the old, unused fields.
    //unset( $fields['aim'] );
    //unset( $fields['yim'] );
    //unset( $fields['jabber'] );

    // Add LinkedIn.
    $fields['title'] = __( 'Title' );

    // Return the amended contact fields.
    return $fields;

}



/* Remove attachment meta boxes */
function anagram_remove_metaboxes() {
/*
	remove_meta_box( 'artistdiv', 'artwork', 'side' );
	remove_meta_box( 'media_collectiondiv', 'artwork', 'side' );
	remove_meta_box( 'repositorydiv', 'artwork', 'side' );
	remove_meta_box( 'tagsdiv-medium', 'artwork', 'side' );
*/

	remove_meta_box( 'event_catdiv', 'event', 'side' );
	remove_meta_box( 'event_locdiv', 'event', 'side' );

/*
	remove_meta_box( 'tagsdiv-media_subject', 'artwork', 'side' );

	remove_meta_box( 'sponsor_leveldiv', 'sponsor', 'default' );
*/

	//Remove Members box
/*
	  remove_meta_box( 'uma_post_access', 'post', 'side' );
	  remove_meta_box( 'uma_post_access', 'exhibition', 'side' );
	  remove_meta_box( 'uma_post_access', 'press', 'side' );
	  remove_meta_box( 'uma_post_access', 'event', 'side' );
	  remove_meta_box( 'uma_post_access', 'artwork', 'side' );
	  remove_meta_box( 'uma_post_access', 'sponsor', 'side' );
*/


}

add_action( 'admin_menu' , 'anagram_remove_metaboxes' , 9999 );



function remove_parent_classes($class)
{
  // check for current page classes, return false if they exist.
	return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item') ? FALSE : TRUE;
}



/**
 * Adds active menu item to pages for child single post types
 */
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 2);
function my_css_attributes_filter($classes,$item) {

	//push page name to menu
	//array_push($classes,  'menu-item-'.sanitize_title($item->title) );

	$pt = get_post_type();

	//remove blog post from beging highlighted
	if( is_author() ) {


			//$classes = array_filter($classes, "remove_parent_classes");
		// add the current page class to a specific menu item (replace ###).
		if (in_array('menu-item-makers', $classes))
		{
			array_push($classes, 'current-menu-item current_page_item active');
		}

/*
		if (in_array('menu-item-people', $classes))
		{
			array_push($classes, 'current-menu-item current_page_item active');
		}
*/


/*

		global $post;
			 $page = get_page_by_title( $item->title, OBJECT, 'collection' );
			 $parent_id = $post->post_parent;
			// var_dump($parent_id);
			        // check if slug matches post_name
        if(  $parent_id!=0 && $parent_id == $page->ID) {
            $classes[] = 'current_page_parent';
        }
*/

	} elseif( $pt == 'program' ) {


			//$classes = array_filter($classes, "remove_parent_classes");
		// add the current page class to a specific menu item (replace ###).
		if (in_array('menu-item-academy-programs', $classes))
		{
			array_push($classes, 'current-menu-item current_page_item active');
		}
/*

		global $post;
			 $page = get_page_by_title( $item->title, OBJECT, 'collection' );
			 $parent_id = $post->post_parent;
			// var_dump($parent_id);
			        // check if slug matches post_name
        if(  $parent_id!=0 && $parent_id == $page->ID) {
            $classes[] = 'current_page_parent';
        }
*/

	}elseif( $pt == 'event' ) {
		if (in_array('menu-item-learn', $classes))
		{
			array_push($classes, 'current-menu-item current_page_item active');
		}

			//$classes = array_filter($classes, "remove_parent_classes");



	} elseif( $pt == 'post' ) {
		// $classes = array_filter($classes, "remove_parent_classes");
		// add the current page class to a specific menu item (replace ###).
		if (in_array('menu-item-news', $classes))
		{
			array_push($classes, 'current-menu-item current_page_item active');
		}
	}


	return $classes;

}




add_action( 'template_redirect', 'anagram_redirect_to' );

function anagram_redirect_to(){

	  global $post;

/*
    is_singular( 'press' )
	and wp_redirect( home_url( '/press-room/' ), 301 )
    and exit;

    is_singular( 'foundation' )
	and wp_redirect( home_url( '/supporter/foundation-council/' ), 301 )
    and exit;


    is_singular( 'business' )
	and wp_redirect( home_url( '/supporter/business/' ), 301 )
    and exit;
*/

/*
	if ( is_tax( 'event-location' ) ) {
		wp_redirect( home_url( '/events-workshops/' ), 301 )
    and exit;

	};
*/


/*
    is_tax( array('medium','artist','media_subject') )
    and wp_redirect( home_url( '/collections/' ), 301 )
    and exit;
*/

/*
    is_tax( 'exhibit_cat' )
    and wp_redirect( home_url( '/exhibitions/' ), 301 )
    and exit;
*/

/*
    is_tax( 'exhibit_cat' )
    and wp_redirect( home_url( '/exhibitions/' ), 301 )
    and exit;
*/

    is_tax( 'tool_type' )
    and wp_redirect( home_url( '/tools-and-equipment/' ), 301 )
    and exit;

/*
    is_singular( 'staff' )
	and wp_redirect( home_url( '/people/' ), 301 )
    and exit;

    is_singular( 'board' )
	and wp_redirect( home_url( '/people/' ), 301 )
    and exit;
*/



}



function add_query_vars($aVars) {
    $aVars[] = "cat_name";    // represents the name of the product category as shown in the URL
    $aVars[] = "event_date";
    return $aVars;
}

// hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');







function anagram_rewrite_rules($aRules) {
    // get array of terms

    // get the URI

	// if the slug from the uri is in the array of terms
		// wp_safe_redirect( site_url() . $array['key'] )

		//append query var to url

    $aNewRules = array(
    'learn/type/([^/]+)/?$' => 'index.php?pagename=learn&cat_name=$matches[1]',
	'learn/([^/]+)/([^/]+)/?$' => 'index.php?event=$matches[1]&event_date=$matches[2]',
   //'exhibitions/([^/]+)/?$' => 'index.php?pagename=exhibitions&cat_name=$matches[1]',
    //'exhibitions/([^/]+)/([^/]+)/?$' => 'index.php?pagename=exhibitions&cat_name=$matches[1]&event_search=$matches[2]',
    //'press-room/([^/]+)/?$' => 'index.php?pagename=press-room&cat_name=$matches[1]',
    //'press-room/([^/]+)/([^/]+)/?$' => 'index.php?pagename=press-room&cat_name=$matches[1]&event_search=$matches[2]',
    //'lecture-archives/([^/]+)/?$' => 'index.php?pagename=lecture-archives&cat_name=$matches[1]',
    //'lecture-archives/([^/]+)/([^/]+)/?$' => 'index.php?pagename=lecture-archives&cat_name=$matches[1]&event_search=$matches[2]',
    /// 'unsettled-landscapes/([^/]+)/?$' => 'index.php?artist=$matches[1]',

    );
    $aRules = $aNewRules + $aRules;
    return $aRules;
}

// hook add_rewrite_rules function into rewrite_rules_array
add_filter('rewrite_rules_array', 'anagram_rewrite_rules');




add_filter( 'posts_where' , 'posts_where', 10, 2);

function posts_where( $where, $query ) {
    global $wpdb,$wp_query;
    if ($query->query_vars['post_type'] == 'event') {
        //$where = str_replace("meta_key = 'recurring_dates_%", "meta_key LIKE 'recurring_dates_%", $where);
    }
    return $where;
}


//Sort post types
function custom_sort_pre_get_posts( $query ) {



    if ( isset( $query->query_vars[ 'post_type' ] ) && ($query->query_vars[ 'post_type' ] == 'event' ) && !isset($_GET['orderby']) ) {
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'DESC' );
        //$query->set( 'meta_key', 'recurring_dates_%_date' );
         // $query->set( 'meta_type', 'DATETIME' );
        /*$query->set( 'meta_query', array(
            array(
                'key' => 'start_date',
                //'value' => date( "m-d-Y" ),
              //  'compare' => '<='//,
                'type' => 'NUMBER'
            )
        ) );*/
    }


    if ( !is_admin() && isset( $query->query_vars[ 'post_type' ] ) && ($query->query_vars[ 'post_type' ] == 'program' ) && !isset($_GET['orderby']) ) {
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
          $query->set('posts_per_page', -1);


    }


    if ( !is_admin() && isset( $query->query_vars[ 'post_type' ] ) && ($query->query_vars[ 'post_type' ] == 'tool' ) && !isset($_GET['orderby']) ) {
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
          $query->set('posts_per_page', -1);


    }

   // is_tax('work_type')

}
add_filter('pre_get_posts' , 'custom_sort_pre_get_posts');



