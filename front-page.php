<?php get_header();
include 'layout/banner.php';
include 'layout/notice.php';
// include 'layout/signup.php';

if(have_posts()) : while(have_posts()) :
  the_post();
  echo '<div class="container pt-0">';
      echo '<div class="row">';
        echo '<div class="col-12">';
          the_content();
        echo '</div>';
      echo '</div>';
  echo '</div>';
endwhile; endif;


get_footer();
