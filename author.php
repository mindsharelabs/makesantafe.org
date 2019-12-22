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

      $current_user_id = get_current_user_id();
      $photo = get_field('photo', 'user_' . $maker_id);
      $image = aq_resize($photo['url'], 400, 400);
      $gallery = get_field('image_gallery', 'user_' . $maker_id );
      $bio = get_field('bio','user_' . $maker_id);
      $name = get_field('display_name', 'user_' . $maker_id );
      $title = get_field('title', 'user_' . $maker_id );

      $certifications = get_field('certifications', 'user_' . $maker_id );

      $liability = get_user_meta( $maker_id, 'liability_entry_id', true );

      $form = new GFAPI();
      $search_criteria = array();
      $search_criteria['field_filters'][] = array( 'key' => 'created_by', 'value' => $maker_id );
      $entries = $form->get_entries( 27, $search_criteria);

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

        if($current_user_id == $maker_id) :
          echo '<a href="/my-account/make-profile/" class="btn btn-default btn-block mt-4">Edit My Profile</a>';
          if(!$entries) :
            echo '<h5 class="text-center mb-0 mt-4">Fill out your Waiver and Release of Liability</h5>';
            echo '<a href="/waiver-and-release-of-liability/" class="btn btn-default btn-block mt-1 mb-2">Waiver and Release of Liability</a>';
          endif;
        endif;

        if($all_certs):
          echo '<h4 class="sidebar-title mt-4">Certifications</h4>';
          echo '<div class="certifications">';
            foreach ($all_certs as $key => $cert) :
              if(is_array($certifications)) :
                $color = get_field('cert_color', $cert);
                $icon = get_field('cert_icon', $cert);
                $icon_back = get_field('cert_icon_back', $cert);
                $user_has = in_array($cert, $certifications);
                if($user_has){
                  $class = 'true';
                } else {
                  $class = 'false';
                }
                echo '<div class="cert-holder ' . $class . '" data-trigger="hover" data-toggle="popover" title="' . get_the_title($cert) . '" data-content="' .  get_field('short_description', $cert) . '">';
                  echo '<a href="' . get_permalink($cert) . '" class="fa-stack fa-2x">';
                    echo '<i class="' . $icon_back . ' fa-stack-2x" style="color:' . $color . '"></i>';
                    echo '<i class="' . $icon . ' fa-stack-1x fa-inverse"></i>';
                  echo '</a>';
                  //echo '<span class="cert-name text-center d-block">' . get_the_title($cert) . '</span>';
                echo '</div>';
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
          echo '<div class="card-columns">';
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
 include 'layout/top-footer.php';
 get_footer();