<?php
//Template Name: Makers Page
get_header();
include 'layout/page-header.php';
include 'layout/notice.php';




$makers = new WP_Query(array(
  "facetwp"        => true,
  'post_type' => 'upt_user',
  'posts_per_page' => 12,
  'orderby'        => [
    'title' => 'ASC'
  ],
  'meta_query' => array(
    array(
      'key' => 'make_active_member',
      'value' => true,
      'compare' => '='
    ),
    array(
      'key' => 'meta-display_profile_publicly',
      'value' => true,
      'compare' => '='
    ),
    'relation' => 'AND',
  ),
));
if($makers->have_posts()) :
  echo '<div class="container">';

    echo '<div class="row">';
      echo '<div class="col-12">';
        echo '<h2 class="text-center display-4 mb-4">Make Santa Fe Members</h2>';
      echo '</div>';
    echo '</div>';


    echo '<div class="row filter-row">';
      echo '<div class="col-12">';
        echo '<span class="label">Filter by Badge:</span>';
        echo facetwp_display('facet', 'user_badges');
      echo '</div>';
    echo '</div>';



    echo '<section class="row makers gy-3 facetwp-template">';
    while($makers->have_posts()) : $makers->the_post();
      mapi_write_log(get_post_meta(get_the_ID(), 'meta-certifications', true));

      echo make_output_member_card(UPT()->get_user_id(), $echo = false);
    endwhile;
    echo '</section>';



    echo '<div class="row">';
      echo '<div class="col-12 col-md-6 offset-0 offset-md-3">';
        echo facetwp_display('facet','member_pager');
      echo '</div>';
    echo '</div>';

  echo '</div>';
endif;






get_footer();
