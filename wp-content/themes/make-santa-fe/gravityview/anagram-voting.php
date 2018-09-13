<?php


/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function anagram_gview_scripts()  {

	//wp_deregister_style('gravityview_default_style');
	//wp_deregister_style('gravityview_style_default_list');


	//wp_deregister_style('gravityview_style_default_table');
	//wp_deregister_style('gv-ratings-reviews-public');

	// get the theme directory style.css and link to it in the header
	//wp_enqueue_style( 'anagram-gview-style', get_stylesheet_directory_uri().'/gravityview/custom.css', array(), filemtime( get_stylesheet_directory().'/gravityview/custom.css') );

	// add theme scripts
	wp_enqueue_script('custom-gview-scripts', (get_template_directory_uri()."/gravityview/custom-gview.js"),array('jquery'),filemtime( get_stylesheet_directory().'/gravityview/custom-gview.js'),true);

}
add_action( 'wp_enqueue_scripts', 'anagram_gview_scripts' , 60); // Register this fxn and allow Wordpress to call it automatcally in the header

	/**
 * Filter gravity view voting title
 *
 * @since 1.0.0
 *
 */


/*
function anagram_redirect_login() {
			global $post;
			$user = wp_get_current_user();
			if ( !( $post->post_name=='login' || $post->post_name=='lost-password' || $post->post_name=='reset-password' ) && !is_allowed() ) {
					nocache_headers();
					wp_redirect(get_permalink(9596));
					exit();
			}
}
//Check users role for student area
function is_allowed() {
			global $current_user;
	$allowed = array('inactive_student','student','instructor','teachers_assistant','administrator','editor');
		$user_roles = $current_user->roles;

	if( array_intersect ( $user_roles , $allowed  ) ){
		return true;
	}else{
		return false;

	}
*/

/*

add_action('comment_post', 'ajaxify_comments',20, 2);
function ajaxify_comments($comment_ID, $comment_status){
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		//If AJAX Request Then
		switch($comment_status){
		case '0':
			//notify moderator of unapproved comment
			wp_notify_moderator($comment_ID);
		case '1': //Approved comment
		echo "success";
			$commentdata=&get_comment($comment_ID, ARRAY_A);
			$post=&get_post($commentdata['comment_post_ID']);
			wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
		break;
		default:
		echo "error";
		}
		exit;
	}
}
*/




/**
 * Get single entry pagination links
 * to use: call anagram_entry_pagintion();
 *
 */
function anagram_entry_pagintion() {

						global $gravityview_view;

						$criteria['paging'] = array(
									'offset' => 0,
									'page_size' => 200
						);
						$criteria['sorting'] = array(
									'key' => $gravityview_view->atts['sort_field'],
									'direction' => $gravityview_view->atts['sort_direction']
						);

						$entry_ids = wp_list_pluck( gravityview_get_entries( $gravityview_view->form_id , $criteria, $sorting ), 'id' );
						//$form['id'], $search_criteria, $sorting, $paging, $total_count

						$total_count = count($entry_ids);
						$current_entry = get_query_var( 'entry' );

						$position = array_search($current_entry, $entry_ids);

						$prev_pos = ! rgblank( $position ) && $position > 0 ? $position - 1 : false;
						$next_pos = ! rgblank( $position ) && $position < $total_count - 1 ? $position + 1 : false;

						$post_id = $gravityview_view->getPostId();
						$query_arg_name = GravityView_Post_Types::get_entry_var_name();

					$output = '<ul class="list-inline">';
						$output .= '<li class="gf_entry_count">';
						$output .= '<span>entry <strong>'. ($position + 1) .'</strong> of <strong>'. $total_count .'</strong></span>';
						$output .= '</li>';
						$output .= '<li class="gf_entry_prev gv_pagination_links">';
						//$output .= anagram_detail_pagination_link( $entry_ids[$prev_pos], 'Previous Entry', ($prev_pos !== false ? ' ' : ' gf_entry_disabled'), 'fa fa-arrow-circle-o-left' );
						$output .= '<a href="' . GravityView_API::entry_link( $entry_ids[$prev_pos] ) . '" class="' . ($prev_pos !== false ? ' ' : ' gf_entry_disabled') . '" title="Previous Entry"><i class="fa-lg fa fa-arrow-circle-o-left"></i></a></li>';
						$output .= '</li>';
						$output .= '<li class="gf_entry_next gv_pagination_links">';
						$output .= '<a href="' . GravityView_API::entry_link( $entry_ids[$next_pos] ) . '" class="' . ($next_pos !== false ? ' ' : ' gf_entry_disabled') . '" title="Next Entry"><i class="fa-lg fa fa-arrow-circle-o-right"></i></a></li>';
						$output .= '</li>';
					$output .= '</ul>';

				return $output;
	}




add_shortcode('has_voted', 'has_voted');
function has_voted($atts) {
   extract(shortcode_atts(array(
      'entry_id' => "",
   ), $atts));


$bridge_id = GravityView_Ratings_Reviews_Helper::get_post_bridge_id( $entry_id );



		$allowed_to_review = true;
		$user              = wp_get_current_user();
		if ( $user->exists() ) {
			if ( empty( $user->display_name ) ) {
				$user->display_name = $user->user_login;
			}

			//is_user_allowed_to_leave_review( $post_bridge, $review_author = '', $review_author_email = '', $reviewdata = array() )
			$allowed_to_review = GravityView_Ratings_Reviews_Helper::is_user_allowed_to_leave_review( $bridge_id, $user->display_name, $user->user_email );

			//return $allowed_to_review;
		}
		if ( ! $allowed_to_review ) :
			return '<span class="rated-message"><i class="fa fa-check-circle-o fa-fw" style="color:green"></i></span>';
		endif;

		return '';


}

	//Anagram / geet adding you voted to list
