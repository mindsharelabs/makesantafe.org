<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" class="container">
  <section <?php post_class('blog team'); ?>>
    <div class="row">
      <?php get_sidebar(); ?>
      <div class="col-12 col-md-8">
        <div class="row">
          <div class="col-12">
            <h2 class="section-title fancy-page-title"><?php the_archive_title(); ?></h2>
          </div>
        </div>
        <div class="row">
          <?php
          while (have_posts()) : the_post();
            get_template_part('loop-team');
          endwhile;
          ?>
        </div>
      </div>


    </div>
    <div class="row">
      <div class="col-12">
        <?php get_template_part('pagination'); ?>
      </div>
    </div>
  </section>
</main>
<?php
include 'layout/top-footer.php';
get_footer();
