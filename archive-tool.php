<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
      <div class="col-12">
        <?php

        echo '<div class="row">';
          echo '<div class="clear related_content">';
            echo '<div class="col-12 col-md-4">';
              echo '<h5>Filter by Shop</h5>';
              echo facetwp_display( 'facet', 'tool_type' );
            echo '</div>';
          echo '</div>';
        echo '</div>';



        echo '<div class="row">';
          echo '<header class="fancy-header d-flex">';
            echo '<div class="header-flex-item">';
              echo '<h1 class="page-title ">';
                echo __('Make Tools');
              echo '</h1>';
            echo '</div>';
            echo '<div class="header-flex-svg">';
              include get_template_directory() . '/inc/svgheader.svg';
            echo '</div>';
          echo '</header>';
        echo '</div>';
        

            $terms = get_terms( array(
              'taxonomy' => 'tool_type',
              'hide_empty' => true,
            ) );
            if($terms) :
              echo '<section class="row mt-4 tools">';
              foreach($terms as $term) :
                $posts = new WP_Query(array(
                  'post_type' => 'tool',
                  'tax_query' => array(
                    array(
                      'taxonomy' => 'tool_type',
                      'field'    => 'slug',
                      'terms'    => $term->slug,
                    ),
                  ),
                ));
                if($posts->have_posts()) :
                  $images = array();
                  while($posts->have_posts()) :
                    $posts->the_post();
                    if(has_post_thumbnail()) :
                      $images[] = get_post_thumbnail_id(get_the_id());
                    endif;
                  endwhile;
                endif;
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-4 mb-3'); ?>>
                  <div class="card h-100 d-flex flex-column">
                    <?php 
                    if(isset($images)) :
                      echo '<div class="image-header">';
                      foreach($images as $image) :
                        echo wp_get_attachment_image( $image, 'thumbnail', true, array() );
                      endforeach;
                      echo '</div>';
                    endif;
                  
                    echo '<div class ="card-body">';
            
                      echo '<h3 class="post-title text-center">';
                        echo '<a href="' . get_term_link($term) . '" title="' . $term->name . '">';
                          echo $term->name;
                        echo '</a>';
                      echo '</h3>';
                      echo term_description($term);
        
                    echo '</div>';
                    ?>
                  </div>

              </article>
              <?php
              endforeach;
              echo '</section>';
            endif;

        
        ?>
      </div>
    </div>
  </main>
<?php
get_footer();
