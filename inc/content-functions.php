<?php




add_filter( 'render_block', 'mapi_block_wrapper', 10, 2 );
function mapi_block_wrapper( $block_content, $block ) {
  // mapi_write_log($block_content);
  $noWrapper = array(
    'core/cover',
    // 'core/button',
    'acf/container',
  );

  if(in_array($block['blockName'], $noWrapper)) :
    // mapi_write_log($block['blockName']);
    $content = '</main>';
    $content .= '</div>';
    $content .= '</article>';
      $content .= $block_content;
    $content .= '<main role="main" aria-label="Content" class="container-fluid">';
    $content .= '<div class="row">';
    $content .= '<article class="' . implode(' ', get_post_class('col-12 col-md mt-2 has-sidebar')) . '">';
    return $content;
  endif;



  return $block_content;
}





function make_get_badged_members($certID) {
  $args = array (
      // 'role' => 'customer',
      'order' => 'ASC',
      'orderby' => 'display_name',
      'meta_query' => array(
        'relation' => 'AND',
          array(
            'key'     => 'certifications',
            'value'   => '"' . $certID . '"',
            'compare' => 'LIKE'
          ),
          array(
              'key'     => 'display_profile_publicly',
              'value'   => '1',
              'compare' => '='
          ),
      )
  );
  // Create the WP_User_Query object
  $wp_user_query = new WP_User_Query($args);
  return $wp_user_query->get_results();

}



function make_add_unique_id_for_modal( $postID  ) {
  if($postID == 'options' && is_admin()) :
    $screen = get_current_screen();
  	if ($screen->id == 'theme-settings_page_acf-options-member-notice') {
      update_option( 'make-member-modal-slug', sanitize_title(get_field('member_modal_title', 'options')));
  	}
  endif;
  return $postID;
}

// acf/update_value - filter for every field
add_filter('acf/save_post', 'make_add_unique_id_for_modal', 20);
