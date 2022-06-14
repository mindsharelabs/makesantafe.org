<?php get_header();
include 'layout/banner.php';

echo '<section class="blog">';
  echo '<div class="container">';
    echo '<div class="row pt-5">';
      if(have_posts()) :
        while(have_posts()) : the_post();
          get_template_part( 'loop-' . $post->post_type );
        endwhile;
      else :
        '<h3 class="text-center">There\'s nothin\' here.</h3>';
      endif;

    echo '</div>';
    get_template_part('pagination');
  echo '</div>';
echo '</section>';


get_footer();
