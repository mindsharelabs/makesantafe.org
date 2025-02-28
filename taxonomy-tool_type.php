<?php get_header(); ?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
    <div class="col-12">
      <section class="mt-4">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <?php
              while (have_posts()) : the_post();
                get_template_part('loop-tools');
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
