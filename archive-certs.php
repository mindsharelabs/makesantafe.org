<?php get_header();?>
<main role="main" aria-label="Content" <?php post_class(); ?>>
  <div class="container-fluid archive-certs">
    
      <?php
      echo '<div class="row">';
        echo '<div class="col-12 mb-4">';
          echo '<header class="fancy-header">';
            echo '<div class="header-flex-item">';
              echo '<h1 class="page-title">Our Badges</h1>';
            echo '</div>';
            echo '<div class="header-flex-svg">';
              include get_template_directory() . '/inc/svgheader.svg';
            echo '</div>';
          echo '</header>';
        echo '</div>';
        echo '<div class="col-12 mb-3">';
          echo '<h4>All badge\'s cover tool set up, operation and adjustment. Safety and best practices specific to MAKE\'s tools will also be covered. Anyone who wishes to use a studio is required to take one badge in that studio. More advanced badges cover more advanced topics but are not required for full use of the studio.</h4>';
        echo '</div>';
        echo '<div class="col-12 d-flex flex-column">';
          echo (is_user_logged_in() ? '<div class="key-item"><div class="key-square"></div><span class="label">Badge not acquired</span></div>' : '<div class="key-item"><div class="key-square"></div><span class="label">Available Badge</span></div>');
          echo (is_user_logged_in() ? '<div class="key-item"><div class="key-square badged"></div><span class="label">Badge acquired</span></div>' : '');
          echo '<div class="key-item"><div class="key-square unavailable"></div><span class="label">Coming Soon</span></div>';
        echo '</div>';
      echo '</div>';

          
      
      if(have_posts()) :
        echo '<section class="row badges gy-2">';
        while(have_posts()) : the_post();

          $has_badge = make_user_has_badge(get_the_id());
          $launched = get_field('launched');
          $class = '';
          if($has_badge) {
            $class = 'has-badge';
          } elseif(!$launched) {
            $class = 'unavailable';
          }


          echo '<div class="col-12 col-md-6 col-lg-4 col-xl-3 badge-card-cont">';
            echo '<div class="card badge-card h-100 d-flex flex-column justify-content-between ' . $class . '">';

              $badge_image = get_field('badge_image');
              if($badge_image) :
                $url = wp_get_attachment_image_url(get_field('badge_image'), 'small-square');
                echo '<a href="' . get_permalink() . '" class="badge-image">';
                  echo '<img src="' . $url . '" class="card-img-top" alt="' . get_the_title() . '">';
                echo '</a>';
              endif;


              echo '<div class="card-header">';
                echo '<h3 class="card-title h5 text-center">' . get_the_title() . '</h3>';
              echo '</div>';

              if($short_desc = get_field('short_description')) :
              echo '<div class="card-body">';
                echo '<div class="card-text">' . $short_desc . '</div>';
              echo '</div>';
              endif;

              echo '<a href="' . get_the_permalink() . '" class="badge-arrow-link"><i class="fas fa-arrow-right"></i></a>';

            echo '</div>';
          echo '</div>';



        endwhile;
        echo '</section>';
      endif;

      ?>
  </div>
    
</main>
<?php
get_footer();
