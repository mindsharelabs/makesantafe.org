<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class(); ?>>
  <div class="container-fluid">
    
      <?php
      echo '<div class="row">';
        echo '<div class="col-12 mb-4">';
          echo '<header class="fancy-header d-flex">';
            echo '<div class="header-flex-item">';
              echo '<h1 class="page-title">Our Badges</h1>';
            echo '</div>';
            echo '<div class="header-flex-svg">';
              include get_template_directory() . '/inc/svgheader.svg';
            echo '</div>';
          echo '</header>';
        echo '</div>';
        echo '<div class="col-12 mb-3">';
          echo '<h4>All badge\'s cover tool set up, operation and adjustment. Safety and best practices specific to MAKE’s tools will also be covered.</h4>';
        echo '</div>';
        echo '<div class="col-12 d-flex flex-column">';
          echo (is_user_logged_in() ? '<div class="key-item"><div class="key-square"></div><span class="label">Badge not acquired</span></div>' : '<div class="key-item"><div class="key-square"></div><span class="label">Available Badge</span></div>');
          echo (is_user_logged_in() ? '<div class="key-item"><div class="key-square badged"></div><span class="label">Badge acquired</span></div>' : '');
          echo '<div class="key-item"><div class="key-square unavailable"></div><span class="label">Coming Soon</span></div>';
        echo '</div>';
      echo '</div>';

          
      
      echo '<section id="makeBadges"></section>';
      echo '<small class="text-muted text-center d-block w-100 text-primary fw-bold my-3">Click and drag to navigate badge tree.</small>';

         
      ?>
  <?php get_template_part('pagination'); ?>
  </div>
    
</main>
<?php
get_footer();
