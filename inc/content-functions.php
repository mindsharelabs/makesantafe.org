<?php


// add_action( 'pre_get_posts', function ($query) {
//   if ( ! is_admin() && !$query->is_main_query() ) {
//
//     $terms = array( 'exclude-from-search', 'exclude-from-catalog' );
//
//     if($query->query['post_type'] == 'product') :
//       // mapi_write_log($query);
//       $query->set('tax_query', array(
//         array(
//           'taxonomy'  => 'product_visibility',
//           'field'     => 'slug',
//           'terms'     => $terms,
//           'operator'  => 'NOT IN'
//         )
//       ));
//     endif;
//
//   }
// });
//


function make_build_img_srcset($src_sizes) {
  $available_sizes = get_intermediate_image_sizes();
  if($available_sizes) :
    $srcset = '';
    $src = '';
    foreach ($available_sizes as $key => $size) :
      $srcset .= $src_sizes[$size] . ' ' . $src_sizes[$size . '-width'] . 'w' . ((next($available_sizes)) ? ', ' : '');
    endforeach;
  endif;
  return $srcset;
}


function make_get_image_html($acf_image_array, $width = 500, $height = '', $srcset = true, $class = '') {
  if($srcset){
     $srcset_attr = 'srcset="' . make_build_img_srcset($acf_image_array['sizes']) . '"';
  } else {
    $srcset_attr = '';
  }
  if($acf_image_array['subtype'] == 'gif') {
    $img_html = '<img class="' . $class . '" alt="' . $acf_image_array['title'] . '" title="' . $acf_image_array['title'] . '" src="' . $acf_image_array['url'] . '">';
  } else {
    $img_src = aq_resize($acf_image_array['url'], $width, $height);
    $img_html = '<img class="' . $class . '" alt="' . $acf_image_array['title'] . '" title="' . $acf_image_array['title'] . '" ' . $srcset_attr . ' src="' . $img_src . '">';
  }
  return $img_html;
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
