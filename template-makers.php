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
            			include get_template_directory() . '/inc/svgheader.svg';
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
                  $maker = get_user_by( 'id', $maker->user_id);
                  echo make_output_member_card($maker, $echo = false);
                endforeach;
                echo '</section>';
              endif;

              ?>
            </section>
        </div>

    </div>
            <!-- /section -->
</main>

<?php

get_footer();
