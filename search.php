<?php get_header();?>
<main role="main" aria-label="Content" class="container">
  <div class="row">
    <div class="col-12">
      <section class="container blog">
        <div class="row">
          <div class="col-12 col-md-8 offset-0 offset-md-2">
            <h2 class="section-title">
              <?php echo sprintf(__('%s Search Results for ', 'mindblank'), $wp_query->found_posts);
              echo get_search_query(); ?>
            </h2>
            <div class="row">
              <?php
              if (have_posts()):

                while (have_posts()) : the_post();


                ?>
                <!-- article -->
                <article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
                  <div class="row">
                    <div class="col-4 col-md-2 pl-0">
                      <!-- post image -->
                      <?php if(has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                          <?php the_post_thumbnail( 'small-square', array('class' => 'rounded-circle') ); ?>
                        </a>
                      <?php endif; ?>
                      <!-- /post image -->
                    </div>
                    <div class="col-8 col-md-10">
                      <!-- post title -->
                      <h5 class="post-title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                          <?php the_title(); ?>
                        </a>
                      </h5>
                      <?php
                      $short_desc = get_field('short_description');
                      if($short_desc) {
                        echo $short_desc;
                      } else {
                        the_excerpt();
                      };
                      ?>
                      <!-- /post title -->
                    </div>
                  </div>
                  <hr/>
                </article>
                <!-- /article -->
                <?php
              endwhile;
              else :
                echo '<h3 align="center">You didn\'t find anything.</h3>';

              endif; ?>

            </div>
          </div>
        </div>
        <?php get_template_part('pagination'); ?>
      </section>
    </div>
  </div>
  <!-- /section -->
</main>


<?php

get_footer();
