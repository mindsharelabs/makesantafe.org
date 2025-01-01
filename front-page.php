<?php get_header();
include 'layout/banner.php';

if(have_posts()) : while(have_posts()) :
  the_post();
  echo '<main class="container pt-0">';
      echo '<div class="row">';
        echo '<article id="post-' . get_the_ID() . '" class="' . implode(' ', get_post_class('col-12')) . '">';
          the_content();
        echo '</article>';
      echo '</div>';
  echo '</main>';
endwhile; endif;


get_footer();
