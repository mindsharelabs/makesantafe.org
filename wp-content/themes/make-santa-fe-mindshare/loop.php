<?php
if (has_post_thumbnail()) :
  $image = get_the_post_thumbnail_url();
  $image_url = aq_resize($image, 300, 300, true);
endif;
?>
<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
    <div class="loop-content">
        <div class="content">
            <!-- post image -->
            <?php if(isset($image_url)) : ?>
              <div class="post-image">
                <img src="<?php echo $image_url; ?>" alt="<?php the_title_attribute(); ?>">
              </div>
            <?php endif; ?>
            <!-- /post image -->

            <!-- post title -->
            <h3 class="section-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </h3>
            <!-- /post title -->

                <!-- post details -->
                <span class="posted-date">
                    <time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
		            </span>
                <span class="author-name"><?php echo get_the_author(); ?></span>
                <!-- /post details -->
            <?php mindwp_excerpt(); ?>

    <hr>

      <a href="<?php the_permalink(); ?>" class="btn btn-block btn-primary abs-button">Read More</a>
        </div>
    </div>
</article>
<!-- /article -->
