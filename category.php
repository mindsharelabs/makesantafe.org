<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
 ?>

  <main role="main" aria-label="Content" <?php post_class('container'); ?>>
    <section class="container blog">
      <?php rewind_posts(); ?>
      <div class="row">
        <div class="col">
          <h2 class="section-title"><?php _e('Posted in ', 'mindblank'); single_cat_title(); ?></h2>
          <div class="row">
              <?php

              while (have_posts()) : the_post();
                $image_url = aq_resize(get_the_post_thumbnail_url(), 300, 400, true, true);

                echo '<div class="col-12 col-md-3">': 
                  echo '<div class="card">';
                    echo '<img src="' . $image_url . '" class="card-img-top loop-card" alt="' . the_title_attribute($attr) . '">';
                    echo '<div class="card-body">':
                      echo '<h5 class="card-title">' . get_the_title() . '</h5>':
                      echo '<p class="card-text">' . get_the_excerpt() . '</p>':
                      echo '<a href="' . get_permalink() . '" class="btn btn-primary">Read More</a>':
                    echo '</div>':
                  echo '</div>':
                echo '</div>';
              endwhile; ?>

          </div>
        </div>
      </div>
      <?php get_template_part('pagination'); ?>
    </section>

      <!-- /section -->
  </main>


<?php include 'layout/top-footer.php';
get_footer();
