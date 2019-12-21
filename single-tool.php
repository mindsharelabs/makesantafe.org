<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

if(has_post_thumbnail()){
  $thumb = get_the_post_thumbnail_url( get_the_id(), 'full');
  $image = aq_resize($thumb, 400, 400);
}
$downloads = get_field('downloads');
?>
<main role="main" aria-label="Content" class="container">
  <div class="row">
    <?php get_sidebar('tool'); ?>
    <div class="col-xs-12 col-md-8 has-sidebar">
      <!-- section -->
      <section class="mt-4">
        <article id="post-<?php the_ID(); ?>" <?php post_class('row mb-5'); ?>>
          <?php
          echo '<header class="fancy-header d-flex mb-4">';
          echo '<div class="header-flex-item">';
          echo '<h1 class="page-title">';
          the_title();
          echo '</h1>';
          echo '</div>';
          echo '<div class="header-flex-svg">';
          include get_template_directory() . '/inc/svgheader.php';
          echo '</div>';
          echo '</header>';

          if (have_posts()): while (have_posts()) : the_post(); ?>
          <div class="col-12 col-md-4">
            <?php if(isset($image)) : ?>
              <img class="rounded-circle" src="<?php echo $image; ?>" title="<?php the_title_attribute(); ?>"/>
            <?php endif; ?>
            <?php
            if($downloads) :
              echo '<h5 class="mt-3">Downloads</h5>';
              echo '<ul class="downloads border-top mt-2 pt-2">';

                foreach ($downloads as $key => $download) :
                  echo '<li><a href="' . $download['file']['url'] . '" class="link" target="_blank"><i class="fas fa-download mr-2"></i><span class="label mb-2">' . $download['label'] . '</span></a></li>';
                endforeach;

              echo '</ul>';
            endif;
            ?>
          </div>
          <div class="col-12 col-md-8">
            <?php the_content();?>
          </div>

          <?php if($gallery = get_field('tool_gallery')) : ?>
            <div class="col-12 mt-5 tool-gallery">
              <h4>Tool Gallery</h4>
              <div class="d-flex">
                <?php
                foreach($gallery as $image) :
                  $image_url = aq_resize($image['url'], 300, 300);
                  echo '<div class="tool-image p-1">';
                    echo '<img src="' . $image_url . '">';
                  echo '</div>';
                endforeach;
                ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if(get_field('tool_video')) : ?>
            <div class="col-12 mt-5">
              <h4>Video</h4>
              <div class="embed-container">
                <?php the_field('tool_video');?>
              </div>
            </div>
          <?php endif; ?>

        <?php endwhile; endif; ?>
      </article>
    </section>
  </div>

</div>

</main>
<?php
include 'layout/top-footer.php';
get_footer();
