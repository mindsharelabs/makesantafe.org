<?php 
get_header();
  $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
  $maker_id = $author->ID;
  $public = get_field('display_profile_publicly', 'user_' . $maker_id);

  $args = array(
    'author'        =>  $author->ID,
    'orderby'       =>  'post_date',
    'order'         =>  'DESC',
    'posts_per_page' => 8
  );
  $maker_posts = get_posts( $args );


 ?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <section class="maker-profile">
    
    
    
    
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
          echo '<div class="row gy-3 mb-4">';
            foreach ($gallery as $key => $image) :
              $image_elem = wp_get_attachment_image( $image['image']['ID'], 'small-square', false, array('class' => 'card-img-top'));
              if($image_elem):
                echo '<div class="col-12 col-md-4">';
                  echo '<div class="card">';
                    echo $image_elem;
                    if($image['caption']) :
                      echo '<div class="card-body small text-center p-1">' . $image['caption'] . '</div>';
                    endif;
                  echo '</div>';
                echo '</div>';
              endif;
            endforeach;
            echo '</div>';
        endif;
      echo '</div>';
      ?>
    

    <?php 
    if($maker_posts) :
      echo '<div class="col-12">';
        echo '<h2 class="text-center my-4 h3">Articles by ' . $name . '</h2>';
        echo '<div class="row gy-2">';
          foreach ($maker_posts as $key => $post) :
            $cats = wp_get_post_categories(get_the_id(), array('fields' => 'id=>name'));
            echo '<div class="col-12 col-md-6 col-lg-4">';
              echo '<div class="card mb-2">';
                echo '<div class="card-body">';
                  echo '<h3 class="card-title h4">' . $post->post_title . '</h3>';
                  echo '<p class="card-text">' . $post->post_excerpt . '</p>';

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


                  echo '<a href="' . get_permalink($post->ID) . '" class="btn btn-primary">Read More</a>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          endforeach;
        echo '</div>';

      echo '</div>';


    endif;


    ?>




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
