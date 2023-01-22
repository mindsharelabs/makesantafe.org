 <?php get_header();
 include 'layout/page-header.php';
 include 'layout/notice.php';
  $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
  $maker_id = $author->ID;
  $public = get_field('display_profile_publicly', 'user_' . $maker_id);
 ?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <section class="maker-profile">
    <?php if($public) :
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
      <div class="col-12">
        <?php
        echo '<header class="fancy-header d-flex mt-5">';
          echo '<div class="header-flex-item">';
            echo '<h1 class="page-title ">';
              echo $name;
            echo '</h1>';
          echo '</div>';
          echo '<div class="header-flex-svg">';
            include get_template_directory() . '/inc/svgheader.svg';
          echo '</div>';
        echo '</header>';
        echo '<hr class="clear">';
        ?>
      </div>
    </div>
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
          echo '<div class="d-flex maker-badges flex-wrap">';
            foreach ($badges as $key => $badge) :
              if(is_array($maker_badges)) :

                $user_has = in_array($badge, $maker_badges);
                if($user_has){
                  $class = 'true';
                } else {
                  $class = 'false';
                }

                
              if($image = get_field('badge_image', $badge)) :
                echo '<div class="badge-image-holder ' . $class . ' m-1">';
                  echo '<a href="' . get_permalink($badge) . '" title="' . get_the_title($badge) . '">';
                    echo wp_get_attachment_image($image);
                    echo '<h3 class="text-center badge-title">' . get_the_title($badge) . '</h3>';
                  echo '</a>';
                echo '</div>';
              endif;
           
                
              endif;
            endforeach;
          echo '</div>';
        endif;



        ?>
      </div>
      <div class="col-12 col-md-8">
        <?php
        if($bio) :
          echo $bio;
        endif;
        ?>
        <hr>
        <?php
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
        ?>
      </div>
    </div>
  </section>
  <?php else : ?>
    <div class="row">
      <div class="col-12 mt-5 pt-5 mb-5 pb-5">
        <h3 class="text-center">This user's profile is private</h3>
      </div>
    </div>


  <?php endif; ?>
</main>
 <?php
 get_footer();
