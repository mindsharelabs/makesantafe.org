<?php get_header();
if(have_posts()) :

?>
    <main role="main" aria-label="Content" <?php post_class('container'); ?>>
      <?php while(have_posts()) : the_post(); ?>
        <div class="row">
            <div class="col-md-10 offset-md-1 col-12">
                <div class="row">
                    <div class="col-12">
                        <h1>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 offset-md-1 col-12">
                <!-- section -->
                <section>
                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php the_content(); ?>
                    </article>
                    <!-- /article -->
                </section>
            </div>
            <?php get_sidebar(); ?>
        </div>

        <!-- /section -->
        <?php endwhile; ?>
    </main>

<?php

include 'layout/top-footer.php';
 endif;
get_footer();
