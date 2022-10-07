<?php


?>
<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
    <div class="row">
        <div class="col-4 col-md-2 pl-0">
          <!-- post image -->
          <?php if(has_post_thumbnail( )) : ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
              <?php the_post_thumbnail( 'small-square', array('class' => 'rounded-circle') ); ?>
            </a>
          <?php endif; ?>
          <!-- /post image -->
        </div>
          <div class="col-8 col-md-10">
            <!-- post title -->
            <h5 class="post-title">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_title(); ?>
              </a>
            </h5>
            <?php
            $short_desc = get_field('short_description');
            if($short_desc) {
              echo $short_desc;
            };
            ?>
            <!-- /post title -->
          </div>
        </div>
    <hr/>
</article>
<!-- /article -->
