<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

if(has_post_thumbnail()){
  $thumb = get_the_post_thumbnail_url( get_the_id(), 'full');
  $image = aq_resize($thumb, 400, 400);
}
?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
      <?php get_sidebar(); ?>
      <div class="col-xs-12 col-md-8 has-sidebar">
            <!-- section -->
            <section>
              <!-- article -->
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
                <?php
                echo '<header class="fancy-header d-flex">';
                  echo '<div class="header-flex-item">';
              			echo '<h1 class="page-title ">';
                      the_title();
                    echo '</h1>';
              		echo '</div>';
              		echo '<div class="header-flex-svg">';
              			include get_template_directory() . '/inc/svgheader.php';
              		echo '</div>';
                echo '</header>';
                 ?>
                <h5><?php the_field('title'); ?></h5>
                <hr class="clear">
                <?php if (have_posts()): while (have_posts()) : the_post();

                if($image) : ?>
                  <div class="col-12 col-md-4">
                    <img class="rounded-circle" src="<?php echo $image; ?>" title="<?php the_title_attribute(); ?>"/>
                  </div>
                <?php endif; ?>
                <div class="col-12 col-md-8">
                  <?php the_content();?>
                </div>

                <?php endwhile; endif; ?>
                </article>
            </section>
        </div>

    </div>
            <!-- /section -->
</main>
<?php
include 'layout/top-footer.php';
get_footer();
