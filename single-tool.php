<?php 

get_header();

$downloads = get_field('downloads');
?>
<main role="main" aria-label="Content">
  <div class="container-fluid">
    <div class="row">
      <?php get_sidebar(); ?>
      <div class="col-12 col-md-8">
        <!-- section -->
        <section class="mt-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('row mb-5'); ?>>
            <?php
            echo '<header class="fancy-header mb-4">';
              echo '<div class="header-flex-item">';
                echo '<h1 class="page-title">';
                  the_title();
                echo '</h1>';
              echo '</div>';
              echo '<div class="header-flex-svg">';
                include get_template_directory() . '/inc/svgheader.svg';
              echo '</div>';
            echo '</header>';



            if (have_posts()): 
              while (have_posts()) : the_post(); ?>
                <div class="col-12 col-md-4">
                  <?php 
                  if(has_post_thumbnail()) :
                    the_post_thumbnail('medium', array('class' => 'w-100'));
                  endif;


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
                        $image_url = wp_get_attachment_image( $image['id'], 'small-square');
                        echo '<div class="tool-image p-1">';
                          echo $image_url;
                        echo '</div>';
                      endforeach;
                      ?>
                    </div>
                  </div>
                <?php endif; 

                if(get_field('tool_video')) : ?>
                  <div class="col-12 mt-5">
                    <h4>Video</h4>
                    <div class="embed-container">
                      <?php the_field('tool_video');?>
                    </div>
                  </div>
                <?php endif;
              endwhile; 
            endif; ?>
          </article>
        </section>
      </div>

    </div>
  </div>

</main>
<div class="tool-access-calendar">
  <div class="container ">
    <div class="row">
      <?php
      if(get_field('badge_category')) :
        $slugs = wp_list_pluck(get_field('badge_category'), 'slug');
        echo '<div class="col-12 ">';
          echo '<h3>Get access to this tool:</h3>';
          echo do_shortcode('[tribe_events view="summary" filter-bar="false" tribe-bar="false" category="' . implode(', ', $slugs) . '"]');
        echo '</div>';
      endif;
      ?>
    </div>
  </div>
</div>
<?php
get_footer();
