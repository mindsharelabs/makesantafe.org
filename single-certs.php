<?php 
get_header();
?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
        
        <div class="col-12 col-md-8 offset-0 offset-md-2">
            <!-- section -->
            <section class="mt-4">
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
              <?php

               if (have_posts()): while (have_posts()) : the_post();
                  echo '<div class="col-12"><h1 class="mt-2 display-4 text-center">' . get_the_title() . '</h1></div>';
                  echo '<div class="col-12">';
                    the_content();
                  echo '</div>';


                  //reverse query tools and display them
                  $gained_tools = new WP_Query( array(
                    'post_type' => 'tool',
                    'meta_query' => array(
                      array(
                        'key' => 'required_badge',
                        'value' => '"' . get_the_ID() . '"',
                        'compare' => 'LIKE'
                      )
                    )
                  ) );

                  if ( $gained_tools->have_posts() ) {
                    echo '<h2 class="mt-5 mb-1">Gain access to these tools and more!</h2>';
                    echo '<div class="row mb-3 row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
                    while ( $gained_tools->have_posts() ) {
                      $gained_tools->the_post();
                      echo '<div class="col">';
                        echo '<div class="card h-100 shadow-sm">';
                          if ( has_post_thumbnail() ) {
                            echo '<a href="' . get_permalink() . '">';
                            echo get_the_post_thumbnail( get_the_ID(), 'medium', ['class' => 'card-img-top', 'alt' => get_the_title()] );
                            echo '</a>';
                          }
                          echo '<div class="card-body">';
                            echo '<h5 class="card-title mb-0"><a href="' . get_permalink() . '" class="stretched-link text-decoration-none text-dark">' . get_the_title() . '</a></h5>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    }
                    echo '</div>';
                  }
                  wp_reset_postdata();

                endwhile;
              endif;
              ?>
              </article>
            </section>
        </div>

    </div>

</main>
<?php 
get_footer();
