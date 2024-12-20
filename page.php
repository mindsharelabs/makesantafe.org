<?php
get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
      <?php get_sidebar(); ?>


      <?php
      echo '<article id="post-' . get_the_ID() . '" class="' . implode(' ', get_post_class('col-12 col-md-9 mt-2 has-sidebar')) . '">';
        echo '<header class="fancy-header d-flex">';
          echo '<div class="header-flex-item">';
      			echo '<h1 class="page-title ">';
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
