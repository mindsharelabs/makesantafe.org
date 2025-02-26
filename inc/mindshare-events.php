<?php



add_action(MINDEVENTS_PREPEND . 'after_single_container', function() {
    // mapi_write_log();
    $related_events = new WP_Query(
      array(
        'post_type' => 'events',
        'posts_per_page' => 4,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'meta_value',
        'meta_key' => 'first_event_date',
        'meta_type' => 'DATETIME',
        'order'            => 'ASC',
        'meta_query' => array(
          'relation' => 'AND',
          array(
            'key' => 'last_event_date', // Check the start date field
            'value' => date('Y-m-d H:i:s'), // Set today's date (note the similar format)
            'compare' => '>=', // Return the ones greater than today's date
            'type' => 'DATETIME' // Let WordPress know we're working with date
          ),
        ),
        'tax_query' => array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'event_category',
            'field' => 'id',
            'terms' => wp_get_post_terms(get_the_ID(), 'event_category', array('fields' => 'ids')),
          ),
        ),
      ));
    if ( $related_events->have_posts() ) :
      echo '<div class="related-events row my-3">';
        echo '<h2>' . __('Related Events', 'mind-events') . '</h2>';
        while ( $related_events->have_posts() ) {
          $related_events->the_post();
          //output the event card
          echo '<div class="col-12 col-md-3">';
            echo '<div class="event-card card  d-flex justify-content-center h-100">';
                
                echo '<div class="event-card-image card-img-top">';
                    echo '<a href="' . get_the_permalink() . '">';
                        the_post_thumbnail('horz-thumbnail-lg', array('class' => 'img-fluid card-img-top'));
                    echo '</a>';
                echo '</div>';

                echo '<div class="event-card-content card-body">';
                    echo '<a href="' . get_the_permalink() . '">';
                        echo '<h3 class="h4">' . get_the_title() . '</h3>';
                    echo '</a>';
                    echo '<div class="event-datespan">';
                        $first_event = new DateTime(get_post_meta(get_the_ID(), 'first_event_date', true));
                        $startdate = $first_event->format('F j');
                        $last_event = new DateTime(get_post_meta(get_the_ID(), 'last_event_date', true));
                        $enddate = $last_event->format('F j');
                        echo 'Classes from <strong>' . $startdate . '</strong> to <strong>' . $enddate . '</strong>';
                    echo '</div>';
                    echo '<p class="post-excerpt">' . get_the_excerpt() . '</p>';
                echo '</div>';
            echo '</div>';
          echo '</div>';
          
        }
  
      echo '</div>';
    endif;
    wp_reset_postdata();
  }, 99);