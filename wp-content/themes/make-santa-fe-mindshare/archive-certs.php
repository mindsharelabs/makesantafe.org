<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
    <?php get_sidebar(); ?>
    <div class="col-12 col-md-8 has-sidebar">
      <?php
      echo '<div class="row">';
        echo '<header class="fancy-header d-flex">';
          echo '<div class="header-flex-item">';
            echo '<h1 class="page-title ">';
              the_archive_title();
            echo '</h1>';
          echo '</div>';
          echo '<div class="header-flex-svg">';
            include get_template_directory() . '/inc/svgheader.php';
          echo '</div>';
        echo '</header>';
        echo '<section class="row mt-4 tools">';
          if(have_posts()):
              while (have_posts()) : the_post();
                get_template_part('loop-badge');
              endwhile;
          endif;
        echo '</section>';
        ?>
        </div>
    </div>
    <?php get_template_part('pagination'); ?>
</main>
<?php
include 'layout/top-footer.php';
get_footer();
