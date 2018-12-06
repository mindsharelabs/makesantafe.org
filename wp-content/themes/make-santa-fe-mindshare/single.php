<?php get_header(); ?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
      <?php get_sidebar(); ?>
        <div class="col-xs-12 col-md-8 has-sidebar">
            <!-- section -->
            <section>
                <h1><?php the_title(); ?></h1>

                <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                  <!-- article -->
                  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                      <?php the_content();?>
                    </article>
                    <!-- /article -->

                <?php endwhile; endif; ?>

            </section>
        </div>

    </div>
            <!-- /section -->
</main>
<?php
include 'layout/top-footer.php';
get_footer();
