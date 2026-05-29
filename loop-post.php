<?php

$cats = wp_get_post_categories(get_the_id(), array('fields' => 'id=>name'));
$author_name = get_the_author();
$posted_date = get_the_date('F j, Y');
$posted_date_attr = get_the_date('c');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-6 col-lg-4 mb-3'); ?>>
  <div class="card h-100">
    <?php if(has_post_thumbnail()) : ?>
      <?php the_post_thumbnail( 'horz-thumbnail-lg', array('class' => 'card-img-top loop-card') ); ?>
    <?php endif; ?>
    <div class="card-body">
      <h3 class="section-title">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
      </h3>
      <div class="blog-card-meta" aria-label="Post details">
        <p class="blog-card-meta-line"><span class="blog-card-meta-label">Author</span><span class="blog-card-meta-value"><?php echo esc_html($author_name); ?></span></p>
        <p class="blog-card-meta-line"><span class="blog-card-meta-label">Posted</span><time class="blog-card-meta-value" datetime="<?php echo esc_attr($posted_date_attr); ?>"><?php echo esc_html($posted_date); ?></time></p>
      </div>
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
