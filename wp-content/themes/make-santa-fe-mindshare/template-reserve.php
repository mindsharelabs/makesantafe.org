<?php get_header();

include 'layout/page-header.php';
include 'layout/notice.php';

$tools = new WP_Query(array(
  'post_type' => 'tools',
  'posts_per_page' => -1,
))
?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
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

                  echo '<article id="post-' . get_the_ID() . '" ' . implode(', ', get_post_class()) . '">';
                    the_content();
                    edit_post_link();
                  echo '</article>';


                endwhile;
              endif; ?>
            </section>
        </div>

    </div>
            <!-- /section -->
</main>

<?php include 'layout/top-footer.php';
get_footer();