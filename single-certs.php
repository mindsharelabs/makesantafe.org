<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

$allowed_shop_space = get_field('allowed_shop_space');
$p_makers = make_get_badged_members(get_the_id());

?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
        <div class="col-12 text-center">
          <?php
          if($image = get_field('badge_image')) :
            echo '<div class="badge-image-holder m-1 w-50 w-md-25 mx-auto">';
              echo wp_get_attachment_image($image);
            echo '</div>';
          endif;
          echo '<h1 class="page-title text-center text-primary">';
            the_title();
          echo '</h1>';
          ?>
        </div>
        <div class="col-12 col-md-8 offset-0 offset-md-2">
            <!-- section -->
            <section class="mt-4">
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
              <?php

               if (have_posts()): while (have_posts()) : the_post();
                  echo '<div class="col-12">';
                    the_content();
                  echo '</div>';

                  if($allowed_shop_space) :
                    echo '<div class="col-12 mt-5 pt-3">';
                      echo '<div class="row justify-content-center">';
                        echo '<div class="col-12 text-center">';
                          echo '<h2>With this badge you gain access to: </h3>';
                        echo '</div>';
                        foreach($allowed_shop_space as $term) :
                          echo make_output_shop_space($term);
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
            echo '<div class="row pt-4 pb-2 mt-4">';
              echo '<div class="col-12 my-4">';
                echo '<h3 class="text-center">Makers with this badge</h3>';
              echo '</div>';
            echo '</div>';
            echo '<div class="row justify-content-center">';
              foreach($p_makers as $key => $maker) :
                echo make_output_member_card($maker);
              endforeach;
              echo '</div>';
            echo '</div>';
          echo '</section>';
        endif;
      ?>

</main>
<?php

get_footer();
