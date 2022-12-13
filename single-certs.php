<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

$tools = get_field('allowed_tools');
$p_makers = make_get_badged_members(get_the_id());

?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
      <?php get_sidebar('cert'); ?>
        <div class="col-12 col-md has-sidebar">
            <!-- section -->
            <section class="mt-4">
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
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

               if (have_posts()): while (have_posts()) : the_post();

                 $color = get_field('cert_color');
                 $icon = get_field('cert_icon');
                 $icon_back = get_field('cert_icon_back');

                 echo '<div class="cert-holder m-1">';
                   echo '<a href="' . get_permalink() . '" class="fa-stack fa-3x">';
                     echo '<i class="' . $icon_back . ' fa-stack-2x" style="color:' . $color . '"></i>';
                     echo '<i class="' . $icon . ' fa-stack-1x fa-inverse"></i>';
                   echo '</a>';
                   //echo '<span class="cert-name text-center d-block">' . get_the_title($cert) . '</span>';
                 echo '</div>';

                  echo '<div class="col-12 col-md-8">';
                    the_content();
                  echo '</div>';

                  if($tools) :
                    echo '<div class="col-12 mt-5 pt-3">';
                      echo '<div class="row">';
                        echo '<div class="col-12">';
                          echo '<h4>With this badge you gain access to: </h3>';
                        echo '</div>';
                        foreach($tools as $tool) :
                          $image = get_the_post_thumbnail( $tool->ID, 'small-square', array('class'=> 'card-img-top') );

                          echo '<div class="col-12 col-md-3 mb-3">';
                            echo '<div class="card mb-3 h-100">';
                              echo $image;
                              echo '<div class="card-body p-1 d-flex flex-column">';
                                echo '<h5 class="text-center">' . $tool->post_title . '</h5>';
                                //echo '<p>' . get_field('short_description', $tool->ID) . '</p>';
                                echo '<a href="' . get_permalink($tool->ID) . '" class="btn btn-primary btn-block btn-sm mt-auto">Read More</a>';
                              echo '</div>';
                            echo '</div>';
                          echo '</div>';
                        endforeach;
                      echo '</div>';
                    echo '</div>';
                  endif;
                endwhile;
              endif;
              ?>
              </article>
            </section>
        </div>

    </div>

      <?php

      if($p_makers) :
        echo '<section class="badged-makers">';
          echo '<div class="container">';
            echo '<div class="row pt-4 pb-2">';
              echo '<div class="col-12">';
                echo '<h3 class="text-center">Makers with this badge</h3>';
              echo '</div>';
            echo '</div>';
            echo '<div class="row">';
              foreach($p_makers as $key => $maker) :
                $member = wc_memberships_is_user_active_member($maker->ID);
                $public = get_field('display_profile_publicly',  'user_' . $maker->ID);
                if($public && $member):
                  $thumb = get_field('photo', 'user_' . $maker->ID);

                  $name = get_field('display_name', 'user_' . $maker->ID);
                  $title = get_field('title', 'user_' . $maker->ID);
                  $link = get_author_posts_url($maker->ID);
                  if(!$thumb){
                    $image = get_template_directory_uri() . '/img/no-photo_' . rand(1,5) . '.png';
                  } else {
                    $image = wp_get_attachment_image( $thumb['ID'], 'small-square', false, array('alt' => $name, 'class' => 'rounded-circle'));
                  }
                  echo '<div class="col-6 col-md-4">';
                    if($image) :
                      echo '<div class="image p-3">';
                        echo '<a href="' . $link . '">';
                          echo $image;
                        echo '</a>';
                      echo '</div>';
                    endif;
                    echo '<div class="content">';
                      echo '<a href="' . $link . '">';
                        echo '<h5 class="text-center">' . $name . '</h5>';
                      echo '</a>';
                      echo '<p class="text-center small">' . $title . '</p>';
                    echo '</div>';
                  echo '</div>';
                endif;
              endforeach;
              echo '</div>';
            echo '</div>';
          echo '</section>';
        endif;
      ?>

</main>
<?php

get_footer();
