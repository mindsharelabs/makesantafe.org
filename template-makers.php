<?php
//Template Name: Makers Page
get_header();


$makers = new WP_Query(array(
  'facetwp'        => true,
  'post_type' => 'upt_user',
  'posts_per_page' => -1,
  'orderby'        => [
    'title' => 'ASC'
  ],
  'meta_query' => array(
    // array(
    //   'key' => 'make_active_member',
    //   'value' => true,
    //   'compare' => '='
    // ),
    array(
      'key' => 'meta-display_profile_publicly',
      'value' => true,
      'compare' => '='
    ),
    // 'relation' => 'AND',
  ),
));
if($makers->have_posts()) :
  echo '<div class="container">';

    //page title
    echo '<h1 class="page-title display-2 my-3 text-center">Our Makers</h1>';

    echo '<div class="row filter-row my-3">';
      echo '<div class="col-12 d-flex flex-row">';
        echo '<div class="facet-cont me-3">';
          echo '<span class="label">Search Members:</span>';
          echo facetwp_display('facet', 'user_search');
        echo '</div>';

        echo '<div class="facet-cont me-3">';
          echo '<span class="label">Filter by Badge:</span>';
          echo facetwp_display('facet', 'user_badges');
        echo '</div>';

        echo '<div class="facet-cont me-3">';
          echo '<span class="label">&#8205;</span>';
          echo facetwp_display('facet', 'search_reset');
        echo '</div>';
        
      echo '</div>';
    echo '</div>';


    if(function_exists('make_output_member_card')) :
      echo '<section class="row makers gy-3 facetwp-template">';
      while($makers->have_posts()) : $makers->the_post();
        echo make_output_member_card(UPT()->get_user_id(), $echo = false);
      endwhile;
      echo '</section>';
    endif;



    // echo '<div class="row">';
    //   echo '<div class="col-12 col-md-6 offset-0 offset-md-3">';
    //     echo facetwp_display('facet','member_pager');
    //   echo '</div>';
    // echo '</div>';

  echo '</div>';
endif;






get_footer();
