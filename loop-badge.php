<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
    <div class="row">
        <div class="col-4 col-md-2 pl-0">
          <!-- post image -->
          <?php
          if($image = get_field('badge_image')) :
            echo '<div class="badge-image-holder m-1">';
              echo wp_get_attachment_image($image);
            echo '</div>';
          endif;
          ?>
          <!-- /post image -->
        </div>
          <div class="col-8 col-md-10 my-auto">
            <!-- post title -->
            <h5 class="post-title">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_title(); ?>
              </a>
            </h5>
            <?php
            if($short_desc = get_field('short_description')) {
              echo $short_desc;
            };
            ?>
            <!-- /post title -->
          </div>
        </div>
    <hr/>
</article>
<!-- /article -->