function anagram_has_voted($enterid){




		$bridge_id = GravityView_Ratings_Reviews_Helper::get_post_bridge_id( $enterid );

		$allowed_to_review = true;
		$user              = wp_get_current_user();
		if ( $user->exists() ) {
			if ( empty( $user->display_name ) ) {
				$user->display_name = $user->user_login;
			}

			$allowed_to_review = GravityView_Ratings_Reviews_Helper::is_user_allowed_to_leave_review( $bridge_id, $user->display_name, $user->user_email );
		}
		if ( ! $allowed_to_review ) :

			return '<span class="rated-message">You voted on this</span>';
		endif;

				return false;


}



add_filter( 'gv_ratings_reviews_vote_rating_text', 'my_gv_filter_no_rating', 10, 1 );
function my_gv_filter_no_rating( $original_rating_text ) {
		$original_rating_text['zero'] = "0";

		return $original_rating_text;
}

//Remove title field from contact form
add_filter( 'comment_form_field_gv_review_title', 'my_gv_field_filter', 10, 1 );
function my_gv_field_filter( $field ) {
/*
global $gravityview_view;
extract( $gravityview_view->field_data );
// field_id => merge_tag
$validation = array(
'18' => '{Custom Background:18}',
'26' => '{New YouTube Video Test:26}',
'28' => '{New Vimeo:28}'
);
foreach( $validation as $id => $merge ) {
if( false !== strpos( $content, $merge ) && empty( $entry[ (string)$id ] ) ) {
return '';
}
}
return $content;
*/

return '';
}




//Custom Slugs for entries
//add_filter( 'gravityview_custom_entry_slug', '__return_true' );

/**
 * Change the /entry/ URL piece to /ref/
 * @param  string $endpoint Previous endpoint, default: "entry"
 * @return string           Change the new endpoint to "name"
 */
//add_filter('gravityview_directory_endpoint', 'change_the_gravityview_directory_endpoint');
function change_the_gravityview_directory_endpoint( $endpoint ) {
    return 'ref';
}


/**
 * Translate GravityView text that doesn't already have a filter
 *
 * Thanks to WooCommerce for the jump start: https://support.woothemes.com/hc/en-us/articles/203105817
 *
 * @param string $translated Text as already translated
 * @param string $text Original text
 * @param string $domain Translated plugin textdomain (for GravityView, it's "gravityview")
 *
 * @return string
 */
function translate_gravityview_text( $translated, $text, $domain = '' ) {
	// Only translate GravityView text
	if( 'gravityview-ratings-reviews' !== $domain ) {
		return $translated;
	}
	// By default, return the original translation
	$return = $translated;
	// If the text matches any of the cases below, it will be replaced by your new text
	switch( $text ) {
		// Modify the example below to add another
	case 'Rate':
			$return = 'Vote';
			break;
	case 'Reviews of this entry':
			$return = 'Votes on this application';
			break;
	case 'One review of this entry':
			$return = 'One vote on this application';
			break;
	case '%1$s reviews of this entry':
			$return = '%1$s  votes on this application';
			break;
	case 'This entry has no reviews.':
			$return = 'This application has no votes.';
			break;
/*
	case '%1$s rating based on %2$s rating':
			$return = '%1$s votes based on %2$s vote';
			break;
	case '%1$s rating based on %2$s ratings':
			$return = '%1$s vote based on %2$s votes';
			break;
	case '%s rating':
			$return = '%s votes';
			break;
*/

	}
	return $return;
}
add_filter('gettext', 'translate_gravityview_text', 20, 3 );





/**
 * Filter gravity view voting
 *
 * @since 1.0.0
 *
 */

 add_filter( 'gv_ratings_reviews_review_form_settings', 'my_gv_comment_filter',  10, 1 );
/**
* Removes the custom content field's content in case a certain entry field is empty
*
* @param string $content Custom Content field content
* @return string
*/
function my_gv_comment_filter( $args ) {
$args = array(
			'fields'                => $fields,
			'comment_field'         => '<h4>' . _x( 'Comment', 'noun', 'gravityview-ratings-reviews' ) . '</h4> <textarea id="comment" class="form-control" name="comment" cols="45" rows="3" style=""aria-required="true"></textarea>',
			/** This filter is documented in wp-includes/link-template.php */
			//'must_log_in'           => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'gravityview-ratings-reviews' ), wp_login_url( $permalink ) ) . '</p>',
			'must_log_in'           => '',
			/** This filter is documented in wp-includes/link-template.php */
			//'logged_in_as'          => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'gravityview-ratings-reviews' ), get_edit_user_link(), $user_identity, wp_logout_url( $permalink ) ) . '</p>',
			'logged_in_as'          => '',

			'comment_notes_before'  => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'gravityview-ratings-reviews' ) . ( $req ? $required_text : '' ) . '</p>',
			'comment_notes_after'   => '<p class="help-block">You must pick at least 1 star to comment.</p>',
			'id_form'               => 'commentform',
			'id_submit'             => 'submit',
			'name_submit'           => 'submit',
			'title_reply'           => __( 'Vote on this application', 'gravityview-ratings-reviews' ),
			'title_reply_to'        => __( 'Reply to %s', 'gravityview-ratings-reviews' ),
			'cancel_reply_link'     => __( 'Cancel reply', 'gravityview-ratings-reviews' ),
			'label_submit'          => __( 'Cast Vote', 'gravityview-ratings-reviews' ),
			'format'                => 'xhtml',

			/** The message shown to users who try to add two reviews to the same entry. */
			'limited_to_one_review' => '<h4 class="limited-to-one-review">' . sprintf( __( 'You voted on this application.', 'gravityview-ratings-reviews' ) ) . '</h4>',
		);

return $args;
}
