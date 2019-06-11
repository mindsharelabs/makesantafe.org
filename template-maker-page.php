 <?php
//Template Name: Maker Profile Page
 get_header();
 include 'layout/page-header.php';
 include 'layout/notice.php';
$author = get_user_by( 'id', get_query_var( 'maker_id', false ) );

 ?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <section class="maker-profile">
    <?php if($author) :
      $maker_id = $author->ID;
      $public = get_field('display_profile_publicly', 'user_' . $maker_id);


      if($maker_id && $public):

      $current_user_id = get_current_user_id();
      $photo = get_field('photo', 'user_' . $maker_id);


      if(!$photo){
      $image = get_template_directory_uri() . '/img/no-photo_' . rand(1,5) . '.png';
      } else {
        $image = aq_resize($photo['url'], 400, 400);
      }


      $gallery = get_field('image_gallery', 'user_' . $maker_id );
      $bio = get_field('bio','user_' . $maker_id);
      $name = get_field('display_name', 'user_' . $maker_id );
      $title = get_field('title', 'user_' . $maker_id );
      $certifications = get_field('certifications', 'user_' . $maker_id );
      $all_certs_obj = get_posts(array(
        'post_type' => 'certs',
        'posts_per_page' => -1,
        'fields' => 'ID'
      ));
      $all_certs = array();
      foreach ($all_certs_obj as $key => $cert) {
        $all_certs[] = $cert->ID;
      }
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
              include get_template_directory() . '/inc/svgheader.php';
            echo '</div>';
          echo '</header>';
          echo '<hr class="clear">';
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4">
          <?php
          if($image):
            echo '<div class="maker-image">';
              echo '<img src="' . $image . '" title="' . $name . '" alt="' . $name . '">';
            echo '</div>';
          endif;


          if(count($all_certs) > 0):
            echo '<h4 class="sidebar-title mt-4">Certifications</h4>';
            echo '<div class="certifications">';
              foreach ($all_certs as $key => $cert) :
                // if(is_array($certifications)) :
                  $color = get_field('cert_color', $cert);
                  $icon = get_field('cert_icon', $cert);
                  $icon_back = get_field('cert_icon_back', $cert);
                  $user_has = in_array($cert, $certifications);
                  if($user_has){
                    $class = 'true';
                  } else {
                    $class = 'false';
                  }
                  echo '<div class="cert-holder m-1 ' . $class . '">';
                    echo '<a href="' . get_permalink($cert) . '" class="fa-stack fa-2x">';
                      echo '<i class="' . $icon_back . ' fa-stack-2x" style="color:' . $color . '"></i>';
                      echo '<i class="' . $icon . ' fa-stack-1x fa-inverse"></i>';
                    echo '</a>';
                    //echo '<span class="cert-name text-center d-block">' . get_the_title($cert) . '</span>';
                  echo '</div>';
                // endif;
              endforeach;
            echo '</div>';
          endif;
          if($current_user_id == $maker_id) :
            echo '<hr>';
            echo '<a href="/my-account/make-profile/" class="btn btn-default btn-block mt-4">Edit My Profile</a>';
          endif;


          ?>
        </div>
        <div class="col-12 col-md-8">
          <?php
          if($bio) :
            echo $bio;
          endif;
          if(count($gallery) > 0) :
            echo '<hr><div class="card-columns">';
            foreach ($gallery as $key => $image) :
              $image_src = aq_resize($image['image']['url'], 300);
              if($image_src):
                echo '<div class="card">';
                  echo '<img class="card-img-top" src="' . $image_src . '">';
                echo '</div>';
              endif;
            endforeach;
            echo '</div>';
          endif;
          ?>
        </div>
      </div>


    <?php else : ?>
      <div class="row">
        <div class="col-12 mt-5 pt-5 mb-5 pb-5">
          <h3 class="text-center">This makers profile is private.</h3>
        </div>
      </div>

    <?php endif; ?>
  </section>
  <?php else : ?>
    <div class="row">
      <div class="col-12 mt-5 pt-5 mb-5 pb-5">
        <h3 class="text-center">That maker does not exist.</h3>
      </div>
    </div>


  <?php endif; ?>
</main>
 <?php
 include 'layout/top-footer.php';
 get_footer();
