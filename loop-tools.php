<?php

$terms = get_the_terms(get_the_ID(), 'tool_type');
?>
<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-4 mb-3'); ?>>


    <div class="card h-100 d-flex flex-column">
      <?php if(has_post_thumbnail()) : ?>
      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php the_post_thumbnail( 'horz-thumbnail-lg', array('class' => 'card-img-top') ); ?>
      </a>
    <?php endif; ?>
      <div class ="card-body">
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
        echo '<h5 class="post-title">';
          echo '<a href="' . get_the_permalink() . '" title="' . the_title_attribute(array('echo' => false)) . '">';
            the_title();
          echo '</a>';
        echo '</h5>';
        ?>
        <?php the_field('short_description'); ?>
      </div>

    </div>

</article>
