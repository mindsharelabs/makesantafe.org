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




function make_output_shop_space($term, $echo = false) {
  $posts = new WP_Query(array(
    'post_type' => 'tool',
    'tax_query' => array(
      array(
        'taxonomy' => 'tool_type',
        'field'    => 'slug',
        'terms'    => $term->slug,
      ),
    ),
  ));
  if($posts->have_posts()) :
    $images = array();
    while($posts->have_posts()) :
      $posts->the_post();
      if(has_post_thumbnail()) :
        $images[] = array(
          'post_id' => get_the_id(),
          'image' => get_post_thumbnail_id(get_the_id())
        );
      endif;
    endwhile;
  endif;

  $html = '<article id="post-' . get_the_ID() . '" class="tool col-12 col-md-4 mb-3">';
    $html .= '<div class="card h-100 d-flex flex-column">';
 
      if(isset($images)) :
        $html .= '<div class="image-header d-flex flex-wrap">';
        foreach($images as $image) :
          $html .= '<a href="' . get_the_permalink($image['post_id']) . '" title="' . get_the_title($image['post_id']) . '">';
            $html .= wp_get_attachment_image( $image['image'], 'thumbnail', true, array('class' => 'tool-image') );
          $html .= '</a>';
        endforeach;
        $html .= '</div>';
      endif;
    
      $html .= '<div class ="card-body">';
        $html .= '<h3 class="post-title text-center">';
          $html .= '<a href="' . get_term_link($term) . '" title="' . $term->name . '">';
            $html .= $term->name;
          $html .= '</a>';
        $html .= '</h3>';
        $html .= term_description($term);

      $html .= '</div>';
    
    $html .= '</div>';
  $html .= '</article>';
  if($echo) :
    echo $html;
  else :
    return $html; 
  endif;
}



function make_output_member_card($maker, $echo = false) {
  $member = wc_memberships_is_user_active_member($maker->ID);
  $public = get_field('display_profile_publicly',  'user_' . $maker->ID);
  $html = '';
  if($public && $member):
    $thumb = get_field('photo', 'user_' . $maker->ID);
    $name = get_field('display_name', 'user_' . $maker->ID);
    $title = get_field('title', 'user_' . $maker->ID);
    $link = get_author_posts_url($maker->ID);
    if(!$thumb){
      $image_url = get_template_directory_uri() . '/img/nophoto.svg';
      $image = '<img src="' . $image_url . '" class="rounded-circle">';
    } else {
      $image = wp_get_attachment_image( $thumb['ID'], 'small-square', false, array('alt' => $name, 'class' => 'rounded-circle'));
    }
    $html .='<div class="col-6 col-md-3 text-center">';
      $html .='<div class="mb-4 text-center card make-member-card">';
        if($image) :
          $html .='<div class="image profile-image p-3 w-75 mx-auto">';
            $html .='<a href="' . $link . '">';
              $html .= $image;
            $html .='</a>';
          $html .='</div>';
        endif;
        $html .='<div class="content">';
          $html .='<a href="' . $link . '">';
            $html .='<h5 class="text-center">' . $name . '</h5>';
          $html .='</a>';
          $html .='<p class="text-center small mb-0">' . $title . '</p>';
        $html .='</div>';

        $badges = get_field('certifications', 'user_' . $maker->ID );
        $html .= '<div class="maker-badges d-flex justify-content-center flex-wrap">';
          foreach($badges as $badge) :
            if($image = get_field('badge_image', $badge)) :
              $html .= '<div class="badge-image-holder m-1">';
                $html .= wp_get_attachment_image($image);
              $html .= '</div>';
            endif;
          endforeach;
        $html .= '</div>';


      $html .='</div>';
    $html .='</div>';
  endif;

  if($echo) :
    echo $html;
  else :
    return $html; 
  endif;
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
