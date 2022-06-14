<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
    <div class="col-12">
      <section class="mt-4">
        <div class="row">
        <?php
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
          ?>
          <div class="col-12">
            <div class="row">
              <?php
              while (have_posts()) : the_post();
                get_template_part('loop');
              endwhile; ?>

            </div>
          </div>
        </div>
        <?php get_template_part('pagination'); ?>
      </section>
    </div>
  </div>
</main>
<?php
get_footer();
