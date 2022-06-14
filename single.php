<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

?>
<main role="main" aria-label="Content" class="container">
  <div class="row">

    <section class="col-12 col-md-8 mx-auto">
      <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <div class="col-12">
          <h1 class="single-title"><?php the_title(); ?></h1>
        </div>
        <!-- article -->
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
          <?php
            if (has_post_thumbnail()) : // Check if thumbnail exists
              $image_id = get_post_thumbnail_id();
              $image = wp_get_attachment_image($image_id, 'medium_large');
            echo '<a itemprop="thumbnailUrl" class="mb-2 d-block" href="' . get_the_permalink() . '" title="' . the_title_attribute(array('echo' => false)) . '">';
              echo $image;
            echo '</a>';
          endif;
          the_content();
          ?>
        </article>
        <!-- /article -->

      <?php endwhile; endif; ?>
  </section>
  <!-- /section -->
</main>
<?php

get_footer();
