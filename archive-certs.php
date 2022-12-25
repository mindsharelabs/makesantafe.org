<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class(); ?>>
  <div class="container">
    <div class="row">
      <?php get_sidebar(); ?>
      <div class="col-12 col-md has-sidebar">
        <?php
        echo '<div class="row">';
          echo '<header class="fancy-header d-flex">';
            echo '<div class="header-flex-item">';
              echo '<h1 class="page-title">Badges</h1>';
            echo '</div>';
            echo '<div class="header-flex-svg">';
              include get_template_directory() . '/inc/svgheader.svg';
            echo '</div>';
          echo '</header>';
          echo '<div class="row">';
            echo '<div class="col-12">';
              echo '<h4>All badge\'s cover tool set up, operation and adjustment. Safety and best practices specific to MAKE’s tools will also be covered.</h4>';
            echo '</div>';
          echo '</div>';
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
    </div>
    
</main>
<?php
get_footer();
