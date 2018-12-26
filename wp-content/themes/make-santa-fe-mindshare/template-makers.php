<?php
//Template Name: Makers Page
get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

// Get the results
$paid_makers = get_active_members_for_membership('Make Member');
$inkind_makers = get_active_members_for_membership('In Kind Membership');
$makers = array_merge($paid_makers, $inkind_makers);
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
      <?php get_sidebar(); ?>
        <div class="col-12 col-md-8 has-sidebar">
            <!-- section -->
            <section class="mt-4">
              <?php
              echo '<header class="fancy-header d-flex">';
                echo '<div class="header-flex-item">';
            			echo '<h1 class="page-title ">';
                    the_title();
                  echo '</h1>';
            		echo '</div>';
            		echo '<div class="header-flex-svg">';
            			include get_template_directory() . '/inc/svgheader.php';
            		echo '</div>';
              echo '</header>';

              if ($makers) :
                echo '<hr class="clear">';
                echo '<section class="row makers">';
                foreach ($makers as $maker) :
                  $user_id = $maker->user_id;
                  $public = get_field('display_profile_publicly', 'user_' . $user_id);
                  $name = get_field('display_name', 'user_' . $user_id );
                  if(($public == 'TRUE') && $name) :
                    if($user_id == $current_user_id){
                      $show_nag = 'dont_show';
                    }


                    $photo = get_field('photo', 'user_' . $user_id);

                    if(!$photo){
                      $image = get_template_directory_uri() . '/img/no-photo_' . rand(1,5) . '.png';
                    } else {
                      $image = aq_resize($photo['url'], 300, 300);
                    }



                    // mapi_var_dump($image);
                    $title = get_field('title', 'user_' . $user_id );
                    $link = get_permalink(get_page_by_path('maker-profile-page')) . '?maker_id=' . $user_id;

                    echo '<div class="col-6 col-md-3">';
                      echo '<div class="maker-photo p-2">';
                        echo '<a href="' . $link . '" title="' . $name . '">';
                          echo '<img src="' . $image . '" class="rounded-circle"/>';
                        echo '</a>';
                      echo '</div>';
                      echo '<div class="content">';
                        echo '<a href="' . $link . '" title="' . $name . '">';
                          echo '<h3 class="text-center">' . $name . '</h3>';
                        echo '</a>';
                        echo '<h4 class="text-center">' . $title . '</h4>';
                      echo '</div>';
                    echo '</div>';

                  endif;


                endforeach;
                echo '</section>';
              endif;

              ?>
            </section>
        </div>

    </div>
            <!-- /section -->
</main>

<?php include 'layout/top-footer.php';
get_footer();
