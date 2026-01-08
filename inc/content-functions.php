<?php

add_action('mindevents_archive_loop_start', function() {
  $event_cats = get_terms(array(
    'taxonomy' => 'event_category',
    'hide_empty' => true,
    'parent' => 0,
    'orderby' => 'name',
    'order' => 'ASC',
  ));
  echo '<div class="container-fluid">';
    echo '<div class="row my-4">';
      echo '<div class="col-12 d-flex flex-wrap justify-content-center">';
        echo '<div class="my-3">';
          echo '<a href="' . get_post_type_archive_link( 'events' ) . '" class="btn me-1 mb-1 btn-sm btn-info">All Events</a>';
          foreach($event_cats as $cat):
            $cat_link = get_term_link($cat);
            $cat_name = $cat->name;
            $cat_color = get_field('event_color', $cat);
            $text_color = makeGgetContrastColor($cat_color);
    
            echo '<a href="' . $cat_link . '" class="btn me-1 mb-1 btn-sm btn-info" style="color:' . $text_color . ';background-color:' . $cat_color . ';border:none;">' . $cat_name . '</a>';

          endforeach;
        echo '</div>';
      echo '</div>';
    echo '</div>';
  echo '</div>';
});

function makeGgetContrastColor($hexcolor) {
  $r = hexdec(substr($hexcolor, 1, 2));
  $g = hexdec(substr($hexcolor, 3, 2));
  $b = hexdec(substr($hexcolor, 5, 2));
  $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
  return ($yiq >= 150) ? '#333' : '#fff';
}

add_filter( 'upt_sync_skip_user', function( $bool, $user_id ) {
  $public_display = get_field('display_profile_publicly', 'user_' . $user_id);
  $active_members = make_get_active_members_array( $user_id);
  if(!in_array($user_id, $active_members) || !$public_display) :
    return true;
  endif;
  return $bool;
}, 10, 2 );



//This adds meta information about the user when FacetWP syncs users to CPT
add_action( 'upt_sync_post', function( $post_id, $user_id ) {
  $active_members = make_get_active_members_array( $user_id);
  if(in_array($user_id, $active_members)) :
    add_post_meta( $post_id, 'make_active_member', true);
    add_user_meta( $user_id, 'make_active_member', true);
  endif;


}, 10, 2 );


//pre get psots make all "tool" post type items display
add_action( 'pre_get_posts', function( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive('tool') ) :
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set( 'posts_per_page', -1 );
  endif;
} );


//This adds meta information about the user when FacetWP syncs users to CPT
//Prevent single upt_user posts from being visible
add_filter( 'upt_post_type_args', function( $args ) {
  $args['show_in_menu'] = false;

  return $args;
});


add_filter( 'facetwp_facet_dropdown_show_counts', function( $return, $params ) {
  if ( 'user_badges' == $params['facet']['name'] ) {
    $return = false;
  }
  return $return;
}, 10, 2 );


//Index serialized data for UPT_users 
add_filter( 'facetwp_index_row', function ( $params, $class ) { 
  if ( 'user_badges' == $params['facet_name'] ) :
    $values = (array) $params['facet_value'];
    foreach ( $values as $val ) :
      $params['facet_value'] = $val;
      $params['facet_display_value'] = get_the_title($val);
      if( $params['facet_value'] && $params['facet_display_value'] ) :
        $class->insert( $params );
      endif;
    endforeach;
    return false; // skip default indexing
  endif;// end if user_badges
  return $params;
}, 10, 2 );




add_filter( 'render_block', 'mapi_block_wrapper', 10, 2 );
function mapi_block_wrapper( $block_content, $block ) {
  $noWrapper = array(
    'core/cover',
    // 'core/button',
    'acf/container',
    'acf/make-image-slider'
  );

  if(in_array($block['blockName'], $noWrapper)) :
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
    $tool_names = array();
    while($posts->have_posts()) :
      $posts->the_post();
      $tool_names[] = array(
        'link' => get_the_permalink(),
        'title' => get_the_title(),
        'id' => get_the_id(),
        'thumb' => get_the_post_thumbnail( get_the_id(), 'small-square'),
      );
    endwhile;
  endif;

  $html = '<article id="post-' . get_the_ID() . '" class="tool col-12 col-md-4 mb-3">';
    $html .= '<div class="card h-100 d-flex flex-column">';
 
      
    
      $html .= '<div class="card-body">';
        $html .= '<h3 class="post-title text-center">';
          $html .= '<a href="' . get_term_link($term) . '" title="' . $term->name . '">';
            $html .= $term->name;
          $html .= '</a>';
        $html .= '</h3>';
        $html .= term_description($term);

        if(isset($tool_names)) :
          $html .= '<div class="d-flex flex-wrap tool-photos">';
          foreach($tool_names as $tool) :
            if($tool['thumb']) :
              $html .= '<div class="tool-photo">';
                $html .= '<a href="' . $tool['link'] . '" title="' . $tool['title'] . '">';
                  $html .= $tool['thumb'];
                $html .= '</a>';
                $html .= '<a href="' . $tool['link'] . '" title="' . $tool['title'] . '" class="tool-caption">' . $tool['title'] . '</a>';
              $html .= '</div>'; 
            endif;
            
          endforeach;
          $html .= '</div>';
        endif;

      $html .= '</div>';
    
    $html .= '</div>';
  $html .= '</article>';
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


function make_output_tool_card($tool, $echo = false) {
  $html = '';


  $html .= '<div class="col-6 col-md-3 col-lg-2 mb-3">';
    $html .= '<div class="card h-100">';
      if(has_post_thumbnail( $tool )) :
        $html .= '<div class="image-header">';
          $html .= '<a href="' . get_the_permalink($tool) . '" title="' . get_the_title($tool) . '">';
            $html .= get_the_post_thumbnail($tool, 'horz-thumbnail', array('class' => 'card-img-top'));
          $html .= '</a>';
        $html .= '</div>';
      endif;
      $html .= '<div class="card-body">';
        $html .= '<h3 class="post-title text-center">';
          $html .= '<a href="' . get_the_permalink($tool) . '" title="' . get_the_title($tool) . '">';
            $html .= get_the_title($tool);
          $html .= '</a>';
        $html .= '</h3>';
        $html .= '<div class="tool-description">';
          $html .= get_the_excerpt($tool);
        $html .= '</div>';
      $html .= '</div>';
    $html .= '</div>';

  $html .= '</div>';

  if($echo) :
    echo $html;
  else :
    return $html;
  endif;  
}





/**
 * Register meta box(es).
 */
function makesf_register_meta_boxes() {
	add_meta_box( 'meta-box-id', 'Post Meta', 'makesf_meta_display_callback', 'upt_user' );
}
add_action( 'add_meta_boxes', 'makesf_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function makesf_meta_display_callback( $post ) {
	echo '<div class="box">' . mapi_var_dump(get_post_meta($post->ID)) . '</div>';
}
