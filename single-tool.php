<?php 

get_header();

$downloads = get_field('downloads');
?>
<main role="main" aria-label="Content">
  
        <!-- section -->
        <section class="mt-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('row mb-5'); ?>>
            <?php

            if (have_posts()): 
              while (have_posts()) : the_post();


                echo '<div class="col-12 col-md-4">';
                  do_action('single_tool_before_sidebar', $post);

                  
                  if(has_post_thumbnail()) :
                    the_post_thumbnail('medium', array('class' => 'w-100'));
                  endif;
                  if($gallery = get_field('tool_gallery')) :
                    echo '<div class="d-flex">';
                        foreach($gallery as $image) :
                          $image_url = wp_get_attachment_image( $image['id'], 'small-square');
                          echo '<div class="tool-image p-1">';
                            echo $image_url;
                          echo '</div>';
                        endforeach;
                    echo '</div>';
                    
                  endif; 

                  if($consumables = get_field('consumables')) :
                    echo '<h2 class="mt-5">Consumables</h2>';
                    echo '<div class="consumables list-group">';

                      foreach ($consumables as $key => $consumable) :
                        $name = $consumable['name'];
                        $purchase_link = $consumable['purchase_link'];
                        $notes = $consumable['notes'];
                        echo '<div class="list-group-item">';
                          echo '<a href="' . $purchase_link . '" target="_blank">' . $name . '</a>';
                          if($notes) :
                            echo '<div class="consumable-notes">' . $notes . '</div>';
                          endif;
                        echo '</div>';
                      endforeach;

                    echo '</div>';
                  endif;

                  if($required_badges = get_field('required_badge')) :
                    echo '<h2 class="mt-5">Required Badge' . (count($required_badges) > 1 ? '(s)' : '') . '</h2>';
                      foreach($required_badges as $badge) :
                        echo '<div class="badge-holder w-25">';
                          $badge_image = get_field('badge_image', $badge);
                          $badge_link = get_permalink($badge);
                          echo '<a href="' . $badge_link . '" class="badge-link text-center text-decoration-none">';
                            echo wp_get_attachment_image($badge_image, 'very-small-square',false, array('class' => 'w-100'));
                            echo '<h3 class="h5 badge-label">' . get_the_title($badge) . '</h3>';
                          echo '</a>';
                        echo '</div>';
                      endforeach;
                  endif;


                  do_action('single_tool_after_sidebar', $post);
                echo '</div>';

                echo '<div class="col-12 col-md-8">';
                  
                  echo '<p class="text-muted fw-bold">Last Updated: <i class="fas fa-calendar-alt me-2"></i>' . get_the_modified_date( 'F j, Y' ) . '</p>';
                  do_action('single_tool_before_content', $post);
                  
                  the_content();
                  
                  
                  if(get_field('tool_video')) :
                    echo '<h2 class="mt-5">How-to Video</h2>';
                    echo '<div class="embed-container">';
                      the_field('tool_video');
                    echo '</div>';
                  endif;

                  if($downloads) :
                    echo '<h2 class="mt-5">Downloads</h2>';
                    echo '<div class="downloads list-group">';

                      foreach ($downloads as $key => $download) :
                        echo '<a href="' . $download['file']['url'] . '" class="list-group-item list-group-item-action" target="_blank"><i class="fas fa-download me-2"></i><span class="label mb-2">' . $download['label'] . '</span></a>';
                      endforeach;

                    echo '</div>';
                  endif;



                  do_action('single_tool_after_content', $post);
                echo '</div>';


              endwhile; 
            endif; ?>
          </article>
        </section>


</main>
<?php
get_footer();
