<?php get_header(); ?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
    <div class="col-12">
      <section class="row mt-4">

        <div class="col-12">
          <h1 class="mb-4 text-center display-3"><?php single_term_title(); ?></h1>
          <?php
          $term = get_queried_object();
          if ($term && !is_wp_error($term)) :
            echo '<p class="lead text-center my-3">' . $term->description . '</p>';
          endif;


          ?>
        </div>



        <div class="col-12 mt-3">
          <div class="row">
            <?php
            if(have_posts()) :
              echo '<section class="row tools">';
                echo '<table class="tools-table table table-hover table-responsive ">';
                  echo '<thead>';
                    echo '<tr>';
                      echo '<th></th>';
                      echo '<th>Tool</th>';
                      echo '<th>Description</th>';
                      echo '<th>Required Badge(s)</th>';
                      echo '<th>Functional Practice</th>';
                    echo '</tr>';
                  echo '</thead>';
                  echo '<tbody>';
                    while(have_posts()) : the_post();
                    $post_classes = get_post_class('col-4 col-md-3 col-lg-2');
                    $required_badges = get_field('required_badge');
                      
                      echo '<tr class="' . implode(' ', $post_classes) . '">';
                        echo '<td class="tool-image">';
                          if(has_post_thumbnail()) :
                            echo '<div class="tool-image-holder">';
                              echo get_the_post_thumbnail(get_the_ID(), 'very-small-square');
                            echo '</div>';
                          endif;
                        echo '</td>';
                        echo '<td class="tool-name align-top">';
                          echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                        echo '</td>';
                        echo '<td class="tool-description">';
                          echo get_field('short_description');
                        echo '</td>';
                        echo '<td class="tool-badge">';
                          if($required_badges) :
                            foreach($required_badges as $badge) :
                              echo '<div class="badge-holder">';
                                $badge_image = get_field('badge_image', $badge);
                                $badge_link = get_permalink($badge);
                                echo '<a href="' . $badge_link . '" class="badge-link">';
                                  echo wp_get_attachment_image($badge_image, 'very-small-square');
                                echo '</a>';
                              echo '</div>';
                            endforeach;
                          else :
                            echo '<span class="badge-link badge rounded-pill text-bg-info">No Badge Required</span>';
                          endif;
                        echo '</td>';
                        echo '<td class="tool-func-practice">';
                          $terms = get_the_terms(get_the_ID(), 'tool_type');
                          if($terms && !is_wp_error($terms)) :
                            foreach($terms as $term) :
                              echo '<span class="badge rounded-pill text-bg-primary">' . esc_html($term->name) . '</span>';
                            endforeach;
                          endif;
                        echo '</td>';
                      echo '</tr>';
                    endwhile;
                  echo '</tbody>';
                echo '</table>';
              echo '</section>';
            endif;
            ?>

          </div>
        </div>

        <?php get_template_part('pagination'); ?>
      </section>
    </div>
  </div>
</main>
<?php
get_footer();
