<?php get_header();?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
      <?php get_sidebar(); ?>
      <div class="col-12 col-md has-sidebar">
            <!-- section -->
            <section>
              <!-- article -->
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>

                <h5><?php the_field('title'); ?></h5>
                <hr class="clear">
                <?php if (have_posts()): while (have_posts()) : the_post();

                if(has_post_thumbnail()) :
                  echo '<div class="col-12 col-md-4">';
                    the_post_thumbnail( 'small-square', array('class' => 'rounded-circle') );
                  echo '</div>';
                endif; ?>
                <div class="col-12 col-md-8">
                  <?php the_content();?>
                </div>

                <?php endwhile; endif; ?>
                </article>
            </section>
        </div>

    </div>
            <!-- /section -->
</main>
<?php
get_footer();
