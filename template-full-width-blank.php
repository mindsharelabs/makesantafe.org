<?php
//Template Name: Full Width Blank
get_header('blank');
 if (have_posts()): while (have_posts()) : the_post(); ?>
                <!-- article -->
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php the_content(); ?>

                    
                </article>
                <!-- /article -->
<?php endwhile;   endif; 

get_footer('blank');
