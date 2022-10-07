<?php

$terms = get_the_terms(get_the_ID(), 'tool_type');
?>
<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
    <div class="row">
        <div class="col-4 col-md-2 pl-0">
          <!-- post image -->
          <?php if(has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
              <?php the_post_thumbnail( 'small-square', array('class' => 'rounded-circle') ); ?>
            </a>
          <?php endif; ?>
          <!-- /post image -->
        </div>
          <div class="col-8 col-md-10">
            <?php
            if($terms):
              echo '<div class="terms-list">';
              foreach ($terms as $key => $term) :
                echo $term->name;
                if(next($terms)) :
                  echo ', ';
                endif;
              endforeach;
              echo '</div>';
            endif;
            ?>
            <!-- post title -->
            <h5 class="post-title">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_title(); ?>
              </a>
            </h5>
            <?php the_field('short_description'); ?>
            <!-- /post title -->
          </div>
        </div>
    <hr/>
</article>
<!-- /article -->
