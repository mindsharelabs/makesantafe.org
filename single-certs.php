<?php 
get_header();
?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
        
        <div class="col-12 col-lg-8 offset-0 offset-lg-2">
            <!-- section -->
            <section class="mt-4">
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
              <?php

               if (have_posts()): 
                while (have_posts()) : the_post();
                  echo '<div class="col-12"><h1 class="mt-2 display-4 text-center">' . get_the_title() . '</h1></div>';
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
