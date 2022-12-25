<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
      <div class="col-12">
        <?php

        echo '<div class="row">';
          echo '<header class="fancy-header d-flex">';
            echo '<div class="header-flex-item">';
              echo '<h1 class="page-title ">';
                echo __('Make Tools');
              echo '</h1>';
            echo '</div>';
            echo '<div class="header-flex-svg">';
              include get_template_directory() . '/inc/svgheader.svg';
            echo '</div>';
          echo '</header>';
        echo '</div>';
        

            $terms = get_terms( array(
              'taxonomy' => 'tool_type',
              'hide_empty' => true,
            ) );
            if($terms) :
              echo '<section class="row mt-4 tools">';
              foreach($terms as $term) :
                echo make_output_shop_space($term);
              endforeach;
              echo '</section>';
            endif;

        
        ?>
      </div>
    </div>
  </main>
<?php
get_footer();
