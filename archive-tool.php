<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
      <div class="col-12">
        <?php

        echo '<div class="row">';
          echo '<div class="clear related_content">';
            echo '<div class="col-12 col-md-4">';
              echo '<h5>Filter by Shop</h5>';
              echo facetwp_display( 'facet', 'tool_type' );
            echo '</div>';
          echo '</div>';
        echo '</div>';



        echo '<div class="row">';
          echo '<header class="fancy-header d-flex">';
            echo '<div class="header-flex-item">';
              echo '<h1 class="page-title ">';
                echo __('Make Tools');
              echo '</h1>';
            echo '</div>';
            echo '<div class="header-flex-svg">';
              include get_template_directory() . '/inc/svgheader.svg';
            echo '</div>';
          echo '</header>';
        echo '</div>';
        echo '<section class="row mt-4 tools">';
          if(have_posts()):
              while (have_posts()) : the_post();
                get_template_part('loop-tools');
              endwhile;
              echo do_shortcode('[facetwp pager="true"]');
          endif;
        echo '</section>';
        ?>
      </div>
    </div>
  </main>
<?php
get_footer();
