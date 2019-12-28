<?php
//Template Name: Makers Page
get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

// Get the results
$paid_makers = get_active_members_for_membership('Make Member');
$inkind_makers = get_active_members_for_membership('In Kind Membership');
$makers = array();
//Merging the arrays like this means we wont get duplicates if a user is both a Make Member and an In Kind Member
foreach ($paid_makers as $key => $paid_maker) :
  $id = $paid_maker->user_id;
  $makers[(int)$id] = $paid_maker;
endforeach;
foreach ($inkind_makers as $key => $inkind_maker) :
  $id = $inkind_maker->user_id;
  $makers[(int)$id] = $inkind_maker;
endforeach;

$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">

        <div class="col-12 col-md-10 offset-0 offset-md-1">
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
              echo '<hr class="clear">';
              if ($makers) :
                echo '<div class="row">';
                  echo '<div class="col">';
                    echo '<div class="alert alert-warning" role="alert">Are you a Make Santa Fe member? Want to see your profile here? Go to <a href="/my-account/make-profile/">your account</a> and enable it!</div>';
                  echo '</div>';
                echo '</div>';

                echo '<section class="row makers">';
                foreach ($makers as $maker) :
                  $user_id = $maker->user_id;
                  $public = get_field('display_profile_publicly', 'user_' . $user_id);
                  $name = get_field('display_name', 'user_' . $user_id );
                  if(!$name) :
                    $user_info = get_userdata( $user_id );
                    $name = $user_info->user_nicename;
                  endif;
                  if($public == 'TRUE') :
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

                    $link = get_author_posts_url($user_id);

                    echo '<div class="col-6 col-md-3 mb-3">';
                      echo '<div class="maker-photo p-2">';
                        echo '<a href="' . $link . '" title="' . $name . '">';
                          echo '<img src="' . $image . '" class="rounded-circle border"/>';
                        echo '</a>';
                      echo '</div>';
                      echo '<div class="content">';
                      if($name) :
                        echo '<a href="' . $link . '" title="' . $name . '">';
                          echo '<h3 class="text-center">' . $name . '</h3>';
                        echo '</a>';
                      endif;
                      if($title) :
                        echo '<h4 class="text-center">' . $title . '</h4>';
                      endif;
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
