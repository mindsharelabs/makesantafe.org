<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
 ?>

  <main role="main" aria-label="Content" <?php post_class('container'); ?>>
    <section class="container blog">
      <div class="row">
        <div class="col-12">
          <h1 class="mt-3 mb-2 section-title"><?php _e('Posted in ', 'mindblank'); single_cat_title(); ?></h1>
        </div>
        <div class="col-12">
          <div class="row">
            <?php
            while (have_posts()) : the_post();

              echo '<div class="col-12 col-md-4 mb-3">';
                echo '<div class="card h-100">';
                  if(has_post_thumbnail()) :
                    the_post_thumbnail( $size = 'medium', array('class' => 'card-img-top loop-card') )
                  endif;
                  echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . get_the_title() . '</h5>';
                    echo '<p class="card-text">' . get_the_excerpt() . '</p>';
                    echo '<a href="' . get_permalink() . '" class="btn btn-primary">Read More</a>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
            endwhile; ?>
          </div>
        </div>
      </div>
      <?php //get_template_part('pagination'); ?>
    </section>
      <!-- /section -->
  </main>


<?php
get_footer();
