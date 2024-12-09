<?php

$cats = wp_get_post_categories(get_the_id(), array('fields' => 'id=>name'));
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-6 col-lg-4 mb-3'); ?>>
  <div class="card h-100">
    <div class="card-body">
      <span class="posted-date mb-2">
        <small class="text-muted">
          <time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time>
        </small>
		  </span>
      <h3 class="section-title">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
      </h3>
      <?php
      if(count($cats) > 0) :
        echo '<div class="categories mb-2 w-100">';
        foreach ($cats as $key => $cat) :
          echo '<a href="' . get_term_link($key, 'category') . '" class="small text-muted pr-2" title="' . $cat . '">' . $cat . '</a>';
          if(next($cats)) :
            echo ' | ';
          endif;
        endforeach;
        echo '</div>';
      endif;

      the_excerpt();

       ?>


    </div>
    <a href="<?php the_permalink(); ?>" class="btn btn-block btn-default m-2">Read More <i class="far fa-long-arrow-right"></i></a>
  </div>
</article>
