<?php
//Template Name: Full Width Page
if(is_account_page()) :
  acf_form_head();
endif;
get_header();

?>
    <main role="main" aria-label="Content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- section -->
                <section>
                    <?php
                    if(!get_field('show_header') && !get_field('hide_title') ) :
                      echo '<h1>' . get_the_title() . '</h1>';
                    endif;
                    if (have_posts()): while (have_posts()) : the_post(); ?>
                        <!-- article -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class('mt-3 d-flex flex-row justify-content-center'); ?>>
                            <?php the_content(); ?>
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
