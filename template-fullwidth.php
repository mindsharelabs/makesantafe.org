<?php
//Template Name: Full Width Page
if(is_account_page()) :
  acf_form_head();
endif;
get_header();

?>
    <main role="main" aria-label="Content" class="container">
        <div class="row">
            <div class="col-12">
                <!-- section -->
                <section>
                    <?php
                    if(!get_field('show_header')):
                      echo '<h1>';
                        the_title();
                      echo '</h1>';
                    endif;
                    if (have_posts()): while (have_posts()) : the_post(); ?>
                        <!-- article -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class('mt-3'); ?>>

                            <?php the_content(); ?>
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
