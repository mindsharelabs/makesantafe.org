<?php
//Template Name: Blank Page
get_header('blank');

?>
    <main role="main" aria-label="Content" class="container">
        <div class="row">
            <div class="col-12">
                <!-- section -->
                <section>
                    <?php
                   
                    if (have_posts()): while (have_posts()) : the_post(); ?>
                        <!-- article -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class('mt-3'); ?>>

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

get_footer('blank');
