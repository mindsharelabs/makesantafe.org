<?php
//Template Name: Skinny Column
if(is_account_page()) :
  acf_form_head();
endif;
get_header();

?>
    <main role="main" aria-label="Content" class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <!-- section -->
                <section>
                    <?php
                    if(!get_field('show_header')):
                      echo '<h1>' . get_the_title() . '</h1>';
                    endif;
                    if (have_posts()): while (have_posts()) : the_post(); ?>
                        <!-- article -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class('mt-3'); ?>>

                            <?php the_content(); ?>

                            <?php comments_template('', true); // Remove if you don't want comments ?>

                            <br class="clear">

                            <?php mapi_post_edit(); ?>

                        </article>
                        <!-- /article -->
                    <?php endwhile; ?>
                    <?php endif; ?>

                </section>
            </div>

        </div>
        <!-- /section -->
    </main>

<?php

get_footer();
