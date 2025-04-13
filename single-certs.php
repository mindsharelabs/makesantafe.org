<?php 
get_header();
?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
        
        <div class="col-12 col-md-8 offset-0 offset-md-2">
            <!-- section -->
            <section class="mt-4">
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
              <?php

               if (have_posts()): while (have_posts()) : the_post();
                  echo '<div class="col-12">';
                    the_content();
                  echo '</div>';
                endwhile;
              endif;
              ?>
              </article>
            </section>
        </div>

    </div>

</main>
<?php 
get_footer();
