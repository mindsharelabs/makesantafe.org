<?php get_header();?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
     
      <?php
      echo '<article id="post-' . get_the_ID() . '" class="' . implode(' ', get_post_class('col-12 col-md-10 offset-0 offset-md-1 mt-5')) . '">';
        echo '<header class="fancy-header">';
          echo '<div class="header-flex-item">';
            echo '<h1 class="page-title text-primary display-5">';
              the_title();
            echo '</h1>';
      		echo '</div>';
      		echo '<div class="header-flex-svg">';
      			include get_template_directory() . '/inc/svgheader.svg';
      		echo '</div>';
        echo '</header>';

        if (have_posts()):
          while (have_posts()) : the_post();
            the_content();
          endwhile;
        endif;
      echo '</article>';
      ?>
    </div>
</main>
<?php
get_footer();
