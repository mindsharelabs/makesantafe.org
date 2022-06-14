<?php get_header();

include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
      <?php get_sidebar(); ?>
        <div class="col-12 col-md has-sidebar">
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
              if (have_posts()):
                while (have_posts()) : the_post();

                  echo '<article id="post-' . get_the_ID() . '" class="' . implode(' ', get_post_class('clear pt-2')) . '">';
                    the_content();
                    mapi_post_edit();
                  echo '</article>';
                endwhile;
              endif; ?>
            </section>
        </div>

    </div>
            <!-- /section -->
</main>

<?php 
get_footer();
