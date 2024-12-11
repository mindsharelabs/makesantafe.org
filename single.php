<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

?>
<main role="main" aria-label="Content" class="container">
  
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
      echo '<div class="row">';
        echo '<div class="col-12 col-md-8 mx-auto">';
          yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
        echo '</div>';
      echo '</div>';
    }
    ?>
  <div class="row">

    <section class="col-12 col-md-8 mx-auto">
      <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <div class="col-12">
          <h1 class="single-title"><?php the_title(); ?></h1>
        </div>
        <!-- article -->
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
          <?php the_content(); ?>
        </article>
        <!-- /article -->

      <?php endwhile; endif; ?>
    </section>
  </div>
  <!-- /section -->
</main>
<?php

get_footer();
