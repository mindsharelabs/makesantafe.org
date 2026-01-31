<?php 
get_header();
  $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
  $maker_id = $author->ID;
  $public = get_field('display_profile_publicly', 'user_' . $maker_id);
  $maker_posts = get_posts(array(
    'author'        =>  $author->ID,
    'orderby'       =>  'post_date',
    'order'         =>  'DESC',
    'posts_per_page' => 9
  ));


  $upcoming_classes = get_posts( array(
    'post_type' => 'sub_event',
    'meta_key' => 'instructorID',
    'meta_value' => $maker_id,
    'meta_compare' => '=',
    'posts_per_page' => 9,
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'value' => date('Y-m-d H:i:s'),
        'compare' => '>=',
        'type' => 'DATETIME'
      )
    ),
    'orderby' => 'meta_value',
    'order' => 'ASC'
  ) );




 ?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <section class="maker-profile mt-3">
    
    
    
    
    <?php
    if($public) :
      $user_obj = get_userdata( $maker_id );
      $current_user_id = get_current_user_id();
      $photo = get_field('photo', 'user_' . $maker_id);
      if($photo) :
        $image = wp_get_attachment_image( $photo['ID'], 'small-square');
      endif;

      $gallery = get_field('image_gallery', 'user_' . $maker_id );
      $bio = get_field('bio','user_' . $maker_id);
      $name = (get_field('display_name', 'user_' . $maker_id ) ? get_field('display_name', 'user_' . $maker_id ) : $user_obj->display_name);

      
      $title = get_field('title', 'user_' . $maker_id );
      
      ?>



    <div class="row">

      <?php
      //author name
      echo '<h1 class="page-title display-3 mt-4 col-12">' . esc_html($name) . '</h1>';
      //author title
      if($title) :
        echo '<h2 class="page-subtitle text-muted mb-4 col-12">' . esc_html($title) . '</h2>';
      endif;  

      ?>


      <div class="col-12 col-md-4">
        <?php

        if(isset($image)):
          echo '<div class="maker-image">';
            echo $image;
          echo '</div>';
        endif;

        if($current_user_id == $maker_id) :
          echo '<a href="/my-account/make-profile/" class="btn btn-default btn-block mt-4">Edit My Profile</a>';
        endif;

        $maker_badges = get_field('certifications', 'user_' . $maker_id );
        $all_badges = get_posts(array(
          'post_type' => 'certs',
          'posts_per_page' => -1,
          'fields' => 'ID'
        ));
        $badges = array();
        foreach ($all_badges as $key => $badge) :
          $badges[] = $badge->ID;
        endforeach;

        if($badges):  
          echo '<h2 class="sidebar-title mt-4">Badges</h4>';
          echo '<div class="d-flex maker-badges flex-wrap justify-content-between">';
            foreach ($badges as $key => $badge) :
              if(is_array($maker_badges)) :

                $user_has = in_array($badge, $maker_badges);
                if($user_has){
                  if($image = get_field('badge_image', $badge)) :
                    echo '<div class="badge-image-holder mb-3 true m-1">';
                      echo '<a href="' . get_permalink($badge) . '" title="' . get_the_title($badge) . '">';
                        echo wp_get_attachment_image($image);
                        echo '<h3 class="text-center badge-title">' . get_the_title($badge) . '</h3>';
                      echo '</a>';
                    echo '</div>';
                  endif;
                }

                
              
           
                
              endif;
            endforeach;
          echo '</div>';
        endif;



        ?>
      </div>

      
      <?php
      echo '<div class="col-12 col-md-8 mb-3">';
        if($bio) : 
          echo '<div class="lead">' . $bio . '</div>';
        endif; 
        if($gallery) :
          echo '<div class="row row-cols-1 row-cols-md-3 g-3 mb-4" data-masonry="{ \"percentPosition\": true }">';
            foreach ($gallery as $key => $image) :
              $image_elem = wp_get_attachment_image( $image['image']['ID'], 'large', false, array('class' => 'img-fluid w-100 rounded') );
              if($image_elem):
                echo '<div class="col">';
                  echo '<div class="card h-100 border-0 shadow-sm">';
                    echo $image_elem;
                    if($image['caption']) :
                      echo '<div class="card-body small text-center p-1">' . esc_html($image['caption']) . '</div>';
                    endif;
                  echo '</div>';
                echo '</div>';
              endif;
            endforeach;
          echo '</div>';
        endif;
      echo '</div>';

    if($upcoming_classes) :
      //card layout for upcoming classes
      echo '<div class="col-12">';
        echo '<h2 class="text-center my-4 h3">Upcoming Classes</h2>';
        echo '<div class="row gy-2">';
          foreach ($upcoming_classes as $key => $event) :
            $parentID = wp_get_post_parent_id($event);
            $parent_event = get_post($parentID);
            $event_date = get_post_meta($event->ID, 'event_start_time_stamp', true);
            $formatted_date = date('F j, Y g:i a', strtotime($event_date));
            echo '<div class="col-12 col-md-6 col-lg-4">';
              echo '<div class="card mb-2">';
                echo '<div class="card-body">';
                echo '<h3 class="card-title h4">' . get_the_title($parent_event) . '</h3>';
                echo '<p class="small mb-2">Date: ' . $formatted_date . '</p>';
                  echo '<p class="card-text text-muted small lh-sm">' . get_the_excerpt($parent_event) . '</p>';
                  echo '<a href="' . get_permalink($parent_event->ID) . '" class="btn btn-primary d-block">View Class</a>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          endforeach;
        echo '</div>';
      echo '</div>';
    endif;


    if($maker_posts) :
      echo '<div class="col-12">';
        echo '<h2 class="text-center my-4 h3">Articles by ' . $name . '</h2>';
        echo '<div class="row gy-2">';
          foreach ($maker_posts as $key => $post) :
            $cats = wp_get_post_categories($post->ID, array('fields' => 'id=>name'));
            $date = get_the_date('F j, Y', $post->ID);
            echo '<div class="col-12 col-md-6 col-lg-4">';
              echo '<div class="card mb-2 h-100">';
                echo '<div class="card-body">';
                  echo '<h3 class="card-title h4">' . $post->post_title . '</h3>';
                  echo '<p class="small text-muted mb-1">Article Published: ' . $date . '</p>';

                  if(count($cats) > 0) :
                    echo '<div class="categories mb-2 w-100">';
                    $cat_count = 0;
                    $cat_total = count($cats);
                    foreach ($cats as $cat_id => $cat_name) :
                      echo '<a href="' . get_term_link($cat_id, 'category') . '" class="small text-muted pr-2" title="' . $cat_name . '">' . $cat_name . '</a>';
                      $cat_count++;
                      if($cat_count < $cat_total) :
                        echo ' | ';
                      endif;
                    endforeach;
                    echo '</div>';
                  endif;
                  echo '<p class="card-text">' . get_the_excerpt($post) . '</p>';


                  echo '<a href="' . get_permalink($post->ID) . '" class="btn btn-primary">Read More</a>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          endforeach;
        echo '</div>';

      echo '</div>';


    endif;
    ?>
  </div>



  </section>

  <?php else : ?>
    <div class="row">
      <div class="col-12 my-5">
        <h1 class="page-title text-center my-5">Sorry, this profile is not public.</h1>
      </div>
    </div>
  <?php endif; ?>
</main>
 <?php
 get_footer();
