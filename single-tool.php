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
<?php
get_footer();
