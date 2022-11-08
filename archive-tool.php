<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class('container-fluid'); ?>>
  <div class="row">
    <?php get_sidebar('tools'); ?>
      <div class="col-12 col-md has-sidebar">
        <?php
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
