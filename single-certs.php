<?php 
get_header();
?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
        <div class="col-12 text-center">
          <?php
          if($image = get_field('badge_image')) :
            echo '<div class="badge-image-holder m-1 w-50 w-md-25 mx-auto">';
              echo wp_get_attachment_image($image);
            echo '</div>';
          endif;
          echo '<h1 class="page-title text-center text-primary">';
            the_title();
          echo '</h1>';
          ?>
        </div>
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
